	var stpin = "";
	function getDepartment(str) {
		if (str == "") {
			var sel1 = document.getElementById("departmentid");
			sel1.options.selectedIndex = 0;
			getStaff("");
			sel2 = document.getElementById("staffpin");
			sel2.options.selectedIndex = 0;
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp1 = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp1.onreadystatechange = function() {
				if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
					var dit = parseInt(xmlhttp1.responseText);
					var sel1 = document.getElementById("departmentid");
					for(i=0;i<sel1.length;i++) { if(sel1[i].value==dit) { break; } }
					sel1.options.selectedIndex = i;
					stpin = str;
					if(dit!=-1){
						getStaff(dit);
					}else{
						getStaff("");
						sel2 = document.getElementById("staffpin");
						sel2.options.selectedIndex = 0;
					}
				}
			};
			xmlhttp1.open("GET","resources/library/get_the_department.php?staffpin="+str,true);
			xmlhttp1.send();
		}
	}
	function getStaff(str) {
		document.getElementById("month-list").innerHTML = "	<label>Month: </label> <select> <option>Select Month</option></select><br>";
		document.getElementById("year-list").innerHTML = "	<label>Year: </label> <select> <option>Select Year</option></select><br><br>";
		if (str == "a") {
			document.getElementById("staff-list").innerHTML = "	<label>Staff name: </label> <select> <option>Select Staff</option></select><br><br>";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						
					document.getElementById("staff-list").innerHTML = xmlhttp.responseText;
					var sel2 = document.getElementById("staffpin");
					for(i=0;i<sel2.length;i++) { if(sel2[i].value==stpin) { break; } }
					sel2.options.selectedIndex = i;
				}
			};
			xmlhttp.open("GET","resources/library/get_staff.php?department_id="+str,true);
			xmlhttp.send();
		}
	}
	function getYear(str) {
		document.getElementById("month-list").innerHTML = "	<label>Month: </label> <select> <option>Select Month</option></select><br>";
		document.getElementById("staffpinin").value = str;
		if (str == "") {
			document.getElementById("year-list").innerHTML = "	<label>Year: </label> <select> <option>Select Year</option></select><br><br>";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp2 = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp2.onreadystatechange = function() {
				if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
					document.getElementById("year-list").innerHTML = xmlhttp2.responseText;
				}
			};
			xmlhttp2.open("GET","resources/library/get_year.php?spin="+str,true);
			xmlhttp2.send();
			stpin = str;
		}
	}
	function getMonth(str) {
		if (str == "") {
			document.getElementById("month-list").innerHTML = "	<label>Month: </label> <select> <option>Select Month</option></select><br>";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("month-list").innerHTML = xmlhttp.responseText;
				}
			};
			if(stpin==""){
				stpin = document.getElementById("staffpin").value;
			}
			xmlhttp.open("GET","resources/library/get_month.php?year="+str+"&staffpin="+stpin,true);
			xmlhttp.send();
		}
	}
	function getStaffName(str) {
		str = this.staffpinin.value;
		getDepartment(str);
		stpin = str;
		getYear(str);
		
		//document.getElementById("year-list").innerHTML = "	<label>Year: </label> <select> <option>Select Year</option></select><br><br>";
		//document.getElementById("month-list").innerHTML = "	<label>Month: </label> <select> <option>Select Month</option></select><br>";
		//if (str == "a") {
			//document.getElementById("staff-list").innerHTML = "	<label>Staff name: </label> <select> <option>Select Staff</option></select><br><br>";
			//return;
		//} else { 
			//if (window.XMLHttpRequest) {
				//// code for IE7+, Firefox, Chrome, Opera, Safari
				//xmlhttp = new XMLHttpRequest();
			//} else {
				//// code for IE6, IE5
				//xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			//}
			//xmlhttp.onreadystatechange = function() {
				//if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					//document.getElementById("staff-list").innerHTML = xmlhttp.responseText;
				//}
			//};
			//xmlhttp.open("GET","../resources/library/get_staff_name.php?staffpin="+str,true);
			//xmlhttp.send();
		//}
	}
