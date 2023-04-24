var windowWidth = 250;
var deleteIconWidth = 16;
var ns6=document.getElementById && !document.all;
var ie=document.all;
var shownPopup = 0;

function getPositionLeft(This){
    var el = This; var pL = 0;
    while (el) { pL+=el.offsetLeft; el=el.offsetParent; }
    return pL;
}
function getPositionTop(This){
    var el = This; var pT = 0;
    while (el) { pT+=el.offsetTop; el=el.offsetParent; }
    return pT;
}
function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function showContextHelpWindow(num_item) {
    if (num_item == shownPopup) {
        closeContextHelpWindow();
        return ;
    }
    
    var img = document.getElementById('help_img_'+num_item);
    var imgX = getPositionLeft(img)+16;
    var imgY = getPositionTop(img)+16;
    var rightedge=ie&&!window.opera? ietruebody().clientWidth-windowWidth : window.innerWidth-windowWidth-20;
    if (imgX > rightedge) imgX = rightedge;
    var text = '<table width="'+windowWidth+'" border="0" cellpadding="0" cellspacing="0" class="ch_table">' +
        '<tr class="ch_header">' +
        ' <td class="ch_header" width="'+(windowWidth-deleteIconWidth-4)+'">ContextHelp</td>' +
        ' <td align="right" width="'+(deleteIconWidth+4)+'"><a href="javascript:closeContextHelpWindow();"><img src="/resources/images/Modules/ContextHelp/close.gif" border="0" alt="Close" title="Close" hspace=1 vspace=1></a></td>' +
        '</tr>' +
        '<tr>' +
        ' <td class="ch_body" colspan="2" width="'+windowWidth+'">'+texts[num_item]+'</td>' +
        '</tr>' +
        '</table>';
    var contextWindow = document.getElementById('ContextWindow');
    contextWindow.innerHTML = text;
    contextWindow.style.left = imgX + 'px';
    contextWindow.style.top = imgY + 'px';
    contextWindow.style.visibility = 'visible';
    shownPopup = num_item;
}
function closeContextHelpWindow() {
    document.getElementById('ContextWindow').style.visibility = 'hidden';
    shownPopup = 0;
}
