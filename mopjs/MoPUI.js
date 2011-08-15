mop.ui = {};
mop.ui.navigation = {};

Element.implement({
	roundCorners: function( radius ){
		var borderStyle;
		if( Browser.safari && Browser.version < 5 ){ borderStyle = "-webkit-border-radius"; }else if( Browser.firefox && Browser.version < 4 ){ borderStyle = "-moz-border-radius"; }else{ borderStyle = "border-radius"; }
		if( (Browser.ie && Browser.version >= 9) || !Browser.ie  ) this.setStyle( borderStyle, radius + "px" );
	},
	addBoxShadow: function( shadow ){
		/*
			reffer to http://www.css3.info/preview/box-shadow/
		*/
		var styles = ( shadow )? shadow: '1px 1px 3px #999';
		var styleName;
		if( Browser.safari && Browser.version <= 5 ){ styleName = "-webkit-box-shadow"; }else if( Browser.firefox && Browser.version < 4 ){ styleName = "-moz-box-shadow"; }else{ styleName = "box-shadow"; }
		if( (Browser.ie && Browser.version >= 9) || !Browser.ie ){
			this.setStyle( styleName, styles );
		}
	}
});

mop.ui.UIField = new Class({

  Extends: mop.MoPObject,
	Implements: [ Options, Events, mop.util.Broadcaster ],

	fieldName: null,
	validationSticky: null,
	
	options: {
	    autoSubmit: true,
	    enabled: true,
	},

	/* Section: getters / setters */
	getValue: function(){
		throw "UIField Abstract method getValue must be overridden in" + this.toString();
	},

	setValue: function(){
		throw "UIField Abstract method setValue must be overridden in" + this.toString();
	},
	
	disableElement: function(){
		this.enabled = false;
		this.element.addClass( "disabled" );
	},
	
	enableElement: function(){
		this.enabled = true;
		this.element.removeClass( "disabled" );
	},

	setTabIndex: function( val ){
		if( this.field ) this.field.set( 'tabindex', val );
	},
	
	/*Constructor*/
	initialize: function( anElement, aMarshal, options ) {
		this.parent( anElement, aMarshal, options );
//	console.log( ":::::::", this.options, anElement.get( 'class' ) );
		this.fieldName = this.options.field;
		if( !this.fieldName ) throw ( "ERROR", this.toString(), "has no fieldName, check html class for field-{fieldName}" );	
	},
	
	toString: function(){
		return "[ object, mop.ui.UIField ]";
	},
	
	onResponse: function( json ){
//		console.log( "RESPONSE", json );
		if( !json.returnValue || !json.response ){
			throw json;
		}else if( json.response.error ){
			this.showValidationError( json.response.message );
		}else{
			this.onSaveFieldSuccess( json.response );
		}
	},

	onSaveFieldSuccess: function( response ){
		this.broadcastMessage( 'uifieldsaveresponse', [ this.fieldName, response ] );
	},
	
	showValidationError: function( errorMessage ){
		this.destroyValidationSticky();
		this.validationSticky = new mop.ui.Sticky( this.element, {
			content: "<p>Error: " + errorMessage + "</p>",
			position: 'centerTop',
			edge: 'centerBottom',
			tick: 'tickBottom',
			stayOnBlur: true
		});
		this.validationSticky.show();
		console.log('showValidationError', this.validationSticky );
	},
	
	destroyValidationSticky: function(){
		if( !this.validationSticky ) return;
		this.validationSticky.destroy();
		this.validationSticky = null;
	},
		
	submit: function( e ){
		mop.util.stopEvent( e );
		var val = this.getValue();
		this.submittedValue = val;
		if( !this.options.autoSubmit ){
			this.setValue( val );
			return true;
		}		
		if( this.showSaving ) this.showSaving();
		if( this.leaveEditMode ) this.leaveEditMode();
		this.marshal.saveField( { field: this.fieldName, value: val }, this.onResponse.bind( this ) );
	},	

	destroy: function(){
//		console.log( ">>>> ", this.fieldName, "destroy!" );
		this.fieldName = null;	
		this.parent();
	}
	
});

mop.ui.Sticky = new Class({
    
	Implements: [ Options, Events ],

	target: null,
	element: null,
	content: null,
	morph: null,
	showInterval: null,
	hideInterval: null,
	options: {
		ignoreMargins: true,
		offset: { x: 0, y: 0 },
		relFixedPosition: false,
		position: 'upperRight',
		edge: 'lowerLeft',
		tick: 'tickLeft',
		stayOnBlur: false,
		boxShadow: '1px 1px 2px #888888'
	},

	initialize: function( attachTo, options ){
		this.setOptions( options );
		this.target = attachTo;
		this.build();
		return this;
	},
    
	build: function(){
		this.element = new Element( 'div.sticky' );
		this.element.addClass( this.options.tick );
		this.content = new Element( 'div.content.clearFix' );
		if( this.options.content && typeof this.options.content == 'string' ){
			this.content.set( 'html', this.options.content );
		}else if( this.options.content ){
			this.content.adopt( this.options.content );			
		}
		if( this.options.cssClassses ) this.element.addClass( this.options.cssClassses );
		this.mouseenter = this.target.addEvent( 'mouseenter', this.startShow.bindWithEvent( this ) );
		if( !this.options.stayOnBlur ) this.mouseleave = this.target.addEvent( 'mouseleave', this.startHide.bindWithEvent( this ) );
		
		// the sticky isn't inside the target
		this.element.addEvent( 'mouseenter', function( e ){ clearTimeout( this.hideInterval ) }.bind( this ) );
		// we may want to pass methods for when the mouse/enter leaves control (say disable submit on blur on ipes );
		if( this.options.mouseEnter ) this.element.addEvent( 'mouseenter', this.options.mouseEnter )
		if( this.options.mouseLeave ) this.element.addEvent( 'mouseleave', this.options.mouseLeave );
		
		if( !this.options.stayOnBlur ) this.element.addEvent( 'mouseleave', this.startHide.bindWithEvent( this ) );
		this.element.adopt( this.content );
		this.populate( this.options.content );
		this.morph = new Fx.Morph( this.element, { duration: 250, transition: Fx.Transitions.Quad.easeOut } );
		$(document.body).adopt( this.element );
		if( this.options.borderRadius ) this.content.roundCorners( this.options.borderRadius );		
		if( this.options.boxShadow ) this.content.addBoxShadow();
		this.position();
	},

	position: function(){
		this.element.position({
			relativeTo: this.target,
			offset: this.options.offset,
			position: this.options.position,
			edge: this.options.edge,
			relFixedPosition: this.options.relFixedPosition
		});
	},
	
  populate: function( content ){ this.content.adopt( content ); },
	
  startShow: function( e ){
		mop.util.stopEvent( e );
		clearTimeout( this.showInterval );
		clearTimeout( this.hideInterval );
		this.showInterval = this.show.delay( 350, this );	
	},
	
	startHide: function( e ){
		mop.util.stopEvent( e );
		clearTimeout( this.showInterval );
		clearTimeout( this.hideInterval );
		this.hideInterval = this.hide.delay( 350, this );
	},
	
	show: function(){ 
		if( this.morph ){
			this.morph.cancel();
			this.morph.start( { 'opacity' : 1 } );
		}
	},

	hide: function(){
		if( this.morph ) this.morph.cancel();
		this.morph.start( { 'opacity' : 0 } );
	},
    
	destroy: function(){
		this.element.destroy();
		this.morph.cancel();
		if( this.showInterval ) clearTimeout( this.showInterval );
		if( this.hideInterval ) clearTimeout( this.hideInterval );
		if( this.mouseenter ) this.target.removeEvent( 'mouseenter', this.mouseenter );
		if( this.mouseleave ) this.target.removeEvent( 'mouseleave', this.mouseleave );
		this.element = this.content = this.options = this.target = this.morph = this.mouseenter = this.mouseleave = this.showInterval = this.hideInterval = null;
	}
    
});

