/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
       function saveDrugs(url,i,id)  {
           var result = $("#addDrugsResult"+i).load(url + "?" + "idMood=" + id  + "&" +  $("#addDrugsssss"+i).serialize(),function() {
               if (result.text() =="Pomyslnie dodano") {
                   resetDrugs(i);
                   //alert("dobrze");
               }
           });
       }     
       
       function showDrugs(url,i,id) {
           
           $("#showDrugss"+i).load(url + "?id=" + id).toggle();
       }
       
function addDrugs(url = null,i = null,id = null) {
    if (i == null) {
        
        $(".drugss").append("<table class='table addMood drugs' id=\"drug_\"><tr><td width='50%' class='center'>Nazwa leku </td><td class='center'><input type='text' name='name[]' class='form-control'></td></tr><tr><td width='50%' class='center' rowspan=\"2\"><br>Dawka leku </td><td class='center'><input type='text' name='dose[]' class='form-control'></td></tr><tr>    <td class='center'>                <select name='type[]' class='form-control form-control-lg'><option value='1'>Mg</option><option value='2'>Militry</option><option value='3'>Ilości</option></select></td></tr><tr><td rowspan='2' class='center'><br>Data wzięcia</td><td><input type='date' name='date[]' class='form-control'></td></tr><tr><td class='center'><input type='time' name='time[]' class='form-control'></td></tr><tr>                                                            <td colspan=\"2\" class='center'><div class=\"center\"><input type=\"button\" onclick='deleteDrugs()'  value=\"Usuń lek\" class=\"btn btn-primary drugsss\"></div></td></tr></table>").html();
    }
    
    else {
        var bool = false;
        if ($(".drugss"+i).text() == "") {
            bool = true;
        }
        var drugs = "drugs"+i;
        $("#addDrugsButton"+i).prop('disabled', true);
        $(".drugss"+i).html("<div class='newline'></div><div class='addDrugssss '" + drugs  + "' id=\"drug_\"><div class=tr><div class='td'>Nazwa leku</div><div class='td'><input type='text' name='name[]' class='form-control'></div></div><div class=newline></div><div class=tr><div class='td'><br>Dawka leku</div><div class='td'><input type='text' name='dose[]' class='form-control'><br><select name=type[] class='form-control'><option value='1'>Mg</option><option value='2'>Militry</option><option value='3'>Ilości</option></select></div></div><div class='newline'></div><div class=tr><div class='td'><br>Dawka leku</div><div class='td'><input type='date' name='date[]' class='form-control'><br><input type='time' name='time[]' class='form-control'>             </div></div>      <div class='newline'></div><div class='tr'><div class=' tdCenter'><input type='button' value='Usuń wpis' onclick='deleteDrugs(true," + i + ")' class='btn btn-primary'></div></div>           </div>");
        
  $(".drugsss"+i).html("      <div class='addDrugssss  center' style=' width: 80%;'" + drugs  + "'   id=\"drug_\"><div class='tr'><div class='tdCenter'><input type='button' onclick=saveDrugs('" + url + "'," + i + "," + id + ") class='btn btn-primary' value='Zapisz leki'></div></div></div>");



    }
    
}


    function generateHash() {
        var array = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','s','t','u','w','y','z','x','1','2','3','4','5','6','7','8','9','0'];
        //alert(array.length);
        var rand;
        var chr;
        var string = "";
        for (var i=0;i< 10;i++ ) {
           rand = parseInt(Math.random() * ((array.length  -1)  - 0) + 0);
           chr =  array[rand];
           string += chr;
        }
        
        $("#hash").val(string);
        
    }
function addHash(url) {
    $("#updateHash").load(url + "?" + $("form").serialize());
}
function offHour() {
    //alert("dobrze");
    if($("#dayFor").is(':checked'))
    {
        $("#hourTo").prop('disabled', true);
        $("#hourFrom").prop('disabled', true);
    }
    else {
        $("#hourTo").prop('disabled', false);
        $("#hourFrom").prop('disabled', false);
    }
}
function resetDrugs(i) {
    //alert("jakks");
    $(".drugss"+i).html("");
            $(".drugsss"+i).html("");
            $("#addDrugsButton"+i).prop('disabled', false);
}
function editMood(url,id,i) {
    $("#viewEditMood"+i).toggle();
    $("#viewEditMood"+i).load(url + "?id=" + id + "&i=" + i);
}
function deleteDrugsId(url,id) {
    var con = confirm("Czy na pewno usunąć");
    if (con == true) {
        $("#DrugsTr"+id).load(url + "?id=" + id);
    }
}
function editMoodAction(url,id,i) {
    var levelMood = $("#levelMood_" + id).val();
    var levelAnxiety = $("#levelAnxiety_"+  id).val();
    var levelNervousness = $("#levelNervousness_" + id).val();
    var levelStimulation = $("#levelStimulation_" + id).val();
    //alert(i);
    $("#viewEditMood2"+i).load(url + "?id=" + id + "&levelMood=" + levelMood + "&levelAnxiety=" + levelAnxiety + "&levelNervousness=" + levelNervousness + "&levelStimulation=" + levelStimulation);
}

function getDiv() {
    alert("dob");
    /*
        
  */
}

function addSleep(url) {
    $("#addResultSleep").load(url + "?" + $("form").serialize());
}

