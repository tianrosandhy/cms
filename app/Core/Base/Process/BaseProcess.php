<?php
namespace App\Core\Base\Process;

use App\Core\Exceptions\ProcessException;
use App\Core\Shared\DynamicProperty;
use Log;
use Exception;
use DB;

class BaseProcess
{
    use DynamicProperty;

    public $type = 'http'; //default request type
    public $config = [];
    public $http_code = 200;
    public $response_type = 'success';
    public $data = null;

    public $error_redirect_target = null;
    public $success_redirect_target = null;
    public $error_message = null;
    public $success_message = "Success";

    public function __construct()
    {
        $this->request = request();
    }

    public function type($process_type = null)
    {
        $available_process_type = ['http', 'ajax', 'raw'];
        if (in_array(strtolower($process_type), $available_process_type)) {
            $this->type = strtolower($process_type);
        }
        return $this;
    }

    public function handle()
    {
        if (method_exists($this, 'validate')) {
            try {
                $this->validate();
            } catch (ProcessException | Exception $e) {
                Log::error("THROWN VALIDATION EXCEPTION IN " . get_class($this) . " : ", [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                ]);

                if (method_exists($e, 'getCode')) {
                    $this->setHttpCode($e->getCode());
                }
                if (method_exists($e, 'getExceptionMessage')) {
                    $this->setErrorMessage($e->getExceptionMessage());
                } else {
                    $this->setErrorMessage($e->getMessage());
                }

                if ($this->type == 'raw') {
                    // langsung throw aja exceptionnya
                    throw $e;
                }
                return $this->generateResponse();
            }
        }

        DB::beginTransaction();
        try {
            $this->data = $this->process();
            DB::commit();
        } catch (ProcessException $e) {
            DB::rollback();
            Log::error("THROWN PROCESS EXCEPTION IN " . get_class($this) . " : ", [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            if (method_exists($e, 'getCode')) {
                $this->setHttpCode($e->getCode());
            }
            $this->setErrorMessage($e->getMessage());

            if ($this->type == 'raw') {
                // langsung throw aja exceptionnya
                throw $e;
            }
            return $this->generateResponse();
        }

        return $this->generateResponse();
    }

    private function setHttpCode($http_code = 200)
    {
        if ($http_code != 200) {
            $this->response_type = 'error';
        } else {
            $this->response_type = 'success';
        }
        if ($http_code == 0) {
            $http_code = 500;
        }
        $this->http_code = $http_code;
    }

    // response management
    private function generateResponse()
    {
        if ($this->type == 'http') {
            return $this->generateHttpResponse();
        }
        if ($this->type == 'ajax') {
            return $this->generateAjaxResponse();
        }
        if ($this->type == 'raw') {
            return $this->data;
        }
    }

    private function generateHttpResponse()
    {
        if ($this->response_type == 'error') {
            return $this->getErrorRedirectTarget()->with(['error' => $this->getErrorMessage()])->withInput();
        } else {
            return $this->getSuccessRedirectTarget()->with(['success' => $this->getSuccessMessage()]);
        }
    }

    private function generateAjaxResponse()
    {
        return response()->json([
            'type' => $this->response_type,
            'message' => $this->response_type == 'success' ? $this->getSuccessMessage() : null,
            'data' => $this->data ?? null,
            'error' => $this->response_type == 'error' ? $this->getErrorMessage() : [],
            'redirect' => $this->success_redirect_target ?? null,
        ], $this->http_code);
    }

    // property getter and setter

    public function setErrorMessage($err)
    {
        $this->error_message = $err;
        return $this;
    }
    public function getErrorMessage()
    {
        return $this->error_message ?? ['Sorry, we cannot process your request.'];
    }

    public function setSuccessMessage($msg)
    {
        $this->success_message = $msg;
        return $this;
    }
    public function getSuccessMessage()
    {
        return $this->success_message ?? ['Your data has been saved.'];
    }

    public function setErrorRedirectTarget($target)
    {
        $this->error_redirect_target = $target;
        return $this;
    }
    public function getErrorRedirectTarget()
    {
        return isset($this->error_redirect_target) ? redirect($this->error_redirect_target) : redirect()->back();
    }

    public function setSuccessRedirectTarget($target)
    {
        $this->success_redirect_target = $target;
        return $this;
    }
    public function getSuccessRedirectTarget()
    {
        return isset($this->success_redirect_target) ? redirect($this->success_redirect_target) : redirect()->back();
    }

}
