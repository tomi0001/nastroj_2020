@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Rejestracja
@endsection

<div id="login">
    <form action="{{ route('user.passwordResetSubmit')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">RESETOWANIE HASŁA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                Twój email
            </td>
            <td>
                <input type="text" name="email" class="form-control" value="{{Request::old("email")}}">
            </td>
        </tr>

        <tr>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zaloguj" class="btn btn-primary">
            </td>
        </tr>

    </table>
    </form>
    <div id="error">
        
        @foreach ($errors as $error)
        {{$error}}<br>
       @endforeach
       
    </div>
    
    <div id="succes">
       
       
        {{Session('succes')}}<br>
       
       
    </div>
</div>



@endsection