function deleteDrugs(bool = false,i=0) {
     if (bool == false) {
       $(document).on('click', '.drugsss', function() {
           $(this).parents('.drugs').remove();
           
       });
     }
     else {
    

        $(".drugs"+i).remove();

        //alert(i);
        if (($(".drugss"+i).text() != "")) {
            $(".drugss"+i).html("");
            $(".drugsss"+i).html("");
            $("#addDrugsButton"+i).prop('disabled', false);
        }
        else {

        }
     }
}


function addDescription(url,id,i) {
    $("#showFieldText"+i).toggle();
    $("#showFieldText"+i).load(url + "?id=" + id);
}

function hideDiv(count) {
    for (i=0;i < count;i++) {
        $("#showDescription"+i).hide();
        $("#showFieldText"+i).hide();
        $("#showActions"+i).hide();
        $("#viewEditMood"+i).hide();
        $("#showDrugs"+i).hide();
    }
}
function editDescription(url,id) {
    

        $("#editDescription"+id).load(url + "?" + $("#form9").serialize() + "&id=" + id);
    
    
}

function searchAI(url) {
    
var response;
$.ajax({ type: "GET",   
     url: url + "?" + $("#form3").serialize(),   
     async: false,
     success : function(text)
     {
         response= text;
     }
});
    
    //$("#AI").load(url + "?" + $("form").serialize()).append();
    $("#AI").prepend(response);
    
    //$("#AI").load(url + "?" + $("form").serialize());
}
function sumMood(url) {
    var response;
    $.ajax({ type: "GET",   
         url: url + "?" + $("#form4").serialize(),   
         async: false,
         success : function(text)
         {
             response= text;
         }
    });
    //$("#AI").load(url + "?" + $("form").serialize()).append();
    $("#SumMoodSearch").prepend(response);
}


function UpdateActionDay(url,i) {
    $("#ForDayAction").load(url + "?" + $("#formActionDay" + i).serialize());
   
}

function deleteWorld() {
    $(".t").remove();
    //alert("ss");
}
function addWorld() {
    //alert("ss");
    $("#what_work").append("<input type=\'text\' name=\'descriptions[]\' class=\'form-control\'>");
    
    //$("#what_work").append($("#what_work4").html());
}

/*
 * 
 * 
 * 
 * 
 * 
 * 
 * 
$(document).ready(function() {
 
	$('#add').click(function(){
		      $('#what_work .element:first').clone().appendTo($('#element')).find('input').val('');
		      return false;
		   });
 
});
 */
function changeMood() {
    if ($("#type").val() == "sleep") {
        $("#sort").html("<option value='date'>Według daty</option><option value='hour'>Według Godziny</option><option value='longMood'>Według długości trwania snu</option>")
        $(".typeMood").prop('disabled', true);
        $(".typeSleep").prop("disabled",false);
        $(".mooddd").text("snu");
    }
    else {
        $("#sort").html("<option value='date'>Według daty</option><option value='hour'>Według Godziny</option><option value='mood'>Według nastroju</option><option value='anxiety'>Według lęku</option><option value='nervousness'>Według zdenerwowania</option><option value='stimulation'>Według pobudzenia</option><option value='longMood'>Według długości trwania nastroju</option>")
        $(".typeMood").prop('disabled', false);
        $(".mooddd").text("nastroju");
        $(".typeSleep").prop("disabled",true);
    }
    
}
function showDescription(url,id,i) {
    
        $("#showDescription"+i).toggle();
        $("#showDescription"+i).load(url + "?id=" + id);
    
}


    function showDescriptionDrugs(i,url,id) {
        //$("#show_description"+i)
        //if (!$("#show_description"+i)) {
        //alert("d");
            $("#show_descriptionDrugs"+i).toggle();
            $("#show_descriptionDrugs"+i).load(url + "?id=" + id);
        //}
        //else {
          //  $("#show_description"+i).hide();
        //}
        
        
    }


function deleteMood(url,id,i) {
    var con = confirm("Czy na pewno usunąć");
    
    if (con == true) {
        $(".idMood"+i).load(url + "?id=" + id).remove();
    }

}
function deleteSleep(url,id,i) {
    var con = confirm("Czy na pewno usunąć");
    
    if (con == true) {
        //alert(id);
        $(".idMood"+i).load(url + "?id=" + id);
    }
}





$(document).ready(function(){
    $("#hideActions").keyup(function(){
        //alert(id);
        //var id = $(".t").attr('id');
        if ($("#hideActions").val() == "") {
            $('.Action___' ).show();
            //$("#" + id).show();
            return;
        }
        
        
        
        $('.Action___' ).not(".selected").hide();
        
        //alert(id);
        //$("#" + id).hide();
        var val = $.trim($("#hideActions" ).not(".selected").val());
        //var val2 = $.trim($("#hideActions" ).not(".selected").val().toUpperCase());
        val = "a:contains("+val+")";
        //val2 = "a:contains("+val2+")";
        $( val ).show();
        //$( val2 ).show();
    //alert(actionList.length);
    });
});




var boolPercent = [];
function loadInputPercent(id) {
    
    if (boolPercent.indexOf(id) != -1) {
            var i = boolPercent.indexOf(id);
            boolPercent.splice(i);
            $( "#div_" + id ).remove();
    }
    else {
            boolPercent.push(id);
            $("#rt" + id).html("<div class='Action___Div' id='div_" + id + "' style='clear: both; float: left; padding-left: 50%;'><input type='number' min='1' max='100' name='int_[]' class='form-control' style='width: 70px;'></div>");

    }
}