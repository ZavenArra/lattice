<?
Class GraphTest extends Kohana_UnitTest_TestCase {

	public function testGraphExists(){
    $object = Graph::object();
    $this->assertNotNull($object);
	}

	public function testGraphNewObject(){
    $object = Graph::object();
    $object->save();
    $this->assertTrue($object->loaded());
    return $object->id;
	}

	public function testGraphCreateObject(){
    $object = Graph::createObject('article');
    $this->assertTrue($object->loaded());
    $object->delete();
	}

  
  /**
   * @depends testGraphNewObject
   */
  public function testGraphLoadObject($objectId){
    $object = Graph::object($objectId);
    $this->assertTrue($object->loaded());
  }

  
  /**
   * @depends testGraphNewObject
   */
  public function testGraphDeleteObject($objectId){
    $object = Graph::object($objectId);
    $object->delete();
    $this->assertFalse($object->loaded());
  }

}
