<?php
    class Jumbotron {
        public static function make($titolo, $sottotitolo) {
            echo '<div class="jumbotron">';
            if(!empty($titolo)){
                echo "<h1>$titolo</h1>";
            }
            if(!empty($sottotitolo)){
                echo "<p>$sottotitolo</p>";
            }
            echo '</div>';
        }
    }
?>



