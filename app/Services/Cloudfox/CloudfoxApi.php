<?php
namespace App\Services\Cloudfox;

use App\Exceptions\CloudfoxException;
use Cache;
use Exception;
use Illuminate\Support\Facades\Log;

class CloudfoxApi
{
    private $apiToken = "";
    private $apiUrl = "http://dev.checkout.net/api";
    public $curlInfo = [];

    public function __construct($apiToken){
        if(empty($apiToken)){
            throw new Exception("Informe Api Token."); 
        }
        $this->apiToken = $apiToken;
    }

    public function getInstallments($data){
        $response = $this->requestGnAuth('getInstallments', $data);
        if($response['status']==200){
            return json_decode($response['result']);
        }
        throw new CloudfoxException("Ops! algo deu errado na Api Cloudfox", $response['status'], null, json_decode($response['result']));        
    }

    public function sendPayment($data){
        $response = $this->requestGnAuth('payment', $data);        
        if($response['status']==200){
            return json_decode($response['result']);
        }
        throw new CloudfoxException("Ops! algo deu errado na Api Cloudfox", $response['status'], null, json_decode($response['result']));        
    }

    public function getMethod($endpoint, $variables)
    {
        $endpoints = [
            "payment" => [
                "route" => "/v1/payments",
                "method" => "POST"
            ],
            "cancelPayment" => [
                "route" => "/v1/cancel payment/:sale_id",
                "method" => "POST"
            ],
            "listSales" => [
                "route" => "/v1/sales/:sale_id",
                "method" => "GET"
            ],
            "getInstallments" => [
                "route" => "/v1/get-installments",
                "method" => "POST"
            ]
        ];

        if (!empty($endpoints[$endpoint])) {
            if (!is_null($variables)) {
                $route = $endpoints[$endpoint]['route'];
                $placeholders = '/\:(\w+)/im';
                preg_match_all($placeholders, $route, $matches);
                $myVariables = $matches[1];
                foreach ($myVariables as $value) {
                    if (isset($variables[$value])) {
                        $route = str_replace(':' . $value, $variables[$value], $route);
                        unset($variables[$value]);
                    }
                }
                $endpoints[$endpoint]['route'] = $route;
            }
            return $endpoints[$endpoint];
        }
        return null;
    }
    
    public function requestGnAuth($endpoint, $data = null, $variables = null)
    {
        $headers = [
            "authorization: Bearer {$this->apiToken}",
            "Content-Type: application/json",
        ];

        $arrEndpoint = $this->getMethod($endpoint, $variables);

        $curl = curl_init($this->apiUrl . $arrEndpoint['route']);

        curl_setopt($curl, CURLOPT_ENCODING, '');

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $arrEndpoint['method']);

        if (!is_null($data)) 
        {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $this->curlInfo = curl_getinfo($curl);

        curl_close($curl);

        return ['status'=>$httpCode,'result'=>$result];
    }
}