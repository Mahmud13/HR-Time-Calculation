$(document).ready( function(){
		var scrollToElement = $("#leaveTable");
		$(window).scrollTop( scrollToElement.offset().top);
//		$("#update").attr("disabled",true);
		//$("#reset").attr("disabled",true);
		$(".edit").hide();
});
$("#edit").click(function(){
		$(".edit").show();
		$(".view").hide();
		$("#edit").attr("disabled",true);
		$("#update").removeAttr("disabled");
		$("#reset").removeAttr("disabled");
});
$("#update").click(function(){
	var flags = [];
	var presentType = [];
	var medicalVal = [];
	var casualVal = [];
	var month = $("#month").html(); 
	var pin = $("#pin").html(); 
	var pin = parseInt(pin.substring(pin.length-8,pin.length));
	$(".datafield").each(function(){
			var day = parseInt($(this).attr("id").substring(3,5));
			flags[day] = $(this).find("input[name='fl"+day+"']:checked").val();
			presentType[day] = $(this).find("select[name='pt"+day+"'] option:selected").val();
			medicalVal[day] = $(this).find("input[name='ml"+day+"']:checked").val();
			casualVal[day] = $(this).find("input[name='cl"+day+"']:checked").val();
	});
	$.ajax({
			url: 'resources/library/editLeaveTable.php',
			type: 'POST',
			data: {flag: flags, status: presentType, medicalleave: medicalVal, casualleave: casualVal, pin: pin, month: month},
			success: function(data){
				$("#tmp").html(data);
			}
	});	  
	$("#automan").val("0");
});
$("#reset").click(function(){
	$("#automan").val("1");
	$("#update").removeAttr("disabled");
});