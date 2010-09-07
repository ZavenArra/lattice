<div <?=isset( $id )? 'id="'. $id . '"' : "";?> class="ui-DateRangePicker field-<?=$field;?> <?=$class;?>">
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<input type="text" class="startDate field-dateRange_startDate" value="<?=$startDate;?>" />
	<input type="text" class="endDate field-dateRange_endDate" value="<?=$endDate;?>"/>
	<img src="modules/mopui/views/images/spinner.gif" width="12" height="12" alt="saving date range..." class="hidden spinner" />
</div>
