<?php

require_once('model/model.php');
require_once('model/configsection.php');
require_once('model/configsetting.php');

# Read settings from ini files
function ReadIniConfig(Model $model, $filename){
    // PHP's parser defaults to a flat layout, get sections with second parameter true
    // Also converts false to an empty string amongst other things, turn off with INI_SCANNER_RAW
    $ini = parse_ini_file($filename,true,INI_SCANNER_RAW);

    # Add the sections in the file to the model
    foreach($ini as $sectionname=>$section){
        # Create section if not existing
        if (!array_key_exists($sectionname,$model->sections)){
            $model->sections[$sectionname] = new ConfigSection($sectionname);
        }

        # Add the settings within the section
        $modelsection=$model->sections[$sectionname];
        foreach($section as $settingname=>$setting){
            # Create setting if not existing
            if (!array_key_exists($settingname,$modelsection->settings)){
                $modelsection->settings[$settingname] = new ConfigSetting($settingname,$modelsection);
            }
            $modelsection->settings[$settingname]->value = $setting;
        }
    }
}


?>
