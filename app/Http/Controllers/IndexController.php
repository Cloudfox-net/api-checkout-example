<?php

namespace App\Http\Controllers;

use App\Exceptions\CloudfoxException;
use App\Services\Cloudfox\CloudfoxApi;
use App\Services\Cloudfox\Address;
use App\Services\Cloudfox\CloudfoxPayment;
use App\Services\Cloudfox\Customer;
use App\Services\Cloudfox\Product;
use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //Token gerado no Sirius
    private $api_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxMSIsImp0aSI6Ijc1YTY1ZTRjOGRjNzZmOTM0ODkyMjRiN2Y1MDRjYjNhNjI3ZDkxNGY4ZTkyZTdkMTFhN2U4NjI0Zjk4N2YzMjY5NTczYWU3NjQ2MGE0ZDc1IiwiaWF0IjoxNjI2MjEwNDE0LjUwMzY5MywibmJmIjoxNjI2MjEwNDE0LjUwMzY5NiwiZXhwIjoyNTcyODk1MjE0LjQwMTIsInN1YiI6IjI2Iiwic2NvcGVzIjpbInNhbGUiXX0.aHNP3BKTzJQxG1iKP3v4TX2qlllSJfF3rGZmQsd3hm-sL2h7DdAK_6gilYbgqr6NhK6L9I7484ah2xIr17j2DtC5Jnhr_hhfXh9wIjLF0QMrMOCEWZHEtNPpYuRhLEP2XEJWmUmDTOo3iub1JfM6dls-qTeLIjlkRmbgwbtA0I_1Tma_H_8qgvvbS6WwlSrMMDcTFqJKW0lbN4nvGbcVcT7jIaPc7TEwLdxy3ZYvb7MFqCVtBdMDeGE7GBQJonpL_uyqwKQhaASsPwX8GNthLtbaj-Q-0HdaxLCuMkTEi_reewmvVFuGETGXk46JVv786RzfONVqFjGLJ6kYTUc1mk5PuzaXPFcvajs_RFQaCGGoY3l_YAg9bsvuKSLSQh6C7en8qjOf-_st_jFEDxdjSnON9XvTsmRwu3fLmnhgqidTyV0Bd-DeqR9xhcs8COEgJ2dEx8BAYZa50gAmx6HaFd1Prh5KVtVwXb9bwxzLa1-cW8SsKkjzc0_O7QFzEuiWPtt46UV19GXNxZBgdc7XYwPlF1hLUYbl5BfBvNurOaMY3CFVZ07yXfbkuOOssfN56yamQssgjAqxISx1Y9-hv6ZgXAt9aGlPvlb6-YrLN7y37gVY83nu08JsWOgit3o1Tu0_u9Ir6aHGv4wUbToByLbSWUjQ4HG9e5GyKdSxzXw";
    private $installments_interest_free=0;

    public function payment(Request $request){
        try{
            $cloudfox = new CloudfoxPayment();
            $cloudfox->payment_method = $request->payment_method;
            $cloudfox->amount = $request->amount*100;  //últimas duas casas é parte decimal              
            $cloudfox->currency = "BRL";
            $cloudfox->invoice_description =  "Descrição da fatura";

            switch($request->payment_method){
                case 'credit_card': 
                    $cloudfox->installments = $request->installments;
                    $cloudfox->installments_interest_free = $this->installments_interest_free; 
                    $cloudfox->attempt_reference = $request->attempt_reference; //obrigatorio

                    $cloudfox->card = [
                        "holder_name"=> $request->card_name,
                        "number"=> $request->card_number,
                        "cvv"=> $request->card_cvv,
                        "expiration_date"=> $request->card_expiration_date
                    ];
                break;
                case 'boleto':
                    $cloudfox->billet_due_days = 3;
                break;
            }

            $cloudfox->customer = $this->getCustomer();             
            
            $cloudfox->shipping_amount ="000"; //últimas duas casas é parte decimal

            $product = new Product();
            $product->id = "123"; //meu id de produto
            $product->name =  "Produto de Teste"; //titulo do produto
            $product->price =  10000; //últimas duas casas é parte decimal
            $product->quantity =  1;
            $product->product_type =  "physical_goods";

            $cloudfox->addProduct($product);           

            $cloudfoxApi = new CloudfoxApi($this->api_token);  
            
            return response()->json($cloudfoxApi->sendPayment($cloudfox));

        }catch(CloudfoxException $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'errors'=>$e->getErrors()],400);        
        }
    }

    public function installments(Request $request)
    {
        $data = [
            'installments'=>12, //numero maximo de parcelas
            'installments_interest_free'=>$this->installments_interest_free, //juros aplicados no parcelamento
            'amount'=>$request->amount*100 //valor a parcelar
        ];

        try{
            $cloudfox = new CloudfoxApi($this->api_token);            
            return $cloudfox->getInstallments($data);
        }catch(CloudfoxException $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'errors'=>$e->getErrors()],400);        
        }
    }

    public function getCustomer()
    {
        $customer = new Customer();
        $customer->first_name = "Teste";
        $customer->last_name = "da Silva";
        $customer->name = "Teste da Silva";
        $customer->email = "teste@hotmail.com";
        $customer->document_type = "cpf";
        $customer->document_number = "33024481044";
        $customer->telephone = "24999999999";

        $address = new Address();        
        $address->street = "Avenida General Afonseca";
        $address->number = "1475";
        $address->complement = "";
        $address->district = "Manejo";
        $address->city = "Resende";
        $address->state = "RJ";
        $address->country = "Brasil";
        $address->postal_code = "27520174";
        
        $customer->address = $address; 
        return $customer;
    }

    public function postback(Request $request)
    {
        //request vindo da api cloudfox
        \Log::info($request->all());
    }
}