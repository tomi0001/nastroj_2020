var actionList = [];


$(document).ready(function(){
    $(".Action___").click(function(){
     if (getNumber($(this).attr("id"),actionList)) {
        actionList.remove($(this).attr("id"));
        $(this).css("background-color","transparent");
        $(this).css("border-radius",'0px');
        $(this).css("color","#4288BA");
    }
    else {
        actionList.push($(this).attr("id"));
        $(this).css("background-color","#95721F");
        $(this).css("border-radius",'30px');
        $(this).css("color","white");
    }
    //alert(actionList.length);
    });
});
Array.prototype.remove=function(s){
                        for(i=0;i<actionList.length;i++){
                           //alert(actionList[i]);
                           if(s==actionList[i]) actionList.splice(i, 1);
                           //alert(actionList[i]);
                        }
                }
                
const getNumber = function ( num, arr ) {
    return arr.includes( num );
}
function switchVisibleMood() {
    if ($("[name='type']").val() == "mood") {
        $("#moodAction").css("display","none");
        $("#moodAdd").css("display","inline");
    }
    else {  
        $("#moodAdd").css("display","none");
        $("#moodAction").css("display","inline");
    }
}

function addAction(url) {
    $("#form4").find(":hidden").filter("[name!='idAction']").remove();


    changeArrayAtHiddenAction();
    //alert($("form").serialize());
    
    //$('form')[0].reset();
    //$('#form2')[0].reset();
//    document.getElementById("form2").reset();
/*
    $("#form").load(url + "?" + $("#form2").serialize());
    if ($("#form").text() == "") {
        setInterval("reload();",4000);
    }
    alert($("#form").val());
    
    //alert("dd");
    

*/

$.ajax({
    url : url,
        method : "get",
        data : 
          $("#form4").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#form3").html(response);
    if (response == "") {
        setInterval("reload();",4000);
        $("#form3").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
    }
    
})
.fail(function() {
    $("#form3").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
    
}

function addMood(url) {
    //alert(actionList.length);
    

$("#form2").find(":hidden").filter("[name!='idAction']").remove();


    changeArrayAtHidden();
    //alert($("form").serialize());
    
    //$('form')[0].reset();
    //$('#form2')[0].reset();
//    document.getElementById("form2").reset();
/*
    $("#form").load(url + "?" + $("#form2").serialize());
    if ($("#form").text() == "") {
        setInterval("reload();",4000);
    }
    alert($("#form").val());
    
    //alert("dd");
    

*/

$.ajax({
    url : url,
        method : "get",
        data : 
          $("#form2").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#form").html(response);
    if (response == "") {
        setInterval("reload();",4000);
        $("#form").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
    }
    
})
.fail(function() {
    $("#form").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
    

}



function runScript(e,url) {
    //See notes about 'which' and 'key'
    if (e.keyCode == 13) {
        addMood(url);
        eval(tb.value);
        return false;
    }
}


function reload() {
    location.reload();
    deleteArray();
}
function changeArrayAtHidden() {
    for (i=0;i < actionList.length;i++) {
        if (isIst(actionList[i])) {
            $("#form2").append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList[i] + " class=\'form-control typeMood\'>");
        }
    }
}
function changeArrayAtHiddenAction() {
    for (i=0;i < actionList.length;i++) {
        if (isIst(actionList[i])) {
            $("#form4").append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList[i] + " class=\'form-control typeMood\'>");
        }
    }
}
function isIst(id) {
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
function deleteArray() {
    $("#parentsAction").children().css("background-color","transparent").css("border-radius",'0px').css("color","#4288BA");
    for (i=0;i < actionList.length;i++) {
        //
        actionList.splice(i, 1);
        
    }
}