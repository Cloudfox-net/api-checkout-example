var total_cart = 0;

document.getElementById("checkout-btn").addEventListener("click", function() {
    $('#checkout-btn').attr("disabled", true);
    
    var orderData = {
        quantity: document.getElementById("quantity").value,
        description: document.getElementById("product-description").innerHTML,
        price: document.getElementById("unit-price").innerHTML
    };

    $(".shopping-cart").fadeOut(500);
    setTimeout(() => {
        $(".payment-method").show(500).fadeIn();

        document.getElementById("item-credit-card").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-credit-card").show(500).fadeIn();
                $("#alertPaymentCC").html('');
                getInstallments();
            }, 500);
        }); 

        document.getElementById("item-boleto").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-boleto").show(500).fadeIn();
            }, 500);
        });
        
        document.getElementById("item-pix").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-pix").show(500).fadeIn();
            }, 500);
        });
             
    }, 500);    
});
  
function updatePrice() {
    let quantity = document.getElementById("quantity").value;
    let unitPrice = document.getElementById("unit-price").innerHTML;
    let amount = parseInt(unitPrice) * parseInt(quantity);
  
    $("#cart-total").html("R$ " + amount);
    $(".summary-price").html("R$ " + unitPrice);
    $(".summary-quantity").html(quantity);
    $(".summary-total").html("R$ " + amount);

    total_cart = amount;
}

document.getElementById("quantity").addEventListener("change", updatePrice);

updatePrice();  
  
document.getElementById("go-back-cart").addEventListener("click", function() {
    $(".payment-method").fadeOut(500);
    setTimeout(() => {
        $(".shopping-cart").show(500).fadeIn();
    }, 500);
    $('#checkout-btn').attr("disabled", false);  
});

$('.go-to-back-pm').on('click',function(){
    $(`.payment-${$(this).attr('pm')}`).fadeOut(500);
    setTimeout(() => {        
        $(".payment-method").show(500).fadeIn();
    }, 500);    
});

function getInstallments(){

    var formData = new FormData();
    formData.append('amount', total_cart);

    $.ajax({
        method: "POST",
        url: '/installments',
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        headers: {            
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },           
        data:formData,            
        error: function (response) {              
                       
            $("#alertPaymentCC").html(`<div class="alert alert-danger">${response.responseJSON.message}</div>`);
        },            
        success: function (response) {                
            
            $('#installments').html('');
            response.forEach(element => {
                $('#installments').append(`<option value="${element.amount}">${element.amount} x de R$ ${element.value}</option>`);            
            });
        }
    }); 
}

$( "#form-credit-card" ).submit(function( event ) {   
    event.preventDefault(); 
    //essencial para executar o antifraude
    if (window.dftp) {
        dftp.profile(sendPaymentCardData);
    } else {
        sendPaymentCardData();
    }
});

function sendPaymentCardData(){
    postPayment("#form-credit-card",'credit_card',".payment-credit-card","#alertPaymentCC");
}

$( "#form-boleto" ).submit(function( event ) {
    event.preventDefault();
    postPayment("#form-boleto","boleto",".payment-boleto","#alertPaymentBo");        
});

$( "#form-pix" ).submit(function( event ) {
    event.preventDefault();
    postPayment("#form-pix","pix",".payment-pix","#alertPaymentPix");    
});

function postPayment(divForm,payment_method,divLoading,divAlert){
    divLoading2 = `${divLoading} .box-content`;
    var formData = new FormData($(divForm)[0]);
    if(payment_method=='credit_card'){
        formData.append('attempt_reference', CloudfoxAntifraud.getAttemptReference());
        console.log(CloudfoxAntifraud.getAttemptReference());
    }
    formData.append('amount', total_cart);
    formData.append('payment_method', payment_method);
    
    $.ajax({
        method: "POST",
        url: '/payment',
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        headers: {                    
            'Accept': 'application/json',
        },   
        crossDomain:false,         
        data: formData,            
        beforeSend: function () {                
            $(divLoading2).loading({message: '...',start:true});
            $('.btn-finish').removeAttr('disabled');
        },
        error: function (response) {                                    
            $(divLoading2).loading('stop');
            $('.btn-finish').removeAttr('disabled'); 
            console.log(response);                       
            $(divAlert).html(`<div class="alert alert-danger">${response.responseJSON.message}</div>`);
        },            
        success: function (data) {                
            $(divLoading2).loading('stop');
            $('.btn-finish').removeAttr('disabled');             
            console.log(data.response);
            if(data.status=='error'){
                $(divAlert).html(`<div class="alert alert-danger">${data.message}</div>`);
            }else{
                $('.btn-finish').hide();
                switch(payment_method){
                    case 'pix':
                        $(divAlert).html(`<div class="alert alert-success">Qrcode gerado com sucesso!</div>`);
                        $('#qrcode_img').html(`<img src="${data.response.pix.qrcode_image}" class="rounded" alt="...">`);
                        $('#qrcode').val(data.response.pix.qrcode);
                        $('#qrcode').removeAttr('disabled');
                    break;
                    case 'boleto':
                        $(divAlert).html(`<div class="alert alert-success">Boleto gerado com sucesso!</div>`);
                        setTimeout(() => {
                            $(divLoading).fadeOut(500);
                            $(".payment-confirmation").show(500).fadeIn();
                            $('#message_confirmation').html(`<h3>Linha digitável boleto</h3><h1>${data.response.boleto.digitable_line}</h1><br/>
                            <a href="${data.response.boleto.link}" class="btn btn-success" target="blank">Baixar</a>` );
                        }, 1000);
                    break;
                    case 'credit_card':
                        $(divAlert).html(`<div class="alert alert-success">Pagamento com cartão realizado com sucesso!</div>`);
                        setTimeout(() => {
                            $(divLoading).fadeOut(500);
                            $(".payment-confirmation").show(500).fadeIn();
                            $('#message_confirmation').html("<h1>Pagamento com cartão de crédito realizado com sucesso!</h1>" );
                        }, 1000);
                    break;
                }                              
            }
        }
    }); 
}