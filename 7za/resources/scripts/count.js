<!--
var stepper=null;
function step(stp){
	var nval=parseInt(stepper.getElementsByTagName("input")[0].value,10)+stp;
	if(!(nval))nval=0;
	stepper.getElementsByTagName("input")[0].value=(nval<1)?1:nval;
}
function initStepper(){
	stepper=document.getElementById("stepper");
	stepper.getElementsByTagName("img")[0].style.cursor="pointer";
	stepper.getElementsByTagName("img")[1].style.cursor="pointer";
	stepper.getElementsByTagName("img")[0].onclick=function(){step(1)};
	stepper.getElementsByTagName("img")[1].onclick=function(){step(-1)};

	stepper.getElementsByTagName("input")[0].onkeyup=function(){
		var allow=new RegExp("[0-9]+",'i');
		var out=allow.exec(this.value);
		this.value=(out?out:"1");
	}
}
//-->