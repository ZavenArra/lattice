<?php

class Kohana_View_Csv_Container {

  private $_indent = 0;
  private $_object = 0;
  private $_object_type_name = '';
  private $skip_fields = array('slug', 'id', 'dateadded', 'objecttypename');

  public function __construct($indent, $object)
  {
    $this->_indent = $indent;
    $this->_object = $object;
    $this->_object_type_name = $object->objecttype->objecttypename;
  }

  public function render()
  {

    $object_type_line = array_pad(array($this->_object_type_name), -1 - $this->_indent, '');
    $csv = latticeutil::array_to_csv($object_type_line, ',');
    $csv .= "\n";

    return $csv;
  }
}

