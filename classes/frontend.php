<?php
/* @package Lattice */

class frontend {
  public static function make_html_element($element, $prefix, $indent='')
  {

    $field = $element->get_attribute('name');

    switch($element->node_name)
    {
    case 'image':
      if (!($size=$element->get_attribute('size')))
      {
        $size = 'original';	
      }
      echo $indent."<?phpif (is_object({$prefix}['$field'])):?>\n";
      echo $indent." <img id=\"$field\" src=\"<?php=latticeurl::site({$prefix}['$field']->{$size}->fullpath);?>\" width=\"<?php={$prefix}['$field']->{$size}->width;?>\" height=\"<?php={$prefix}['$field']->{$size}->height;?>\" alt=\"<?php={$prefix}['$field']->{$size}->filename;?>\" />\n";
      echo $indent."<?phpendif;?>\n\n";
      break;
    case 'file':
      echo $indent."<?phpif (is_object({$prefix}['$field'])):?>\n";
      echo $indent."<a href=\"<?php={$prefix}['$field']->fullpath;?>\"><?php={$prefix}['$field']->filename;?></a>\n\n";
      echo $indent."<?phpendif;?>\n\n";
      break;
    case 'checkbox':
      echo $indent."<div type=\"checkbox_result\">\n";
      echo $indent." <label>".$element->get_attribute('label')."</label>\n";
      echo $indent." <input type=\"checkbox\" name=\"".$element->get_attribute('name')."\" ".
        "<?phpecho ({$prefix}['$field'])?'checked=\"true\" ':'';?> disabled=\"disabled\" >\n";
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

