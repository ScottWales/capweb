<?php

// Holds a section of the configuration
class ConfigSection {
    // Section in the metadata
    public $id;
    // Display name, default $id
    public $name;
    // Display tooltip, default $name
    public $tooltip;
    // Variable to store arguments in the script, default $id
    public $scriptvariable;
    // Should this section always be shown?
    public $alwaysenable;
    public $enabled;

    public $settingmetadata; // File containing setting metadata

    // Array of ConfigSettings
    public $settings;

    function __construct($id){
        $this->id=$id;
        $this->settings = array();
        $this->enable = false;
    }
    function Key(){
        return $this->id;
    }
    function Name(){
        if (isset($this->name)) return $this->name;
        return $this->id;
    }
    function Tooltip(){
        if (isset($this->tooltip)) return $this->tooltip;
        return $this->Name();
    }
    function ScriptVariable(){
        if (isset($this->scriptvariable)) return $this->scriptvariable;
        return $this->id;
    }
    function SettingMetadataFile(){
        if (isset($this->settingmetadata)) return $this->settingmetadata;
        return "metadata/{$this->id}.ini";
    }
    function AlwaysEnable(){
        if (isset($this->alwaysenable) && $this->alwaysenable===true) return true;
        return false;
    }
    function IsEnabled(){
        return $this->AlwaysEnable() || ($this->enabled===true);
    }

    function SetMetadata($metadata){
        if (array_key_exists('name',$metadata)) $this->name = $metadata['name'];
        if (array_key_exists('tooltip',$metadata)) $this->tooltip = $metadata['tooltip'];
        if (array_key_exists('script variable',$metadata)) $this->scriptvariable = $metadata['script variable'];
        if (array_key_exists('metadata file',$metadata)) $this->settingmetadata = $metadata['metadata file'];
        if (array_key_exists('always enable',$metadata)) $this->alwaysenable = 
             filter_var($metadata['always enable'],FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE);
    }
};

?>
