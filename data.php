<?php
	require_once("functions.php");
	// data.php
	
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
	
	$number_plate = $color = "";
	$number_plate_error = $color_error = "";
	
	//keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_plate"])){
		// echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		// mõlemad on kohustuslikud
		// salvestatakse AB'i fn kaudu addCarPlate
		if ( empty($_POST["number_plate"]) ) {
				$number_plate_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$number_plate = cleanInput($_POST["number_plate"]);
			}
		if ( empty($_POST["color"]) ) {
				$color_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$color = cleanInput($_POST["color"]);
			}
		if(	$number_plate_error == "" && $color_error == ""){
					
					
					
					// kasutaja loomise funktsioon, failist functions.php
					// saadame kaasa muutujad
					$message = addCarPlate($number_plate, $color);
					
					if($message != ""){
						// õnnestus, teeme inputi väljad tühjaks
						$number_plate = "";
						$color = "";
						
						echo $message;
						
					}
				}
	}
	
	  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
    function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1">logi välja<a>	
</p>

<h2>Lisa autonumbrimärk</h2>
  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="number_plate">Auto numbrimärk</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?php echo $number_plate; ?>"> <?php echo $number_plate_error; ?><br><br>
	<label for="color">Värv</label><br>
  	<input id="color" name="color" type="text" value="<?php echo $color; ?>"> <?php echo $color_error; ?><br><br>
  	<input type="submit" name="add_plate" value="Salvesta">
  </form>