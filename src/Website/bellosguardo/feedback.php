<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="feedback.css">
    <link rel="stylesheet" href="common.css">
    <link rel="shortcut icon" type="image" href="./public/logo.jpg" />
    <title>Bello Sguardo - Feedbacks</title>
</head>
<body>
    <?php
    require("header.php");
    ?>
    <main>
        <section>
            <form class="action-form" action="./send_feedback.php" method="POST">
                <input required name="user" type="text" id="user" placeholder="username">
                <input required maxlength="150" name="text" type="text" id="feedback" placeholder="insert feedback">
                <input required name="mark" type="number" id="mark" min="1" max="5" placeholder="give mark">
                <button type="submit">ADD FEEDBACK</button>
            </form>
        </section>
        <section class="feed-container">
            <?php
                //ini_set('display_errors', 1);
                (require("confdb.php")) or die("Unable to connect");

                try {
                    $db = new PDO("mysql:host=$hostdb; dbname=$dbname;charset=utf8", $userdb, $passdb);
                    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                } catch (PDOException $e) {
                    die ("Errore di connessione: " . $e->getMessage() );
                }
                $sql = 'SELECT * FROM feedbacks';
                $tab = $db->prepare($sql);
                $tab->execute();

                $feeds_arr = [];
                while($row = $tab->fetch(PDO::FETCH_OBJ)) {
                    array_push($feeds_arr, [$row->user, $row->feedtext, $row->mark]);
                }
                $swap = false;
                $last = 0;
                $n = sizeof($feeds_arr);
                do {
                    $swap = false;
                    for($y = 0; $y < $n-1; $y++) {
                        if($feeds_arr[$y][2] < $feeds_arr[$y+1][2]){
                            $tmp = $feeds_arr[$y];
                            $feeds_arr[$y] = $feeds_arr[$y+1];
                            $feeds_arr[$y+1] = $tmp; 
                            $swap = true;
                            $last = $y + 1;
                        }
                    }
                    $n = $last;
                }while($swap);
                foreach($feeds_arr as $feed) {
                    echo "<div><h1>$feed[0]</h1><p>valutazione: $feed[2]/5</p><p>$feed[1]</p></div>";
                }
            ?>
        </section>
    </main>
    <?php
    require("footer.php");
    ?>
</body>
</html>