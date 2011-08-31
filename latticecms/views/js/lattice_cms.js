/* Class: lattice.cms.CMS */

lattice.modules.CMS = new Class({

	/* Constructor: initialize */
	Extends: lattice.modules.Module,
	Interfaces: lattice.modules.navigation.NavigationDataSource,
	Implements: lattice.util.Broadcaster,

	rootObjectId: null,
  currentObjectId: null,
	loc: 'en',
	pageContainer: null,
	pages: {},
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
	
	getRequestTranslatedPageURL: function( nodeId, loc ){
		return lattice.util.getBaseURL() + "ajax/compound/cms/getTranslatedPage/" + nodeId + '/' + loc;
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
		this.loc = lattice.defaultLanguage;
		this.pageSlideFx = new Fx.Scroll( this.element.getElement('.pagesPane') );
//    console.log( this.options, this.elementClass, this.options.rootObjectId );
    this.rootNodeId = this.options.rootObjectId;
    $$( "script" ).each( function( aScriptTag ){ 
        this.loadedJS.push( aScriptTag.get("src") );
    }, this );
    $$( "link[rel=stylesheet]" ).each( 
        function( aStyleSheetTag ){this.loadedCSS.push(  aStyleSheetTag );
    }, this );
//	console.log( 'localizationControls', this.element.getElement( '.localizationControls' ) );		
		if( this.element.getElement( '.localizationControls' ) ){
			this.localizationControls = new lattice.ui.Menu( this.element.getElement( '.localizationControls' ), this, { onItemClicked: this.onLanguageSelected.bind( this ) } );
		}
	},

	onLanguageSelected: function( item ){
		var href, loc;
		href = item.get('href');
		loc = href.substr( href.lastIndexOf( "/" )+1, href.length );
		if( loc == this.loc ) return;
		this.loc = loc;
		console.log( 'onLanguageSelected:', this.loc );
		this.requestTranslatedPage( this.getObjectId(), this.loc );
	},
	 
	/* Section: Methods */
	toString: function(){return this.stringIdentifier},

	build: function(){
//		console.log( "build", this.element );
		this.pageContainer = $("pageContainer");
		this.initModules( this.element );
	},

	populate: function( html ){
		
		var page, langPage, langContainer, pageCount, w;

		if( !this.pages[ this.loc ] ){
			page = new Element( 'div', { 'class' : 'page page_' + this.loc } );
			this.currentPage  = new lattice.modules.CMSPage( page, this );
			this.pages[ this.loc ] = this.currentPage;
			this.pageContainer.adopt( page );
		}else{
			this.currentPage = this.pages[ this.loc ];
		}

		this.currentPage.populate( html );
		
		w = this.element.getElement('.pagesPane').getDimensions().width;
		pageCount = Object.getLength( this.pages );
		w *= pageCount + 1;
		this.pageContainer.setStyle( "width", w );
		console.log( ">>", this.pages, this.currentPage );
		this.slideToPage( this.currentPage );
	},
	
	slideToPage: function( aPage ){
		if( this.pageSlideFx ) this.pageSlideFx.cancel();
		this.pageSlideFx.toElement( aPage );
	},
    	
	clearPages: function(){
		this.pages.each( function( aPage ){
			aPage.clearContent();
		});
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
	
	requestTranslatedPage: function( nodeId, loc ){
		console.log( 'requestTranslatedPage', nodeId, loc );
		this.setObjectId( nodeId );

		var json = {
			returnValue: true,
			response: {
				data: { 
					id: this.getObjectId()
				},
				css: [],
				js: [],
				html: "<h1>LANGUAGE PAGE " + loc + "</h1>" 
			},
		};		

		this.requestPageResponse( json );
		// return new Request.JSON( { url: this.getRequestTranslatedPageURL( nodeId, loc ), onSuccess: function( json ){ 
		// 	this.requestPageResponse( json ); }.bind( this )
		// }).send();		
	},
    
	/*
		Function: requestPageResponse
		Callback to requestPage, loops through supplied JSON object and attached css, html, js, in that order then looks through #pageContainer and initialize modules therein....
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
				this.loadedJS.push( urlString );
				lattice.util.loadJS( urlString, {
					type: "text/javascript", 
					onload: this.onJSLoaded.bind( this, [ json.response.html ] )
				} );                    
			}
		}, this );
			console.log("A");
			if( noneLoaded ) this.populate( json.response.html );
		}else{
			console.log("B", json.response.html );
			this.populate( json.response.html );
		}
	},
	
/*
	Section: lattice.modules.navigation.NavigtionDelegate Interface Requests and Response
*/

	onNodeSelected: function( nodeId ){
		if( this.currentPage ){
			this.currentPage.clearContent();
			this.currentPage.spin();
		}
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
	},
	
	destroy: function(){
		this.clearPages();
		this.parent();
	}

});

lattice.modules.CMSPage = new Class({
	
	Extends: lattice.modules.Module,
	
	initialize: function( el, marshal, options ){
		this.parent(el, marshal, options);
	},
	
	spin: function(){
		this.element.spin();
	},
	
	populate: function( content ){
		var titleIPE;
		this.clearContent();
		this.element.set( 'html', content );
		this.UIFields = this.initUI( this.element );
		this.initModules( this.element );		
		this.titleElement = this.element.getElement( ".objectTitle" );
		if( this.titleElement ){
			titleIPE = this.titleElement.getElement('.ui-Text[data-field=title]').retrieve( "Class" );
			if( titleIPE ){
				titleIPE.addListener( this );
				this.addEvent( 'uifieldsaveresponse', this.marshal.onUIFieldSaved.bind( this ) );
			}
			this.slugIPE = this.titleElement.getElement( ".field-slug" );
		}
		this.element.unspin();
	},
	
	/*
		Function: initUIField
		Overrides lattice.modules.Module.initUIField to delegate internal module calls to CMS instead of CMSPage
	*/
	initUIField: function( uiClass, anElement, index ){
		var UIField = new uiClass( anElement, this.marshal, this.options );
		this.UIFields[ UIField.fieldName  ] = UIField;
		if( UIField ) UIField.setTabIndex( 'tabindex', index+1 );
	},
	
	/*
		Function: initModule
		Overrides lattice.modules.Module.initModule to delegate internal module calls to CMS instead of CMSPage
		returns - the module initialized
	*/
	initModule: function( anElement ){
		var elementClass, classPath, newModule, ref;
		elementClass = anElement.get( 'class' );
		classPath = lattice.util.getValueFromClassName( "classPath", elementClass ).split( "_" );
		classPath.each( function( node ){ ref = ( !ref )? this[node] : ref[node]; });
		newModule = new ref( anElement, this.marshal );
		return newModule;		
	},
	
	clearContent: function(){
		this.destroyChildModules( this.element );
		this.destroyUIFields( this.element );
		this.element.empty();
	},
	
	destroy: function(){
		this.clearContent();
		this.parent();
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
		lattice.CMS = new lattice.modules.CMS( 'cms' );
	});
}
