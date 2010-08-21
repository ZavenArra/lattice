mop.ui = {};
mop.ui.navigation = {};

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

mop.util.DepthManager = new Class({

	Extends: mop.util.Broadcaster,

	modalDepth: 5000,
	windowOverlayDepth: 1000,
	modalOverlayDepth: 8000, 

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
		return '[ object, mop.util.Broadcaster, mop.ui.ModalManager ]';
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
//		console.log( "setActiveModal", aModal, aModal.element );

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

	options:{ action: "savefield" },
	
	onCompleteCallbacks: [],
	
	type: "Generic UIElement",
	
	element: null,
	marshal: null,
	elementClass: null,
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

		this.setOptions( options );
//		console.log( this.toString(), this.fieldName, this.options );
		this.element = $( anElement );
		this.marshal = aMarshal;
		this.elementClass = this.element.get( "class" );

		this.element.store( "Class", this );

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
		
		var url = mop.getAppURL() + this.marshal.getSubmissionController() + "/ajax/" + this.action + "/" + this.marshal.getRID();
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
					this.element.setStyle("display","block");
				}
			});

			this.hideTransition = new Fx.Morph( this.element, { 
				"property": "opacity",
				"duration": this.options.fadeDuration
			});
			
			mop.ModalManager.setActiveModal( this );

			this.element.addEvent( "scroll", mop.ModalManager.onModalScroll.bind( mop.ModalManager, this ) );
//			console.log( "MODAL", this.element, mop.ModalManager );
		},
		
		build: function(){
			
			this.element = new Element( "div", {
				"class": "enhancedModalContainer hidden",
				"styles": { "z-index": mop.DepthManager.incrementDepth( "modal") }
			});

			this.modalAnchor = new Element( "a", {
				"class": "modalAnchor",
				"href": "#",
				"events": { "click" : function( e ){ 
					mop.util.stopEvent( e );
				}.bindWithEvent( this ) }
			}).inject( this.element );

			this.modal = new Element( "div", { "class": "modal" }).inject( this.element );

			this.header = new Element( "div", { "class" : "header" } ).inject( this.element );
			this.title = new Element( "h3", { "text" : "title" } ).inject( this.header );			
			this.headerControls = new Element( "div", { "class" : "controls" } ).inject( this.header );
			var cancelButton = new Element( "a", { 
				"class" : "icon cancel",
				"href" : "cancel"
			}).inject( this.headerControls );
			
			
			this.content = new Element( "div", { "class": "content" } ).inject( this.modal );

			this.footer = new Element( "div", { "class": "footer" } ).inject( this.modal );
			this.footerControls = this.headerControls.clone().inject( this.footer );
			
			$(document).getElement("body").adopt( this.element );

			return this.element;

		},
		
		initControls: function(){
			this.headerControls.getElement( ".cancel" ).addEvent( "click", this.close.bindWithEvent( this ) );
			this.footerControls.getElement( ".cancel" ).addEvent( "click", this.close.bindWithEvent( this ) );
			if( this.element.getElement( ".tabNav" ) ) this.tabNav = new mop.ui.navigation.Tabs( this.element.getElement( ".tabNav" ), "a", this.loadTab.bind( this ) );
		},

		toString: function(){
			return "[ object, mop.ui.EnhancedModal ]";
		},

		showLoading: function(){
//			console.log( this.toString(), 'showLoading' );
			this.content.empty();
			this.modal.addClass("centeredSpinner");
			this.hideControls();
			this.show();
		},
		
		hideControls: function(){
			this.headerControls.addClass("hidden");
			this.footerControls.addClass("hidden");	
		},

		showControls: function(){
			console.log( "\n============================================================================");
			console.log( "\tshowControls", this.toString() );
			console.log( this.header.get("html") )
			this.headerControls.removeClass("hidden");
			this.footerControls.removeClass("hidden");	
			console.log( "============================================================================\n\n");
		},
		
		show: function(){

			console.log( "show", this.toString(), this );

			this.showControls();
			mop.ui.windowMode = "modal";
			this.modal.removeClass("centeredSpinner")
			this.element.setStyle( "opacity", 0 );
			this.element.removeClass("hidden");
			this.showTransition.start( { "opacity": 1 } );

		},

		close: function( e, onComplete ){
			
			mop.util.stopEvent( e );
			
			mop.ui.windowMode = "normal";
			this.element.setStyle( "opacity", 1 );
			
			//this should be part of a mixin or something, 
			// it should be written once
			// it should do all ui elements not just ipes
			// since modals dont have a uiElement array, it needs a way to find all ui elements...... hmmmm
			var ipes = this.content.getElements( ".ui-IPE" );
			ipes.each( function( anIPE ){
				anIPE.retrieve( "Class" ).destroyValidationSticky();
			});
			
			this.hideTransition.start({
				onComplete: function(){
					if( onComplete ) onComplete();
					this.element.addClass("hidden");
					mop.ModalManager.removeModal( this );
				}.bind( this )
			});
			
		},
		
		cancel: function( e ){
			this.close( e );
		},
		
		setTitle: function( aString ){
//			console.log( "setTitle\t", this.toString(), aString );
			this.title.set( "text", aString );
		},
		
		loadTab: function( aTab ){
//			console.log( "loadTab", aTab );
			this.content.empty();
			this.content.addClass( "centeredSpinner" );
			this.setTitle( aTab.get( "title" ), "loading..." );
			mop.util.JSONSend( aTab.get( "href" ), null, { onComplete: this.onTabLoaded.bind( this ) });
		},

		onTabLoaded: function( json ){
			this.content.removeClass( "centeredSpinner" );
			this.setContent( json.html );
		},

		setContent: function( someContent, aTitle ){
//			console.log( this.toString(), "setContent", aTitle );
		
			if( aTitle ) this.setTitle( aTitle );
			
			this.destroyChildModules();
			
			this.content.empty();
					
			if( this.modal.hasClass( "centeredSpinner" ) ) this.modal.removeClass( "centeredSpinner" );

			if( typeof someContent == "string" ){
				this.content.set( "html", someContent );
			}else{
				this.content.adopt( someContent );
			}

			this.initModules();

		},

		initModules: function(){
			var newlyInstantiatedModules = mop.ModuleManager.initModules( this.content, 'modal' );
			this.loadedModules = newlyInstantiatedModules.loadedModules;
			this.protectedModules = newlyInstantiatedModules.protectedModules;
		},
		
		destroyChildModules: function(){
			if( !this.loadedModules || !this.loadedModules.length ) return;
			var count = this.loadedModules.length - this.protectedModules.length;
			while( this.loadedModules.length >= count ){

				if( !this.loadedModules[ this.loadedModules.length - 1 ].isProtected() ){
					var moduleReference = this.loadedModules.pop();		
					mop.ModuleManager.destroyModuleById( moduleReference.instanceName, this.instanceName + "destroyChildModules" );
				}
			}
		},

		getScrollOffset: function(){
			return this.element.getScroll();
		},
		
		destroy: function(){
			
			console.log( "destroy", this.marshal, this.marshal.instanceName, this.toString() );
			
			this.marshal.removeModal( this );
//			mop.ModalManager.removeModal( this );
			this.destroyChildModules();
			
			this.element.destroy();

			delete this.element;
			delete this.modalAnchor;
			delete this.modal;
			delete this.header;
			delete this.headerControls;
			delete this.title;
			delete this.footer;
			delete this.footerControls;
			delete this.content;
			delete this.hideTransition;
			delete this.showTransision;
			delete this.loadedModules;
			delete this.protectedModules;

			this.loadedModules = null;
			this.protectedModules = null;
			this.element = null;
			this.modalAnchor = null;
			this.modal = null;
			this.header = null;
			this.headerControls = null;
			this.title = null;
			this.content = null;
			this.footer = null;
			this.footerControls = null;
			this.marshal = null;
			this.hideTransition = null;
			this.showTransision = null;
			this.loadedModules = null;

		}		

});


mop.ui.EnhancedAddItemDialogue = new Class({
	
	Extends: mop.ui.EnhancedModal,
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	},
	
	toString: function(){
		return "[ Object, mop.ui.EnhancedModal, mop.ui.EnhancedAddItemDialogue ]";
	},
	
	build: function(){
		
		this.element = new Element( "div", {
			"class": "enhancedModalContainer hidden",
			"styles": { "z-index": mop.DepthManager.incrementDepth( "modal") }
		});

		this.modalAnchor = new Element( "a", {
			"class": "modalAnchor",
			"href": "#",
			"events": { "click" : function( e ){
				mop.util.stopEvent( e );
			}.bindWithEvent( this ) }
		}).inject( this.element );

		this.modal = new Element( "div", { "class": "modal" }).inject( this.element );

		this.header = new Element( "div", { "class" : "header" } ).inject( this.element );
		this.title = new Element( "h3" ).inject( this.header );
		this.headerControls = new Element( "div", { "class" : "controls" } ).inject( this.header );

		var submitButton = new Element( "a", { 
			"class" : "icon submit",
			"href" : "submit"
		}).inject( this.headerControls );

		var cancelButton = new Element( "a", { 
			"class" : "icon cancel",
			"href" : "cancel"
		}).inject( this.headerControls );

		
		
		this.content = new Element( "div", { "class": "content" } ).inject( this.modal );

		this.footer = new Element( "div", { "class": "footer" } ).inject( this.modal );
		this.footerControls = this.headerControls.clone().inject( this.footer );
		
		$(document).getElement("body").adopt( this.element );

		return this.element;

	},

	setContent: function( someContent, aTitle ){
//		console.log( this.toString(), "setContent" );

		this.content.empty();

//		console.log( this.toString(), "setContent", aTitle );
		if( aTitle ) this.title.set( "text", aTitle );
		if( this.modal.hasClass( "centeredSpinner" ) ) this.modal.removeClass( "centeredSpinner" );


		this.itemContainer = new Element( "ul" );
		
		this.content.adopt( this.itemContainer );

		if( typeof someContent == "string" ){
			this.itemContainer.set( "html", someContent );
		}else{
			this.itemContainer.adopt( someContent );
		}

		var controls = this.itemContainer.getElement(".itemControls");
	 	controls.getElement(".delete").addClass("hidden");
		
//		console.log( "setContent\t", this.toString(), this.element.getScrollSize().y, this.element.getSize().y );
		if( this.element.getScrollSize().y <= this.element.getSize().y ){
//			console.log( "\t", this.header.getStyle( "margin-left" ) );
			this.header.setStyle( "margin-left", parseInt( this.header.getStyle( "margin-left" ) ) + 7 );
//			console.log( "\t", this.header.getStyle( "margin-left" ) );
		}

		try{ 
			controls = null;
		}finally{
//			console.log( "+++++ ", this.itemContainer.getFirst() );
			return this.itemContainer.getFirst();
		}
	
	},
	
	initControls: function(){
		this.parent();
		this.headerControls.getElement( ".submit" ).addEvent( "click", this.submit.bindWithEvent( this ) );
		this.footerControls.getElement( ".submit" ).addEvent( "click", this.submit.bindWithEvent( this ) );
	},

	submit: function( e ){
		
		mop.util.stopEvent( e );		
		
		/* @TODO: Figure out how to submit all ui elements inside the modal before submit (that way they all validate and close)*/
		var ipes = this.content.getElements( ".ui-IPE" );

		var invalidIpes = [];

		ipes.each( function( anIPE ){
			var validity = anIPE.retrieve( "Class" ).validate();
			if( !validity ){
				invalidIpes.push( anIPE );
			} else { 
				if( anIPE.retrieve( "Class" ).mode == "editing" ) anIPE.retrieve( "Class" ).submit();
			}
		});

		if( invalidIpes.length > 0 ) return;
		
		delete invalidIpes;
		invalidIpes = null;

		this.close( e, function(){
			this.getItemClass().element.setStyle( "opacity", 0 );
			this.marshal.insertItem( this.getItemClass().element );
		}.bind( this ) );

	},
	
	getItemClass: function(){
//		console.log( "getItemClass : ", this.container.getElement("li").retrieve("Class") );
		return this.content.getElement("li").retrieve("Class");
	},

	cancel: function( e ){
//		console.log( "cancel,", e, e.target );
		mop.util.stopEvent( e );
		this.close( e, this.getItemClass().deleteItem.bind( this.getItemClass() ) );
	},

	destroy: function(){
		this.content.destroy();
		this.parent();
	}
	
});

/*	Class: mop.ui.Modal
	A lightweight modal class
*/


mop.ui.Modal = new Class({

	Implements: [ Options, Events ],

	initialize: function( aMarshal ){

		this.marshal = aMarshal;

		this.element = new Element( "div", {
			"class": "modalContainer",
			"styles": {
				"display" : "none",
				"opacity" : 0,
				"styles": { "z-index": mop.DepthManager.incrementDepth( 'modal' ) }
			}
		});

		this.modalAnchor = new Element( "a", {
			"class": "modalAnchor",
			"styles": { "useHandCursor": false },
			"href": "#",
			"events": { "click" : Event.stop }
		});

		this.modal = new Element( "div", {
			"class": "modal"
		});
		
		this.header = new Element( "h3" );


		this.element.grab( this.modalAnchor );
		this.element.grab( this.modal );
		this.modal.grab( this.header );

		$(document).getElement("body").adopt( this.element );

		this.showMe = new Fx.Morph( this.element, { 
			"property": "opacity",
			"duration": 300,
			"onStart": function(){
				this.element.setStyle("display","block");
			}
		});

		this.hideMe = new Fx.Morph( this.element, { 
			"property": "opacity",
			"duration": 300,
			"onComplete": function(){}
		});


	},
	
	toString: function(){ return "[ object, mop.ui.Modal ]"; },
	
	show: function(){
		mop.ui.windowMode = "modal";
		this.showMe.start({ "opacity": 1 });
	},
	
	cancel: function( e ){
		this.close( e );
	},
	
	close: function( e, onComplete ){
		mop.util.stopEvent( e );
		mop.ui.windowMode = "normal";
		this.element.setStyle( "opacity", 0 );
		this.hideMe.start( {
			onComplete: function(){ if( onComplete ) onComplete(); this.element.setStyle("display","none"); }.bind( this ) } );
	},
	
	destroy: function(){
		this.modal.destroy();
		this.modalAnchor.destroy();
		this.element.destroy();
		this.header.destroy();
		this.hideMe = null;
		this.showMe = null;
	}
		
});

