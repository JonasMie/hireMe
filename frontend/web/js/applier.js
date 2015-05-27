
$( document ).ready(function() {

	var key = $("#ac").attr('name');
	var html = '<iframe src="http://frontend/job/view-count" width="0" height="0" id="hireMeFrame" scrolling="no" frameBorder="0" name="'+key+'">';
	$("#ac").html(html);
	$("#ac").append("<button id='applyBtn' onclick='clicked();'>APPLY</button>");
	$("#ac").append('<div style="width:400px; height:400px; border:1px solid;" id="hoverInfo"><iframe id="hoverInfoFrame" src="http://frontend/job/button-popup" width="400" height="400" scrolling="no" frameBorder="0" name="'+key+'"></div>');
	var btn = $( "#ac" ).children()[1];

	console.log(btn);

	$(document).on('ready' ,function()  { 
   		
   		 $('#hoverInfo').hide();
		
	});

});

$(document).on('mouseenter', '#applyBtn', function(){ 
     
     $('#hoverInfo').show();
     
 });

$(document).on('mouseleave', '#hoverInfoFrame', function(){ 
     
     $('#hoverInfo').hide();
     
 });














