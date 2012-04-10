<?
Class ModelObjectTypeTest extends Kohana_UnitTest_TestCase {

  public static $ot;
  public static $object;

  public static function setUpBeforeClass(){
    self::$ot = ORM::Factory('objecttype', 'article');
    self::$object = Graph::object()->addObject('defaultsTest', array('slug'=>'defaults-test'));
  }

  public static function tearDownAfterClass(){
    self::$ot->delete();
    self::$object->delete();
  }


  public function testDefaultsFunction(){

    $this->assertNotNULL(self::$ot->defaults());

  }

  public function testDefaultsLoad(){
    $object = self::$object;
    $defaults = $object->objecttype->defaults();
    $this->assertNotNULL($defaults['dateField']);
    //$this->assertTrue(1 == preg_match('^([1-3][0-9]{3,3})-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2][1-9]|3[0-1])\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9])$', $defaults['dateField']));
    // failing? bad regex?
  }

  public function testDefaultsSave(){
    $object = self::$object;
    //print_r($object->getPageContent());
    $this->assertNotNULL($object->dateField);
    $this->assertNULL($object->dateFieldNoDefault);
    $this->assertNotNULL($object->textFieldDefault);
    $this->assertTrue($object->textFieldDefault == 'Some Default Text');
    $this->assertNULL($Object->textFieldNoDefault);
  }


}
