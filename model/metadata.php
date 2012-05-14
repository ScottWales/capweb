<?php

// Read the metadata files
require_once('model/model.php');
require_once('model/config.php');

// Given the filename for the section metadata load all of the metadata for the model
function ReadSectionMetadata(Model $model, $filename){
    $ini = parse_ini_file($filename,true,INI_SCANNER_RAW);

    # Add the sections in the file to the model
    foreach($ini as $sectionname=>$sectionmeta){
        # Create section if not existing
        if (!array_key_exists($sectionname,$model->sections)){
            $model->sections[$sectionname] = new ConfigSection($sectionname);
        }
        $model->sections[$sectionname]->SetMetadata($sectionmeta);

        ReadSettingMetadata($model->sections[$sectionname]);
    }
};

// Read the metadata file for the settings within a section and load them
function ReadSettingMetadata($section){
    if (!file_exists($section->SettingMetadataFile())) return;
    $ini = parse_ini_file($section->SettingMetadataFile(),true,INI_SCANNER_RAW);

    foreach($ini as $settingname=>$settingmeta){
        if (!array_key_exists($settingname,$section->settings)){
            $section->settings[$settingname] = new ConfigSetting($settingname,$section);
        }
        $section->settings[$settingname]->SetMetadata($settingmeta);
        echo "\n\n";
    }
};

?>
