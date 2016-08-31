<html>
<body onLoad="timer()">
   <div id="contador"></div>
     <script language="javascript">
    function timer(){
		var t=setTimeout("timer()",1000);
		document.getElementById('contador').innerHTML = 'Tiene '+i--+" segundos";
		if (i==-1){
			document.getElementById('contador').innerHTML = 'Su tiempo ha acabado';
			clearTimeout(t);
      alert('perdio');
		}

	}
	i=2;


    </script>
</body>
</html>
