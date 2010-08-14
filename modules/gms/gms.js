MOP.GMS = new Object();
MOP.GMS.Module = Class.extend({
	initialize: function( anElement, gallery, galleryid, modulename, instance, options ){
		this.element = $(anElement);
		this.gallery = gallery;
		this.galleryid = galleryid;
		this.modulename = modulename;
		this.instance = instance;
		this.options = Object.extend({
			queryTemplates: {
				init: new Template( 'module=#{modulename}&instance=#{instance}&action=initgms&galleryid=#{galleryid}' ),
				rename: new Template( 'module=#{modulename}&instance=#{instance}&action=savefield&galleryid=#{galleryid}&field=title&value=${value}' ),
				addImage: new Template( 'module=#{modulename}&instance=#{instance}&action=addimage&galleryid=#{galleryid}&newimage=#{image}' ),
				removeImage: new Template( 'module=#{modulename}&instance=#{instance}&action=delete&galleryid=#{galleryid}&imageid=#{imageid}' ),
				saveSortOrder: new Template( 'module=#{modulename}&instance=#{instance}&action=saveSortOrder&galleryid=#{galleryid}&sortorder=#{serialization}' ),
				inPlaceEdit: new Template( 'module=#{modulename}&instance=#{instance}&action=saveimagefield&imageid=#{imageid}&field=${fieldname}&value=${value}' )	
			},
			onRename: function( form, value ){
				var templateFilter = { modulename: this.modulename, instance: this.instance, galleryid: this.galleryid, value: value };
				var queryString = this.options.queryTemplates.rename.evaluate( templateFilter );
				return queryString;
			},
		}, options || {} );

		this.loadImages();		
	},
	
	toString: function(){
		return "[ Object, MOP.GMS.Module ]";
	},
	
	loadImages: function(){
		var templateFilter = { modulename: this.modulename, instance: this.instance, galleryid: this.galleryid };
		var queryString = this.options.queryTemplates.init.evaluate( templateFilter);
		var cb = this.onGMSLoaded.bind( this );
		var myAjax = new Ajax.JSONRequest( 'ajaxsrv.php', {
			method: 'post',
			parameters: queryString,
			onSuccess: cb
		});
	},
	
	onGMSLoaded: function( gallerydata ){
		this.gms = new MOP.GMS.Gallery( this.element, this, this.galleryid, gallerydata, this.modulename );		
		this.options.controls.donesortingbutton.onclick = this.gms.saveOrder.bindAsEventListener( this.gms );
	},
	
	onRename: function( form, value ){
		this.options.onRename.bind( this, form, value );
	},
	
	addImage: function( img ){
		this.gms.addImage( img );
	}
});

