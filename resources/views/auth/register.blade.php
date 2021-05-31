@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Rejestracja
@endsection
<div id="login">
    <form action="{{ route('user.registerSubmit')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">REJESTRACJA UŻYTKOWNIKA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                Twój login
            </td>
            <td>
                <input type="text" name="login" class="form-control" value="{{Request::old("login")}}">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Twój E-mail
            </td>
            <td>
                <input type="email" name="email" class="form-control" value="{{Request::old("email")}}">
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
            <td width="40%">
                Wpisz jeszcze raz swoje hasło
            </td>
            <td>
                <input type="password" name="password_confirm" class="form-control">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Początek dnia
            </td>
            <td>
                @if (Request::old("start_day") )
                    <input type="number" name="start_day" class="form-control"  value ='{{Request::old("start_day") }}'>
                @else
                    <input type="number" name="start_day" class="form-control"  value ='0'>
                @endif
            </td>
        </tr>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zarejestruj" class="btn btn-primary">
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