<div class="ui-DateRangePicker <?=$class;?>" data-field='<?=$name;?>'>
	<?if(isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
	<input type="text" class="startDate field-dateRange_startDate" value="<?=$startDate;?>-<?=$endDate;?>" />
	<img src="modules/latticeui/views/images/spinner.gif" width="12" height="12" alt="saving date range..." class="hidden spinner" />
</div>