mop.ui.MessageDialogue = new Class({

	Extends: mop.ui.Modal,
	
	initialize: function( aMarshal, aTitle, aMessage, onConfirm, onCancel, confirmText, cancelText ){
		this.parent( aMarshal );
		this.container = new Element( "div", { "class": "container" } );
		this.message = new Element("div");
		
		this.setupControls( onConfirm, onCancel, confirmText, cancelText );
		
		this.header.set( "text", aTitle );
		this.message.inject( this.container );
		this.container.inject( this.modal );

		return this;
	},
	
	setupControls: function( onConfirm, onCancel, confirmText, cancelText ){
		
		confirmText = (confirmText)? confirmText : "Confirm";
		cancelText = (cancelText)? cancelText : "Cancel";
		
		var controls = new Element( "div", { "class": "controls" } ).inject( this.container );
		this.confirmButton = new Element( "a", { "href": "#", "class": "button", "text": confirmText } ).inject( controls );
		this.cancelButton = new Element( "a", { "href": "#", "class": "button", "text": cancelText } ).inject( controls );
		
		this.confirmButton.addEvent( "click", this.close.bindWithEvent( this, null ) );
		this.cancelButton.addEvent( "click", this.close.bindWithEvent( this, null ) );
		if( onConfirm ) this.confirmButton.addEvent( "click", function(e){ 
			mop.util.stopEvent( e );
			onConfirm();
		}.bindWithEvent( this ) );
		if( onCancel ) this.cancelButton.addEvent( "click", function(e){
			mop.util.stopEvent( e );
			onCancel();
		}.bindWithEvent( this ) );
		controls.inject( this.container );

		controls = null;

	},

	setMessage: function( aMessage ){
		this.message.set( "html", aMessage );
	},
	
	destroy: function(){
		this.confirmButton.destroy();
		this.cancelButton.destroy();
		this.container.destroy();
		this.parent();
	}

});

mop.ui.InactivityDialogue = new Class({
	Extends: mop.ui.MessageDialogue,
	initialize: function( aMarshal, aTitle, aMessage, onConfirm, onCancel, confirmText, cancelText ){
		this.parent( aMarshal, aTitle, aMessage, onConfirm, onCancel, confirmText, cancelText );
	},
	
	setupControls: function(onConfirm, onCancel, confirmText, cancelText){
		confirmText = (confirmText)? confirmText : "Confirm";
		cancelText = (cancelText)? cancelText : "Cancel";
		var controls = new Element( "div", { "class": "controls" } ).inject( this.container );
		this.confirmButton = new Element( "a", { "href": "#", "class": "button", "text": confirmText } ).inject( controls );
		this.cancelButton = new Element( "a", { "href": "#", "class": "button", "text": cancelText } ).inject( controls );
		
		this.confirmButton.addEvent( "click", this.close.bindWithEvent( this, null ) );
//		this.cancelButton.addEvent( "click", this.close.bindWithEvent( this, null ) );
		if( onConfirm ) this.confirmButton.addEvent( "click", function(e){
			mop.util.stopEvent( e );
			onConfirm();
		}.bindWithEvent( this ) );
		if( onCancel ) this.cancelButton.addEvent( "click", function(e){
			mop.util.stopEvent( e );
			onCancel();
		}.bindWithEvent( this ) );
		controls.inject( this.container );
		controls = null;
	}
});


mop.ui.AddItemDialogue = new Class({
	
	Extends: mop.ui.Modal,
	
	initialize: function( aMarshal ){
		this.parent( aMarshal );
		this.container = new Element( "ul", { "class": "container" } );
		this.container.inject( this.modal );
	},
	
	toString: function(){
		return "[ Object, mop.ui.Modal, mop.ui.AddItemDialogue ]";
	},
	
	showLoading: function( label ){
		
		this.header.set("text",label);
		this.parent( label );

	},
	
	setContent: function( html ){
//		console.log( this.toString(), "setContent", html );
		this.modal.removeClass("centeredSpinner");
		this.container.set( "html", html );
		var controls = this.container.getElement(".itemControls");
	 	controls.getElement(".delete").addClass("hidden");
		controls.getElement(".submit").removeClass("hidden");
		controls.getElement(".cancel").removeClass("hidden");
		try{ controls = null; }finally{ return this.container.getFirst(); }
	},
	
	submit: function( e ){
		mop.util.stopEvent( e );		
		/* TODO: APPLY FOR OTHER UI ELEMENTS AS WELL*/
		var ipes = this.container.getElements( ".ui-IPE" );
		// console.log( "IPES TO VALIDATE >>>> ", ipes.join( "\n\t" ) );
		var invalidIpes = [];
		ipes.each( function( anIPE ){
			var validity = anIPE.retrieve( "Class" ).validate();
			if( !validity ){
				invalidIpes.push( anIPE );
			} else { 
				if( anIPE.retrieve( "Class" ).mode == "editing" ) anIPE.retrieve( "Class" ).submit();
			}
		});
		if( invalidIpes.length > 0 ){
			try{ 
				delete invalidIpes;
				invalidIpes = null;
			}finally{
				return
			};
		};
		
		var controls = this.container.getElement( ".itemControls" );

	 	controls.getElement(".delete").removeClass("hidden");
		controls.getElement(".submit").addClass("hidden");
		controls.getElement(".cancel").addClass("hidden");

		this.close( e, function(){
			this.getItemClass().element.setStyle( "opacity", 0 );
			this.marshal.insertItem( this.getItemClass().element );
		}.bind( this ) );

		controls = null;

	},

	getItemClass: function(){
//		console.log( "getItemClass : ", this.container.getElement("li").retrieve("Class") );
		return this.container.getElement("li").retrieve("Class");
	},

	cancel: function( e ){
//		console.log( "cancel,", e, e.target );
		mop.util.stopEvent( e );
		this.close( e, this.getItemClass().deleteItem.bind( this.getItemClass() ) );
	},
	

	destroy: function(){
		this.container.destroy();
		this.container = null;
		this.parent();
	}

});

