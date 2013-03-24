<?
Class Graph_CoreTest extends Kohana_UnitTest_TestCase {

	public function testGraph_CoreExists(){
    $object = Graph_Core::object();
    $this->assertNotNull($object);
	}

	public function testGraph_CoreCreateObject(){
    $object = Graph_Core::createObject('article', 'anArticle');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

	public function testGraph_CoreCreateObjectWithKey(){
    $object = Graph_Core::createObject('article', 'testkey');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

  
  public function testGraph_CoreLoadObject(){
    $object = Graph_Core::createObject('article', 'testkey');
    $objectId = $object->id;
    $object = Graph_Core::object($objectId);
    $this->assertTrue($object->loaded());
    $object->delete();
  }

  
  public function testGraph_CoreDeleteObject(){
    $object = Graph_Core::createObject('article', 'anotherArticle');
    $objectId = $object->id;
    $object->delete();
    $object = Graph_Core::object($objectId);
    $this->assertFalse($object->loaded());
  }

}
