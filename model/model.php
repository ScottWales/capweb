<?php

require_once('model/config.php');

class Model {
    public $sections;

    function __construct(){
        $this->sections=array();
    }  

    function LoadPOST($post){
        // Model values input on the webform have field ids like input/$section/$field
        foreach ($post as $key=>$value){
            $parts = explode("-",$key);
            // Ignore if doesn't start with input or length != 3
            if (count($parts)!==3) continue;
            if ($parts[0]!=="input") continue;

            // Set the value
            $section = $this->sections[$parts[1]];
            $setting = $section->settings[$parts[2]];
            $setting->value = $value;
        }
    }
};

?>