mop.ui.MultiSelect = new Class({
	
	Extends: mop.ui.UIElement,
	
	type: "multiSelect",
	
	initialize: function( anElement, aMarshal, options ){
		
		this.parent( anElement, aMarshal, options );
		
		this.firstIsNull = mop.util.getValueFromClassName( "firstIsNull", this.element.get( "class" ) );

		this.ogSelect = this.element.getElement("select").setStyles( {
			"position": "absolute",
			"top": "-3000px",
			"left": "-1000px"
		});

		this.ogSelect.addEvent( "focus", this.showMultiSelect.bindWithEvent( this ) );
		this.ogSelect.addEvent( "keydown", this.updateAndClose.bindWithEvent( this ) );

		var selectedOptions = this.ogSelect.getSelected();

		var initVal = ( selectedOptions.length > 1 )? "Multiple" : ( selectedOptions.length )? selectedOptions[0].get( "text" ) : this.ogSelect.getChildren()[0].get("text");
		this.valueElement = new Element( "p", {
			"text": initVal
		}).inject( this.element );
		this.valueElement.addEvent( "click", this.showMultiSelect.bindWithEvent( this ) );
		this.buildMultiSelect();
	
	},

	getKeyValuePair: function(){
//		console.log( "getKeyValuePair", this.fieldName, this.getValue() );
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	getValue: function(){
		var val = [];
		this.ogSelect.getSelected().each( function( aSelectedOption ){
			val.push( aSelectedOption.getProperty( "value" ) );
		});
//		console.log( "getValue", val );
		return val;
	},
	
	setValue: function( newValue ){
		this.ogSelect.set( "value", 0 );
		this.valueElement.set( "text", ( this.ogSelect.getSelected().length > 1 )? "Multiple" : this.ogSelect.getSelected()[0].get( "text" ) );
	},
	
	getValuesAsQueryString: function(){
		var returnVal = new Hash( this.getKeyValuePair() ).toQueryString();
//		console.log( this.toString(), "getValuesAsQueryString()", getKeyValuePair(), returnVal );
		return returnVal;
	},
	
	buildMultiSelect: function(){
		
		if( this.multiBox ) this.multiBox.destroy();

		var w = ( this.ogSelect.getCoordinates().width > this.valueElement.getCoordinates().width )? this.ogSelect.getCoordinates().width + 16 : this.valueElement.getCoordinates().width + 16;

		this.multiBox = new Element( "div", {
			"class" : "multiSelectBox hidden",
			"styles":{
				"position": "absolute",
				"top": this.element.getPosition().y - window.getScroll().y,
				"left": this.element.getPosition().x,
				'width': w//this.ogSelect.getStyle("width")*1.5
			}
		});

		this.list = new Element( "ul", { "class": "multiSelectList" });
		
		this.controls = new Element( "div", { "class" : "controls clear" } );
		this.saveButton = new Element( "a", { 
			"class" : "icon submit"
		}).inject( this.controls );
		this.saveButton.addEvent( "click", this.onSaveClicked.bindWithEvent( this ) );;

		this.cancelButton = new Element( "a", { 
			"class" : "icon cancel"
		}).inject( this.controls )
		this.cancelButton.addEvent( "click", this.onCancelClicked.bindWithEvent( this ) );

		this.multiBox.adopt( this.list );
		this.multiBox.adopt( this.controls );
		this.element.adopt( this.multiBox );

	},
	
	onSaveClicked: function( e ){
		mop.util.stopEvent( e );
//	    console.log( "onSaveClicked" );
        this.updateAndClose( e );
        this.submit();
	},

	onCancelClicked: function( e ){
		mop.util.stopEvent( e );
//	    console.log( "onCancelClicked" );
	    this.hideMultiSelect();
	},

	onDocumentClicked: function( e ){
		mop.util.stopEvent( e );
	    if( e.target == this.saveButton || e.target == this.cancelButton ) return;
	    if(	$chk( e ) && ( e.target == this.multiBox || this.multiBox.hasChild( e.target ) ) ) return;
//	    console.log( "onDocumentClicked" );
	    this.updateAndClose( e );
	},
	
	updateMultiBoxList: function(){
		
		this.list.empty();
		
		var options = this.ogSelect.getChildren();
	
		delete this.checkBoxes;
		this.checkBoxes = [];
	
		if( !this.ogSelect.getProperty("value") ){
			this.ogSelect.setProperty( "value", 0 );
		}

//		console.log( "B", this.ogSelect.getSelected() );
		options.each( function( anOption, anIndex ){

			var opt = new Element( "li" );
			var checkBox = new Element( "input", { "type" : "checkbox", "value": anOption.get( "value" ) } );

			if( this.firstIsNull == "true" ){

				if( anIndex == 0 ){

					checkBox.addEvent( "click", this.clearNotNullOptions.bindWithEvent( this ) );

				}else{

					checkBox.addEvent( "click", this.clearNullOption.bindWithEvent( this ) );						

				}

			}

			this.checkBoxes.push( checkBox );

			var label = new Element( "label" );
			var span = new Element( "span", { "text" : anOption.get("text") } );
			//console.log( this.toString(), "updateMultiBoxList", anOption, anOption.getProperty( "selected" ) );
			if( anOption.getProperty( "selected" ) ) checkBox.setProperty( "checked", "checked" );
			label.adopt( checkBox );
			label.adopt( span );
			opt.adopt(label);
			this.list.adopt( opt );

		}, this );

	},
	
	clearNullOption: function( e ){
		this.checkBoxes[0].removeProperty( "checked" );
	},
	
	clearNotNullOptions: function( e ){

		this.checkBoxes.each( function( aCheckBox, anIndex ){
			if( anIndex != 0 ) aCheckBox.removeProperty( "checked" );
		});
		
	},
	
	updateOgSelect: function(){
		var selectOptions = this.ogSelect.getChildren();
		var selectedOptions = this.ogSelect.getSelected();
		this.multiBox.getElements( "input[type='checkbox']" ).each( function( aCheckBox, anIndex ){
			if( selectedOptions.contains( selectedOptions[ anIndex ] ) ) selectedOptions[ anIndex ].removeProperty( "selected" );
//		console.log( "updateOgSelect",  aCheckBox.getProperty( "checked" ) );
			if( aCheckBox.getProperty( "checked" ) ) selectOptions[ anIndex ].setProperty( "selected", true );
		});
//	console.log( "A", this.ogSelect.get("html"), this.ogSelect.getSelected() );
	},
	
	updateAndClose: function(){
//		console.log( 'updateAndClose', e, e.target, this.multiBox, this.multiBox.hasChild( e.target ) );
		this.ogSelect.removeEvents();
		this.updateOgSelect();
//		console.log( "updateAndClose", this.ogSelect.getSelected().length );
		this.valueElement.set( "text", ( this.ogSelect.getSelected().length > 1 )? "Multiple" : this.ogSelect.getSelected()[0].get( "text" ) );
		this.hideMultiSelect();
	
	},
	
	leaveEditMode: function(){
		this.updateAndClose();
	},
	
	showMultiSelect: function( e ){
		mop.util.stopEvent( e );
		this.documentBoundUpdateAndClose = this.onDocumentClicked.bindWithEvent( this );
		document.addEvent( "mousedown", this.documentBoundUpdateAndClose );
		this.updateMultiBoxList();
		this.multiBox.removeClass("hidden");
		this.multiBox.focus();
	},
	
	hideMultiSelect: function(){
		this.multiBox.addClass( "hidden" );
		document.removeEvent( 'mousedown', this.documentBoundUpdateAndClose );
	},
	
	destroy: function(){
		document.removeEvent( 'mousedown', this.documentBoundUpdateAndClose );
		this.multiBox.destroy();
		this.valueElement.destroy();
		delete this.checkBoxes;
		this.ogSelect.inject( this.element );
		this.multiBox = this.valueElement = this.checkBoxes = this.ogSelect = this.list = null;
		this.parent();
	}

});

mop.ui.HideShowGroup = new Class({
	
	type: "interfaceWidget",
	
	initialize: function( anElement, aMarshal, options ){
		this.element = $( anElement );
		this.toggle = $( "hideShowActuatorFor_" + this.element.get("id") );
		this.toggle.addEvent( "click", this.toggleVisibility.bindWithEvent( this ) );
	},
	
	toggleVisibility: function( e ){

		mop.util.stopEvent( e );

		this.element.toggleClass( ".hidden" );

	}
	
});

/*
	Class: mop.ui.VisibilityToggler
	Hides and shows nextSibling
*/
mop.ui.VisibilityToggler = new Class({

	type: "interfaceWidget",
	subType: "visibilityToggler",
	
	initialize: function( aToggleElement, options ){
		this.toggler = aToggleElement;
		this.toggler.setStyle("cursor","pointer");
		var toggleId = this.toggler.get("id");
		var targetId = toggleId.substring( "accordionActuatorFor_".length, toggleId.length );
		this.targetElement = $( targetId );

		console.log( this.toString(), toggleId, targetId, $( targetId ) );
	
		var duration = mop.util.getValueFromClassName( 'duration', aToggleElement.get( "class" ) );
		var display = mop.util.getValueFromClassName( 'display', aToggleElement.get( "class" ) );
		if( display ){
			if( display == "false" ){
				display = -1;
			}
		}

		// console.log( "ACCORDION", toggleId, targetId, this.targetElement )
		this.accordion = new Fx.Accordion( $$( this.toggler ), $$( this.targetElement ), {
			alwaysHide: true,
			display: ( display )? display : -1,
			duration: ( duration )? duration : 250,
			initialDisplayFx: false,
			onBackground: function ( toggler ){
				var text = toggler.get( "text" );
				console.log( toggler, text );
				text = text.replace(/\-/gi,'+');
				text = text.replace(/hide/gi,'Show');
				toggler.set( "text", text );
			},

			onActive: function ( toggler, element ){
				var text = toggler.get( "text" );
				console.log( toggler, text );
				text = text.replace(/\+/g,'-');
				text = text.replace(/show/gi,'Hide');
				toggler.set( "text", text );
			}
		});
		this.toggler.store( "accordion", this.accordion );
	},
	
	toString: function(){
		return "[ object, mop.ui.VisibilityToggler ]";
	},
	
	destroy: function(){
		this.toggler.eliminate( "accordion" );
		delete this.accordion;
		this.accordion = this.toggler = this.type = this.subType = this.toggleElement = this.targetElement = null;
	}

	
});

mop.ui.ExtendedMonkeyPhysicsDatePicker = new Class({

	Extends: DatePicker,

	Implements: [ Events, Options ],
	
	initialize: function( attachTo, aMarshal, options ){
		this.marshal = aMarshal;
		this.attachTo = attachTo;

		this.setOptions( options );
		
		//i dont know why i need to do this, setOptions doesnt seem to be adding the "on" Methods to the options array during setoptions... im sure i am just understanding something wrong.
		this.options.onShow = options.onShow;
		this.options.onSelect = options.onSelect;
		this.options.onClose = options.onClose;
		
		this.attach();

		if (this.options.timePickerOnly) {
			this.options.timePicker = true;
			this.options.startView = 'time';
		}

		this.formatMinMaxDates();
		document.addEvent('mousedown', this.close.bind(this));
//		console.log( this.toString(), options, this.options );

	},

	select: function( values ) {
		this.choice = $merge(this.choice, values);
		var d = this.dateFromObject(this.choice);
		this.input.set('value', this.format(d, this.options.inputOutputFormat));
		this.visual.set('value', this.format(d, this.options.format));
		this.options.onSelect();
		this.close(null, true);
	},
	
	constructPicker: function() {

		this.picker = new Element( 'div', { 'class': this.options.pickerClass }).inject(document.body);
		if( this.options.elementId ) this.picker.set( "id", this.options.elementId );
		
		if (this.options.useFadeInOut) {
			this.picker.setStyle('opacity', 0).set('tween', { duration: this.options.animationDuration });
		}
		
		var h = new Element('div', { 'class': 'header' }).inject(this.picker);
		var titlecontainer = new Element('div', { 'class': 'title' }).inject(h);
		new Element('div', { 'class': 'previous' }).addEvent('click', this.previous.bind(this)).set('text', '«').inject(h);
		new Element('div', { 'class': 'next' }).addEvent('click', this.next.bind(this)).set('text', '»').inject(h);
		new Element('div', { 'class': 'closeButton' }).addEvent('click', this.close.bindWithEvent(this, true)).set('text', 'x').inject(h);
		new Element('span', { 'class': 'titleText' }).addEvent('click', this.zoomOut.bind(this)).inject(titlecontainer);
		
		var b = new Element('div', { 'class': 'body' }).inject(this.picker);
		this.bodysize = b.getSize();
		this.slider = new Element('div', { styles: { position: 'absolute', top: 0, left: 0, width: 2 * this.bodysize.x, height: this.bodysize.y }})
					.set('tween', { duration: this.options.animationDuration, transition: Fx.Transitions.Quad.easeInOut }).inject(b);
		this.oldContents = new Element('div', { styles: { position: 'absolute', top: 0, left: this.bodysize.x, width: this.bodysize.x, height: this.bodysize.y }}).inject(this.slider);
		this.newContents = new Element('div', { styles: { position: 'absolute', top: 0, left: 0, width: this.bodysize.x, height: this.bodysize.y }}).inject(this.slider);
	},
	
	toString: function(){
		return "[ Object, DatePicker, mop.ui.ExtendedMonkeyPhysicsDatePicker ]";
	},
	
	getDate: function(){
		return this.dateFromObject( this.choice );
	},
	
	show: function( position, timestamp){

		this.parent( position, timestamp );
		var depth = mop.DepthManager.incrementDepth( ( this.marshal.scrollContext == "modal" )? 'modalOverlay' : 'windowOverlay' );

//		console.log( this.toString(), "show", this.marshal.scrollContext );
		if( this.marshal.scrollContext == 'modal' ){
			mop.ModalManager.addListener( this );
			this.addEvent( "modalScroll", this.onModalScroll.bind( this ) );
		}
		mop.util.EventManager.addListener( this );
		this.addEvent( "resize", this.reposition.bind( this ) );

		this.reposition();
		this.picker.setStyle( "z-index", depth );

	},

	setDate: function( date ){
		this.select( { year: date.getFullYear(), month: date.getMonth(), day: date.getDate() } );
	},

	attach: function() {
		// toggle the datepicker through a separate element?
		if ($chk(this.options.toggleElements)) {
			var togglers = $$(this.options.toggleElements);
			document.addEvents({
				'keydown': function(e) {
					if (e.key == "tab") {
						this.close(null, true);
					}
				}.bind(this)
			});
		};
		
		// attach functionality to the inputs		
		$$(this.attachTo).each(function(item, index) {
			
			// never double attach
			if (item.retrieve('datepicker')) return;
			
			// determine starting value(s)
			if ($chk(item.get('value'))) {
				var init_clone_val = this.format(new Date(this.unformat(item.get('value'), this.options.inputOutputFormat)), this.options.format);
			} else if (!this.options.allowEmpty) {
				var init_clone_val = this.format(new Date(), this.options.format);
			} else {
				var init_clone_val = '';
			}
			
			// create clone
			var display = item.getStyle('display');
			var clone = item
			.setStyle('display', this.options.debug ? display : 'none')
			.store('datepicker', true) // to prevent double attachment...
			.clone()
			.store('datepicker', true) // ...even for the clone (!)
			.removeProperty('name')    // secure clean (form)submission
			.setStyle('display', display)
			.set('value', init_clone_val)
			.inject(item, 'after');
			
			/*added by thiago@madeofpeople.org */
			this.input = item;
			this.visual = clone;
			/*end modificiations*/
			
			// events
			if ($chk(this.options.toggleElements)) {
				togglers[index]
					.setStyle('cursor', 'pointer')
					.addEvents({
						'click': function(e) {
							this.onFocus(item, clone);
						}.bind(this)
					});
				clone.addEvents({
					'blur': function() {
						item.set('value', clone.get('value'));
					}
				});
			} else {
				clone.addEvents({
					'keydown': function(e) {
						if (this.options.allowEmpty && (e.key == "delete" || e.key == "backspace")) {
							item.set('value', '');
							e.target.set('value', '');
							this.close(null, true);
						} else if (e.key == "tab") {
							this.close(null, true);
						} else {
							mop.util.stopEvent( e );
						}
					}.bind(this),
					'focus': function(e) {
						this.onFocus(item, clone);
					}.bind(this)
				});
			}
		}.bind(this));
	},

	onFocus: function(original_input, visual_input) {
		
		var init_visual_date, d = visual_input.getCoordinates();
		
		if ($chk(original_input.get('value'))) {
			init_visual_date = this.unformat(original_input.get('value'), this.options.inputOutputFormat).valueOf();
		} else {
			init_visual_date = new Date();
			if ($chk(this.options.maxDate) && init_visual_date.valueOf() > this.options.maxDate.valueOf()) {
				init_visual_date = new Date(this.options.maxDate.valueOf());
			}
			if ($chk(this.options.minDate) && init_visual_date.valueOf() < this.options.minDate.valueOf()) {
				init_visual_date = new Date(this.options.minDate.valueOf());
			}
		}
		
		this.show({ left: d.left + this.options.positionOffset.x, top: d.top + d.height + this.options.positionOffset.y }, init_visual_date);
		this.input = original_input;
		this.visual = visual_input;
//		console.log( this.toString(), "onFocus", this.options );
		this.options.onShow();
	},
	
	getValue: function(){
		return this.input.get( 'value' );
	},

	setValue: function( aValue ){
		if( aValue == null && this.allowEmpty ){
			this.attachTo.set( 'value', aValue );
			this.visual.set( "value", aValue );
		}else{
			this.attachTo.set( 'value', aValue );
			this.visual.set( "value", aValue );
		}		
	},
	
	onModalScroll: function( ){
//		console.log( this.toString(), "onModalScroll" );
		this.reposition();
	},
	
	reposition: function(){
		if( this.picker && this.marshal.scrollContext == "modal" ){
			var coords = this.visual.getCoordinates();
			var left = coords.left;
			this.picker.setStyles({
				"top": coords.top + coords.height + this.options.positionOffset.y,
				"left": left
			});
		}
	},
	
	destroy: function(){
		mop.util.EventManager.removeListener( this );
		mop.ModalManager.removeListener( this );
		this.removeEvents();
		this.parent();
	}

});

/*	Class: mop.ui.DatePicker
	mop.ui Wrapper for http://www.monkeyphysics.com/mootools/script/2/datepicker
	@TODO add some kind of spinner element on save
*/

mop.ui.DatePicker = new Class({

	Extends: mop.ui.UIElement,
	
	type: "datePicker",
	action: "savefield",
		
	initialize: function( anElement, options ){
//		console.log( "\t:::::>>>> ", this.toString(), "initialize", anElement, options );
		this.parent( anElement, options );
		this.dateField = this.element.getElement("input");
		this.allowEmpty = (  this.getValueFromClassName( "allowEmpty" ) )? true : false;
		this.buildPicker();
	},
	
	toString: function(){
		return '[ Object, mop.ui.UIElement, mop.ui.DatePicker ]';
	},
	
	buildPicker: function(){
//		console.log( "buildPicker");
		this.picker = new mop.ui.ExtendedMonkeyPhysicsDatePicker( this.dateField, this, {
			elementId: "datePickerFor_" + this.fieldName,
			startView: "month",
			inputOutputFormat: "Y/m/d",
			format: "m/d/Y",
			allowEmpty: this.allowEmpty,
			onShow: this.onShow.bind( this ),
			onSelect: this.onSelect.bindWithEvent( this  ),
			onClose: $empty
		});
	},
	
	onSelect: function( e ){
		mop.util.stopEvent( e );
		this.submit();
	},
	
	onShow: function(){
		var scrollData = ( this.scrollContext == "modal" )? mop.ModalManager.getActiveModal().getScrollOffset() : $( window ).getScroll();
//		console.log( this.toString(), 'onShow', this.scrollContext, scrollData );
		this.reposition( scrollData );
	},

	reposition: function( scrollData ){
//		console.log( this.toString(), "reposition", $A( arguments ) );
		this.picker.reposition( scrollData );
	},
	
	onResponse: function( json ){
//		console.log( this.toString(), "onResponse", $A( arguments ) );
		this.parent( json );
	},
	
	onClose: function(){},
	
	getValue: function(){
		return this.dateField.get("value");
	},

	setValue: function( aValue ){
//		console.log( "Setvalue", aValue );
		this.dateField.set( aValue );
	},
	
	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	destroy: function(){
		if( this.picker ) this.picker.destroy();
		this.parent();
	},
	
	getDateFormat: function(){
		return ( mop.util.getValueFromClassName( "format", this.element.get( "class" ) ) )? mop.util.getValueFromClassName("format", this.element.get( "class") ) : "dmY";
	},
	
	getCurrentDateString: function(){
		var currentDate = new Date();
		var dateString = "";
//		console.log( ">>>>>>>> ", this.getDateFormat() );
		if( this.getDateFormat() == "dmy" ){
			dateString = currentDate.getDate() + "/"+ currentDate.getMonth() + "/" + currentDate.getYear();
		}else{
			dateString = currentDate.getMonth() + "/" + currentDate.getDate() + "/"+ currentDate.getYear();
		}
		try{
			return dateString;
		}finally{
			delete currentDate;
			delete dateString;
			currentDate = null;
			dateString = null;
		}
	}
	
});

mop.ui.TimePicker = new Class({

	Extends: mop.ui.DatePicker,
	type: "timepicker",
	
	toString: function(){
		return '[ Object, mop.ui.UIElement, mop.ui.DatePicker, mop.ui.TimePicker ]';
	},
		
	initialize: function( anElement, options ){
		this.parent( anElement, options );
	},
	
	buildPicker: function(){
		this.picker = new DatePicker( this.dateField, {
			elementId: "datePickerFor_" + this.fieldName,
			timePicker: true,
			yearPicker: false,
			startView: "time",
			inputOutputFormat: "H:i",
			format: "h:i:a",
			debug: false,
			onSelect: this.onSelect.bindWithEvent( this )
		});
	}
});

/*	Class: mop.ui.DateRangePicker
	Datepicker with two fields, and range validation 
*/
mop.ui.DateRangePicker = new Class({

	Extends: mop.ui.UIElement,
	
	type: "dateRange",
	
	options: {
		alerts:{
			endDateLessThanStartDateError : "The end date cannot be earlier than the start date."
		}
	},
	
	initialize: function( anElement, aMarshal ){

		this.parent( anElement, aMarshal );
		
		this.dateFields = this.element.getElements("input");
		
		this.allowEmpty = ( this.getValueFromClassName( "allowEmpty" ) == "true" )? true : false;
		
		this.dateFields.each( function( aDateField, index ){
//			console.log( "DATERANGE",  index, aDateField, this.elementClass, this.autoSubmit, this.allowEmpty, this.getValueFromClassName( "allowEmpty" ) );
			var opts = {
				elementId: "datePickerFor_" + this.fieldName,
				startView: ( mop.util.getValueFromClassName( "startView", this.element.get( "class" ) ) )?  mop.util.getValueFromClassName( "startView", this.element.get( "class" ) ) : "month",
				allowEmpty: this.allowEmpty,
				inputOutputFormat: "Y/m/d",
				format: "m/d/Y",
				onShow: this.onShow.bind( this ),
				onSelect: this.onSelect.bindWithEvent( this ),
				onClose: $empty,
				index: index
			};
//			console.log( "//////////////////", aDateField, index, this.submit, this.onShow, opts );
			var picker = new mop.ui.ExtendedMonkeyPhysicsDatePicker( aDateField, this, opts );
			aDateField.store( "Class", picker );

		}, this );

	},
	
	onSelect: function( e ){
		mop.util.stopEvent( e );
        this.submit();
	},
	
	onShow: function( scrollData ){
		this.dateFields.each( function( aDateField, index ){
//			console.log( this.toString(), "reposition", $A( arguments ) );
			aDateField.retrieve( "Class" ).reposition( scrollData );
		});
	},
	
	onClose: function(){},
	
	
	reposition: function( scrollData ){
//		console.log( this.toString(), "reposition", $A( arguments ) );
		this.dateFields.each( function( aDateField ){
			aDateField.reposition( scrollData );
		});
	},
	

	validate: function(){
		if( !this.isEndDateAfterStartDate() ) this.validationErrors.push( this.options.alerts.endDateLessThanStartDateError );
		this.parent();
	},
	
	toString: function(){
		return "[ Object, mop.ui.UIElement, mop.ui.DateRangePicker ]";
	},

	onResponse: function(){
//		console.log( this.toString(), " onreponse", $A( arguments ) );
		this.element.getElement(".spinner").addClass("hidden");
	},
	
	getValue: function(){
		var startDate = this.dateFields[0].retrieve("Class").getValue();
		var endDate = this.dateFields[1].retrieve("Class").getValue();
		return { startDate: startDate, endDate: endDate, field: this.fieldName };
	},
	
	setValue: function( date ){

//		console.log( "setValue", this.toString(), $A( arguments ) );

		var range = { startDate: null, endDate: null };
		
		var now = new Date();
		if( !date ){
			var date = { startDate: "", endDate: "" };
		}
		
		if( !date.startDate || date.startDate == "" ){
			range.startDate = ( this.allowEmpty )? "" : now;
		}else{
			range.startDate = date.startDate;
		}
		
		if( !date.endDate || date.endDate == "" ){
			range.endDate = ( this.allowEmpty )? "" : now;
		}else{
			range.endDate = date.endDate;
		}

		// this.setRange( range );

		this.dateFields[0].retrieve( "Class" ).setValue( range.startDate );
		this.dateFields[1].retrieve( "Class" ).setValue( range.endDate );

	},
	
	setRange: function( date ){
		this.dateFields[0].retrieve( "Class" ).setDate( date.startDate );
		this.dateFields[1].retrieve( "Class" ).setDate( date.endDate );
	},

	getDates: function(){
		var startDate = this.dateFields[0].retrieve("Class").getDate();
		var endDate = this.dateFields[1].retrieve("Class").getDate();
		return { startDate: startDate, endDate: endDate };
	},
	
	getKeyValuePair: function(){
		var vals = this.getValue();
		var returnVal = {};
		returnVal[ this.fieldName + "_startDate" ] = vals.startDate;
		returnVal[ this.fieldName + "_endDate" ] = vals.endDate;
//		console.log( "DateRange .... getKeyValuePair : ", returnVal );
		return returnVal;
	},
	
	isEndDateAfterStartDate: function(){

//		console.log( "startDate less than or equal to endDate? ", this.getDates().startDate, this.getDates().endDate );

		var dates = this.getDates();
		
		var returnVal = ( ( ( dates.startDate ) && ( dates.endDate ) ) && ( this.getDates().startDate < this.getDates().endDate ) );
		
		return returnVal;

	},
	
	setConstraint: function( constraint ){
		this.constraint = constraint;
	},
	
	constrainDates: function( constraint ){
//		console.log( e.target.get("value") );
		this.setConstraint( constraint );
		switch( this.constraint ){
			case "TOTALS":
			case "DAILY":
			break;
			case "MONTHLY":
				this.setRange( this.constrainToMonthly( this.getDates() ) );
			break;
			case "WEEKLY":
				this.setRange( this.constrainToWeekly( this.getDates() ) );
			break;
			case "YEARLY":
				this.setRange( this.constrainToYearly( this.getDates() ) );
			break;
		}
	},

	daysInMonth: function( year, month ) {
//		var monthArray = [ 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec' ];
	 	var dd = 32 - new Date( year, month, 32 ).getDate();
		return dd;
	},

	constrainToMonthly: function( dates ){
		dates.startDate.setDate(1);
		dates.endDate.setDate( this.daysInMonth( dates.endDate.getFullYear(), dates.endDate.getMonth() ) );
		return dates; 
	},

	constrainToWeekly: function( dates ){

		var difference = dates.endDate.getTime() - dates.startDate.getTime();

//		console.log(difference);

		var msInDay = 86400000;

		var days = Math.round( difference / ( msInDay ) );
//		console.log( days );

//		console.log( dates.endDate.getTime() );

		if( days%7 != 6 ){
			//then update the end date to the most lesser end date
			var val = 7 - days%7 - 1;
			var oldTime = dates.endDate.getTime();
			dates.endDate = new Date();
			dates.endDate.setTime( oldTime + (7 - days%7 -1) * msInDay );
		}
		return dates;
	},

	constrainToYearly: function( dates ){
		dates.startDate.setFullYear( dates.startDate.getFullYear(), 0, 1 );
		dates.endDate.setFullYear( dates.endDate.getFullYear(), 11, 31 );
		return dates;
	}

});





/*	Class: mop.ui.File
	File uploader with progress
	Modified and simplified version of fancyupload2 by digitarald.
*/
mop.ui.FileElement = new Class({

	Extends: mop.ui.UIElement,
	
	type: "file",
	
	options:{
		action: "savefile"
	},
	
	ogInput: null,
	uploadButton: null,
	Uploader: null,
	baseURL: null,
	statusElement: null,
	progressBar: null,
	statusMessage: null,
	previewElement: null,
	fileName: null,
	action: null,
	extensions: null,
	sizeLimitMax: null,
	sizeLimitMin: null,
	submitURL: null,
	statusShow: null,
	statusHide: null,
	validationError: null,
	invalid: null,
	imagePreview: null,
	imgAsset: null,
	imageFadeIn: null,

	initialize: function( anElement, aMarshal, options ){

		this.parent( anElement, aMarshal, options );

		this.ogInput = this.element.getElement( "input[type='file']" );
		this.ogInput.setStyles({
			"position": "absolute",
			"top": "-2000px"
		});

		this.uploadButton = this.element.getElement( ".uploadLink" );
		this.uploadButton.store( "Class", this );

		this.Uploader = new mop.util.Uploader( { path: mop.getBaseURL() + "modules/mop/views/digitarald/fancyupload/Swiff.Uploader3.swf", target: this.uploadButton } );

		this.ogInput.addEvent( "focus", this.onFocus.bindWithEvent( this ) );
		this.uploadButton.addEvent( "mouseover", this.onMouseOver.bindWithEvent( this ) );

		this.baseURL = mop.getBaseURL();

		this.statusElement = this.element.getElement( 'div.status' );
		this.progressBar = this.statusElement.getElement( "img" );
		this.statusMessage = this.statusElement.getElement( "span.message" );

		this.statusShow = new Fx.Morph( this.statusElement, { 
			'duration': 500,
			'onComplete': function(){
				mop.util.EventManager.broadcastEvent("resize");
			}.bind( this )
		});

		this.statusHide = new Fx.Morph( this.statusElement, { 
			'duration': 500,
			"onComplete": function(){
				this.statusElement.addClass( "hidden" );
				mop.util.EventManager.broadcastEvent("resize");
			}.bind( this )
		});

		this.previewElement = this.element.getElement(".preview");
		if( this.previewElement ) this.imagePreview = this.previewElement.getElement( "img" );

		this.fileName = this.element.getElement( ".fileName" );
		mop.util.EventManager.addListener( this );

		this.action = ( this.getValueFromClassName( "action" ) )? this.getValueFromClassName( "action" ) : this.options.action;

//		this.fieldName = this.getValueFromClassName( "field" );
		this.extensions = this.buildExtensionsObject();
		this.submitURL = this.getSubmitURL();
		this.sizeLimitMax = Number( mop.util.getValueFromClassName( "maxlength", this.element.get("class") ) ) * 1024;
	},

	toString: function(){
		return "[ Object, mop.ui.UIElement, mop.ui.FileElement ]";
	},
	
	getOptions: function(){
		var opts = {
			target: this.element,
			fieldName: this.fieldName,
			url: this.submitURL,
			data: {
				field: this.fieldName,
				url: this.submitURL
			},
			typeFilter: this.extensions,
			sizeLimitMin: 0,
			sizeLimitMax: this.sizeLimitMax
		}
//		console.log( this.toString(), "getOptions", opts );
		return opts;
	},
	
	buildExtensionsObject: function(){
//		console.log( this, "::", this.getValueFromClassName( "extensions" ) );
		var extensionsArray = ( this.getValueFromClassName( "extensions" ).split("_") )? this.getValueFromClassName( "extensions" ).split("_") : this.getValueFromClassName( "extensions" ) ;
		if(!extensionsArray) return null;
		var desc = "";
		var exts = "";
		extensionsArray.each( function( extension, index ){
			desc = ( index < extensionsArray.length-1 )? desc +  "*." + extension + ", " : desc +  "*." + extension;
			exts = ( index < extensionsArray.length-1 )? exts + "*." + extension + ";" : exts + "*." + extension;
		});
		desc = "'Allowed Files: " + desc + "'";
		exts = exts;
		var ret =  {};
		ret[desc] = exts;
//		console.log( this, "buildExtensionsObject ", ret );
		return ret;
	},

	getSubmitURL: function(){
		var url = mop.getAppURL() + this.marshal.getSubmissionController() + "/ajax/" + this.action + "/" + this.marshal.getRID();
//		console.log( ":::: ", this.toString(), "getSubmitURL: ", url );
		return 	url;
	},
	
	onFocus: function( e ){
//		console.log( this.toString(), "onFocus", e );

		mop.util.stopEvent( e );

		this.Uploader.setFocus( this, this.getPosition() );
	},
	
	// onKeyDown: function( e ){
	// 	if( e.key == "enter" && this.Uploader.getFocus() == this ){
	// 		mop.Uploader.browse();
	// 	}
	// },
	
	onUploadButtonClicked: function( e ){
		mop.util.stopEvent( e );
	},
	
	onMouseOver: function( e ){

		mop.util.stopEvent( e );

		var depth = ( this.scrollContext == 'modal' )? mop.DepthManager.incrementDepth( 'modalOverlay' ) :  mop.DepthManager.incrementDepth( 'windowOverlay' );
//		console.log( this.toString(), "onTargetHovered", this.scrollContext, depth );
		this.Uploader.onTargetHovered( this, this.uploadButton, this.getCoordinates(), depth, this.getOptions() );

	},
	
	reposition: function( scrollContext ){
		this.Uploader.reposition( scrollContext );
	},
	
	getCoordinates: function(){
		return this.uploadButton.getCoordinates( this.scrollContext );
	},

	validate: function() {
		
//		console.log( this.toString(), 'validate' );

		var options = this.Uploader.options;
		
		if (options.fileListMax && this.Uploader.fileList.length >= options.fileListMax) {
			this.validationError = 'fileListMax';
			return false;
		}
		
		if (options.fileListSizeMax && (this.Uploader.size + this.size) > options.fileListSizeMax) {
			this.validationError = 'fileListSizeMax';
			return false;
		}
		
		return true;

	},

	invalidate: function() {
//		console.log( this.toString(), "invalidate" );
		this.invalid = true;
		this.Uploader.fireEvent( 'fileInvalid', this, 10 );
		return this.fireEvent( 'invalid', this, 10 );
	},

	render: function() {
		
//		console.log( this.toString(), 'render' );

		this.addEvents({
			'start': this.onStart,
			'progress': this.onProgress,
			'complete': this.onComplete,
			'error': this.onError,
			'remove': this.onRemove
		});
		
		return this;

	},

	showProgress: function( data ) {
//		console.log( this.toString(), "onProgress", $A( arguments ) );
		this.progressBar.setStyle( "background-position", ( 100 - data.percentLoaded )+"% 0%" );
		if( this.imagePreview ) this.imagePreview.setStyle( "opacity", ( 1 - data.percentLoaded * .01 ) );

	},	
	
	showStatus: function(){
//		console.log( this.toString(), "showStatus", $A( arguments ) );
		mop.util.EventManager.broadcastEvent("resize");
 		this.statusShow.start( { "opacity": [0,1] } );
		this.statusElement.removeClass("hidden");
	},
	
	revertToReadyState: function(){
//		console.log( this.toString(), "revertToReadyState" );
		this.statusHide.start( { "opacity":[1,0] });
	},
	
	onFileComplete: function( data ){
//		console.log( this.toString(), "onFileComplete", $A( arguments ), this.previewElement );

		var json = JSON.decode( data.response.text );

//		console.log( "-------------------------------- ", $A( arguments ) );

		this.fileName.set( "text",  json.filename );


		if( this.previewElement ){
//			console.log( this.toString(), "onFileComplete B ", json, data.response.text, JSON.decode( data.response.text ) );
			this.imgAsset = new Asset.image( json.thumbSrc, {  alt: json.filename, onload: this.updateThumb.bind( this, json ) } );
		}else{
			this.revertToReadyState();
		}
	},
	
	updateThumb: function( imageData ){

//		console.log( this.toString(), "updateThumb", imageData );

		var size = ( this.imagePreview )? this.imagePreview.getSize() : { x: 0, y: 0 };
		this.imgAsset.setStyle( "width", size.x );
		this.imgAsset.setStyle( "height", size.y );
		this.imgAsset.setStyle( "opacity", 0 );
		if( !this.imagePreview ){
			//this.imagePreview = new Element( "img" ).inject( this.previewElement, "top" );
			this.imgAsset.inject( this.previewElement, "top" );
		}else{
			this.imgAsset.replaces( this.imagePreview );
		}
		this.imagePreview = this.previewElement.getElement( 'img' );
		this.revertToReadyState();
		this.imageFadeIn = new Fx.Morph( this.imagePreview, {
			'duration': 300
			//"onComplete": this.broadcastResize.bind( this )
		}).start( { "opacity" : [ 0, 1 ], "width": imageData.width, "height": imageData.height } );

	},
	

	destroy: function(){
//		console.log( "destroy\t", this.toString() );
		mop.util.EventManager.removeListener( this );
//		this.removeEvents();
		this.Uploader.destroy();
		this.statusElement.destroy();
		
		delete this.action;
		delete this.baseURL;
		delete this.extensions;
		delete this.fileName;
		delete this.imagePreview;
		delete this.imageFadeIn;
		delete this.imgAsset;
		delete this.ogInput;
		delete this.previewElement;
		delete this.progressBar;
		delete this.sizeLimitMax;
		delete this.sizeLimitMin;
		delete this.statusElement;
		delete this.statusHide;
		delete this.statusMessage;
		delete this.statusShow;
		delete this.submitURL;
		delete this.uploadButton;
		delete this.Uploader;
		delete this.validationError;
		delete this.invalid;

		this.action = null,
		this.baseURL = null,
		this.extensions = null,
		this.fileName = null,
		this.imagePreview = null,
		this.imageFadeIn = null,
		this.imgAsset = null,
		this.ogInput = null,
		this.previewElement = null,
		this.progressBar = null,
		this.sizeLimitMax = null,
		this.sizeLimitMin = null,
		this.statusElement = null,
		this.statusHide = null,
		this.statusMessage = null,
		this.statusShow = null,
		this.submitURL = null,
		this.uploadButton = null,
		this.Uploader = null,
		this.validationError = null,
		this.invalid = null,

		this.element.eliminate( "Class" );
		if( this.uploadButton ) this.uploadButton.eliminate( "Class" );
		this.parent();

	}

});

mop.util.Uploader = new Class({
	
	Extends: Swiff,

	Implements: Events,
	
	box: null,
	loaded: false,
	size: null,
	fileList: [],
	currentFileElementInstance: null,
	status: null,
	
	options: {
		path: 'Swiff.Uploader.swf',
		
		target: null,
		zIndex: 9999,
		
		height: 30,
		width: 100,
		callBacks: null,
		params: {
			wMode: 'opaque',
			menu: 'false',
			allowScriptAccess: 'always'
		},

		typeFilter: null,
		multiple: false,
		queued: false,
		verbose: false,

		url: null,
		method: null,
		data: null,
		mergeData: true,
		fieldName: null,

		fileSizeMin: 1,
		fileSizeMax: null, // Official limit is 100 MB for FileReference, but I tested up to 2Gb!
		allowDuplicates: true,
		timeLimit: (Browser.Platform.linux) ? 0 : 30,

		buttonImage: null,
		policyFile: null,
		
		fileListMax: 0,
		fileListSizeMax: 0,

		instantStart: true,
		appendCookieData: false,
		
		fileClass: null

	},

	initialize: function( options ) {

		this.setOptions(options);

//		console.log( "\tmop.util.Uploader", "\n" );
		// protected events to control the class, added
		// before setting options (which adds own events)
		this.addEvent('load', this.initializeSwiff, true )
			.addEvent('select', this.processFiles, true )
			.addEvent('complete', this.update, true )
			.addEvent('onComplete', this.complete, true )
			.addEvent('onFileComplete', this.fileComplete, true )
			.addEvent('onBeforeStart', this.beforeStart, true)
			.addEvent('fileRemove', function(file) {
				this.fileList.erase(file);
		}.bind(this), true);

		mop.util.EventManager.addListener( this );
		this.addEvent( "resize", this.reposition );


		// callbacks are no longer in the options, every callback
		// is fired as event, this is just compat
		if (this.options.callBacks) {
			Hash.each(this.options.callBacks, function(fn, name) {
				this.addEvent(name, fn);
			}, this);
		}

		this.options.callBacks = { fireCallback: this.fireCallback.bind(this) };

		var path = this.options.path;
		if (!path.contains('?')) path += '?noCache=' + $time(); // cache in IE

		// container options for Swiff class
		this.options.container = this.box = new Element('span', {'class': 'swiff-uploader-box'}).inject( $( this.options.container ) || document.body );

		this.parent( path, {
			params: {
				wMode: 'transparent'
			},
			height: '100%',
			width: '100%'
		});



		this.addEvents({
			buttonEnter: this.targetRelay.bind(this, ['mouseenter'] ),
			buttonLeave: this.targetRelay.bind(this, ['mouseleave'] ),
			buttonDown: this.targetRelay.bind(this, ['mousedown'] ),
			buttonDisable: this.targetRelay.bind(this, ['disable'] ),
			fileComplete: this.targetRelay.bind( this, ['fileComplete'] )
		});
		
		this.size = this.uploading = this.bytesLoaded = this.percentLoaded = 0;
		
		if (Browser.Plugins.Flash.version < 9) {
			this.fireEvent('fail', ['flash']);
		} else {
//			console.log("INITIALIZING, about to call verifyload....." );
			this.verifyLoad.delay( 1000, this );
		}
	},

	toString: function(){
		return "[ Object, digitarald.Swiff.Uploader, mop.util.Uploader ]";
	},
	
	setFocus: function(){
		this.box.getChildren()[0].focus();
	},
	
	verifyLoad: function() {

//		console.log( this.toString(), "verifyLoad", this.object );

		if (this.loaded) return;

		if (!this.object.parentNode) {
			this.fireEvent('fail', ['disabled']);
		} else if (this.object.style.display == 'none') {
			this.fireEvent('fail', ['hidden']);
		} else if (!this.object.offsetWidth) {
			this.fireEvent('fail', ['empty']);
		}

	},

	fireCallback: function( name, args ) {

		// file* callbacks are relayed to the specific file
//		console.log( this.toString(), "fireCallback", name, args );

		if (name.substr(0, 4) == 'file') {
			// updated queue data is the second argument
			if (args.length > 1) this.update(args[1]);
			var data = args[0];

			var file = this.findFile( data.id );
			this.fireEvent( name, file || data, 5 );
			if (file) {
				var fire = name.replace(/^file([A-Z])/, function($0, $1) {
					return $1.toLowerCase();
				});
				file.update(data).fireEvent( fire, [ data ], 10 );
			}
		} else {
			this.fireEvent( name, args, 5 );
		}
	},

	
	findFile: function(id) {
//		console.log( "findFile" );
		for (var i = 0; i < this.fileList.length; i++) {
			if ( this.fileList[i].id == id ) return this.fileList[i];
		}
		return null;
	},

	initializeSwiff: function() {
//		console.log( this.toString(), "initializeSwiff" );
		// extracted options for the swf 
		this.remote('initialize', {
			width: this.options.width,
			height: this.options.height,
			typeFilter: this.options.typeFilter,
			multiple: this.options.multiple,
			queued: this.options.queued,
			url: this.options.url,
			method: this.options.method,
			data: this.options.data,
			mergeData: this.options.mergeData,
			fieldName: this.options.fieldName,
			verbose: this.options.verbose,
			fileSizeMin: this.options.fileSizeMin,
			fileSizeMax: this.options.fileSizeMax,
			allowDuplicates: this.options.allowDuplicates,
			timeLimit: this.options.timeLimit,
			buttonImage: this.options.buttonImage,
			policyFile: this.options.policyFile
		});

		this.loaded = true;

		this.appendCookieData();
	},

	targetRelay: function(name) {
//		console.log( "targetRelay", name );
		if ( this.currentFileElementInstance ) this.currentFileElementInstance.fireEvent( name );
	},

	setOptions: function( options ) {

		if (options) {
//			console.log( this.toString(), "setOptions", options );
			if ( options.url) options.url = mop.util.Uploader.qualifyPath( options.url );
			if ( options.buttonImage) options.buttonImage = mop.util.Uploader.qualifyPath( options.buttonImage );
			this.parent( options );
			if( this.loaded ) this.remote( 'setOptions', options );
		}

		return this;

	},

	onTargetHovered: function( target, targetElement, coords, depth, options ){
		if( this.currentFileElementInstance == target ) return;
//		console.log( this.toString(), options );
		this.setTarget( target, targetElement, coords, depth, options );
	},

	setEnabled: function(status) {
//		console.log( "setEnabled" );
		this.remote('setEnabled', status);
	},

	start: function() {
		this.status = "uploading";
		this.fireEvent('beforeStart');
		this.remote('start');
	},

	stop: function() {
		this.status = "rest";
//		console.log( "stop" );
		this.fireEvent('beforeStop');
		this.remote('stop');
	},

	remove: function() {
//		console.log( "remove" );
		this.fireEvent('beforeRemove');
		this.remote('remove');
	},

	update: function( data ) {
		// the data is saved right to the instance
//		console.log( this.toString(), "update", data );
		if( data ) this.currentFileElementInstance.showProgress( data );
		$extend(this, data);
		this.fireEvent('queue', [this], 10);
		return this;
	},

	beforeStart: function(){
//		console.log( this.toString(), "beforeStart", $A( arguments ) );
		this.currentFileElementInstance.showStatus();
		this.reposition();
	},
	
	fileStart: function(file) {
//		console.log( "fileStart" );
		this.fireEvent("fileStart");
		this.remote('fileStart', file.id);
	},
	
	fileStop: function(file) {
//		console.log( "fileStop" );
		this.remote('fileStop', file.id);
	},

	fileRemove: function(file) {
//		console.log( "fileRemove" );
		this.remote('fileRemove', file.id);
	},

	fileRequeue: function(file) {
//		console.log( "fileRequeue" );
		this.remote('fileRequeue', file.id);
	},

	fileComplete: function( data ){
		this.status = "rest";
//		console.log( this.toString(), "onFileComplete", $A( arguments ) );
		// fixes weird behavior of everything going well but thumb not updating if upload happens too fast.
		this.currentFileElementInstance.onFileComplete.delay( 90, this.currentFileElementInstance, data );
	},
	
	complete: function(){
//		console.log( this.toString(), "complete" );
//		this.currentFileElementInstance.onComplete( data );
	},
	
	onComplete: function(){
		this.status = "rest";
//		console.log( this.toString(), "onComplete" );
		this.currentFileElementInstance.onComplete();
	},
	
	appendCookieData: function() {
//		console.log( "appendCookieData" );
		var append = this.options.appendCookieData;
		if (!append) return;

		var hash = {};
		document.cookie.split(/;\s*/).each(function(cookie) {
			cookie = cookie.split('=');
			if (cookie.length == 2) {
				hash[decodeURIComponent(cookie[0])] = decodeURIComponent(cookie[1]);
			}
		});

		var data = this.options.data || {};
		if ($type(append) == 'string') data[append] = hash;
		else $extend(data, hash);

//		console.log( this.toString(), "appendCookieData", data );

		this.setOptions( { data: data } );
	},

	processFiles: function( successraw, failraw, queue ) {

//		console.log( this.toString(), "processFiles", $A( arguments ) );

		var fail = [], success = [];

		if( successraw ){
//			console.log( this.toString(), "processFiles", "success", success );
			successraw.each( function( data ) {
				this.size += data.size;
				this.fileList.push( this.currentFileElementInstance );
				success.push( this.currentFileElementInstance );
				this.currentFileElementInstance.render();
			}, this );

			this.fireEvent( 'selectSuccess', [ success ], 10 );

		}

		if (failraw || fail.length){
//			console.log( this.toString(), "!!! FAILED !!!", failraw, fail );
			//this.currentFileElementInstance.invalidate().render();
			switch( failraw.validationError ){
				case "sizeLimitMax":
				alert( "This file is larger than the maximum allowed, which is " + this.currentFileElementInstance.getOptions.sizeLimitMax );
				break;
			}
			this.fireEvent('selectFail', [fail], 10);
		}

		this.update(queue);
//		console.log( this.toString(), "processFiles", this.options.instantStart, success.length, success)
		if (this.options.instantStart && success.length) this.start();
	},

	setTarget: function( uiElement, targetElement, coords, depth, options ){

		this.currentFileElementInstance = uiElement;
		this.target = targetElement;

		this.setOptions( options );
		this.reposition();

	},

	onResize: function(){
		this.reposition();
	},
	
	reposition: function( scrollContext ) {
		
		if( !this.currentFileElementInstance ) return;

		var coords = this.currentFileElementInstance.getCoordinates();

		if( !scrollContext ){
			depthContext = (  this.currentFileElementInstance.scrollContext == 'modal' )? "modalOverlay" : "windowOverlay";			
		}else{
			depthContext = (  depthContext == "modal" )? "modalOverlay" : "windowOverlay";
		}

		var newDepth = mop.DepthManager.incrementDepth( depthContext );

//		console.log( this.toString(), "reposition", this.scrollContext, depthContext, this.currentFileElementInstance.getCoordinates(), newDepth );

		this.box.setStyles( {
			position: 'absolute',
			display: 'block',
			visibility: 'visible',
			zIndex: newDepth,
			overflow: 'hidden',
			width: coords.width + "px",
			height: coords.height + "px",
			top: coords.top + "px",
			left: coords.left + "px"
		});
	},

	render: function() {
//		console.log( this.toString(), "render", this.invalid, $A( arguments ) );
	},
	
	destroy: function(){
//		console.log( "UPLOADER DESTROY ", this.currentFileElementInstance );
		this.removeEvents();
		this.box.destroy();

		mop.ModalManager.removeListener( this );
		mop.util.EventManager.removeListener( this );
		
		delete this.box;
		delete this.loaded;
		delete this.size;
		delete this.fileList;
		delete this.currentFileElementInstance;
		delete this.status;
		
		this.box =  null;
		this.loaded = null;
		this.size = null;
		this.fileList = null;
		this.currentFileElementInstance = null;
		this.status = null;

	}

});

$extend( mop.util.Uploader, {

	STATUS_QUEUED: 0,
	STATUS_RUNNING: 1,
	STATUS_ERROR: 2,
	STATUS_COMPLETE: 3,
	STATUS_STOPPED: 4,

	log: function() {
		if (window.console && console.info) console.info.apply(console, arguments);
	},

	unitLabels: {
		b: [{min: 1, unit: 'B'}, {min: 1024, unit: 'kB'}, {min: 1048576, unit: 'MB'}, {min: 1073741824, unit: 'GB'}],
		s: [{min: 1, unit: 's'}, {min: 60, unit: 'm'}, {min: 3600, unit: 'h'}, {min: 86400, unit: 'd'}]
	},

	formatUnit: function(base, type, join) {
		var labels = Swiff.Uploader.unitLabels[(type == 'bps') ? 'b' : type];
		var append = (type == 'bps') ? '/s' : '';
		var i, l = labels.length, value;

		if (base < 1) return '0 ' + labels[0].unit + append;

		if (type == 's') {
			var units = [];

			for (i = l - 1; i >= 0; i--) {
				value = Math.floor(base / labels[i].min);
				if (value) {
					units.push(value + ' ' + labels[i].unit);
					base -= value * labels[i].min;
					if (!base) break;
				}
			}

			return (join === false) ? units : units.join(join || ', ');
		}

		for (i = l - 1; i >= 0; i--) {
			value = labels[i].min;
			if (base >= value) break;
		}

		return (base / value).toFixed(1) + ' ' + labels[i].unit + append;
	}

});

mop.util.Uploader.qualifyPath = ( function() {
	var anchor;
	return function( path ) {
		( anchor || ( anchor = new Element('a') ) ).href = path;
		return anchor.href;
	};

})();

mop.ui.PulldownNav = new Class({
	
	type: "pulldownNav",
	
	Extends: mop.ui.UIElement,
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.pulldown = this.element.getElement( "select" );
		this.pulldown.addEvent( "change", this.redirect.bindWithEvent( this ) );
	},
	
	getValue: function(){
		return this.pulldown.get( "value" );
	},
	
	setValue: function( aValue ){
		var selectedOption = this.pulldown.getSelected();
		selectedOption.removeProperty( "selected" );
		this.pulldown.getChildren().each( function( anOption ){
//			console.log( "------------->>>> ", aValue, anOption.getProperty( "value" ) );
			if( anOption.getProperty( "value" ) == aValue ) anOption.setProperty( "selected", "selected" );
		});
	},	
	
	redirect: function(){
		if( this.getValue() == null || this.getValue() == "" ) return;
		var url = mop.getAppURL() + this.getValue();
		window.location.href = url;
	}

});

