<div id='addHashDr' style='display: none;'>
    <form method="get">
    <table class="table">
        
        
        <tr>
            <td>
                Nowy Hash
            </td>
            <td>
                <input type="text" name="hash" id="hash" class="form-control">
            </td>
            <td>
                <input type="button" class="btn btn-primary" onclick="generateHash()" value="Wygeneruj hash">
            </td>
        </tr>
        <tr>
            <td>
                Login dla Dr
            </td>
            <td>
                @if (isset($hash->login))
                    <input type="text" name="login" class="form-control" value="{{$hash->login}}">
                @else
                    <input type="text" name="login" class="form-control" >
                @endif
            </td>
        </tr>
        <tr>
            <td>
                Umożliwić logowanie
            </td>
            <td>
                @if (isset($hash->if_true))
                    @if ($hash->if_true == 1)
                        <input type="checkbox" name="ifTrue" checked>
                    @else
                        <input type="checkbox" name="ifTrue">
                    @endif
                @else
                    <input type="checkbox" name="ifTrue">
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="3" class="center">
                <input type="button" class="btn btn-primary btn-lg" onclick="addHash('{{ route('setting.updateHash')}}')" value="Uaktulnij hash">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="center">
                <div id="updateHash"></div>
                
            </td>
        </tr>
    </table>
    </form>
</div>