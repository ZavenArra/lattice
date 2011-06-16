/*
	Section: mop.module
	mop Modules
*/
mop.modules = {};
/* 
	Class: mop.modules.Module
	Base module
*/
mop.modules.Module = new Class({

	Extends: mop.MoPObject,	
	/*
		Variable: instanceName
		id of element, also used as unique id for module manager.
	*/
	instanceName: null,
	/*
		Variable: UIElements
		list of this module's UIElements
	*/
	UIElements: {},
	/*
		Variable: childModules
		Modules loaded within this module
	*/
	childModules: {},
	
	initialize: function( anElementOrId, aMarshal, options ){
//		console.log( "Constructing", this.toString(), this.childModules );
		this.parent( anElementOrId, aMarshal, options );
		this.instanceName = this.element.get("id");
		this.build();			
	},
	
	onModalScroll: function( scrollData ){
		this.UIElements.each( function( anUIElement ){
			anUIElement.reposition( mop.ModalManager.getActiveModal() );
		});
	},
	
	/*
	Function build: Instantiates mop.ui elements by calling initUI, can be extended for other purposes...
	*/ 	
	build: function(){
//	    console.log("mop.modules.Module.build!")
		this.UIElements = this.initUI();
		this.initModules();
	},
	
	toElement: function(){
		return this.element;
	},

	toString: function(){
		return "[ object, mop.modules.Module ]";
	},
	
	/*
		Function: getSubmissionController
		Returns: Name of controller to submit to.
		Note: Overriden elsewhere
	*/
	getSubmissionController: function(){
		return this.instanceName;
	},
	
	/*
		Function: initModules	
		Loops through elements with the class "module" and initializes each as a module
		// there is likely a better ( faster ) way to solve this 
	*/
	initModules: function( anElement ){
		var descendantModules = ( anElement )? anElement.getElements(".module") : this.element.getElements(".module");
		var filteredOutModules = [];
		descendantModules.each( function( aDescendant ){
			descendantModules.each( function( anotherDescendant ){
				if(  aDescendant.contains( anotherDescendant ) && aDescendant != anotherDescendant ) filteredOutModules.push( anotherDescendant );
			}, this );
		}, this );
		descendantModules.each( function( aDescendant ){
			if( !filteredOutModules.contains( aDescendant ) ){
				var module = this.initModule( aDescendant );
				var instanceName = module.instanceName;
				this.childModules[ instanceName ] = module;
			}
		}, this );
        delete filteredOutModules, descendantModules;
        filteredOutModules = descendantModules = null;
	},
	
	getObjectId: function(){
	    return mop.util.getObjectId();
	},
	
	/*
		Function: initModule
		Initializes a specific module
	*/
	initModule: function( element ){
		var classPath = mop.util.getValueFromClassName( "classPath", element.get( "class" ) ).split( "_" );
		console.log( "\t\tinitModule", this.toString(), element.get( "class" ), classPath );
		ref = null;
		classPath.each( function( node ){
		    ref = ( !ref )? this[node] : ref[node]; 
//  		    console.log( ref, node );
		});
    	var newModule = new ref( element, this );
		return newModule;		
	},

	/*
		Function: getModuleUIElements
	*/
	getModuleUIElements: function( anElement ){
		var elements = [];
		anElement.getChildren().each( function( aChild, anIndex ){
			if( aChild.get( "class" ).indexOf( "ui-" ) > -1 ){
//			    console.log( "\t\tgetModuleUIElements ", aChild );
				elements.combine( [ aChild ] );
			} else if( !aChild.hasClass( "modal" ) && !aChild.hasClass( "module" ) && !aChild.hasClass( "listItem" ) ){
//			    console.log( "\t\tgetModuleUIElements ", aChild );
				elements.combine( this.getModuleUIElements( aChild ) );
			}
		}, this );
//		console.log( "getModuleUIElements", this.toString(), anElement, elements );
		return elements;
	},
	/*
		Function: initUI
		loops through child elements and instantiates ui elements that dont live inside other modules
	*/
	initUI: function( anElement ){
	    anElement = ( anElement )? anElement : this.element;
		var UIElements = this.getModuleUIElements( anElement );
		if( !UIElements || UIElements.length == 0  ) return null;
		UIElements.each( function( anElement ){
		    console.log( 'initUI >>>> ', anElement, mop.util.getValueFromClassName( "ui", anElement.get( "class" ) )  );
		    var UIElement = new mop.ui[ mop.util.getValueFromClassName( "ui", anElement.get( "class" ) ) ]( anElement, this, this.options );
		    this.UIElements[ UIElement.fieldName ] = UIElement;
		}, this );
		if( this.postInitUIHook ) this.postInitUIHook();
		return UIElements;
	},

/*  Function: destroyChildModules */
	destroyChildModules: function( whereToLook ){
//		console.log( "destroyChildModules", this.toString(), this.childModules );
		if( !this.childModules || Object.getLength( this.childModules ) == 0 ) return;
        var possibleTargets = ( whereToLook )? whereToLook.getElements( ".module" ) : this.element.getElements( ".module" );
		Object.each( this.childModules, function( aModule ){
		    if( possibleTargets.contains( aModule.element ) ){
		        var key = aModule.instanceName;
				aModule.destroy();
				this.childModules.erase( key );
				delete aModule;
				aModule = null;
			}
		}, this );
	},
	
	destroyUIElements: function(){
//		console.log( "destroyUIElements", this, this.instanceName, this.UIElements );
		if( !this.UIElements || !this.UIElements.length || this.UIElements.length == 0  ) return;
		this.UIElements.each( function( aUIElement ){
			var key = aUIElement.fieldName;
			aUIElement.destroy();
			this.UIElements.erase( key );
			delete aUIElement;
			aUIElement = null;
		}, this );
		
//	console.log( "post destroyUIElements ", this.UIElements );

	},
	
	destroy: function(){
		this.destroyChildModules();
		this.destroyUIElements();
		
		delete this.UIElements;
		delete this.instanceName;
		delete this.childModules;
		
		this.instanceName = null;
		this.UIElements = null;
		this.childModules = null;
		
		this.parent();
	}

});