MOP.GMS.Gallery = Class.extend({
	initialize: function( element, module, gid, gallerydata, modulename ){
		this.galleryid = gid;
		this.module = module;
		this.instance = module.instance;
		this.element = $( element );
		this.modulename = modulename;
		this.gallerydata = gallerydata;
		this.element.innerHTML = gallerydata.html;
		var imagecount = this.gallerydata.data.length;
		for( var i = 0; i < imagecount; i++ ){
			new MOP.GMS.Image( this, this.gallerydata.data[ i ] ); 
		};
		this.makeSortable();
		if( $('gallerytitle'+this.galleryid) != undefined ) this.makeFieldEditable( 'gallerytitle'+ this.galleryid, 'title', 1, 40 );
	},
	
	toString: function(){
		return "[ Object, MOP.GMS.Gallery ]";
	},
	
	makeFieldsEditable: function( element, aFieldName, rows, size ){
		var cb = this.options.onRename.bind( this, aFieldName);
		rows = (rows)? rows : 1;
		size = (size)? size : 30;
		new MOP.Ajax.InPlaceEditor( element, 'ajaxsrv.php', { 
			rows: rows,
			size: size,
			callback: cb
		});		
	},

	makeSortable: function(){
		Position.includeScrollOffsets = true;
		if( this.element.id == "" ){
			var now = new Date();
			var newid = 'sortable_' + now.getYear() + now.getMonth() + now.getHours() + now.getMinutes() + now.getSeconds() + now.getMilliseconds();			
			this.element.id = newid;
		}
		Sortable.destroy( this.element );
		Sortable.create( this.element, { constraint: false, overlap: "horizontal" } );
	},
	
	onSort: function(){
		if( this.options.controls.donesortingbutton.getStyle("display") == 'none' ) new Effect.BlindRight(  this.options.controls.donesortingbutton, { duration: .5 } );
	},

	addImage: function( image ){
		var placeholder = this.getPlaceholder();
		var cb = this.insertImage.bind( this, placeholder );
		this.element.insertBefore( placeholder, this.element.firstDescendant() );
		var queryString = 'module='+this.modulename+'&instance='+this.instance+'&action=addimage&galleryid='+this.galleryid+'&newimage='+image;
		var myAjax = new Ajax.JSONRequest( 'ajaxsrv.php', {
			method: 'post',
			parameters: queryString,
			onSuccess: cb,
		});
		return false;
	},
	
	getPlaceholder: function(){
		var element = $( document.createElement( "LI" ));
		element.addClassName("thumbnail");
		var icon = document.createElement("IMG");
		icon.src = "images/spinner.gif";
		icon.width = icon.height = 16;
		icon.alt = "Adding image...";
		var h = $( document.createElement("H4") );
		h.addClassName("ineditable");
		h.addClassName("title");
		var span = $(document.createElement("SPAN"));
		span.update("Adding image...");
		h.appendChild( icon );
		h.appendChild( span );
		element.appendChild( h );
		return element;
	},

	insertImage: function(){
		var placeholder = $A(arguments)[0];
		var img = $A( arguments )[1];
		var newnode = this.element.insertTop( img.html );
		// hmmm this is a little weird, instead of telling the element, the image uses the id in the json object to 'bless' the element...
		new MOP.GMS.Image( this, img.data );
		placeholder.remove();
		this.makeSortable();
	},
	
	removeImage : function( imgInstance ){
		var imgid = imgInstance.data.imageid;
		var cb = function(){
			imgInstance.element.remove();
			delete imgInstance;
		};
		cb.bind( this );
		var myAjax = new Ajax.Request( 'ajaxsrv.php', {
			method: 'post',
			parameters: 'module='+this.modulename+'&instance='+this.instance+'&action=delete&galleryid='+ this.galleryid + '&imageid=' + imgid,
			onComplete: cb
		});
	},

	saveOrder: function( e ){
		var button = Event.element( e );
		button.update("Saving sort order...");
		var serialization = this.serialize();
 		var queryString = 'module='+this.modulename+'&instance='+this.instance+'&action=saveSortOrder&galleryid=' + this.galleryid + '&sortorder=' + serialization;
		var cb = this.module.gallery.doneEditing.bind( this.module.gallery );
		this.module.gallery.showVeil();
		var myajax = new Ajax.Request( 'ajaxsrv.php', {
			method: 'post',
			parameters : queryString,
			onComplete: cb
		});
		return false;
	},
	
	serialize: function(){
		var serialArray = new Array();
		var children = this.element.getElementsByClassName('thumbnail');
		var childcount = children.length;
		for( var i=0; i < childcount; i++ ){
			serialArray.push( children[i].id.split("_")[1] );
		};
		return serialArray.join(',');
	}
});

MOP.GMS.Image = Class.extend({
	initialize: function( gms, data ){
		this.data = data;
		this.gms = gms;
		this.element = $( 'thumb_'+data.imageid );
 		this.title = this.element.getElementsByClassName( 'title' )[0];
		this.makeTitleEditable( this.title, this.data.imageid, 'title', 1, 10 );
		this.deletelink = this.element.getElementsByClassName( 'deletelink' )[0];
		this.deletelink.onclick = this.destroy.bind( this );
		this.deletelink.onmouseover = this.indicateDeleteLink.bind( this );
		this.deletelink.onmouseout = this.deIndicateDeleteLink.bind( this );
	},
	
	indicateDeleteLink: function(){
		this.deletelink.firstDescendant().src = "../modules/gms/images/icon_delete_hover.gif";
	},

	deIndicateDeleteLink: function(){
		this.deletelink.firstDescendant().src = "../modules/gms/images/icon_delete.gif";
	},
	
	makeTitleEditable: function( element, imgid, fieldname, rows, cols  ){
		var modulename = this.gms.modulename;
		var cb = function( form, value ){
			var returnvalue = "module="+ modulename +'&instance='+this.instance+"&action=saveimagefield&imageid=" + imgid + "&field=" + fieldname + "&value=" + escape( value );
			return returnvalue;
		};
		new MOP.Ajax.InPlaceEditor( element, 'ajaxsrv.php', { rows: rows, size: cols, callback: cb } );		
	},
	
	toString: function(){
		return "[ Image, " + this.data.imageid + " ]";
	},
	
	destroy: function(){
		this.deletelink.onmouseover = this.deletelink.onmouseout = null;
		this.deletelink.firstDescendant().src = "images/icon_spinner.gif";
		this.gms.removeImage( this );
		return false;
	}
});
