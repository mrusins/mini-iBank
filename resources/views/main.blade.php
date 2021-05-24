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
<body class="font-sans antialiased">
<div>

    <div>
        @yield('head')
    </div>


    <div class="container mx-auto bg-gray-200 py-5 rounded-lg font-mono pl-5 pr-5">
        <h2>Summary</h2>

        @foreach($total as $record)
            <li>{{ $record['account'] }} - <b>{{ $record['currency'] }}</b>: {{ $record['amount'] / 100}}

                @if($record['is_investment'] === true)
                    (Investment account)
                @endif

            </li>
        @endforeach
    </div>
    <br>
    <div class="container mx-auto bg-gray-200 py-5 rounded-lg font-mono pl-5 pr-5">

        <div>
            @include('inc.messages')

        </div>

        <div>

            @include('forms.mainPaymentForm')

        </div>


        <div>
            @if(count($paymentConfirmation) >= 1)
                @include('forms.paymentConfirmation')
            @endif
        </div>

    </div>
<br>

    <div class="container mx-auto bg-gray-200 py-5 rounded-lg font-mono pl-5 pr-5">
        <table class="table table-bordered mb-5">
            <thead>
            <tr class="table-success ">

                <th scope="col">From account</th>
                <th scope="col">Amount</th>
                <th scope="col">Currency</th>

                <th scope="col">To account</th>
                <th scope="col">Converted to</th>
                <th scope="col">Converted amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($history as $record)
                <tr>

                    <td>{{ $record['from_account'] }} </td>
                    <td>{{ $record['amount'] / 100 }}</td>
                    <td>{{ $record['currency'] }}</td>
                    <td>{{ $record['to_account'] }}</td>

                    <td>{{ $record['converted_to'] }}</td>
                    <td>{{ $record['converted_amount']/100  }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $history->links() !!}
        </div>
    </div>


</div>
<br>


</body>
<style>
    table, th, td {
        padding: 5px;
        text-align: center;
        border: 1px solid black;
    }

    .errorMessage {
        color: red;
    }

    .infoMessage {
        color: green;
    }

    .input {
        color: red;
    }

    .paginator {
        color: green;
        font-family: Arial;
    }
</style>
</html>


