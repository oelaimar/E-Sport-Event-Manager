<?php
class Console {
    public function input($label){
        echo $label ." : ";
        $val = trim(fgetc(STDIN));
        return $val;
    }
}

$scan = new Console;