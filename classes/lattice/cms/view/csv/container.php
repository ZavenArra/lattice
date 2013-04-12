<?php

class Lattice_Cms_View_Csv_Container {

  private $_indent = 0;
  private $_object = 0;
  private $_objectTypeName = '';
  private $skip_fields = array('slug', 'id', 'dateadded', 'objecttypename');

  public function __construct($indent, $object)
  {
    $this->_indent = $indent;
    $this->_object = $object;
    $this->_objectTypeName = $object->objecttype->objecttypename;
  }

  public function render()
  {

    $object_type_line = array_pad(array($this->_objectTypeName), -1 - $this->_indent, '');
    $csv = cms_util::array_to_csv($object_type_line, ',');
    $csv .= "\n";

    return $csv;
  }
}

