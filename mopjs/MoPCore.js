// Section: Setting up environment for MoPCore.

//	Redirects ie 6 to a landing page for that browser
if( Browser.ie && Browser.version < 8 ) window.location.href = $(document).getElement("head").getElement("base").get("href") + "msielanding";

/*
Quick hack to prevent browsers w/o a console, or firebug from generating errors when console functions are called.
Builds an empty console object with proper members if none is present.
*/
var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
if (!window.console ){ window.console = {};
    for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
}

/*
	Section: Extending Mootools
*/

/*
Class: Interfaces
description: Interfaces provides some Interface functionality to Class (and also provides an Interface Object)
license: MIT-style
authors: Sebastian Wohlrab
requires: core/1.2.4: '*'
provides: [Class.Interfaces]
...
*/

Class.Mutators.Interfaces = function( interfaces ) {
	this.implement('initialize', function(){});
	return interfaces;
};

Class.Mutators.initialize = function( initialize ) {
	return function() {
	    Array.from( this.Interfaces ).each( function( implemented ) {
			implemented.Interface.Check( this );
		}, this );
		return initialize.apply( this, arguments );
	}
}
var Interface = function( name, members ) {
	members.Interface = {
		Name: name,
		Check: function( obj ) {
			var error = [];
			for ( p in members ) {
				switch( p ) {
					case "Interface": /* reservated */ break;
					case "Interfaces":
						var existing = false;
						$splat(members[p]).each(function(iNeeded) {
							$splat(obj[p]).each(function(iExisting) {
								if ( iNeeded.Interface.Name == iExisting.Interface.Name) existing = true;
							});
						});
						if ( !existing ) {
							error.push( p );
						}
					break;
					default:
						if ( !(p in obj) ) {
							error.push( p );
						}
					break;
				}
			}
			if ( error.length > 0 ) {
				throw new Error( "[" + this.Name + "] The following Interface members are not implemented yet: " + error.join(', ') );
			}
		}
	};
	return members;
};

/*
	Function: String.toElement
	returns a dom element from a string
*/
String.implement({ 
	toElement: function() { 
		return new Element('div', { html:this } ).getFirst(); 
	} 
});

Element.implement({
	/*
		Function: getSiblings
		Arguments:
			match - {Element} an element to get the sibling
			nocache - {Boolean} 

	*/
   getSiblings: function(match,nocache) {
		return this.getParent().getChildren(match,nocache).erase(this);
	},
	/*
		Function: getSibling
		Arguments:
			match - {Element} an element to get the sibling
			nocache - {Boolean} 
		Note: calls getSiblings, returns first element of collection
	*/
	getSibling: function(match,nocache) {
		return this.getSiblings(match,nocache)[0];
   },
	/*
		Function: getOptionsFromClassName
		Loops through a classes className, splits it by 
	*/
	getOptionsFromClassName: function(){
		if(!this.get("class")) return false;
		var classes = this.get('class').split(" ");
		var opts = {};
		classes.each( function( className ){
			if( className.indexOf( "-" ) > -1 ){
				var opt = className.split("-");
				opts[ opt[0] ] = opt[1];
			}
		});
		return opts;
	},
	
	/*
		Function: isBody
		Paramaters: 
			element - {Element}
	*/
	isBody: function(element){
		return (/^(?:body|html)$/i).test(element.tagName);
	},

	getValueFromClassName: function( key ){
		if(!this.get("class")) return false;
		var classes = this.get("class").split(" ");
		var result;
		classes.each( function( className ){
		  if( className.indexOf( key ) == 0 ) result = className.split("-")[1];
		});
		return result;
	}

});

/*
	Function: Function.bindWithEvent
	Implements the now deprecated bindWithEvent
 	Parameters:
 		bind - {obj} a scope for the closure (what's "this")
	    args: Single argument, or an array
*/

Function.implement({ 
    bindWithEvent: function(bind, args){ 
        var self = this; 
        if (args != null) args = Array.from(args); 
        return function(event){ 
            return self.apply(bind, (args == null) ? arguments : [event].concat(args));
        }
    }
});
 
/*
	Function: String.encodeUTF8
	Implements encodeUTF8 into mootools' native String class
 	Parameters:
 		s - {String} a string
	Returns: {String} argumemt string as UTF-8 string
*/
String.implement( "encodeUTF8", function(){
  return unescape( encodeURIComponent( this ) );
});


/*
	Function: Request.JSON.success override
	Better error reporting for MOPCMS specific error reporting
*/
Request.JSON.implement({
    success: function(text){
		var json;
		try {
			json = this.response.json = JSON.decode( text, this.options.secure );
		} catch ( error ){
			this.fireEvent('error', [text, error]);
			return;
		}
		if ( json == null ){ 
		    this.onFailure();
	    }else if( !json.returnValue ){
	        throw json.response;
	    } else {
            this.onSuccess( json, text );
	    }
	}
});

    
/*
	Section: MoP Package
	Mop is a namespace, quick definition of namespace, more useful for documentation than anything else.
*/
if( !mop ) var mop = {};

