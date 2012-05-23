<?php
require_once('model/model.php');
require_once('model/metadata.php');

class ModelTest extends PHPUnit_Framework_TestCase {
    public function testDefaultConstructor() {
        $model = new Model();

        $this->assertEquals(is_array($model->sections),true);
    } 

    public function testReadSectionMetadata(){
        $metadata = <<<EOF
[section]
name=section name
tooltip=tooltip
script variable = variable
always enable =true 

EOF;
        $model = new Model();
        ReadSectionMetadata($model,$metadata);

        $this->assertTrue(array_key_exists('section',$model->sections));
        $this->assertEquals($model->sections['section']->Name(),'section name');
        $this->assertEquals($model->sections['section']->Tooltip(),'tooltip');
        $this->assertEquals($model->sections['section']->ScriptVariable(),'variable');
        $this->assertTrue($model->sections['section']->IsEnabled());
    }
}

?>
