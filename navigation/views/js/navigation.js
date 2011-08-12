if( !mop.modules.navigation ) mop.modules.navigation = {};

mop.modules.navigation.Navigation = new Class({

	Extends: mop.MoPObject,
	Implements: [ Events, Options ],
	rootId: 0,
	dataSource: null,
	nodeData: {},
	breadCrumbs: null,
	tiers: [],
	numberOfVisiblePanes: 3,
	options: {
		addObjectPosition: 'bottom'
	},

	getNodeTypeFromId: function( nodeId ){ return this.nodeData[ nodeId ].nodeType; },
	getContentTypeFromId: function( nodeId ){ return this.nodeData[ nodeId ].contentType; },
	getNodeTitleFromId: function( nodeId ){ if( this.nodeData[ nodeId ] ){ return this.nodeData[ nodeId ].title; }else{ return null; } },
	getSlugFromId: function( nodeId ){ return this.nodeData[ nodeId ].slug; },
	getNodeById: function( nodeId ){ return this.nodeData[ nodeId ].node; },
	getUserLevel: function(){ return this.userLevel; },
	getPanes: function(){ return this.container.getElements('.pane'); },
	getPaneTemplate: function(){ return this.navPaneTemplate.clone(); },
	getVisibleTiers: function(){
		var visibleTiers = [];
		this.getPanes().each( function( aPane ){
			visibleTiers.push( aPane.retrieve('tier') );
		});
		return visibleTiers;
	},
	
	onAppStateChanged: function( appState ){ console.log( 'mop.modules.navigation.Navigation.appStateChanged', appState ); },	
	onNodeSelected: function( nodeId ){ 
		this.marshal.onNodeSelected( nodeId );
	},
	onObjectNameChanged: function( objId, name ){
		this.nodeData[ objId ].title = name;
		$( 'node_' + objId ).getElement( "h5" ).set( 'text', name );
	},
	
	initialize: function( element, marshal, options ){
		this.setOptions( options );
		this.parent( element, marshal, options );
		mop.historyManager.addListener( this );
		
		this.addEvent( 'appstatechanged', function( appState ){
			this.onAppStateChanged( appState );
		}.bind( this ) );
		
		this.dataSource = ( !this.options.dataSource )? this.marshal : this.options.dataSource;
		this.dataSource.addListener( this );
		this.addEvent( 'objectnamechanged', this.onObjectNameChanged.bind( this ) );
		
		this.navPaneTemplate = this.element.getElement( ".pane" ).dispose();
		this.container = this.element.getElement( ".panes" );
		
		this.container.empty();
		this.instanceName = this.element.get("id");
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onCrumbClicked.bind( this ) );
		this.rootId = this.dataSource.getRootNodeId();
		this.userLevel = ( Cookie.read( 'userLevel' ) )? Cookie.read( 'userLevel' ) : "superuser";
		console.log( "/////////////////////////////////" );
		console.log( "rootId:", this.rootId );	
		console.log( "userLevel:", this.userLevel );
		console.log( "appState:", mop.historyManager.getAppState() );
		console.log( "/////////////////////////////////" );
		var deepLink = ( mop.historyManager.getAppState().slug )? mop.historyManager.getAppState().slug : null;
		this.requestTier( this.rootId, null, deepLink );
	},

	addPane: function(){
		var newPane = this.getPaneTemplate();
		this.element.getElement( ".panes" ).adopt( newPane );
		var elementDimensions = this.container.getDimensions();
		this.container.setStyle( "width", elementDimensions.width + newPane.getDimensions().width );
		newPane.get( "spinner" ).show( true );
		return newPane;
	},
	
	adoptPane: function( pane ){
		this.element.getElement( ".panes").adopt( pane );
		return pane;
	},

	requestTier: function( nodeId, parentTier, deepLink ){
		cached = ( this.tiers[ nodeId ] && !deepLink )? 'cached' : 'not cached';
		if( this.tiers[ nodeId ] && !deepLink ){
			this.renderPane( this.tiers[ nodeId ] );
		}else{
			pane = this.addPane();
			this.dataSource.requestTier( nodeId, deepLink, function( json ){ this.requestTierResponse( json, nodeId, pane ); }.bind( this ) );
		}
	},

	saveTierSort: function( order ){
		this.dataSource.saveTierSortRequest( order );
	},

	requestTierResponse: function( json, tierId, containerPane ){
		var tier;
		json.response.data.tier.nodes.each( function( nodeObj ){
			this.nodeData[ nodeObj.id ] = nodeObj;
		}, this );
		console.log( "nodeData", this.nodeData );
		tier = new mop.modules.navigation.Tier( this, json.response.data.tier, tierId );
		this.tiers[ tierId ] = tier;
		this.renderPane( tier, containerPane, tierId );
	},

	renderPane: function( aTier, newPane, nodeId ){
		
		var nodeId, navSlideFx, nodeTitle;
		
		if( Array.from( arguments ).length == 1 ){ //if cached
			aTier.render();
			newPane = aTier.element;
			nodeId = aTier.id;
			aTier.attachToPane();
		}else{
			newPane.unspin();
			aTier.attachToPane( newPane );			
		}
		if( this.getPanes().indexOf( newPane ) < this.numberOfVisiblePanes ){
			navSlideFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toLeft();	        
		}else{	        
			navSlideFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toElementEdge( newPane );
		}
		nodeTitle = ( this.getNodeTitleFromId( nodeId ) )? this.getNodeTitleFromId( nodeId ) : '/';  
		this.addCrumb( nodeTitle, aTier );
	},

	detachTiers: function( startIndex, endIndex ){
		var visibleTiers, tiersToDetach;
		visibleTiers = this.getVisibleTiers();
		if( startIndex < 0 ) startIndex = 0;
		if( !endIndex ) endIndex = visibleTiers.length;		
		var tiersToDetach = visibleTiers.filter( function( aTier, i ){
			if( i >= startIndex && i < endIndex ) return aTier;
		});
		tiersToDetach.each( function( aTier ){ aTier.detach(); });
	},
	
	removeCrumbs: function( startIndex, endIndex ){
		var crumbs, crumbsToRemove;
		crumbs = this.breadCrumbs.getCrumbs();
		if( startIndex < 0 ) startIndex = 0;
		if( !endIndex ) endIndex = crumbs.length;		
		var crumbsToRemove = crumbs.filter( function( aCrumb, i ){
			if( i >= startIndex && i < endIndex ) return aCrumb;
		});
		this.breadCrumbs.removeCrumbs( crumbsToRemove );		
	},
    
	addObject: function( parentId, templateId, nodeProperties, tierInstance ){
		this.dataSource.addObjectRequest( parentId, templateId, nodeProperties, function( json ){ this.onAddObjectResponse( json, parentId, tierInstance ); }.bind( this ) );
	},

	onAddObjectResponse: function( json, parentId, tierInstance ){
		this.nodeData[ json.response.data.id ] = json.response.data;
//		console.log( "\t addObjectResponse", this.nodeData, "(", Object.getLength(this.nodeData), ")"  );
		var newNode = json.response.html.toElement();
		tierInstance.adoptNode( newNode );
		tierInstance.onObjectAdded();
	},

	removeObject: function( nodeId ){
		this.dataSource.removeObjectRequest( nodeId, this.onRemoveObjectResponse.bind( this, nodeId ) );
		// if object is loaded we need to call
		// this.marshal.clearPage();
		// and rmove the breadcrumb
	},
  	
	onRemoveObjectResponse: function( nodeId ){
		delete this.nodeData[ nodeId ];
//		console.log( "\tB removeObject", this.nodeData, "(", Object.getLength(this.nodeData), ")"  );
	},

	togglePublishedStatus: function( nodeId ){
		this.dataSource.togglePublishedStatusRequest( nodeId );        
	},

	prepareTier: function( parentTier ){
		var visibleTiers, paneIndex, pane, nodeTitle;
		visibleTiers = this.container.getElements( '.pane' );
		paneIndex = ( parentTier )? visibleTiers.indexOf( parentTier.element ) : 0;
		console.log( "requestTier detach ", paneIndex + 1 );
		this.removeCrumbs( paneIndex + 1 );
		this.detachTiers( paneIndex + 1 );
	},

	onCrumbClicked: function( crumbData ){
		console.log( "onCrumbClicked", crumbData );
//		prepareTier( )
		this.requestTier( crumbData.tier.id, crumbData.tier );
		if( this.nodeData[ crumbData.tier.id ] ){
			this.marshal.onNodeSelected( crumbData.tier.id );
		}else{
			this.marshal.clearPage();
		}
	},

	addCrumb: function( label, tier ){
		this.breadCrumbs.addCrumb( { label: label, tier: tier } );
	}


});

