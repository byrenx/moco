function mpcq_preview(){
   var q = $("#mpcq").val();
   q = strip_script(q);
   $("#mpcq_preview").html(q);
   MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
   return true;
}

function preview(src, target){
    var q = $(src).val();
    q = strip_script(q);
    $(target).html(q);
    MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
    return true;
}