/*
	Pakcage: mop.util
*/
mop.util = {};

/* Variable: mop._domIsReady read only */
mop._domIsReady = false;


/*
 	Function: mop.util.isDomReady 
	Simple getter
	Returns: mop._domIsReady
*/
mop.util.hasDOMReadyFired = function(){
	return mop._domIsReady;
}

/*
	Function: mop.util.domIsReady
	So a module can know if an initial domready has been called
	This is key to having modules not call domready if they are loaded from within another module, but still able to self-instantiate is loaded alone)
	Set mop._domIsReady to true
*/
mop.util.DOMReadyHasFired = function(){
	mop._domIsReady = true;
}


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
}

/*
	Function: mop.util.loadJS
	Attach a javascript element to head element via DOM
 	Arguments:
		jsURL - {String} path to the script element to be attached
*/
mop.util.loadJS = function( jsURL, options ){
    console.log( "loadJS", jsURL)
	return new Asset.javascript( jsURL, options );
}

/*
 	Function: mop.util.stopEvent 
	Stops event bubbling, normally this is handled in each instance
	But this will serve as a nice shortcut given the verbosity needed to deal with some IE's ( the whole return value conditional )
*/
mop.util.stopEvent = function( e ){
	if( e && e.stop ){
		e.stop();
	}else if( e ){
		e.returnValue = false;
	}
}

/*
 	Function: mop.util.preventDefault 
	Prevents default actions on click events, similart to stopEvent... see mootools documentation for distinction
	This will serve as a nice shortcut given the verbosity needed to deal with IE's ( the whole return value conditional )
*/
mop.util.preventDefault = function( e ){
	if( e && e.preventDefault ){
		e.preventDefault();
	}else if( e ){
		e.returnValue = false;
	}	
}

/*
 	Function: mop.util.setBaseURL 
	Returns: sets mop.baseURL for later use
*/
mop.util.setBaseURL = function( base ){
    mop.baseURL = base;
}

/*
 	Function: mop.util.getBaseURL 
	Returns: href from html base tag
*/
mop.util.getBaseURL = function(){
	return ( mop.baseURL )? mop.baseURL : "/";
}

/* Function: mop.util.getValueFromClassName
	Arguments: key {String}, aClassName {String} (space delimeted)
	Returns: {String} value
*/
mop.util.getValueFromClassName = function( key, aClassName ){
	if(!aClassName) return false;
	var classNames = aClassName.split( " " );
	var result = null;
	classNames.each( function( className ){
		if( className.indexOf( key ) == 0 ) result = className.split("-")[1];
	});
	return result;
}


/*
	Package: mop.util.validation
	Static class to hold validation regex and functions
	Note: (Capitalize)
*/
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

