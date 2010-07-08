
mop.modules.ListModule = new Class({

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
		
		this.sortable = ( this.getValueFromClassName( "sortable" ) != "false" ) ? this.getValueFromClassName( "sortable" ) : false;
		this.sortDirection = this.getValueFromClassName( "sortDirection" );

		if( this.sortable ) this.makeSortable();
	},

	toString: function(){
		return "[ object, mop.modules.ListModule ]";
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
	
	toggleSortable: function(){
		if( this.sortable ){ this.killSortable(); }else{ this.makeSortable(); }
	},

	initControls: function(){
		// console.log( this.element.getElement( "#" + this.instanceName+"AddItemModal" ).retrieve("Class") );
		this.controls = this.element.getChildren( ".controls" );
		var addItemButton = this.controls.getElement( ".addItem" ).addEvent("click", this.addItem.bindWithEvent( this ) );//this.showModal.bindWithEvent( this, $( this.instanceName+"AddItemModal" ) ) );
		if( this.sortable ){
			var saveSort = this.controls.getElement( ".saveSort" ).addEvent("click", this.saveSort.bindWithEvent( this ) );
			saveSort = null;
		}
		addItemButton = null;
	},
	
	makeSortable: function(){
		if( this.sortable && !this.sortableList ){
				this.sortableList = new mop.ui.Sortable(  this.listing, this, {
				scrollElement: window,
				clone:  true,
				snap: 12,
				revert: true,
				velocity: .97,
				area: 24,
				constrain: true,
				onComplete: function( el ){
					if(!this.moved) return;
					this.moved = false;
					this.scroller.stop();
					this.marshal.onOrderChanged();
				},
				onStart: function(){
					this.moved = true;
					this.scroller.start();
				}
			});
		}else if( this.sortable ){
			this.sortableList.attach();
		}
		this.oldSort = this.serialize();
	},
		
	resumeSort: function(){
		if( this.sortable && this.sortableList ) this.sortableList.attach();
	},
	
	suspendSort: function(){
		if( this.sortable && this.sortableList ) this.sortableList.detach();
	},
	
	killSortable: function(){
		this.sortableList.detach();
		delete this.sortableList;
		this.sortableList = null;
	},
	
	onOrderChanged: function(){
		var newOrder = this.serialize();
		$clear( this.submitDelay );
		this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder.join(",") );
		newOrder = null;
	},
	
	submitSortOrder: function( newOrder ){
		if( this.sortable && this.oldSort != newOrder ){
			$clear( this.submitDelay );
			this.submitDelay = null;
			this.JSONSend( "saveSortOrder", { sortorder: newOrder } );
			this.oldSort = newOrder;
		}
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
		listItem.uiElements.each( function( uiInstance ){
			uiInstance.scrollContext = "modal";
		});
		listItem.filesToTop();
		this.items.push( listItem );
		this.addItemDialogue.show();
		listItem = null;
	},
	
	removeModal: function( aModal ){
		if( !this.addItemDialogue ) return;
		this.addItemDialogue = null;
	},

	insertItem: function( anElement ){
		var where = ( this.sortDirection == "DESC" )? "top" : "bottom";
		this.listing.grab( anElement, where );
		if( this.sortable && this.sortableList ) this.sortableList.addItems( anElement );

		// reset scrollContexts
		var listItemInstance = anElement.retrieve("Class");
		listItemInstance.scrollContext = 'window';
		listItemInstance.resetFileDepth();
		listItemInstance.uiElements.each( function( uiInstance ){
			uiInstance.scrollContext = "window";
		});
		anElement.tween( "opacity", 1 );
	 	anElement.getElement(".itemControls" ).getElement(".delete").removeClass("hidden");

		if( this.sortable != null ) this.onOrderChanged();
		listItemInstance = where = null;
	},

	serialize:function(){
		console.log( this.toString(), "serialize", this.listing, this.listing.getChildren() )
		var sortArray = [];

		//get all the items to serialize
		var children = this.listing.getChildren("li");
		children.each( function ( aListing ){
			
				var listItemId = aListing.get("id");
				var listItemIdSplit = listItemId.split( "_" );
				listItemId = listItemIdSplit[ listItemIdSplit.length - 1 ];
				sortArray.push( listItemId );
			});
		try{
			return sortArray;
		}finally{
			sortArray = null;
		}
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
	
	destroy: function(){

		//We only want to killSortable if the list is currently sortable
		//It might now be, if an IPE is open and the user hits the trash can
		if(this.sortableList){
			this.killSortable();
		}

		if( this.items ){

			while( this.items.length > 0 ){
				var aChild = this.items.pop();
				aChild.destroy();
				delete aChild;
				aChild = null;
			};

		};

		$clear( this.submitDelay );		
		
		this.removeModal();
		
		delete this.modal;
		delete this.addItemDialogue;
		delete this.controls;
		delete this.instanceName;
		delete this.items;
		delete this.listing;
		delete this.oldSort;
		delete this.scroller;
		delete this.sortable;
		delete this.sortDirection;
		delete this.submitDelay;
		
		this.addItemDialogue = null;
		this.controls = null;
		this.instanceName = null;
		this.items = null;
		this.listing = null;
		this.oldSort = null;
		this.scroller = null;
		this.sortable = null;
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
	rid: null,
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
		this.rid = this.element.get("id").split("_")[1];
		if( options && options.scrollContext ) this.scrollContext = options.scrollContext;
		this.build();
	},

	getRID: function(){ return this.rid; },

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
		this.uiElements.each( function( uiElementInstance, indexA ){
			if( uiElementInstance.type == "file" || uiElementInstance.type == "imageFile" ){
 				uiElementInstance.scrollContext = 'modal';
				uiElementInstance.reposition( 'modal' );
			}
		}, this );
	},
	
	resetFileDepth: function(){
		this.uiElements.each( function( anElement ){
			if( anElement.type == "file" || anElement.type == "imageFile" ){
				anElement.reposition( 'window' );
			}
		});
	},

	JSONSend: function( action, data, options ){
		var url = mop.getAppURL() + "ajax/" + this.getSubmissionController() +  "/" + action + "/" + this.getRID();
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
		if( this.marshal.sortable != null ) this.marshal.onOrderChanged();
		this.fadeOut = new Fx.Morph( this.element, { duration: 300, onComplete: this.marshal.onItemDeleted.bind( this.marshal, this ) } );
		this.fadeOut.start( { opacity: 0 } );
	},

	
	resumeSort: function(){
		if( this.marshal.sortable ) this.marshal.resumeSort();
	},
	
	suspendSort: function(){
		if( this.marshal.sortable ) this.marshal.suspendSort();
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
		this.rid = null;

		console.log(this.element);

		//this.trash = true;

	}
	
});
