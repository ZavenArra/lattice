<p>Main Content</p><ul>
<?foreach($content['main'] as $field => $value):?>
<li><?=$field;?>: <?=$value;?></li>
<?endforeach;?>
</ul>

<p>stuffs Content</p><?foreach($content['stuffs'] as $item):?>
<ul>
<?foreach($item as $field=>$value):?>
<li><?=$field;?>: <?=$value;?></li>
<?endforeach;?>
</ul>
<?endforeach;?>


<?=$listing;?>

<?=$listing2;?>
