@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Rejestracja
@endsection
<div id="login">
    <form action="{{ route('login')}}" method="post">
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
        <tr>
            <td>
                 <label class="form-check-label" for="remember">
                                        {{ __('Zapamiętaj mnie') }}
                                    </label>
            
            </td>
            <td align='left'>
                                   <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </td>
        </tr>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zaloguj" class="btn btn-primary btn-lg">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{ route("user.passwordReset")}}">Zapomniałem hasła</a>
                
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
<div class="center">
<a href="{{route('register')}}"><button class="btn btn-success btn-lg">Zarejestruj się</button></a>
</div>
<div id="login">
    <form action="{{ route('userDr.loginSubmit')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">LOGOWANIE LEKARZA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                login
            </td>
            <td>
                <input type="text" name="email" class="form-control" value="{{Request::old("loginDr")}}">
            </td>
        </tr>
        <tr>
            <td width="40%">
                hash
            </td>
            <td>
                <input type="password" name="password" class="form-control">
            </td>
        </tr>
        <tr>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zaloguj" class="btn btn-primary btn-lg">
            </td>
        </tr>
        
    </table>
    </form>
    <div id="error">
        
        @if (!empty($errors2))
        
        @foreach ($errors2 as $error2)
        
        {{$error2}}<br>
       @endforeach
       @endif
       
    </div>
</div>
@endsection