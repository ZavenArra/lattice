<?
Class Graph_CoreObjectAuthRolesTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph_Core::createObject('article', 'test');

    $role = ORM::Factory('role', array('name'=>'editor'));
    if (!$role->loaded()){
      $role = ORM::Factory('role');
      $role->name = 'editor';
      $role->save();
    }

  }

  public static function tearDownAfterClass(){
    $object = Graph_Core::object('test');
    $object->delete();

    $role = ORM::Factory('role', array('name'=>'editor'));
    //$role->delete();
  }

	public function testCrossTableExists(){
    $object = Graph_Core::object();
    $this->assertNotNULL($object->roles);
	}

  public function testAddRole(){
    $object = Graph_Core::object('test');
    $object->addRoleAccess('admin');
  }

  public function testCheckAccess(){
    $object = Graph_Core::object('test');
    $this->assertTrue($object->checkRoleAccess('admin'));
  }

  public function testRemoveRole(){
    $object = Graph_Core::object('test');
    $object->removeRoleAccess('admin');
  }

  public function testCheckNoAccess(){
    $object = Graph_Core::object('test');
    $this->assertFalse($object->checkRoleAccess('admin'));
  }

  public function testResetAccessExists(){
    $object = Graph_Core::object('test');
    $object->resetRoleAccess();
  }

  public function testCreateWithConfiguredAccess(){
    $objectId = Graph_Core::createObject('editorOnlyObjectType', 'editorOnlyTest');
    $object = Graph_Core::object($objectId);
    $this->assertTrue($object->checkRoleAccess('editor'), 'Configured access does not have access');
    $this->assertFalse($object->checkRoleAccess('admin'), 'Unconfigured access has access');
    $object->delete();
  }

  public function testChangeAccess(){
    $objectId = Graph_Core::createObject('editorOnlyObjectType', 'editorOnly2');
    $object = Graph_Core::object($objectId);
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
    $object = Graph_Core::createObject('article', 'testDoubleAddDoesntBreak');
    $object->addRoleAccess('editor');
    $object->addRoleAccess('editor');
    $this->assertTrue($object->checkRoleAccess('editor'));
    $object->delete();
  }

}
