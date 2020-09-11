

<table class="table">
    <form  method="get">
    <tr>
        <td>
            Poziom nastroju
        </td>
        <td>
            <input type="text" id="levelMood_{{$list->id}}" class="form-control" value="{{$list->level_mood}}"  onkeypress="return runScriptEditMood(event,'{{ route('Mood.editAction')}}',{{$list->id}},{{$i}})">
        </td>
    </tr>
    <tr>
        <td>
            Poziom lęku
        </td>
        <td>
            <input type="text" id="levelAnxiety_{{$list->id}}" class="form-control" value="{{$list->level_anxiety}}"  onkeypress="return runScriptEditMood(event,'{{ route('Mood.editAction')}}',{{$list->id}},{{$i}})">
        </td>
    </tr>
    <tr>
        <td>
            Poziom zdenerwowania
        </td>
        <td>
            <input type="text" id="levelNervousness_{{$list->id}}" class="form-control" value="{{$list->level_nervousness}}"  onkeypress="return runScriptEditMood(event,'{{ route('Mood.editAction')}}',{{$list->id}},{{$i}})">
        </td>
    </tr>
    <tr>
        <td>
            Poziom pobudzenia
        </td>
        <td>
            <input type="text" id="levelStimulation_{{$list->id}}" class="form-control" value="{{$list->level_stimulation}}"  onkeypress="return runScriptEditMood(event,'{{ route('Mood.editAction')}}',{{$list->id}},{{$i}})">
        </td>
    </tr>
    <tr>

        <td colspan="2" class="center">
            <input type="button" value="Edytuj" class="btn btn-primary" onclick="editMoodAction('{{ route('Mood.editAction')}}',{{$list->id}},{{$i}})">
        </td>
    </tr>

    </form>
    
</table>

<div id="viewEditMood2{{$i}}"></div>