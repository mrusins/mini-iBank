{!! Form::open(['action' => 'HomeController@confirmPayment', 'method' => 'POST']) !!}
{{--{!! Form::open(['action' => 'HomeController@index', 'method' => 'POST']) !!}--}}


{{Form::select('fromAccount', $userAccounts, null, ['placeholder' => 'from account...'])}}
{{Form::text('toAccount','',['placeholder'=>'to account...'])}}
{{Form::number('amount','',['placeholder'=>'amount...', 'step'=>'0.01'])}}


{{Form::submit('Pay')}}


{!! Form::close() !!}


