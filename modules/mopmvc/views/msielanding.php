<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>NTVB Integrated Site Management via MoPCMS - Internet Explorer Landing Page</title>

	<style type="text/css">
		/* reset.css */
		html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {margin:0;padding:0;border:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;}
		table {border-collapse:separate;border-spacing:0;}
		caption, th, td {text-align:left;font-weight:normal;}
		table, td, th {vertical-align:middle;}
		blockquote:before, blockquote:after, q:before, q:after {content:"";}
		blockquote, q {quotes:"" "";}
		a img {border:none;}

		html, body{

		}
		/* typography.css */
		body {
			color:#222;
			background:#fff;
			font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size:75%;
			line-height: 18px;
			padding-bottom:6em;
		}

		#container {
			width: 900px;
			height: 100%;
			margin:0 auto;
		}

		h1, h2, h3, h4{
			font-weight:normal;color:#121212;
		}

		h4{ 
			font-size: 1.75em;	/* 21px */
			line-height: 1.75em;
		}

		h1 {
			font-size: 4em;		/* 42px */
			line-height: 4.5em;
		}

		p {
			margin:0 0 2em 0; 
		}
		
		a:focus{
			border: none;
		}

		a:focus, a:hover {color:#000;}

		a {
			color:#0af;
			text-decoration:underline;
		}

		.sectionHead{
			font-family: Georgia, Times, serif;
			margin: 0 0 6px 0;
			padding: 18px 0 6px 0;
			color:#aaa;

		}
	
		#controlPanelList{
			font-size: 2em;
			margin:0;
			padding: 0;
		}

		#controlPanelList li{
			display:block;
			float: left;
			width: 425px;
			background: #0af;
			color:#fff;
			margin:0 12px .125em 0;
			padding: 0;
		}

		#controlPanelList li a{
			text-decoration: none;
			display:block;
			padding: 1em .5em;
			background: #0af;
			color:#fff;
		}

		#controlPanelList li a:hover{
			background: #000;
		}
	
	</style>
</head>

<body>
	
	<div id="container">
		<h4 class="sectionHead">This area of the site requires a modern-standards-compliant browser, unfortunately Internet Explorer 6 doesn't quite qualify. We currently support Mozilla Firefox, and Safari,<br/>though other similarly standards compliant browsers should also work.<br/>
		<a class="button" href="<?=Kohana::config('config.site_protocol');?>://<?=$_SERVER['HTTP_HOST'];?><?=Kohana::config('config.site_domain');?>controlpanel/">Return to your control panel.</a></h4>


		<h4 class="sectionHead">Supported Browsers</h4>
		<ul id="controlPanelList">
		<li><a href="http://www.mozilla.com/firefox/" target="_blank">Get Firefox</a></li>
		<li><a href="http://www.apple.com/safari/download/" target="_blank">Get Safari</a></li>
		</ul>
	</div>

</body>

</html>
