<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="content-script-type" content="text/javascript">

	<title>Made of People</title>

	<base href="<?=Kohana::config('config.site_protocol');?>://<?echo isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';?><?=Kohana::config('config.site_domain');?>" />

<?=$stylesheet;?>
<?=$javascript;?>

</head>
<body>

<?=$publicheader;?>

<?=$content;?>

<?=$publicfooter;?>

</body>
</html>
