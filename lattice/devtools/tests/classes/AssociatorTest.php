<?
Class AssociatorTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
    Graph::createObject('article', 'associatorTestArticle');
  }

  public static function tearDownAfterClass(){
    Graph::object('associatorTestArticle')->delete();
  }

  private $articleFilter = array(
    array(
      'objectTypeName'=>'article'
    )
  );



  public function testNewAssociator(){
    $a = new Associator('single-association', 'myAssociation');
    $this->assertNotNULL($a);
    return $a;
  }

  public function testNewAssociatorWithObjectTypeName(){

    $a = new Associator('single-association', 'myAssociation', $this->articelFilter);
    $this->assertNotNULL($a);
    return $a;
  }

  public function testAssociatorPoolWithAll(){

    $a = new Associator('single-association', 'myAssociation');
    $this->assertNotNULL($a->pool);
    $this->assertTrue(count($a->pool) > 0);
    return $a;
  }

  public function testAssociatorPoolWithObjectTypeName(){

    $a = new Associator('single-association', 'myAssociation', $this->articleFilter);
    $this->assertNotNULL($a->pool);
    $this->assertTrue(count($a->pool) > 0);
    return $a;
  }

  /**
   * @depends testNewAssociator
   */
  public function testAssociatorRender($a){
    $html = $a->render();
    $this->assertNotNull($html);
  }

  /**
   * @depends testNewAssociatorWithObjectTypeName
   */
  public function testAssociatorRenderWithObjectTypeFilter($a){
    $html = $a->render();
    $this->assertNotNull($html);
  }

  public function testAssociatorPoolExcludesAssociated(){
    $object1 = Graph::instance()->addObject('article', array('slug'=>'test1'));
    $object1 = Graph::object($object1);
    $object2 = Graph::instance()->addObject('article', array('slug'=>'test2'));
    $object2 = Graph::object($object2);
    $object3 = Graph::instance()->addObject('article', array('slug'=>'test3'));
    $object3 = Graph::object($object3);

    $object1->addLatticeRelationship('testAssociation', $object2->id);

    $a = new Associator($object1->id, 'testAssociation', $this->articleFilter);
    $this->assertTrue($this->resultContainsObjectWithId($a->associated, $object2->id));
    $this->assertFalse($this->resultContainsObjectWithId($a->pool, $object2->id));
  }

  private function resultContainsObjectWithId($result, $id){
    foreach($result as $row){
      if($row->id == $id){
        return true;
      }
    }
    return false;
  }

}
