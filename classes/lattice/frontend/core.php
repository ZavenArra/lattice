<?php
/* @package Lattice */

class Lattice_Frontend_Core {
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
      echo $indent."<?php if (is_object({$prefix}['$field'])):?>\n";
      echo $indent." <img id=\"$field\" src=\"<?php core_url::site({$prefix}['$field']->{$size}->fullpath);?>\" width=\"<?php echo {$prefix}['$field']->{$size}->width;?>\" height=\"<?php echo {$prefix}['$field']->{$size}->height;?>\" alt=\"<?php echo {$prefix}['$field']->{$size}->filename;?>\" />\n";
      echo $indent."<?php endif; ?>\n\n";
      break;
    case 'file':
      echo $indent."<?php if (is_object({$prefix}['$field'])): ?>\n";
      echo $indent."<a href=\"<?php echo {$prefix}['$field']->fullpath;?>\"><?php echo {$prefix}['$field']->filename;?></a>\n\n";
      echo $indent."<?php endif; ?>\n\n";
      break;
    case 'checkbox':
      echo $indent."<div type=\"checkbox_result\">\n";
      echo $indent." <label>".$element->getAttribute('label')."</label>\n";
      echo $indent." <input type=\"checkbox\" name=\"".$element->getAttribute('name')."\" ".
        "<?php echo ({$prefix}['$field'])?'checked=\"TRUE\" ':'';?> disabled=\"disabled\" >\n";
      echo $indent."</div>\n\n";
      break;
    case 'tags':
      echo $indent."<p class=\"$field\"> <?php echo implode({$prefix}['$field'], ', ');?></p>\n\n";
      break;
    case 'associator':

      break;
    default:
      echo $indent."<p class=\"$field\"> <?php echo {$prefix}['$field']; ?></p>\n\n";
      break;
    }

  }

}

