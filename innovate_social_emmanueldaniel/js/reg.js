function verify() {
	var ax = document.getElementById("inputer").value;
	var bx = document.getElementById("inputers").value;
	var cx = document.getElementById("inputerss").value;

	if (ax && bx && cx != "") {
		document.getElementById("sign_in").style.color = "rgb(21, 131, 240)";
	} else {
		document.getElementById("sign_in").style.color = "grey";
	}
}

function verified() {
	var ax = document.getElementById("inputer").value;
	var bx = document.getElementById("inputers").value;

	if (ax && bx != "") {
		document.getElementById("sign_in").style.color = "rgb(21, 131, 240)";
	} else {
		document.getElementById("sign_in").style.color = "grey";
	}
}
