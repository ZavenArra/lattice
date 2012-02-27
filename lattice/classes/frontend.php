<?
/* @package Lattice */

class frontend {
	public static function makeHtmlElement($element, $prefix, $indent=''){

		$field = $element->getAttribute('name');

		switch($element->nodeName){
		case 'image':
			if(!($size=$element->getAttribute('size'))){
				$size = 'original';	
			}
			echo $indent."<?if(is_object({$prefix}['$field'])):?>\n";
			echo $indent." <img id=\"$field\" src=\"<?=latticeurl::site({$prefix}['$field']->{$size}->fullpath);?>\" width=\"<?={$prefix}['$field']->{$size}->width;?>\" height=\"<?={$prefix}['$field']->{$size}->height;?>\" alt=\"<?={$prefix}['$field']->{$size}->filename;?>\" />\n";
			echo $indent."<?endif;?>\n\n";
			break;
		case 'file':
			echo $indent."<?if(is_object({$prefix}['$field'])):?>\n";
			echo $indent."<a href=\"<?={$prefix}['$field']->fullpath;?>\"><?={$prefix}['$field']->filename;?></a>\n\n";
			echo $indent."<?endif;?>\n\n";
			break;
		case 'checkbox':
			echo $indent."<div type=\"checkboxResult\">\n";
			echo $indent." <label>".$element->getAttribute('label')."</label>\n";
			echo $indent." <input type=\"checkbox\" name=\"".$element->getAttribute('name')."\" ".
				"<?echo ({$prefix}['$field'])?'checked=\"true\" ':'';?> disabled=\"disabled\" >\n";
			echo $indent."</div>\n\n";
			break;
      case 'tags':
         echo $indent."<p class=\"$field\"> <?=implode({$prefix}['$field'], ', ');?></p>\n\n";
         break;
      case 'associator':

        break;
		default:
			echo $indent."<p class=\"$field\"> <?={$prefix}['$field'];?></p>\n\n";
			break;
		}

	}

}

