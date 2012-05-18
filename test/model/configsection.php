<?php

require_once('model/configsection.php');

class ConfigSectionTest extends PHPUnit_Framework_TestCase {

    public function testDefaultConstructor(){
        $id = "test_id<foo>%/\"\spe'cial\n;!@$#^*&^chars";
        $section = new ConfigSection($id);
        $this->assertEquals($id,$section->Key());
        $this->assertEquals($id,$section->Name());
        $this->assertEquals($id,$section->ScriptVariable());
        $this->assertEquals('metadata/'.$id.'.ini',$section->SettingMetadataFile());
        $this->assertEquals(false,$section->AlwaysEnable());
        $this->assertEquals(false,$section->IsEnabled());
        return $section;
    }

    /**
     * @depends testDefaultConstructor
     */
    public function testSetMetadata(ConfigSection $section){
        $id = $section->Key();

        $metadata = array();
        $metadata['name'] = 'name'.$id;
        $metadata['tooltip'] = 'tooltip'.$id;

        $section->SetMetadata($metadata);
        $this->assertEquals($id,$section->Key());
        $this->assertEquals('name'.$id,$section->Name());

        // Setting metadata should be additive, replacing when an old value is found
        $metadata = array();
        $metadata['tooltip'] = 'new tooltip'.$id;
        $metadata['script variable'] = 'script variable'.$id;
        $metadata['metadata file'] = 'metadata file'.$id;
        $metadata['always enable'] = 'always enable'.$id;

        $section->SetMetadata($metadata);
        $this->assertEquals('name'.$id,$section->Name());
        $this->assertEquals('new tooltip'.$id,$section->Tooltip());
        $this->assertEquals('script variable'.$id,$section->ScriptVariable());
        $this->assertEquals('metadata file'.$id,$section->SettingMetadataFile());
        $this->assertEquals(false,$section->AlwaysEnable());
        $this->assertEquals(false,$section->IsEnabled());

        return $section;
    }

    /**
     * @depends testSetMetadata
     */
    public function testSetEnable(ConfigSection $section){
        $metadata = array();
        $metadata['always enable'] = 'true';
        $section->SetMetadata($metadata);
        $section->enabled = false;
        $this->assertEquals(true,$section->AlwaysEnable());
        $this->assertEquals(true,$section->IsEnabled());

        $metadata = array();
        $metadata['always enable'] = 'false';
        $section->SetMetadata($metadata);
        $section->enabled = true;
        $this->assertEquals(false,$section->AlwaysEnable());
        $this->assertEquals(true,$section->IsEnabled());
    }
};

?>
