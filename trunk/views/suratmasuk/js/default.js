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

$(this).ready(function(){
   $("#alamat").autocomplete({
      minLength:1,
      source:
          function(req, add){
          $.ajax({
              url:"<?php echo URL; ?>helper/alamat",
              dataType:'json',
              type:'POST',
              data:req,
              success:
                  function(data){
                  if(data.response==true){
                      add(data.message);
                  }
                  },
          });
          },
          select:
              function(event,ui){
              $("#result").append(
                    "<li>"+ui.item.value+"</li>"
                );
              },
   });
   
   });