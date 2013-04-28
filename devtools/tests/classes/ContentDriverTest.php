<?
Class ContentDriverTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    Graph::create_object('article', 'content-driver-test');
  }

  public static function tearDownAfterClass(){
    Graph::object('content-driver-test')->delete();
  }

  public function testDriverInfo(){
    $info = Graph::object('content-driver-test')->contentDriver()->driverInfo();
    $this->assertTrue(is_array($info));
    $this->assertTrue(isset($info['driver']));
    $this->assertTrue(isset($info['tableName']));
  }

  /*
    Disabled until there is a clear way to bypass user access
    controll on controller_cms, or controller cms should not be access
    controlled by default in development?
   *
  public function testAssociateAction(){
    $request = new Request('welcome');
    $response = new Response();
    $cms = new Controller_CMS($request, $response);  
  }
   */

}
