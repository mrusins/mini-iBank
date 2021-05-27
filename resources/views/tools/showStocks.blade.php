@foreach($myStocks as $stock)
    <div class="stockInfo">
        <div class="id">{{$stock->name}}</div>
        <div class="rate">${{$stock->actual_price}}</div>
        <p class="id">amount</p>
        <div class="rate">{{$stock->total}}</div>

        {!! Form::open(['action' => 'FinToolsController@sellStock', 'method' => 'POST']) !!}

        {{Form::number('amount','',['placeholder'=>'amount...', 'step'=>'1', 'class'=>'sellForm'])}}
        {{Form::hidden('name', $stock->name )}}
        {{Form::hidden('actualPrice', $stock->actual_price )}}
        {{Form::hidden('startingPrice', $stock->starting_price )}}


        {{Form::submit('sell')}}


        {!! Form::close() !!}

    </div>
@endforeach
