function Validador(email) {
    var tester = /^([a-zA-Z0-9_.+-])*\@(([misena-sena]+)\.)+([edu])+\.([co])+$/;
    return tester.test(email);
}
function Validar(){
  var nombre = document.getElementById('nombre').value;
  var email = document.getElementById('email').value;
  var contra1 = document.getElementById('psw1').value;
  var reg = document.getElementById('Reg').value;
  var reg2 = $( "#Reg option:selected" ).text();
  var rol = document.getElementById('selectt').value;
  var contra2 = document.getElementById('ps2').value;
  if (nombre == "") {
    $('#alert').html('Ingresa tu nombre').slideDown(500);
    $('#nombre').focus();
    return false;
} else {
    $('#alert').html('').slideUp(300);
}
  if (nombre.length < 3) {
    $('#alert').html('Minimo 3 Caracteres').slideDown(500);
    $('#nombre').focus();
    return false;
} else {
    $('#alert').html('').slideUp(300);
}
if (email == "") {
  $('#alert').html('Ingresa tu correo').slideDown(500);
  $('#email').focus();
  return false;
} else {
  $('#alert').html('').slideUp(300);
}
if (Validador(email) == false) {
  $('#alert').html('Ingresa un correo válido').slideDown(500);
  $('#email').focus();
  return false;
} else {
  $('#alert').html('').slideUp(300);
}

if (contra1 == "") {
  $('#alert').html('Ingresa una contraseña').slideDown(500);
  $('#psw1').focus();
  return false;
  } else {
  $('#alert').html('').slideUp(300);
  }

  if (contra1.length <= 5) {
    $('#alert').html('Minimo 6 caracteres').slideDown(500);
    $('#psw1').focus();
    return false;
    } else {
    $('#alert').html('').slideUp(300);
    }

    if (contra2 == "") {
      $('#alert').html('Ingresa una contraseña').slideDown(500);
      $('#ps2').focus();
      return false;
      } else {
      $('#alert').html('').slideUp(300);
      }

      if (contra1 != contra2) {
        $('#alert').html('Las contraseñas no coinciden').slideDown(500);
        $('#psw2').focus();
        return false;
    } else {
        $('#alert').html('').slideUp(300);
    }
    if(reg2 == "Seleccione Su Regional")
    {
        $('#alert').html('Selecciona tu Regional').slideDown(500);
        return false;
    }
    else {
      $('#alert').html('').slideUp(300);
    }
    if(rol == "seleccione")
    {
        $('#alert').html('Selecciona tu Rol').slideDown(500);
        return false;
    }
    else {
      $('#alert').html('').slideUp(300);
    }
}


function Validar2()
{
  var email = document.getElementById('email').value;
  var contra1 = document.getElementById('password').value;
  if (email == "")
  {
    $('#alert1').html('Ingresa tu correo').slideDown(500);
    $('#email').focus();
    return false;
  }
  else
  {
    $('#alert1').html('').slideUp(300);
  }
  if (Validador(email) == false)
  {
    $('#alert1').html('Ingresa un correo válido').slideDown(500);
    $('#email').focus();
    return false;
  }
  else
  {
    $('#alert1').html('').slideUp(300);
  }
  if (contra1 == "")
  {
    $('#alert1').html('Ingresa una contraseña').slideDown(500);
    $('#password').focus();
    return false;
  }
  else
  {
    $('#alert1').html('').slideUp(300);
  }
  if (contra1.length <= 5)
  {
    $('#alert1').html('Minimo 6 caracteres').slideDown(500);
    $('#password').focus();
    return false;
  }
  else
  {
    $('#alert1').html('').slideUp(300);
  }
}
