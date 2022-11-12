<?php
// phpcs:ignoreFile

$allowed_sentence = 'Marla ali lamm lila malt o';

$allowed = array_values( array_unique( str_split( strToLower( str_replace( ' ', '', $allowed_sentence ) ) ) ) );
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

// Blank list
//print_r($allowed);
//print_r($words);

echo "<html>
<head><title>Erstlesen</title></head>
<body>
";
echo '<h4>Erlaubte Buchstaben</h4>';
printf('<p>Im Satz <em>%s</em> sind die %d Buchstaben <strong>%s</strong> enthalten.</p>',
    $allowed_sentence, 
    count($allowed),
    join(' ', $allowed));

printf('<h4>Damit sind %d Wörter möglich:</h4>', count( $words ) );
$first = 'a';
foreach( $words as $word ) {
    $actual_first = substr($word, 0, 1); 
    if($actual_first != $first ){
        $first = $actual_first;
        echo "<br>";
    } 
    echo $word . ' ';
}
//printf('<p>%s</p>', join(', ', $words));

echo "
</body>
</html>";