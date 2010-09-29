mop.ui = {};
mop.ui.navigation = {};

mop.ui.DepthManager = new Class({

	Extends: mop.util.Broadcaster,

	modalDepth: 15000,
	windowOverlayDepth: 10000,
	modalOverlayDepth: 20000, 

	initialize: function(){},
	
	incrementDepth: function( context ){
		switch( context ){
			case "modal" : return this.modalDepth++; break;
			case "modalOverlay" : return this.modalOverlayDepth++; break;
			case "windowOverlay" : return this.windowOverlayDepth++; break;
		}
	},
	
	getCurrentDepth: function( context ){
		switch( context ){
			case "modal": return this.modalDepth; break;
			case "modalOverlay": return this.modalOverlayDepth; break;
			case "windowOverlay": return this.windowOverlayDepth; break;
		}
	}
	
});

/*
	Class: mop.ui.navigation.Tabs
	Generic helper for handling tabbed navigation
	Simply takes an collection of elements with the passed selector from the passed element, and returns a reference of the clicked element to the callback function.
	More generic than tabs for sure, but what to call? Buton collection?
*/
mop.ui.navigation.Tabs = new Class({
	
	type: "tabbedNavigation",
	
	toString: function(){
		return "[ object, mop.ui.navigation.Tabs ]";
	},
	
	initialize: function( anElement, aSelector, callback ){
		this.tabs = anElement.getElements( aSelector );
		this.callback = callback;
		this.tabs.each( this.applyTabBehavior.bind( this ) );
	},
	
	applyTabBehavior: function( aTab, anIndex ){
//		console.log( this, "applyTabBehavior", aTab, anIndex );
		aTab.addEvent( "click", this.onTabClicked.bindWithEvent( this, aTab ) );
		if( aTab.hasClass( "active" ) ){
			// this.activeTab = aTab;
			this.onTabClicked( null, aTab );
		}
	},
	
	onTabClicked: function( e, aTab ){
		mop.util.stopEvent( e );
		if( this.activeTab && this.activeTab == aTab ) return;
		if( this.activeTab ) this.activeTab.removeClass( "active" );
		aTab.addClass( "active" );
		this.activeTab = aTab;
		this.callback( aTab );
	},
	
	destroy: function(){
		this.tabs = this.callback = null;
	}

});

/*
	Class: mop.ui.navigation.BreadCrumbTrail
	Generic class for handling breadcrumb trails
*/
mop.ui.navigation.BreadCrumbTrail = new Class({
	
	className: "BreadCrumbTrail",
	
	initialize: function( anElement, onBreadCrumbClickedCallback ){
		this.onBreadCrumbClickedCallback = onBreadCrumbClickedCallback;
		this.list = new Element( "ul", { "class": "breadCrumb" } );
		var clear = new Element( "li", { "class": "clear" } );
		clear.inject( this.list );
		this.list.inject( anElement );
	},
	
	toString: function(){
		return "[ object, mop.ui.BreadCrumbTrail ]";
	},

	clearCrumbs: function( anIndex ){
		var crumb = this.list.getChildren( "li:not(.clear)" )[ anIndex ];
		if( crumb ){
			subsequentCrumbs = crumb.getAllNext();
			crumb.destroy();
			subsequentCrumbs.each( function( aCrumb ){ if( !aCrumb.hasClass("clear") ) aCrumb.destroy(); } );
		}
	},

	addCrumb: function( obj ){

		var crumb = new Element( "a", {
			"text": obj.label,
			"events":{
				"click": this.onBreadCrumbClicked.bindWithEvent( this, obj )
			}
		});

		var listItem = new Element( "li" );

		crumb.inject( listItem );

		if( this.list.getChildren("li:not(.clear)")[ obj.index ] ){

			listItem.replaces( this.list.getChildren("li:not(.clear)")[ obj.index ] );
		
		}else{
		
			var breadCrumbsClear = this.list.getElement(".clear");
			listItem.inject( breadCrumbsClear, "before" );
			breadCrumbsClear = null;

		}

	},
	
	onBreadCrumbClicked: function( e, obj ){
		mop.util.stopEvent();
//		console.log( this.toString(), "onBreadCrumbClicked", obj );
		this.onBreadCrumbClickedCallback( obj );
	},
	
	removeBreadCrumb: function( anIndex ){
		var crumb = this.list.getChildren( "li:not(.clear)" )[ anIndex ];
		crumb.destroy();
	},
	
	destroy: function(){
		this.list = null;
		onBreadCrumbClickedCallback = null;
	}

});


