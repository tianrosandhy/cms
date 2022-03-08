<?php
namespace App\Core\Exceptions;

use Exception;
use Illuminate\Validation\Validator;

class ProcessException extends Exception
{
    public $exception_message = null;
    
    public function __construct($request = null)
    {
        $this->code = 400;
        $this->message = "An error occured";
        if ($request instanceof Validator) {
            $this->exception_message = $request->errors()->toArray();
            $this->message = json_encode($this->exception_message);
        } else if (is_string($request)) {
            //force to single array
            $this->exception_message = [$request];
            $this->message = $request;
        } else {
            //force to array
            $this->exception_message = json_decode(json_encode($request), true);
        }
    }

    public function getExceptionMessage()
    {
        return $this->exception_message;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
}
