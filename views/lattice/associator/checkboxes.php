<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator_checkboxes classPath-lattice_modules_CheckboxAssociator clearFix">
	<?=$label;?>
	<div data-field="<?=$lattice;?>">
		<label class="groupLabel"><?=$label;?></label>
		<?foreach( Associator_Checkboxes::makePool($associated, $pool) as $view):?>
			<?=$view->render();?>
		<?endforeach;?>
	</div>
</div>
