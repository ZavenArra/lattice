/* Class: mop.cms.CMS */
mop.modules.CMS = new Class({
	/* Constructor: initialize */
	Extends: mop.modules.Module,
	pageLoadCount: 0,
	objectId: null,
	pageContent: null,
	pageIdToLoad: null,
	scriptsLoaded: null,
	scriptsTotal: null,
	currentPageLoadIndex: null,
	titleElement: null,
	deletePageLink: null,

	initialize: function( anElement, options ){
//        console.log( "CMS INIT", this.childModules );
		this.parent( anElement, null, options );		
		this.objectId = this.getValueFromClassName( "objectId" );
	},
	
	build: function(){
		this.pageContent = $("nodeContent");
		this.initModules( this.element );
	},
	
	toString: function(){
		return "[ object, mop.modules.CMS ]";
	},

	loadPage: function ( pageId ){
//		console.log( this.toString(), "loadPage", pageId );
		this.pageIdToLoad = pageId;
		this.clearPage( pageId );
		this.pageContent.spin();
		new Request.JSON({
			url: mop.util.getAppURL() + "cms/ajax/getPage/" + pageId,
			onSuccess: this.onPageLoaded.bind( this )
		}).send();
 		mop.util.setObjectId( pageId );
	},
	
	clearPage: function( pageId ){
//	    console.log( "clearPage", pageId );
//		if( mop.util.getObjectId() == pageId ) return;
		this.destroyChildModules( this.pageContent );
		this.destroyUIElements();
		this.pageContent.empty();
	},

	/*
		Function: onPageLoaded
		Callback to getPage, loops through supplied JSON object and attached css, html, js, in that order then looks through #pageContent and initialize modules therein....
		Arguments:
			pageJSON - Object : { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	onPageLoaded: function( pageJSON ){

		var pageData = new Hash( pageJSON );
		pageData.css.each( function( element, index ){ mop.util.loadStyleSheet( element ); });

		$("nodeContent").unspin();

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
		
		this.pageContent.set( 'html', html );
		this.titleElement = this.element.getElement( ".pageTitle" );

		if( this.titleElement ){
			this.titleText = this.titleElement.getElement( "h2" ).get( "text" );
			this.deletePageLink = this.titleElement.getElement( "a.deleteLink" );
			if( this.deletePageLink ) this.deletePageLink.addEvent( "click", this.deleteNode.bindWithEvent( this, "page" ) );
		}
		
		this.uiElements = this.initUI( this.pageContent );
				
		this.initModules( this.pageContent );		

	},

	postInitUIHook: function( ){
	    
		this.UIElements.each( function( aUIElement ){
			if( aUIElement.element.hasClass( "field-title" ) ){
        	    console.log( "postInitUIHook" , aUIElement, aUIElement.element );
			    aUIElement.registerOnCompleteCallBack( this.renameNode.bind( this ) );
			}
		}, this );
	
	},
	
	renameNode: function( response, uiInstance ){
		this.childModules.get( "navigation" ).renameNode( response.value );
	},


	addObject: function( objectName, templateId, parentId, whichTier, placeHolder ){
//	    console.log( "addObject", this, this.toString() );
		var callBack = function( nodeData ){
			this.onObjectAdded( nodeData, parentId, whichTier, placeHolder );
		};
		new Request.JSON({
			url: mop.util.getAppURL() + "cms/ajax/addObject/" + parentId + "/" + templateId,
			onComplete: callBack.bind( this )
		}).post( { "title" : objectName } );
		callBack = null;
	},

	onObjectAdded: function( data, parentId , whichTier, placeHolder ){
//	    console.log( "onObjectAdded", this, this.toString() );
		this.childModules.get( "navigation" ).onObjectAdded(  data , parentId, whichTier, placeHolder );
	},
	
	getModule: function(){ return this; },
	
	/*
	Function: togglePublishedStatus
	Sends page publish toggle ajax call 
	Argument: pageId {Number}
	Callback: onTogglePublish
	*/
	togglePublishedStatus: function( nodeId ){
		new Request.JSON({
			url: mop.util.getAppURL() + "cms/ajax/togglePublish/"+ nodeId
//			onComplete: this.onPublishedStatusToggled
		}).send();
	},

	/*
	Function: deleteNode
	Sends page deleting ajax call destroys current page 
	Argument: pageId {Number}
	Callback: onNodeDeleted
	*/
	deleteNode: function( e, from ){
	    console.log( "deleteNode", this.toString(), from );
		mop.util.stopEvent( e );		
		var confirmed = confirm( "Are you sure you wish to delete the node: “" + this.titleText + "”?\nThis cannot be undone." );
		if( confirmed ){
		    if( from == "page" ) this.childModules.get( "navigation" ).removeNode( mop.objectId, this );
    		new Request.JSON({
    			url: mop.util.getAppURL() + "ajax/cms/delete/"+mop.objectId,
    			onComplete: this.clearPage.bind( this, mop.objectId )
    		}).send();
    	};
	}
	
});

window.addEvent( "domready", function(){

	mop.HistoryManager = new mop.util.HistoryManager().instance();
	mop.HistoryManager.init( "pageId", "onPageIdChanged" );
	mop.ModalManager = new mop.ui.ModalManager();
    mop.DepthManager = new mop.util.DepthManager();
    
    var doAuthTimeout = mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
    
    if( window.location.href.indexOf( "auth" ) == -1 && doAuthTimeout && doAuthTimeout != "0" ) mop.loginMonitor = new mop.util.LoginMonitor();
    
    mop.util.EventManager.broadcastEvent("resize");
    mop.CMS = new mop.modules.CMS( "cms" );

});
