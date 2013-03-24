<?
Class ControllerAssociatorTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    Graph_Core::createObject('singleAssociator', 'associateTest');
    Graph_Core::createObject('singleAssociator', 'associateTest2');
  }

  public static function tearDownAfterClass(){
    Graph_Core::object('associateTest')->delete();
    Graph_Core::object('associateTest2')->delete();
  }

  public function testAssociateAction(){
    $request = Request::Factory('associator/associate/associateTest/associateTest2/myAssociation');
    $request->execute();
  }

  public function testDisociateAction(){
    $request = Request::Factory('associator/dissociate/associateTest/associateTest2/myAssociation');
    $request->execute();
  }

  public function testFilterAction(){
    $request = Request::Factory('associator/filterPoolByWord/associateTest/myAssociation/the');
    $request->execute();
  }

}