mop.ui.Pulldown = new Class({

	Extends: mop.ui.UIElement,

	type: "pulldown",
	action: "savefield",
	pulldown: null,
	
	initialize: function( anElement, aMarshal, option ){
		this.parent( anElement, aMarshal, option );
		this.pulldown = this.element.getElement( "select" );
		this.pulldown.addEvent( "change", this.submit.bindWithEvent( this ) );
	},

	getValue: function(){
		return this.pulldown.get( "value" );
	},
	
	setValue: function( aValue ){
		var selectedOption = this.pulldown.getSelected();
		selectedOption.removeProperty( "selected" );
		this.pulldown.getChildren().each( function( anOption ){
//			console.log( "------------->>>> ", aValue, anOption.getProperty( "value" ) );
			if( anOption.getProperty( "value" ) == aValue ) anOption.setProperty( "selected", "selected" );
		});
	},
	
	getKeyValuePair: function(){
//		console.log( "getKeyValuePair ", this.element );
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	onResponse: function( json ){
		this.parent( json );
//		console.log( "Pulldown.onResponse,", $A(arguments) );
	},
	
	destroy: function(){
		delete this.pulldown;
		this.pulldown = null;
		this.parent();
	}

});

mop.ui.CheckBox = new Class({
	
	Extends: mop.ui.UIElement,

	type: "checkBox",

	action: "saveField",
	checkBox: null,
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.checkBox = this.element.getElement( "input[type='checkbox']" );
		this.checkBox.addEvent( "click", this.submit.bindWithEvent( this ) );
	},

	getValue: function(){
		return ( this.checkBox.get( "checked" ) )? 1 : 0;
	},
	
	submit: function( e ){

		console.log( "\t\t:::::", this.getValue(), this.checkBox.getProperty( "checked" ) );

		// var newValue = ( this.checkBox.getProperty( "checked" ) == "checked" )? false : true;
		// 
		// this.setValue( newValue );

		if( this.onEditCallbacks && this.onEditCallbacks.length > 0 ){
			this.onEditCallbacks.each( function( aFunc ){
				aFunc( this.field.get( "value" ) );
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

		var url = mop.getAppURL() + this.marshal.getSubmissionController() + "/ajax/" + this.action + "/" + this.marshal.getRID();
		var submittedVars = { field: this.fieldName, value: val };
		console.log( this.toString(), "submit", url, submittedVars );
		mop.util.JSONSend( url, submittedVars, { onComplete: this.onResponse.bind( this ) } );
		if( this.leaveEditMode ) this.leaveEditMode();

	},
	
	setValue: function( aVal ){
//		this.checkBox.set( "value", aVal );
		if( aVal == 1 ){
			this.checkBox.setProperty( "checked", "checked" );
		}else{
			this.checkBox.removeProperty( "checked" );
		} 
	},
	
	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	destroy: function(){
		delete this.checkBox;
		this.checkBox = null;	
		this.parent();
	}
		
});

mop.ui.RadioGroup = new Class({
	
	Extends: mop.ui.UIElement,

	type: "radioGroup",

	radios: null,
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.radios = this.element.getElements("input[type='radio']");
		this.enableElement();
		this.ogValue = this.getValue();
	},
	
	enableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();

		this.radios.each( function( aRadio ){
			aRadio.erase( "disabled" );
			aRadio.removeEvents();
			aRadio.addEvent( "change", this.submit.bindWithEvent( this ) );
		}, this );
	},
	
	disableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();

		this.radios.each( function( aRadio ){
			aRadio.set( "disabled", "disabled" );
			aRadio.removeEvents();
			aRadio.addEvent( "focus", Event.stop );
		}, this );

	},
	
	toString: function(){
		return "[ object, mop.ui.RadioGroup ]";
	},
	
	getValue: function(){
//	console.log( this, "getValue", this.radios, this.radios.length );
		for( var i = 0; i < this.radios.length; i++ ){
			if( this.radios[i].get( "checked" ) ) return this.radios[i].get( "value" );
		}
		return null;
	},
	
	setValue: function( aValue ){
		if( aValue == null ) aValue = "";
		for( var i = 0; i < this.radios.length; i++ ){
			var aRadio = this.radios[i];
//			console.log( aRadio.get( "value" ), ( aRadio.get( "value" ) == aValue ), ( aRadio.get( "value" ) == "" ) );
			if( aRadio.get( "value" ) == aValue ) aRadio.setProperty( "checked", "checked" );
		}
	},
	
	getKeyValuePair: function(){
//		console.log( "getKeyValuePair ", this.element );
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},

	onResponse: function( json ){
		this.parent( json );
//		console.log( "RadioGroup onResponse,", $A(arguments) );
	},
	
	destroy: function(){
		this.radios.each( function( aRadio ){
			aRadio.removeEvents();
			aRadio = null;
		});
		delete this.radios;
		this.radios = null;
		this.parent();
	}

});

