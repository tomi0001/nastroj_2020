var actionList = [];
var actionList2 = [];


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


$(document).ready(function(){
    $(".Action___2").click(function(){
     if (getNumber($(this).attr("id"),actionList2)) {
        actionList2.remove2($(this).attr("id"));
        $(this).css("background-color","transparent");
        $(this).css("border-radius",'0px');
        $(this).css("color","#4288BA");
    }
    else {
        actionList2.push($(this).attr("id"));
        $(this).css("background-color","#95721F");
        $(this).css("border-radius",'30px');
        $(this).css("color","white");
    }
    //alert(actionList.length);
    });
});
Array.prototype.remove2=function(s){
                        for(i=0;i<actionList2.length;i++){
                           //alert(actionList[i]);
                           if(s==actionList2[i]) actionList2.splice(i, 1);
                           //alert(actionList[i]);
                        }
                }
                



function switchVisibleMoodDobule(array,bool = 0) {
    switchVisibleMood();
    if (bool == 1) {
        switchVisibleMoodShow(1);
    }
    else {
        for (i=0;i < array.length;i++) {
            if (array[i] == 1) {
                switchVisibleMood();
            }
            else if (array[i] == 2) {
                switchVisibleMoodShow();
            }
        }
    }
}

function switchVisibleMood() {

    if ($("[name='type']").val() == "mood") {
        $("#moodAction").css("display","none");
        $("#moodAdd").css("display","inline");
        $("#SleepAdd").css("display","none");
    }
    else if ($("[name='type']").val() == "action"){  
        $("#moodAdd").css("display","none");
        $("#moodAction").css("display","inline");
        $("#SleepAdd").css("display","none");
    }
    else {
        $("#moodAdd").css("display","none");
        $("#moodAction").css("display","none");
        $("#SleepAdd").css("display","inline");
    }
}
var ifMood = "mood";


function idMood(mood) {
    if (mood == ifMood) {
        return "selected";
    }
}

function switchVisibleMoodShow(bool = 0) {
    if (bool == 1) {
        $("#actionShow").css("display","inline");
        $("#moodShow").css("display","none"); 
        ifMood = "action";
    }
    else if ($("[name='typeMood']").val() == "mood") {
        $("#actionShow").css("display","none");
        $("#moodShow").css("display","inline");        
        ifMood = "mood";
    }
    else if ($("[name='typeMood']").val() == "action"){  
        $("#actionShow").css("display","inline");
        $("#moodShow").css("display","none");   
        ifMood = "action";
    }
    
}
var arraySetting = ["settingAction","levelMood","changeNameAction","changeDateAction"];
var arraySetting2 = ["settingPosition_1","settingPosition_2","settingPosition_3","settingPosition_4"];
function switchSetting(id = "settingAction",id2 = "settingPosition_1") {
    for (i=0;i < arraySetting.length;i++) {
        if (id == arraySetting[i]) {
            $("#" + id).css("display","inline");
            $( "#" + id2).addClass("settingPositionSelected");
            
        }
    
    }
    setNone(id);
}
function addActionSearch() {
    //alert("ss");
    $("#actionSearch").append("<div style='float: left; width: 40%;'><input type='text' name='actions[]' class='form-control' placeholder='nazwa'></div><div style='float: left; width: 29%; padding-left: 20px;' ><input type='text' name='actionsNumberFrom[]' class='form-control' placeholder='wartość od'>                           </div><div style='float: right; width: 25%;' ><input type='text' name='actionsNumberTo[]' class='form-control' placeholder='wartość do'></div>");
    
    //$("#what_work").append($("#what_work4").html());
}


var arraySettingSearch = ["mainSearch","SearchSleep","averageMood","howHourMood","PDF"];
var arraySettingSearch2 = ["settingPosition_1","settingPosition_2","settingPosition_3","settingPosition_4","settingPosition_5"];
function switchSettingSearch(id = "mainSearch",id2 = "settingPosition_1") {
    
    for (i=0;i < arraySettingSearch.length;i++) {
        if (id == arraySettingSearch[i]) {
            $("#" + id).css("display","inline");
            $( "#" + id2).addClass("settingPositionSelected");
            
        }
    
    }
    setNone2(id);
}
function editSleep(url,i,id) {
    $("#sleepEdit"+i).load(url + "?id=" + id + "&i=" + i).toggle();
}
function editSleepAction(url,id,i) {
    var sleep = $("#sleep" + i).val();
    $("#viewEditSleep2"+i).load(url + "?id=" + id + "&sleep=" + sleep);
}
function setNone2(id) {
    
    for (var i=0;i < arraySettingSearch.length;i++) {
        
        if (id != arraySettingSearch[i]) {
            $("#" + arraySettingSearch2[i]).removeClass("settingPositionSelected").addClass("settingPosition");
            $("#" + arraySettingSearch[i]).css("display","none");
        }
    }
}


function setNone(id) {
    
    for (var i=0;i < arraySetting.length;i++) {
        
        if (id != arraySetting[i]) {
            $("#" + arraySetting2[i]).removeClass("settingPositionSelected").addClass("settingPosition");
            $("#" + arraySetting[i]).css("display","none");
        }
    }
}


function loadActionChange(url) {
    $("#changeNameActionForm").load(url + "?" + $("form").serialize());
}

