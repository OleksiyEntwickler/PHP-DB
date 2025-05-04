<?php

require 'dbconn.php';

$genre_id = filter_input( INPUT_GET, 'Genre_id', FILTER_VALIDATE_INT);

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Datenbankverbindung Film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>

        <header id="header">
            <h1>Datenbankverbindung Film</h1>
        </header>

        <main id="main">

        <?php

        echo '<h2>Genre</h2>';

        $sql = 'SELECT * FROM genre ORDER BY Name';
        $result = mysqli_query($mysqli, $sql);

        echo '<ul>';
        while( $row = mysqli_fetch_assoc($result) ) {
            echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?Genre_id='.$row['id'].'">'.$row['Name'].'</a></li>';}
        echo '</ul>';
        echo '<h2>Filme</h2>';
        echo '<a class="button-style" href="filme-formular.php">neuer Film</a>';

        if( is_int($genre_id) ) {

            $sql = "SELECT * FROM film WHERE Genre_id = $genre_id ORDER BY Titel";
            $result = mysqli_query($mysqli, $sql);
            echo '<ul>';
            
            while( $row = mysqli_fetch_assoc($result) ) {

                echo '<li>';
                echo $row['Titel'].' ('.$row['Erscheinungsdatum'].') <br> '.$row['Beschreibung'].'<br>';
                echo '<a class="button-style" href="filme-formular.php?Film_id='.$row['id'].'">bearbeiten</a>';
                echo '</li>';
            }
            echo '</ul>';

        }


        ?>


        </main>
        
    </body>
</html>