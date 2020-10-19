@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Rejestracja
@endsection
<div id="login">
    <form action="{{ route('User.resetPasswordConfirm2')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">RESETOWANIE HASŁA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                hasło
            </td>
            <td>
                <input type="password" name="password" class="form-control" >
            </td>
        </tr>
        <tr>
            <td width="40%">
                Powtórz hasło
            </td>
            <td>
                <input type="password" name="password2" class="form-control">
            </td>
        </tr>
        <tr>
        <input type="hidden" name="hash" value="{{$hash}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Resetuj" class="btn btn-primary btn-lg">
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