mop.ui.Sticky = new Class({

	Implements: [ Options, Events ],
	type: "sticky",
	options: {},
	element: null,
	marshal: null,
	top: null,
	title: null,
	closeButton: null,
	message: null,

	initialize: function( aMarshal, options ){

		this.marshal = aMarshal;

		this.setOptions( options );

		if( this.marshal.scrollContext == 'modal' || this.marshal.options.scrollContext == 'modal' ){
			mop.ModalManager.addListener( this );
			this.addEvent( "modalScroll", this.onModalScroll.bind( this ) );
		}

		this.element = new Element( "div", {
			"class": "sticky",
			"styles":{ 
				"opacity":0,
				"position": "absolute",
				"left": ( this.options && this.options.offsetX )? this.marshal.element.getPosition().x + this.options.offsetX : this.marshal.element.getPosition().x,
				"cursor": "pointer"
			},
			"events": {
				"click": this.close.bindWithEvent( this )
			}
		});
		
		this.hideTransition = new Fx.Morph( this.element, { 
			duration: 250, onComplete: function(){ 
//				console.log( "onComplete", this.marshal, this.marshal.validationSticky );
				this.marshal.destroyValidationSticky();
			}.bind( this ) 
		});
		
		this.top = new Element( "div", { "class":"top" } ).inject( this.element );

		this.title = new Element( "h4", {
			"text": ( options && options.title )? options.title : ""
		}).inject( this.top );

		this.closeButton = new Element( "a", {
			"class": "close",
			"events": {
				"click": this.close.bindWithEvent( this )
			}
		}).inject( this.top );

		this.message = new Element( "p", {
			"text": ( options && options.message)? options.message : ""
		}).inject( this.element );

		this.element.inject( document.body );

		mop.util.EventManager.addListener( this );
		this.addEvent( "resize", this.reposition );
		this.reposition();

	},
	
	onModalScroll: function(){
		this.reposition( mop.ModalManager.getScroll() );
	},
	
	reposition: function( scrollData ){


		//A Hack to deal with empty but not-destroyed sticky objects
		//This is indicative of another memory leak.
		if( this.marshal.element == null){
			//alert('null marshal.element');
			return;
		}
		
		// 
		var pos = this.marshal.element.getCoordinates();
//		var top = ( this.marshal.scrollContext == "modal" )? ( pos.top - pos.height*.75 ) - mop.ModalManager.getActiveModal().element.getScroll().y : pos.top - pos.height*.75;
		var top = pos.top - pos.height*.75;
		var inModal = ( this.marshal.scrollContext == "modal" || this.marshal.options.scrollContext == "modal" );
		//@TODO, reconcile location of scrollContext, its either an option on a property, should probably be an option, since it gets passed to ui constructors from module 
		var left = ( inModal )? mop.ModalManager.getActiveModal().element.getCoordinates().left + pos.left : pos.left;
		
//		console.log( "repositioning", this.toString(), this.marshal.toString(), "{ inModal:", inModal, "}", this.marshal.fieldName, "{ activeModal.coords: ", mop.ModalManager.getActiveModal().element.getCoordinates().left, mop.ModalManager.getActiveModal().element.getCoordinates().top, "}", "{ marshalCoords: ", pos.left, pos.top, "}", top, left );

		var zIndex = ( inModal )? mop.DepthManager.incrementDepth( "modalOverlay" ) : mop.DepthManager.incrementDepth( "windowOverlay" );
		this.element.setStyles({
			"top" : top,
			"left" : left,
			"z-index" : zIndex
		});

	},
	
	close: function(e){
		mop.util.stopEvent( e );
		this.hide();
	},
	
	show: function( messageObj ){
		this.reposition();
		if( messageObj ){
			this.title.set( "text", messageObj.title );
			this.message.set( "text", messageObj.message );
			if( messageObj.offsetX ) this.element.setStyle( "left", this.marshal.element.getPosition().x + messageObj.offsetX );
		}
		
		this.element.setStyle( "display", "block" );
		this.element.fade( "in" );

	},

	hide: function(){
		this.hideTransition.start( { "opacity": 0 } ) ;
	},

	destroy: function(){
		
//		console.log( "destroy", this.toString() );
		
		this.removeEvents();		
		mop.ModalManager.removeListener( this );
		
		this.title.destroy();
		this.message.destroy();
		this.top.destroy();
		this.closeButton.destroy()
		this.element.destroy();
		
		delete this.message;
		delete this.top;
		delete this.title;
		delete this.closeButton;
		delete this.element;
		delete this.hideTransition;
		
		this.title = null;
		this.message = null;
		this.element = null;
		this.top = null;
		this.hideTransition = null;
		this.closeButton = null;
	
	}

});


