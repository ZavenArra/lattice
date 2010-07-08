/* Class: mop.cms.CMS */
mop.modules.CMS = new Class({
	/* Constructor: initialize */
	Extends: mop.modules.Module,
	pageLoadCount: 0,

	initialize: function( anElement, aMarshal, options ){

		this.parent( anElement, aMarshal, options );		
		this.rid = this.getValueFromClassName( "rid" );
		this.navKey = mop.util.getValueFromClassName( "navigation", this.elementClass );
		
		return this;
	},
	
	build: function(){
	
		this.parent();
		this.pageContent = $("nodeContent");
	
	},
	
	toString: function(){
		return "[ object, mop.modules.CMS ]";
	},

	loadPage: function ( pageId ){
//		console.log( this.toString(), "loadPage", pageId );
		this.pageIdToLoad = pageId;
		this.clearPage( pageId );
		this.pageContent.addClass(".centeredSpinner");
		new Request.JSON({
			url: mop.getAppURL() + "cms/ajax/getPage/" + pageId,
			onSuccess: this.onPageLoaded.bind( this )
		}).send();
 		mop.ModuleManager.setRID( pageId );
	},
	
	clearPage: function( pageId ){
		if( this.getRID() == pageId ) return;
		this.destroyUIElements();
//		console.log( "A", this.toString(), "clearPage", pageId );
		this.destroyChildModules();
//		console.log( "B", this.toString(), "clearPage", pageId );
		this.pageContent.empty();
	},

	/*
		Function: onPageLoaded
		Callback to getPage, loops through supplied JSON object and attached css, html, js, in that order then tells modulemanager to look through #pageContent and initialize modules therein....
		Arguments:
			pageJSON - Object : { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	onPageLoaded: function( pageJSON ){

		var pageData = new Hash( pageJSON );

		$("nodeContent").removeClass(".centeredSpinner");

		pageData.css.each( function( element, index ){ mop.util.loadStyleSheet( element ); });

		var scripts = pageData.js;
		this.scriptsLoaded = 0;
		this.scriptsTotal = scripts.length;
		this.currentPageLoadIndex = this.pageLoadCount++;

		if( this.scriptsTotal && this.scriptsTotal > 0 ){
			scripts.each( function( urlString ){
				mop.util.loadJS( urlString, { type: "text/javascript", onload: this.onJSLoaded.bind( this, [ pageData.html, this.currentPageLoadIndex ] ) } );
			}, this);
			
		}else{
			

			this.populate( pageData.html );

		}

	},
	
	onJSLoaded: function( pageHTML, pageLoadCount ){
		// keeps any callbacks from previous pageloads from registering
		if( pageLoadCount != this.currentPageLoadIndex ) return;
		
		this.scriptsLoaded++;
		
		if( this.scriptsLoaded == this.scriptsTotal ){
			
			this.scriptsTotal = null;
			this.populate( pageHTML );

		}
	},
	
	
	populate: function( html ){
		
//		console.log( '1. populate', this.toString() );

		this.pageContent.set( 'html', html );
		this.loadedModules = [];
		this.protectedModules = [];
		this.titleElement = this.element.getElement( ".pageTitle" );

		if( this.titleElement ){
			this.titleText = this.titleElement.getElement( "h2" ).get( "text" );
			this.deletePageLink = this.titleElement.getElement( "a.deleteLink" );
			if( this.deletePageLink ) this.deletePageLink.addEvent( "click", this.deleteNode.bindWithEvent( this ) );
		}
		
		this.initUI();
		
		/*@TODO break this out into AjaxModuleLoader interface
		( the crm detail modal/tab interface for example needlessly replicates a lot of this functionality, 
		cms and said modal should just implement an interface, specially how important, complex, and critical this code is,
		it will help with maintenance to break it out ) */
		this.initModules();
		
		this.loadedModules.each( function( aModule ){
			if( aModule.element.hasClass("protected") ) this.protectedModules.push( aModule );
		}, this );
		
		/*@TODO turn this into a hook, call to postInitUIHook or something*/
		if( this.uiElements.length ){
			this.uiElements.each( function( uiInstance ){
				if( uiInstance.element.hasClass( "ui-IPE" ) && uiInstance.element.hasClass( "field-title" ) ) uiInstance.registerOnCompleteCallBack( this.renameNode.bind( this ) );
			}, this );
		}

	},
	
	initModules: function(){
		var newlyInstantiatedModules = mop.ModuleManager.initModules( this.pageContent, "window" );
		this.loadedModules = newlyInstantiatedModules.loadedModules;
		this.protectedModules = newlyInstantiatedModules.protectedModules;	
	},
	
	renameNode: function( response, uiInstance ){
		this.getNav().renameNode( response.value );
	},

	deleteNode: function( e ){
		if( e && e.stop ){
			e.stop();
		}else if( e ){
			e.returnVal = false;
		}
		
		var confirmed = confirm( "Are you sure you wish to delete the node: “" + this.titleText + "”?\nThis cannot be undone." );
		if( confirmed ) this.deleteNode( this.getRID(), "page" );
		confirmed = null;
	},


	addObject: function( objectName, templateId, parentId, whichTier, placeHolder ){
		var callBack = function( nodeData ){
			this.onObjectAdded( nodeData, parentId, whichTier, placeHolder );
		};
		new Request.JSON({
			url: mop.getAppURL() + "cms/ajax/addObject/" + parentId + "/" + templateId,
			onComplete: callBack.bind( this )
		}).post( { "title" : objectName } );
		callBack = null;
	},

	onObjectAdded: function( data, parentId , whichTier, placeHolder ){
		this.getNav().onObjectAdded(  data , parentId, whichTier, placeHolder );
	},
	
	getModule: function(){ return this; },
	
	getNav: function(){
		if( !this.nav ) this.nav = mop.ModuleManager.getModuleById( this.navKey );
//		console.log( "getNav", this.toString(), this.nav );
		return this.nav;
	},

	/*
	Function: togglePublishedStatus
	Sends page publish toggle ajax call 
	Argument: pageId {Number}
	Callback: onTogglePublish
	*/
	togglePublishedStatus: function( nodeId ){
		new Request.JSON({
			url: mop.getAppURL() + "cms/ajax/togglePublish/"+ nodeId
//			onComplete: this.onPublishedStatusToggled
		}).send();
	},

	/*
	Function: deleteNode
	Sends page deleting ajax call destroys current page 
	Argument: pageId {Number}
	Callback: onNodeDeleted
	*/
	deleteNode: function( pageId, from ){
//		console.log( "deleteNode :: " + pageId + " : " + from );
		if( from == "page" ) this.getNav().removeNode( pageId, this );
		new Request.JSON({
			url: mop.getAppURL() + "cms/delete/"+pageId,
			onComplete: this.clearPage.bind( this, pageId )
		}).send();
	}
	
});