/*
	Class: mop.ui.navigation.Tabs
	Generic helper for handling tabbed navigation
	Simply takes an collection of elements with the passed selector from the passed element, and returns a reference of the clicked element to the callback function.
	More generic than tabs for sure, but what to call? Buton collection?
*/
mop.ui.navigation.Tabs = new Class({
	
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
	
	initialize: function( anElement, onCrumbClickedCallback ){
		this.element = anElement;
		this.onCrumbClickedCallback = onCrumbClickedCallback;
		// console.log( "BreadCrumbTrail", this, this.element );
	},
	
	toString: function(){
		return "[ object, mop.ui.BreadCrumbTrail ]";
	},

	clearCrumbs: function( anIndex ){
		var crumb = this.element.getChildren( "li" )[ anIndex ];
		if( crumb ){
			subsequentCrumbs = crumb.getAllNext();
			crumb.destroy();
			subsequentCrumbs.each( function( aCrumb ){ aCrumb.destroy(); } );
		}
	},

	addCrumb: function( obj ){
		var newCrumb = new Element( "li" ).adopt( new Element( "a", { "text": obj.label, "events":{ "click": this.onCrumbClicked.bindWithEvent( this, obj ) } } ) );
		newCrumb.store( 'data', obj );
		this.element.getElement("ul").adopt( newCrumb );
	},
	
	getCrumbs: function(){
		return this.element.getElements('li');
	},
	
	onCrumbClicked: function( e, obj ){
		mop.util.stopEvent( e );
//		console.log( "::::: \t onBreadCrumbClicked", obj );
		this.onCrumbClickedCallback( obj );
	},
	
	removeCrumbs: function( crumbs ){
		crumbs.each( function( aCrumb ){
			aCrumb.destroy();
		});
	},
	
	destroy: function(){
		this.element = null;
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
	},

	getActiveModal: function(){
		return this.activeModal;
	},
	
	clearActiveModal: function(){
		this.activeModal = this.getPreviousModal();
	},
	
	getScroll: function(){
		var returnVal =  ( this.activeModal )? this.activeModal.element.getScroll() : window.getScroll();
//		console.log( this.toString(), "getScroll", returnVal );
		return returnVal;
	},

	removeModal: function( aModal ){
		aModal.destroy();
		this.modals.erase( aModal );
		if( this.activeModal == aModal ) this.activeModal = this.getPreviousModal();
		if( !this.activeModal ) $( document ).getElement("body").setStyle( "overflow", "auto" );
		aModal = null;
	},
	
	getPreviousModal: function(){
		return this.modals[ this.modals.length - 1 ];
	}

});


/*	Class: mop.ui.Sortable
	Simply an extension of the mootools sortable adds a marshal reference, and a scroller instance as well as some callbacks
*/
mop.ui.Sortable = new Class({
  
	Implements: Options,
	Extends: Sortables,	

	initialize: function( anElement, marshal, scrollerTarget ){
//	    console.log( ":: mop.ui.Sortable", anElement, marshal, scrollerTarget );
		this.marshal = marshal;
		this.element = $( anElement );
		this.parent( anElement, {
			clone: true,
			snap: 12,
			revert: true,
			velocity: .9,
			area: 24,
			constrain: false,
			onComplete: function( droppedItem ){
				this.isSorting = false; 
				this.scroller.stop();
				this.marshal.onOrderChanged( droppedItem );
			},
			onStart: function(){
				this.isSorting = true; 
				this.scroller.start();
			},
			onSort: function( droppedItem, ghostItem ){
				//@TODO: make it so that elements cant be dragged below unsortable elements (.modules in navi for example );
				/* requires some heavy code, must compare position against some 'upperlimit' and somehow put things back together */
			}
	 	});
	 	var scrollerElement = ( typeOf( scrollerTarget ) != "element" )? $( document.body ) : scrollerTarget;
		this.scroller = new Scroller( scrollerElement, { area: 20, velocity: 1 } );
	}
});


/*
	Class: mop.ui.Modal
	A lightweight modal class
*/
mop.ui.Modal = new Class({
		
		Implements: [ Events, Options ],
		
		element: null,
		marshal: null,
		modalAnchor: null,
		modal: null,
		header: null,
		headerControls: null,
		title: null,
		container: null,
		footer: null,
		footerControls: null,
		hideTransition: null,

		options: {
			fadeDuration: 300,
			confirmText: 'Confirm',
			cancelText: 'Cancel'
		},

		setTitle: function( aString ){ this.title.set( "text", aString ); },

		initialize: function( aMarshal, options ){
			this.setOptions( options );
			this.marshal = aMarshal;
			this.build();
			this.modalAnchor.setStyles({ "useHandCursor":false });
			this.modalAnchor.set( 'href', "#" );
			this.modalAnchor.addEvent( "click", function( e ){ mop.util.stopEvent(e); } );
			this.showTransition = new Fx.Morph( this.element, { 
				property: "opacity",
				duration: this.options.fadeDuration,
				transition: Fx.Transitions.Quad.easeInOut,
				onStart: function(){
					this.element.setStyles( {
						'display': 'block',
						'opacity': '0' 
					});
				}
			});
			this.hideTransition = new Fx.Morph( this.element, { 
				property: "opacity",
				transition: Fx.Transitions.Quad.easeInOut,
				duration: this.options.fadeDuration
			});

		},
		
		spin: function(){
			console.log( 'spin', this.container, this.container.get( 'spinner') );
			this.modal.show();
		},
		
		unSpin: function(){			
			this.modal.unspin();
		},
		
		build: function(){
			console.log(":::::::::::::::::::::::::::::::::::::::::::");
			this.element = new Element( "div", { "class": "modalContainer hidden" });
			this.modalAnchor = new Element( "a", {
				'class': 'modalAnchor',
				'href': '#',
				'events': { 'click' : function( e ){ 
					mop.util.stopEvent( e );
				}.bindWithEvent( this ) }
			}).inject( this.element );
			this.modal = new Element( "div", { "class": "modal container_12" }).inject( this.element );
			this.header = new Element( "div", { 'class': 'header container_12' }).inject( this.element );
			this.title = new Element( "h3.title" ).inject( this.header );
			this.container = new Element( "div.content" ).inject( this.modal );
			this.footer = new Element( "div.footer" ).inject( this.modal );
			this.initControls();
			$(document).getElement("body").adopt( this.element );
		},
		
		initControls: function(){
			var headerCancel, footerCancel;
			this.headerControls = new Element( "div", { "class" : "controls clearFix" } );
			this.footerControls = this.headerControls.clone();
			headerCancel = new Element( 'a', {
				'class' : 'icon cancel',
				'title': this.options.cancelText, 
				'href' : 'cancel',
				'events': {
					"click": this.cancel.bindWithEvent( this )
				} 
			});
			this.headerControls.adopt( headerCancel );
			footerCancel = headerCancel.clone();
			footerCancel.cloneEvents( headerCancel );
			this.footerControls.adopt( footerCancel );
			this.header.adopt( this.headerControls );
			this.footer.adopt( this.footerControls );
		},

		toString: function(){ return "[ object, mop.ui.Modal ]"; },
		
		show: function(){
			console.log( "show" );
			this.element.setStyle( "opacity", 0 );
			this.element.removeClass("hidden");
			this.showTransition.start( { "opacity": 1 } );
		},

		close: function( onComplete ){
			this.hideTransition.cancel();
			this.hideTransition.start({
				onComplete: function(){
					if( onComplete ) onComplete();
					mop.modalManager.removeModal( this );
				}.bind( this )
			});
		},
		
		cancel: function( e ){
			mop.util.stopEvent( e );
			if( this.options.onCancel ) this.options.onCancel();
			this.close();
		},
				
		loadTab: function( aTab ){
			this.container.empty();
			this.container.spin();
			this.setTitle( aTab.get( "title" ), "loading..." );
			return new Request.JSON( { url: aTab.get( "href" ), onSuccess: this.onTabLoaded.bind( this ) } ).send();
		},

		onTabLoaded: function( json ){
			this.modal.get('spinner').hide();
			this.setContent( json.html );
		},

		setContent: function( someContent, aTitle ){
			if( aTitle ) this.setTitle( aTitle );
			this.container.unspin();
			if( typeof someContent == "string" ){
				this.container.set( "html", someContent );
			}else{
				this.container.adopt( someContent );
			}
		},
		
		getScrollOffset: function(){ return this.element.getScroll(); },

		destroy: function(){
			if( this.element ) this.element.destroy();
			this.element = this.modalAnchor = this.modal = this.header = this.headerControls = this.title = this.container = this.footer = this.footerControls = this.marshal = this.hideTransition = this.showTransision = null;
		}		

});


