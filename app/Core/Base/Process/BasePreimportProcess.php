<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Excels\ArrayImporter;
use App\Core\Exceptions\ProcessException;
use Excel;
use Storage;
use Validator;

class BasePreimportProcess extends BaseProcess implements CanProcess
{
    public $err = [];
    public $warn = [];

    public function validate()
    {
        $validate = Validator::make($this->request->all(), [
            'import' => 'required',
        ]);
        if ($validate->fails()) {
            throw new ProcessException($validate);
        }
    }

    public function process()
    {
        $this->getRawExcelData($this->request->import);

        // start process the $this->rawData if not empty.
        // first need to translate the rawHeader to field name first
        $istructure = $this->importStructure();
        $headerMap = [];
        foreach ($istructure->structure as $struct) {
            if (!$struct->exportable) {
                continue;
            }

            $trimmedField = str_replace('[]', '', $struct->field);
            $headerMap[strtolower($struct->name)] = $trimmedField;
        }

        $collections = [];
        foreach ($this->rawData as $raw) {
            $single = [];
            foreach ($this->rawHeader as $headerID => $headerLabel) {
                $lowerHeaderLabel = strtolower($headerLabel);
                if (isset($headerMap[$lowerHeaderLabel])) {
                    $single[$headerMap[$lowerHeaderLabel]] = $raw[$headerID] ?? null;
                }
            }
            $collections[] = $single;
        }

        // store collection as temporary file
        $tempFilename = 'import-' . date('YmdHis');
        if (method_exists($this, 'importName')) {
            $tempFilename = $this->importName() . '-' . date('YmdHis');
        }

        $storeTempPath = 'temp-import/' . $tempFilename . '.json';
        Storage::put($storeTempPath, json_encode($collections));

        $rowValidator = null;
        if (method_exists($this, 'rowValidator')) {
            $rowValidator = $this->rowValidator($collections);
        }

        return [
            'rawHeader' => $this->rawHeader,
            'rawHeaderFlipped' => $this->rawHeaderFlipped,
            'rawData' => $this->rawData,
            'headerMap' => $headerMap,
            'collections' => $collections,
            'tempPath' => $storeTempPath,
            'rowValidator' => [
                'errors' => $this->err,
                'warnings' => $this->warn,
            ],
        ];
    }

    public function getRawExcelData($path)
    {
        // path can be compiled json, or raw string path
        $try_decode = json_decode($path, true);
        if (isset($try_decode['path'])) {
            $path = $try_decode['path'];
        }

        if (!Storage::exists($path)) {
            throw new ProcessException("Failed to get the imported data. Please make sure you import the right document");
        }

        $sheets = Excel::toArray(new ArrayImporter, Storage::path($path));
        $rows = $sheets[0] ?? [];
        $header = $rows[0] ?? [];
        $headerFlipped = [];
        foreach ($header as $idx => $hname) {
            $headerFlipped[strtolower($hname)] = $idx;
        }

        // unset header
        unset($rows[0]);
        $rawData = array_values($rows);
        if (empty($rows) || empty($header)) {
            throw new ProcessException("Failed to parse the imported data. Please make sure you import the right document");
        }
        if (empty($rawData)) {
            throw new ProcessException("No data in your imported document.");
        }

        $this->rawHeader = $header;
        $this->rawHeaderFlipped = $headerFlipped;
        $this->rawData = $rawData;
        return $this;
    }

    public function addError($err)
    {
        $this->err[] = $err;
    }

    public function addWarning($warn)
    {
        $this->warn[] = $warn;
    }
}
