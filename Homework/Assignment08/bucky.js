
function doFirst(){
	var button = document.getElementById("button");
	button.window.addEventListener("click", saveCrap, false);

}

function saveCrap(){
	//gets whole control, not variable without value
	var first = document.getElementById("one").value;
    var second = document.getElementById("two").value;
	
	//heeey, we can actually store to session in javascript
	sessionStorage.setItem(first, second);

	}

//call dofirst as soon as page is loaded
window.addEventListener("load", doFirst, false);