mop.modules.navigation.Tier = new Class({

	Implements: [ Options, Events ],
	nodes: null,
	element: null,
	nodeElement: null,
	html: null,
	parentId: null,
	activeNode: null,
	drawer: null,
	sortableList: null,

	options: { 
		addPosition: 'bottom',
		allowChildSort: true
	},
	
	getActiveNode: function(){ return this.activeNode; },
	
	setActiveNode: function( el ){
		if( this.activeNode )this.deindicateNode( this.activeNode );
		this.activeNode = el;
		this.indicateNode( el );
	},
	
	getActiveNodeId: function(){
		return this.getNodeIdFromElement( this.activeNode );
	},
	
	initialize: function( aMarshal, data, nodeId ){
		this.marshal = aMarshal;
		this.html = data.html;
		this.id = nodeId;
	},

	toString: function(){
		return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]"
	},

	getNodeIdFromElement: function( anElement ){
		return anElement.get("id").split( "_" )[1];
	},
	
	getNodeById: function( id ){
		return this.element.getElement( "#node_"+id );
	},

	attachToPane: function( pane ){
		if( pane ){
			pane.store( "tier", this );
			pane.set( 'id', 'pane-' + this.id );
			this.options = Object.merge( this.options, pane.getOptionsFromClassName() );
			this.element = pane;			
			this.spinner = new Spinner( this.element );
		}else{
			this.marshal.adoptPane( this.element );
		}
		this.render();
		
	},
	
	detach: function(){
		this.element.unspin();
		this.element = this.element.dispose();
		this.activeNode = null;
	},
		
	adoptNode: function( newNode ){
		if( this.options.addPosition == "top" ){
			this.nodeElement.grab( newNode, 'top' );			
		}else{
			if( this.nodeElement.getElement( ".module" ) ){
				this.nodeElement.getElement( ".module" ).grab( newNode, 'before' );
			}else{
				this.nodeElement.grab( newNode, 'bottom' );				
			}
		}
		this.html = this.element.get( "html" );
		this.initNode( newNode );
	},
   
	render: function(){
		if( this.element.get('html') != this.html ) this.element.set( 'html', this.html );
		this.nodeElement = this.element.getElement( ".nodes" );
		if( this.options.allowChildSort ) this.makeSortable( this.nodeElement );
		this.nodes = this.element.getElements(".node");
		this.nodes.each( function( aNodeElement ){ this.initNode( aNodeElement ); }, this );
		this.drawer = this.element.getElement( '.tierMethodsDrawer' );
 		if( this.drawer ){
			this.drawer.set( "morph", {
				duration: 200, 
				transition: Fx.Transitions.Quad.easeInOut
			});
			// make nodes element shorter by the height of the addableObjects title height
			this.nodeElement.setStyle( 'height', this.nodeElement.getSize().y - this.drawer.getElement( "div.titleBar" ).getDimensions().height );
			this.drawer.getElement( '.close' ).addClass( 'hidden' );
			this.drawer.setStyle( 'height', 'auto' );
			this.drawer.getElement( 'ul.addableObjects' ).setStyle( 'height', 'auto' );
			this.drawer.getElement( '.close' ).addEvent( 'click', this.render.bindWithEvent( this ) );
			if( !this.drawer.retrieve( 'initTop' ) ) this.drawer.store( "initTop", this.drawer.getStyle( "top" ) );	
			this.drawer.setStyle( 'top', this.drawer.retrieve( 'initTop' ) );
			var addObjectLinks = this.drawer.getElements( "li" );
			// wire addobject links
			addObjectLinks.each( function( aLink ){
				aLink.addEvent( "click", this.onAddObjectClicked.bindWithEvent( this, aLink ) );
			}, this );
			if( this.marshal.getUserLevel() == 'superuser' && addObjectLinks.length > 5  ){
				this.element.removeClass( "dark" );
				this.drawer.getElement( ".close" ).addClass("hidden");
			 	this.drawer.setStyle( 'top', this.drawer.retrieve( 'initTop' ) );
				this.drawer.addEvent( 'click', this.renderAddObjectSelection.bindWithEvent( this, addObjectLinks ) );
			}else{
				this.drawer.addEvent( 'mouseenter', this.onDrawerMouseEnter.bindWithEvent( this ) );
				this.drawer.addEvent( 'mouseleave', this.onDrawerMouseLeave.bindWithEvent( this ) );
			}
		}
	},
	
	renderAddObjectSelection: function( e, addObjectLinks ){
		mop.util.stopEvent( e );
		this.nodeElement.addClass( 'hidden' );
		this.drawer.setStyle( 'height', '100%' );
		this.drawer.getElement( '.close' ).removeClass( 'hidden' );
		var h = this.element.getSize().y - this.drawer.getElement( "div.titleBar" ).getSize().y;
		this.drawer.getElement( 'ul.addableObjects' ).setStyle( 'height', h );
		this.drawer.morph( { 'top': 0 } );
	},

	initNode: function( aNodeElement ){
		aNodeElement.store( "options", aNodeElement.getOptionsFromClassName() );
		aNodeElement.addEvent( "click", this.onNodeClicked.bindWithEvent( this, aNodeElement ) );
		var togglePublishedStatusElement = aNodeElement.getElement(".togglePublishedStatus");
		if( togglePublishedStatusElement ){
			togglePublishedStatusElement.addEvent( "click", this.onTogglePublishedStatusClicked.bindWithEvent( this, aNodeElement ) );
		}
		var removeNodeElement = aNodeElement.getElement(".removeNode");
		if( removeNodeElement ){
			removeNodeElement.addEvent( "click", this.onRemoveNodeClicked.bindWithEvent( this, aNodeElement ) );
		}
	},

	indicateNode: function( nodeElement ){
		nodeElement.addClass( "active");
	},

	deindicateNode: function( nodeElement ){
		nodeElement.removeClass("active");
	},

/*	Section: Event Handlers	*/

	onMouseEnter: function( e, nodeElement ){
		mop.util.stopEvent( e );
		this.indicateNode( aNodeElement );
	},

	onMouseLeave: function( e, nodeElement ){
		mop.util.stopEvent( e );
		if( this.activeNode != nodeElement ) this.deindicateNode( nodeElement );
	},

	onNodeClicked: function( e, el ){
		mop.util.stopEvent( e );
		this.onNodeSelected( el );
	},
		
	onRemoveNodeClicked: function( e, nodeElement ){
//		console.log( "\tonRemoveNodeClicked", this.marshal.nodeData, "(" , Object.getLength( this.marshal.nodeData ), ")" );
		mop.util.stopEvent( e );
		var confirmation = confirm( "Are you sure you want to remove " + nodeElement.getElement("h5").get("text") + " ?" );
		if( !confirmation ) return; 
		var nodeId = this.getNodeIdFromElement( nodeElement );
		nodeElement.destroy();
		this.removeObject( nodeId );
	},

   removeObject: function( nodeElement, nodeId ){
      this.marshal.removeObject( nodeId );
   },
	
   onTogglePublishedStatusClicked: function( e, nodeElement ){
      mop.util.stopEvent( e );
			var nodeId, togglePublishedStatusLink;
      nodeId = this.getNodeIdFromElement( nodeElement );
      togglePublishedStatusLink = nodeElement.getElement( ".togglePublishedStatus" );
      if( togglePublishedStatusLink.hasClass( "published" ) ){
         togglePublishedStatusLink.removeClass( "published" );
      }else{
         togglePublishedStatusLink.addClass( "published" );            
      }
      this.marshal.togglePublishedStatus( nodeId );
   },
    
   onNodeSelected: function( el ){
			var nodeId, slug;
			nodeId = this.getNodeIdFromElement( el );
			slug = this.marshal.getSlugFromId( nodeId );
			this.setActiveNode( el );
			console.log( ":::", el.getOptionsFromClassName() );
			mop.historyManager.changeState( "slug", slug );
			if( this.marshal.getNodeTypeFromId( nodeId ) != "module" ) this.marshal.requestTier( nodeId, this, null );
      this.marshal.onNodeSelected( nodeId );
   },
	
	onDrawerMouseEnter: function( e ){
		var top = this.element.getSize().y - this.drawer.getSize().y;
		//    console.log( ":::::: onDrawerMouseEnter ::", this.nodeElement, this.nodeElement.getSize() );
		this.drawer.morph( { 'top': top } );
	},

	onDrawerMouseLeave: function( e ){
		var top = this.nodeElement.getSize().y - this.drawer.getElement( "h5" ).getSize().y;
		this.drawer.morph( { 'top': this.drawer.retrieve( "initTop" ) } );
	},

	onAddObjectClicked: function( e, addObjectButton ){
		mop.util.stopEvent( e );
		var templateId = mop.util.getValueFromClassName( "objectTypeId", addObjectButton.get("class") );
		var addText = addObjectButton.get( 'text' );
		var nodeTitle = prompt( "What would you like to name this" + addText.substr( addText.lastIndexOf( " " ), addText.length ).toLowerCase() );
		if( !nodeTitle ) return;
		this.spinner.show( true );
		this.render();
		this.marshal.addObject( this.id, templateId, { title: nodeTitle }, this );
	},

	onObjectAdded: function(){ this.spinner.hide(); },

	makeSortable: function( sortableListElement ){	
		this.sortableListElement = sortableListElement;
		if( !this.sortableList ){
			this.sortableList = new mop.ui.Sortable( this.sortableListElement, this, this.sortableListElement  );
			// alert( sortableListElement.getElements( '.module' ).length );
			// alert( this.sortableList.removeItems( sortableListElement.getElements( '.module' ) ) );
		}else{
			this.sortableList.attach();
		}
		this.oldSort = this.serialize();
	},
	
	removeSortable: function( aSortable ){
		aSortable.detach();
		delete aSortable;
		aSortable = null;
	},

	onOrderChanged: function(){
		var newOrder = this.serialize();
//		console.log( "onOrderChanged", newOrder);
		clearInterval( this.submitDelay );
		this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder.join(",") );
		newOrder = null;
	},

	submitSortOrder: function( newOrder ){
		if( this.options.allowChildSort && this.oldSort != newOrder ){
			clearInterval( this.submitDelay );
			this.submitDelay = null;
			this.marshal.saveTierSort( newOrder );
			this.oldSort = newOrder;
		}
	},

	serialize:function(){
		var sortArray = [];
		var children = this.sortableListElement.getChildren("li");
		children.each( function ( aListing ){
			if( aListing.get( "id" ) ){
	//    		    console.log( this.toString(), aListing, aListing.get( "id" ) ); 	
				var listItemId = aListing.get("id");
				var listItemIdSplit = listItemId.split( "_" );
				listItemId = listItemIdSplit[ listItemIdSplit.length - 1 ];
				sortArray.push( listItemId );		        
			}
		});
		return sortArray;
	},
		
	onNodeRenamed: function(){

	},

	dispose: function(){

	}
	

});

 