mop.ui.Input = new Class({
	

	Extends: mop.ui.UIElement,

	type: "input",

	initialize: function( anElement, aMarshal, options ) {
		this.parent( anElement, aMarshal, options );
		this.inputElement = this.element.getElement( "input" );
		this.maxlength = this.getValueFromClassName("maxlength");
		if( this.maxlength ) this.element.addEvent("keydown", this.checkForMaxLength.bindWithEvent( this ) );
	},
	
	enableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();
		this.inputElement.erase( "disabled" );
		this.inputElement.removeEvents();
		// this.inputElement.addEvent( "click", this.enterEditMode.bindWithEvent( this ) );
		if( this.maxlength ) this.element.addEvent("keydown", this.checkForMaxLength.bindWithEvent( this ) );
	},
	
	disableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent( e );
		this.inputElement.set( "disabled", "disabled" );
		this.inputElement.removeEvents();
		this.inputElement.addEvent( "focus", Event.stop );
	},

	requiresValidation: function(){
		return Boolean( this.validationOptions );
	},

	toString: function(){
		return "[ Object, mop.ui.Input ]";
	},

	checkForMaxLength: function( e ){
//		console.log(this.maxlength, e.target.get("value").length);
		if( e.target.get("value").length >= this.maxlength && e.key != "shift" && e.key != "enter" && e.key != "return" && e.key != "tab" && e.keycode != 46 && e.keycode != 8 ){
			mop.util.stopEvent( e );
			alert( "The maximum length this field allows is " + this.maxlength + " characters");
		}
	},

	getValue: function(){
		return this.inputElement.get( "value" );
	},

	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},

	setValue: function( aValue ){
		this.inputElement.set( "value", aValue );
	},

	destroy: function(){
		this.parent();
	}

});

