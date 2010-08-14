	<ul class="filelisting">

		<li class="currentdir" id="<?=$currentdirectory;?>" >
	<img class="icon" src="images/icon_folderopen.gif" width="16" height="16" alt="<?=$currentdirectory;?>" / >
			<h4 class="title"><?if($currentdirectory == ""):?>./<?else:?><?=$currentdirectory;?><?endif;?></h4>
		</li>
	
		<li class="directory" id="..">
			<h4 class="filename">
				<a href="#"><img class="icon" src="images/icon_updir.gif" width="16" height="16" alt="../" / >../</a>
			</h4>
		</li>

	<?foreach($directories as $directory):?>
		<li class="directory" id="<?=$directory['name'];?>">
			<h4 class="filename">
		<a href="#"><img class="icon" src="images/icon_folder.gif" width="16" height="16" alt="<?=$directory['name'];?>" / ><?=$directory['name'];?></a>
			</h4>
		</li>
	<?endforeach;?>

	<?foreach($files as $index => $file):?>
		<li class="file" id="file_<?=$index;?>">
			<h4 class="title">
				<img class="icon" alt="icon" src="images/icon_image.gif" height="16" width="16">
				<span class="filename"><?=$file['filename'];?></span>
			</h4>
			<a title="add this image to gallery" class="addbutton" href="#"><img alt="add this image to gallery" src="images/icon_addimage.gif" height="16" width="16" /></a>
		</li>
	<?endforeach;?>
	</ul>
	
	<a title="upload file to current directory" class="uploadlink button" href="#">
		<img class="icon" src="images/icon_uploaddocument.gif" width="16" height="16" alt="upload icon" />upload image
	</a>

	<iframe name="hiddenframe" id="hiddenframe" style="display:none;"></iframe>
	<div class="uploadform" style="display:none">
		<form name="fileform" action="ajaxsrv.php?module=gms_filebrowser" method="post" target="hiddenframe" enctype="multipart/form-data">
			<div class="elements">
				<h4>Add file to current directory!</h4>
				<div class="formgroup">
					<input type="hidden" name="action" value="upload" />
					<!-- <input type="hidden" name="pageid" value="<?=$pageid;?>"> -->
					<input type="hidden" name="uniqueid" id="input_fileuniqueid" value="" />
					<input type="hidden" name="directory" value="<?=$currentdirectory;?>" />
					<input id="documentfile" type="file" name="attachfile" />
				</div>
				<div class="formgroup">
					<img src="images/spinner.gif" width="16" height="16" alt="uploading file, please wait..." class="spinner" style="display:none" />
				</div>
				<div class="formgroup">
					<input type="button" class="submit" value="start upload"/>
				</div>
			</div>
		</form>
		<div class="clearboth"></div>
	</div>
