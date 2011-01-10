<ul>
<?foreach($navi as $page):?>
	<li id="<?=$page['slug'];?>"><a href="<?=$page['path'];?>"><?=$page['title'];?></a></li>
	<?if(isset($page['children'])):?>
		<ul>
		<?foreach($page['children'] as $child):?>
			<li id="<?=$child['slug'];?>"><a href="<?=$child['path'];?>"><?=$child['title'];?></a></li>
		<?endforeach;?>
  	</ul>
	<?endif;?>
<?endforeach;?>
</ul>

