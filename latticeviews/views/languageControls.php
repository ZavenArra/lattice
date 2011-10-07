<?foreach($languages as $language):?>
<a href="language/changeLanguage/<?=$language->code;?>/<?=latticeview::initialObject()->slug;?>"><?=$language->fullname;?></a>
<?endforeach;?>
