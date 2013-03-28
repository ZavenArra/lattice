<?
Class LatticeUITest extends Kohana_UnitTest_TestCase {

  public static function setUpBeforeClass(){
  }

  public static function tearDownAfterClass(){
  }


  public function testLinkObject(){
    $elements = Lattice::config('objects', '//objectType[@name="link"]/elements/*');

    $this->assertNotNULL($elements);

    $elementsConfig = array();
    foreach ($elements as $element) {

      $entry = latticecms::convertXmlElementToArray($object, $element);

      $elementsConfig[$entry['name']] = $entry;
    }


    $ui = latticecms::buildUIHtmlChunks($elementsConfig);

    $this->assertNotNULL($ui);
    $this->assertNotNULL($ui['text_url']);

  }

  public function testCluster(){

    $objectId = Graph::object()->addObject('clusterTest', array('slug'=>'cluster-test'));
    $object = Graph::object($objectId);

    $ui = latticecms::buildUIHtmlChunksForObject($object);

    $this->assertNotNULL($ui);
    $this->assertNotNULL($ui['link_myLink']);
    $this->assertTrue(count(strstr($ui['link_myLink'], 'url')) > 0);

    $object->delete();
  }


}
