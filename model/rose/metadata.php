<?php 

// Reads metadata in Rose's format, storing into a tree structure of sections and options
//
// <<EOF
// [section]
// key=value # Comment
// !commented=key
//
// [!commented:section]
// unused=keys
//
// [section:path=option]
// key=value
// key=very \
// long value
// EOF
//
// parses to
//
// <<EOF
// [section]
// key=value
// [section:path=option]
// key=value
// key=very long value
// EOF

namespace Rose;

class Metadata {
    private $sections = array();

    public function Read($filename){
        // Read the file as .ini
        $file = file_get_contents($filename);
        // Strip comments
        $file = preg_replace('/[^\\\\]#.*$/m','',$file);
        $file = preg_replace('/\\\\\n/m','',$file);
        echo($file);
        $ini = parse_ini_string($file,TRUE);

        // Loop over each section and add the metadata
        foreach ($ini as $key => $value){
            $item = GetItem($key,$this->sections);
            $item->Set($value);
        }
    } 

};

// Get the item object corresponding to a config file section,
// creating objects if required
function GetItem($key, &$items){
    // Split the key into [section, item]
    $split = explode('=',$key,2);
    if (isset($split[0])) $pathname=$split[0];
    if (isset($split[1])) $itemname=$split[1];

    // Split the namespace into [parent, children]
    $split = explode(':',$pathname,2);
    if (isset($split[0])) $parentname=$split[0];
    if (isset($split[1])) $childname=$split[1];

    // Find the parent
    if (!isset($items[$parentname])){
        $items[$parentname] = new Section();
    }
    $parent = $items[$parentname];

    // Check if sub namespaces exists then recurse
    if (isset($childname)){
        // Look through the rest of the namespace, adding the item name back onto the key
        $newkey = $childname;
        if (isset($itemname)){
            $newkey = $childname.'='.$itemname;
        }
        return GetItem($newkey,$parent->items);

    } else {
        // At the end of the namespace, check for the item
        if (!isset($itemname)){
            return $parent;
        }
        if (!isset($parent->items[$itemname])){
            $parent->items[$itemname] = new Option();
        }
        return $parent->items[$itemname];
    }
}

// Common information
class SectionBase {
    public $ns;
    public $sort_key;
    public $url;
    public $help;
    public $description;
    public $title;

    // Use reflection to set values
    public function Set($values){
        foreach ($values as $key => $value){
            // Need to make sure the property exists or php will create it!
            if (property_exists($this,$key) && !isset($this->{$key})) $this->{$key}=$value;
        }
    }
};

// Sections hold items
class Section extends SectionBase {
    public $items;
};

// Items hold information about their variables
class Option extends SectionBase {
    public $type;
    public $length;
    public $values;
    public $range;
    public $pattern;
    public $fail_if;
    public $warn_if;
    public $compulsory;
    public $trigger;
    public $duplicate;
    public $widget;
};

?>