mop.ui.ModalManager = new Class({
	
	Extends: mop.util.Broadcaster,
	modals: [],
	activeModal: null,
	
	initialize: function(){},
	
	addListener: function( aListener ){
//		console.log( this.toString(), "addListener", aListener );
		this.parent( aListener );
	},
	
	toString: function(){
		return '[ object, mop.util.EventManager, mop.ui.ModalManager ]';
	},
	
	removeListener: function( aListener ){
		aListener.removeEvent( "scroll" );
		this.parent( aListener );
	},
	
	setActiveModal: function( aModal ){
		this.modals.push( aModal );
		if( this.activeModal ) this.activeModal.element.removeEvent( "scroll" );
		this.activeModal = aModal;
		this.modals.push( this.activeModal );
		$( document ).getElement("body").setStyle( "overflow", "hidden" );
//		console.log( "setActiveModal", aModal, aModal.element );modalmanager
	},

	getActiveModal: function(){
		return this.activeModal;
	},
	
	clearActiveModal: function(){
		this.activeModal = this.getPreviousModal();
	},
	
	onModalScroll: function( aModal ){
//		console.log( "broadcastEvent onModalScroll", aModal, aModal.element.getScroll() );
		this.broadcastEvent( "modalScroll", aModal, aModal.element.getScroll() );
	},
	
	getScroll: function(){
		var returnVal =  ( this.activeModal )? this.activeModal.element.getScroll() : window.getScroll();
//		console.log( this.toString(), "getScroll", returnVal );
		return returnVal;
	},

	removeModal: function( aModal ){

		this.modals.erase( aModal );

		if( this.activeModal == aModal ) this.activeModal = this.getPreviousModal();
		if( !this.activeModal ) $( document ).getElement("body").setStyle( "overflow", "auto" );

		aModal.destroy();		
		delete aModal;
		aModal = null;
	},
	
	getPreviousModal: function(){
		return this.modals[ this.modals.length - 1 ];
	}

});


/*	Class: mop.ui.Sortable
	Simply an extension of the mootools sortable
	adds a marshal reference, and a scroller instance
*/
mop.ui.Sortable = new Class({
	Extends: Sortables,
	initialize: function( anElement, marshal, options ){
		this.parent( anElement, options );
		this.marshal = marshal;
		var opts = {};
		opts.area = options.area;
		opts.velocity = options.velocity;
		this.scroller = new mop.ui.VerticalScroller( options.scrollElement, opts );
		opts = null;
	},
	
	getClone: function(event, element){
		if (!this.options.clone) return new Element('div').inject(document.body);
		if ($type(this.options.clone) == 'function') return this.options.clone.call(this, event, element, this.list );
		return element.clone(false).addClass("listClone").setStyles({
			'margin': '0px',
			'position': 'absolute',
			'opacity': .4,
			'visibility': 'hidden',
			'width': element.getStyle('width'),
			'height': element.getStyle('height')
		}).inject( this.list ).position( element.getPosition() );
	}
	
});

/*	Class: mop.ui.Vertical scroller
	Simply an extension of the mootools Scroller, fixed a bug or two.... 
	might not need this at all, since bug was with Element.getScrolls(), though this is more legible
*/
mop.ui.VerticalScroller = new Class({

	Extends: Scroller,

	options: {
		area: 20,
		velocity: 1,
		onChange: function(x, y){
			this.element.scrollTo( x, y);
		}
	},

	initialize: function(element, options){
		this.parent( element, options );
	},

	getCoords: function(event){
		this.page = (this.listener.get('tag') == 'body') ? event.client : event.page;
		if (!this.timer) this.timer = this.scroll.periodical( 80, this );
	},

	scroll: function(){
		var size = this.element.getSize();
		var scroll = this.element.getScroll();
		var pos = this.element.getCoordinates();
		var change = {'x': 0, 'y': 0};
		if ( this.page.y < ( pos.top + this.options.area ) && scroll.y != 0 ){
			change.y = ( this.page.y - this.options.area - pos.top ) * this.options.velocity;
		}else if( this.page.y > ( size.y + pos.top - this.options.area )  && size.y + size.y != scroll.y ){
			change.y = (this.page.y - size.y + this.options.area - pos.top ) * this.options.velocity;
		}
		if ( change.y || change.x ) this.fireEvent( 'change', [scroll.x + change.x, scroll.y + change.y ] );
	}

});

