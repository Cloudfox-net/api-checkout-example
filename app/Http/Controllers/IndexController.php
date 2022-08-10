<?php

namespace App\Http\Controllers;

use App\Exceptions\CloudfoxException;
use App\Services\Cloudfox\Address;
use App\Services\Cloudfox\CloudfoxApi;
use App\Services\Cloudfox\CloudfoxPayment;
use App\Services\Cloudfox\Customer;
use App\Services\Cloudfox\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //Token gerado no Sirius
    private $api_token;
    private $installments_interest_free = 1;

    public function __construct()
    {
        $this->api_token = config('cloudfox.api_token');
    }

    public function payment(Request $request)
    {
        try {
            $cloudfox = new CloudfoxPayment();
            $cloudfox->payment_method = $request->payment_method;
            $cloudfox->amount = $request->amount * 100;  //últimas duas casas é parte decimal
            $cloudfox->currency = "BRL";
            $cloudfox->invoice_description = "Descrição da fatura";

            switch ($request->payment_method) {
                case 'credit_card':
                    $cloudfox->installments = $request->installments;
                    $cloudfox->installments_interest_free = $this->installments_interest_free;
                    $cloudfox->attempt_reference = $request->attempt_reference; //obrigatorio

                    $cloudfox->card = [
                        "holder_name"     => $request->card_name,
                        "number"          => $request->card_number,
                        "cvv"             => $request->card_cvv,
                        "expiration_date" => $request->card_expiration_date
                    ];
                    break;
                case 'boleto':
                    $cloudfox->billet_due_days = 3;
                    $cloudfox->billet_description='Teste';
                    break;
            }

            $cloudfox->customer = $this->getCustomer();

            $cloudfox->shipping_amount = "000"; //últimas duas casas é parte decimal

            $product = new Product();
            $product->id = "123"; //meu id de produto
            $product->name = "Produto de Teste"; //titulo do produto
            $product->price = 10000; //últimas duas casas é parte decimal
            $product->quantity = 1;
            $product->product_type = "physical_goods";

            $cloudfox->addProduct($product);

            $cloudfoxApi = new CloudfoxApi($this->api_token);

            return response()->json($cloudfoxApi->sendPayment($cloudfox));
        } catch (CloudfoxException $e) {
            return response()->json(
                ['status' => 'error', 'message' => $e->getMessage(), 'errors' => $e->getErrors()],
                400
            );
        }
    }

    public function installments(Request $request)
    {
        $data = [
            'installments'               => 12, //numero maximo de parcelas
            'installments_interest_free' => $this->installments_interest_free, //juros aplicados no parcelamento
            'amount'                     => $request->amount * 100 //valor a parcelar
        ];

        try {
            $cloudfox = new CloudfoxApi($this->api_token);
            return $cloudfox->getInstallments($data);
        } catch (CloudfoxException $e) {
            dd($e->getMessage());
            return response()->json(
                ['status' => 'error', 'message' => $e->getMessage(), 'errors' => $e->getErrors()],
                400
            );
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
