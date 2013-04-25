$(function() {
    $( "#datepicker" ).datepicker();
  });

$('input:text, input:password')
  .button()
  .css({
          'font' : 'inherit',
         'color' : 'inherit',
    'text-align' : 'left',
       'outline' : 'none',
        'cursor' : 'text'
  });


$(document).ready(function(){
    $("#form-rekam").validate();
});

$(function(){
    $(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
});

