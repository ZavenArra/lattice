<div id="fileupload" style="display:none;">
	<?=$fileupload;?>
</div>
<form id="gmsform" name="form" method="POST" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'];?>?module=gms">	

<?if(!$_REQUEST['hidegallerylisting']):?>
	<div id="gallerylisting">
		<select onchange="gidval = this.value;">
			<option>- Select a gallery -</option>
			<? foreach($galleries as $gallery):?>
			<option  value="<?=$gallery['galleryid'];?>"  >
				<?=$gallery['title'];?>
			</option>
			<? endforeach; ?>
		</select>
		<input type="button" onclick="window.location.href='site.php?module=gms&amp;galleryid='+gidval;" value="edit" />
		<input type="button" onclick="window.location.href='site.php?module=gms&amp;action=add';" value="add new gallery" />
		<input type="hidden" name="galleryid" value="<?=$galleryid;?>" />
		<input type="hidden" name="action" value="save" />
	</div>
<?endif;?>

<? if($_REQUEST['galleryid']):?>

	<?if(!$_REQUEST['hidegallerylisting']):?>
		<h2 class="pagetitle">
			<span id="gallerytitle<?=$_REQUEST['galleryid'];?>" class="editable"><?=$title;?></span>
			<a href="#" id="deletelink_<?=$_REQUEST['galleryid'];?>"><img src="../modules/cms/images/icon_delete.gif" class="icon" width="16" height="16" alt="delete this page" onclick="deleteItem( '<?=$pageid;?>', this );" />
			<div class="clearboth"></div>
		</h2>
	<?endif;?>
	
<?endif;?>

</form>
