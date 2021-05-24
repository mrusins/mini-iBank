<div class="errorMessage">
    @if(count($errors)>0)
        @foreach($errors->all() as $error)
            <div>
                {{$error}}
            </div>
        @endforeach
    @endif
</div>


<div class="errorMessage">
    @foreach($errorMessages as $message)
        {{$message}} <br>
    @endforeach
</div>
<div class="infoMessage">
    @foreach($infoMessages as $message)
        {{$message}} <br>
    @endforeach
</div>
