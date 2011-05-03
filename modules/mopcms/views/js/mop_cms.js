/* Class: mop.cms.CMS */
mop.modules.CMS = new Class({
	/* Constructor: initialize */
	Extends: mop.modules.Module,
	pageLoadCount: 0,
	objectId: null,
	pageContent: null,
	pageIdToLoad: null,
	scriptsLoaded: null,
	scriptsTotal: null,
	currentPageLoadIndex: null,
	titleText: "",
	titleElement: null,
	editSlugLink: null,
	deletePageLink: null,
	loadedCSS: [],
	loadedJS: [],
	
	initialize: function( anElement, options ){
//        console.log( "CMS INIT", this.childModules );
		this.parent( anElement, null, options );		
		this.objectId = this.getValueFromClassName( "objectId" );
	},
	
	build: function(){
		this.pageContent = $("nodeContent");
		this.initModules( this.element );
	},
		
	requestTier: function( parentId, callback ){
	    var url = mop.util.getAppURL() + "ajax/compound/navigation/getTier/" + parentId;
		mop.util.JSONSend( url, null, { onSuccess: callback } );
 		mop.util.setObjectId( parentId );
	},
    
	toString: function(){
		return "[ object, mop.modules.CMS ]";
	},

	loadPage: function ( pageId ){
//		console.log( this.toString(), "loadPage", pageId );
		this.pageIdToLoad = pageId;
		this.clearPage();
		this.pageContent.spin();
		var url = mop.util.getAppURL() + "ajax/html/cms/getPage/" + pageId;
		mop.util.JSONSend( url, null, { onSuccess: this.onPageLoaded.bind( this ) } );
		console.log( "loadPage", url );
 		mop.util.setObjectId( pageId );
	},
	
	clearPage: function(){
	    console.log( "clearPage" );
		this.destroyChildModules( this.pageContent );
		this.destroyUIElements();
		this.pageContent.empty();
	},

	/*
		Function: onPageLoaded
		Callback to getPage, loops through supplied JSON object and attached css, html, js, in that order then looks through #pageContent and initialize modules therein....
		Arguments:
			pageJSON - Object : { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	onPageLoaded: function( response ){
        console.log( ">>> ", response );
		var pageData = response.response;
		pageData.css.each( function( styleSheetURL, index ){
		    if( !this.loadedCSS.contains( styleSheetURL ) ) mop.util.loadStyleSheet( styleSheetURL );
		    this.loadedCSS.push( styleSheetURL );
		}, this );
		$("nodeContent").unspin();
		var scripts = pageData.js;
		this.scriptsLoaded = 0;
		this.scriptsTotal = scripts.length;
		this.currentPageLoadIndex = this.pageLoadCount++;
        console.log( "onPageLoaded", pageData.js );
		if( this.scriptsTotal && this.scriptsTotal > 0 ){
			scripts.each( function( urlString ){
			    console.log( this.toString(), "loadJS loading ", urlString );
			    if( !this.loadedJS.contains( urlString ) ) mop.util.loadJS( urlString, { type: "text/javascript", onload: this.onJSLoaded.bind( this, [ pageData.html, this.currentPageLoadIndex ] ) } );
    		    this.loadedJS.push( urlString );
			}, this);			
		}
		this.populate( pageData.html );
	},
	
	onJSLoaded: function( pageHTML, pageLoadCount ){
		// keeps any callbacks from previous pageloads from registering
		if( pageLoadCount != this.currentPageLoadIndex ) return;
		
		this.scriptsLoaded++;
		
		if( this.scriptsLoaded == this.scriptsTotal ){
			
			this.scriptsTotal = null;
			this.populate( pageHTML );

		}
	},
	
	
	populate: function( html ){
		
		this.pageContent.set( 'html', html );

		this.uiElements = this.initUI( this.pageContent );
		this.initModules( this.pageContent );		

		this.titleElement = this.element.getElement( ".pageTitle" );
		
        
		if( this.titleElement ){

			this.titleText = this.titleElement.getElement( "h2" ).get( "text" );
			this.deletePageLink = this.titleElement.getElement( "a.deleteLink" );

    		this.editSlugLink = this.titleElement.getElement( ".field-slug label" );
			if( this.editSlugLink ){
				this.editSlugLink.addEvent( "click", this.toggleSlugEditField.bindWithEvent( this ) );
                // this.editSlugLink.retrieve( "Class" ).registerOnLeaveEditModeCallback( this.onSlugEdited.bind( this ) );
			}
			var titleIPE = this.titleElement.getElement( ".field-title" ).retrieve("Class");
			if( titleIPE ) titleIPE.registerOnCompleteCallBack( this.renameNode.bind( this ) );
			if( titleIPE ) titleIPE.registerOnCompleteCallBack( this.onTitleEdited.bind( this ) );
			if( this.deletePageLink ) this.deletePageLink.addEvent( "click", this.onDeleteNodeReleased.bindWithEvent( this ) );
			
		}
	},
	
	onTitleEdited: function( response ){
	    this.editSlugLink.retrieve( "Class" ).setValue( response.slug );
	},
	
	onSlugEdited: function(){
		this.titleElement.getElement( ".field-slug .ipe" ).addClass("hidden");
	},
	
	toggleSlugEditField: function( e ){
//	    console.log( "revealSlugEditField", e );
		mop.util.stopEvent( e );
		var slug = this.titleElement.getElement( ".field-slug" );
		var ipe = slug.getElement( ".ipe" )
		var label = slug.getElement( "label" );
		if( ipe.hasClass( "hidden" ) ){
    		this.titleElement.getElement( ".field-slug .ipe" ).removeClass("hidden");
    		this.titleElement.getElement( ".field-slug" ).retrieve( "Class" ).enterEditMode();		    
    		label.set( "text", "Hide slug" );
		}else{
		    ipe.addClass( "hidden" );
		    slug.retrieve( "Class" ).cancelEditing( null );
    		label.set( "text", "Edit slug" );
		}
	},
	
	renameNode: function( response, uiInstance ){
		this.childModules.get( "navigation" ).renameNode( response.value );
	},


	addObject: function( objectName, templateId, parentId, whichTier, placeHolder ){
	    console.log( "addObject", this.toString(), $A( arguments ) );
	    // crappy hack to add... fuckit lets do this right.
	    parentId = ( parentId )? parentId : 0;
		var callBack = function( nodeData ){
			this.onObjectAdded( nodeData, parentId, whichTier, placeHolder );
		};
		new Request.JSON({
			url: mop.util.getAppURL() + "ajax/data/cms/addObject/" + parentId + "/" + templateId,
			onComplete: callBack.bind( this )
		}).post( { "title" : objectName } );
		callBack = null;
	},

	onObjectAdded: function( data, parentId , whichTier, placeHolder ){
//	    console.log( "onObjectAdded", this, this.toString() );
		this.childModules.get( "navigation" ).onObjectAdded(  data , parentId, whichTier, placeHolder );
	},
	
	getModule: function(){ return this; },
	
	/*
	Function: togglePublishedStatus
	Sends page publish toggle ajax call 
	Argument: pageId {Number}
	Callback: onTogglePublish
	*/
	togglePublishedStatus: function( nodeId ){
		new Request.JSON({
			url: mop.util.getAppURL() + "ajax/data/cms/togglePublish/"+ nodeId
//			onComplete: this.onPublishedStatusToggled
		}).send();
	},
	
	/*
	Function: onDeleteNodeReleased
	Event handler for delete link in pagetitle area
	Argument: event from bound link
	*/
	onDeleteNodeReleased: function( e ){
		mop.util.stopEvent( e );
//		console.log( "onDeleteNodeReleased", mop.objectId );
		this.deleteNode( mop.objectId, this.titleText );
		this.childModules.get( "navigation" ).removeNode( mop.objectId, true );
	},

	/*
	Function: deleteNode
	Sends page deleting ajax call destroys current page 
	Argument: pageId {Number}
	Callback: onNodeDeleted
	*/
	deleteNode: function( nodeId, titleText ){
	    console.log( "deleteNode", this.toString() );
		var confirmed = confirm( "Are you sure you wish to delete the node: “" + titleText + "”?\nThis cannot be undone." );
		if( confirmed ){
			var url = mop.util.getAppURL() + "ajax/data/cms/delete/"+ nodeId;
			mop.util.JSONSend( url, null, { onComplete: this.clearPage.bind( this ) })
		}
	}
	
});


