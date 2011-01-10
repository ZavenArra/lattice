<?
Class Tests_Controller extends Controller  {

	public function imagesize($imageFileName){
		$imageFileName = str_replace("'", '', $imageFileName);
		$imageFileName = str_replace('&#039;', '', $imageFileName);
		$dimensions = getimagesize('application/media/'.$imageFileName);
		$width = $dimensions[0];
		$height = $dimensions[1];
		echo <<<EOT
<html>
  <body>
	  <ul>
		 <li id="width">$width</li>
		 <li id="height">$height</li>
		</ul>
	</body>
</html>
EOT;
	}

}
