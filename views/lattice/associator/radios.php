<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator_radio classPath-lattice_modules_RadioAssociator clearFix">
	<?=$label;?>
	<div data-field="<?=$lattice;?>">
		<label class="groupLabel"><?=$label;?></label>
		<fieldset class="radios">
		<?foreach( Cms_Associator_Radios::makePool($associated, $pool) as $view):?>
			<?=$view->render();?>
		<?endforeach;?>
		</fieldset>
	</div>
</div>
