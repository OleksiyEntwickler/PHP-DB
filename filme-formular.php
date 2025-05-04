<?php

require 'dbconn.php';
require 'funktionen.php';

$genre_id = fiaePost('Genre_id', 3);
$filmgesellschaft_id = fiaePost('Filmgesellschaft_id', 5);
$titel = fiaePost('Titel', 150);
$beschreibung = fiaePost('Beschreibung', 2000);
$erscheinungsdatum = fiaePost('Erscheinungsdatum', 10);
$dauer_in_minuten = fiaePost('DauerInMinuten', 3);
$bewertung = fiaePost('Bewertung', 4);
$freigabe = fiaePost('Freigabe', 1);
$button = fiaePost('button', 20);

$film_id = filter_input(INPUT_GET, 'Film_id');

if( $button == 'speichern' ) {

    if( empty($genre_id) ) {

        $meldung[] = 'Bitte Genre auswählen';
    }
    if( empty($filmgesellschaft_id) ) {

        $meldung[] = 'Bitte Filmgesellschaft auswählen';
    }
    if( empty($titel) ) {

        $meldung[] = 'Bitte Titel eingeben';
    }
    if( empty($erscheinungsdatum) ) {

        $meldung[] = 'Bitte Erscheinungsdatum eingeben';
    }

    if( !isset($meldung) ) {

        if( empty($dauer_in_minuten) ) {
            $dauer_in_minuten = 'NULL';
        }
        if( empty($bewertung) ) {
            $bewertung = 'NULL';
        }
        if( empty($freigabe) ) {
            $freigabe = 0;
        }

        if( is_numeric($film_id) ) {

            $sql = "UPDATE film SET 
                Genre_id = $genre_id, 
                Filmgesellschaft_id = $filmgesellschaft_id, 
                Titel = '$titel',
                Beschreibung = '$beschreibung',
                Erscheinungsdatum = '$erscheinungsdatum',
                DauerInMinuten = $dauer_in_minuten,
                Bewertung = $bewertung,
                Freigabe = $freigabe
            WHERE id = $film_id";

            mysqli_query($mysqli, $sql);

        }
        else {
            $sql = "INSERT INTO film (Genre_id, Filmgesellschaft_id, Titel, Beschreibung, Erscheinungsdatum, DauerInMinuten, Bewertung, Freigabe) 
            VALUES ($genre_id, $filmgesellschaft_id, '$titel', '$beschreibung', '$erscheinungsdatum', $dauer_in_minuten, $bewertung, $freigabe)";

            mysqli_query($mysqli, $sql);
        }

        header('Location: filme.php?Genre_id='.$genre_id);

    }

}

elseif( is_numeric($film_id) ) {

    $sql = "SELECT * FROM film WHERE id = $film_id";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

    $genre_id = $row['Genre_id'];
    $filmgesellschaft_id = $row['Filmgesellschaft_id'];
    $titel = $row['Titel'];
    $beschreibung = $row['Beschreibung'];
    $erscheinungsdatum = $row['Erscheinungsdatum'];
    $dauer_in_minuten = $row['DauerInMinuten'];
    $bewertung = $row['Bewertung'];
    $freigabe = $row['Freigabe'];

}

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Filmformular</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>

        <header id="header">
            <h1>Filmformular</h1>
        </header>

        <main id="main">

        <?php
        if( isset($meldung) ) {

            echo '<p class="wichtig">'.implode('<br>', $meldung).'</p>';
        }
        ?>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'].'?Film_id='.$film_id ?>" method="post">

            <label>Genre *</label>
            <select name="Genre_id" class="eingabe">
                <option value="">Bitte auswählen</option>
                <?php
                $sql = 'SELECT * FROM genre ORDER BY Name';
                $result = mysqli_query($mysqli, $sql);
                while( $row = mysqli_fetch_assoc($result) ) {
                    if( $row['id'] == $genre_id ) {
                        $selected = 'selected';
                    }
                    else {
                        $selected = '';
                    }
                
                    echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['Name'].'</option>';
                }

                ?>
            </select>

            <label>Filmgesellschaft *</label>
            <select name="Filmgesellschaft_id" class="eingabe">
                <option value="">Bitte auswählen</option>
                <?php

                $sql = 'SELECT * FROM filmgesellschaft ORDER BY Name';
                $result = mysqli_query($mysqli, $sql);
                while( $row = mysqli_fetch_assoc($result) ) {
                    
                    if( $row['id'] == $filmgesellschaft_id ) {
                        $seleted = 'selected';
                    }
                    else {
                        $seleted = '';
                    }

                    echo '<option value="'.$row['id'].'" '.$seleted.'>'.$row['Name'].'</option>';
                }

                ?>
            </select>

            <label>Titel *</label>
            <input type="text" name="Titel" value="<?php echo $titel ?>" maxlength="150" class="eingabe">

            <label>Beschreibung</label>
            <textarea name="Beschreibung" maxlength="2000" class="eingabe textfeld"><?php echo $beschreibung ?></textarea>

            <label>Erscheinungsdatum *</label>
            <input type="date" name="Erscheinungsdatum" value="<?php echo $erscheinungsdatum ?>" maxlength="10" class="eingabe">

            <label>Dauer in Minuten</label>
            <input type="number" min="0" max="600" name="DauerInMinuten" value="<?php echo $dauer_in_minuten ?>" maxlength="3" class="eingabe">

            <label>Bewertung</label>
            <input type="number" step="0.1" min="0" max="10" name="Bewertung" value="<?php echo $bewertung ?>" class="eingabe" maxlength="4">

            <label>Freigabe</label>
            <input type="checkbox" name="Freigabe" value="1" <?php if($freigabe == 1){ echo 'checked'; } ?> class="checkbox">

            <button type="submit" name="button" value="speichern" class="button-style">Speichern</button>
            <a href="filme.php" class="button-style">Abbrechen</a>

        </form>


        </main>
        
    </body>
</html>