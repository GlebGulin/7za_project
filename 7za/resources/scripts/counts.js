<!--
var fields=new Array();
function step(num,stp){
	var nval=parseInt(fields[num-1].getElementsByTagName("input")[0].value,10)+stp;
	if(!(nval))nval=0;
	fields[num-1].getElementsByTagName("input")[0].value=(nval<1)?1:nval;
	calculate_summ();
}
function initSteppers(){
	var steppers=document.getElementsByName("stepper");
	for(var i=0;i<steppers.length;i++){
		fields.push(steppers[i]);
		steppers[i].getElementsByTagName("img")[0].style.cursor="pointer";
		steppers[i].getElementsByTagName("img")[1].style.cursor="pointer";
		steppers[i].getElementsByTagName("img")[0].onclick=function(){step(this.num,1)};
		steppers[i].getElementsByTagName("img")[1].onclick=function(){step(this.num,-1)};
		steppers[i].getElementsByTagName("input")[0].onkeyup=function(){
			var allow=new RegExp("[0-9]+",'i');
			var out=allow.exec(this.value);
			this.value=(out?out:"1");
			calculate_summ();
		}
		steppers[i].getElementsByTagName("input")[0].num=fields.length;
		steppers[i].getElementsByTagName("img")[0].num=fields.length;
		steppers[i].getElementsByTagName("img")[1].num=fields.length;
	}
}
//-->