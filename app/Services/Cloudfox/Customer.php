<?php namespace App\Services\Cloudfox;

class Customer{

    public $first_name;
    
    public $last_name;
    
    public $name;

    public $email;
    /**
     * tipo de documento cpf | cnpj     
     * @var string
     */
    public $document_type;

    public $document_number;

    public $telephone;

    public $address = [];
       
    
    public function __construct(){
        
    }
}