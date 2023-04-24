function openWindow( width, height ) {
    var win = window.open('about:blank', 'popup', 'menubar=no,scrollbars=auto,toolbar=no,directiories=no,status=no,location=no,width='+width+',height='+height+',left='+((screen.width-width)/2)+',top='+((screen.height-height)/2));
    win.focus();
    return win;
}
