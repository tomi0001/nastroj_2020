@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Rejestracja
@endsection
<div id="login">
    <form action="{{ route('user.loginSubmit')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">LOGOWANIE UŻYTKOWNIKA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                Twój login
            </td>
            <td>
                <input type="text" name="email" class="form-control" value="{{Request::old("login")}}">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Twoje hasło
            </td>
            <td>
                <input type="password" name="password" class="form-control">
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
        @if (!empty(session('errors')))
        @foreach ($errors->all() as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
@endsection