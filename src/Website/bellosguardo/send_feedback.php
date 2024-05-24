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
   header("Location: ./feedback.php");
   die(); 
?>

