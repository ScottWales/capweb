<?php
require_once('model/model.php');

class ModelTest extends PHPUnit_Framework_TestCase {
    public function testDefaultConstructor() {
        $model = new Model();

        $this->assertEquals(is_array($model->sections),true);
    } 
}

?>
