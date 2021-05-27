<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>mini iBank</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

{{--    @livewireStyles--}}

<!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="text-gray-900">

<div>
    @yield('head')
</div>

<div class="container mx-auto bg-gray-200 py-5 rounded-lg font-mono pl-5 pr-5">
    @include('rates')
</div>
<br>
<div class="container mx-auto bg-gray-200 py-5 rounded-lg font-mono pl-5 pr-5">
    <div style="float: right;">
        @include('forms.updateStocks')
    </div>
    <div class="">
        Summary
        @foreach($total as $record)
                @if($record['is_investment'] === true)
                <li>{{ $record['account'] }} - <b>{{ $record['currency'] }}</b>: {{ round($record['amount'] / 100, 2)}}
                @endif
            </li>
        @endforeach
    </div>
    <br>
    @include('forms.stockSearchForm')

    <div>
        @include('inc.messages')
    </div>
    <br>
    <div class="stockGrid">
        @include('tools.showStocks')
    </div>
</div>





</body>
<style>
    .grid {
        display: grid;
        grid-template-columns: auto auto auto auto auto auto;
        grid-gap: 2px;
        /*background-color: whitesmoke;*/
        padding: 10px;
    }

    .grid > div {
        /*background-color: lightgrey;*/
        text-align: center;
        margin: auto;
        padding: 5px 0;
    }
    .stockGrid {
        display: grid;
        grid-template-columns: auto auto auto auto auto auto;
        grid-gap: 20px;
        /*background-color: whitesmoke;*/
        padding: 10px;

    }

    .stockGrid > div {
        background-color: lightgray ;

        text-align: center;
        padding: 5px 0;
        height: 150px;
        width: 100px;
        border-radius: 5px;
        margin: auto;
        justify-content: center;
        align-items: center;
        box-shadow: 2px 2px #888888;

    }
    .stockInfo{
        top: 50%;
        margin: auto;
        justify-content: center;
        align-items: center;
    }
    .sellForm{
        width: 100px;
        height: 30px;
        font-size: smaller;
        border: none;
        text-align: center;
        background-color: lightgray;
        -webkit-appearance: none;


    }

    .id {
        font-size: small;
    }

    .rate {
        font-size: medium;
    }

    .errorMessage {
        color: red;
    }

    .infoMessage {
        color: green;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
</html>


