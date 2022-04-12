function checkPassword() {
	var p = document.getElementById("p").value;
	var v = document.getElementById("v").value;
	var messageElement = document.getElementById("passmatch");
	if (p !== "" && v !== "" && p !== v) {
	messageElement.style.visibility = "visible";
	} else {
		messageElement.style.visibility = "hidden";
	}
}