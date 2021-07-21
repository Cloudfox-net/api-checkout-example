<?php namespace App\Services\Cloudfox;

class CloudfoxPayment{
    /**
     * forma de pagamento credit_cart | boleto | pix          
     * @var string
     */
    public $payment_method;
    
    /**
     * valor total da cobrança sem separador decimal. aceita 2 casas decimais.     
     * Exemplo para cobrança R$100 informar 10000
     * @var integer
     */
    public $amount;
    
    public $currency;
    public $invoice_description;
    
    public $customer;
     /**
     * valor de frete sem separador decimal. aceita 2 casas decimais.
     * Exemplo para cobrança R$100 informar 10000
     * @var string
     */
    public $shipping_amount;

    /* campos obrigatorios para cartão de crédito
    // public $installments;
    // public $installments_interest_free;
    // public $attempt_reference;
    // public $card;
    */

    /* campos obrigatorios para boleto
    // public $billet_due_days = 3;
    */

    /**
     * lista de produtos
     * @var array
     */
    public $items;
    
    public function addProduct(Product $product){
        $this->items[] = $product;
    }
}