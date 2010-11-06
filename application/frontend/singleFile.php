<h1><?=$content['main']['title'];?></h1>

<?if(is_object($content['main']['file'])):?>
<a href="<?=$content['main']['file']->fullpath;?>"><?=$content['main']['file']->filename;?></a>

<?endif;?>

