<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?=Kohana::config('mop.siteTitle');?></title>

<base href="<?=Kohana::config('config.site_protocol');?>://<?=$_SERVER['HTTP_HOST'];?><?=Kohana::config('config.site_domain');?>" ></base> 

	<?=$stylesheet;?>
	<?=$javascript;?>
	
</head>
<body id="<?=$primaryId;?>">
	<div id="container">
		<?=$content;?>
	</div>
</body>
</html>

