<?php

require_once('model/model.php');
require_once('model/config.php');
require_once('view/web.php');

// Create the runner script
// All settings need to be escaped to maintain safety
class ScriptView{
    function Display(Model $model){
        header('Content-Type: text/plain');
        echo <<<EOS
#!/bin/bash

EOS;
        // Set the variables for each section
        array_walk($model->sections,'DisplaySectionCallback',$this);

        // Insert runner script
        readfile('view/script.sh');
    }

    function DisplaySection($section){
        # Create the script variables for each section
        echo('export '.escapeshellcmd($section->ScriptVariable())."=\\\n");
        array_walk($section->settings,'DisplaySettingCallback',$this);
        echo(";\n");
    }
    function DisplaySetting($setting){
        $variable = escapeshellarg("--".escapeshellcmd($setting->ScriptVariable()));
        $value = escapeshellarg(escapeshellcmd($setting->Value()));
        echo("$variable=$value\\\n");
    }
}

?>
