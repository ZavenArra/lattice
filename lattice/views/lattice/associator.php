<div id="" data-objectid="ASSOCIATORID" class="module associator classPath-lattice_modules_Associator clearFix">

<ul class="associated">
<?foreach($associated as $view):?>
  <?=$view->render();?>
<?endforeach;?>
</ul>

<ul class="pool">
<?foreach($pool as $view):?>
  <?=$view->render();?>
<?endforeach;?>
</ul>


</div>
