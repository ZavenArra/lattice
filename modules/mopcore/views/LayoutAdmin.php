<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="content-script-type" content="text/javascript">

	<title>MoPCMS &ldquo;It's Made of People!&rdquo;</title>

	<base href="<?=Kohana::config('config.site_protocol');?>://<?=$_SERVER['HTTP_HOST'];?><?=Kohana::config('config.site_domain');?>" />

	<?=$stylesheet;?>
	<?=$javascript;?>
	
</head>
<body class=" loginTimeOut-<?=Kohana::config('mop.loginTimeOut');?>">
	<div id="container" class="container_12">

<?=Request::Factory('header/admin')->execute()->body();?>

<?=$body;?>

<?=Request::Factory('footer/admin')->execute()->body();?>

	</div>
</body>
</html>
