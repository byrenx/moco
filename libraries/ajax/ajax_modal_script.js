  //global variables
  var ajax;
  var response;


  function showpopup_form(bg_div, form_div){ 
    var bgdiv = document.getElementById(bg_div);
    var formdiv = document.getElementById(form_div);

    var sw = $(window).width();//screen width
    var sh = $(window).height();//screen height
    var fw = $('#'+form_div).width();//form dialog width;
    var fh = $('#'+form_div).height();//form dialog height
    var fl = (sw-fw)/2;//dialog form left position
    var ft = (sh-fh)/2;//dialog form top position

    /*$('#'+form_div).css({
      left: fl+'px',
      top: ft+'px',
      display: 'block'
    });*/

    formdiv.style.left = fl+"px";
    formdiv.style.top = (ft-100)+"px";
    bgdiv.style.display="block"; 
    formdiv.style.display="block"; 	
  } 
  
  function hide_form(bg_div, form_div){
    var bgdiv = document.getElementById(bg_div);
    bgdiv.style.display="none";
              
    var formdiv = document.getElementById(form_div);
    formdiv.style.display="none";  
  }

  function ajaxCreate(){
    if(window.XMLHttpRequest){
      //for IE7, Firefox,Chrome, Opera, Safari
      return new XMLHttpRequest();
    }else{
      //for IE5,IE6 
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
          
  function connectToServer(server_page, form_src_id){                            
    var xmlhttp = ajaxCreate();
    
    var str_inputs = getformVal(form_src_id);
    var response_text ="sample";
              
    xmlhttp.open("POST", server_page);
    //this is needed enable for $_POST array in php to access form elements input
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");

    xmlhttp.onreadystatechange = function(){  
      alert(xmlhttp.status);
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200){ 
        alert(xmlhttp.responseText);
      }                           
    }
    xmlhttp.send(str_inputs);
  }
              
  function getformVal(form_id){ 
    var  formObj = document.getElementById(form_id);
    var str = '';
              
    for(var i = 0; i < formObj.elements.length; i++){
      str += formObj.elements[i].name + "=" + escape(formObj.elements[i].value) + "&";
    }
    //Then return the string values.
    return str;
  }
 
