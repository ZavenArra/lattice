<?
Class Graph_CoreObjectRelationshipsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph_Core::createObject('article', 'test');
    $object = Graph_Core::createObject('article', 'test-assoc');
  }

  public static function tearDownAfterClass(){
    $object = Graph_Core::object('test');
    $object->delete();
    $object = Graph_Core::object('test-assoc');
    $object->delete();
  }

	public function testAddRelationship(){
    $object = Graph_Core::object('test');
    $newObject = Graph_Core::object('test-assoc');
    $object->addLatticeRelationship('testlattice', $newObject->id);
    $associated = $object->getLatticeChildren('testlattice');
    $this->assertTrue(count($associated) == 1);
    return $object;
	}

  /**
   * @depends testAddRelationship
   */
  public function testRemoveRelationship($object){
    $removeObject = Graph_Core::object('test-assoc');
    $object->removeLatticeRelationship('testlattice', $removeObject->id);
    $associated = $object->getLatticeChildren('testlattice');
    $this->assertTrue(count($associated) == 0);
  }

  public function testCheckObjectRelationship(){
    $object = Graph_Core::object('test');
    $newObject = Graph_Core::createObject('article', 'test-check-assoc');
    $this->assertFalse($object->checkLatticeRelationship('testlattice', $newObject->id));
    $object->addLatticeRelationship('testlattice', $newObject->id);
    $this->assertTrue($object->checkLatticeRelationship('testlattice', $newObject->id));
    $object->removeLatticeRelationship('testlattice', $newObject->id);
    $this->assertFalse($object->checkLatticeRelationship('testlattice', $newObject->id));
    $newObject->delete();
  }

  public function testMetaObjectTypeName(){
    $object = Graph_Core::createObject('singleAssociator', 'single-associator-test');
    $newObject = Graph_Core::createObject('meta', 'meta-test');
    $object->addLatticeRelationship('myAssociation', $newObject->id);
    $metaObjectTypeName = $object->getMetaObjectTypeName('myAssociation');
    $this->assertNotNull($metaObjectTypeName);
    $this->assertEquals($metaObjectTypeName,'meta');
    $object->delete();
    $newObject->delete();
  }


}
