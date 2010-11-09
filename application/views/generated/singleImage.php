<h1><?=$content['main']['title'];?></h1>

<?if(is_object($content['main']['file'])):?>
 <img id="file" src="<?=$content['main']['file']->original->fullpath;?>" width="<?=$content['main']['file']->original->width;?>" height="<?=$content['main']['file']->original->height;?>" alt="<?=$content['main']['file']->original->filename;?>" />
<?endif;?>

<?if(is_object($content['main']['file2'])):?>
 <img id="file2" src="<?=$content['main']['file2']->original->fullpath;?>" width="<?=$content['main']['file2']->original->width;?>" height="<?=$content['main']['file2']->original->height;?>" alt="<?=$content['main']['file2']->original->filename;?>" />
<?endif;?>

