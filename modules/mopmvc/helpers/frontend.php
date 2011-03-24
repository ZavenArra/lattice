<?

class frontend {
	public static function makeHtmlElement($element, $prefix, $indent=''){

		$field = $element->getAttribute('field');

		switch($element->nodeName){
		case 'list':
			$family = $element->getAttribute('family');
			$addables = mop::config('objects', 'addableObject', $element);		
			$addable = $addables->item(0);
			$templateName = $addable->getAttribute('templateName');
			$listItemElements = mop::config('objects', sprintf('//template[@name="%s"]/elements/*', $templateName));		
			echo $indent."<ul id=\"$family\" >\n";
			echo $indent."<?foreach({$prefix}['$family'] as \$label => \${$family}ListItem):?>\n";
			echo $indent." <li class=\"$templateName\">\n";
			foreach($listItemElements as $element){
				frontend::makeHtmlElement($element, "\${$family}ListItem", $indent.'  ');
			}
			echo $indent." </li>\n";
			echo $indent."<?endforeach;?>\n";
			echo $indent."</ul>\n\n";
			break;

		case 'image':
			if(!($size=$element->getAttribute('size'))){
				$size = 'original';	
			}
			echo $indent."<?if(is_object({$prefix}['$field'])):?>\n";
			echo $indent." <img id=\"$field\" src=\"<?={$prefix}['$field']->{$size}->fullpath;?>\" width=\"<?={$prefix}['$field']->{$size}->width;?>\" height=\"<?={$prefix}['$field']->{$size}->height;?>\" alt=\"<?={$prefix}['$field']->{$size}->filename;?>\" />\n";
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
			echo $indent." <input type=\"checkbox\" name=\"".$element->getAttribute('field')."\" ".
				"<?echo ({$prefix}['$field'])?'checked ':'';?> disabled>\n";
			echo $indent."</div>\n\n";
			break;
		default:
			echo $indent."<p class=\"$field\"> <?={$prefix}['$field'];?></p>\n\n";
			break;
		}

	}

}

