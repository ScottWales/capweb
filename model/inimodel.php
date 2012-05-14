<?php

require_once('model/model.php');
require_once('model/config.php');

# Read settings from ini files
function ReadIniConfig(Model $model, $filename){
    $ini = parse_ini_file($filename,true);
    print_r($ini);
}


?>