mop.ui.AddObjectDialogue = new Class({
	
	Extends: mop.ui.Modal,
	Implements: Options,
	
	options: {
		onConfirm: function(){},
		onCancel: function(){},
		confirmText: "Add Object",
		cancelText: "Cancel"
	},
	
	initialize: function( aMarshal, options ){
		this.parent( aMarshal, options );
	},
	
	toString: function(){ return "[ Object, mop.ui.Modal, mop.ui.AddObjectDialogue ]"; },
		
	initControls: function(){
		var headerSubmit, footerSubmit;
		this.parent();
		headerSubmit = new Element( "a", { 
			'class' : 'icon submit',
			'href' : 'submit',
			'title': this.options.confirmText,
			'events':{
				'click': this.submit.bindWithEvent( this )
			}
		});
	  footerSubmit = headerSubmit.clone();
		footerSubmit.cloneEvents( headerSubmit );
		this.headerControls.grab( headerSubmit, 'top' );
		this.footerControls.grab( footerSubmit, 'top' );
	},
	
	setContent: function( itemToAdd, aTitle ){
		console.log( itemToAdd, aTitle );
		if( aTitle ) this.title.set( "text", aTitle );
		this.modal.unspin();
		this.itemContainer = new Element( "ul" );
		this.container.empty();
		this.container.adopt( this.itemContainer );
		this.itemContainer.adopt( itemToAdd );
		if( this.element.getScrollSize().y <= this.element.getSize().y ){
//			this.header.setStyle( "margin-left", parseInt( this.header.getStyle( "margin-left" ) ) + 7 );
		}
		this.itemInstance = itemToAdd.retrieve("Class");
		return itemToAdd;
	},
	
	submit: function( e ){		
		mop.util.stopEvent( e );		
		this.close( function(){
			this.itemInstance.element.setStyle( "opacity", 0 );
			this.marshal.insertItem( this.itemInstance );
		}.bind( this ) );
		if( this.options.onConfirm ) this.options.onConfirm();
	},

	cancel: function( e ){
		mop.util.stopEvent( e );
		this.close( this.itemInstance.removeObject.bind( this.itemInstance ) );
	},
	
	destroy: function(){
		this.itemInstance = null;
		this.parent();
	}
	
});

mop.ui.InactivityDialogue = new Class({

	Extends: mop.ui.Modal,
	Implements: Options,
	message: null,
	
	initialize: function( aMarshal, options ){
		this.setOptions( options );
		this.parent( aMarshal, options );
	},

	build: function(){
		this.parent();
		this.message = new Element( 'p', { 'class': 'logoutMessage'  } );
		this.container.adopt( this.message );
		console.log( "::", this.container );
	},
	
	setMessage: function( msg ){
		console.log( 'setMessage', this.container, this.message, msg );
		this.message.set( 'html', msg );
	},
	
	initControls: function(){
		var headerSubmit, footerSubmit, headerCancel, footerCancel;
		this.headerControls = new Element( "div", { "class" : "controls clearFix" } );
		this.footerControls = this.headerControls.clone();
		footerSubmit = new Element( 'a', {
			'class' : 'button submit',
			'title': this.options.confirmText, 
			'href' : 'submit',
			'text' : this.options.confirmText,
			'events': {
				"click": this.submit.bindWithEvent( this )
			} 
		}).inject( this.footerControls );
		footerCancel = new Element( 'a', {
			'class' : 'button cancel',
			'title': this.options.cancelText, 
			'href' : 'cancel',
			'text' : this.options.cancelText,
			'events': {
				"click": this.cancel.bindWithEvent( this )
			} 
		}).inject( this.footerControls );
		this.footer.adopt( this.footerControls );
	},
	
	submit: function( e ){		
		mop.util.stopEvent( e );		
		this.close();
		if( this.options.onConfirm ) this.options.onConfirm();
	}

});

