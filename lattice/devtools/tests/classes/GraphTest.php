<?
Class GraphTest extends Kohana_UnitTest_TestCase {

	public function testGraphExists(){
    $object = Graph::object();
    $this->assertNotNull($object);
	}

	public function testGraphCreateObject(){
    $object = Graph::createObject('article');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

	public function testGraphCreateObjectWithKey(){
    $object = Graph::createObject('article', 'testkey');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

  
  public function testGraphLoadObject(){
    $object = Graph::createObject('article', 'testkey');
    $objectId = $object->id;
    $object = Graph::object($objectId);
    $this->assertTrue($object->loaded());
    $object->delete();
  }

  
  public function testGraphDeleteObject(){
    $object = Graph::createObject('article');
    $objectId = $object->id;
    $object->delete();
    $object = Graph::object($objectId);
    $this->assertFalse($object->loaded());
  }

}
