<?php
/****Function For Hightlight a Search Results****/
function highlight_word( $content, $word) {
    $replace = '<span style="background-color: #FF0;">' . $word . '</span>'; // create replacement
    $content = str_replace( $word, $replace, $content ); // replace content
    return $content; // return highlighted data
}
?>