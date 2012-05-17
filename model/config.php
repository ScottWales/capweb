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
        if (isset($this->alwaysenable) && $this->alwaysenable==="true") return true;
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
        if (array_key_exists('always enable',$metadata)) $this->alwaysenable = $metadata['always enable'];
    }
};

// Holds a config value & metadata
class ConfigSetting {
    public $id; // Section in the metadata
    public $name; // Display name, default $id
    public $tooltip; // Display tooltip, default $name
    public $type; // Variable type

    public $section; // The section that owns this setting

    public $value; // Current value
    public $scriptvariable;
    public $availablevalues;

    function __construct($id,$section){
        $this->id=$id;
        $this->section=$section;
    }
    function Key(){
        return "{$this->section->id}-{$this->id}";
    }
    function Name(){
        if (isset($this->name)) return $this->name;
        return $this->id;
    }
    function Value(){
        if (isset($this->value)) return $this->value;
        return "";
    }
    function Tooltip(){
        if (isset($this->tooltip)) return $this->tooltip;
        return $this->Name();
    }
    function ScriptVariable(){
        if (isset($this->scriptvariable)) return $this->scriptvariable;
        return $this->id;
    }
    function SetMetadata($metadata){
        if (array_key_exists('name',$metadata)) $this->name = $metadata['name'];
        if (array_key_exists('tooltip',$metadata)) $this->tooltip = $metadata['tooltip'];
        if (array_key_exists('type',$metadata)) $this->type = $metadata['type'];
        if (array_key_exists('script variable',$metadata)) $this->scriptvariable = $metadata['script variable'];
        if (array_key_exists('available values',$metadata)) {
            $this->availablevalues = ($metadata['available values']);
        }
    }
};

?>
