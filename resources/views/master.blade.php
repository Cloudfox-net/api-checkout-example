<!DOCTYPE html>
<html>
    <head>
        <title>Example Cloudfox Api checkout integration</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/index.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <meta name="csrf-token" content="{{csrf_token()}}">
    </head>
<body class="bg-light">
    <div class="container">
        <main>
            <!-- Shopping Cart -->
            @include('partials.shopping_cart')
            <!--payment-->
            @include('partials.payment_method')

            <!-- credit card -->
            @include('partials.payment_credit_card')
            <!-- boleto -->
            @include('partials.payment_boleto')
            <!-- pix -->
            @include('partials.payment_pix')

            @include('partials.payment_confirmation')
        </main>
    </div>
    <footer class="p-4 bg-white">
        <div class="row px-3">
            <div class="col-4 col-md-1">
                <img src="img/logo.svg" class="img-fluid">
            </div>
            <div class="col-1 col-md-6"></div>
            <div class="col-7 col-md-5 text-end">
                <p>Documentação: <a href="https://sandbox.cloudfox.net/guide">https://sandbox.cloudfox.net/guide</p>
            </div>
        </div>
	</footer>

    <!-- copiar e colar link gerado pelo sirus -->
    <script id="cfaf" src="{{config('cloudfox.url_script')}}" async></script>

    <!-- BEGININ - colar e copiar o script para inicializar o script cloudfox -->
    <script>
        let sensitiveFields = ['card_number','card_name','card_cvv'];
        let secretFields = [''];
        const cfaf = document.getElementById('cfaf');
        if (cfaf.readyState) {  //IE
            cfaf.onreadystatechange = function () {
                if (cfaf.readyState == "loaded" || script.readyState == "complete") {
                    cfaf.onreadystatechange = null;
                    cfa.init(sensitiveFields, secretFields);
                }
            };
        } else {  //Others
            cfaf.onload = function () {
                cfa.init(sensitiveFields, secretFields);
            };
        }
    </script>
    <!-- END -->

    <script type="text/javascript" src="assets/jquery-loading.min.js"></script>
    <script type="text/javascript" src="js/index.js?v=1" defer></script>
  </body>
</html>