/* 
	Class: mop.modules.Module
	Base module
*/

mop.modules.Cluster = new Class({
    Extends: mop.modules.Module,
    initialize: function( anElementOrId, aMarshal, options ){
        this.parent( anElementOrId, aMarshal, options );
        this.objectId = this.element.get("id").split("_")[1];
		
        // console.log( "Cluster objectId", this.getObjectId() );
    },
    getSubmissionController: function(){
        return this.marshal.getSubmissionController();
        // console.log( "instanceName", this.instanceName );
        // return this.instanceName;
    },
    getObjectId: function(){
	    return this.objectId;
	}
});



/*
	Class mop.module.AjaxFormModule
	Module that validates and submits inputs via ajax calls.
*/
mop.modules.AjaxFormModule = new Class({

	Extends: mop.modules.Module,
	action: null,
	generatedData: {},

	getSubmitFormURL: function(){
	    return mop.util.getBaseURL() + "ajax/" + this.getSubmissionController() +  "/" + this.action + "/" + this.getObjectId();
	},

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.action = mop.util.getValueFromClassName( "action", this.element.get( "class" ) );
		this.element.getElement("input[type='submit']").addEvent( "click", this.submitForm.bindWithEvent( this ) );
		this.resultsContainer = this.element.getElement(".resultsContainer");
		this.requiresValidation = ( mop.util.getValueFromClassName( "validate", this.element.get( "class" ) ) == "true" )? true : false;
	},

	toString: function(){
		return "[ object, mop.module.Module, mop.modules.AjaxFormModule ]";
	},

	submitForm: function( e ){
        mop.util.stopEvent( e );
        this.gene
        ratedData = Object.merge( this.generatedData, this.serialize() );
		if( this.requiresValidation && !this.validateFields() ) return false;	
		return new Request.JSON({
            url:  this.getSubmitFormURL(),
            onSuccess: this.onFormSubmissionComplete.bind( this )
        }).post( this.generatedData );
	},
	
	
	validateFields: function(){
		var returnVal = true
		this.UIElements.each( function( anUIElement, anIndex ){
//			console.log( "validateFields", anUIElement.fieldName, anUIElement.enabled );
			if( anUIElement.validationOptions && anUIElement.enabled ){
				returnVal = ( anUIElement.validate() )? true : false ;
			}
		});
		return returnVal;
	},

	getGeneratedDataQueryString: function(){
		return new Hash( this.generatedData ).toQueryString();
	},

	serialize: function(){
//		console.log( this.toString(), "serialize", this.UIElements.length );
		var query = "";
		var keyValuePairs = {};
		this.UIElements.each( function( anUIElement ){
			
//			console.log( this.toString(), anUIElement.type, anUIElement.fieldName, anUIElement );

			if( anUIElement.type != "interfaceWidget" ){
				keyValuePairs.append( anUIElement.getKeyValuePair() );
			}
		}, this );
		return keyValuePairs;
	},
	
	clearFormFields: function( e ){
		mop.util.stopEvent( e );
		this.UIElements.each( function( anUIElement ){
			//console.log( this.toString(), anUIElement.type, anUIElement.fieldName, anUIElement );
			if( anUIElement.setValue ) anUIElement.setValue( null );
		}, this );
	},

	onFormSubmissionComplete: function( text, json ){

		if( json ){
//			console.log( this.toString(), "onFormSubmissionComplete", text, json );
			json = JSON.decode( json );
//			console.log( this.toString(), "onFormSubmissionComplete" );
			if( this.resultsContainer ){
//				this.resultsContainer.setStyle( "height", 'auto' );
//				this.resultsContainer.removeClass( "centeredSpinner" );
				this.resultsContainer.set( "html", json.html );
			}
//			log( this.resultsContainer.get( "html" ) );
		}else{
			console.log( "NO JSON RESPONSE... check for 500 error?" );
		}
	
	}
	

});

