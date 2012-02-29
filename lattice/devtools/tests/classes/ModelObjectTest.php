<?
Class ModelObjectTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph::createObject('article', 'modelObjectTest');
    $object->title = 'The House';
    $object->save();
    $object = Graph::createObject('article', 'modelObjectTest2');
    $object = Graph::createObject('article', 'modelObjectTest3');
  }

  public static function tearDownAfterClass(){
    Graph::object('modelObjectTest')->delete();
    Graph::object('modelObjectTest2')->delete();
    Graph::object('modelObjectTest3')->delete();
  }

  public function testContentFilterMethodExists(){
    $object = Graph::object();
    $wheres = array();
    $wheres[] = array('title', '=', 'match'); //won't match anything
    $results = $object->contentFilter($wheres);
  }

  public function testContentFilterNoResults(){
    $object = Graph::object();
    $wheres = array();
    $wheres[] = array('title', '=', '2349oiupoupoiuwfpoiaso;dfkaopiuop'); //won't match anything
    $results = $object->contentFilter($wheres)->find_all();
    $this->assertTrue(count($results)==0);
  }

  public function testContentFilterResults(){
    $objects = Graph::object();
    $wheres = array();
    $wheres[] = array('title', 'LIKE', '%House%'); //won't match anything
    $results = $objects->contentFilter($wheres)->find_all();
    $this->assertTrue(count($results)>0);
  }

  public function testNext(){
    $objectQuery = Graph::object()->objectTypeFilter('article');
    $next = $objectQuery->next('dateadded', Graph::object('modelObjectTest2')->id);
    $this->assertNotNULL($next);
    echo 'wlll';
    echo $next->slug;
    $this->assertTrue($next->slug == 'modelObjectTest2');
  }


  public function testPrev(){
    $objectQuery = Graph::object()->objectTypeFilter('article');
    $objectQuery->prev('dateadded',  Graph::object('modelObjectTest2')->id);
    $this->assertNotNULL($prev);
    $this->assertTrue($prev->slug == 'modelObjectTest');
  }
}