mop.modules.List = new Class({

	/* TODO write unit tests for List*/

	Extends: mop.modules.Module,

	// listing properties and members, helps with maintenance and destruction.... standard practice from now on
	sortable: null,
	sortDirection: null,
	instanceName: null,
	addItemDialogue: null,
	items: null,
	controls: null,
	sortableList: null,
	scroller: null,
	submitDelay: null,
	oldSort: null,
	
	
	initialize: function( anElement, aMarshal, options ){
		
		this.parent( anElement, aMarshal, options );

		delete this.items;
		this.items = null;
		this.items = [];
		
		this.allowChildSort = ( this.getValueFromClassName( "allowChildSort" ) == "false" ) ? false : true;
		this.sortDirection = this.getValueFromClassName( "sortDirection" );
        console.log( "List allowChildSort: ", this.getValueFromClassName( "allowChildSort" ) );
		if( this.allowChildSort ) this.makeSortable();
	},

	toString: function(){
		return "[ object, mop.modules.List ]";
	},
	
	getInstanceName: function(){
		return this.instanceName;
	},
	
	build: function(){
		this.parent();
		this.initControls();
		this.addItemDialogue = null;
//		console.log( "build", this.toString() );
		this.initList();
	},	
	
	initList: function(){
		delete this.items;
		this.items = null;
		this.items = [];
		this.listing = this.element.getElement( ".listing" );
		var children = this.listing.getChildren("li");
		children.each( function( element ){
			this.items.push( new mop.modules.ListItem( element, this, this.addItemDialogue ) ); 
		}, this );
	},

	initControls: function(){
		// console.log( this.element.getElement( "#" + this.instanceName+"AddItemModal" ).retrieve("Class") );
		this.controls = this.element.getChildren( ".controls" );
		var addItemButton = this.controls.getElement( ".addItem" ).addEvent("click", this.addItem.bindWithEvent( this ) );//this.showModal.bindWithEvent( this, $( this.instanceName+"AddItemModal" ) ) );
		if( this.allowChildSort ){
			var saveSort = this.controls.getElement( ".saveSort" ).addEvent("click", this.saveSort.bindWithEvent( this ) );
			saveSort = null;
		}
		addItemButton = null;
	},
	
	addItem: function( e ){
		if( e && e.preventDefault ){
			e.preventDefault();
		}else{
			e.returnValue = false;
		}
		
		if( this.addItemDialogue ) this.removeModal( this.addItemDialogue );
		this.addItemDialogue = new mop.ui.EnhancedAddItemDialogue( null, this );
		this.addItemDialogue.showLoading( e.target.get("text") );
		
		this.JSONSend( "addItem", null, { 
			onComplete: function( json ){ 
				this.onItemAdded( json ); 
			}.bind( this )
		});
	},

	onItemAdded: function( json  ){
		var element = this.addItemDialogue.setContent( json.response, this.controls.getElement( ".addItem" ).get( "text" ) );
		var listItem = new mop.modules.ListItem( element, this, this.addItemDialogue, { scrollContext: 'modal' } );
		listItem.UIElements.each( function( uiInstance ){
			uiInstance.scrollContext = "modal";
		});
		this.items.push( listItem );
		mop.util.EventManager.broadcastEvent( "resize" );
		listItem = null;
	},
	
	removeModal: function( aModal ){
		if( !this.addItemDialogue ) return;
		this.addItemDialogue = null;
	},

	insertItem: function( anElement ){
		var where = ( this.sortDirection == "DESC" )? "top" : "bottom";
		this.listing.grab( anElement, where );
		if( this.allowChildSort && this.sortableList ) this.sortableList.addItems( anElement );

		// reset scrollContexts
		var listItemInstance = anElement.retrieve("Class");
		listItemInstance.scrollContext = 'window';
		listItemInstance.resetFileDepth();
		listItemInstance.UIElements.each( function( uiInstance ){
			uiInstance.scrollContext = "window";
		});
		anElement.tween( "opacity", 1 );
	 	anElement.getElement(".itemControls" ).getElement(".delete").removeClass("hidden");

		if( this.allowChildSort != null ) this.onOrderChanged();
		listItemInstance = where = null;
	},

	onItemDeleted: function( anItem ){
		this.items.erase( anItem );
		anItem.destroy();
		delete anItem;
		anItem = null;
		
		mop.util.EventManager.broadcastEvent( "resize" );
		//again we should be removing from this.items
		//this is a potential memory leak, since adding and removing many times will leave
		//baggage around since it's not removed from this.items, now we have a class with all vars and methods deleted
	},
	
	makeSortable: function(){
		if( this.allowChildSort && !this.sortableList ){
			this.sortableList = new mop.ui.Sortable( this.listing, this, $( 'body' ) );
		}else if( this.allowChildSort ){
			this.sortableList.attach();
		}
		this.oldSort = this.serialize();
	},
		
	toggleSortable: function(){
		if( this.sortableList ){ this.removeSortable( this.sortableList ); }else{ this.makeSortable(); }
		console.log( "toggleSortable", this.sortableList );
	},
	
	resumeSort: function(){
		if( this.allowChildSort && this.sortableList ) this.sortableList.attach();
	},
	
	suspendSort: function(){
		if( this.allowChildSort && this.sortableList ) this.sortableList.detach();
	},
	
	removeSortable: function( aSortable ){
		aSortable.detach();
		delete aSortable;
		aSortable = null;
	},
	
	onOrderChanged: function(){
		var newOrder = this.serialize();
		clearInterval( this.submitDelay );
		this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder.join(",") );
		newOrder = null;
	},
	
	submitSortOrder: function( newOrder ){
		if( this.allowChildSort && this.oldSort != newOrder ){
			clearInterval( this.submitDelay );
			this.submitDelay = null;
			this.JSONSend( "saveSortOrder", { sortorder: newOrder } );
			this.oldSort = newOrder;
		}
	},

	serialize:function(){
		var sortArray = [];
		var children = this.listing.getChildren("li");
		children.each( function ( aListing ){			
            var listItemId = aListing.get("id");
            var listItemIdSplit = listItemId.split( "_" );
            listItemId = listItemIdSplit[ listItemIdSplit.length - 1 ];
            sortArray.push( listItemId );
		});
        console.log( this.toString(), "serialize", this.listing, sortArray );
		return sortArray;

	},

	destroy: function(){
		if(this.sortableList) this.removeSortable( this.sortableList );
		clearInterval( this.submitDelay );		
		this.removeModal();
		
		delete this.modal;
		delete this.addItemDialogue;
		delete this.controls;
		delete this.instanceName;
		delete this.items;
		delete this.listing;
		delete this.oldSort;
        if( this.scroller ) delete this.scroller;
		delete this.allowChildSort;
		delete this.sortDirection;
		delete this.submitDelay;
		
		this.addItemDialogue = null;
		this.controls = null;
		this.instanceName = null;
		this.items = null;
		this.listing = null;
		this.oldSort = null;
        if( this.scroller ) this.scroller = null;
		this.allowChildSort = null;
		this.sortDirection = null;
		this.submitDelay = null;
		
		mop.util.EventManager.broadcastEvent( 'resize' );
		
		this.parent();

	}

});

