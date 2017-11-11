<?php

class File {
    public static function FILENAME($file) {
        $path_parts = pathinfo($file);
        return $path_parts['filename'];
    }
}

/*
$path_parts = pathinfo(__FILE__);

echo $path_parts['dirname'], "<br>";   // /var/www/html/myebook/temp
echo $path_parts['basename'], "<br>";  // testValido.php
echo $path_parts['extension'], "<br>"; // php
echo $path_parts['filename'], "<br>";  // testValido
*/