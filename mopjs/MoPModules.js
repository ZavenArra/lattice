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
		unique id
	*/
	instanceName: null,
	/*
		Variable: UIFields
		Object that stores module's ui elements
	*/
	UIFields: {},
	/*
		Variable: childModules
		Modules within this module
	*/
	childModules: {},
	
	getSaveFieldURL: function(){
		throw "Abstract function getSaveFieldURL must be overriden in" + this.toString();
	},
	
	saveField: function( postData, callback ){
//			console.log( "saveField.postData:", postData );
	    return new Request.JSON( { url: this.getSaveFieldURL(), onSuccess: callback } ).post( postData );
	},
	
	initialize: function( anElementOrId, aMarshal, options ){
//		console.log( "Constructing", this.toString(), this.childModules );
		this.parent( anElementOrId, aMarshal, options );  
		this.instanceName = this.element.get("id");
		this.build();
	},
	
	/*
	Function build: Instantiates mop.ui elements by calling initUI, can be extended for other purposes...
	*/ 	
	build: function(){
//		console.log( "mop.modules.Module.build!", this.element );
		this.UIFields = this.initUI();
//		console.log( ">>> ", this.UIFields );
		this.childModules = this.initModules( this.element );
//		console.log( ">>> ", this.childModules );
	},
	
	toElement: function(){
		return this.element;
	},

	toString: function(){
		return "[ object, mop.modules.Module ]";
	},
	
	/*
		Function: initModules	
		Loops through elements with the class "module" and initializes each as a module
		// there is likely a better ( faster ) way to solve this 
	*/
	initModules: function( anElement ){
//	console.log( 'initModules', anElement );
		var childModules, filteredOutModules, descendantModules;
		descendantModules = ( anElement )? anElement.getElements(".module") : this.element.getElements(".module");
		childModules = [];
		filteredOutModules = [];
		descendantModules.each( function( aDescendant ){
			descendantModules.each( function( anotherDescendant ){
				if(  aDescendant.contains( anotherDescendant ) && aDescendant != anotherDescendant ){
//					console.log( "::::::", anotherDescendant );
					filteredOutModules.push( anotherDescendant );
				}
			}, this );
		}, this );		
		descendantModules.each( function( aDescendant ){
			if( !filteredOutModules.contains( aDescendant ) ){
				// console.log( "\t", 'calling initmodule on', aDescendant );
				var module = this.initModule( aDescendant );
				var instanceName = module.instanceName;
				// console.log( "\n::\t", module.instanceName, "is a descendant of ", this.toString());
				childModules[ instanceName ] = module;
			}
		}, this );
		return childModules;
	},
	
	
	/*
		Function: initModule
		Initializes a specific module
	*/
	initModule: function( anElement ){
		// console.log( Array.from( arguments ) );
		// console.log( "initModule", this.toString(),  "element", anElement );
		var elementClass = anElement.get( 'class' );
		var classPath = mop.util.getValueFromClassName( "classPath", elementClass ).split( "_" );
		ref = null;
//		console.log( "\t\tinitModule classPath",  classPath );
		classPath.each( function( node ){
			ref = ( !ref )? this[node] : ref[node]; 
//		console.log( ref, node );
		});
		var newModule = new ref( anElement, this );
		return newModule;		
	},

	/*
		Function: getModuleUIFields
	*/
	getModuleUIFields: function( anElement ){
		var elements = [];
		anElement.getChildren().each( function( aChild, anIndex ){
			if( aChild.get( "class" ).indexOf( "ui-" ) > -1 ){
//			    console.log( "\t\tgetModuleUIFields ", aChild );
				elements.combine( [ aChild ] );
			} else if( !aChild.hasClass( "modal" ) && !aChild.hasClass( "module" ) && !aChild.hasClass( "listItem" ) ){
//			    console.log( "\t\tgetModuleUIFields ", aChild );
				elements.combine( this.getModuleUIFields( aChild ) );
			}
		}, this );
//		console.log( "getModuleUIFields", this.toString(), anElement, elements );
		return elements;
	},
	/*
		Function: initUI
		loops through child elements and instantiates ui elements that dont live inside other modules
	*/
	initUI: function( anElement ){
		anElement = ( anElement )? anElement : this.element;
		var moduleUIFields = this.getModuleUIFields( anElement );
		if( !moduleUIFields || moduleUIFields.length == 0  ) {
			this.UIFields = new Array();
			return this.UIFields;
		}
		moduleUIFields.each( function( anElement, index ){
			console.log( 'initUI >>>> ', anElement, mop.util.getValueFromClassName( "ui", anElement.get( "class" ) )  );
			var UIField = new mop.ui[ mop.util.getValueFromClassName( "ui", anElement.get( "class" ) ) ]( anElement, this, this.options );
			this.UIFields[ UIField.fieldName ] = UIField;
			if( UIField ) UIField.setTabIndex( 'tabindex', index+1 );
		}, this );
		if( this.postInitUIHook ) this.postInitUIHook();
		return this.UIFields;
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
				delete this.childModules[key];
				delete aModule;
				aModule = null;
			}
		}, this );
	},
	
	destroyUIFields: function(){
		console.log( "destroyUIFields before", this.instanceName, this.UIFields );
		Object.each( this.UIFields, function( aUIField ){
			aUIField.destroy();
			delete aUIField;
			aUIField = null;
		}, this );
		this.UIFields = {};
		console.log( "destroyUIFields after ", this.instanceName, this.UIFields );
	},
	
	destroy: function(){
		this.destroyChildModules();
		this.destroyUIFields();
		
		this.instanceName = null;
		this.UIFields = null;
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
},


