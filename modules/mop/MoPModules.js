
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
	UIElements: new Hash(),
	/*
		Variable: childModules
		Modules loaded within this module
	*/
	childModules: null, //new Hash(),
	
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
	
	isProtected: function(){
		return this.element.hasClass("protected");
	},

	/*
	Function build: Instantiates mop.ui elements by calling initUI, can be extended for other purposes...
	*/ 	
	build: function(){
		this.UIElements = this.initUI();
		this.initModules();
	},
	
	toElement: function(){
		return this.element;
	},

	toString: function(){
		return "[ Object, mop.modules.Module ]";
	},
	/*
		Function: getSubmissionController
		Returns: Name of controller to submit to.
		Note: Overriden elsewhere
	*/
	getSubmissionController: function(){
		return this.instanceName;
	},
	
	getChildMarshal: function(){
		return this;
	},
	
	/*
		Function: initModules	
		Loops through elements with the class "module" and initializes each as a module
		// there is likely a better ( faster ) way to solve this 
	*/
	initModules: function( whereToLook ){
		
		var descendantModules = ( whereToLook )? $( whereToLook ).getElements(".module") : this.element.getElements(".module");
		var filteredOutModules = [];

//		console.log( "initModules", this.toString(), this.childModules, descendantModules );

		descendantModules.each( function( aDescendant ){
			descendantModules.each( function( anotherDescendant ){
//			    console.log( "initModule, looping through descendant of", this.toString(), "\n\t", aDescendant,"\n\t", anotherDescendant );
				if(  aDescendant.hasChild( anotherDescendant ) ) filteredOutModules.push( anotherDescendant );
			}, this );
		}, this );
		
//		console.log( this.toString(), "\t\tfilteredOutModules", filteredOutModules );
		descendantModules.each( function( aDescendant ){
			if( !filteredOutModules.contains( aDescendant ) ){
        		if( !this.childModules ) this.childModules = new Hash();
				var module = this.initModule( aDescendant );
				var instanceName = module.instanceName;
				this.childModules.set( instanceName, module );
			}
		}, this );
		
//        console.log( "childModules", this.toString(), this.childModules );
        
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
		console.log( "initModule", this.toString(), element, element.get( "class" ) );
		var classPath = mop.util.getValueFromClassName( "classPath", element.get( "class" ) ).split( "_" );
		ref = null;
		classPath.each( function( node ){
			ref = ( !ref )? this[node] : ref[node];
		});
		var newModule = new ref( element, this.getChildMarshal() );
		return newModule;		
	},
	
	/*
		Function: getModuleUIElements
	*/
	getModuleUIElements: function( anElement ){
		var elements = [];
		anElement.getChildren().each( function( aChild, anIndex ){
			if( aChild.get( "class" ).indexOf( "ui-" ) > -1 ){
				elements.combine( [ aChild ] );
			} else if( !aChild.hasClass( "modal" ) && !aChild.hasClass( "module" ) && !aChild.hasClass( "listItem" ) ){
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
		
//		this.UIElements = if( !this.childModules ) this.childModules = new Hash();
		

		if( !UIElements || UIElements.length == 0  ) return null;

		UIElements.each( function( anElement ){
		    var UIElement = new mop.ui[ mop.util.getValueFromClassName( "ui", anElement.get( "class" ) )  ]( anElement, this, this.options );
		    this.UIElements.set( UIElement.fieldName, UIElement );
		}, this );
		
		if( this.postInitUIHook ) this.postInitUIHook();
		
		return UIElements;
	},

/*	
	Function: destroyChildModules
	Loops through loaded modules, and destroys unprotected ones... 
	@TODO, this shouldnt necessarily be a part of module, but rather something more like an ModuleInstantiator interface */
	destroyChildModules: function( whereToLook ){
//		console.log( "destroyChildModules", this.toString(), this.childModules );
		if( !this.childModules || this.childModules.getLength() == 0 ) return;

        var possibleTargets = ( whereToLook )? whereToLook.getElements( ".module" ) : this.element.getElements( ".module" );
		
		this.childModules.each( function( aModule ){
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
		console.log( "destroyUIElements", this, this.instanceName, this.UIElements );
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
        console.log( "Cluster objectId", this.getObjectId() );
    },
    getSubmissionController: function(){
        return this.marshal.getSubmissionController();
        // console.log( "instanceName", this.instanceName );
        // return this.instanceName;
    },
    getObjectId: function(){
	    return this.getValueFromClassName( "objectId" );
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

	JSONSend: function( action, data, options ){
		var url = mop.util.getAppURL() + this.getSubmissionController() +  "/ajax/" + action + "/";
//		console.log( this.toString(), "JSONSend", url, data, options );
		mop.util.JSONSend( url, data, options );
	},

	submitForm: function( e ){
		
        mop.util.stopEvent( e );
		
		this.generatedData = $merge( this.generatedData, this.serialize() );


		if( this.resultsContainer ){
//			this.resultsContainer.setStyle( "height", this.resultsContainer.getCoordinates().height );
			this.resultsContainer.addClass( "centeredSpinner" );
		}

		if( this.requiresValidation ){
			if( this.validateFields() ){
//				console.log( this.toString(), "submitForm fields validates.... ");
				this.JSONSend( this.action, this.generatedData, { onComplete: this.onFormSubmissionComplete.bind( this ) } );
			}
		}else{
			this.JSONSend( this.action, this.generatedData, { onComplete: this.onFormSubmissionComplete.bind( this ) } );
		}
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
				$extend( keyValuePairs, anUIElement.getKeyValuePair() );
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
				this.resultsContainer.removeClass( "centeredSpinner" );
				this.resultsContainer.set( "html", json.html );
			}
//			log( this.resultsContainer.get( "html" ) );
		}else{
			console.log( "NO JSON RESPONSE... check for 500 error?" );
		}
	
	}
	

});