<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Components\DataTable\DataTableExporter;
use App\Core\Contracts\CanProcess;

class BaseExportProcess extends BaseProcess implements CanProcess
{
    public function validate()
    {

    }

    public function process()
    {
        $this->prepare();
        $response = (new DataTableExporter)
            ->setHeaderMap($this->headerMap)
            ->setRowData($this->rowData)
            ->setFilename($this->exportName())
            ->export();
        $this->setSuccessMessage('');
        $this->setSuccessRedirectTarget(storage_url($response));
    }

    public function prepare()
    {
        $headerMap = [];
        $printedColumn = [];

        $data = $this->exportModel();
        foreach ($this->exportStructure()->structure as $struct) {
            if ($struct->exportable) {
                $sf = str_replace('[]', '', $struct->field);
                $printedColumn[] = $sf;
                $headerMap[$sf] = $struct->name;
                $input_type = $struct->input_type ?? 'text';

                if (isset($this->request->datatable_filter[$sf])) {
                    $filterValue = $this->request->datatable_filter[$sf];
                    if (is_array($filterValue)) {
                        // sementara ini, array berarti input berupa input daterage
                        if (count($filterValue) == 2) {
                            $filterValue = array_values($filterValue);
                            if (!empty($filterValue[0])) {
                                $data = $data->where($struct->field, '>=', $filterValue[0]);
                            }
                            if (!empty($filterValue[1])) {
                                $data = $data->where($struct->field, '<=', $filterValue[1]);
                            }
                        } else {
                            // selain itu abaikan aja dulu
                        }
                    } else {
                        if ((is_numeric($filterValue) && strlen($filterValue) < 6) || in_array($input_type, ['select', 'radio', 'checkbox', 'number'])) {
                            $data = $data->where($struct->field, $filterValue);
                        } else {
                            $data = $data->where($struct->field, 'like', '%' . trim($filterValue) . '%');
                        }
                    }
                }
            }
        }

        // transform data
        if ($this->request->dummy) {
            $data = $data->limit(3)->get();
        } else {
            $data = $data->get();
        }

        $rowData = [];
        if (method_exists($this->exportStructure(), 'transformer')) {
            $rowData = $this->exportStructure()->transformer()->reform($data, 'export');
        } else if (method_exists($this->exportStructure(), 'rowFormat')) {
            $rowData = [];
            foreach ($data as $row) {
                $rowData[] = $this->exportStructure()->rowFormat($row, 'export');
            }
        }

        $this->headerMap = $headerMap;
        $this->printedColumn = $printedColumn;
        $this->rowData = $rowData;
    }

}
