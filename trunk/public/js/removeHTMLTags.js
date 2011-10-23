/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Robert Nyman | http://robertnyman.com/ */
function removeHTMLTags(id){
 	if(document.getElementById && document.getElementById(id)){
 		var strInputCode = document.getElementById(id).innerHTML;
 		/* 
  			This line is optional, it replaces escaped brackets with real ones, 
  			i.e. < is replaced with < and > is replaced with >
 		*/	
 	 	strInputCode = strInputCode.replace(/&(lt|gt);/g, function (strMatch, p1){
 		 	return (p1 == "lt")? "<" : ">";
 		});
 		var strTagStrippedText = strInputCode.replace(/<\/?[^>]+(>|$)/g, "");
 		return strTagStrippedText;	
   // Use the alert below if you want to show the input and the output text
   //		alert("Input code:\n" + strInputCode + "\n\nOutput text:\n" + strTagStrippedText);	
 	}	
}
