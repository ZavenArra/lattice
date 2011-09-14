<div class="ui-Pulldown <?=$class;?>" data-field="<?=$name;?>">
	<label class="groupLabel"><?=$label;?></label>
	<!-- =form::dropdown($field, $options, $value, 'class="pulldown field-'.$field.'"'); 
        ?=form::select('state', array_slice(Kohana::config('formVariables.states'), 1), $customer->state, ' style="margin-bottom:7px;width:100%"')?>
	?=form::select($field, $options, $value, 'class="pulldown field-'.$field.'"');  ?>
	-->
	 <?=form::select( $groupLabel, $options );?> 
</div>
