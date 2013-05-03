<?
Class GraphTest extends Kohana_UnitTest_TestCase {

	public function testGraphExists(){
    $object = Graph::object();
    $this->assertNotNull($object);
	}

	public function testGraphCreateObject(){
    $object = Graph::create_object('article', 'anArticle');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

	public function testGraphCreateObjectWithKey(){
    $object = Graph::create_object('article', 'testkey');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

  
  public function testGraphLoadObject(){
    $object = Graph::create_object('article', 'testkey');
    $objectId = $object->id;
    $object = Graph::object($objectId);
    $this->assertTrue($object->loaded());
    $object->delete();
  }

  
  public function testGraphDeleteObject(){
    $object = Graph::create_object('article', 'anotherArticle');
    $objectId = $object->id;
    $object->delete();
    $object = Graph::object($objectId);
    $this->assertFalse($object->loaded());
  }

}
