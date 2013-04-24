<?if ( count($potential_parents) >1 ):?>
<div class="moveWidget clearfix">
	<h5>Move</h5>
	<? $opts = array( 'Move this page to...' ) + $potential_parents;?>
	<?=form::select('move', $opts ); ?>
</div>
<?endif;?>
