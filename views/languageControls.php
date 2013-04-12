<ul id='languageSwitcher'>
	<?foreach($languages as $language):?>
	<li><a href="language/changeLanguage/<?=$language->code;?>/<?=core_view::initialObject()->slug;?>"><?=$language->fullname;?></a></li>
	<?endforeach;?>
</ul>
