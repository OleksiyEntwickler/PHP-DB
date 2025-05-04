<?php

function fiaeQuadrat(int $zahl, int $offset = 0): int {

    $ergebnis = $zahl * $zahl + $offset;
    return $ergebnis;
}

function fiaePost(string $name, int $laenge = 50): string|null {

    if( isset($_POST[$name]) ) {
        return trim( substr( $_POST[$name], 0, $laenge ) );
    }
    else {
        return null;
    }
}

function fiaeFahrenheit( int|float $celsius, int $stellen = 2 ): int|float {

    return round( (($celsius * 9) / 5) + 32, $stellen );
}

function fiaeMeilen( int|float $kilometer, int $stellen = 2 ): int|float {

    return round( $kilometer / 1.609, $stellen );
}

function fiaeCheckEmail( string $email ): bool {

    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


