
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
		$clear( this.submitDelay );
		this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder.join(",") );
		newOrder = null;
	},
	
	submitSortOrder: function( newOrder ){
		if( this.allowChildSort && this.oldSort != newOrder ){
			$clear( this.submitDelay );
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

		//We only want to removeSortable if the list is currently sortable
		//It might now be, if an IPE is open and the user hits the trash can
		if(this.sortableList){
			this.removeSortable( this.sortableList );
		}

		$clear( this.submitDelay );		
		
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

	//trash: false, // set to true when an item is destroyed
	
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

	 /*
		* this.trash is a hack to identify items that have already been deleted
		* but have not been removed from the this.marshal.items array
  	*/
		//This is now fixed by erasing the item in onItemDeleted
		/*
		if(this.trash == true){
			return;
		}
		*/

		//Destroy this.element if it still exists
		//This.element is the html element for the object
		//if(this.element != null){ this.element.destroy(); }
		//This is now fixed by erasing the item in onItemDeleted
		//also this apprears to be redundant now with mopUI.js
		
		this.element.destroy();

//		the item is not being removed from this.listing
//		which is causing some memory bloat and seems to be a problem in IE specifically

		console.log(this.element);
		this.parent();  //call the superclass's 'destroy()'
	
		this.addItemDialogue = null;
		this.controls = null;
		this.fadeOut = null;
		this.scrollContext = null;
		this.objectId = null;

		console.log(this.element);

		//this.trash = true;

	}
	
});
