
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

function addAnnouncement(frm_src){
  alert("Im here");
  var server = "../classes/add_announ2cement.php";
  
  /*
  var ann = null;
  
  //txt response from server in JSON format
  var data = connectToServer(server, frm_src);  
  alert(data);
  if(data==null){    
     ann += "<div id='ca_ann_con' class='"+data.ann_id+"'>";
     ann += "div id='ca_date_con'>";
     ann += "<span id='ca_date_cont'>";
     ann += "Date Updated : "+data.date_posted;
     ann += "</span>";
     ann += "</div>";
     //announcement content
     ann += "<div id='ca_content'>";
     ann += data.ann_stmt;
     ann += "</div>";
     ann += "<div id='ca-edit-pane'>";
     ann += "<a href='#' class='btn btn-default'>edit</a>";
     ann += "</div>";
     ann += "</br></br>";
     ann += "</div>";

    $('#sub-content').append(ann);
  }*/
  
}

/* Modified True or False Pick other 

function showOtherItem(inputID){
    $('#'+inputID).css('visibility', 'visible');
    $('#'+inputID).focus();
    $('#'+inputID).attr('required', 'true');    
}
function hideOtherItem(inputID){
    $('#'+inputID).css('visibility', 'hidden');
    $('#'+inputID).attr('required', 'false');        
}
*/
