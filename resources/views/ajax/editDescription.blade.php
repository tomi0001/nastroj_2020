<form method="get">
    
    <textarea name="description"  class='form-control' cols='2' rows='3'>{{$description}}</textarea>
    <input type='button' onclick="editDescription('{{ route('Mood.editDescription')}}',{{$idMood}})" class='btn btn-primary' value='Modyfikuj'>
</form>


<div id="editDescription{{$idMood}}"></div>