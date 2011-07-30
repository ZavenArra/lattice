if( !mop.modules.navigation ) mop.modules.navigation = {};

mop.modules.navigation.Navigation = new Class({

	Extends: mop.MoPObject,
	Implements: [ Events, Options ],
	dataSource: null,
	nodeData: {},
	navPanes: [],
	breadCrumbs: null,
	tiers: [],
	numberOfVisiblePanes: 3,
	options: {
		addObjectPosition: 'bottom'
	},

	getNodeTypeFromId: function( nodeId ){
		return this.nodeData[ nodeId ].nodeType;
	},

	getContentTypeFromId: function( nodeId ){
		return this.nodeData[ nodeId ].contentType;
	},
	
	getIdFromSlug: function(){
//		this.nodeData.each( function( aNode ))
	},

	getSlugFromId: function( nodeId ){
		return this.nodeData[ nodeId ].slug;		
	},
	
	getNodeById: function( nodeId ){
		return this.nodeData[ nodeId ].node;
	},
	
	getUserLevel: function(){
		return this.userLevel;
	},
	
	onAppStateChanged: function( appState ){
		console.log( 'mop.modules.navigation.Navigation.appStateChanged', appState );
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
		this.paneContainer = this.element.getElement( ".panes" );
		this.navPanes = this.element.getElements( ".pane" );
		this.paneContainer.empty();
		this.instanceName = this.element.get("id");
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onCrumbClicked.bind( this ) );
		var rootId = this.dataSource.getRootNodeId();
		this.userLevel = ( Cookie.read( 'userLevel' ) )? Cookie.read( 'userLevel' ) : "superuser";
		console.log( "/////////////////////////////////" );
		console.log( "rootId:", rootId );	
		console.log( "userLevel:", this.userLevel );
		console.log( "appState:", mop.historyManager.getAppState() );
		console.log( "/////////////////////////////////" );
		var deepLink = null;//( mop.historyManager.getAppState().slug )? this.getNodeIdFromSlug( mop.historyManager.getAppState().slug ) : null;
		this.requestTier( rootId, null, deepLink );
	},

	addPane: function( parentId ){
		var newPane = this.navPaneTemplate.clone();
		this.navPanes.push( newPane );
		this.element.getElement( ".panes" ).adopt( newPane );
		var elementDimensions = this.paneContainer.getDimensions();
		this.paneContainer.setStyle( "width", elementDimensions.width + newPane.getDimensions().width );
		newPane.get( "spinner" ).show( true );
		return newPane;
	},

	requestTier: function( parentId, parentTier, deepLink ){
		var title;
		var paneIndex = 0;
		if( parentTier ){
			console.log( parentTier, parentTier.getActiveNode() );
			title = parentTier.getActiveNode().getElement( "h5" ).get( 'text' );
			parentId = parentTier.getActiveNodeId();
			paneIndex = this.navPanes.indexOf( parentTier.element );
			this.addCrumb( title, parentId, paneIndex );
		}
		if( this.navPanes.length > 0 ) this.clearPanes( paneIndex + 1 );	    
		var newPane = this.addPane( parentId );
		newPane.store( 'paneIndex', paneIndex );
		if( this.tiers[ parentId ] && !deepLink ){
			// if the tier has already been loaded and cached
			console.log( "requestTier", "cached", parentId, this.tiers[parentId] );
			this.renderPane( this.tiers[ parentId ], newPane );

		}else{
			// otherwise load send a tier request
			console.log( "requestTier", "uncached", parentId, newPane );
			if( this.currentTierRequest ) this.currentTierRequest.cancel();
			this.currentTierRequest = this.dataSource.requestTier( parentId, deepLink, function( json ){
				this.requestTierResponse( json, parentId, newPane );
			}.bind( this ) );
		}
	},

	saveTierSort: function( order ){
		this.dataSource.saveTierSortRequest( order );
	},

	requestTierResponse: function( json, parentId, containerPane ){
		console.log( "requestTierResponse", json, parentId, containerPane );
		json.response.data.nodes.each( function( nodeObj ){
//		console.log( nodeObj.id, nodeObj.slug );
			this.nodeData[ nodeObj.id ] = nodeObj;
		}, this );
		var tier = new mop.modules.navigation.Tier( this, json.response, parentId );
		this.tiers[ parentId ] = tier;
		this.renderPane( tier, containerPane, parentId );
	},

	renderPane: function( aTier, newPane, parentId ){
		newPane.unspin();
		console.log( aTier, newPane, parentId );
		newPane.set( 'id', 'pane-'+parentId );
		aTier.attachToPane( newPane );
		if( this.navPanes.indexOf( newPane ) < this.numberOfVisiblePanes ){
			var myFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toLeft();	        
		}else{	        
			var myFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toElementEdge( newPane );
		}
	},
    
	clearPanes: function( startIndex, endIndex ){
		if( startIndex == -1 ) startIndex = 0;
		if( !endIndex ) endIndex = this.navPanes.length;
		var panesToRemove = this.navPanes.filter( function( aPane, i ){
			if( i >= startIndex && i < endIndex ) return aPane;
		});
		console.log( ":: panesToRemove", "\n\t", startIndex, "\n\t", endIndex, "\n\t", panesToRemove );
		panesToRemove.each( function( aPane, index ){
			this.removeCrumb( this.navPanes.indexOf( aPane ) -1 ); // we want to remove the crumbs FOLLOWING the crumb that represents the current pane 
			this.navPanes.erase( aPane );
			aPane.unspin();
			aPane.retrieve( 'tier' ).detach();
			aPane.destroy();
		}, this );
	},
    
	onNodeSelected: function( nodeId ){
		console.log( ">>>> onNodeSelected", this.nodeData );
		this.marshal.onNodeSelected( nodeId );
	},

	addObject: function( parentId, templateId, nodeProperties, tierInstance ){
		this.dataSource.addObjectRequest( parentId, templateId, nodeProperties, function( json ){ this.onAddObjectResponse( json, parentId, tierInstance ); }.bind( this ) );
	},

	onAddObjectResponse: function( json, parentId, tierInstance ){
		this.nodeData[ json.response.data.id ] = json.response.data;
		console.log( "\t addObjectResponse", this.nodeData, "(", Object.getLength(this.nodeData), ")"  );
		var newNode = json.response.html.toElement();
		tierInstance.adoptNode( newNode );
		tierInstance.onObjectAdded();
	},

	removeObject: function( nodeId ){
		this.dataSource.removeObjectRequest( nodeId, this.onRemoveObjectResponse.bind( this, nodeId ) );
	},
  	
	onRemoveObjectResponse: function( nodeId ){
		delete this.nodeData[ nodeId ];
		console.log( "\tB removeObject", this.nodeData, "(", Object.getLength(this.nodeData), ")"  );
	},

	togglePublishedStatus: function( nodeId ){
		this.dataSource.togglePublishedStatusRequest( nodeId );        
	},

	onCrumbClicked: function( aNode ){
		console.log( ":::::::::::: onBreadCrumbClicked ", aNode.id );
		console.log( "\t", aNode.index );
		console.log( "\t", this.navPanes[ aNode.index ].retrieve( "tier" )  );
		this.requestTier( aNode.id, null, this.navPanes[ aNode.index ].retrieve( "tier" ) );
		this.marshal.onNodeSelected( aNode.id );
	},

	addCrumb: function( label, id, paneIndex ){
		console.log( "addBreadCrumb", label, id, paneIndex );
		this.breadCrumbs.addCrumb( { label: label, id: id, index: paneIndex });
	},

	removeCrumb: function( paneIndex ){
		this.breadCrumbs.removeCrumb( paneIndex );
	}

});

