$(document).ready(function(){
  $( ".encorefois" ).click(function() {
  var tokenC = $('#_token').val();

  $.ajax({
    type:"post",
    url: "/encorefois",
    headers: {'X-CSRF-TOKEN': tokenC},
    success: function(resp)
    {
      if(resp!="")
      {
        $( document ).ajaxStop();
        $('#jouer').html(resp);
      }
    },
    error: function(data)
    {
    }
    });
  });
});
