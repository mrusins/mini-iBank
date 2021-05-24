<br><br>
Please confirm your payment <br>
FROM  YOUR ACCOUNT: {{$paymentConfirmation['fromAccount']}} <br>
TO ACCOUNT: {{$paymentConfirmation['toAccount']}} <br>
AMOUNT: {{$paymentConfirmation['amount']}} <br>


{!! Form::open(['action' => 'HomeController@indexRedirect', 'method' => 'POST']) !!}

{{Form::hidden('fromAccount', $paymentConfirmation['fromAccount'])}}
{{Form::hidden('toAccount', $paymentConfirmation['toAccount'])}}
{{Form::hidden('amount', $paymentConfirmation['amount'])}}

{{Form::submit('Confirm')}}


{!! Form::close() !!}


{!! Form::open(['action' => 'HomeController@cancelPayment', 'method' => 'POST']) !!}


{{Form::submit('Cancel')}}


{!! Form::close() !!}

<br><br>