mop.modules.navigation.Tier = new Class({

	Implements: [ Options, Events ],
	nodes: null,
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
	
	initialize: function( aMarshal, response, parentId ){
		this.marshal = aMarshal;
		this.html = response.html;
		this.setOptions( response.data );
		this.parentId = parentId;
	},

	toString: function(){
		return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]"
	},

	getNodeIdFromElement: function( anElement ){
		return anElement.get("id").split( "_" )[1];
	},

	attachToPane: function( navPane ){
		navPane.store( "tier", this );
		this.options = Object.merge( this.options, navPane.getOptionsFromClassName() );
		this.element = navPane;
		this.render();
		this.spinner = new Spinner( this.element );
	},
	
	detach: function(){
		this.element.eliminate( "tier" );
		this.element = this.activeNode = null;
	},
	
	getActiveNode: function(){
		return this.activeNode;
	},
	
	getActiveNodeId: function(){
		return this.getNodeIdFromElement( this.activeNode );
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
   
	render: function( e ){
		console.log( 'render' );
		mop.util.stopEvent( e );
		this.element.set( 'html', this.html );
		this.nodeElement = this.element.getElement( ".nodes" );
		if( this.options.allowChildSort ) this.makeSortable( this.nodeElement );
		this.nodes = this.element.getElements(".node");
		this.nodes.each( function( aNodeElement ){
			this.initNode( aNodeElement );
		}, this );
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
				// this.superUserContextualMenu = new mop.ui.ContextualMenu( this.drawer, {
				// 	offset: { x: 0, y: 18 },
				// 	cols: 3,
				// 	content: this.drawer.getElements( "li" )
				// });
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
//  aNodeElement.addEvent( "focus", this.indicateNode.bindWithEvent( this, aNodeElement ) );
//	aNodeElement.addEvent( "blur", this.deindicateNode.bindWithEvent( this, aNodeElement ) );
		aNodeElement.store( "options", aNodeElement.getOptionsFromClassName() );
		aNodeElement.addEvent( "click", this.onNodeClicked.bindWithEvent( this, aNodeElement ) );
		var togglePublishedStatusElement = aNodeElement.getElement(".togglePublishedStatus");
		//        console.log( "togglePublishedStatusElement", togglePublishedStatusElement );
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

	onNodeClicked: function( e, nodeElement ){
		mop.util.stopEvent( e );
		var nodeId = this.getNodeIdFromElement( nodeElement );
		var slug = this.marshal.getSlugFromId( nodeId );
	 	console.log( "onNodeClicked", this.element, slug, nodeId );
		mop.historyManager.changeState( "slug", slug );
		if( this.activeNode )this.deindicateNode( this.activeNode );
		this.activeNode = nodeElement;
		this.indicateNode( nodeElement );
		this.onNodeSelected( nodeId );
		// if this specific tier has a pending request, we cancel it so the callback doesn't fire		
		if( this.marshal.getNodeTypeFromId( nodeId ) != "module" ){
			this.marshal.requestTier( nodeId, this, null );
		}else{
			this.marshal.clearPanes( this.element.retrieve( 'paneIndex' ) + 1 );
		}
	},
		
	onRemoveNodeClicked: function( e, nodeElement ){
		console.log( "\tonRemoveNodeClicked", this.marshal.nodeData, "(" , Object.getLength( this.marshal.nodeData ), ")" );
		mop.util.stopEvent( e );
		var confirmation = confirm( "Are you sure you want to remove " + nodeElement.getElement("h5").get("text") + " ?" );
		if( !confirmation ) return; 
		var nodeId = this.getNodeIdFromElement( nodeElement );
		nodeElement.destroy();
		this.removeObject( nodeId );
	},

   removeObject: function( nodeId ){
      this.marshal.removeObject( nodeId );
   },
	
   onTogglePublishedStatusClicked: function( e, nodeElement ){
      mop.util.stopEvent( e );
      console.log( "onTogglePublishedStatusClicked", e, nodeElement );
      var nodeId = this.getNodeIdFromElement( nodeElement );
      var togglePublishedStatusLink = nodeElement.getElement( ".togglePublishedStatus" );
      if( togglePublishedStatusLink.hasClass( "published" ) ){
         togglePublishedStatusLink.removeClass( "published" );
      }else{
         togglePublishedStatusLink.addClass( "published" );            
      }
      this.marshal.togglePublishedStatus( nodeId );
   },
    
   onNodeSelected: function( nodeId ){
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
		//this.element.setStyle( "border", "1px #f00 solid" );
		var nodeTitle = prompt( "What would you like to name this" + addText.substr( addText.lastIndexOf( " " ), addText.length ).toLowerCase() );
		if( !nodeTitle ) return;
		this.spinner.show( true );
		this.render();
		this.marshal.addObject( this.parentId, templateId, { title: nodeTitle }, this );
	},

	onObjectAdded: function(){
		this.spinner.hide();
	},

	makeSortable: function( sortableListElement ){	
		this.sortableListElement = sortableListElement;
		if( !this.sortableList ){
			this.sortableList = new mop.ui.Sortable( this.sortableListElement, this, this.sortableListElement  );
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
		console.log( "onOrderChanged", newOrder);
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

 
