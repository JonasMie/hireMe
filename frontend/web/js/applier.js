//thanks to http://www.sitepoint.com/dynamically-load-jquery-library-javascript/
function loadScript(url, callback) {
 
	var script = document.createElement("script")
	script.type = "text/javascript";

	if (script.readyState) { //IE
		script.onreadystatechange = function () {
			if (script.readyState == "loaded" || script.readyState == "complete") {
				script.onreadystatechange = null;
				callback();
			}
		};
	} else { //Others
		script.onload = function () {
			callback();
		};
	}

	script.src = url;
	document.getElementsByTagName("head")[0].appendChild(script);
}
/* thanks finished*/

loadScript("http://code.jquery.com/jquery-1.11.3.min.js", function () {

	loadScript("http://code.jquery.com/jquery-migrate-1.2.1.min.js", function () {
		console.log("jquery loaded");
		
		/* Apply Button */

		var key = $("#ac").attr('name');
		var html = '<iframe src="http://bewerbung.local/job/view-count" width="0" height="0" id="hireMeFrame" scrolling="no" frameBorder="0" name="'+key+'">';
		$("#ac").html(html);
		$("#ac").append("<span title='Mit hireMe bewerben' alt='Mit hireMe bewerben' id='applyBtn' class='ripple'><img src='http://bewerbung.local/images/button/hireMe-Button-1-transp.png' witdh='50'></span>"); // ToDo: jquery tooltip http://www.codechewing.com/library/create-simple-tooltip-jquery/
		$("#applyBtn").css({"width":"50px","height":"50px","cursor":"pointer"});
		$('#applyBtn').css({"background-size":"cover"});
		/* On-Page Hover Modal
		$("#ac").append('<div style="width:400px; height:400px; border:1px solid;" id="hoverInfo"><iframe id="hoverInfoFrame" src="http://bewerbung.local/job/button-popup?key='+key+'" width="400" height="400" scrolling="no" frameBorder="0" name="'+key+'"></div>');
		*/
		var btn = $( "#ac" ).children()[1];
		console.log(btn);
		/* On-Page Hover Modal
		$('#hoverInfo').hide();
		$(document).on('click', '#applyBtn', function(){  $('#hoverInfo').show();});
		$(document).on('mouseleave', '#hoverInfoFrame', function(){  $('#hoverInfo').hide();  });
		*/
		/* END Apply Button */

		/* Center Popup Window on (Dual)Screen */

		$(document).on('click', '#applyBtn', function(){ 
			var key = $("#ac").attr('name');
			//httpReq("http://bewerbung.local/job/click-up?btnKey=");
			// Fixes dual-screen position
			var w = 650;
			var h = 550;
			var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
			var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

			width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
			height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

			var left = ((width / 2) - (w / 2)) + dualScreenLeft;
			var top = ((height / 2) - (h / 2)) + dualScreenTop;
			var newWindow = window.open('http://bewerbung.local/job/button-popup?key='+key+'','_blank', 'toolbar=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

			// Puts focus on the newWindow
			if (window.focus) {
				newWindow.focus();
			}
			
			
			
		});


	});
});