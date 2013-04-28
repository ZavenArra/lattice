<?
Class GraphObjectRelationshipsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph::create_object('article', 'test');
    $object = Graph::create_object('article', 'test-assoc');
  }

  public static function tearDownAfterClass(){
    $object = Graph::object('test');
    $object->delete();
    $object = Graph::object('test-assoc');
    $object->delete();
  }

	public function testAddRelationship(){
    $object = Graph::object('test');
    $newObject = Graph::object('test-assoc');
    $object->add_lattice_relationship('testlattice', $newObject->id);
    $associated = $object->get_lattice_children('testlattice');
    $this->assertTrue(count($associated) == 1);
    return $object;
	}

  /**
   * @depends testAddRelationship
   */
  public function testRemoveRelationship($object){
    $removeObject = Graph::object('test-assoc');
    $object->remove_lattice_relationship('testlattice', $removeObject->id);
    $associated = $object->get_lattice_children('testlattice');
    $this->assertTrue(count($associated) == 0);
  }

  public function testCheckObjectRelationship(){
    $object = Graph::object('test');
    $newObject = Graph::create_object('article', 'test-check-assoc');
    $this->assertFalse($object->check_lattice_relationship('testlattice', $newObject->id));
    $object->add_lattice_relationship('testlattice', $newObject->id);
    $this->assertTrue($object->check_lattice_relationship('testlattice', $newObject->id));
    $object->remove_lattice_relationship('testlattice', $newObject->id);
    $this->assertFalse($object->check_lattice_relationship('testlattice', $newObject->id));
    $newObject->delete();
  }

  public function testMetaObjectTypeName(){
    $object = Graph::create_object('singleAssociator', 'single-associator-test');
    $newObject = Graph::create_object('meta', 'meta-test');
    $object->add_lattice_relationship('myAssociation', $newObject->id);
    $metaObjectTypeName = $object->getMetaObjectTypeName('myAssociation');
    $this->assertNotNull($metaObjectTypeName);
    $this->assertEquals($metaObjectTypeName,'meta');
    $object->delete();
    $newObject->delete();
  }


}
