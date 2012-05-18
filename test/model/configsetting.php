<?php
require_once('model/configsetting.php');

class ConfigSettingTest extends PHPUnit_Framework_TestCase {
    public function testDefaultConstructor(){
        $id = "test_id<foo>%/\"\spe'cial\n;!@$#^*&-+=^chars";
        $section = $this
            ->getMockBuilder('ConfigSection')
            ->disableOriginalConstructor()
            ->getMock();
        $section
            ->expects($this->any())
            ->method('Key')
            ->will($this->returnValue('section'.$id));

        $setting = new ConfigSetting($id,$section);
        $this->assertEquals($section->Key().'-'.$id,$setting->Key());
        $this->assertEquals($id,$setting->Name());
        $this->assertEquals($id,$setting->ScriptVariable());
        $this->assertEquals("",$setting->Value());
        $this->assertEquals($id,$setting->Tooltip());
        $this->assertEquals('text',$setting->Type());
        return $setting;
    }

    /**
     * @depends testDefaultConstructor
     */
    public function testSetMetadata(ConfigSetting $setting){
        $id = $setting->Key();

        $metadata = array();
        $metadata['name'] = 'name'.$id;
        $metadata['tooltip'] = 'tooltip'.$id;

        $setting->SetMetadata($metadata);
        $this->assertEquals($id,$setting->Key());
        $this->assertEquals('name'.$id,$setting->Name());

        // Setting metadata should be additive, replacing when an old value is found
        $metadata = array();
        $metadata['tooltip'] = 'new tooltip'.$id;
        $metadata['script variable'] = 'script variable'.$id;
        $metadata['type'] = 'type'.$id;

        $setting->SetMetadata($metadata);
        $this->assertEquals('name'.$id,$setting->Name());
        $this->assertEquals('new tooltip'.$id,$setting->Tooltip());
        $this->assertEquals('script variable'.$id,$setting->ScriptVariable());
        $this->assertEquals('type'.$id,$setting->Type());

        return $setting;
    }

    /**
     * @depends testDefaultConstructor
     */
    public function testSetValue(ConfigSetting $setting){
        $id = $setting->Key();
        $setting->value = 'value'.$id;

        $this->assertEquals('value'.$id,$setting->Value());

        return $setting;
    }

    public function testPrerequisite(){
        $section = $this
            ->getMockBuilder('ConfigSection')
            ->disableOriginalConstructor()
            ->getMock();
        $section
            ->expects($this->any())
            ->method('Key')
            ->will($this->returnValue('section'));

        $a = new ConfigSetting("a",$section);
        $b = new ConfigSetting("b",$section);

        $metadata = array();
        $metadata['prerequisite'] = array('section/a==value');
        $b->SetMetadata($metadata);

        $a->value = false;
        $this->assertEquals(false,$b->IsEnabled());
        $a->value = 'value';
        $this->assertEquals(true,$b->IsEnabled());
    }
}
