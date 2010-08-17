//msie6 redirect
if( Browser.Engine.trident4 ){
	window.location.href =  $(document).getElement("head").getElement("base").get("href") + "msielanding";
}


/*
Fix for:
https://mootools.lighthouseapp.com/projects/2706/tickets/651-classtostring-broken-on-122-big-regression
*/
Class.Mutators.toString = Class.Mutators.valueOf = $arguments(0);

/*
	mopCore.js

	Documentation:
		onDomReady: instantiates instance of mop.modMan
	
	procedure:	Quick hack to prevent browsers w/o a console, or firebug from generating errors when console functions are called.
	Gets called on post definition.
*/
function buildConsoleObject(){	
	if (!window.console ){
	    var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
	    window.console = {};
	    for (var i = 0; i < names.length; ++i){
			window.console[names[i]] = function() {};
		}
		names = null;
	}else if( Browser.Engine.webkit ){
	    var names = [ "debug", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
	    for (var i = 0; i < names.length; ++i){
			window.console[names[i]] = function() {};
		}
		names = null;		
	}
}

buildConsoleObject();

/*
	Section: Extending Mootools
*/
Element.implement({
	getSiblings: function(match,nocache) {
		return this.getParent().getChildren(match,nocache).erase(this);
	}	
});

Element.implement({
	getSibling: function(match,nocache) {
		return this.getSiblings(match,nocache)[0];
	}
});

/*
	Implementing isBody as non private function and implementing getScrolls fix from: https://mootools.lighthouseapp.com/projects/2706/tickets/637-getcoordinatesgetleftgettop-bug-on-overflowhidden-elements
	TODO: *** REMOVE WHEN MOOTOOLS FIXES THIS...  its in milestone for 2.0 but no fix yet***
*/
Element.implement({
	isBody: function(element){
		return (/^(?:body|html)$/i).test(element.tagName);
	}
});

Element.implement({
	getScrolls: function(){
		var element = this.parentNode, position = {x: 0, y: 0};
		while (element && !this.isBody(element)){
	    position.x += element.scrollLeft;
	    position.y += element.scrollTop;
	    element = element.parentNode;
	  }
	  return position;
	}
});

/*
	Function: String.encodeUTF8
	Implements encodeUTF8 into mootools' native String class
 	Argument: s{String} a string
	Returns: {String} argumemt string as UTF-8 string
*/
String.implement( "encodeUTF8", function(  ){
  return unescape( encodeURIComponent( this ) );
});

/*
	Section: MoP Package
	mop is a namespace, quick definition of namespace, more useful for documentation than anything else.
*/

mop = {

	_domIsReady: false,

	getBaseURL: function(){
		return $(document).getElement("head").getElement("base").get("href");
	},

	getAppURL: function(){

		var appURLAppendClassName = mop.util.getValueFromClassName( "appUrlAppend", $(document).getElement("body").get("class") );
		var appUrlAppend;

		if( typeof appURLAppendClassName == "string" ){
			appUrlAppend = appURLAppendClassName + ".php/";
		}else{
			appUrlAppend = "";
		}

		// var appUrlAppend = ( appURLAppendClassName )? appURLAppendClassName + ".php/" : "";
		return mop.getBaseURL() + appUrlAppend;

	}

}


/*
	Section: mop.util
*/
mop.util = {};

/*
	Function: mop.util.loadStyleSheet
	Attach a stylesheet element to head element via DOM
 	Parameters:
		cssURL - path to the stylesheet to be attached default value is "screen"
		media - media type to apply to stylesheet element
*/

mop.util.loadStyleSheet = function( cssURL, mediaString, opts ){
	var options = ( opts )? opts : {};
	options.media = ( mediaString )? mediaString : "screen";
	new Asset.css( cssURL, options ); 
	options = null;
}

/*
	Function: mop.util.loadJS
	Attach a javascript element to head element via DOM
 	Arguments:
		jsURL - {String} path to the script element to be attached
*/
mop.util.loadJS = function( jsURL, options ){
	return new Asset.javascript( jsURL, options );
}

/*
	Function: mop.util.domIsReady
	Set mop._domIsReady to true

*/

mop.util.domIsReady = function(){
	mop._domIsReady = true;
}


mop.util.destroyInstance = function( anInstance ){
	delete anInstance;
	anInstance = null;
}

/*
 	Function: mop.util.stopEvent 
	Stops event bubbling, normally this is handled in each instance
	But this will serve as a nice shortcut given the verbosity needed to deal with Ie6 ( the whole return value conditional )
*/
mop.util.stopEvent = function( e ){
	if( e && e.preventDefault ){
		e.stop();
	}else if( e ){
		e.returnValue = false;
	}
}

/*
 	Function: mop.util.preventDefault 
	Prevents default actions on click events, similart to stopEvent... see mootools documentation for distinction
	This will serve as a nice shortcut given the verbosity needed to deal with Ie6 ( the whole return value conditional )
*/
mop.util.preventDefault = function( e ){
	if( e && e.preventDefault ){
		e.preventDefault();
	}else if( e ){
		e.returnValue = false;
	}	
}

/*
 	Function: mop.util.isDomReady 
	Retrieve the value of mop.util.isDomReady
	Returns: mop._domIsReady
*/
mop.util.isDomReady = function(){
	return mop._domIsReady;
}

/* Function: mop.util.getValueFromClassName
	Arguments: key {String}, aClassName {String} (space delimeted)
	Returns: {String} value
*/
mop.util.getValueFromClassName = function( key, aClassName ){
	if(!aClassName) return;
	var classNames = aClassName.split( " " );
//	console.log( "mop.util.getValueFromClassName ", classNames.join(", ") );
	var result = null;
	classNames.each( function( className ){
		if( className.indexOf( key ) == 0 ) result = className.split("-")[1];
	});
	return result;
}

/*
	Function: mop.util.getUniqueId
	Get a unique string based on the unix date string
 	Arguments -
		prefix- {String}  A prefix to prepend to the id string.
	Returns: {String} unique id with prefix (if specified)
*/
mop.util.getUniqueId = function ( prefix ){
	var now = new Date();
	var newId = now.getYear() + now.getMonth() + now.getHours() + now.getMinutes() + now.getSeconds() + now.getMilliseconds() + now.getMilliseconds() + Math.random( 10000000 );
	try{
		return (prefix) ? String( prefix + newId ) : String( newId );
	}finally{
		delete now;
		delete newId;
		now = null;
		newId = null;
	}
}

mop.util.JSONSend = function( url, data, options ){
	if( options ){ 
		options.url = url;
	}else{
		options = { url: url };
	}
//	console.log( "mop.util.JSONSend", url, data, options );
	new Request.JSON( options ).post( data );
},

mop.util.validation = {

	regEx : {
		required : /[^.+]/,
		nonEmpty : /[^.+]/,
		alpha : /^[a-z ._-]+$/i,
		alphanum : /^[a-z0-9 ._-]+$/i,
		digit : /^[-+]?[0-9]+$/,
		nodigit : /^[^0-9]+$/,
		number : /^[-+]?\d*\.?\d+$/,
		email : /^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i,
		password :  /\*+/ ,
		phone : /^[\d\s ().-]+$/,
		url : /^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i
	},

	alerts : {
		required: "This field is required.",
		nonEmpty: "This field cannot be empty.",
		alpha: "This field accepts alphabetic characters only.",
		alphanum: "This field accepts alphanumeric characters only.",
		nodigit: "No digits are accepted.",
		digit: "Please enter a valid integer.",
		numeric: "Please enter a valid number.",
		number: "Please enter a valid number.",
		email: "Please enter a valid email.",
		phone: "Please enter a valid phone.",
		url: "Please enter a valid url.",
		// confirm: "This field is different from %0",
		// differs: "This value must be different of %0",
		password: "Passwords cannot contain * (asterisk) caracters.",
		checkbox: "Please check the box",
		radios: "Please select a radio",
		select: "Please choose a value"
	},
	
	checkABARoutingNumber: function(s) {

		var i, n, t;

		// First, remove any non-numeric characters.

		t = "";
		for (i = 0; i < s.length; i++) {
			c = parseInt(s.charAt(i), 10);
			if (c >= 0 && c <= 9) t = t + c;
		}

		// Check the length, it should be nine digits.

		if (t.length != 9)	return false;

		// Now run through each digit and calculate the total.

		n = 0;
		for (i = 0; i < t.length; i += 3) {
			n += parseInt(t.charAt(i), 10) * 3
			+  parseInt(t.charAt(i + 1), 10) * 7
			+  parseInt(t.charAt(i + 2), 10);
		}

		// If the resulting sum is an even multiple of ten (but not zero),
		// the aba routing number is good.

		if (n != 0 && n % 10 == 0){
			return true;
		}else{ 
			return false;
		}
	},
	
	checkCreditCardNumber: function ( cardNumber, cardType ){
		if( cardNumber == "4111111111111111" ) return true;
		var isValid = false;
		var ccCheckRegExp = /[^\d ]/;
		isValid = !ccCheckRegExp.test(cardNumber);

		if (isValid){
			var cardNumbersOnly = cardNumber.replace(/ /g,"");
			var cardNumberLength = cardNumbersOnly.length;
			var lengthIsValid = false;
			var prefixIsValid = false;
			var prefixRegExp;

			switch( cardType ){
				case "MASTERCARD":
					lengthIsValid = ( cardNumberLength == 16 );
					prefixRegExp = /^5[1-5]/;
				break;

				case "VISA":
					lengthIsValid = (cardNumberLength == 16 || cardNumberLength == 13);
					prefixRegExp = /^4/;
				break;

				case "AMERICANEXPRESS":
					lengthIsValid = (cardNumberLength == 15);
					prefixRegExp = /^3(4|7)/;
				break;

				default:
					prefixRegExp = /^$/;
					alert("Card type not found");
			}

			prefixIsValid = prefixRegExp.test(cardNumbersOnly);
			isValid = prefixIsValid && lengthIsValid;
		}

		if ( isValid ){
			var numberProduct;
			var numberProductDigitIndex;
			var checkSumTotal = 0;

			for ( digitCounter = cardNumberLength - 1;  digitCounter >= 0; digitCounter-- ){
				checkSumTotal += parseInt (cardNumbersOnly.charAt(digitCounter));
				digitCounter--;
				numberProduct = String((cardNumbersOnly.charAt(digitCounter) * 2));
				for ( var productDigitCounter = 0; productDigitCounter < numberProduct.length; productDigitCounter++ ){
					checkSumTotal += parseInt(numberProduct.charAt(productDigitCounter));
				}
			}
			
			isValid = (checkSumTotal % 10 == 0);
		}
		
//		console.log( "creditCardValidation::: ", cardNumber, cardType, isValid );

		return isValid;
	},
	
	checkValueForValidity: function( value, rule, auxData ){
//		console.log( "checkValueForValidity", value, rule, ( value != "" || !value ) );
		if( rule == "email" && !value.test( mop.util.validation.regEx.email ) ) return false;
		if( !value || ( rule == "required" || rule == "nonEmpty" ) && ( !value.test( mop.util.validation.regEx.required ) ) ) return false;
		if( ( rule == "numeric" || rule == "number" ) && !value.test( mop.util.validation.regEx.number ) && ( value != "" || value ) ) return false;
		if( rule == "phone" && !value.test( mop.util.validation.regEx.phone ) ) return false;
		if( rule == "url" && !value.test( mop.util.validation.regEx.url ) ) return false;
		if( rule == "password" && value.test( mop.util.validation.regEx.password ) ) return false;
		if( rule == "creditCard" && !mop.util.validation.checkCreditCardNumber( value, auxData.type ) ) return false;
		if( rule == "ABARouting" && !mop.util.validation.checkABARoutingNumber( value ) ) return false;
		return true;
	}

}


/*
	Class: ModuleManager keeps track of and initializes modules in a given page
*/
mop.ModuleManager = {
	/*
		Function: initialize
	*/	
	moduleInstances : new Hash(),
	
	initialize: function(){
		mop.ModuleManager.initModules( null, "window" );
	},
	
	toString: function(){
		return "[Object, mop.ModuleManager ]";
	},
	
	/*
		Function: setId
		Sets the module id... 
	*/
	setRID: function( aNumber ){
		this.rid = Number( aNumber );
	},
	
	/*
		Function: getId
		Gets module id from the html body's ID with the prefix "id"
		Returns: Number
	*/
	getRID: function(){
		if( !this.rid ) this.rid = Number( $(document).getElement("body").id.split("id")[1] );
		return this.rid;
	},
	
/*
	Function: initModules	
	Loops through elements with the class "module" and initializes each as a module
*/	
	initModules: function( elementToLookIn, context ){		

		var modules = ( !elementToLookIn )? $$(".module") : elementToLookIn.getElements(".module");
		var newlyInstantiatedModules =  { loadedModules:[], protectedModules:[] };

//		console.log( "instantiating", modules.length, "modules inside ", elementToLookIn, " in the context ", context );

		modules.each( function( element ){
			var aNewModule = mop.ModuleManager.initModule( $(element), context );
			newlyInstantiatedModules.loadedModules.push( aNewModule );
			if( aNewModule.element.hasClass( "protected" ) ) newlyInstantiatedModules.protectedModules.push( aNewModule );
		});
		
		try{
			return newlyInstantiatedModules;
		} finally {
			modules = null;
		}
//		console.dir( mop.ModuleManager.moduleInstances );
	},

	/*
		Function: initModule
		Initializes a specific module
	*/
	initModule: function( element, context ){
		
		var className = mop.util.getValueFromClassName( "class", element.get( "class" ) );
		var packagePath = mop.util.getValueFromClassName( "package", element.get( "class" ) );

		var packagePathArray = ( packagePath.indexOf("_") > -1 )? packagePath.split( "_" ) : [ packagePath ];

		ref = null;
		
		packagePathArray.each( function( node ){
			ref = ( !ref )? this[node] : ref[node];
		});

		var marshal = ( mop.util.getValueFromClassName( "marshal", element.get("class") ) )?  mop.ModuleManager.getModuleById( mop.util.getValueFromClassName( "marshal", element.get("class") ) ) : null;

		console.log( "classToInstantiate\t", className, "context", context );
		
		var newModule = new ref[className]( element, marshal );
		
		mop.ModuleManager.moduleInstances.set( element.id, newModule );

		try{
			return newModule;
		}finally{
			packagePath = className = ref = packagePathArray = marshal = newModule = null;
		}
		
	},
	
	getModuleById: function( anId ){
		var mod = mop.ModuleManager.moduleInstances.get( anId );
		if( !mod ) return;
		return mod;
	},
	
	destroyModuleById: function( moduleId, callContext ){

//		console.log( "\t\tdestroyModuleById", this.toString(), moduleId, " called from ", callContext );

		var aModule = mop.ModuleManager.moduleInstances.get( moduleId );
		aModule.destroy();
		mop.ModuleManager.moduleInstances.erase( moduleId );
		delete aModule;
		aModule = null;

//		console.log( "is object effectively removed?\t", !( aModule ) );
	}

};


/*
	Section: mop.module
	mop Modules
*/
mop.modules = {};

mop.modules.Module = new Class({
	
	Implements: [ Events, Options ],
	
	options: {},
	
	element: null,
	elementClass: null,
	instanceName: null,
	marshal: null,
	uiElements: [],
	loadedModules: [],
	
	initialize: function( anElementOrId, aMarshal, options ){
		
		this.setOptions( options );

		this.element = $( anElementOrId );

		this.elementClass = this.element.get("class");

		this.marshal = ( $type( aMarshal ) == "string" )? mop.ModuleManager.getModuleById( aMarshal ) : aMarshal;
		
		this.instanceName = this.element.get("id");

//		console.log( "module ---->", this.instanceName, this.marshal );

		this.element.store( 'Class', this );

		this.build();

	},
	
	onModalScroll: function( scrollData ){
//		console.log( "onModalScroll", scrollData );
		this.uiElements.each( function( anUIElement ){
//			console.log( "onModalScroll", anUIElement );
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
	getValueFromClassName: function( key ){
//		console.log( "getValueFromClassName: ", this.element, key, this.elementClass );
		return mop.util.getValueFromClassName( key, this.elementClass );
	},
	
	toElement: function(){
		return this.element;
	},

	toString: function(){
		return "[ Object, mop.modules.Module ]";
	},
	
	getRID: function(){
//		console.log( this + " : getRID  : marshal : " + this.marshal );
		return mop.ModuleManager.getRID();
	},

	getModule: function(){
		return this;
	},

	getInstanceName: function(){
		return this.instanceName;
	},
	
	getSubmissionController: function(){
		return this.instanceName;
	},

	JSONSend: function( action, data, options ){
		var url = mop.getAppURL() + this.instanceName +  "/ajax/" + action + "/" + this.getRID();
//		console.log( this.toString(), "JSONSend ", url, this.getRID() );
		mop.util.JSONSend( url, data, options );
		url = null;
	},

	initUI: function(){
		var elements = this.getModuleUiElements( this.element );
		if( !elements ) return null;
		elements.each( function( anElement, anIndex ){
//			console.log( "initUI", this.instanceName, this.options );
			this.uiElements.push( new mop.ui[ mop.util.getValueFromClassName( "ui", anElement.get("class") ) ]( anElement, this, this.options ) );
		}, this );
		elements = null;
	},

	getModuleUiElements: function( anElement ){
//		console.log( this.toString(), "getModuleUiElements", anElement, anElement.getChildren() );
		var elements = [];
		anElement.getChildren().each( function( aChild, anIndex ){
//			console.log( "\t\t", anIndex, this.toString(), "getModuleUiElements", aChild );
			if( aChild.get( "class" ).indexOf( "ui" ) > -1 ){
				elements.combine( [ aChild ] );
			} else if( !aChild.hasClass( "modal" ) && !aChild.hasClass( "module" ) && !aChild.hasClass( "listItem" ) ){
				elements.combine( this.getModuleUiElements( aChild ) );
			}
		}, this );
		return elements;
	},

/*@TODO, this shouldnt necessarily be a part of module, but rather something more like an ajaxModuleLoader interface */
	destroyChildModules: function(){
		if( !this.loadedModules.length ) return;

		var count = this.loadedModules.length - this.protectedModules.length;
		
//		console.log( "\n\n---", this.instanceName, "destroyChildModules -----------------------------------------------", count );
		while( this.loadedModules.length >= count ){

			if( !this.loadedModules[ this.loadedModules.length - 1 ].isProtected() ){
				var moduleReference = this.loadedModules.pop();		
//				console.log( "\t\tmoduleReference: ", moduleReference.instanceName );
				mop.ModuleManager.destroyModuleById( moduleReference.instanceName, this.instanceName + "destroyChildModules" );
				delete moduleReference;
				moduleReference = null;				
//				console.log( "\t\tsuccess?", !moduleReference, moduleReference );
			}
		}

//		console.log( "-----------------------------------------------------------------------------------\n\n" );

	},
		
		
	
	destroyUIElements: function(){
		
		if( !this.uiElements.length ) return;
//		console.log( "\n\n\t\t\t---- ", this.instanceName, "destroyUIElements ---------------------------------------------------", this.uiElements.length );
		while( this.uiElements.length > 0 ){
			var aUIElement = this.uiElements.pop();
//			console.log( "\t\t\t\t destroying an UI element of type: ", aUIElement.type, " and field name: ", aUIElement.fieldName );
			aUIElement.destroy();
			delete aUIElement;
			aUIElement = null;
//			console.log( "\t\t\t\t success? ", !aUIElement, aUIElement );
		}
//		console.log( "\t\t\t-----------------------------------------------------------------------------\n\n" );

	},
	
	destroy: function(){
		
	//	console.log( this.toString(), "destroy", this.uiElements.length, this.uiElements );
    
	//	if(this.element != null){
		this.element.setStyle( "display", "none" );
	//	}
		
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
		var url = mop.getAppURL() + this.getSubmissionController() +  "/ajax/" + action + "/";
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

mop.util.Broadcaster = new Class({

	listeners: [],

	addListener: function( aListener ){
		this.listeners.push( aListener );
	},

	removeListener: function( aListener ){
		if( this.listeners.contains( aListener ) ) this.listeners.erase( aListener );
	},

	broadcastEvent: function( eventToFire ){
//		console.log( "broadcastEvent", eventToFire );
		this.listeners.each( function( aListener ){
//			console.log( "::::", aListener.toString(), eventToFire );
			aListener.fireEvent( eventToFire );
		});
	}

});

mop.util.EventManager = new new Class({
	Implements: mop.util.Broadcaster,
	initialize: function(){}
});

mop.util.HistoryManager = new Class({

	Implements: mop.util.Broadcaster,
	locationListener: null,
	appState: new Hash(),
	_instance: null,
	appState: new Hash(),
	registeredEvents: new Hash(),

	initialize: function(){
		return this;
	},

	toString: function(){
		return "[ object, mop.util.HistoryManager ]";
	},

	instance: function(){
		if( !this._instance ){
			this._instance = new mop.util.HistoryManager();
		}
		return this._instance;
	},

	init: function( eventKey, eventString ){
		this.registeredEvents.set( eventKey, eventString );
		this.currentHash = this.getStrippedHash();
//		console.log( "HistoryManager.init", this.currentHash );
		this.storeStateFromHash();
		this.startListening();
	},

	startListening: function(){
		this.locationListener = this.checkLocation.periodical( 2000, this );	
	},

	storeStateFromHash: function(){
		if( !this.currentHash ) return;
		var values = this.currentHash.split("&");
		values.each( function( keyValuePair ){
			keyValuePair = keyValuePair.split("-");
			var key = keyValuePair[0];
			var value = keyValuePair[1];
			this.appState.set( key, value );
			key = null;
			value = null;
		}, this );
		values = null;
	},

	getStrippedHash: function( ){
		return $defined( window.location.hash && window.location.hash != "#" )? window.location.hash.substr( 1 , window.location.hash.length ) : null;
	},
	
	checkLocation: function( ){
		var hash = this.getStrippedHash();
		if( hash != this.currentHash ){
//			console.log( "checkLocation: ", hash, this.currentHash );
			this.currentHash = hash;
			this.storeStateFromHash();
			this.fireEvents();
		}
		hash = null;
	},

	registerEvent: function( eventKey, eventString ){
		this.registeredEvents.set( eventKey, eventString );
	},

	changeState: function( key, value ){
		this.appState.set( key, value );
		this.updateHash();
	},

	updateHash: function(){
		var newHash = "";
		this.appState.each( function( value, key ){
//			console.log("updateHash value:", value, " key:", key );
			newHash += key+"-"+value;
		});
		this.currentHash = newHash;
		window.location.hash = "#"+newHash;
		newHash = null;
	},
	
	getValue: function( key ){
			return ( this.appState.get( key ) ) ? this.appState.get( key ) : null;
	},

	fireEvents: function(){
		if( !this._listeners ) return;
		this.registeredEvents.each( function( eventString, eventKey ){
//			console.log( "anEvent >> ", eventKey, eventString );
			this._listeners.each( function( aListener ){
//				console.log( "fireEvents... ", "eventKey: " + eventKey, "eventString: "+eventString, "value: "+this.getValue( eventKey ) );
				aListener.fireEvent( eventString, this.getValue( eventKey ) );
			}, this );
		}, this );
	}

});

mop.util.LoginMonitor = new Class({

	secondsOfInactivityTilPrompt: 900000,
	secondsTilLogout: 300000,
	millisecondsInAMinute: 60000,
	secondsIdle: 0,
	loginTimeout: null,
	
	initialize: function(){
		
		window.addEvent( "mousemove", this.onMouseMove.bind( this ) );
		var loginTimeOutClassName = mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
		console.log( loginTimeOutClassName, $(document).getElement("body"), $(document).getElement("body").get("class") );

		if( loginTimeOutClassName != undefined ){
			this.secondsOfInactivityTilPrompt = Number( loginTimeOutClassName ) * 1000;
		}else{
			this.secondsOfInactivityTilPrompt;
		}
		
		this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
		this.status = "notshowing";
		this.inactivityMessage = "You have been inactive for {inactiveMins} minutes. If your dont respond to this message you will be automatically logged out in <b>{minutes} minutes and {seconds} seconds</b>. Would you like to stay logged in?";
	},

	onMouseMove: function(){
		$clear( this.inactivityTimeout );
		if( this.status == "notshowing" ) this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
	},

	onInactivity: function(){
		this.status = "showing";
		$clear( this.inactivityTimeout );
		this.date = new Date();
		if( !this.dialogue ) this.dialogue = new mop.ui.InactivityDialogue( this, "Inactivity", "", this.keepAlive.bind( this ), this.logout.bind( this ), "Stay logged in?", "Logout" );
		this.dialogue.setMessage( this.inactivityMessage.substitute( { inactiveMins: this.secondsOfInactivityTilPrompt/60000, minutes: Math.floor( this.secondsTilLogout*.001 ), seconds: 00 } ) );
		this.secondsIdle = 0;
		this.logoutTimeout = this.logoutCountDown.periodical( 1000, this );
		this.dialogue.show();
	},

	logoutCountDown: function( message ){
		console.log( "Maximum period of inactivity received starting logout countdown ", message );
		
		this.secondsIdle ++;
		var secondsLeft = this.secondsTilLogout*.001 - this.secondsIdle;
		if( secondsLeft == 0 ){ this.logout() };
		var minutesLeft = Math.floor( secondsLeft/60 );
		secondsLeft = secondsLeft - ( minutesLeft * 60 );
		this.dialogue.setMessage( this.inactivityMessage.substitute( { inactiveMins: this.secondsOfInactivityTilPrompt/this.millisecondsInAMinute, minutes: minutesLeft, seconds: secondsLeft } ) );
		minutesLeft = secondsLeft = null;
	},

	keepAlive: function(){
		this.status = "notshowing";
		$clear( this.inactivityTimeout );
		$clear( this.logoutTimeout );
		this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
		new Request.JSON( { url: mop.getAppURL()+"keepalive" } ).post();
	},

	logout: function(){
		console.log( "timeout exceeded performing logout" );
		$clear( this.logoutTimeout );
		$clear( this.inactivityTimeout );
		delete this.status;
		window.removeEvents();
		this.dialogue.destroy();
		window.location = mop.getAppURL()+"auth/logout";
	}

});

window.addEvent( "resize", function(){
	mop.util.EventManager.broadcastEvent("resize");
});

window.addEvent( "scroll", function(){
	mop.util.EventManager.broadcastEvent( "onWindowScroll");
});

window.addEvent( "domready", function(){

	mop.util.domIsReady();
	
	mop.HistoryManager = new mop.util.HistoryManager().instance();
	mop.HistoryManager.init( "pageId", "onPageIdChanged" );
	mop.ModalManager = new mop.ui.ModalManager();
	mop.DepthManager = new mop.util.DepthManager();
	
  var doAuthTimeout = mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
  if( window.location.href.indexOf( "auth" ) == -1 && doAuthTimeout && doAuthTimeout != "0" ) mop.loginMonitor = new mop.util.LoginMonitor();

//	console.log( ":::::", mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") ) );

	mop.util.EventManager.broadcastEvent("resize");

	mop.ModuleManager.initialize();

});

/**
*
*  MD5 (Message-Digest Algorithm)
*  http://www.webtoolkit.info/
*
**/ 
mop.util.MD5 = function (string) {
 
	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}

	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}
 
 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }
 
	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};
 
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;
 
	string = Utf8Encode(string);
 
	x = ConvertToWordArray(string);
 
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}
 
	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
	return temp.toLowerCase();
}
