<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TESTE TÉCNICO PHP - BACK-END DEVELOPER - Júnior de Jesus da Silva</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ env('APP_URL') }}/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ env('APP_URL') }}/css/style.css" rel="stylesheet">
    <style>
        .nav-header .brand-title {
            margin-left: 15px;
            max-width: 200px;
        }
        </style>
</head>

<body>
<body class="bg-light">

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="{{env('APP_URL')}}/images/logo.png" alt="" >
                <h2>TESTE TÉCNICO PHP - BACK-END DEVELOPER</h2>
                <p class="lead">Júnior de Jesus da Silva</p>
            </div>
            @yield('content')
        </main>
    </div>

    
    <script src="{{ env('APP_URL') }}/vendor/global/global.min.js"></script>
    <script src="{{ env('APP_URL') }}/js/quixnav-init.js"></script>
    <script src="{{ env('APP_URL') }}/js/jquery.printelement.js"></script>
    <script src="{{ env('APP_URL') }}/js/custom.min.js"></script>
    <script src="{{ env('APP_URL') }}/js/funcoes.js"></script>
    
</body>

</html>