mop.ui.UIElement = new Class({

	type: "UIElement",

	Implements: [ Options, Events ],
    Extends: mop.MoPObject,

	options:{ action: "savefield" },
	
	onCompleteCallbacks: [],
	
	type: "Generic UIElement",
	
	fieldName: null,
	autoSubmit: true,
	action: null,
	validationOptions: null,
	validationErrors: [],
	validationSticky: null,
	
	onCompleteCallbacks: [],
	onEditCallbacks: [],

	enabled: true,
	clickEvent: null,
	
	requiresValidation: function(){
		return Boolean( this.validationOptions );
	},
	
	// TODO: maybe just create an options object, that loops through all 'key-kalue' pairs in class name... seems like it would remove redundancies....   
	getValueFromClassName: function( key ){
		return mop.util.getValueFromClassName( key, this.element.get( "class" ) );
	},

	registerOnCompleteCallBack: function( func ){
		this.onCompleteCallbacks.push( func );
	},

	registerOnEditCallback: function( func ){
		this.onEditCallbacks.push( func );
	},	
	
	disableElement: function(){
		this.enabled = false;
		this.element.addClass( "disabled" );
	},
	
	enableElement: function(){
		this.enabled = true;
		this.element.removeClass( "disabled" );
	},
	
	initialize: function( anElement, aMarshal, options ) {

        this.parent( anElement, aMarshal, options );

        console.log( "mop.uiUIElement", anElement, aMarshal, this.element.retrieve( "class" ) );
        
		this.fieldName = this.getValueFromClassName( 'field' );

		// if autosubmit is set in the class as autoSubmit-false then set to false, otherwise default to true
		this.autoSubmit = (  mop.util.getValueFromClassName( "autoSubmit", this.element.get( "class" ) ) == "false" )? false : this.autoSubmit;
//		console.log( this.toString(), this.field, this.autoSubmit );
		this.action = ( this.getValueFromClassName( "action" ) )? this.getValueFromClassName( "action" ) : this.options.action;

		if( this.getValueFromClassName('validation') ) this.validationOptions = this.getValueFromClassName( 'validation' ).split("_");

		if( !this.fieldName ) console.log( "ERROR", this.toString(), "has no fieldName, check html class for field-{fieldName}" );	

//		console.log( "Constructor", this.toString(), this.fieldName, this.options );

	},
	
	toString: function(){
		return "[ object, mop.ui.UIElement ]";
	},
	
	onResponse: function( json ){

		this.destroyValidationSticky();

		if( json && json.error ){
			this.validationSticky = new mop.ui.Sticky( this, {
				title: "Error:",
				message: json.message,
				scrollContext: this.options.scrollContext
			});
			this.validationSticky.show();
		}else{
			if( this.onCompleteCallbacks.length > 0 ){
				for( var i = 0; i < this.onCompleteCallbacks.length; i++ ){
					this.onCompleteCallbacks[i]( json, this );
				}
			}
		}

		console.log( this.toString(), "onResponse", $A( arguments ) );

	},

	getValue: function(){
		console.log( this.toString(), "Subclasses of mop.ui.UIElement must override getValue function" );
	},

	setValue: function(){
		console.log( this.toString(), "Subclasses of mop.ui.UIElement must override setValue function" );
	},
	
	submit: function( e ){

	//	console.log( this.toString(), "submit", e, this.autoSubmit, this.getValue() );
		mop.util.stopEvent( e );
		
		if( this.onEditCallbacks && this.onEditCallbacks.length > 0 ){
			this.onEditCallbacks.each( function( aFunc ){
				aFunc();
			});
		}
		
		var val = this.getValue();
		this.submittedValue = val;
		
		if( !this.validate() ) return;		

		if( !this.autoSubmit ){
			this.setValue( val );
			if( this.leaveEditMode ) this.leaveEditMode();
			return;
		}
		
		if( this.showSaving ) this.showSaving();
		
		var url = mop.util.getAppURL() + this.marshal.getSubmissionController() + "/ajax/" + this.action + "/" + this.marshal.getObjectId();
		var submittedVars = { field: this.fieldName, value: val };
		
		console.log( "SUBMIT ", url, submittedVars );
		
		mop.util.JSONSend( url, submittedVars, { onComplete: this.onResponse.bind( this ) } );
		if( this.leaveEditMode ) this.leaveEditMode();

	},
	
	validate: function(){
		
		this.destroyValidationSticky();
		
//		console.log( "\nvalidate", this.toString(), this.fieldName, this.getValue(), this.validationOptions );
		
		if( this.validationOptions ){
			for( var i = 0; i < this.validationOptions.length; i++ ){
				if( !mop.util.validation.checkValueForValidity( this.getValue(), this.validationOptions[i] ) ) this.validationErrors.push( this.validationOptions[i] );
			}
		}
		
//		console.log( "\tvalidationErrors", this.toString(), this.fieldName, this.validationErrors.length, this.validationErrors );
		
		if( this.validationErrors.length > 0 ){

			//add tooltip with all errors
			var errorMessage = [];

			this.validationErrors.each( function( anError ){

				var error = ( this.marshal.alerts && this.marshal.alerts[ this.fieldName ] )? this.marshal.alerts[ this.fieldName ] : mop.util.validation.alerts[anError];
				error = ( error )? error : anError;
				errorMessage.push( error );

			}, this );

			this.validationSticky = new mop.ui.Sticky( this, { title: "Error", message: errorMessage.join( "<br/>" ), scrollContext: this.options.scrollContext } );
//			console.log( "\t\tvalidationStickyCreated", this.toString(), this.fieldName, this.validationSticky, errorMessage );
			this.validationSticky.reposition();
			this.validationSticky.show();
			
			this.validationErrors = [];
			return false;

		}

		this.validationErrors = [];
		return true;

	},
	
	destroyValidationSticky: function(){
//		console.log( "destroyValidationSticky", this.toString(), this.validationSticky );
		if( this.validationSticky ){
			this.validationSticky.destroy();
			delete this.validationSticky;
			this.validationSticky = null;			
		}	
	},
		
	getCoordinates: function(){
//		console.log( this.toString(), "getCoordinates", this.scrollContext, this.element.getCoordinates( this.scrollContext ) );
		return this.element.getCoordinates( this.scrollContext );
	},
	
	destroy: function(){

		this.element.eliminate( "Class", this );

		this.destroyValidationSticky();
		
		delete this.element;
		delete this.elementClass;
		delete this.fieldName;
		delete this.autoSubmit;

		delete this.onCompleteCallbacks;
		delete this.onEditCallbacks;

		delete this.action;
		delete this.validationOptions;
		delete this.validationErrors;
		delete this.validationSticky;

		this.element = null;
		this.marshal = null;
		this.elementClass = null;
		this.fieldName = null;
		this.autoSubmit = null;
		
		this.onCompleteCallbacks = null;		
		this.onEditCallbacks = null;
		
		this.action = null;
		this.validationOptions = null;
		this.validationSticky = null;	
		
		
	}
	
});


