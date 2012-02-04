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

}
