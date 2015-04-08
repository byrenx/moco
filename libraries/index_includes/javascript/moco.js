/**
login script validation

*/
function loadOfferedCourses(ctype){
 window.location = "Courses.php?course="+ctype;
}


$(function(){
     $('#accordion').accordion();
    });


function validateAccountInput(){
  var uname = $('#uname').val();
  var pword = $('#password').val();
  
  if(uname.length<1 && pword.length<1){
    alert("Please Enter username and Password");
    return false;
  }else if(uname.length<1){
    alert("Please Enter Username");
    return false;
  }else if(pword.length<1){
    alert("Please Enter Password");
    return false;
  }else{
    return true;
  }
}



/*****************************
*
* quiz script 
*
*****************************/

function addQuiz(frm_src){
  /*
  * frm_src -> source form id where to get the inputs
  * 
  *
  * postconsdition:
  *    calls the ajax script and receive response string
  *    if response is 'ok' then
  *       add quiz element in the quiz page
  *    else display error
  */
  var server = '';
  //var response=connectToServer(server, frm_src);  
  var response = "ok";  
  var ann = {"ann_id":1,
             "ann_stmt":"Sample Statement.",
             "date_posted":"12-11-12"};

  if(response=="ok"){
    
    var txt="<div id='page_dialog'>";
    txt+="<div id='hdr'>";
    txt+="<span id='hdr-title'>";
    txt+= "Quiz2";
    txt+= "</span>";
    txt+= "<span id='xbutton'>";
    txt+= "<a href='#' title='Delete this quiz'>";
    txt+= "<img src='../../libraries/themes/icons/close.png'>";
    txt+= "</a>";
    txt+= "</span>";
    txt+= "</div>";
    //end-header
            
    //dialog-content
    txt+= "<div id='pg-diag-content'>";
    txt+= "Total Items: {$q['items']} </br>";
    txt+= "Due Date: "+ann.date_posted+"</br>";
    txt+= "Date Available: 12/12/12 </br>";
    txt+= "</br>";
    txt+= "<form action='#' method='post'>";
    txt+= "<input type='hidden' id='q_id' value=''>";
    txt+= "<input type='hidden' id='q_name' value=''>";
    txt+= "<input type='hidden' id='dd' value=''>";
    txt+= "<input type='hidden' id='da' value=''>";
    txt+= "<input type='button' name='edit' value='Edit'>";
    txt+= "<input type='button' name='view' value='View'>";
    txt+= "</form>";
    txt+= "</div>";
    $('#sub-content').append(txt);
  }else{

  }
}

function removeQuiz(frm_src){
  
  var c = confirm("If you press ok this quiz will be permanently deleted.\n Are you sure to delete this quiz?");
  alert(frm_src);
  if(c)
   $("."+frm_src).remove();

}

/********************************
*  announcement script 
*
********************************/

//add new announcement
//display add announcement dialog form
function showAddAnnDg(popup_bg,popup_div){
  $('#addann #action').val('add');

  $('#addann #icr_id').val($('#addfrm #icr_id').val());
  showpopup_form(popup_bg,popup_div);
}

function showEnrollDg(popup_bg,popup_div,formID){
    $("#CK #scr_id").val(formID);
    $("#CK #SCK").val(formID);
  showpopup_form(popup_bg,popup_div);
}

function confirmKey(form_id){ 


    var url = "../../libraries/php/executeAction.php";
    var ajax = ajaxCreate();

    var str_inputs = getformVal(form_id);
    var response = null;
    ajax.open("POST", url); // this is needed enable for $_POST array in php to acces form elements inputs

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    
    ajax.onreadystatechange = function(){
	if(ajax.readyState == 4 && ajax.status == 200){
	    response = new String (ajax.responseText).trim();
	    if(response=='ok'){
		window.location = "Course_Dashboard.php";

	    }else if(response=='invalid'){
		$('#feedback').text("You have Entered an Invalid Coursekey!");
	    }else{
		window.location = "Course_Dashboard.php";
		}
	    
	}
    }
    ajax.send(str_inputs);

}


function showUnEnrollDg(popup_bg,popup_div,formID){
    $("#UN #scr_id").val(formID);
    $("#UN #SCK").val(formID);
  showpopup_form(popup_bg,popup_div);
}
//edit and delete announcement handler

function showUpdateDelAnnDg(popup_bg,popup_div,frmid){
 
 var ann_id = $('#'+frmid+' #ann_id').val();
 var ann_stmt = $('#'+frmid+' #ann_stmt').val();
 var action = $('#'+frmid+' #action').val();

 $('#addann #action').val(action);
 $('#addann #ann_id').val(ann_id);
 $('#addann #ann_stmt').val(ann_stmt);

 
 if(action=='del'){
   var conf=confirm("Are you sure to delete this announcement?");
   if(conf){
     
   }
 }else{
   showpopup_form(popup_bg,popup_div);
 }

}

