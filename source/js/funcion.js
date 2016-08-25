function Countdown ()
{
	this.start_time = "1:00";
	this.target_id = "#time";
	this.name = "timer";
}
Countdown.prototype.init = function()
{
	this.reset();
}
Countdown.prototype.reset = function()
{
	tim = setInterval(this.name + '.tick()', 1000);
	time = this.start_time.split(":");
	this.minutes = parseInt(time[0]);
	this.seconds = parseInt(time[1]);
	this.update_target();
}
Countdown.prototype.tick = function()
{
	if(this.seconds>0 || this.minutes>0)
	{
		if(this.seconds == 0)
		{
			this.minutes=this.minutes-1;
			this.seconds = 59;
		}
		else {
			this.seconds = this.seconds -1;
		}
		this.update_target();
	}
	else {
		if (this.minutes == 0 && this.seconds == 0) {
			var tokenC = $('#_token').val();
			$.ajax({
        type:"post",
        url: "/deletepunt",
        headers: {'X-CSRF-TOKEN': tokenC},
        success: function(resp)
        {
          if(resp!="")
          {

          }
        },
        error: function(data)
        {
        }
      });
			window.location.href = '/end';
			this.seconds = -1;
		}
	}
}
Countdown.prototype.update_target = function()
{
	seconds = this.seconds;
	if(seconds == 8)
	{
		var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'sounds/343130__inspectorj__ticking-clock-a.wav');
        audioElement.setAttribute('autoplay', 'autoplay');
    }
	if(seconds < 10) seconds = "0" + seconds;

	$(this.target_id).html("  <img src='img/pje1.png' class='picTime'> <h2 id ='timer'>" + this.minutes + ":" + seconds +"</h2>");

}
Countdown.prototype.restart = function()
{
	if (tim) {
      clearInterval(tim);
    }
}
