<?php
// phpcs:ignoreFile

$allowed = 'Marla ali lamm lila malt o';

$allowed = array_values( array_unique( str_split( strToLower( str_replace( ' ', '', $allowed ) ) ) ) );
sort( $allowed );

$words = file( 'words.txt' );


$hunspell = file( 'hunspell.txt' );
$hunspell = array_map( function( $word ) {
    return strstr( trim( $word ) . '/', '/', true );
}, $hunspell );

$words = array_map( function( $word ) {
    return strToLower( trim( $word ) );
}, $words );

$words = array_unique( array_merge( $words, $hunspell ) );


$words = array_filter($words, function( $word ) {
    if( strlen($word) === 1 ) {
        return false;
    }

    if( empty( array_intersect( str_split( $word ), ['a','e','i','o','u'] ) )) {
        return false;
    }
    return empty( array_diff( str_split( $word ), $GLOBALS['allowed'] ) );
});


$words = array_values( $words );

sort($words);
print_r($allowed);
print_r($words);