mop.ui.IPE = new Class({

	Extends: mop.ui.UIElement,

	type: "ipe",

	form: null,
	
	options:{
		messages: { clickToEdit: "click to edit." },
		action: "savefield"
	},

	enableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();
		this.ipeElement.removeEvents();
		this.ipeElement.addEvent( "click", this.enterEditMode.bindWithEvent( this ) );
	},
	
	disableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();
		this.ipeElement.removeEvents();
		this.ipeElement.addEvent( "mouseover", Event.stop );
		this.ipeElement.addEvent( "focus", Event.stop );
	},
	
	initialize: function( anElement, aMarshal, options ) {

		this.parent( anElement, aMarshal, options );

		this.mode = "resting";
		this.ipeElement = this.element.getElement(".ipe");
		this.ipeElement.store( "Class", this );
		this.rows = this.getValueFromClassName( "rows" );
		this.ogBgColor = this.ipeElement.getStyle("background-color");
		this.ogTextColor = this.ipeElement.getStyle("color");		

		this.enableElement();
		
		this.ipeElement.set( "title", this.options.messages.clickToEdit );

		this.oldValue = this.ipeElement.get( "text" );

	},

	toString: function(){
		return "[ Object, mop.ui.IPE ]";
	},

	enterEditMode: function( e ){
//		console.log( this.toString(), "enterEditMode", this.field );
		mop.util.stopEvent( e );
		if( this.marshal.suspendSort) this.marshal.suspendSort();
		if( this.mode == "editing ") return false;
		this.mode = "editing";
		
		if( !this.form ){
			this.buildForm();
			this.form.inject( this.element );
		}else{
			this.form.setStyle( "display", "block" );
		}
		
		this.ipeElement.setStyle( "display", "none" );
		this.field.addEvent( 'keydown', this.onKeyPress.bind( this ) );
		
		this.field.focus();
		this.field.select();
		
		mop.util.EventManager.broadcastEvent("resize");
		
	},
	
	onKeyPress: function( e ){
		var submitCondition = ( ( e.control || e.meta) && e.key == 'enter' );
		if( submitCondition == true ){
			this.submit(e);
		}else if( e.key == "esc" ){
			this.cancelEditing( e );
		}
		submitCondition = null;
	},
	
	
	html_entity_decode: function( aString ){
		var div = new Element("div", { "text": aString });
		try{
			return div.get( "text" );
		}finally{
			div.destroy();
			div = null;
		}
	},
	
	html_entity_encode: function( aString ){
		var matches = aString.match(/&#\d+;?/g);
		for(var i = 0; i < matches.length; i++){
			var replacement = String.fromCharCode((matches[i]).replace(/\D/g,""));
			data = data.replace(/&#\d+;?/,replacement);
		}
		return data;
	},
	
	fitToContent: function(){

        var fieldHeight = this.field.getSize().y;
        var scrollHeight = this.field.getScrollSize().y;
        targetHeight = Math.max( scrollHeight, fieldHeight );
//        console.log( "fitToContent", fieldHeight, scrollHeight, targetHeight );
        if ( scrollHeight >= fieldHeight ) this.field.setStyle( "height", targetHeight );

    },
        

	buildForm: function(){

		this.form = new Element( 'div', {
			"class": "IPEForm ",
			"events": { "submit": this.submitHandler }
		});
		
		var size = this.ipeElement.getSize();
		var contents = this.ipeElement.get( 'html' );
		
		var tag = ( this.rows > 1 )? "textarea" : "input";

		var opts;
		if( this.rows > 1 ){
			opts = {
				"rows": this.rows,
				"cols": this.cols,
				"text":   this.html_entity_decode( contents.replace( /<br( ?)(\/?)>/g, "\n" ) ),
				"value": this.formatForEditing( contents ),
				"styles": {
					"width": size.x,
					"height": size.y
				}
			}
			this.field = new Element( tag, opts );
			this.field.addEvent( "keyup", this.fitToContent.bind( this ) );
		}else{
			opts = {
				"rows": this.rows,
				"type": ( this.getValueFromClassName( 'type') == "password" )? "password" : "text",
				"class": "ipeField " + this.ipeElement.get( "tag" ),
				"value": this.formatForEditing( contents ),
				"styles": {
					"width": size.x,
					"height": size.y
				}
			}
			this.field = new Element( tag, opts );
		};


		this.maxlength = this.getValueFromClassName("maxlength");
		if( this.maxlength ) this.field.addEvent("keydown", this.checkForMaxLength.bindWithEvent( this ) );
		this.field.removeClass( "editable" );
		this.formControls = this.buildControls();
		this.field.inject( this.form );
		this.formControls.inject( this.form );

		this.submitOnBlur = ( this.getValueFromClassName( "submitOnBlur" ) == "true" )? this.getValueFromClassName( "submitOnBlur" ) : false;
		if( this.submitOnBlur == 'true' ) this.submitOnBlur = true;
//		console.log( this.submitOnBlur );
		if( this.submitOnBlur ) this.field.addEvent( "blur", this.submit.bindWithEvent( this ) );

		return this.form;
	},
	
	checkForMaxLength: function(e){
//		console.log(this.maxlength, e.target.get("value").length);
		if( e.target.get("value").length > this.maxlength && e.keycode != 46 && e.keycode != 8 ){
			mop.util.stopEvent( e );
			alert( "The maximum length this field allows is " + this.maxlength + " characters");
		}
	},

	buildControls: function(){

		var formControls = new Element( "div", { "class" : "ipeControls" } );
		// setting the text as html, as this allows us to style the type or use a background image via css.
		this.okButton = new Element( "a", {
			"class": "icon submit",
			"html": "<span>submit</span>",
			"href": "#",
			"events": {
				"click": this.submit.bind( this )
			}
		}).inject( formControls );

		this.cancelButton = new Element( "a", {
			"class": "icon cancel",
			"html" : "<span>cancel</span>",
			"href": "#",
			"events": {
				"click": this.cancelEditing.bind( this )
			}
		}).inject( formControls );

		formControls.inject( this.form );
		
		return formControls;

	},

	formatForEditing: function( aString ){
		return aString.replace	( /<br( ?)(\/?)>/g, "\n" ); 
	},

	getValue: function(){
		return ( this.field )? this.field.get( "value" ) : this.ipeElement.get( "html" );
	},

	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	setValue: function( aValue ){
		if( this.field ) this.field.set( "value", aValue );
		this.ipeElement.set( "html", aValue );
	},

	showSaving: function(){
		this.mode = "saving";
		this.ipeElement.removeEvents();
		this.ipeElement.set( "html", '<img class="icon" src="modules/cms/views/images/spinner.gif" width="12" height="12" alt="working..." /> saving');//'&hellip;' );
		mop.util.EventManager.broadcastEvent("resize");
	},


	onResponse: function( txt, json ){
//		console.log( this.fieldName, "ipe.onResponse ", '\n\t',txt, '\n\t', json );
		this.destroyValidationSticky();
		
		var json = JSON.decode( json );

		this.ipeElement.addEvent( 'click', this.enterEditMode.bindWithEvent( this ) );
		this.ipeElement.setStyle( "height", "auto" );

		if( json && json.error ){
			this.validationSticky = new mop.ui.Sticky( this, { title: "Error:", message: json.message, scrollContext: this.options.scrollContext } );
			this.validationSticky.show();
			this.ipeElement.set( "text", this.submittedValue );
			this.field.set( "value", this.submittedValue );
			this.enterEditMode();
			this.field.focus();
			this.field.select();
		}else{
			if( this.field && this.field.get( "type" ) == "password" ){
				this.ipeElement.set( "html", "******" );
			}else{
				this.ipeElement.set( "html", json.value );
			}
			this.oldValue = json.value;
			if( this.onCompleteCallbacks.length > 0 ){
				for( var i = 0; i < this.onCompleteCallbacks.length; i++ ){
					this.onCompleteCallbacks[i]( json, this );
				}
			}
		}
		json = null;			
		mop.util.EventManager.broadcastEvent("resize");
	},

	cancelEditing: function( e ){

		mop.util.stopEvent( e );

		if( this.oldValue ){
			this.ipeElement.set( "text", this.oldValue );
		}else{
			this.ipeElement.set("text", "" );			
		}
		this.leaveEditMode();
	},

	leaveEditMode: function(){

		this.mode = "resting";

		if( this.form ) this.form.setStyle("display","none");

		if( this.field ) this.field.removeEvents();

		if( this.marshal.resumeSort ) this.marshal.resumeSort();

		this.ipeElement.setStyle( "display", "block" );
		
		this.destroyValidationSticky();
		
		mop.util.EventManager.broadcastEvent("resize");

	},

	destroy: function(){
		delete this.oldValue;
		delete this.submittedValue;
		this.clickEvent = null;
		this.ipeElement.eliminate( "Class" );
		this.ipeElement.destroy();
		this.leaveEditMode();
		this.parent();
	}
	
});



/*
 @description		MooTools based iPhonesque switch button
 @author			Marcel Miranda Ackerman < reaktivo.com >
 @license 			MIT Style License.
 @version			0.5
 @date				2008-04-02
 @modified to only look inside its own element by thiagodemellobueno at madeofpeople july 27 2009
 @dependencies		mootools 1.2b
*/

