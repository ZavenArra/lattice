<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator_checkboxes classPath-lattice_modules_CheckboxAssociator clearFix">
	<h4><?=$label;?></h4>
	<div data-field="<?=$lattice;?>">
		<?foreach( Associator_Checkboxes::makePool($associated, $pool) as $view):?>
			<?=$view->render();?>
		<?endforeach;?>
	</div>
</div>
