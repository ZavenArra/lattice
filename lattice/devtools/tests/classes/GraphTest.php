<?
Class GraphTest extends Kohana_UnitTest_TestCase {

	public function testGraphExists(){
    $object = Graph::object();
    $this->assertNotNull($object);
	}

	public function testGraphCreateObject(){
    $object = Graph::object();
    $object->save();
    $this->assertTrue($object->loaded());
    return $object->id;
	}
  
  /**
   * @depends testGraphCreateObject
   */
  public function testGraphLoadObject($objectId){
    $object = Graph::object($objectId);
    $this->assertTrue($object->loaded());
  }

  
  /**
   * @depends testGraphCreateObject
   */
  public function testGraphDeleteObject($objectId){
    $object = Graph::object($objectId);
    $object->delete();
    $this->assertFalse($object->loaded());
  }

}