mop.ui.MultiSelect = new Class({
	
	Extends: mop.ui.UIField,
	
	options: {
	    firstIsNull: false
	},
	
	initialize: function( anElement, aMarshal, options ){		
		this.parent( anElement, aMarshal, options );
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
	    if( e && ( e.target == this.multiBox || this.multiBox.contains( e.target ) ) ) return;
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

			if( this.options.firstIsNull ){

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
//		console.log( 'updateAndClose', e, e.target, this.multiBox, this.multiBox.contains( e.target ) );
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

/*	Class: mop.ui.DatePicker
*/

mop.ui.DatePicker = new Class({

	Extends: mop.ui.UIField,
	
	options: {
	    allowEmpty: false,
	    format: "%Y/%m/%d"
	},
		
	initialize: function( anElement, options ){
//		console.log( this.toString(), "initialize", anElement, options );
		this.parent( anElement, options );
		this.dateField = this.element.getElement("input");
	    this.buildPicker();
	},
	
    
	toString: function(){
		return '[ object, mop.ui.UIField, mop.ui.DatePicker ]';
	},
	
	buildPicker: function(){ 
	    console.log( "a", this.dateField );
		this.picker = new Picker.Date( this.dateField, {
			elementId: "datePickerFor_" + this.fieldName,
			startView: "month",
			format: this.options.format,
			allowEmpty: this.options.allowEmpty,
            onSelect: this.onSelect.bindWithEvent( this  ),
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
	    return this.options.format;
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
	
	toString: function(){
		return '[ object, mop.ui.UIField, mop.ui.DatePicker, mop.ui.TimePicker ]';
	},
		
	initialize: function( anElement, options ){
		this.parent( anElement, options );
	},
	
	buildPicker: function(){
		this.picker = new Picker.Date( this.dateField, {
			elementId: "datePickerFor_" + this.fieldName,
			timePicker: true,
			yearPicker: false,
			startView: "time",
			format: "%I:%M:%S",
			debug: false,
			onSelect: this.onSelect.bindWithEvent( this )
		});
	}
});

/*	Class: mop.ui.DateRangePicker
	Datepicker with two fields, and range validation 
*/
mop.ui.DateRangePicker = new Class({

	Extends: mop.ui.UIField,
		
	options: {
		alerts:{
			endDateLessThanStartDateError : "The end date cannot be earlier than the start date."
		},
		ellowEmpty: false,
		startView: 'month'
	},
	
	initialize: function( anElement, aMarshal ){

		this.parent( anElement, aMarshal );
		
		this.dateFields = this.element.getElements("input");
			
		this.dateFields.each( function( aDateField, index ){
			var opts = {
				elementId: "datePickerFor_" + this.fieldName,
				startView: this.options.startView,
				allowEmpty: this.options.allowEmpty,
				format: "%Y/%m/%d",
				onShow: this.onShow.bind( this ),
				onSelect: this.onSelect.bindWithEvent( this ),
				onClose: function(){},
				index: index
			};
			var picker = new Picker.Date( aDateField, this, opts );
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
//		.get('validator', {serial: true, evaluateFieldsOnBlur: false}).reset();
		this.parent();
	},
	
	toString: function(){
		return "[ object, mop.ui.UIField, mop.ui.DateRangePicker ]";
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

	Extends: mop.ui.UIField,
	
	type: "file",
	
	options:{
		extensions: [ 'jpg', 'png', 'gif', 'pdf', 'doc', 'txt', 'zip' ]
	},
	
	ogInput: null,
	uploadButton: null,
	uploadLink: null,
	uploader: null,
	baseURL: null,
	statusElement: null,
	progressBar: null,
	statusMessage: null,
	previewElement: null,
	filename: null,
	action: null,
	extensions: null,
	sizeLimitMin: null,
	submitURL: null,
	statusShow: null,
	statusHide: null,
	validationError: null,
	invalid: null,
	imagePreview: null,
	imgAsset: null,
	imageFadeIn: null,
	scrollContext: 'window',

	getSubmitURL: function(){
		var url = mop.util.getBaseURL() + "ajax/data/cms/savefile/"+this.marshal.getObjectId()+"/"+this.fieldName;
		console.log( "mop.ui.FileElement : ", this.toString(), "getSubmitURL: ", url );
		return 	url;
	},

	getClearFileURL: function(){
		var url = mop.util.getBaseURL() + "ajax/data/" + this.marshal.instanceName + "/clearField/" + this.marshal.getObjectId() + "/" + this.fieldName;
		return url;
	},

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.ogInput = this.element.getElement( "input[type='file']" );
		this.ogInput.addClass('away');
		this.uploadButton = this.element.getElement( ".uploadButton" );
		this.uploadLink = this.element.getElement( ".uploadLink" );
		this.uploadLink.addEvent( 'click', function( e ){ mop.util.stopEvent( e ) } );
		this.uploadLink.store( "Class", this );
		this.downloadButton = this.element.getElement( ".downloadLink" );
		this.downloadButton.store( "Class", this );
		this.clearButton = this.element.getElement( ".clearImageLink" );
		this.clearButton.store( "Class", this );
		this.clearButton.addEvent( "click", this.clearFileRequest.bindWithEvent( this ) );
		this.uploader = new mop.util.Uploader({
			path: mop.util.getBaseURL() + "lattice/thirdparty/digitarald/fancyupload/Swiff.Uploader3.swf",
			container: this.uploadLink,
			target: this.uploadButton,
			cookie: Cookie.read( 'session' )
		});
		this.ogInput.addEvent( "focus", this.onFocus.bindWithEvent( this ) );
		this.baseURL = mop.util.getBaseURL();
		this.statusElement = this.element.getElement( 'div.status' );
		this.progressBar = this.statusElement.getElement( "img" );
		this.statusMessage = this.statusElement.getElement( "span.message" );
		this.statusShow = new Fx.Morph( this.statusElement, { 
			'duration': 500,
			'onComplete': function(){
				mop.util.EventManager.broadcastMessage("resize");
			}.bind( this )
		});
		this.statusHide = new Fx.Morph( this.statusElement, { 
			'duration': 500,
			"onComplete": function(){
				this.statusElement.addClass( "hidden" );
				mop.util.EventManager.broadcastMessage("resize");
			}.bind( this )
		});
		this.previewElement = this.element.getElement(".preview");
		if( this.previewElement ) this.imagePreview = this.previewElement.getElement( "img" );
		this.filename = this.element.getElement( ".fileName" );
		mop.util.EventManager.addListener( this );
		if( mop.util.getValueFromClassName( 'extensions', this.element.get("class") ) ) this.options.extensions = this.buildExtensionsObject()
		this.getSubmitURL();
		this.uploader.setTarget( this, this.uploadLink, this.getOptions() );
		this.reposition();
	},
	
	simulateClick: function(){
	    console.log( "simulateClick", this.uploader.box.getElement( "object" ), $( this.uploader.box.getElement( "object" ).get( "id" ) ) );
        // Swiff.remote.delay( 500, Swiff, this.uploader.box.getElement( "object" ), 'stageClick' );
	},

	toString: function(){
		return "[ object, mop.ui.UIElement, mop.ui.FileElement ]";
	},
	
	getOptions: function(){
		console.log( "getOptions", "{", this.options.extensions, Cookie.read( 'session' ), "}");
		return {
			target: this.element,
			cookie: Cookie.read( 'session'),
			container: this.element.getElement( '.controls' ),
			fieldName: this.fieldName,
			url: this.getSubmitURL(),
			data: { field: this.fieldName, url: this.getSubmitURL(), cookie: Cookie.read( 'session') },
			typeFilter: this.buildExtensionsObject(),
			sizeLimitMin: 0,
			sizeLimitMax: this.options.maxLength
		}
	},
	
	buildExtensionsObject: function(){
		console.log( "buildExtensionsObject" );
    var extensionsArray = mop.util.getValueFromClassName( 'extensions', this.elementClass ).split( "_" );
		var desc = "";
		var exts = "";
		if( extensionsArray.length ){
		    extensionsArray.each( function( extension, index ){
			    desc = ( index < extensionsArray.length-1 )? desc +  "*." + extension + ", " : desc +  "*." + extension;
			    exts = ( index < extensionsArray.length-1 )? exts + "*." + extension + ";" : exts + "*." + extension;
		    });
		}else{
		    desc = ( index < extensionsArray.length-1 )? desc +  "*." + extension + ", " : desc +  "*." + extension;
		    exts = ( index < extensionsArray.length-1 )? exts + "*." + extension + ";" : exts + "*." + extension;		    
		}
		desc = "'Allowed Files: " + desc + "'";
		exts = exts;
		var ret =  {};
		ret[desc] = exts;
		return ret;
	},
	
	onFocus: function( e ){
		console.log( "mop.ui.FileElement", "onFocus", e );
		mop.util.stopEvent( e );
		this.uploader.setFocus( this, this.getPosition() );
	},
	
	clearFileRequest: function( e ){
		if( this.previewElement ){
			this.imageFadeOut = new Fx.Morph( this.imagePreview, {
				'duration': 300,
				'onComplete': mop.util.EventManager.broadcastMessage.bind( mop.util.EventManager, "resize" )
			}).start( { 'opacity' : [ 1, 0 ], 'height': 0 } );
		}
		if( this.clearButton ) this.clearButton.fade("out");
		var myRequest =  new Request.JSON( { url: this.getClearFileURL(), onSuccess: this.onClearFileResponse.bind( this ) } );
		return myRequest.send();
	},
	
	onClearFileResponse: function( json ){
		if( !json.returnValue ){
			throw "Error: mop.ui.FileElement clearFileRequest " + json.response.error;
		}else {
			this.clearButton.addClass("hidden");
			this.downloadButton.addClass("hidden");
			var msg = ( this.previewElement )? "No image uploaded yet…" : "No file uploaded yet…";
			this.filename.set( "text", msg );
		}
	},
	
	reposition: function(){
		this.uploader.reposition( this.scrollContext );
	},
	
	getCoordinates: function(){
		return this.uploadLink.getCoordinates( this.scrollContext );
	},

	validate: function() {
//		console.log( this.toString(), 'validate' );
		var options = this.uploader.options;
		if (options.fileListMax && this.uploader.fileList.length >= options.fileListMax) {
			this.validationError = 'fileListMax';
			return false;
		}
		if (options.fileListSizeMax && (this.uploader.size + this.size) > options.fileListSizeMax) {
			this.validationError = 'fileListSizeMax';
			return false;
		}
		return true;

	},

	invalidate: function() {
//		console.log( this.toString(), "invalidate" );
		this.invalid = true;
		this.uploader.fireEvent( 'fileInvalid', this, 10 );
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
		mop.util.EventManager.broadcastMessage("resize");
 		this.statusShow.start( { "opacity": [0,1] } );
		this.statusElement.removeClass("hidden");
	},
	
	revertToReadyState: function(){
//		console.log( this.toString(), "revertToReadyState" );
		this.statusHide.start( { "opacity":[1,0] });
	},
	
	onFileComplete: function( json ){
		console.log("JSON",json);
		json = JSON.decode( json.response.text );
		this.clearButton.fade( "in" );
		if( this.filename ) this.filename.set( "text",  json.response.filename );
		this.clearButton.removeClass("hidden");
		this.downloadButton.removeClass("hidden");
		this.downloadButton.set( 'title', 'download ' + json.response.filename );
		this.downloadButton.set( "href", mop.util.getBaseURL() + json.response.src );
		console.log( this.toString(), "onFileComplete", mop.util.getBaseURL() + json.response.thumbSrc );
		this.downloadButton.removeClass("hidden");
		if( this.previewElement ){
			this.imgAsset = new Asset.image( mop.util.getBaseURL() + json.response.thumbSrc, {  alt: json.response.filename, onload: this.updateThumb.bind( this, json ) } );
		}else{
			this.revertToReadyState();
		}
	},
	
	updateThumb: function( imageData ){
//		console.log( this.toString(), "updateThumb", imageData );
		var size = ( this.imagePreview )? this.imagePreview.getSize() : { x: 0, y: 0 };
		this.imgAsset.setStyle( 'width', size.x );
		this.imgAsset.setStyle( 'height', size.y );
		this.imgAsset.setStyle( 'opacity', 0 );
		if( !this.imagePreview ){
			//this.imagePreview = new Element( "img" ).inject( this.previewElement, "top" );
			this.imgAsset.inject( this.previewElement, 'top' );
		}else{
			this.imgAsset.replaces( this.imagePreview );
		}
		this.imagePreview = this.previewElement.getElement( 'img' );
		this.revertToReadyState();
		this.imageFadeIn = new Fx.Morph( this.imagePreview, {
			'duration': 300,
			'onComplete': mop.util.EventManager.broadcastMessage.bind( mop.util.EventManager, "resize" )
		}).start( { 'opacity' : [ 0, 1 ], 'width': imageData.width, 'height': imageData.height } );

	},

	destroy: function(){
//		console.log( "destroy\t", this.toString() );
		mop.util.EventManager.removeListener( this );
		this.uploader.destroy();
		this.statusElement.destroy();
		this.element.destroy();
		this.uploadLink = this.baseURL = this.extensions = this.filename = this.imagePreview = this.imageFadeIn = this.imageFadeOut = this.imgAsset = this.ogInput = this.previewElement = this.progressBar = this.sizeLimitMin = this.statusElement = this.statusHide = this.statusMessage = this.statusShow = this.uploadButton = this.uploader = this.validationError = this.invalid = null,
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
		if (this.options.callBacks) { Hash.each( this.options.callBacks, function( fn, name ) { this.addEvent( name, fn ); }, this ); }
		this.options.callBacks = { fireCallback: this.fireCallback.bind(this) };
		var path = this.options.path;
		if (!path.contains('?')) path += '?noCache=' + Date.now(); // cache in IE
		// container options for Swiff class
				
		this.box = new Element( 'div', { 'class': 'swiff-uploader-box' } ).inject( this.options.container );
		
		this.parent( path, { params: { wMode: 'transparent' }, height: '100%', width: '100%' } );
		this.addEvents({
			buttonEnter: this.buttonEnter.bind( this, 'mouseenter' ),
			buttonLeave: this.buttonLeave.bind( this, 'mouseleave' ),
			buttonDown: this.targetRelay.bind( this, 'mousedown' ),
			buttonDisable: this.targetRelay.bind( this, 'disable' ),
			fileComplete: this.targetRelay.bind( this, 'fileComplete' )
		});
		this.size = this.uploading = this.bytesLoaded = this.percentLoaded = 0;
		if (Browser.Plugins.Flash.version < 9) { this.fireEvent('fail', ['flash']); } else { this.verifyLoad.delay( 1000, this ); }
	},

	buttonEnter: function( eventName ){
		console.log( "??", this.target.getParent() );
		if( this.target.getParent().hasClass("command" ) ) this.target.getParent().addClass( "active" );
		this.targetRelay( eventName );
	},
	
	buttonLeave: function( eventName ){
		if( this.target.getParent() ) this.target.getParent().removeClass( "active" );
		this.targetRelay( eventName );
	},

	setFocus: function(){
//		console.log("!!!!!!!!!!!!!!!!!!")
		this.box.getChildren()[0].focus();
	},
	
	verifyLoad: function() {
		console.log( this.toString(), "verifyLoad", this.object );
		this.object.set( 'title', "Upload a file." );
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
		if ( name.substr(0, 4) == 'file') {
			// updated queue data is the second argument
			if (args.length > 1) this.update(args[1]);
			var data = args[0];
			var file = this.findFile( data.id );
			this.fireEvent( name, file || data, 5 );
			if (file) {
				var fire = name.replace(/^file([A-Z])/, function($0, $1) { return $1.toLowerCase(); });
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
		console.log( "initializeSwiff A" );
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
//		console.log( "!!!! targetRelay", name );
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

	onTargetHovered: function( target, targetElement, coords, options ){
		if( this.currentFileElementInstance == target ) return;
		console.log( "mop.util.Uploader", target, targetElement, coords, options );
// 		this.setTarget( target, targetElement, coords, options );
// //		targetElement.addClass('active');
	},

	setEnabled: function(status) {
		console.log( "setEnabled" );
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
		console.log( "mop.util.Uploader", "update", data );
		if( data ) this.currentFileElementInstance.showProgress( data );
		Object.append( this,  data );
		this.fireEvent('queue', [this], 10);
		return this;
	},

	beforeStart: function(){
//		console.log( this.toString(), "beforeStart", $A( arguments ) );
		this.currentFileElementInstance.showStatus();
//		this.reposition();
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
		var append = this.options.appendCookieData;
	console.log( "appendCookieData A", this.options.appendCookieData, document.cookie );//, document.cookie.split(/;\s*/) );
		if (!append) return;

		var hash = {};
		
		document.cookie.split(/;\s*/).each(function(cookie) {
			cookie = cookie.split('=');
			if (cookie.length == 2) {
				hash[decodeURIComponent(cookie[0])] = decodeURIComponent(cookie[1]);
			}
		});
		console.log( "appendCookieData B" );

		var data = this.options.data || {};
		if ($type(append) == 'string') data[append] = hash;
		else data.append( hash );

		console.log( this.toString(), "appendCookieData", data );

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

	setTarget: function( uiElement, targetElement, options ){
//		console.log( "mop.util.Uploader.setTarget", uiElement, targetElement, coords, options );
		this.currentFileElementInstance = uiElement;
		this.target = targetElement;
		this.setOptions( options );
//		this.reposition();
	},

	onResize: function(){ this.reposition(); },
	
	reposition: function( scrollContext ) {		
		if( !this.currentFileElementInstance ) return;
		// var coords = this.currentFileElementInstance.getCoordinates();
		// this.box.setStyles( {
		// 	position: 'absolute',
		// 	display: 'block',
		// 	visibility: 'visible',
		// 	overflow: 'hidden',
		// 	width: coords.width + "px",
		// 	height: coords.height + "px",
		// 	top: coords.top + "px",
		// 	left: coords.left + "px"
		// });
	},

	render: function() {
		console.log( this.toString(), "render", this.invalid, $A( arguments ) );
	},
	
	destroy: function(){
//		console.log( "UPLOADER DESTROY ", this.currentFileElementInstance );
		this.removeEvents();
		this.box.destroy();

		mop.modalManager.removeListener( this );
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
	},

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
		console.log( "\tformatUnit")
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
		console.log( "\t/ formatUnit")
		return (base / value).toFixed(1) + ' ' + labels[i].unit + append;
	}
});


mop.util.Uploader.qualifyPath = ( function() {
	var anchor;
	console.log("mop.util.Uploader.qualifyPath ")
	return function( path ) {
		console.log( "\t",path);
		( anchor || ( anchor = new Element('a') ) ).href = path;
		return anchor.href;
	};

})();

mop.ui.PulldownNav = new Class({
	
	Extends: mop.ui.UIField,
	
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
		var url = this.getValue();
		window.location.href = url;
	}

});

mop.ui.Pulldown = new Class({

	Extends: mop.ui.UIField,

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
	
	Extends: mop.ui.UIField,
	checkBox: null,
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		this.field = this.element.getElement( "input[type='checkbox']" );
		this.field.addEvent( "click", this.submit.bindWithEvent( this ) );
	},

	getValue: function(){
		return ( this.field.get( "checked" ) )? 1 : 0;
	},
	
	submit: function( e ){
		var val = this.getValue();
		this.submittedValue = val;
		if( !this.options.autoSubmit ){
			this.setValue( val );
			if( this.leaveEditMode ) this.leaveEditMode();
			return;
		}
		if( this.showSaving ) this.showSaving();
		if( this.leaveEditMode ) this.leaveEditMode();
		this.marshal.saveField( { field: this.fieldName, value: val }, this.onResponse.bind( this ) );
	},
	
	setValue: function( aVal ){
		if( aVal == 1 ){
			this.field.setProperty( "checked", "checked" );
		}else{
			this.field.removeProperty( "checked" );
		} 
	},
	
	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	destroy: function(){
		delete this.field;
		this.field = null;	
		this.parent();
	}
		
});

mop.ui.RadioGroup = new Class({
	
	Extends: mop.ui.UIField,

	radios: null,

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
	
	setTabIndex: function( val ){
		this.radios.each( function( aRadio, i ){
			console.log( aRadio, aRadio.get('tabindex') );
			aRadio.set( "tabindex", val + i );
		});
	},

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
		this.parent( e );
		this.radios.each( function( aRadio ){
			aRadio.set( "disabled", "disabled" );
			aRadio.removeEvents();
			aRadio.addEvent( "focus", Event.stop );
		}, this );

	},
	
	toString: function(){
		return "[ object, mop.ui.RadioGroup ]";
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

mop.ui.Input = new Class({
	

	Extends: mop.ui.UIField,
	
	options: {
		maxLength: 0,
		autoSubmit: true,
		enabled: true,
		rows: 1
	},

	initialize: function( anElement, aMarshal, options ) {
		this.parent( anElement, aMarshal, options );
		this.inputElement = this.element.getElement( "input" );
		if( this.options.maxLength ) this.element.addEvent("keydown", this.checkFormaxLength.bindWithEvent( this ) );
	},
	
	enableElement: function( e ){
		mop.util.stopEvent( e );
		this.parent();
		this.inputElement.erase( "disabled" );
		this.inputElement.removeEvents();
		if( this.options.maxLength ) this.element.addEvent("keydown", this.checkFormaxLength.bindWithEvent( this ) );
	},
	
	disableElement: function( e ){
		this.parent( e );
		this.inputElement.set( "disabled", "disabled" );
		this.inputElement.removeEvents();
		this.inputElement.addEvent( "focus", Event.stop );
	},

	toString: function(){
		return "[ object, mop.ui.Input ]";
	},

	checkFormaxLength: function( e ){
//		console.log(this.maxLength, e.target.get("value").length);
		if( e.target.get("value").length >= this.options.maxLength && e.key != "shift" && e.key != "enter" && e.key != "return" && e.key != "tab" && e.keycode != 46 && e.keycode != 8 ){
			mop.util.stopEvent( e );
			alert( "The maximum length this field allows is " + this.options.maxLength + " characters");
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

mop.ui.Text = new Class({

	Extends: mop.ui.UIField,
	// Implements: [ Options, Events, mop.util.Broadcaster ],

	form: null,
	options:{
		autoSubmit: true,
		submitOnBlur: true,
		enabled: true,
		rows: 1,
		maxLength: 0,
		messages: {
			hover: "Click to edit, ctr+enter to save, esc to cancel.",
			saving:"Saving field, please wait&hellip;" 
		}
	},

	getValue: function(){		
		return this.field.get( 'value' );
	},

	getKeyValuePair: function(){
		var returnVal = {};
		returnVal[ this.fieldName ] = this.getValue();
		return returnVal;
	},
	
	setValue: function( aValue ){
		if( this.field ) this.field.set( 'value', aValue );
		this.ipeElement.set( 'html', aValue.formatToHTML() );
	},

	initialize: function( anElement, aMarshal, options ) {
		this.parent( anElement, aMarshal, options );
		this.mode = "atRest";
		if( this.options.submitOnBlur ) this.allowSubmitOnBlur = true;
		this.field = anElement.getElement( ".og" );
		if( this.options.validation ){
			this.validators = [];
			Object.each( this.options.validation, function( aValidationString ){
				// this.validators = new InputValidator( 'this', options);
			});
		}

		this.ipeElement = new Element( "div", { 
			"class": "ipe " + this.field.get( 'class' ).split( " " ).splice( 1 ).join(' '),
			"html": this.field.get( 'value' )
		}).inject( anElement );

		this.documentBoundUpdateAndClose = this.onDocumentClicked.bindWithEvent( this );
		document.addEvent( "mousedown", this.documentBoundUpdateAndClose );

		this.ipeElement.removeClass('og');
		this.field.store( "Class", this );
		this.ipeElement.store( "Class", this );
		this.field.addEvent( 'focus' , this.onFieldFocus.bindWithEvent( this ) );
		this.field.addClass( 'away' );
		this.enableElement();
		// this.ipeElement.set( 'morph' );
		this.oldValue = this.ipeElement.get( "html" );
	},

	onDocumentClicked: function( e ){
		if( this.mode != "editing" ) return;
	  if( e.target == this.saveButton || e.target == this.cancelButton ) return;
	  if( e.target == this.element || this.element.contains( e.target ) ) return;
		mop.util.stopEvent( e );
		console.log( this.fieldName, 'onDocumentClicked', this.mode, this.element, this.element.contains( e.target ) );
	},

	toString: function(){ return "[ object, mop.ui.Text ]"; },
	
	onKeyPress: function( e ){
		var submitCondition = ( ( e.control || e.meta) && e.key == 'enter' );
		if( submitCondition == true ){
			this.submit(e);
		}else if( e.key == "esc" ){
			this.cancelEditing( e );
		}
		submitCondition = null;
	},
	
	onFieldFocus: function( e ){
		mop.util.stopEvent( e );
		if( this.mode == "editing ") return false;
		this.enterEditMode( e );
	},
	
	onBlur: function( e ){
		if( this.allowSubmitOnBlur ) this.submit();
	},
	
	prepareField: function(){
		var val, size, h, w, inputType;
		this.field.removeEvents();
		val = this.ipeElement.get( 'html' ).toPlain();
		this.field.set( 'value', val );
		w = this.ipeElement.getSize().x - ( 2 * parseInt( this.field.getComputedStyle( 'border-bottom-width' ) ) + 2 * parseInt( this.ipeElement.getStyle('padding-left' ) ) );
		h = this.ipeElement.getComputedSize().height - ( 2 * parseInt( this.field.getComputedStyle( 'border-bottom-width') )  ); 
		console.log( this.fieldName, '{', w,',',h,'}', '-',  this.ipeElement.getSize().y,  this.ipeElement.getCoordinates().height, this.ipeElement.getComputedSize().height, ",", parseInt( this.field.getComputedStyle( 'border-bottom-width') ) );
		if( this.options.rows > 1 ){
			this.field.addEvent( 'keyup', this.fitToContent.bind( this ) );
			this.fitToContent();
		}else{
			inputType = ( this.element.getValueFromClassName( 'type' ) == 'password' )? 'password' : 'text';
			this.field.set( 'type', inputType );
		};
		this.field.setStyles({
			'overflow': 'hidden',
			'width': w, 
			'height': h
		});
		if( this.options.maxLength ) this.field.addEvent( 'keydown', this.checkFormaxLength.bindWithEvent( this ) );
		document.addEvent( "mousedown", this.documentBoundUpdateAndClose );
		if( this.options.submitOnBlur ){
			this.submitOnBlurEnabled = true;
			this.field.addEvent( 'blur', this.onBlur.bindWithEvent( this ) );
		}else{
			this.submitOnBlurEnabled = false;
			this.field.addEvent( 'blur', this.cancelEditing.bind( this ) );
		}
		if( this.controls ){
			this.controls.destroy();
			this.controls = null;
		}
		this.controls = new mop.ui.Sticky( this.field, {
			content: this.getControls(),
			borderRadius: 4,
			offset: ( this.options.rows > 1 )? { x: -8, y: -12 } : { x: -8, y: 0 },
			position: ( this.options.rows > 1 )? { x: 'right', y: 'bottom' } : { x: 'right', y: 'center' },
			stayOnBlur: true,
			mouseEnter: this.setAllowSubmitOnBlur.bind( this, false ),
			mouseLeave: this.setAllowSubmitOnBlur.bind( this, true )
		});
		if( this.options.rows == 1 ){
			this.field.select();
		}else{
			this.field.select();
		}
		this.field.addEvent( 'focus' , this.onFieldFocus.bindWithEvent( this ) );
		this.field.addEvent( 'keydown', this.onKeyPress.bind( this ) );
		this.ipeElement.addClass("away");
		this.field.removeClass('away');
		this.ipeElement.removeClass("atRest");
		this.controls.position();
		this.controls.show();
	},
	
	setAllowSubmitOnBlur: function( bool ){
		this.allowSubmitOnBlur = ( this.options.submitOnBlur )? bool : false;
	},
	
	getAllowSubmitOnBlur: function(){
		return this.allowSubmitOnBlur;
	},
	
	getControls: function(){  		
		var controls = new Element( 'div.ipeControls.clearFix' );
		this.saveButton = new Element( 'a.icon.submit', {
			'title': 'save',
			'text': 'save',
			'href': '#',
			'events': {
				'click': this.submit.bind( this )
			}
		});
		this.cancelButton = new Element( 'a.icon.cancel', {
			'title': 'cancel',
			'text' : 'cancel',
			'href': '#',
			'events': {
				'click': this.cancelEditing.bind( this )
			}
		});
		controls.adopt( this.saveButton );
		controls.adopt( this.cancelButton );
		return controls;
	},
	
	submit: function( e ){
		this.parent( e );
		var val = this.submittedValue.formatToHTML();
		this.ipeElement.set( 'html', val );
	},
		
	checkFormaxLength: function(e){
		if( e.target.get("value").length > this.options.maxLength && e.keycode != 46 && e.keycode != 8 ){
			mop.util.stopEvent( e );
			alert( "The maximum length this field allows is " + this.options.maxLength + " characters");
		}
	},

	enableElement: function( e ){
		this.parent( e );
		this.ipeElement.removeEvents();
		this.ipeElement.addEvent( "click", this.enterEditMode.bindWithEvent( this ) );
		this.ipeElement.set( "title", this.options.messages.hover );
	},
	
	disableElement: function( e ){
		this.parent( e );
		this.ipeElement.removeEvents();
		this.ipeElement.addEvent( "mouseover", Event.stop );
		this.ipeElement.addEvent( "focus", Event.stop );
	},
	
	enterEditMode: function( e ){
		mop.util.stopEvent( e );
		if( this.mode == "editing ") return false;
		this.mode = "editing";
		// if we don't suspend parent sorting, then when we click the field we start a drag angle
		if( this.marshal.suspendSort ) this.marshal.suspendSort();
		this.prepareField();
	},
	
	leaveEditMode: function(){
		this.mode = 'atRest';
		this.field.removeEvents('blur');
		// see enterEditMode and sorting
		if( this.marshal.resumeSort ) this.marshal.resumeSort();
		if( this.controls ){
			this.controls.destroy();
			this.controls = null;
		}
		if( this.options.submitOnBlur ) this.allowSubmitOnBlur = true;
		this.field.addClass('away');
		this.ipeElement.removeClass( 'away' );
		this.ipeElement.addClass('atRest');
		this.enableElement();
	},

	cancelEditing: function( e ){
		mop.util.preventDefault( e );
		if( this.oldValue ){
			var val = this.oldValue.formatToHTML()
			this.field.set( 'value', val );
			this.ipeElement.set( 'html', this.oldValue );
		}else{
			this.ipeElement.set( 'html', '' );
		}
		this.ipeElement.morph( '.atRest' );
		this.leaveEditMode();
		this.destroyValidationSticky();
		console.log( 'validationSticky', this.validationSticky );
	},

	showSaving: function(){
		this.mode = 'saving';
		this.ipeElement.addClass( 'saving' );
		this.ipeElement.setStyle( 'opacity', .2 );
		this.ipeElement.set( "title", this.options.messages.saving );
	},

	showValidationError: function( errorMessage ){
		this.ipeElement.removeClass("saving");
		this.parent( errorMessage );		
		this.ipeElement.set( 'text', this.submittedValue );
		this.field.set( 'value', this.submittedValue );
		this.enterEditMode();
	},
	
	fitToContent: function(){
		var val = this.getValue().formatToHTML();
		this.field.setStyle( "height", this.measureIPEElementWithValue( val ).y + 12 );
		if( this.controls ) this.controls.position();
	},
	
	measureIPEElementWithValue: function( aValue ){
		var ogVal = this.getValue();
		var ogSize = this.ipeElement.getSize();
		this.ipeElement.setStyle( 'height', 'auto' );
		this.ipeElement.set( 'html', aValue.formatToHTML() );
		var newSize = this.ipeElement.getSize();
		this.setValue( ogVal );
		return newSize;
	},

	onResponse: function( json ){
		// this.ipeElement.addEvent( 'click', this.enterEditMode.bindWithEvent( this ) );
		this.ipeElement.setStyle( 'height', 'auto' );
		this.parent( json );
	},
	
	onSaveFieldSuccess: function( response ){
		this.enableElement();
		val = response.value;
		if( this.field && this.field.get( 'type' ) == 'password' ){
			this.ipeElement.set( 'html', '******' );
		}else{
			this.ipeElement.set( 'html', val );
		}
		this.destroyValidationSticky();
		this.oldValue = val;
		this.parent( response );
		this.ipeElement.set( 'morph', { duration: 600, onComplete: function(){
			this.ipeElement.removeClass('saving');
			this.ipeElement.removeClass('atRest');
		}.bind( this ) } );
		this.ipeElement.setStyle( 'opacity', .2 );
		this.ipeElement.morph( { opacity: 1 } );
	},	

	destroy: function(){
		if( this.mode == 'editing' ) this.leaveEditMode();
		this.ipeElement.eliminate( 'Class' );
		this.ipeElement.destroy();
		this.ipeElement = this.mode = this.value = this.oldValue = null;
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
	
	Extends: Drag.Move,
	isVirgin: true,
	
	initialize: function( radios, options ){
		options = options || [];
		this.duration = options.duration || 100;
		this.hide_radios = (options.hide_radios ) ? options.hide_radios : true;
		this.hide_labels = (options.hide_labels ) ? options.hide_labels : false;
	
		this.onChangeHandler = ( options.onChange ) ? options.onChange : null;
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
		if( !this.isVirgin ){
			this.onChangeHandler( ( value == 1 )? 0 : 1 ); 
		}else{
		    this.isVirgin = false;
		}
		this.handle.morph({
			'left' : ( value == 0 )? this.maxscroll : 0,
			'opacity' : 1
		});

	}
});

mop.ui.SlideSwitch = new Class({
	Extends: mop.ui.MooSwitch,
	initialize: function( anElement, aMarshal, options ){
		this.element = anElement;
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
		var newWidth = this.tableSize.x - 16;
		this.element.setStyles( { "overflow": "auto", "width": newWidth } );
		this.setUpTableHead();
 		this.setUpTableBody();
	},
	
	isBrowserIe6orLower: function(){ return( Browser.ie && Browser.version < 7 ); },
	
	setUpTableHead: function(){
		this.table.getElement( "thead" ).getChildren( "tr" ).each( function( aTr, index ){ aTr.setStyle( "position", "relative" ); }, this );
	},
	
	destroy: function(){ this.element = this.table = this.tableSize = null; }
	
});

mop.ui.PaginationControls = new Class({
	
	pages: [],
	cachePages: false,
	method: "pagination",
	currentPage: 1,
	
	getPageURL: function( marshalId ){
	    return mop.util.getBaseURL() + "ajax/data/" + marshalId + "/" + this.method + "/" + this.options.listId + "/" + this.currentPage;
	},
	
	initialize: function( anElement, aMarshal ){		
		this.element = $( anElement );
		this.instanceName = this.element.get( "id" );
		this.element.store( "Class" );
		this.marshal = ( aMarshal )? aMarshal : $( this.element.get("id").subString( 0, this.element.get("id").indexOf("_pagination") ) );
		this.container = ( this.marshal.element.getElement( ".container" ) )? this.marshal.element.getElement( ".container" ) : this.marshal.element;
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
		return "[ object, mop.ui.PaginationControls ]";
	},
	
	nextPage: function( e ){
		mop.util.stopEvent( e );
//		console.log( this.toString(), "nextPage", e );
		this.currentPage ++;
		if( this.currentPage == this.options.totalPages ) this.nextPageControl.addClass( "hidden" );
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
		if( this.pages[ this.currentPage ] && this.options.cachePages ){
			var newChildren = this.buildItems( this.pages[ this.currentPage ] );
			this.clearElements( this.getPageableItems() ); 
			this.container.adopt( newChildren );
			//this.container.adopt( this.pages[ this.currentPage ] );
//			console.log( "Page Cached... send JSON", this.toString(), "paginate", "this.pages[ this.currentPage ]", this.pages[ this.currentPage ] );
			if( this.marshal && this.marshal.initList ) this.marshal.initList();
		}else{
			this.spinner.removeClass( "hidden" );
			var marshalId = ( this.marshal.instanceName )? this.marshal.instanceName : this.marshal.get("id");
			var postData = ( this.marshal.getPaginationPostData )? this.marshal.getPaginationPostData() : null ;
			return Request.JSON( { url: this.getPageURL( marshalId ), onSuccess: this.onPagination.bind( this ) } ).post( postData );
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
		this.pages[ this.currentPage ] = json;
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
		this.options = null;
		this.element = null;
		this.instanceName = null;
		this.itemIdPrefix = null;
		this.elementToClone	= null;
		this.nextPageControl = null;
		this.previousPageControl = null;
		this.pageableElement = null;
		this.method = null;
		this.container = null;
		this.spinner = null;
		this.marshal = null;
		this.pages = null;
		this.container = null;
		this.currentPage = null;
		this.pageableElement = null;
	}
});