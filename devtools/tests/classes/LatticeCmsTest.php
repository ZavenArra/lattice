<?
Class LatticeCmsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
  }

  public static function tearDownAfterClass(){
  }


  public function testMoveHtml(){
    Graph::createObject('category', 'cat1');
    Graph::createObject('category', 'cat2');
    Graph::createObject('category', 'cat3');
    Graph::createObject('category', 'cat4');
    $anArticle = Graph::createObject('article', 'articl1');
    $html = Cms_Core::moveNodeHtml($anArticle);
    $this->assertNotNull($html);
    
  }


}
