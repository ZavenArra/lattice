<div class="ui-DateRange" data-autosubmit='false' data-field='reportDateRange'>
	<?if (isset($label)):?>
		<label><?=$label;?></label>
	<?endif;?>
  <input type="text" name="<?=$name;?>" value="<?=$startDate;?>-<?=$endDate;?>" />
	<img src="<?=url::base();?>modules/lattice/resources/images/spinner.gif" width="12" height="12" alt="saving date range..." class="hidden spinner" />
</div>
