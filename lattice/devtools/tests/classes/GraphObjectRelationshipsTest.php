<?
Class GraphObjectRelationshipsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph::object();
    $object->slug = 'test';
    $object->save();

    $object = Graph::object();
    $object->slug = 'testAssoc';
    $object->save();
  }

  public static function tearDownAfterClass(){
    $object = Graph::object('test');
    $object->delete();
    $object = Graph::object('testAssoc');
    $object->delete();
  }

	public function testAddRelationship(){
    $object = Graph::object('test');
    $newObject = Graph::object('testAssoc');
    $object->addLatticeRelationship('testlattice', $newObject->id);
    $associated = $object->getLatticeChildren('testlattice');
    $this->assertTrue(count($associated) == 1);
    return $object;
	}

  /**
   * @depends testAddRelationship
   */
  public function testRemoveRelationship($object){
    $removeObject = Graph::object('testAssoc');
    $object->removeLatticeRelationship('testlattice', $removeObject->id);
    $associated = $object->getLatticeChildren('testlattice');
    $this->assertTrue(count($associated) == 0);
  }

  public function testMetaObjectTypeName(){
    $object = Graph::object( Graph::object()->addObject('singleAssociator') );
    $newObject = Graph::object( Graph::object()->addObject('meta') );
    $object->addLatticeRelationship('myAssociation', $newObject->id);
    $metaObjectTypeName = $object->getMetaObjectTypeName('myAssociation');
    $this->assertNotNull($metaObjectTypeName);
    $this->assertEquals($metaObjectTypeName,'meta');
  }

}
