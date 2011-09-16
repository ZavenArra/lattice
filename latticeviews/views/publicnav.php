<ul>
<?foreach($navi as $object):?>
	<li id="<?=$object['slug'];?>"><a href="<?=$object['path'];?>"><?=$object['title'];?></a></li>
	<?if(isset($object['children'])):?>
		<ul>
		<?foreach($object['children'] as $child):?>
			<li id="<?=$child['slug'];?>"><a href="<?=$child['path'];?>"><?=$child['title'];?></a></li>
		<?endforeach;?>
  	</ul>
	<?endif;?>
<?endforeach;?>
</ul>

