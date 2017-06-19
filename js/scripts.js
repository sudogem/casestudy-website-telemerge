

function checkAll ( n , chkname )
{
	if ( !chkname )		
	{
		chkname = 'cb';
	}
	
	var f = document.adminForm ;
	var c = f.toggle.checked ;
	var x = 0 ;
	
	for ( i=0 ; i < n ; i++ )
	{
		cb = eval( 'f.' + chkname + '' + i );
		if (cb)
		{
			cb.checked = c ;
			x++ ;
		}
	}
	if ( c )
	{
		f.boxchecked.value = x ;
	}
	else
	{
		f.boxchecked.value = 0 ;	
	}
	
}

function ischecked( ischeck )
{
	if ( ischeck == true )
		document.adminForm.boxchecked.value++ ;
	else
		document.adminForm.boxchecked.value-- ;
}

function submitForm ()
{
	if ( document.pressed == 'refresh' ) 
	{
		document.adminForm.action = '';
	}
	

	if ( document.pressed == 'deleteresume' ) 
	{
		document.adminForm.action = 'deleteresume.php';
	}

	if ( document.pressed == 'deletevoicefile' ) 
	{
		document.adminForm.action = 'deletevoicefile.php';
	}

	if ( document.pressed == 'deletetestimonial' ) 
	{
		document.adminForm.action = 'deletetestimonial.php';
	}

	if ( document.pressed == 'deletenews' ) 
	{
		document.adminForm.action = 'deletenews.php';
	}
	
	if ( document.pressed == 'restore' ) 
	{
		document.adminForm.action = 'restore.php';
	}
	
	return true ;
}

<!--
function getWindowHeight() {
	var windowHeight = 0;
	if (typeof(window.innerHeight) == 'number') {
		windowHeight = window.innerHeight;
	}
	else {
		if (document.documentElement && document.documentElement.clientHeight) {
			windowHeight = document.documentElement.clientHeight;
		}
		else {
			if (document.body && document.body.clientHeight) {
				windowHeight = document.body.clientHeight;
			}
		}
	}
	return windowHeight;
}
function setFooter() {
	if (document.getElementById) {
		var windowHeight = getWindowHeight();
		if (windowHeight > 0) {
			var contentHeight = document.getElementById('container').offsetHeight;
			var footerElement = document.getElementById('footer');
			var footerHeight  = footerElement.offsetHeight;
			if (windowHeight - (contentHeight + footerHeight) >= 0) {
				footerElement.style.position = 'relative';
				footerElement.style.top = (windowHeight - (contentHeight + footerHeight)) + 'px';
			}
			else {
				footerElement.style.position = 'static';
			}
		}
	}
}
window.onload = function() {
	setFooter();
}
window.onresize = function() {
	setFooter();
}
//-->

/**
* Pops up a new window in the middle of the screen
*/
function popupWindow(mypage, myname, w, h, scroll ) {
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
	//alert(winprops);
	win = window.open(mypage, myname, winprops)
	if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}


