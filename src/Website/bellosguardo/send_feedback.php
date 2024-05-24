<?php 
   (require("confdb.php")) or die("Unable to connect");

   ob_start();
   //POST values
   $user = $_POST["user"];
   $feed_text = $_POST["text"];
   $feed_mark = $_POST["mark"];
   
   try {
      $db = new PDO("mysql:host=$hostdb; dbname=$dbname;charset=utf8", $userdb, $passdb);
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
   } catch (PDOException $e) {
      die ("Errore di connessione: " . $e->getMessage() );
   }
   $sql = "INSERT INTO feedbacks (user, feedtext, mark) VALUES(:user, :feed_text, :feed_mark);";
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':user', $user);
   $stmt->bindValue(':feed_text', $feed_text);
   $stmt->bindValue(':feed_mark', $feed_mark);
   $stmt->execute();
   echo "New record created successfully";
   //  $conn = new mysqli($hostdb, $userdb, $passdb, $dbname);
   //  // Check connection
   //  if ($conn->connect_error) {
   //     echo "Connection failed: " . $conn->connect_error;
   //     die();
   //  } else {
   //      echo "Connection ok";
   //  }
    
    /**********************************************
    *
    *  ATTENZIONE: prima di eseguire insert bisogna fare
    *  dei controlli sull'input, togliendo ad esempio eventuali caratteri speciali
    *  che possono provocare SQL Injection. 
    *  Così com'è il sito è molto a rischio
    *
    *  TO DO
    ***********************************************/
    
   //  if ($conn->query($sql) === TRUE) {
   //     echo "New record created successfully";
   //  } else {
   //     echo "Error: " . $sql . "<br>" . $conn->error;
   //     die();
   //  }
    
   //  $conn->close();
    header("Location: ./feedback.php");
    die()   ; 
?>