mop.modules.MoPList = new Class({

	/* TODO write unit tests for List*/
	Extends: mop.modules.Module,
	// listing properties and members, helps with maintenance and destruction.... standard practice from now on
	sortable: null,
	sortDirection: null,
	instanceName: null,
	addObjectDialogue: null,
	items: null,
	controls: null,
	sortableList: null,
	scroller: null,
	submitDelay: null,
	oldSort: null,
	
	/* Section: Getters & Setters */
	getAddObjectURL: function(){
	    throw "Abstract function getAddObjectURL must be overriden in" + this.toString();
	},
	
	getRemoveObjectURL: function(){
	    throw "Abstract function getRemoveObjectURL must be overriden in" + this.toString();
	},

	getSubmitSortOrderURL: function(){ 
	    throw "Abstract function getSubmitSortOrderURL must be overriden in" + this.toString();
	},
	
	getObjectId: function(){
	    return this.objectId;
	},
	
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
        delete this.items;
        this.items = null;
        this.items = [];
        this.allowChildSort = ( this.getValueFromClassName( "allowChildSort" ) == "false" ) ? false : true;
        this.sortDirection = this.getValueFromClassName( "sortDirection" );
        if( this.allowChildSort ) this.makeSortable();
        this.objectId = this.element.get("id").split("_")[1];
	},

	toString: function(){
		return "[ object, mop.modules.List ]";
	},
	
	build: function(){
		this.parent();
		this.initControls();
		this.addObjectDialogue = null;
		this.initList();
	},	
	
	initList: function(){
		delete this.items;
		this.items = null;
		this.items = [];
		this.listing = this.element.getElement( ".listing" );
		var children = this.listing.getChildren("li");
		children.each( function( element ){
			this.items.push( new mop.modules.MoPListItem( element, this, this.addObjectDialogue ) ); 
		}, this );
	},

	initControls: function(){
		// console.log( this.element.getElement( "#" + this.instanceName+"AddObjectModal" ).retrieve("Class") );
		this.controls = this.element.getChildren( ".controls" );
		var addObjectButton = this.controls.getElement( ".addItem" ).addEvent("click", this.addObjectRequest.bindWithEvent( this ) );
		if( this.allowChildSort ){
			var saveSort = this.controls.getElement( ".saveSort" ).addEvent("click", this.saveSort.bindWithEvent( this ) );
			saveSort = null;
		}
		addObjectButton = null;
	},
	
	addObjectRequest: function( e ){
	    mop.util.stopEvent( e );
		if( this.addObjectDialogue ) this.removeModal( this.addObjectDialogue );
		this.addObjectDialogue = new mop.ui.AddObjectDialogue( null, this );
		this.addObjectDialogue.showLoading( e.target.get("text") );
        return new Request.JSON( { url: this.getAddObjectURL(), onSuccess: this.onAddObjectResponse.bind( this ) } ).send();
	},
    
	onAddObjectResponse: function( json ){
        console.log( "::::: ", json );
        var element = this.addObjectDialogue.setContent( json.response.html, this.controls.getElement( ".addItem" ).get( "text" ) );
        var listItem = new mop.modules.ListItem( element, this, this.addObjectDialogue, { scrollContext: 'modal' } );
        listItem.UIElements.each( function( uiInstance ){
        	uiInstance.scrollContext = "modal";
        });
        this.items.push( listItem );
        mop.util.EventManager.broadcastEvent( "resize" );
        listItem = null;
	},
	
    removeObjectRequest: function( item ){
        var jsonRequest = Request.JSON( { url: this.getDeleteItemURL( item ) } ).send();
    	this.items.erase( item );
		item.destroy();
		item = null;
		mop.util.EventManager.broadcastEvent( "resize" );        
		return jsonRequest;
    },
    
    removeObjectResponse: function( json ){
        console.log( "removeObjectResponse", json );
    },

	removeModal: function( aModal ){
		if( !this.addObjectDialogue ) return;
		this.addObjectDialogue = null;
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

	makeSortable: function(){
		if( this.allowChildSort && !this.sortableList ){
			this.sortableList = new mop.ui.Sortable( this.listing, this, $( document.body ) );
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
	    console.log( "onOrderChanged", this, this.toString() );
		var newOrder = this.serialize();
		clearInterval( this.submitDelay );
		this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder.join(",") );
		newOrder = null;
	},
	
	submitSortOrder: function( newOrder ){
		if( this.allowChildSort && this.oldSort != newOrder ){
			clearInterval( this.submitDelay );
			this.submitDelay = null;
            Request.JSON( { url: this.getSubmitSortOrderURL } ).post( { sortorder: newOrder } );
			this.oldSort = newOrder;
		}
	},
	
	serialize:function(){
		var sortArray = [];
		var children = this.listing.getChildren("li");
		children.each( function ( aListing ){
		    if( aListing.get( "id" ) ){
    		    console.log( this.toString(), aListing, aListing.get( "id" ) ); 	
                var listItemId = aListing.get("id");
                var listItemIdSplit = listItemId.split( "_" );
                listItemId = listItemIdSplit[ listItemIdSplit.length - 1 ];
                sortArray.push( listItemId );		        
		    }
		});
        console.log( this.toString(), "serialize", this.listing, sortArray );
		return sortArray;
	},

	destroy: function(){
		if(this.sortableList) this.removeSortable( this.sortableList );
		clearInterval( this.submitDelay );		
		this.removeModal();
		this.addObjectDialogue = this.controls = this.instanceName = this.items = this.listing = this.oldSort = this.allowChildSort, this.sortDirection, this.submitDelay = null;
        if( this.scroller ) this.scroller = null;
		mop.util.EventManager.broadcastEvent( 'resize' );
		this.parent();
	}
});

