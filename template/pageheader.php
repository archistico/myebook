<?php
    class Header {
        public static function make($header) {
            if(!empty($header)){
                echo '<div class="page-header">';
                echo "<h1>$header</h1>";
                echo '</div>';
            }            
        }
    }
?>