mop.MoPObject = new Class({
	Implements: [ Events, Options ],
	/*
		Variable: element
		html element for this class
	*/
	element: null,
	/*
		Variable: elementClass
		Convenience variable getting the className from the element
	*/
	elementClass: null,
	/*
		Variable: marshal
		This instance's delegate, ie. the object the next level up between this instance and the root controller.
	*/
	marshal: null,
	/*
		Function: initialize
		Constructor
	*/
	initialize: function( anElementOrId, aMarshal, options ){
		this.element = $( anElementOrId );
		this.elementClass = this.element.get("class");
		this.setOptions( options );
		this.options = Object.merge( this.options, this.element.getOptionsFromClassName() );
		this.marshal = aMarshal;
		this.element.store( 'Class', this );
	},	
	
	getElement: function(){
	    return this.element;
	},
	
	destroy: function(){
		console.log( '\t', this.toString() );
		this.element.destroy();
		this.element.eliminate( "Class" );
		this.options = this.element = this.elementClass = this.marshal = null 
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

	broadcastMessage: function( eventToFire, args ){
		if( typeof args == 'array' ){
			args = args.slice(1);
		}
		var response = Array.from( arguments )[1];
		this.listeners.each( function( aListener ){
				aListener.fireEvent( eventToFire, response );
		});
	}
	
});

mop.util.EventManager = new new Class({
	Implements: mop.util.Broadcaster,
	initialize: function(){}
});

mop.util.DepthManager = new Class({

	Extends: mop.util.Broadcaster,

	windowOverlayDepth: 5000,
	modalDepth:         15000,
	modalOverlayDepth:  20000, 

	initialize: function(){},
	
	incrementDepth: function( context ){
			return this.modalOverlayDepth++;
	},
	
	getCurrentDepth: function( context ){
	    return this.modalOverlayDepth;
	}
	
});

mop.util.HistoryManager = new Class({

	Implements: [ Events, mop.util.Broadcaster ],
	locationMonitor: null,
	appState: new Hash(),
	_instance: null,

	getStrippedHash: function(){
		return ( window.location.hash && window.location.hash != "#" )? window.location.hash.substr( 1 , window.location.hash.length ) : null;
	},
	
	getAppState: function(){
		return this.appState;
	},

	setAppState: function(){
		if( !this.currentHash ) return;
		this.appState.empty();
		this.appState.combine( this.getStrippedHash().parseQueryString() );
	},
	
	
	initialize: function(){
		return this;
	},

	toString: function(){
		return "[ Object, mop.util.HistoryManager ]";
	},

	instance: function(){
		if( !this._instance ){ this._instance = new mop.util.HistoryManager(); }
		return this._instance;
	},

	init: function(){
		this.currentHash = this.getStrippedHash();
		this.setAppState();
		this.locationMonitor = this.checkLocation.periodical( 2000, this );	
	},

	checkLocation: function(){
		var hash = this.getStrippedHash();
		if( hash != this.currentHash ){
			this.currentHash = hash;
			this.setAppState();
			this.broadcastMessage( "appstatechanged", this.appState );
		}
		hash = null;
	},

	changeState: function( key, value ){
		this.appState.set( key, value );
		this.updateHash();
	},

	updateHash: function(){
		var newHash = "";
		this.appState.each( function( value, key ){
			newHash += (newHash=="")? key + "=" +  value : "&" + key + "=" + value;
		});
		this.currentHash = newHash;
		window.location.hash = "#"+newHash;
		newHash = null;
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
		if( loginTimeOutClassName != undefined ){
			this.secondsOfInactivityTilPrompt = Number( loginTimeOutClassName ) * 1000;
		}
		
		this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
		this.status = "notshowing";
		this.inactivityMessage = "You have been inactive for {inactiveMins} minutes. If your dont respond to this message you will be automatically logged out in <b>{minutes} minutes and {seconds} seconds</b>. Would you like to stay logged in?";
	},

	onMouseMove: function(){
		clearInterval( this.inactivityTimeout );
		if( this.status == "notshowing" ) this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
	},

	onInactivity: function(){
		this.status = "showing";
		clearInterval( this.inactivityTimeout );
		this.date = new Date();
		if( !this.dialogue ) this.dialogue = new mop.ui.InactivityDialogue( this, "Inactivity", "", this.keepAlive.bind( this ), this.logout.bind( this ), "Stay logged in?", "Logout" );
		this.dialogue.setContent( this.inactivityMessage.substitute( { inactiveMins: this.secondsOfInactivityTilPrompt/this.millisecondsInAMinute, minutes: Math.floor( this.secondsTilLogout*.001 ), seconds: 00 } ) );
		this.secondsIdle = 0;
		this.logoutTimeout = this.logoutCountDown.periodical( 1000, this );
		this.dialogue.show();
	},

	logoutCountDown: function( message ){
//		console.log( "Maximum period of inactivity received starting logout countdown ", message );
		
		this.secondsIdle ++;
		var secondsLeft = this.secondsTilLogout*.001 - this.secondsIdle;
		if( secondsLeft == 0 ){ this.logout() }
		var minutesLeft = Math.floor( secondsLeft/60 );
		secondsLeft = secondsLeft - ( minutesLeft * 60 );
		this.dialogue.setContent( this.inactivityMessage.substitute( { inactiveMins: this.secondsOfInactivityTilPrompt/this.millisecondsInAMinute, minutes: minutesLeft, seconds: secondsLeft } ) );
		minutesLeft = secondsLeft = null;
	},

	keepAlive: function(){
		this.status = "notshowing";
		clearInterval( this.inactivityTimeout );
		clearInterval( this.logoutTimeout );
		this.inactivityTimeout = this.onInactivity.periodical( this.secondsOfInactivityTilPrompt, this );
		new Request.JSON( { url: mop.util.getBaseURL() + "keepalive" } ).send();
	},

	logout: function(){
//		console.log( "timeout exceeded performing logout" );
		clearInterval( this.logoutTimeout );
		clearInterval( this.inactivityTimeout );
		delete this.status;
		window.removeEvents();
		this.dialogue.destroy();
		window.location = "auth/logout".toURI().toAbsolute();
	}

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
	}
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	}
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	}
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	}
 
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
	}
        
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	}
 
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
	}
 
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

/* These should be configurable, also are they more App level stuff instead of mopcore? */
window.addEvent( "resize", function(){
	mop.util.EventManager.broadcastMessage( "resize" );
});

window.addEvent( "scroll", function(){
	mop.util.EventManager.broadcastMessage( "onWindowScroll");
});
