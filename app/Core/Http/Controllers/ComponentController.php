<?php
namespace App\Core\Http\Controllers;

use App\Core\Base\Controllers\BaseController;
use App\Core\Exceptions\MediaException;
use DB;
use Language;
use Media;
use Storage;
use Validator;
use Exception;

class ComponentController extends BaseController
{

    public function switcherMaster()
    {
        $this->request->validate([
            'id' => 'required',
            'pk' => 'required',
            'table' => 'required',
            'field' => 'required',
        ]);

        try {
            $table = decrypt($this->request->table);
            $pk = decrypt($this->request->pk);
            $id = decrypt($this->request->id);
            $conn = decrypt($this->request->conn);
            $field = decrypt($this->request->field);
            $tb = DB::connection($conn)->table($table)->where($pk, $id)->update([
                $field => intval($this->request->value),
            ]);
            return response()->json([
                'type' => 'success',
            ]);
        } catch (Exception $e) {
            return abort(403);
        }

    }

    public function switchLang()
    {
        $available_lang = Language::available();
        if ($this->request->lang) {
            if (isset($available_lang[$this->request->lang])) {
                session(['lang' => $this->request->lang]);
            }
        }
        return redirect()->back();
    }
}
