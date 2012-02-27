<?
Class ControllerAssociatorTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    Graph::createObject('singleAssociator', 'associateTest');
    Graph::createObject('singleAssociator', 'associateTest2');
  }

  public static function tearDownAfterClass(){
    Graph::object('associateTest')->delete();
    Graph::object('associateTest2')->delete();
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
