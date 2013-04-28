<?
Class LatticeCmsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
  }

  public static function tearDownAfterClass(){
  }


  public function testMoveHtml(){
    Graph::create_object('category', 'cat1');
    Graph::create_object('category', 'cat2');
    Graph::create_object('category', 'cat3');
    Graph::create_object('category', 'cat4');
    $anArticle = Graph::create_object('article', 'articl1');
    $html = Cms_Core::move_node_html($anArticle);
    $this->assertNotNull($html);
    
  }


}