mop.modules.ListItem = new Class({

	Extends: mop.modules.Module,

	Implements: [ Events, Options ],

	addItemDialogue: null,
	objectId: null,
	scrollContext: null,
	controls: null,
	fadeOut: null,
	
	initialize: function( anElement, aMarshal, addItemDialogue, options ){
		this.element = $( anElement);
		this.element.store( "Class", this );
		this.marshal = aMarshal;
		this.instanceName = this.element.get( "id" );
		this.addItemDialogue = addItemDialogue;
		this.objectId = this.element.get("id").split("_")[1];
		if( options && options.scrollContext ) this.scrollContext = options.scrollContext;
		this.build();
	},

	getObjectId: function(){ return this.objectId; },

	toString: function(){ return "[ object, mop.modules.ListItem ]"; },

	build: function(){
		this.parent();
		this.initControls();
	},

	initControls: function(){

		this.controls = this.element.getElement(".itemControls");
		if( this.controls.getElement(".delete") ) this.controls.getElement(".delete").addEvent( "click", this.deleteItem.bindWithEvent( this ) );
		

		// if( this.controls.getElement(".submit") )
		// 	this.controls.getElement(".submit").addEvent( "click", this.addItemDialogue.submit.bindWithEvent( this.addItemDialogue ) );
		// 
		// if( this.controls.getElement(".cancel") )
		// 	this.controls.getElement(".cancel").addEvent( "click", this.addItemDialogue.cancel.bindWithEvent( this.addItemDialogue ) );

	},
	
	filesToTop: function(){
		this.UIElements.each( function( uiElementInstance, indexA ){
			if( uiElementInstance.type == "file" || uiElementInstance.type == "imageFile" ){
 				uiElementInstance.scrollContext = 'modal';
				uiElementInstance.reposition( 'modal' );
			}
		}, this );
	},
	
	resetFileDepth: function(){
		this.UIElements.each( function( anElement ){
			if( anElement.type == "file" || anElement.type == "imageFile" ){
				anElement.reposition( 'window' );
			}
		});
	},

	JSONSend: function( action, data, options ){
		var url = mop.util.getAppURL() + "ajax/" + this.getSubmissionController() +  "/" + action + "/" + this.getObjectId();
		mop.util.JSONSend( url, data, options );
	},

	getSubmissionController: function(){ return this.marshal.instanceName; },
	
	deleteItem: function( e ){
		if( e ){
			if( e.preventDefault ){
				e.preventDefault();
			}else{
				e.returnVal = false;
			}
			e.target.removeClass("delete");
			e.target.addClass("spinner");
		}
		this.JSONSend( "deleteItem" );
		if( this.marshal.sortableList != null ) this.marshal.onOrderChanged();
		this.fadeOut = new Fx.Morph( this.element, { duration: 300, onComplete: this.marshal.onItemDeleted.bind( this.marshal, this ) } );
		this.fadeOut.start( { opacity: 0 } );
	},

	
	resumeSort: function(){
		if( this.marshal.sortableList ) this.marshal.resumeSort();
	},
	
	suspendSort: function(){
		if( this.marshal.sortableList ) this.marshal.suspendSort();
	},
	
	destroy: function(){
		this.element.destroy();
//		console.log(this.element);
		this.parent();  //call the superclass's destroy method
		this.addItemDialogue = null;
		this.controls = null;
		this.fadeOut = null;
		this.scrollContext = null;
		this.objectId = null;
		console.log(this.element);
	}
	
});

window.addEvent( "domready", function(){

	mop.HistoryManager = new mop.util.HistoryManager().instance();
	mop.HistoryManager.init( "pageId", "onPageIdChanged" );
	mop.ModalManager = new mop.ui.ModalManager();
    mop.DepthManager = new mop.util.DepthManager();
    
    var doAuthTimeout = mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
    
    if( window.location.href.indexOf( "auth" ) == -1 && doAuthTimeout && doAuthTimeout != "0" ) mop.loginMonitor = new mop.util.LoginMonitor();
    
    mop.util.EventManager.broadcastEvent("resize");
    mop.CMS = new mop.modules.CMS( "cms" );

});
