/**
 * Created by Simon
 */


$(document).ready(function(){
	console.log("VLALA");
//	var keys = $('#inboxTable').yiiGridView('getSelectedRows');
//	alert(keys);
})

$("#inboxTable").contents().find(":checkbox").bind('change', function(){        
        alert("changed to:" +this.value);
});