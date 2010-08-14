<?
$objTmp = (object) array('aFlat' => array());

array_walk_recursive($content, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);

$content = $objTmp->aFlat;

 ?>
Default..
<?foreach($content as $key => $item):?>
	<p><?=$item;?></p>
<?endforeach;?>
