<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="content-script-type" content="text/javascript">
	<title>MoPCMS “It's Made of People!”</title>
	<base href="http://localhost/mopcms/fullobject/">
	<script type="text/javascript" src="http://localhost/mopcms/fullobject/modules/mop/thirdparty/mootools/mootools-1.2.4-core-nc.js"></script>
	<script type="text/javascript" src="http://localhost/mopcms/fullobject/modules/mop/thirdparty/mootools/mootools-more-nc.js"></script>
	<script type="text/javascript" src="http://localhost/mopcms/fullobject/modules/mop/MoPCore.js"></script>
	<script type="text/javascript">
	mop.ui = {};
	mop.ui.navigation = {};

/*		Class: mop.ui.Sortable
		Simply an extension of the mootools sortable
		adds a marshal reference, and a scroller instance
*/
	mop.ui.Sortable = new Class({

		Extends: Sortables,

		initialize: function( anElement, marshal, options ){

			var opts = {
			    area: options.area,
			    velocity: options.velocity,
				clone: function(event,element,list){
					var scroll = {x:0 ,y: 0};
					element.getParents().each(function(el){
						if(['auto','scroll'].contains(el.getStyle('overflow'))){
							scroll = {
								x: scroll.x + el.getScroll().x,
								y: scroll.y + el.getScroll().y
							}					
						}
					});
					var position = element.getPosition();

					return element.clone().setStyles({
						margin: '0px',
						position: 'absolute',
						visibility: 'hidden',
						'width': element.getStyle('width'),
						top: position.y + scroll.y,
						left: position.x + scroll.x
					}).inject(this.list);
				},
				opacity: 0.5
			};

			this.parent( anElement, opts );
			this.marshal = marshal;

//	      this.scroller = new Scroller( options.scrollElement, opts );

			opts = null;

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


	mop.ui.IPE = new Class({

		Extends: mop.ui.UIElement,

		onLeaveEditModeCallbacks: [],
	
		type: "ipe",

		form: null,
	
		options:{
			messages: { clickToEdit: "click to edit." },
			action: "savefield"
		},

		registerOnLeaveEditModeCallback: function( func ){
			this.onLeaveEditModeCallbacks.push( func );
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
			if( this.marshal.suspendSort ) this.marshal.suspendSort();
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
	    
	        if( !this.measureDiv ){
	            this.measureDiv = new Element( "div", { 
	                "class": this.field.get( "class" ) + " " + this.ipeElement.get("class"),
	                "styles" : {
	                    "min-height": this.ipeElement.getStyle( "min-height" ),
	                    "max-height": this.ipeElement.getStyle( "max-height" ),
	                    "display": "none",
	                    "width": this.field.getStyle( "width" ),
	                    "height": 'auto',
	                    "font-size": this.ipeElement.getStyle( "font-size" ),
	                    "font-family": this.ipeElement.getStyle( "font-family" ),
	                    "line-height": this.ipeElement.getStyle( "line-height" ),
	                    "letter-spacing": this.field.getStyle( "letter-spacing" )
	                }
	            })
	            $(document.body).adopt( this.measureDiv );
	        }
	        var val = this.html_entity_decode( this.field.get( "value" ).replace( /\n/g, "<br/>" ) )
	        this.measureDiv.set( "html", val );
	        var size = this.measureDiv.measure( function(){ return this.getComputedSize() } );
	        this.field.setStyle( "height", ( size.height + 16 ) + "px" );

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
					    "overflow": "hidden",
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
				this.ipeElement.set( "html", this.oldValue );
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
		
			if( this.onLeaveEditModeCallbacks.length > 0 ){
				for( var i = 0; i < this.onLeaveEditModeCallbacks.length; i++ ){
					this.onLeaveEditModeCallbacks[i]( this );
				}
			}
		
			this.destroyValidationSticky();
		
			mop.util.EventManager.broadcastEvent("resize");

		},

		destroy: function(){
			delete this.oldValue;
			delete this.submittedValue;
			this.clickEvent = null;
			this.ipeElement.eliminate( "Class" );
			this.ipeElement.destroy();
	//		this.leaveEditMode();
			this.parent();
		}
	
	});
	</script>
	<script type="text/javascript" src="http://localhost/mopcms/fullobject/modules/mop/MoPModules.js"></script>
	<script type="text/javascript" src="http://localhost/mopcms/fullobject/modules/cms/views/list.js"></script>
	<script type="text/javascript">
	window.addEvent( 'domready', function(){
		this.proxyAppModule = {
			
		};
		new mop.modules.List( $("simpleListMod"), this.proxyAppModule, null  );
	});
	</script>

</head>


<body>

<div id="simpleListMod" class="module  allowChildSort-true sortDirection-ASC classPath-mop_modules_List">
		
	<ul class="listing">
		<li id="5" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">3 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li>
<li id="4" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">2 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="6" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">4 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="3" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">1 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="7" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">5 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="8" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">6 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="9" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">7 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="10" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">8 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="11" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">9 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="12" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">10 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="13" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">11 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="14" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">12 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="15" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">13 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="16" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">14 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="17" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">15 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="18" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">16 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="19" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">17 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="20" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">18 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="21" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">19 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="22" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">20 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="23" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">21 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="24" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">22 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="25" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">23 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="26" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">24 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="27" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">25 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="28" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">26 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="29" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">27 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="30" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">28 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="31" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>

		<div title="click to edit." class="ipe p">29 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="32" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">30 THIS IS THE TITLE</div>

</div>
	
	<div class="itemControls">controls</div>

</li><li id="33" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">31 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="34" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">
			<label>Title</label>
		<div title="click to edit." class="ipe p">32 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li><li id="35" style="width: 200px; height: 200px; float: left; margin: 0pt 1em 0.25em 0pt; border: 1px #000 solid">
	<div class="ui-IPE field-title  rows-1">

			<label>Title</label>
		<div title="click to edit." class="ipe p">33 THIS IS THE TITLE</div>
</div>
	
	<div class="itemControls">controls</div>

</li>	</ul>

	<div class="controls clear">
		<a href="#" class="addItem button grid_2">Add another?</a>

	</div>

	

</div>

</body></html>