getSaveFieldURL: function(){
	var url = mop.util.getBaseURL() +"ajax/data/cms/savefield/" + this.objectId;
	console.log( "::::::", this.toString(), "getSaveFieldURL", url );
	return url;
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
	generatedData: {},

	// getSubmitFormURL: function(){
	//     return mop.util.getBaseURL() + "ajax/" + this.getSubmissionController() +  "/" + this.options.action + "/" + this.getObjectId();
	// },

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.element.getElement("input[type='submit']").addEvent( "click", this.submitForm.bindWithEvent( this ) );
		this.resultsContainer = this.element.getElement(".resultsContainer");
	},

	toString: function(){
		return "[ object, mop.module.Module, mop.modules.AjaxFormModule ]";
	},

	submitForm: function( e ){
        mop.util.stopEvent( e );
        this.gene
        ratedData = Object.merge( this.generatedData, this.serialize() );
		if( this.options.validate && !this.validateFields() ) return false;	
		return new Request.JSON({
            url:  this.getSubmitFormURL(),
            onSuccess: this.onFormSubmissionComplete.bind( this )
        }).post( this.generatedData );
	},

	validateFields: function(){
		var returnVal = true
		this.UIFields.each( function( aUIField, anIndex ){
			if( aUIField.validationOptions && aUIField.enabled ){
				returnVal = ( aUIField.validate() )? true : false ;
			}
		});
		return returnVal;
	},

	getGeneratedDataQueryString: function(){
		return new Hash( this.generatedData ).toQueryString();
	},

	serialize: function(){
		var query = "";
		var keyValuePairs = {};
		this.UIFields.each( function( aUIField ){
			if( aUIField.type != "interfaceWidget" ){
				keyValuePairs.append( aUIField.getKeyValuePair() );
			}
		}, this );
		return keyValuePairs;
	},
	
	clearFormFields: function( e ){
		mop.util.stopEvent( e );
		this.UIFields.each( function( aUIField ){
			aUIField.setValue( null );
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
			throw "NO JSON RESPONSE... check for 500 error?";
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
	
	getSaveFieldURL: function(){
    throw "MoPList Abstract function getSaveFieldURL must be overriden in" + this.toString();
	},

	getAddObjectURL: function(){
	    throw "Abstract function getAddObjectURL must be overriden in" + this.toString();
	},
	
	getRemoveObjectURL: function(){
	    throw "Abstract function getRemoveObjectURL must be overriden in" + this.toString();
	},

	getSubmitSortOrderURL: function(){ 
	    throw "Abstract function getSubmitSortOrderURL must be overriden in" + this.toString();
	},

	// getSubmissionController: function(){
	//     throw "Abstract function getSubmissionController must be overriden in" + this.toString();		
	// },
	
	getObjectId: function(){
	    return this.objectId;
	},

	toString: function(){
		return "[ Object, mop.MoPObject, mop.modules.Module, mop.modules.MoPList ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
        delete this.items;
        this.items = null;
        this.items = [];
        if( this.options.allowChildSort ) this.makeSortable( this.listing );
        this.objectId = this.element.get("id").split("_")[1];
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
			this.items.push( new mop.modules.ListItem( element, this, this.addObjectDialogue ) ); 
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
        var element = this.addObjectDialogue.setContent( json.response.html, this.controls.getElement( ".addItem" ).get( "text" ) );
        var listItem = new mop.modules.ListItem( element, this, this.addObjectDialogue, { scrollContext: 'modal' } );
        Object.each( listItem.UIFields, function( uiFIeld ){
        	uiFIeld.scrollContext = "modal";
        });
        this.items.push( listItem );
        mop.util.EventManager.broadcastMessage( "resize" );
        listItem = null;
	},

	removeObject: function( item ){
	    this.removeObjectRequest( item.getObjectId() );
	  	this.items.erase( item );
		item.destroy();
		item = null;
		mop.util.EventManager.broadcastMessage( "resize" );          
	},
	
	removeObjectRequest: function( itemObjectId ){
		console.log( "removeObjectRequest", this.toString(), this.getRemoveObjectURL );
		var jsonRequest = new Request.JSON( { url: this.getRemoveObjectURL( itemObjectId ) } ).send();
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
		var where = ( this.options.sortDirection == "DESC" )? "top" : "bottom";
		this.listing.grab( anElement, where );
		if( this.allowChildSort && this.sortableList ) this.sortableList.addItems( anElement );
		// reset scrollContexts
		var listItemInstance = anElement.retrieve("Class");
		listItemInstance.scrollContext = 'window';
		listItemInstance.resetFileDepth();
		Object.each( listItemInstance.UIFields, function( aUIField ){
			aUIField.scrollContext = "window";
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
            var request = new Request.JSON( { url: this.getSubmitSortOrderURL } ).post( { sortorder: newOrder } );
			this.oldSort = newOrder;
			return request;
		}
	},
	
	serialize:function(){
		var sortArray = [];
		var children = this.listing.getChildren("li");
		children.each( function ( aListing ){
		    if( aListing.get( "id" ) ){
//    		    console.log( this.toString(), aListing, aListing.get( "id" ) ); 	
                var listItemId = aListing.get("id");
                var listItemIdSplit = listItemId.split( "_" );
                listItemId = listItemIdSplit[ listItemIdSplit.length - 1 ];
                sortArray.push( listItemId );		        
		    }
		});
//        console.log( this.toString(), "serialize", this.listing, sortArray );
		return sortArray;
	},

	destroy: function(){
		if(this.sortableList) this.removeSortable( this.sortableList );
		clearInterval( this.submitDelay );		
		this.removeModal();
		this.addObjectDialogue = this.controls = this.instanceName = this.items = this.listing = this.oldSort = this.allowChildSort, this.sortDirection, this.submitDelay = null;
    if( this.scroller ) this.scroller = null;
		mop.util.EventManager.broadcastMessage( 'resize' );
		this.parent();
	}
});

mop.modules.ListItem = new Class({
	
	Extends: mop.modules.Module,
	Implements: [ Events, Options ],
	addObjectDialogue: null,
	objectId: null,
	scrollContext: null,
	controls: null,
	fadeOut: null,
	
  /* Section: Getters & Setters */
	
	getObjectId: function(){ return this.objectId; },
	getSaveFieldURL: function(){
		var url =  this.marshal.getSaveFieldURL( this.getObjectId() );
		console.log( "listItem.getSaveFieldURL", url );
		return url;
	},

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
//		console.log( this.controls, this.controls.getElement(".delete") );
		if( this.controls.getElement(".delete") ) this.controls.getElement(".delete").addEvent( "click", this.removeObject.bindWithEvent( this ) );
	},

	filesToTop: function(){
		Object.each( this.UIFields, function( aUIField, indexA ){
			if( aUIField.type == "file" || aUIField.type == "imageFile" ){
 				aUIField.scrollContext = 'modal';
				aUIField.reposition( 'modal' );
			}
		}, this );
	},
	
	resetFileDepth: function(){
		console.log( this, this.toString(), this.UIFields );
		Object.each( this.UIFields, function( anElement ){
			if( anElement.type == "file" || anElement.type == "imageFile" ) anElement.reposition( 'window' );
		});
	},

	removeObject: function( e ){
		mop.util.stopEvent( e );
		if( this.marshal.sortableList != null ) this.marshal.onOrderChanged();
		this.fadeOut = new Fx.Morph( this.element, { duration: 300, onComplete: function(){ this.marshal.removeObject( this ) }.bind( this ) } );
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
		this.parent();  //call the superclass's destroy method
		this.addObjectDialogue = null;
		this.controls = null;
		this.fadeOut = null;
		this.scrollContext = null;
		this.objectId = null;
	}
	
});
