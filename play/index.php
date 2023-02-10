<!DOCTYPE html>
<html>
    <head>
        <title>GBA Forums - Play</title>
<link rel="icon" type="image/x-icon" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/img/logo.png'; ?>">
    </head>

    <body oncontextmenu="return false;">
<script>
	// Anti Methods

// Disabling Right-Click (Contextmenu) Buttons
document.addEventListener("contextmenu", (e) => {
  e.preventDefault();
}, false);

// // Disabling CONTROL AND F12 Keys
 document.addEventListener("keydown", (e) => {
   if (e.ctrlKey || e.keyCode==123) {
     e.stopPropagation();
     e.preventDefault();
  }
 });


</script>
       <iframe
	src="https://emulator-backend.paragram.repl.co/launcher.html"  
	style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"
	name="my-iframe"
	allow="fullscreen"
	referrerpolicy="no-referrer"
	title="Emulator for all sorts of game files!!!"
	sandbox="allow-same-origin allow-forms allow-modals	allow-orientation-lock allow-pointer-lock allow-popups-to-escape-sandbox allow-presentation allow-same-origin	allow-scripts	allow-top-navigation	"  

><p>Sorry, you cant play with this emulator. Your computer seems to be running an extremely old version of its OS or your OS is deprecated. Please update your OS / enable JavaScript / Get a new computer.</p></iframe>
    </body>
</html>