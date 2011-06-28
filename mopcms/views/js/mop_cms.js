/* Class: mop.cms.CMS */
mop.modules.CMS = new Class({
	/* Constructor: initialize */
	Extends: mop.modules.Module,
	Interfaces: [ mop.modules.navigation.NavigationDataSource ],
	
	objectId: null,
	pageContent: null,
	pageIdToLoad: null,
	scriptsLoaded: null,
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
    
    getRootNodeId: function(){       
       return this.rootNodeId;
    },



	/* Section: Constructor */
	initialize: function( anElement, options ){
     
     //this initializer and the initializer parent chain need to be rethough
     //because submodules are required to be initialize before the parent
     //what is the submodule have devependencies on the parent?
     //
     //this.parent( anElement, null, options );

      var aMarshal = null;
      this.setOptions( options );
		this.element = $( anElement );
		this.elementClass = this.element.get("class");
		this.marshal = aMarshal;
		this.element.store( 'Class', this );
		this.instanceName = this.element.get("id");


     	this.rootNodeId = this.getValueFromClassName( "objectId" );	


     
      console.log('hey'+this.element.get("id"));
		$$( "script" ).each( function( aScriptTag ){ 
		    this.loadedJS.push( aScriptTag.get("src") );
		}, this );
		$$( "link[rel=stylesheet]" ).each( 
		    function( aStyleSheetTag ){ this.loadedCSS.push(  aStyleSheetTag );
		}, this );
		console.log( ":::::: ", this.loadedJS );
      
      //this code needs to be reorganized
      this.pageContent = $("nodeContent");
      this.UIElements = this.initUI();
		this.initModules( this.element );
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
		this.UIElements = this.initUI( this.pageContent );
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

	onJSLoaded: function( html, jsLoadCount ){
		// keeps any callbacks from previous pageloads from registering
		this.scriptsLoaded++;
		console.log( "onJSLoaded", html, this.scriptsLoaded, this.loadedJS.length );
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
	    if( !json.returnValue ) throw json.response.error;
		json.response.css.each( function( styleSheetURL, index ){
		    styleSheetURL = mop.util.getBaseURL() + styleSheetURL;
		    if( !this.loadedCSS.contains( styleSheetURL ) ) mop.util.loadStyleSheet( styleSheetURL );
		    this.loadedCSS.push( styleSheetURL );
		}, this );
		this.scriptsLoaded = 0;
        var noneLoaded = true;
		if( json.response.js.length && json.response.js.length > 0){
            json.response.js.each( function( urlString, i ){
                urlString = mop.util.getBaseURL() + urlString;
                console.log( ":::: ", urlString, this.loadedJS.indexOf( urlString ) );
                if( this.loadedJS.indexOf( urlString ) == -1 ){
                    noneLoaded = false;
                    console.log( "::::::", urlString, "not in loadedJSArray" );
                    this.loadedJS.push( urlString );
                    mop.util.loadJS( urlString, { type: "text/javascript", onload: this.onJSLoaded.bind( this, [ json.response.html ] ) } );                    
                }
            }, this );
            if( noneLoaded ) this.populate( json.response.html );
		}else{
	       this.populate( json.response.html );
		}
	},

/*
    Section: mop.modules.navigation.NavigtionDelegate Interface Requests and Response
*/

    onNodeSelected: function( nodeId ){
        console.log( this.toString(), "onNodeSelected", nodeId );
        this.clearPage();
        if(this.pageContent){
        this.pageContent.spin();
         }
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
            onSuccess: function(json){
                this.addObjectResponse(json);
                callback(json);
            }.bind( this )
        }).post( nodeData );
    },

    addObjectResponse: function( json ){
        if( !json.returnValue ) console.log( this.toString(), "addObjectRequest error:", json.response.error );
    },

    removeObjectRequest: function( parentId, callback ){
        return new Request.JSON({
            url: this.getRemoveObjectRequestURL( parentId ),
            onSuccess: function( json ){ this.removeObjectResponse( json ); callback(); }.bind( this )
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
