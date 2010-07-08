
MOP.FileBrowser = Class.extend({
	
	initialize: function( galleryController, anElement, aDirectory ){
		this.gallery = galleryController;
		this.element = $( anElement );
		this.directories = this.element.getElementsByClassName( 'directory' );
		this.files = this.element.getElementsByClassName( 'file' );
		this.uploadForm = this.element.getElementsByClassName('uploadform')[0];
		this.currentdirectory = this.uploadForm.firstDescendant().getInputs('hidden','directory')[0];
		this.uploadFileInput = this.uploadForm.firstDescendant().getInputs('file')[0];
		this.uploadSubmitButton = this.uploadForm.firstDescendant().getInputs('button')[0];
		
		this.uploadSpinner = this.uploadForm.getElementsByClassName('spinner')[0];
		
		this.uploadLink = this.element.getElementsByClassName('uploadlink' )[0];
		this.uploadLink.onclick = this.showUploadForm.bind( this );
		this.uploadSubmitButton.onclick = this.uploadFile.bind(this);
		
		var directorycount = this.directories.length;
		for( var i=0; i < directorycount; i++ ){
			new MOP.FileBrowserDirectory( this.directories[i], this );
		};
		var filecount = this.files.length;
		for( var i=0; i < filecount; i++ ){
			new MOP.FileBrowserFile( this.files[i], this );
		};
	},
	
	reload: function(){
		this.gallery.loadFileBrowser( this.getCurrentDirectory() );
	},
	
	showUploadForm: function(){
		new Effect.Appear( this.uploadForm );
		return false;
	},

	hideUploadForm: function(){
		new Effect.Fade( this.uploadForm );		
	},

	onUploadComplete: function(){
		hideUploadForm();
		this.uploadSpinner.hide();
	},
	
	toString: function(){
		return "[ Object, MOP.FileBrowser ]";
	},
	
	getCurrentDirectory: function(){
		return this.currentdirectory.value;
	},
	
	uploadFile: function(){
		var filename = this.uploadFileInput.value;
		var ext = filename.substr( filename.length - 3 , filename.length );
		if( ext.toLowerCase() != 'jpg'){
			alert("In order to upload an image, said image must be in JPG format.");
			return false;
		}
		this.uploadForm.firstDescendant().submit();
		this.uploadSpinner.show();
		return false;
	} 

});

MOP.FileBrowserDirectory = Class.extend({
	initialize: function( anElement, filebrowser ){
		this.element = $( anElement );
		this.filebrowser = filebrowser;
		this.dir = this.element.id;
		this.link = this.element.getElementsByTagName('A')[0];
		this.link.onclick = this.getDirectory.bind( this );
	},
	
	getDirectory: function(){
		this.filebrowser.gallery.loadFileBrowser( this.filebrowser.getCurrentDirectory() +  this.dir + "/" );
		return false;
	}
});

MOP.FileBrowserFile = Class.extend({
	initialize: function( anElement, filebrowser ){
		this.element = $( anElement );
		this.filebrowser = filebrowser;
		var addlink = this.element.getElementsByClassName("addbutton")[0];
//		var previewlink = this.element.getElementsByClassName("previewbutton")[0];
		addlink.onclick = this.addImageToGallery.bind( this );
//		previewlink.onclick = this.showPreview.bind( this );
	},
	
	addImageToGallery: function(){
		var src = this.filebrowser.getCurrentDirectory() +  this.element.getElementsByClassName('filename')[0].innerHTML;
//		console.log( src + " : " + this.filebrowser.gallery.addImage );
		this.filebrowser.gallery.addImage( src );
		return false;
	},
	
	showPreview: function(e){
		// var mx = Event.pointerX(e);
		// var my = Event.pointerY(e);
		// var acallback = function(){ showPreview( this.getThumbSrc(), mx, my, this.data.thumbheight/2) };
		// showPreviewTimeout = setTimeout( acallback.bind(this), 600 );
	}
});
// 
// MOP.GMS.ImagePreview = Class.extend({
// 
// 	initialize: function(){
// 		this.element = document.createElement('div');
// 		this.element.setStyle({display:'none'});
// 		this.element.addClassName("gmspreview");
// 		this.previewimage;
// 		document.body.appendChild(this.element);
// 	},
// 	
// 	show: function( imgsrc, x, y, yoffset ){
// 		if(this.previewimage) this.element.removeChild( this.previewimage );
// 		if(this.pointer) this.element.removeChild( this.pointer );
// 		
// 		this.previewimage = document.createElement( 'img' );
// 		this.previewimage.addClassName('previewimage');
// 		this.previewimage.src = imgsrc;
// 		
// 		this.pointer = document.createElement( 'img' );
// 		this.pointer.src = 'images/icon_pointer.png';
// 		this.pointer.width = this.pointer.height = 16;
// 		this.pointer.alt = "pointer";
// 		
// 		this.pointer.setStyle({
// 			position:"relative", top: -(yoffset+20)+"px"
// 		});
// 
// 		this.element.appendChild( this.pointer  );
// 		this.element.appendChild(this.previewimage);
// 		this.element.setStyle({ left: (x+40)+"px", top: (y-yoffset)+"px" } );
// 		new Effect.Appear(this.element, {duration:.3});
// 	},
// 	
// 	hide: function(){
// 		new Effect.Fade(this.element,{duration:.3});
// 	}	
// });
