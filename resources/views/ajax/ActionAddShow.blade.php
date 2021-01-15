<script>
var actionList_{{$id}} = [];
var actionList2_{{$id}} = [];



$(document).ready(function(){
    $(".Action___").click(function(){
     if (getNumber($(this).attr("id"),actionList_{{$id}})) {
        actionList_{{$id}}.remove($(this).attr("id"));
        $(this).css("background-color","transparent");
        $(this).css("border-radius",'0px');
        $(this).css("color","#4288BA");
        
    }
    else {
        
        actionList_{{$id}}.push($(this).attr("id"));
        $(this).css("background-color","#95721F");
        $(this).css("border-radius",'30px');
        $(this).css("color","white");
    }
    //alert(actionList.length);
    });
});
Array.prototype.remove=function(s){
                        for(i=0;i<actionList_{{$id}}.length;i++){
                           //alert(actionList[i]);
                           if(s==actionList_{{$id}}[i]) actionList_{{$id}}.splice(i, 1);
                           //alert(actionList[i]);
                        }
                }
                
const getNumber = function ( num, arr ) {
    return arr.includes( num );
}


$(document).ready(function(){
    $(".Action___2").click(function(){
     if (getNumber($(this).attr("id"),actionList2_{{$id}})) {
        actionList2_{{$id}}.remove2($(this).attr("id"));
        $(this).css("background-color","transparent");
        $(this).css("border-radius",'0px');
        $(this).css("color","#4288BA");
    }
    else {
        actionList2_{{$id}}.push($(this).attr("id"));
        $(this).css("background-color","#95721F");
        $(this).css("border-radius",'30px');
        $(this).css("color","white");
    }
    //alert(actionList.length);
    });
});
Array.prototype.remove2=function(s){
                        for(i=0;i<actionList2_{{$id}}.length;i++){
                           //alert(actionList[i]);
                           if(s==actionList2_{{$id}}[i]) actionList2_{{$id}}.splice(i, 1);
                           //alert(actionList[i]);
                        }
                }
                
function updateActionMood(url,id) {
    var tmp = eval("actionList_" + id);
    //alert();
    //var tmp2 = tmp.serializeArray();
  $("#form_" + id).find(":hidden").filter("[name!='idAction']").remove();


    changeArrayAtHidden2(tmp,id);
    $.ajax({
    url : url,
        method : "get",
        data : 
          "array=" + JSON.stringify(tmp) + "&idMood=" + id


        ,
        dataType : "html",
})
.done(function(response) {
    $("#form__" + id).html(response);
    if (response == "") {
        
        $("#form__"+ id).html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
    }
    
})
.fail(function() {
    $("#form__" + id).html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
    
}
function selectAction(id) {
    actionList_{{$id}}.push($("#" + id).attr("id"));
        $("#" + id).css("background-color","#95721F");
        $("#" + id).css("border-radius",'30px');
        $("#" + id).css("color","white");
}
function isIst2(id) {
    if (actionList.length == 0) {
        return false;
    }
    for (i=0;i < actionList.length;i++) {
        if (actionList[i] == id) {
            return true;
            
        }
    }
    return false;
}
function changeArrayAtHidden2(tmp,id) {

    for (i=0;i < tmp;i++) {
        if (isIst2(tmp[i])) {
            $("#form" + id).append("<input type=\'hidden\' name=\'idAction[]\' value=" + tmp[i] + " class=\'form-control typeMood\'>");
        }
    }
}
</script>
<div  style="overflow-y: scroll;  height:200px; width:60%; margin-left: auto; margin-right: auto;">
                                        <div id="parentsAction_{{$i}}">
                                            @foreach ($Action as $list)
                                                @if (App\Moods_action::compareIdActionMood($list->id,$id))
                                                    <script>
                                                    window.onload=selectAction('{{$list->id}}_{{$id}}');

                                                        </script>
                                                    <a class="Action___" id = "{{$list->id}}_{{$id}}">{{$list->name}}</a> |
                                                @else
                                                    <a class="Action___" id = "{{$list->id}}_{{$id}}">{{$list->name}}</a> |
                                                @endif
                                            @endforeach
                                        </div>
</div>
<div class='center'> <input type='button' class='btn btn-primary btn-lg' onclick="updateActionMood('{{ route('ajax.updateActionMoods')}}',{{$id}})" value='Uaktualnij'></div>

<div id="form__{{$id}}"></div>