mop.modules.MoPListItem = new Class({
	Extends: mop.modules.Module,
	Implements: [ Events, Options ],
	addObjectDialogue: null,
	objectId: null,
	scrollContext: null,
	controls: null,
	fadeOut: null,
	
    /* Section: Getters & Setters */
	getObjectId: function(){ return this.objectId; },
	getDeleteItemURL: function(){ throw( "Abstract function getDeleteItemURL must be overriden in", this.toString() ); },	
	
	initialize: function( anElement, aMarshal, addObjectDialogue, options ){
		this.element = $( anElement);
		this.element.store( "Class", this );
		this.marshal = aMarshal;
		this.instanceName = this.element.get( "id" );
		this.addObjectDialogue = addObjectDialogue;
		this.objectId = this.element.get("id").split("_")[1];
		if( options && options.scrollContext ) this.scrollContext = options.scrollContext;
		this.build();
	},

	toString: function(){ return "[ object, mop.modules.Module, mop.modules.ListItem ]"; },

	build: function(){ 
	    this.parent();
	    this.initControls();
	},

	initControls: function(){
		this.controls = this.element.getElement(".itemControls");
		console.log( this.controls, this.controls.getElement(".delete") );
		if( this.controls.getElement(".delete") ) this.controls.getElement(".delete").addEvent( "click", this.removeObject.bindWithEvent( this ) );
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
			if( anElement.type == "file" || anElement.type == "imageFile" ) anElement.reposition( 'window' );
		});
	},
		
	removeObject: function( e ){
	    mop.util.stopEvent( e );
		if( this.marshal.sortableList != null ) this.marshal.onOrderChanged();
		this.fadeOut = new Fx.Morph( this.element, { duration: 300 } );
		this.fadeOut.start( { opacity: 0 } );
		this.marshal.deleteItem( this );	        
	},
	
	resumeSort: function(){
		if( this.marshal.sortableList ) this.marshal.resumeSort();
	},
	
	suspendSort: function(){
		if( this.marshal.sortableList ) this.marshal.suspendSort();
	},
	
	destroy: function(){
		this.element.destroy();
		this.parent();  //call the superclass's destroy method
		this.addObjectDialogue = null;
		this.controls = null;
		this.fadeOut = null;
		this.scrollContext = null;
		this.objectId = null;
	}
	
});