function addUpdateAnnouncement(frm_id){
  
  var url = "../../libraries/php/executeAction.php";
  var action = $('#'+frm_id+' #action').val();
  var ann_id = $('#'+frm_id+' #ann_id').val();
  //window.location = "../classes/add_announcement.php";                     
  var ajax = ajaxCreate();
    
  var str_inputs = getformVal(frm_id);
  var response_text = "sample";
  
  
  ajax.open("POST", url);
    //this is needed enable for $_POST array in php to access form elements input
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
  ajax.onreadystatechange = function(){
     if(ajax.readyState == 4 && ajax.status == 200){
        if(action=='add'){   
          $('#sub-content').append(ajax.responseText);
        }else if(action=='edit'){
          $('.'+ann_id).html(ajax.responseText);      
        }
     }                             
  }
  ajax.send(str_inputs);
}

function delAnn(div_annid, form_id){
  var url = "../classes/add_announcement.php";
  var ajax = ajaxCreate();
    
  var str_inputs = getformVal(frm_id);
              
  ajax.open("POST", url);
    //this is needed enable for $_POST array in php to access form elements input
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
  ajax.onreadystatechange = function(){  
    if(ajax.readyState == 4 && ajax.status == 200){ 
       if(ajax.responseText=='ok'){
         $('#sub-content').remove('.'+div_annid); 
       }
    }                           
  }
  ajax.send(str_inputs);
}

/************************************
** course lecture ajax script
*************************************/

function addLecture(frm_id){
  var lect_con_id=$('#topic').val(); //container of lecture 

  var url = "../classes/add_lect.php";
  
  var ajax = ajaxCreate();
    
  var str_inputs = getformVal(frm_id);
  var response_text = null;
              
  ajax.open("POST", url);
    //this is needed enable for $_POST array in php to access form elements input
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
  ajax.onreadystatechange = function(){  
    if(ajax.readyState == 4 && ajax.status == 200){ 
      $('#'+lect_con_id+' table').append(ajax.responseText);
    }                           
  }
  ajax.send(str_inputs);
}

function addLectMat(frm_id){
  var lect_con_id=$('#topic').val(); //container of lecture 

  var url = "../classes/add_lect.php";
  
  var ajax = ajaxCreate();
    
  var str_inputs = getformVal(frm_id);
  var response_text = null;
              
  ajax.open("POST", url);
    //this is needed enable for $_POST array in php to access form elements input
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
  ajax.onreadystatechange = function(){  
    if(ajax.readyState == 4 && ajax.status == 200){ 
      $('#'+lect_con_id+' table').append(ajax.responseText);
    }                           
  }
  ajax.send(str_inputs);
}


/*
* syllabus scripots here
* this segment are javascript functions
* which is used by syllabus page in instructor module
* some of the functions is using  ajax
* for chaning data in the database,
* while other functions are used for 
* UI interactions
*/

function add_main_topic(frm_id){
  /*
  * postcondition: add new main topic to a course
  *                then add new row to a syllabus table
  */
  
  var url = "../classes/add_main_topic.php";//server page
  var ajax = ajaxCreate();//initializa and create ajax request
    
  var str_inputs = getformVal(frm_id);
  var response_text = null;
              
  ajax.open("POST", url);
    //this is needed enable for $_POST array in php to access form elements input
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
  ajax.onreadystatechange = function(){  
    if(ajax.readyState == 4 && ajax.status == 200){ 
      response_text = ajax.responseText;
      if(response_text=="err"){
        //show alert message with no changes to the mode
        alert("Unable to add topic that already exists in your syllabus");
      }else{
        $('#mode').val('add');//set to default the mode of topic
        $('#syllabus-table').append(ajax.responseText);//append the new topic to syllabus table
      }
    }                           
  }
  ajax.send(str_inputs);
}

function topicEditMode(id, val){
  $('#mode').val('edit');//set mode to edit
  $('#topic-id').val(val);//set the id of topic to be modified
  $('#topic-title').val(val);//show the topic title to be modified
  $('#topic-title').focus();
}

function deleteTopic(id, val, r_id){
  //precondition: id -> the id of the topic to deleted both in the database and in the table(UI)
  //              val -> the topic title to be deleted from the table
  //              r_id -> id of a row to be remove from the table
  //postcondition: remove the topic both in the database and in the table(UI)
  var response = confirm('Are you sure to delete \"'+val+'"?');
  
  if(response==true){
    //delete from database
    //and remove the row from the table
    $(r_id).remove();
  }
   
}
