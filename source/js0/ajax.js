$(document).ready(function(){

		$('#Reg').change(function(event){
    var id = $('#Reg').val();
    var tokenC = $('#_token').val();

	//Inicio Metodo envio ajax
			$.ajax({
			type: "get",
			url: "/dorpload",
			headers: {'X-CSRF-TOKEN': tokenC},
			data: {id},
			success: function(resp){
				if(resp!=""){

            for(i=0; i<resp.length; i++)
            {
              $('#centro').append("<option value='"+resp[i].id+"'> "+resp[i].name+"</option>");
            }
				}
			},
			error: function(data) {
				alert("");
			}
		});

	})
		//Fin Metodo envio ajax

		//Fin Metodo envio ajax
	});
  $(document).ready(function(){
    $( ".opcione" ).click(function() {
      var respuestas = $(this).val();
      var respuesta = $('#id_preg').val();
      var tokenC = $('#_token').val();

      $.ajax({
        type:"post",
        url: "/deletepreg",
        headers: {'X-CSRF-TOKEN': tokenC},
  			data: {respuesta,respuestas},
        success: function(resp)
        {
          if(resp!="")
          {
            if(resp == 1)
            {
                $.ajax({
                  type: "post",
                  url: "/deletepunt",
                  headers: {'X-CSRF-TOKEN': tokenC},
                  success: function(respons){
                    if(respons!=""){
                          window.location.href = 'wrong';
                    }
                  },
                  error: function(data) {
                    alert("");
                  }
                });
            }
            else {
              var view= $('#conteo').html();
              view = view+'<a href="#"><img src="img/win.png" class="lastFirst"></a>';
              $('#conteo').html(view);

              $('#game').html(resp);

            }
          }
        },
        error: function(data)
        {
        }
      });
  });
});
  $(document).on('click','.opciones',function(){
    var respuesta = $('#id_preg').val();
    var tokenC = $('#_token').val();
    var respuestas = $(this).val();
		var respuesta = $('#id_preg').val();
    $.ajax({
      type:"post",
      url: "/deletepreg",
      headers: {'X-CSRF-TOKEN': tokenC},
      data: {respuesta,respuestas},
      success: function(resp)
      {
        if(resp!="")
        {
					if(resp == 1)
					{

							$.ajax({
								type: "post",
								url: "/deletepunt",
								headers: {'X-CSRF-TOKEN': tokenC},
								data: {respuesta},
								success: function(resp){
									if(resp!=""){
												window.location.href = 'wrong';
									}
								},
								error: function(data) {
									alert("");
								}
							});
					}
					else {

							if(resp == 2)
							{
								window.location.href = 'win';
							}
							else {
								var view= $('#conteo').html();
								view = view+'<source src="sounds/preguntaCorrecta.mp3" type="audio/mp3"><a href="#"><img src="img/win.png" class="lastFirst"></a>';
								$('#conteo').html(view);
								$('#game').html(resp);
							}


					}

        }
      },
      error: function(data)
      {
      }
    });
});
$(document).ready(function(){
    $( ".ops" ).click(function() {
			var reset='<source src="sounds/preguntaCorrecta.mp3" type="audio/mp3">';
      var reset1='';
      $('#respuesta1').html(reset);
      $('#respuesta2').html(reset1);
      $('#option').html(reset1);
    });
});
$(document).ready(function(){
    $( ".verprofile" ).click(function() {
      var $row = jQuery(this).closest('tr');
      var columns = $row.data('id');
      var tokenC = $('#_token').val();
      $.ajax({
        type:"post",
        url: "/profilee",
        headers: {'X-CSRF-TOKEN': tokenC},
        data: {columns},
        success: function(resp)
        {
          if(resp!="")
          {

            $( document ).ajaxStop();
            $('#perfil').html(resp);
          }
        },
        error: function(data)
        {

        }
        });
    });
});
$(document).ready(function(){
    $( ".show" ).click(function() {
      	$('#miventana').modal('show');
    });
});
