{!! Form::open(['action' => 'FinToolsController@addStock', 'method' => 'POST']) !!}



{{Form::text('stock','',['placeholder'=>'enter stock name...'])}}
{{Form::number('stockAmount','',['placeholder'=>'amount...', 'step'=>'1'])}}


{{Form::submit('addStock')}}

{!! Form::close() !!}



