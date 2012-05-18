<?php

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
