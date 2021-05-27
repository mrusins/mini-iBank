@if($viewRates === true)
    <a href="{{action('FinToolsController@showRates')}}">Show currency rates</a>



@elseif($viewRates === false)
    <a href="{{action('FinToolsController@hideRates')}}">Hide currency rates</a>

<div>
    Actual currencies rate @
    {{$currencyUpdateTime}}
</div>

    <div class="grid bg-gray-200">
        @foreach($allCurrencies as $data)
            <div>
                <div class="id">{{$data['ID']}}</div>
                <div class="rate">{{$data['Rate']}}</div>
            </div>
        @endforeach
    </div>
@endif
