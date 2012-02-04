<?
Class ObjectRolesTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph::object();
    $object->slug = 'test';
    $object->save();
  }

  public static function tearDownAfterClass(){
    $object = Graph::object('test');
    $object->delete();
  }

	public function testCrossTableExists(){
    $object = Graph::object();
    $this->assertNotNULL($object->roles);
	}

  public function testAddRole(){
    $object = Graph::object('test');
    $object->addRoleAccess('admin');
  }

  public function testCheckAccess(){
    $object = Graph::object('test');
    $this->assertTrue($object->checkRoleAccess('admin'));
  }

  public function testRemoveRole(){
    $object = Graph::object('test');
    $object->removeRoleAccess('admin');
  }

  public function testCheckNoAccess(){
    $object = Graph::object('test');
    $this->assertFalse($object->checkRoleAccess('admin'));
  }

  public function testResetAccessExists(){
    $object = Graph::object('test');
    $object->resetRoleAccess();
  }

  public function testCreateWithConfiguredAccess(){
    $object = Graph::object()->addObject('editorOnlyObjectType');
    $this->assertTrue($object->checkRoleAccess('editor'));
    $this->assertFalse($object->checkRoleAccess('admin'));
    $object->delete();
  }

  public function testChangeAccess(){
    $object = Graph::object()->addObject('editorOnlyObjectType');
    $object->removeRoleAccess('editor');
    $object->addRoleAccess('admin');
    $this->assertFalse($object->checkRoleAccess('editor'));
    $this->assertTrue($object->checkRoleAccess('admin'));
    return $object;
  }

  /**
   * @depends testChangeAccess
   */
  public function testResetAccess($object){
    $object->resetRoleAccess();
    $this->assertTrue($object->checkRoleAccess('editor'));
    $this->assertFalse($object->checkRoleAccess('admin'));
    $object->delete();
  }

}
