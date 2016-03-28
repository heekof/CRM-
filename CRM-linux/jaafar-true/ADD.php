<html>
	<head>
		<title>test</title>
		<script type="text/javascript">
			var counter = 0;
			
			
			function addNew() {
				// Get the main Div in which all the other divs will be added
				var mainContainer = document.getElementById('mainContainer');
				// Create a new div for holding text and button input elements
				var newDiv = document.createElement('div');
				// Create a new text input
				var newText = document.createElement('input');
				newText.type = "input"; 
				newText.value = counter;
				// Create a new button input
				var newDelButton = document.createElement('input');
				newDelButton.type = "button";
				newDelButton.value = "Delete";
				
				// Append new text input to the newDiv
				newDiv.appendChild(newText);
				// Append new button input to the newDiv
				newDiv.appendChild(newDelButton);
				// Append newDiv input to the mainContainer div
				mainContainer.appendChild(newDiv);
				counter++;
				
				// Add a handler to button for deleting the newDiv from the mainContainer
				newDelButton.onclick = function() {
						mainContainer.removeChild(newDiv);
				}
			}
		</script>
	</head>
	
	<body >
		<div id="mainContainer">
			<div><input type="text" ><input type="button" value="Add" onClick="addNew()"></div>
		</div>
	</body>
</html>
   