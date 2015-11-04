<?php
	require_once("functions.php");
	
	// kui kasutaja ei ole sisseloginud,
	// siis suunan tagasi
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	// kasutaja tahab välja logima
	
	if(isset($_GET["logout"])){
		// aadressireal on olemas muutuja logout
		
		//kustutame kõik sessoni muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}

	
	
?>
<?php if(isset($_SESSION["login_success_message"])): ?>
	<p style="color:green;">
		<?=$_SESSION["login_success_message"];?>
	</p>

<?php 
	// kustutan sõnumi ära pärast esimest näitamist
	unset($_SESSION["login_success_message"]);
	
	endif; ?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1">logi välja<a>	
</p>