mop.ui.MooSwitch = new Class({
	
	type: "switch",
	Extends: Drag.Move,
	isVirgin: true,
	
	initialize: function( radios, options ){
		options = options || [];
		this.duration = options.duration || 100;
		this.hide_radios = (options.hide_radios ) ? options.hide_radios : true;
		this.hide_labels = (options.hide_labels ) ? options.hide_labels : false;
	
		this.onChangeHandler = ( options.onChange ) ? options.onChange : null;
//	console.log("MOOSWITCH ", this.onChangeHandler, options.onChange );
		this.label_position = (options.label_position ) ? options.label_position : 'outside';
		this.drag_opacity = (options.drag_opacity ) ? options.drag_opacity : 1;
		this.mouse_over_handle = false;

		this.is_dragging = false;
		
		if(this.label_position == 'outside' && options.label_bg == undefined){
			this.label_bg = 'light';
		}else{
			this.label_bg = (options.label_bg != undefined) ? options.label_bg : 'dark';
		}
		
		this.mvalue = 0;
		
		//Create Elements
		this.container = new Element('div', {'class':'switchbox'});
		this.scrollarea = new Element('div', {'class':'scrollarea'}).inject(this.container);
		
		this.handle = new Element('div', {'class':'handle'}).inject(this.scrollarea);
		var duration = duration || this.duration;

		this.handle.set( 'morph', { duration:duration } );
		
		this.handle.setStyle( 'z-index', 1 );
		this.left_label = new Element( 'div', { 'class':'label left' } ).inject( this.container );
		this.right_label = new Element( 'div', { 'class':'label right' } ).inject( this.container );
		this.labels = this.container.getElements('.label');
		
		//Hide Radioboxes and Labels//
		this.radio_el = radios;//this.element.getElements('input[name='+radios+']');
//		console.log( ":::: ", this.radio_el );
		this.container.inject( this.radio_el[ this.radio_el.length - 1 ], 'after');
		
		if(this.label_bg == 'light') this.labels.addClass('light_bg');
		if(this.label_position=='outside'){
			this.container.setStyle('width', this.left_label.getStyle('width').toInt() + this.scrollarea.getStyle('width').toInt() + this.right_label.getStyle('width').toInt());
			this.scrollarea.setStyle('left', this.left_label.getStyle('width').toInt());
			this.scrollarea.setStyle('cursor', 'pointer');
			this.scrollarea.addEvent('click', function(){
				if(!this.mouse_over_handle) {
					this.mvalue = ( this.mvalue == 0 )? 1 : 0;
					this.goTo(this.mvalue);
				}
			}.bind(this));
		}else{
			this.container.setStyle('width', this.scrollarea.getStyle('width').toInt());	
		}
		
		this.maxscroll = this.scrollarea.getStyle('width').toInt() - this.handle.getStyle('width').toInt();
		

		this.radio_el.each( function( item, index ){
			
			if(this.hide_radios) {
				item.setStyle('display', 'none');
				var label = this.element.getElement('label[for=' + item.get('id') + ']');
				if( label ) label.setStyle('display', 'none');
			}
			
			if( item.get( "checked" ) ){
				this.goTo( index );
			}
			
			var opttext = this.element.getElement('label[for=' + item.get('id') + ']').get('text');
			this.container.getElements('.label')[index].set('text', opttext);
		}, this );
		
		//Execute Drag.Move initialize function
		this.parent( this.handle, {

			container: this.scrollarea,

			onStart: function (){
				this.is_dragging = true;
				this.handle.morph( { 'opacity': this.drag_opacity } );
			},

			onComplete: function (){
				if(this.handle.getStyle('left').toInt() < this.maxscroll*.5){
					this.goTo(1);
				}else{
					this.goTo(0);
				}
			}

		});
				
		//Set Events
		this.left_label.addEvent('click', this.goTo.bind( this, 1 ) );
		this.right_label.addEvent('click', this.goTo.bind(this, 0 ) );
		
		this.handle.addEvent('mouseover', function(){
			this.mouse_over_handle = true;
		}.bind(this));
		
		this.handle.addEvent('mouseout', function(){
			this.mouse_over_handle = false;
		}.bind(this));
		
		if(this.hide_labels){
			this.labels.setStyle('display', 'none');
		}
	},
	
	toString: function(){
		return "[object, MooSwitch ]";
	},
	
	activate: function(){
		this.goTo( 0 );		
	},
	
	deActivate: function(){
		this.goTo( 1 );
	},
	
	goTo: function( value ){
		var cursor = (value ==1 ) ? 'e-resize' : 'w-resize';
		this.handle.setStyle('cursor', cursor);

//		console.log("MooSwitch value ... ", value );

		if( !this.isVirgin ){
			this.onChangeHandler( ( value == 1 )? 0 : 1 ); 
		}else{ this.isVirgin = false; }

//		this.mvalue = value;

		// this.radio_el.set( "checked", true )

		this.handle.morph({
			'left' : ( value == 0 )? this.maxscroll : 0,
			'opacity' : 1
		});

	}
});

mop.ui.SlideSwitch = new Class({
	Extends: mop.ui.MooSwitch,
	type: "switch",

	
	initialize: function( anElement, aMarshal, options ){
		this.element = anElement;
//		console.log( ":::: MOOSWITCH HTML ", anElement, aMarshal, options, this.element.get( "html" ) );
		this.marshal = aMarshal;
		this.radios = anElement.getElements( "input[type='radio']" );
		this.parent( this.radios, options );
	}
	
});


mop.ui.ScrollableTable = new Class({
	
	initialize: function( anElement, aMarshal ){
		this.element = anElement;
		this.table = anElement.getElement( "table" );
		this.tableSize = this.table.getSize();
		this.browser = { version: Browser.Engine.version, name: Browser.Engine.name };
//		console.log( "Browser: ", this.browser );
		var newWidth = this.tableSize.x - 16;
		this.element.setStyles({
			"overflow": "auto",
			"width": newWidth
		});
		this.setUpTableHead();
 		this.setUpTableBody();
	},
	
	isBrowserIe6orLower: function(){
//		console.log( "isBrowserIe6orLower", ( this.browser.name.indexOf( "trident" ) && this.browser.version < 7 ) );
		return( this.browser.name.indexOf( "trident" ) && this.browser.version < 7 );
	},
	
	setUpTableHead: function(){
		this.table.getElement( "thead" ).getChildren( "tr" ).each( function( aTr, index ){
				aTr.setStyle( "position", "relative" );
		}, this );
	},
	
	destroy: function(){
		delete this.browser;
		this.browser = this.element = this.table = this.tableSize = null;
	}
	
});

mop.ui.PaginationControls = new Class({
	
	pages: [],
	
	cachePages: false,
	
	method: "pagination",

	currentPage: 1,
	
	initialize: function( anElement, aMarshal ){
		
		
		this.element = $( anElement );
		this.instanceName = this.element.get( "id" );
		this.element.store( "Class" );
		this.marshal = ( aMarshal )? aMarshal : $( this.element.get("id").subString( 0, this.element.get("id").indexOf("_pagination") ) );
		this.container = ( this.marshal.element.getElement( ".container" ) )? this.marshal.element.getElement( ".container" ) : this.marshal.element;
		this.cachePages = ( mop.util.getValueFromClassName( "cachePages", this.element.get( "class" ) ) == "true" )? true : false;
//		console.log( this.toString(), "initialize", anElement, this.marshal );
		this.build();

	},
	
	build: function(){
		
		if( this.getPaginationItemElement().get( "id" ) ){
			var idArr = this.getPaginationItemElement().get( "id" ).split("_");
			idArr.splice( idArr.length - 1, 1 );
			this.itemIdPrefix = idArr.join("_");
		}
		
		this.spinner = this.element.getElement(".spinner");

		this.listId = mop.util.getValueFromClassName( "listId", this.element.get( "class" ) );
		this.totalPages = mop.util.getValueFromClassName( "totalPages", this.element.get( "class" ) );

		if( this.element.getElement( ".pagingLeft" ) ) this.previousPageControl = this.element.getElement( ".pagingLeft" ).addEvent( "click", this.previousPage.bindWithEvent( this ) );
		if( this.element.getElement( ".pagingRight" ) ) this.nextPageControl = this.element.getElement( ".pagingRight" ).addEvent( "click", this.nextPage.bindWithEvent( this ) );

	},
	
	getPaginationItemElement: function(){
		return this.container.getElement(".paginationItem");
	},
	
	getPageableItems: function(){
		return this.container.getElements(".paginationItem");		
	},
	
	toString: function(){
		return "[ Object, mop.ui.PaginationControls ]";
	},
	
	nextPage: function( e ){
		mop.util.stopEvent( e );
//		console.log( this.toString(), "nextPage", e );
		this.currentPage ++;
		if( this.currentPage == this.totalPages ){
			this.nextPageControl.addClass( "hidden" );
		};
		this.previousPageControl.removeClass("hidden");
		this.paginate();
	},
	
	previousPage: function( e ){
		mop.util.stopEvent( e );
		this.currentPage --;
		if( this.currentPage == 1 ){
			this.previousPageControl.addClass( "hidden" );
		};
		this.nextPageControl.removeClass( "hidden" );
		this.paginate();
	},

	paginate: function(){
//		console.log( "this.cachePages", this.cachePages );
		if( this.pages[ this.currentPage ] && this.cachePages ){
			var newChildren = this.buildItems( this.pages[ this.currentPage ] );
			this.clearElements( this.getPageableItems() ); 
			this.container.adopt( newChildren );
			//this.container.adopt( this.pages[ this.currentPage ] );
//			console.log( "Page Cached... send JSON", this.toString(), "paginate", "this.pages[ this.currentPage ]", this.pages[ this.currentPage ] );
			if( this.marshal && this.marshal.initList ) this.marshal.initList();
		}else{
			this.spinner.removeClass( "hidden" );
			var marshalId = ( this.marshal.instanceName )? this.marshal.instanceName : this.marshal.get("id");
			var url = mop.getAppURL() + marshalId + "/ajax/" + this.method + "/" + this.listId + "/" + this.currentPage;
			var postData = ( this.marshal.getPaginationPostData )? this.marshal.getPaginationPostData() : null ; //getGeneratedDataQueryString() : null;
//			console.log( this.toString(), "paginate uncached page >> ", url, postData );
			mop.util.JSONSend( url, postData, { onComplete: this.onPagination.bind( this ) } );
		}
	},
	
	clearElements: function ( contents ){
		contents.each( function( anElement, index ){
			var item = anElement.retrieve( "Class" );
			if( item ) item.destroy();
			anElement.destroy();
		});
	},
	
	onPagination: function( array, json ){
		this.spinner.addClass( "hidden" );

		var contents = this.getPageableItems();
		var newChildren = this.buildItems( json );

		this.clearElements( contents );

		this.pages[ this.currentPage ] = json;//newChildren;

//		console.log( "\n\t", this.toString(), "onPagination", newChildren, this.pages[ this.currentPage ] );
		this.container.adopt( newChildren );

		if( this.marshal && this.marshal.initList ){ this.marshal.initList(); }
	},
	
	buildItems: function( json ){
//		console.log( this.toString(), "buildItems", json );
		json = JSON.decode( json );
		var newItems = [];
		json.each( function( aNode, anIndex ){
//			console.log("anIndex", anIndex );
			newItems.push( this.buildItem( aNode, anIndex ) );
		}, this );
		return newItems;
	},
	
	buildItem: function( json, anIndex ){
//		console.log( this.toString(), "buildItem", anIndex, this.marshal, json );
		var clone = this.getPaginationItemElement().clone();//true );
		if( this.getPaginationItemElement().get( "id" ) ) clone.set( "id", this.itemIdPrefix + "_" + json.id );
		
		var jsonHash = new Hash( json );
		// this will only work for simple structures, what about files and other more complex structures... how do we spec json for that ie, ids and className-based settings inside files? loop through it? Maybe html is better?
		// for more complex structure pagination needs to know what the UNIT tag is (or class) in order to call its instantiation...
		jsonHash.each( function( value, key ){
			var node = clone.getElement( "." + key );
			if( node ) node.set( "text", value );
		});
		if( anIndex%2 != 0 ) clone.addClass("alternate");
		return clone;
	},
	
	setCurrentPage: function( aValue ){
		this.currentPage = aValue;
	},
	
	destroy: function(){
		
		this.element.eliminate( "Class" );

		this.nextPageControl.destroy();
		this.previousPageControl.destroy();
		this.element.destroy();
		
		if( this.elementToClone ) this.elementToClone.destroy();
		
		delete	this.element; 
		delete	this.instanceName;
		delete	this.itemIdPrefix;
		delete	this.elementToClone;	   
		delete	this.nextPageControl;   
		delete	this.previousPageContro;
		delete	this.pageableElement;   
		delete	this.method;			   
		delete	this.container;		   
		delete	this.spinner;		   
		delete	this.marshal;		   
		delete	this.listId;			   
		delete	this.pages;			   
		delete	this.container;		   
		delete	this.currentPage; 	   
		delete	this.pageableElement;   
		delete	this.totalPages;

		this.element		 	= null;
		this.instanceName	 	= null;
		this.itemIdPrefix	 	= null;
		this.elementToClone		= null;
		this.nextPageControl	= null;
		this.previousPageControl= null;
		this.pageableElement 	= null;
		this.method				= null;
		this.container		 	= null;
		this.spinner		 	= null;
		this.marshal		 	= null;
		this.listId			 	= null;
		this.pages 			 	= null;
		this.container		 	= null;
		this.currentPage 	 	= null;
		this.pageableElement 	= null;
		this.totalPages 		= null;

	}

});