/*
	Class: mop.ui.EnhancedModal
	A lightweight modal class
*/
mop.ui.EnhancedModal = new Class({
	
		/*
		@TODO : i think mop.ui.windowMode is vestigeous, lets find out and remove it entirely eh?
		*/
	
		Implements: [ Events, Options ],
		
		loadedModules: [],
		element: null,
		marshal: null,
		modalAnchor: null,
		modal: null,
		header: null,
		headerControls: null,
		title: null,
		content: null,
		footer: null,
		footerControls: null,
		showTransition: null,
		hideTransition: null,
		loadedModules: null,
		protectedModules: null,
		
		options: {
			destroyOnClose: false,
			fadeDuration: 300
		},
		
		initialize: function( anElement, aMarshal, options ){
			
			this.setOptions( options );
		
			this.marshal = aMarshal;

//			console.log( ":::::", this.toString(), this.marshal );
			
			if( anElement ){
								
				this.element = $( anElement );
				this.element.setStyles( { "z-index": mop.DepthManager.incrementDepth( "modal" ) } );

				this.modalAnchor = this.element.getElement( ".modalAnchor" );

				this.modal = this.element.getElement( ".modal");

				this.header = this.element.getElement( ".header" );
				this.headerControls = this.header.getElement( ".controls" );
				
				this.title = this.header.getElement( "h3" );
				
				this.content = this.element.getElement( ".content" );
				
				this.footer = this.element.getElement( ".footer" );
				this.footerControls = this.footer.getElement( ".controls" );

			}else{

				this.element = this.build();

			}
			
			this.modalAnchor.setStyles({
				 "useHandCursor":false
			});
			this.modalAnchor.setProperty( 'href', "#" );
			this.modalAnchor.addEvent( "click", Event.stop );
			
			this.initControls();
			
			this.showTransition = new Fx.Morph( this.element, { 
				"property": "opacity",
				"duration": this.options.fadeDuration,
				"onStart": function(){
					this.element.setStyle("display","blo