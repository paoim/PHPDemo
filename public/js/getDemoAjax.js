//(function() {
	function myFunction() {
		document.getElementById('myDiv').style.display = 'inline';
		xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				setTimeout("callMe()", 3000);
			}
		}
		xmlHttp.open("GET", "simpleform/GetDemo.php?param=1", true);
		xmlHttp.send();
	};
	function callMe() {
		document.getElementById('myText').value=xmlHttp.responseText;
		document.getElementById('myDiv').style.display='none';
	};
	
	//myFunction();
//})();
