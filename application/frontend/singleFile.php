<h1><?=$content['main']['title'];?></h1>

ehllosingleFile<?if(is_object($content['main']['file'])):?>
<a href="<?=$content['main']['file']->fullpath;?>"><?=$content['main']['file']->filename;?></a>

<?endif;?>

