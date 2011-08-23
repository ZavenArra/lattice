/* Class: lattice.cms.CMS */

lattice.modules.CMS = new Class({

	/* Constructor: initialize */
	Extends: lattice.modules.Module,
	Interfaces: lattice.modules.navigation.NavigationDataSource,
	Implements: lattice.util.Broadcaster,

	rootObjectId: null,
  currentObjectId: null,
	pageContent: null,
	pageIdToLoad: null,
	scriptsLoaded: null,
	titleElement: null,
	slugIPE: null,
	loadedCSS: [],
	loadedJS: [],
	stringIdentifier: "[ object, lattice.modules.CMS ]",
	options: {},

	/* Section: Getters & Setters */    
    
	getRemoveObjectRequestURL: function( parentId ){
		return lattice.util.getBaseURL() + "ajax/compound/cms/removeObject/" + parentId;
	},

	getRequestPageURL: function( nodeId ){
		return lattice.util.getBaseURL() + "ajax/compound/cms/getPage/" + nodeId;
	},

	getRequestTierURL: function( parentId, deepLink ){
		var deepLinkAppend, url;
		deepLinkAppend = ( deepLink )? "/" + deepLink : '';
		url = lattice.util.getBaseURL() + "ajax/compound/navigation/getTier/" + parentId + deepLinkAppend;
		return url;
	},

	getSaveFileSubmitURL: function(){
			return lattice.util.getBaseURL() + 'ajax/data/cms/savefile/' + this.getObjectId()+"/";
	},
	
	getAddObjectRequestURL: function( parentId, templateId ){
		return lattice.util.getBaseURL() + "ajax/compound/cms/addObject/" + parentId + "/" + templateId;
	},

	getTogglePublishedStatusRequestURL: function( nodeId ){            
		return lattice.util.getBaseURL() + "ajax/data/cms/togglePublish/"+ nodeId;
	},

	getSaveFieldURL: function(){
		return  lattice.util.getBaseURL() + "ajax/data/cms/savefield/"+ this.getObjectId();
	},	

	getSubmitSortOrderURL: function(){
	    return lattice.util.getBaseURL() + "ajax/data/cms/saveSortOrder/" + this.getObjectId();
	},
	
	getGetTagsURL: function(){
    return lattice.util.getBaseURL() + "ajax/data/cms/getTags/" + this.getObjectId();		
	},
	
	getAddTagURL: function(){
    return lattice.util.getBaseURL() + "ajax/data/cms/addTag/" + this.getObjectId();		
	},
	
	getRemoveTagURL: function(){
    return lattice.util.getBaseURL() + "ajax/data/cms/removeTag/" + this.getObjectId();		
	},

	getRootNodeId: function(){ return this.options.rootObjectId; },

	getObjectId: function(){ return this.currentObjectId; },
	setObjectId: function( objectId ){ this.currentObjectId = objectId;	},

	/* Section: Constructor */
	initialize: function( anElement, options ){
    this.parent( anElement, null, options );
//    console.log( this.options, this.elementClass, this.options.rootObjectId );
    this.rootNodeId = this.options.rootObjectId;
    $$( "script" ).each( function( aScriptTag ){ 
        this.loadedJS.push( aScriptTag.get("src") );
    }, this );
    $$( "link[rel=stylesheet]" ).each( 
        function( aStyleSheetTag ){this.loadedCSS.push(  aStyleSheetTag );
    }, this );
	},

	/* Section: Methods */
	toString: function(){return this.stringIdentifier},

	build: function(){
//		console.log( "build", this.element );
		this.pageContent = $("nodeContent");
		this.initModules( this.element );
	},

	populate: function( html ){
		var titleIPE;
		this.pageContent.set( 'html', html );
		
		this.UIFields = this.initUI( this.pageContent );
//		console.log( "populate", this.toString(), this.pageContent );
		this.initModules( this.pageContent );		
		this.titleElement = this.element.getElement( ".objectTitle" );
		if( this.titleElement ){
			titleIPE = this.titleElement.getElement('.ui-Text[data-field=title]').retrieve( "Class" );
			if( titleIPE ){
				titleIPE.addListener( this );
				this.addEvent( 'uifieldsaveresponse', this.onUIFieldSaved.bind( this ) );
			}
   		this.slugIPE = this.titleElement.getElement( ".field-slug" );
		}
		this.pageContent.unspin();
	},
    	
	clearPage: function(){
//		console.log( "clearPage" );
		this.destroyChildModules( this.pageContent );
		this.destroyUIFields();
		this.pageContent.empty();
	},
	
	onUIFieldSaved: function( fieldName, response ){
		console.log( "onUIFieldSaved", fieldName, response );
		switch( fieldName ){
			case 'title':
				this.onTitleEdited(  response );
			break;
		}
	},

/*  
    Section: Event Handlers
*/
	onTitleEdited: function( response ){
		this.broadcastMessage( 'objectnamechanged', [ this.getObjectId(), response.value ] );
    if( this.slugIPE ) this.slugIPE.retrieve( "Class" ).setValue( response.slug );
	},

	onJSLoaded: function( html, jsLoadCount ){
		// keeps any callbacks from previous pageloads from registering
		this.scriptsLoaded++;
//		console.log( this, "onJSLoaded", html, this.scriptsLoaded, this.loadedJS.length );
		if( this.loadedJS.length == this.loadedJS.length ){			
			this.populate( html );
		}
	},
	
	
/*
    Section: Server Requests
*/
	
    /*
    	Function: requestPage
    	Requests pageData and calls requestPageResponse on callback
    	Arguments: nodeId LatticeObject Id of a page object.
    */
	requestPage: function( nodeId ){
			this.setObjectId( nodeId );
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
			if( json.response.data ) this.setObjectId( json.response.data.id );
      json.response.css.each( function( styleSheetURL, index ){
         styleSheetURL = lattice.util.getBaseURL() + styleSheetURL;
         if( !this.loadedCSS.contains( styleSheetURL ) ) lattice.util.loadStyleSheet( styleSheetURL );
         this.loadedCSS.push( styleSheetURL );
      }, this );
      this.scriptsLoaded = 0;
      var noneLoaded = true;
      if( json.response.js.length && json.response.js.length > 0){
         json.response.js.each( function( urlString, i ){
            urlString = lattice.util.getBaseURL() + urlString;
            //                console.log( ":::: ", urlString, this.loadedJS.indexOf( urlString ) );
            if( this.loadedJS.indexOf( urlString ) == -1 ){
               noneLoaded = false;
               //                   console.log( "::::::", urlString, "not in loadedJSArray" );
               this.loadedJS.push( urlString );
               lattice.util.loadJS( urlString, {
                  type: "text/javascript", 
                  onload: this.onJSLoaded.bind( this, [ json.response.html ] )
               } );                    
            }
         }, this );
         if( noneLoaded ) this.populate( json.response.html );
      }else{
         this.populate( json.response.html );
      }
   },

/*
	Section: lattice.modules.navigation.NavigtionDelegate Interface Requests and Response
*/

	onNodeSelected: function( nodeId ){
		this.clearPage();
		this.pageContent.get( 'spinner' ).show();
		if( this.pageRequest ) this.pageRequest.cancel();
		this.pageRequest = this.requestPage( nodeId );
	},

/*
	Section: lattice.modules.navigation.NavigationDataSource Interface Requests and Response
*/
	requestTier: function( parentId, deepLink, callback ){
		var url;
		url = this.getRequestTierURL( parentId, deepLink );
//		console.log( 'cms.requestTier.url:', url );
		this.setObjectId( parentId );
		this.clearPendingTierRequest()
		this.currentTierRequest = new Request.JSON( {
			url: url,
			onSuccess: function( json ){
				this.requestTierResponse( json );
				callback( json );
			}.bind( this )
		}).send();
		return this.currentTierRequest;
	},

	clearPendingTierRequest: function( json ){
		if( this.currentTierRequest ) this.currentTierRequest.cancel();
		this.currentTierRequest = null;
	},
	
	requestTierResponse: function( json ){
		this.clearPendingTierRequest();
		if( !json.returnValue ) throw  this.toString() + " requestTier error: " + json.response.error;
	},

	saveTierSortRequest: function( newOrder, objectId ){
		return new Request.JSON( { url: this.getSubmitSortOrderURL(objectId), onComplete: this.saveSortResponse.bind( this ) } ).post( { sortOrder: newOrder } );	
	},

	saveSortResponse: function( json ){
		if( !json.returnValue ) console.log( this.toString(), "saveSortRequest error:", json.response.error );
	},
	
	addObjectRequest: function( parentId, templateId, nodeProperties, callback ){
		console.log( "addObjectRequest", parentId, templateId, nodeProperties, callback );
		return new Request.JSON({
			url: this.getAddObjectRequestURL( parentId, templateId ),
			onSuccess: function( json  ){
				this.addObjectResponse( json );
				callback( json );
			}.bind( this )
		}).post( nodeProperties );
	},

	addObjectResponse: function( json ){
		console.log( "addObjectResponse", json );
		if( !json.returnValue ) console.log( this.toString(), "addObjectRequest error:", json.response.error );
	},

	getTags: function( callback ){
		return new Request.JSON({
			url: this.getGetTagsURL(),
			onSuccess: function( json  ){
				if( callback ) callback( json );
			}.bind( this )
		}).send();				
	},
	
	addTag: function( tag, callback ){
		return new Request.JSON({
			url: this.getAddTagURL(),
			onSuccess: function( json  ){
				if( callback ) callback( json );
			}.bind( this )
		}).post( { tag: tag } );		
	},
	
	removeTag: function( tag, callback ){
		return new Request.JSON({
			url: this.getRemoveTagURL(),
			onSuccess: function( json  ){
				if( callback ) callback( json );
			}.bind( this )
		}).post( { tag: tag } );
	},
	
	removeObjectRequest: function( parentId, callback ){
		return new Request.JSON({
			url: this.getRemoveObjectRequestURL( parentId ),
			onSuccess: function( json ){
				this.removeObjectResponse( json );
				if( callback ) callback();
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
			onSuccess: function( json ){
				this.togglePublishedStatusResponse( json );
				if( callback ) callback( json );
			}.bind( this )
		}).send();
	},

	togglePublishedStatusResponse: function( json ){
	if( !json.returnValue ) console.log( this.toString(), "togglePublishedStatusRequest error:", json.response.error );        
	}

	});

if( !lattice.util.hasDOMReadyFired() ){
	window.addEvent( "domready", function(){
		lattice.util.DOMReadyHasFired();
		lattice.historyManager = new lattice.util.HistoryManager().instance();
		lattice.historyManager.init();
		lattice.modalManager = new lattice.ui.ModalManager();
		if( lattice.loginTimeout && lattice.loginTimeout > 0 ) lattice.loginMonitor = new lattice.util.LoginMonitor();
		lattice.util.EventManager.broadcastMessage( "resize" );
		lattice.CMS = new lattice.modules.CMS( "cms" );
	});
}
