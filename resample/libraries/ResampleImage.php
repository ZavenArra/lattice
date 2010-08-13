<?

define('JPEG_COMPRESSION', 80);

class ResampleImage {

static function resampimagejpg($forcedwidth, $forcedheight, $sourcefile, $destfile)
  {
   $g_imgcomp=JPEG_COMPRESSION;
   $g_srcfile=$sourcefile;
   $g_dstfile=$destfile;
   $g_fw=$forcedwidth;
   $g_fh=$forcedheight;
    

	 if(file_exists($g_srcfile))
	 {
		 $g_is=getimagesize($g_srcfile);
		 if($g_is[0] == 0 && $g_is[1] == 0){
			return;
		 }

		 if($g_fh == 0){
			 $g_fh = $g_is[1] * $g_fw / $g_is[0];
		 }

		 if(($g_is[0]-$g_fw)>=($g_is[1]-$g_fh))
		 {
			 $g_iw=$g_fw;
			 $g_ih=($g_fw/$g_is[0])*$g_is[1];
		 }
		 else
		 {
			 $g_ih=$g_fh;
			 $g_iw=($g_ih/$g_is[1])*$g_is[0];    
		 }
		 $img_src=imagecreatefromjpeg($g_srcfile);
		 $img_dst=imagecreatetruecolor($g_iw,$g_ih);
		 imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
		 imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
		 imagedestroy($img_dst);
		 imagedestroy($img_src);
		 return true;
	 }
	 else {
		 echo "source file does not exist";
	 }
	}

static function cropimagejpg($src_x, $src_y, $src_w, $src_h, $sourcefile, $destfile) {
		 $img_src=imagecreatefromjpeg($sourcefile);
		 $img_dst=imagecreatetruecolor($src_w,$src_h);
		 imagecopyresampled($img_dst, $img_src, 0, 0, $src_x, $src_y, $src_w, $src_h, $src_w, $src_h);
		 imagejpeg($img_dst, $destfile, JPEG_COMPRESSION);
		 imagedestroy($img_dst);
		 imagedestroy($img_src);
		 return true;
	}

static	function resampimagejpghandle($forcedwidth, $forcedheight, $sourcefile, $imgcomp)
	{
		$g_imgcomp=100-$imgcomp;
		$g_srcfile=$sourcefile;
		$g_fw=$forcedwidth;
		$g_fh=$forcedheight;


		if(file_exists($g_srcfile))
		{
			$g_is=getimagesize($g_srcfile);

			if($g_fh == 0){
				$g_fh = $g_is[1] * $g_fw / $g_is[0];
			}

			if(($g_is[0]-$g_fw)>=($g_is[1]-$g_fh))
			{
				$g_iw=$g_fw;
				$g_ih=($g_fw/$g_is[0])*$g_is[1];
			}
			else
			{
				$g_ih=$g_fh;
				$g_iw=($g_ih/$g_is[1])*$g_is[0];    
			}
			$img_src=imagecreatefromjpeg($g_srcfile);
			$img_dst=imagecreatetruecolor($g_iw,$g_ih);
			imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
			return $img_dst;
		}
		else {
			return false;
		}
	}
}

?>
