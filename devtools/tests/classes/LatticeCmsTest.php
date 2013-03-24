<?
Class LatticeCmsTest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
  }

  public static function tearDownAfterClass(){
  }


  public function testMoveHtml(){
    Graph_Core::createObject('category', 'cat1');
    Graph_Core::createObject('category', 'cat2');
    Graph_Core::createObject('category', 'cat3');
    Graph_Core::createObject('category', 'cat4');
    $anArticle = Graph_Core::createObject('article', 'articl1');
    $html = latticecms::moveNodeHtml($anArticle);
    $this->assertNotNull($html);
    
  }


}
