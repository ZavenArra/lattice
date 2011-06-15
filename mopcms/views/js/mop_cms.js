/* Class: mop.cms.CMS */
mop.modules.CMS = new Class({
	/* Constructor: initialize */
	Extends: mop.modules.Module,
	Interfaces: [ mop.modules.navigation.NavigationDataSource ],
	pageLoadCount: 0,
	objectId: null,
	pageContent: null,
	pageIdToLoad: null,
	scriptsLoaded: null,
	currentPageLoadIndex: null,
	titleText: "",
	titleElement: null,
	editSlugLink: null,
	deletePageLink: null,
	loadedCSS: [],
	loadedJS: [],
    stringIdentifier: "[ object, mop.modules.CMS ]",
    
    /* Section: Getters & Setters */    
    
    getRemoveObjectRequestURL: function( parentId ){
        return mop.util.getBaseURL() + "ajax/compound/cms/removeObject/" + parentId;
    },
    
    getRequestPageURL: function( nodeId ){
        return mop.util.getBaseURL() + "ajax/html/cms/getPage/" + nodeId;
    },
    
    getRequestTierURL: function( parentId ){
        return mop.util.getBaseURL() + "ajax/compound/navigation/getTier/" + parentId;
    },

    getAddObjectRequestURL: function( parentId, templateId ){
        return mop.util.getBaseURL() + "ajax/data/cms/addObject/" + parentId + "/" + templateId;
    },
    
    getTogglePublishedStatusRequestURL: function( nodeId ){            
        return mop.util.getBaseURL() + "ajax/data/cms/togglePublish/"+ nodeId;
    },

	/* Section: Constructor */
	initialize: function( anElement, options ){
        this.parent( anElement, null, options );
        this.instanceName = this.element.get("id");
		this.objectId = this.getValueFromClassName( "objectId" );
		var scripttags = $$( "script" ).each( function( aScriptTag ){ this.loadedJS.push( aScriptTag ); }, this );
		var scripttags = $$( "link[rel=stylesheet]" ).each( function( aStyleSheetTag ){ this.loadedCSS.push(  aStyleSheetTag ); }, this );
	},

	/* Section: Methods */
    toString: function(){ return this.stringIdentifier },

	build: function(){
		this.pageContent = $("nodeContent");
		this.initModules( this.element );
	},

	populate: function( html ){
		$("nodeContent").unspin();
		this.pageContent.set( 'html', html );
		this.uiElements = this.initUI( this.pageContent );
		this.initModules( this.pageContent );		
		this.titleElement = this.element.getElement( ".pageTitle" );
		if( this.titleElement ){
			this.titleText = this.titleElement.getElement( "h2" ).get( "text" );
			this.deletePageLink = this.titleElement.getElement( "a.deleteLink" );
    		this.editSlugLink = this.titleElement.getElement( ".field-slug label" );
			if( this.editSlugLink ) this.editSlugLink.addEvent( "click", this.toggleSlugEditField.bindWithEvent( this ) );
			var titleIPE = this.titleElement.getElement( ".field-title" ).retrieve("Class");
			if( titleIPE ) titleIPE.registerOnCompleteCallBack( this.onTitleEdited.bind( this ) );
		}
	},
    	
	clearPage: function(){
	    console.log( "clearPage" );
		this.destroyChildModules( this.pageContent );
		this.destroyUIElements();
		this.pageContent.empty();
	},

	
	toggleSlugEditField: function( e ){
//	    console.log( "revealSlugEditField", e );
		mop.util.stopEvent( e );
		var slug = this.titleElement.getElement( ".field-slug" );
		var ipe = slug.getElement( ".ipe" )
		var label = slug.getElement( "label" );
		if( ipe.hasClass( "hidden" ) ){
    		this.titleElement.getElement( ".field-slug .ipe" ).removeClass("hidden");
    		this.titleElement.getElement( ".field-slug" ).retrieve( "Class" ).enterEditMode();		    
    		label.set( "text", "Hide slug" );
		}else{
		    ipe.addClass( "hidden" );
		    slug.retrieve( "Class" ).cancelEditing( null );
    		label.set( "text", "Edit slug" );
		}
	},

/*  
    Section: Event Handlers
*/
	onTitleEdited: function( json ){
	    this.editSlugLink.retrieve( "Class" ).setValue( json.response.slug );
	},

	onJSLoaded: function( html, pageLoadCount ){
	    console.log( "onJSLoaded", html, pageLoadCount );
        console.log( this.toString(), "onJSLoaded", html );
		// keeps any callbacks from previous pageloads from registering
		if( pageLoadCount != this.currentPageLoadIndex ) return;
		this.scriptsLoaded++;
		console.log( this.scriptsLoaded, this.loadedJS.length-1 );
		if( this.scriptsLoaded == this.loadedJS.length-1 ){			
			this.populate( html );
		}
	},
	
	
/*
    Section: Server Requests
*/
	
    /*
    	Function: requestPage
    	Requests pageData and calls requestPageResponse on callback
    	Arguments: nodeId MoPObject Id of a page object.
    */
	requestPage: function( nodeId ){
 		mop.util.setObjectId( nodeId );        
	    return new Request.JSON( { url: this.getRequestPageURL( nodeId ), onSuccess: this.requestPageResponse.bind( this ) } ).send();
    },
    
	/*
		Function: requestPageResponse
		Callback to requestPage, loops through supplied JSON object and attached css, html, js, in that order then looks through #pageContent and initialize modules therein....
		Arguments:
			json - Object : { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	requestPageResponse: function( json ){
	    if( !json.returnValue ) console.log( this.toString(), "requestPageResponse error:", json.response.error );
		json.response.css.each( function( styleSheetURL, index ){
		    styleSheetURL = mop.util.getBaseURL() + styleSheetURL;
		    if( !this.loadedCSS.contains( styleSheetURL ) ) mop.util.loadStyleSheet( styleSheetURL );
		    this.loadedCSS.push( styleSheetURL );
		}, this );
		this.scriptsLoaded = 0;
		this.currentPageLoadIndex = this.pageLoadCount++;
		if( json.response.js.length ){
            json.response.js.each( function( urlString ){
                urlString = mop.util.getBaseURL() + urlString
                if( ( this.loadedJS.some( function( item ){ item.src == urlString } ) ) ){
                    this.loadedJS.push( mop.util.loadJS( urlString, { type: "text/javascript", onload: this.onJSLoaded.bind( this, [ json.response.html, this.currentPageLoadIndex ] ) } ) );
                }else{
         		    this.populate( json.response.html, this.currentPageLoadIndex );           
                }
            }, this );
		}
	},

/*
    Section: mop.modules.navigation.NavigtionDelegate Interface Requests and Response
*/

    onNodeSelected: function( nodeId ){
        console.log( this.toString(), "onNodeSelected", nodeId );
        this.clearPage();
        this.pageContent.spin();
        this.requestPage( nodeId );
    },
    
/*
    Section: mop.modules.navigation.NavigationDataSource Interface Requests and Response
*/

    requestTier: function( parentId, callback ){
        console.log( "requestTier", parentId );
        mop.util.setObjectId( parentId );
	    return new Request.JSON( {
	        url: this.getRequestTierURL( parentId ),
	        onSuccess: function( json ){
                 console.log( "requestTier, complete: ", json, json.returnValue );
                 this.requestTierResponse( json );
                 callback( json );
             }.bind( this )
        }).send();
    },

    requestTierResponse: function( json ){
        console.log( this.toString(), "requestTierResponse", json );
        if( !json.returnValue ) console.log( this.toString(), "requestTier error:", json.response.error );
    },

    saveSortRequest: function( objectId, idArray, callback ){},

	saveSortResponse: function( json ){
	    if( !json.returnValue ) console.log( this.toString(), "saveSortRequest error:", json.response.error );
	},
	
    addObjectRequest: function( parentId, templateId, nodeData, callback ){
        console.log( "addObjectRequest", parentId, templateId );
        return new Request.JSON({
            url: this.getAddObjectRequestURL( parentId, templateId ),
            onSuccess: function(){
                this.addObjectResponse();
                callback();
            }.bind( this )
        }).post( nodeData );
    },

    addObjectResponse: function( json ){
        if( !json.returnValue ) console.log( this.toString(), "addObjectRequest error:", json.response.error );
    },

    removeObjectRequest: function( parentId, callback ){
        return new Request.JSON({
            url: this.getRemoveObjectRequestURL( parentId ),
            onSuccess: function( json ){
                this.removeObjectResponse( json );
                callback();
            }.bind( this )
        }).send();
    },

    removeObjectResponse: function( json ){
        console.log( this.toString(), "removeObjectResponse", json, Array.from( arguments ) );
        if( !json.returnValue ) console.log( this.toString(), "removeObjectRequest error:", json.response.error );
    },

    /*
    Function: togglePublishedStatus
    Sends page publish toggle ajax call 
    Argument: pageId {Number}
    Callback: onTogglePublish
    */
    togglePublishedStatusRequest: function( nodeId, callback ){
        console.log( "::::", this.getTogglePublishedStatusRequestURL( nodeId ) );
        return new Request.JSON({
            url: this.getTogglePublishedStatusRequestURL( nodeId ),
            onSuccess: function(){
                this.togglePublishedStatusResponse();
                callback();
            }.bind( this )
        }).send();
    },
	
    togglePublishedStatusResponse: function( json ){
        if( !json.returnValue ) console.log( this.toString(), "togglePublishedStatusRequest error:", json.response.error );        
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
