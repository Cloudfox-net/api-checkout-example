<?php

namespace App\Exceptions;

use Exception;

class CloudfoxException extends Exception
{
    private $errors;

    public function __construct($message,$code=0,$previous=null,$options=array('params')){

        parent::__construct($message, $code, $previous);

        $this->errors = $options;        
    }

    public function getErrors(){
        return $this->errors;
    }
}
