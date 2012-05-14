<?php

// Simple class to hold a config (value and metadata)
class ConfigNode {
    $metadata;
    $value;

    // Add metadata to the node
    public function SetMetadata($value){

    }

    // Set the node's value
    // TODO: check the value maintains assertions
    // TODO: update dependancies on being set
    public function SetValue($value){

    }
};

class Model {
    // Read a metadata file and parse it into the config layout
    public function LoadMetadata($filename){
        $ini = $this->ReadIni($filename);
        foreach ($ini as $key=>$value){
            $this->AddConfigNodeMetadata($key,$value);
        }
    }

    // Reads a config file and parse it into the config layout
    public function LoadConfig($filename){
        $ini = $this->ReadIni($filename);
        foreach ($ini as $key=>$value){
            $this->AddConfigNodeValue($key,$value);
        }
    }
    
    // Reads a ini file into an internal structure
    private function ReadIni($filename){
        $file = file_get_contents($filename);
        // Strip comments (# can be escaped with \)
        $file = preg_replace('/[^\\\\]#.*$/m','',$file);
        // Join continued lines
        $file = preg_replace('/[^\\\\]\\\\\n/m','',$file);
        $ini = parse_ini_string($file);
        return $ini;
    }

    // An array of config nodes, e.g. Grid
    private $confignodes;

    // Finds $key in $configs, creating a node for it if 
    // necessary, and add metadata in $value to it
    private function AddConfigNodeMetadata($key,$value){
        $config = $this->FindConfigNode($key);
    }

    // Finds $key in $configs, creating a node for it if 
    // necessary, and add the values
    private function AddConfigNodeValue($key,$value){
        $config = $this->FindConfigNode($key);
        $config->AddValues($value);
    }

    // Return a config section
    private function FindConfigNode($key){
        if (!isset($confignodes[$key])){
            $confignodes[$key] = new ConfigNode($key);
        }
        return $confignodes[$key];
    }
};

?>
