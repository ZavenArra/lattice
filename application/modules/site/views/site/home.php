<p>stuffs Content</p><?foreach($content['stuffs'] as $item):?>
<ul>
<?foreach($item as $field=>$value):?>
<li><?=$field;?>: <?=$value;?></li>
<?endforeach;?>
</ul>
<?endforeach;?>


<?=$listing;?>

<?=$listing2;?>
