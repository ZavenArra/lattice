<?php
/* @package Lattice */

class Lattice_Frontend_Front {
  public static function make_html_element($element, $prefix, $indent='')
  {

    $field = $element->getAttribute('name');

    switch($element->nodeName)
    {
    case 'image':
      if ( ! ($size=$element->getAttribute('size')))
      {
        $size = 'original';	
      }
      echo $indent."<?phpif (is_object({$prefix}['$field'])):?>\n";
      echo $indent." <img id=\"$field\" src=\"<?php=core_url::site({$prefix}['$field']->{$size}->fullpath);?>\" width=\"<?php={$prefix}['$field']->{$size}->width;?>\" height=\"<?php={$prefix}['$field']->{$size}->height;?>\" alt=\"<?php={$prefix}['$field']->{$size}->filename;?>\" />\n";
      echo $indent."<?phpendif;?>\n\n";
      break;
    case 'file':
      echo $indent."<?phpif (is_object({$prefix}['$field'])):?>\n";
      echo $indent."<a href=\"<?php={$prefix}['$field']->fullpath;?>\"><?php={$prefix}['$field']->filename;?></a>\n\n";
      echo $indent."<?phpendif;?>\n\n";
      break;
    case 'checkbox':
      echo $indent."<div type=\"checkbox_result\">\n";
      echo $indent." <label>".$element->getAttribute('label')."</label>\n";
      echo $indent." <input type=\"checkbox\" name=\"".$element->getAttribute('name')."\" ".
        "<?phpecho ({$prefix}['$field'])?'checked=\"TRUE\" ':'';?> disabled=\"disabled\" >\n";
      echo $indent."</div>\n\n";
      break;
    case 'tags':
      echo $indent."<p class=\"$field\"> <?php=implode({$prefix}['$field'], ', ');?></p>\n\n";
      break;
    case 'associator':

      break;
    default:
      echo $indent."<p class=\"$field\"> <?php={$prefix}['$field'];?></p>\n\n";
      break;
    }

  }

}

