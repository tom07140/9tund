<?php
class User{

	// private - klassi sees
	private $connection;

	// klassi loomisel(new User)
	function __construct($mysqli){
		// this tähendab selle klassi muutujat
		$this->connection = $mysqli;
	}
	
	function createUser($hash, $create_email){

		//Salvestame AB'i
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		//echo $mysqli->error;
		//echo $stmt->error;
		// asendame ? märgid, ss - s on string email, s on string password
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		
	}
	
	function loginUser($email, $hash){
		
		$stmt = $this->connection->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
				
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
				
		//Kontrollin kas tulemusi leiti
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			// suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
				
		$stmt->close();
		
	}

	
	
}?>