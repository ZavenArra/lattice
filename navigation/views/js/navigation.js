if( !mop.modules.navigation) mop.modules.navigation = {};

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

	initialize: function( element, marshal, options ){
		this.setOptions( options );
		this.parent( element, marshal, options );
		this.dataSource = ( !this.options.dataSource )? this.marshal : this.options.dataSource;
		this.navPaneTemplate = this.element.getElement( ".pane" ).dispose();
		this.paneContainer = this.element.getElement( ".panes" );
		this.navPanes = this.element.getElements( ".pane" );
		this.paneContainer.empty();
		this.instanceName = this.element.get("id");
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onCrumbClicked.bind( this ) );
		var rootId = this.dataSource.getRootNodeId();
		console.log( "rootId", rootId );
		this.requestTier( rootId, null );
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

	requestTier: function( parentId, parentTier ){
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
		if( this.tiers[ parentId ] ){
			// if the tier has already been loaded and cached
			console.log( "requestTier", "cached" );
			this.renderPane( this.tiers[ parentId ], newPane );
		}else{
			// otherwise load send a tier request
			console.log( "requestTier", "uncached" );
			this.dataSource.requestTier( parentId, function( json ){
				this.requestTierResponse( json, parentId, newPane );
			}.bind( this ) );
		}
	},

	requestTierResponse: function( json, parentId, containerPane ){
//      console.log( "requestTierResponse", json, parentId, containerPane );
		//this.nodeData[ parentId ] = json.response.data.nodes;
		json.response.data.nodes.each( function( nodeObj ){
			this.nodeData[ nodeObj.id ] = nodeObj;
		}, this );
		console.log( "requestTierResponse", parentId, this.nodeData );
		this.nodeData = Object.merge( this.nodeData, json.response.data.nodes );
		var tier = new mop.modules.navigation.Tier( this, json.response.html, parentId );
		this.tiers[ parentId ] = tier;
		this.renderPane( tier, containerPane, parentId );
	},

	renderPane: function( aTier, newPane, parentId ){
		newPane.unspin();
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
   //        window.location.hash = this.nodeData[ nodeId ].slug;
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
      this.requestTier( aNode.id, this.navPanes[ aNode.index ].retrieve( "tier" ) );
      this.marshal.onNodeSelected( aNode.id );
   },
	
   addCrumb: function( label, id, paneIndex ){
      console.log( "addBreadCrumb", label, id, paneIndex );
      this.breadCrumbs.addCrumb( {
         label: label, 
         id: id, 
         index: paneIndex
      } );
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
	options: { 
		addPosition: 'bottom',
		allowChildSort: true
	},
	
	initialize: function( aMarshal, html, parentId ){
		//    console.log( html );
		this.marshal = aMarshal;
		this.html = html;
		this.parentId = parentId;
	},
	
   toString: function(){
      return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]"
   },
	
   getNodeIdFromElement: function( anElement ){
      //	    console.log( "getNodeIdFromElement", anElement );
      return anElement.get("id").split( "_" )[1];
   },
    

	attachToPane: function( navPane ){
		//    console.log( "attachToPane", this, navPane );
		navPane.store( "tier", this );
		
		this.options = Object.merge( this.options, navPane.getOptionsFromClassName() );
		console.log( ":::::::::::::::::", this.options );
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
			this.nodeElement.grab( newNode, 'bottom' );			
		}
		this.html = this.element.get( "html" );
		this.initNode( newNode );
	},
   
   render: function(){
      this.element.set( 'html', this.html );
      this.nodeElement = this.element.getElement( ".nodes" );
      this.nodes = this.element.getElements(".node");
      this.nodes.each( function( aNodeElement ){
		this.initNode( aNodeElement );
      }, this );
      this.drawer = this.element.getElement( '.tierMethodsDrawer' );
      if( this.drawer ){
         this.drawer.store( "initTop", this.drawer.getStyle( "top" ) );
         this.drawer.set( "morph", {
            duration: 200, 
            transition: Fx.Transitions.Quad.easeInOut
         } );
         this.drawer.addEvent( 'mouseenter', this.onDrawerMouseEnter.bindWithEvent( this ) );
         this.drawer.addEvent( 'mouseleave', this.onDrawerMouseLeave.bindWithEvent( this ) );
    	    
         this.nodeElement.setStyle( "height", this.nodeElement.getSize().y - this.drawer.getElement("h5").getSize().y + 2 );
	        
         var addObjectLinks = this.drawer.getElements( "li" );
         addObjectLinks.each( function( aLink ){
            console.log( aLink );
            aLink.addEvent( "click", this.onAddObjectClicked.bindWithEvent( this, aLink ) );
         }, this );	        
      }
   },

	initNode: function( aNodeElement ){
//          aNodeElement.addEvent( "focus", this.indicateNode.bindWithEvent( this, aNodeElement ) );
//          aNodeElement.addEvent( "blur", this.deindicateNode.bindWithEvent( this, aNodeElement ) );
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

   /**
    * Section: Event Handlers
	*/
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
		//    console.log( "onNodeClicked", this.element );
		var nodeId = this.getNodeIdFromElement( nodeElement );
		// if this specific tier has a pending request, we cancel it so the callback doesn't fire
		if( this.activeNode )this.deindicateNode( this.activeNode );
		this.activeNode = nodeElement;
		this.indicateNode( nodeElement );
		this.onNodeSelected( nodeId );
		if( this.currentTierRequest ) this.currentTierRequest.cancel();
		if( this.marshal.getNodeTypeFromId( nodeId ) != "module" ){
			this.currentTierRequest = this.marshal.requestTier( nodeId, this );
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
		var templateId = mop.util.getValueFromClassName( "templateId", addObjectButton.get("class") );
		var addText = addObjectButton.get( 'text' );
		//this.element.setStyle( "border", "1px #f00 solid" );
		console.log( this, this.element, this.spinner );
		var nodeTitle = prompt( "What would you like to name this" + addText.substr( addText.lastIndexOf( " " ), addText.length ).toLowerCase() );
		if( !nodeTitle ) return;
		this.spinner.show( true );
		this.marshal.addObject( this.parentId, templateId, { title: nodeTitle }, this );
	},

   onAddObjectResponse: function (json, placeHolder){
       placeHolder.destroy();
//       var newElement = 
       if( this.marshal.options.addPosition ){
           
       }else{
           
       }
   },
	
	onObjectAdded: function(){
		this.spinner.hide();
	},
	
   makeSortable: function(){
      if( this.isSortable ){
	        
      }
   },
	
   onNodeRenamed: function(){
	    
   },
	
   onSort: function(){
	    
   },
	
   clearTier: function(){
	    
   },

   dispose: function(){
	    
   }
	

});

 
