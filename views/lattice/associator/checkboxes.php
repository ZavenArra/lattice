<div id="<?=$lattice;?><?=$parentId;?>" data-objectid="<?=$parentId;?>" data-lattice="<?=$lattice;?>" class="module cms_associator_checkboxes classPath-lattice_modules_CheckboxAssociator clearfix">

  <h4><?=$label;?></h4>

  <ul class="associated clearfix ">
    <?foreach($associated as $view):?>
      <?=$view->render();?>
    <?endforeach;?>
    <?foreach($pool as $view):?>
      <?=$view->render();?>
    <?endforeach;?>
  </ul>
  
</div>
