<div id="" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module associator_radio classPath-lattice_modules_RadioAssociator clearFix">

<?=$label;?>

<div class="ui-RadioGroup " data-field="<?=$lattice;?>">
    <label class="groupLabel"><?=$label;?></label>
			<fieldset>
        <?foreach( Associator_Radios::makePool($associated, $pool) as $view):?>

          <?=$view->render();?>

      <?endforeach;?>
			</fieldset>
	</div>
</div>
