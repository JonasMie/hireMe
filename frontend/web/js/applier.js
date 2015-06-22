
$( document ).ready(function() {
	
	/* ApplyBtn Specific */
	var key = $("#ac").attr('name');
	var html = '<iframe src="http://bewerbung.local/job/view-count" width="0" height="0" id="hireMeFrame" scrolling="no" frameBorder="0" name="'+key+'">';
	$("#ac").html(html);
	$("#ac").append("<button id='applyBtn'>APPLY</button>");
	var btn = $( "#ac" ).children()[1];

	console.log(btn);

	$(document).on('ready' ,function()  { 
   		
   		 $('#hoverInfo').hide();
		
	});
	
	/* Center Popup Window on (Dual)Screen */
	function PopupCenter(url, title, w, h) {
		
	}
	
	$(document).on('click', '#applyBtn', function(){ 
    
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
	
	
	/*window.open("http://bewerbung.local/job/button-popup?key="+key+"", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, width=400, height=400");*/
    
	
	});

});
















