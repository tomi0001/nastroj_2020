@foreach ($list as $description)
<div class="listDescription">
    {!!App\Http\Services\Common::charset_utf_fix($description->description)!!}<br>
    <b>{{$description->date}}</b>
    
</div><br>
    
@endforeach