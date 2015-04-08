function timed(){
    $('#duration').css('display', 'block');
    $('#utt').val(1);
}

function untimed(){
    $('#duration').css('display', 'none');
    $('#utt').val(-1);
}

$("#question").keydown(function(){
    alert('asasas');
});


//validate submission
var form ={
  //variables
    msg: '',
    valid: true,
    title: null,
    date_avail: null,
    date_due: null,
    duration: null,
    type: null,
    timed: -1,
    //initialize and get the value of the fields involved
    Init: function(){
	this.title = $("#q_title").val();
	this.date_avail = $("#da").val();
	this.date_due = $("#dd").val();
	this.duration = $("#duration").val();
	this.timed = $('#utt').val();
	if($("#ttype").val()==0){
	    this.type = "Quiz";
	}else{
	    this.type = "Exam";
	}
    } ,//end of Init
    
    validate: function(){
	this.Init();
	if(emptyStr(this.title) || this.title.length<0 ){
	    this.msg += " * Type the Title of the "+ this.type + '</br>';
	    this.valid = false;
	}
	if(!isValidDateFormat(this.date_avail)){
	    this.msg += " * Enter a valid date for date available e.g 03/05/2013 </br>";
	    this.valid = false;
	}
	if(!isValidDateFormat(this.date_due)){
	    this.msg += " * Enter a valid date for due date e.g 03/05/2013 </br>";
	    this.valid = false;
	    
	}
	if(isValidDateFormat(this.date_due) && isValidDateFormat(this.date_avail)){
	    if(compDate1toDate2(this.date_due, this.date_avail)<0){
		this.msg += " * Due date must not be before date available</br>";
		this.valid = false;
		
	    }
	    if(!isLaterToday(this.date_avail)){
		this.msg += " * Date available must not be before today</br>";
		this.valid = false;
		
	    }
	    if(!isLaterToday(this.date_due)){
		this.msg += " * Due date must not be before today</br>";
		this.valid = false;
	    }
	}
	
	if(this.duration <= 0 && this.timed==1){
	    this.msg += ' * Duration must be greater than 0</br>';
	    this.valid = false;
	}

	if(this.valid==false){
	    $("#msg").removeClass()
		.addClass('alert alert-danger')
		.html('<b>You must follow the ff. validation rules(*) to add this ' + this.type + ' :</b> </br>'+this.msg);
	    this.clear();
	    return false;
	}else{
	    return true;
	}
	
    },//end of valid function,
    //clear data
    clear: function(){
	this.msg = '';
	this.valid = true;
    }
};



