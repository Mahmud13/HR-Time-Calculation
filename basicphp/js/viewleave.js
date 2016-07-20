$(document).ready( function(){
		var scrollToElement = $("#leaveTable");
		$(window).scrollTop( scrollToElement.offset().top);
//		$("#update").attr("disabled",true);
		//$("#reset").attr("disabled",true);
		$(".edit").hide();
		$(".datafield").each(function(){
			var day = parseInt($(this).attr("id").substring(3,5));
			if ($(this).find(".stat").find(".view").html() == "H"){
			//	$(this).css("background-color","gray");
			}
			if ($(this).find(".status").find(".view").html() == "absent"){
			$(this).css("background-color","IndianRed");
			}
			if ($(this).find(".status").find(".view").html() == "!out-absent"){
			$(this).css("background-color","IndianRed");
			}
			if ($(this).find(".status").find(".view").html() == "late"){
			$(this).css("background-color","LightBlue");
			}
			if ($(this).find(".status").find(".view").html() == "late3"){
			$(this).css("background-color","LightBlue");
			}
			if ($(this).find(".status").find(".view").html() == "half"){
			$(this).css("background-color","LightPink");
			}
			if ($(this).find(".status").find(".view").html() == "!out-half"){
			  $(this).css("background-color","LightPink");
			}
			if ($(this).find(".status").find(".view").html() == "half12"){
			  $(this).css("background-color","LightPink");
			}
			
		//	var day = parseInt($(this).attr("id").substring(3,5));
		//	if ($(this).find(".stat").find(".noview").html() == "H"){
		//	//	$(this).css("background-color","gray");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "absent"){
		//		$(this).css("background-color","IndianRed");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "!out-absent"){
		//		$(this).css("background-color","IndianRed");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "late"){
		//		$(this).css("background-color","LightBlue");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "late3"){
		//		$(this).css("background-color","LightBlue");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "half"){
		//		$(this).css("background-color","LightPink");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "!out-half"){
		//		$(this).css("background-color","LightPink");
		//	}
		//	if ($(this).find(".status").find(".noview").html() == "half12"){
		//		$(this).css("background-color","LightPink");
		//	}

			//presentType[day] = $(this).find("select[name='pt"+day+"'] option:selected").val();
			//medicalVal[day] = $(this).find("input[name='ml"+day+"']:checked").val();
			//casualVal[day] = $(this).find("input[name='cl"+day+"']:checked").val();
		});
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
	 pin = parseInt(pin.substring(pin.length-8,pin.length));
	 var balance=$("#balance").val();
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
			 data: {flag: flags, status: presentType, medicalleave: medicalVal, casualleave: casualVal, pin: pin, month: month, balance: balance},
			 success: function(data){
				//$("#tmp").html(data);
			 }
	 });	  
	 $("#automan").val("0");
	 $("#autocal").val("0");
});
$("#reset").click(function(){
	$("#automan").val("1");
	$("#autocal").val("0");
	$("#update").removeAttr("disabled");
});
$("#resetcalendar").click(function(){
	$("#autocal").val("1");
	$("#automan").val("0");
	$("#update").removeAttr("disabled");
});