function loadActionDateChange(url) {
    $.ajax({
    url : url,
        method : "get",
        data : 
          $("form").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#changeNameActionDateForm").val(response);
    var tags = $.parseJSON( response );
    //alert(response);
    $("#dateStart").val(tags.date_start);
    $("#dateEnd").val(tags.date_end);
    $("#timeStart").val(tags.time_start);
    $("#timeEnd").val(tags.time_end);
    
    $("#longer").val(tags.longer);
    if (tags.if_all_day == 1) {
        $("#if_all_day").prop('checked',true);
    
    }
    else {
        $("#if_all_day").prop('checked',false);
    }
    makeSelect(tags);
    
})
.fail(function() {
    $("#form3").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
}
function makeSelect(response) {
    var select;
    for (i=0;i < response.count;i++) {
        if (response[i].id2 == response.id_actions) {
            select += "<option value='" + response[i].id2 + "' selected>" + response[i].name2 + "</option>";
        }
        else {
            select += "<option value='" + response[i].id2 + "'>" + response[i].name2 + "</option>";
        }
    }
    $("#idAction").html(select);
}
function changeNameAction(url) {
    $("#changeNameActionForm2").load(url + "?" + $("form").serialize());
}

function changeNameDateAction(url) {
    $("#changeNameDateActionForm2").load(url + "?" + $("#form4").serialize());
}
function SettingchangeLevelMood(url) {
       $.ajax({
    url : url,
        method : "get",
        data : 
          $("form").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#form1").html(response);
    if (response == "") {
        $("#form1").html("<div class='ajaxSucces'>Pomyślnie zmodyfikowano</div>");
    }
    
})
.fail(function() {
    $("#form1").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
  
}


function LoadPage(url) {
    window.location.replace(url);
}

function addAction(url) {
    $("#form4").find(":hidden").filter("[name!='idAction']").remove();


    changeArrayAtHidden2(4);
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
function addSleep(url) {
    



    
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
          $("#form6").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#form5").html(response);
    if (response == "") {
        setInterval("reload();",4000);
        $("#form5").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
    }
    
})
.fail(function() {
    $("#form5").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
    

}
function addMood(url) {
    //alert(actionList.length);
    

$("#form2").find(":hidden").filter("[name!='idAction']").remove();


    changeArrayAtHidden(2);
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
function runScriptAddActionMood(e,url) {
    
    if (e.keyCode == 13) {
        
        addAction(url);
        eval(tb.value);
        return false;
    }
}
function runScriptEditMood(e,url,id,i) {
    if (e.keyCode == 13) {
        
        editMoodAction(url,id,i);
        eval(tb.value);
        return false;
    }
}
function runScriptEditSleep(e,url,id,i) {
    if (e.keyCode == 13) {
        
        editSleepAction(url,id,i);
        eval(tb.value);
        return false;
    }
}
function runScriptSettingAddAction(e,url) {
    //See notes about 'which' and 'key'
    if (e.keyCode == 13) {
        addActionSetting(url);
        eval(tb.value);
        return false;
    }
}
function runScriptSettingchangeLecelMood(e,url) {
    if (e.keyCode == 13) {
        SettingchangeLevelMood(url);
        eval(tb.value);
        return false;
    }
}

function runScriptSleepAdd(e,url) {
    if (e.keyCode == 13) {
        addSleep(url);
        eval(tb.value);
        return false;
    }
}

function addActionSetting(url) {
   $.ajax({
    url : url,
        method : "get",
        data : 
          $("form").serialize()
        ,
        dataType : "html",
})
.done(function(response) {
    $("#form").html(response);
    if (response == "") {
        $("#form").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
    }
    
})
.fail(function() {
    $("#form").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
})
    
}
function calendarOn(id) {
    $("#" + id).addClass("cell_selected");
}
function calendarOff(id) {
    $("#" + id).removeClass("cell_selected");
}
function reload() {
    location.reload();
    deleteArray();
}
function changeArrayAtHidden(z) {
    for (i=0;i < actionList.length;i++) {
        if (isIst(actionList[i])) {
            $("#form" + z).append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList[i] + " class=\'form-control typeMood\'>");
        }
    }
}
/*
function changeArrayAtHiddenAction() {
    for (i=0;i < actionList.length;i++) {
        if (isIst(actionList[i])) {
            $("#form ").append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList[i] + " class=\'form-control typeMood\'>");
        }
    }
}
 * 
 */
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

function changeArrayAtHidden2(z) {
    for (i=0;i < actionList2.length;i++) {
        if (isIst2(actionList2[i])) {
            $("#form" + z).append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList2[i] + " class=\'form-control typeMood\'>");
        }
    }
}
/*
function changeArrayAtHiddenAction() {
    for (i=0;i < actionList.length;i++) {
        if (isIst(actionList[i])) {
            $("#form ").append("<input type=\'hidden\' name=\'idAction[]\' value=" + actionList[i] + " class=\'form-control typeMood\'>");
        }
    }
}
 * 
 */
function isIst2(id) {
    if (actionList2.length == 0) {
        return false;
    }
    for (i=0;i < actionList2.length;i++) {
        if (actionList2[i] == id) {
            return true;
            
        }
    }
    return false;
}
function deleteArray2() {
    $("#parentsAction").children().css("background-color","transparent").css("border-radius",'0px').css("color","#4288BA");
    for (i=0;i < actionList2.length;i++) {
        //
        actionList2.splice(i, 1);
        
    }
}

function showAction(url,i,id) {
    $("#showActions"+i).load(url + "?id=" + id).toggle();
    //$("#showActions"+i).text("sss");
}