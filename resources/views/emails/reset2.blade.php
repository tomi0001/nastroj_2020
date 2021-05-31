@extends('Layout.User')
@section('content')
<br>
@section ('title') 
Nadawanie nowego hasła
@endsection
<div id="login">
    
    <div id="error">
        
        @foreach ($errors as $error)
        {{$error}}<br>
       @endforeach
       
    </div>
</div>


@endsection