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
		Variable: uiElements
		list of this module's uiElements
	*/
	uiElements: [],
	/*
		Variable: loadedModules
		Modules loaded within this module (likely going away soon)
	*/
	childModules: [],
	
	initialize: function( anElementOrId, aMarshal, options ){	
		this.parent( anElementOrId, aMarshal, options );
		this.instanceName = this.element.get("id");
		this.build();
	},
	
	onModalScroll: function( scrollData ){
		this.uiElements.each( function( anUIElement ){
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
		this.initUI();
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
	
	/*
		Function: initModules	
		Loops through elements with the class "module" and initializes each as a module
	*/
	initModules: function(){
		// there is likely a better ( faster ) way to solve this 
		var descendantModules = this.element.getElements(".module");
		var childModules = [];
		var filteredModules = [];		
		descendantModules.each( function( aDescendant ){
			descendantModules.each( function( anotherDescendant ){
				if(  aDescendant.hasChild( anotherDescendant ) ) filteredModules.push( anotherDescendant );
			});
		});
		descendantModules.each( function( aDescendant ){
			if( filteredModules.indexOf( aDescendant ) == -1 ){
				this.childModules.push( this.initModule( aDescendant ) );
			}
		});
		return this.childModules;
	},
	
	/*
		Function: initModule
		Initializes a specific module
	*/
	initModule: function( element, context ){
		var classPath = mop.util.getValueFromClassName( "classPath", element.get( "class" ) ).split( "_" );
		ref = null;
		classPath.each( function( node ){
			ref = ( !ref )? this[node] : ref[node];
		});
		var marshal = ( mop.util.getValueFromClassName( "marshal", element.get("class") ) )?  mop.ModuleManager.getModuleById( mop.util.getValueFromClassName( "marshal", element.get("class") ) ) : null;
		console.log( "classToInstantiate\t", class, "context", context );
		var newModule = new ref( element, marshal );
		return newModule;		
	},
	
	/*
		Function: getModuleUiElements
	*/
	getModuleUiElements: function( anElement ){
		var elements = [];
		anElement.getChildren().each( function( aChild, anIndex ){
			if( aChild.get( "class" ).indexOf( "ui" ) > -1 ){
				elements.combine( [ aChild ] );
			} else if( !aChild.hasClass( "modal" ) && !aChild.hasClass( "module" ) && !aChild.hasClass( "listItem" ) ){
				elements.combine( this.getModuleUiElements( aChild ) );
			}
		}, this );
		return elements;
	},
	/*
		Function: initUI
		loops through child elements and instantiates ui elements that dont live inside other modules
	*/
	initUI: function(){
		var elements = this.getModuleUiElements( this.element );
		if( !elements ) return null;
		elements.each( function( anElement, anIndex ){
			this.uiElements.push( new mop.ui[ mop.util.getValueFromClassName( "ui", anElement.get("class") ) ]( anElement, this, this.options ) );
		}, this );
		elements = null;
	},

/*	
	Function: destroyChildModules
	Loops through loaded modules, and destroys unprotected ones... 
	@TODO, this shouldnt necessarily be a part of module, but rather something more like an ModuleInstantiator interface */
	destroyChildModules: function(){
		if( !this.loadedModules.length ) return;

		var count = this.loadedModules.length - this.protectedModules.length;
		
		while( this.loadedModules.length >= count ){

			if( !this.loadedModules[ this.loadedModules.length - 1 ].isProtected() ){
				var moduleReference = this.loadedModules.pop();		
				mop.ModuleManager.destroyModuleById( moduleReference.instanceName, this.instanceName + "destroyChildModules" );
				delete moduleReference;
				moduleReference = null;				
			}
		}
	},
	
	destroyUIElements: function(){
		
		if( !this.uiElements.length ) return;
		while( this.uiElements.length > 0 ){
			var aUIElement = this.uiElements.pop();
			aUIElement.destroy();
			delete aUIElement;
			aUIElement = null;
		}

	},
	
	destroy: function(){
		
		this.element.setStyle( "display", "none" );
		
		this.destroyChildModules();
		this.destroyUIElements();
		
		this.element.eliminate( "Class" );

		delete this.uiElements;
		delete this.elementClass;
		delete this.instanceName;
		delete this.protectedModules;
		delete this.loadedModules;
		delete this.options;

		
		this.element = null;
		this.elementClass = null;
		this.instanceName = null;
		this.marshal = null;
		this.uiElements = null;
		this.loadedModules = null;
		this.protectedModules = null;
		
		this.options = null;
	}

});

/*
	Class mop.module.ApplicationModule
	Front-Controller for the running application
	Note: Extended Module that can handle view stacks (eg a module that loads other modules into a tabbed modal interface).
*/
mop.modules.ViewStackModule = new Class({

	Extendeds: mop.modules.Module;

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	},

	initModules: function(){
		
	},

	destroyModules: function(){
		
	},

	destroy: function(){}

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
		
//		console.log( this.toString(), "submitForm", e );
		if( e && e.preventDefault ){
			e.preventDefault();
		}else if( e ){
			e.returnValue = false;
		}
		
		this.generatedData = $merge( this.generatedData, this.serialize() );


		if( this.resultsContainer ){
//			this.resultsContainer.setStyle( "height", this.resultsContainer.getCoordinates().height );
			this.resultsContainer.addClass( "centeredSpinner" );
		}

		if( this.requiresValidation ){
			if( this.validateFields() ){
				console.log( this.toString(), "submitForm fields validates.... ");
				this.JSONSend( this.action, this.generatedData, { onComplete: this.onFormSubmissionComplete.bind( this ) } );
			}
		}else{
			this.JSONSend( this.action, this.generatedData, { onComplete: this.onFormSubmissionComplete.bind( this ) } );
		}
	},
	
	validateFields: function(){
		var returnVal = true
		this.uiElements.each( function( anUIElement, anIndex ){
			console.log( "validateFields", anUIElement.fieldName, anUIElement.enabled );
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
//		console.log( this.toString(), "serialize", this.uiElements.length );
		var query = "";
		var keyValuePairs = {};
		this.uiElements.each( function( anUIElement ){
			
//			console.log( this.toString(), anUIElement.type, anUIElement.fieldName, anUIElement );

			if( anUIElement.type != "interfaceWidget" ){
				$extend( keyValuePairs, anUIElement.getKeyValuePair() );
			}
		}, this );
		return keyValuePairs;
	},
	
	clearFormFields: function( e ){
		if( e && e.stop ){
			e.stop();
		}else if( e ){
			e.returnValue = false;
		}
		this.uiElements.each( function( anUIElement ){
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