function showWait(div){

document.getElementById(div).innerHTML='<span class=\'normal\'>Please wait...</span>';

}





function confirmation(URL,message) {
	if (confirm(message)){
		location.href = URL;
	}
	else{
		return false;
	}
}

function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}


function checkDate(input){
var validformat=/^\d{4}\-\d{2}\-\d{2}$/ //Basic check for format validity

if (!validformat.test(input.value))
return false;
else
{ //Detailed check for valid date ranges
var yearfield=input.value.split("-")[0]
var monthfield=input.value.split("-")[1]
var dayfield=input.value.split("-")[2]
var dayobj = new Date(yearfield, monthfield-1, dayfield)

if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
return false;
else
return true;
}
}