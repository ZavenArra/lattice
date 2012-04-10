<?
Class GraphObjectAuthRolesTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph::createObject('article', 'test');

    $role = ORM::Factory('role', array('name'=>'editor'));
    if(!$role->loaded()){
      $role = ORM::Factory('role');
      $role->name = 'editor';
      $role->save();
    }

  }

  public static function tearDownAfterClass(){
    $object = Graph::object('test');
    $object->delete();

    $role = ORM::Factory('role', array('name'=>'editor'));
    //$role->delete();
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
    $objectId = Graph::createObject('editorOnlyObjectType', 'editorOnlyTest');
    $object = Graph::object($objectId);
    $this->assertTrue($object->checkRoleAccess('editor'), 'Configured access does not have access');
    $this->assertFalse($object->checkRoleAccess('admin'), 'Unconfigured access has access');
    $object->delete();
  }

  public function testChangeAccess(){
    $objectId = Graph::createObject('editorOnlyObjectType', 'editorOnly2');
    $object = Graph::object($objectId);
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

  public function testDoubleAddDoesntBreak(){
    $object = Graph::createObject('article', 'testDoubleAddDoesntBreak');
    $object->addRoleAccess('editor');
    $object->addRoleAccess('editor');
    $this->assertTrue($object->checkRoleAccess('editor'));
    $object->delete();
  }

}
