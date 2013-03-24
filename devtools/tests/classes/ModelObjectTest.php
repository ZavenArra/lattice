<?
Class ModelObjectTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    $object = Graph_Core::createObject('article', 'object-test-article');
    $object->title = 'The House';
    $object->save();
    $object = Graph_Core::createObject('prevNext', 'model-object-test');
    $object->postDate = '2012-01-01';
    $object->save();
    $object = Graph_Core::createObject('prevNext', 'model-object-test2');
    $object->postDate = '2011-01-01';
    $object->save();
    $object = Graph_Core::createObject('prevNext', 'model-object-test3');
    $object->postDate = '2010-01-01';
    $object->save();

    $testParent = Graph_Core::createObject('article', 'testParent');
    $testParent->addObject('article', array('slug'=>'child1'));
    $testParent->addObject('article', array('slug'=>'child2'));
    $testParent->addObject('article', array('slug'=>'child3'));
  }

  public static function tearDownAfterClass(){
    Graph_Core::object('object-test-article')->delete();
    Graph_Core::object('model-object-test')->delete();
    Graph_Core::object('model-object-test2')->delete();
    Graph_Core::object('model-object-test3')->delete();
    Graph_Core::object('child1')->delete();
    Graph_Core::object('child2')->delete();
    Graph_Core::object('child3')->delete();
    Graph_Core::object('testParent')->delete();
  }

  public function testContentFilterMethodExists(){
    $object = Graph_Core::object();
    $wheres = array();
    $wheres[] = array('title', '=', 'match'); //won't match anything
    $results = $object->contentFilter($wheres);
  }

  public function testContentFilterNoResults(){
    $object = Graph_Core::object();
    $wheres = array();
    $wheres[] = array('title', '=', '2349oiupoupoiuwfpoiaso;dfkaopiuop'); //won't match anything
    $results = $object->contentFilter($wheres)->find_all();
    $this->assertTrue(count($results)==0);
  }

  public function testContentFilterResults(){
    $objects = Graph_Core::object();
    $wheres = array();
    $wheres[] = array('title', 'LIKE', '%House%'); //aiwll match anything
    $results = $objects->contentFilter($wheres)->find_all();
    $this->assertTrue(count($results)>0);
  }

  public function testNext(){
    //This doesn't always work because the field is not microtime
    $objectQuery = Graph_Core::object()->objectTypeFilter('prevNext');
    $next = $objectQuery->next('dateadded', Graph_Core::object('model-object-test2')->id);
    $this->assertNotNULL($next);
    $this->assertTrue($next->slug == 'model-object-test3');
  }


  public function testPrev(){
    //This doesn't always work because the field is not microtime
    $objectQuery = Graph_Core::object()->objectTypeFilter('prevNext');
    $prev = $objectQuery->prev('dateadded',  Graph_Core::object('model-object-test2')->id);
    $this->assertNotNULL($prev);
    $this->assertTrue($prev->slug == 'model-object-test');
  }

  public function testNextContentColumn(){
    $objectQuery = Graph_Core::object()->objectTypeFilter('prevNext');
    $next = $objectQuery->next('postDate', Graph_Core::object('model-object-test2')->id);
    $this->assertNotNULL($next);
    $this->assertTrue($next->slug == 'model-object-test');
  }


  public function testPrevContentColumn(){
    $objectQuery = Graph_Core::object()->objectTypeFilter('prevNext');
    $prev = $objectQuery->prev('postDate',  Graph_Core::object('model-object-test2')->id);
    $this->assertNotNULL($prev);
    $this->assertTrue($prev->slug == 'model-object-test3');
  }

  public function testChildrenQuery(){
    $items = Graph_Core::object('testParent')
      ->latticeChildrenQuery();
    $items = $items->find_all();
    $this->assertTrue(count($items)>0);
  }

  public function testChildrenQueryActive(){
    $items = Graph_Core::object('testParent')
      ->latticeChildrenQuery()
      ->activeFilter();
    $items = $items->find_all();
    $this->assertTrue(count($items)>0);
  }

  public function testChildrenQueryActiveAndOrder(){
    $items = Graph_Core::object('testParent')
      ->latticeChildrenQuery()
      ->activeFilter()
      ->order_by('objectrelationships.sortorder', 'ASC');
    $items = $items->find_all();
    $this->assertTrue(count($items)>0);
  }

  public function testMove(){
    $testParent = Graph_Core::createObject('article', 'parent-orig');
    $child = $testParent->addObject('article', array('slug'=>'the-child'));
    $child = Graph_Core::object($child);
    $newParent = Graph_Core::createObject('article', 'parent-new');
    $child->move($newParent->id);


    $found = false;
    $children = $newParent->getLatticeChildren();
    foreach($children as $testChild){
      if ($testChild->id == $child->id){
        $found = true;
        break;
      } 
    }
    $this->assertTrue($found);

    $moved = true;
    $children = $testParent->getLatticeChildren();
    foreach($children as $testChild){
      if ($testChild->id == $child->id){
        $found = false;
        break;
      } 
    }
    $this->assertTrue($moved);

    $child->delete();
    $newParent->delete();
    $testParent->delete();

  }
}
