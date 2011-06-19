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
	
	initialize: function( element, marshal, options ){
		this.parent( element, marshal, options );
	    this.dataSource = ( !this.options.dataSource )? this.marshal : this.options.dataSource;
	    this.navPaneTemplate = this.element.getElement( ".pane" ).dispose();
        this.paneContainer = this.element.getElement( ".panes" );
		this.navPanes = this.element.getElements( ".pane" );
	    this.paneContainer.empty();
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onCrumbClicked.bind( this ) );
		this.requestTier( 0, null );
	},

	addPane: function( parentId ){
    	var newPane = this.navPaneTemplate.clone();
        this.navPanes.push( newPane );
        this.element.getElement( ".panes" ).adopt( newPane );
        var elementDimensions = this.paneContainer.getDimensions();
        this.paneContainer.setStyle( "width", elementDimensions.width + newPane.getDimensions().width );
        newPane.get( "spinner" ).show(true);
        return newPane;
	},

	requestTier: function( parentId, parentTier ){
	    var title;
	    var paneIndex = 0;
	    if( parentTier ){
	        console.log( parentTier, parentTier.getActiveNode() );
	        title = parentTier.getActiveNode().getElement( "h5" ).get( 'text' );
	        parentId = parentTier.getActiveNodeId();
	        paneIndex = this.navPanes.indexOf( parentTier.getElement() );
            this.addCrumb( title, parentId, paneIndex );
	    }
	    if( this.navPanes.length > 0 ) this.clearPanes( paneIndex + 1 );	    
        var newPane = this.addPane( parentId );
	    if( this.tiers[ parentId ] ){
    	    // if the tier has already been loaded and cached
	        console.log( "requestTier", "cached" );
	        this.renderPane( this.tiers[ parentId ], newPane );
	    }else{
    	    // otherwise load send a tier request
	        console.log( "requestTier", "uncached" );
    	    this.dataSource.requestTier( parentId, function( json ){ this.requestTierResponse( json, parentId, newPane ); }.bind( this ) );
	    }
	},

	requestTierResponse: function( json, parentId, containerPane ){
//	    console.log( ">>>>>>>>>>>>>>>>>>>>", newPane.getSibling() );
//	    console.log( "onTierReceived", json );
        this.nodeData[ parentId ] = json.response.data.nodes;
        console.log( "requestTierResponse", this.nodeData, parentId );
	    var tier = new mop.modules.navigation.Tier( this, json.response.html, parentId );
        this.tiers[ parentId ] = tier;
	    this.renderPane( tier, containerPane );
	},

    renderPane: function( aTier, newPane ){
        newPane.unspin();
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
        var panesToRemove = this.navPanes.filter( function( aPane, i ){ if( i >= startIndex && i < endIndex ) return aPane; });
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

    addObject: function( parentId, templateId, nodeProperties ){
        this.dataSource.addObjectRequest( parentId, templateId, nodeProperties, this.onAddObjectResponse.bind( this ) );
    },

    onAddObjectResponse: function( json ){
        console.log( this.toString(), "onAddObjectResponse", json );
    },
    
	removeObject: function( nodeId ){
	    this.dataSource.removeObjectRequest( nodeId, this.onRemoveObjectResponse.bind( this ) );
	},
	
	onRemoveObjectResponse: function( json ){
	    console.log( this.toString(), "onRemoveObjectResponse", json );
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
		this.breadCrumbs.addCrumb( { label: label, id: id, index: paneIndex } );
	},
	
	removeCrumb: function( paneIndex ){
	    this.breadCrumbs.removeCrumb( paneIndex );
	}
	
});

mop.modules.navigation.Tier = new Class({

 //       Extends: mop.MoPObject,
	nodes: null,
	nodeElement: null,
	html: null,
	parentId: null,
	activeNode: null,
	drawer: null,
	
	initialize: function( aMarshal, html, parentId ){
//	    console.log( html );
	    this.marshal = aMarshal;
	    this.html = html;
	    this.parentId = parentId;
	},
	
	toString: function(){ return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]" },
	
	getNodeIdFromElement: function( anElement ){
//	    console.log( "getNodeIdFromElement", anElement );
	    return anElement.get("id").split( "_" )[1];
	},
    
    getElement: function(){
        return this.element;
    },
    
	attachToPane: function( navPane ){
//	    console.log( "attachToPane", this, navPane );
	    navPane.store( "tier", this );
	    this.element = navPane;
	    navPane.empty();
	    this.render();
	},
	
	detach: function(){
	    this.element.eliminate( "tier" );
        this.element = this.activeNode = null;
	},
	
	getActiveNode: function(){ return this.activeNode; },

	getActiveNodeId: function(){
        return this.getNodeIdFromElement( this.activeNode );
	},
	
	render: function(){
        this.element.set( 'html', this.html );
	    this.nodes = this.element.getElements(".node");
	    this.nodes.each( function( aNodeElement, i ){
//          aNodeElement.addEvent( "focus", this.indicateNode.bindWithEvent( this, aNodeElement ) );
//          aNodeElement.addEvent( "blur", this.deindicateNode.bindWithEvent( this, aNodeElement ) );
    	    aNodeElement.addEvent( "click", this.onNodeClicked.bindWithEvent( this, aNodeElement ) );
	        var togglePublishedStatusElement = aNodeElement.getElement(".togglePublishedStatus");
//	        console.log( "togglePublishedStatusElement", togglePublishedStatusElement );
	        if( togglePublishedStatusElement ){
        	    togglePublishedStatusElement.addEvent( "click", this.onTogglePublishedStatusClicked.bindWithEvent( this, aNodeElement ) );
	        }
	        var removeNodeElement = aNodeElement.getElement(".removeNode");
	        if( removeNodeElement ){
        	    removeNodeElement.addEvent( "click", this.onRemoveNodeClicked.bindWithEvent( this, aNodeElement ) );
	        }
	    }, this );
	    this.drawer = this.element.getElement( '.tierMethodsDrawer' );
	    this.nodeElement = this.element.getElement( ".nodes" );
	    if( this.drawer ){
    	    this.drawer.store( "initTop", this.drawer.getStyle( "top" ) );
    	    this.drawer.set( "morph", { duration: 200, transition: Fx.Transitions.Quad.easeInOut } );
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

	indicateNode: function( nodeElement ){ nodeElement.addClass( "active"); },

	deindicateNode: function( nodeElement ){ nodeElement.removeClass("active"); },

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
//	    console.log( "onNodeClicked", this.element );
        var nodeId = this.getNodeIdFromElement( nodeElement );
        // if this specific tier has a pending request, we cancel it so the callback doesn't fire
	    if( this.activeNode )this.deindicateNode( this.activeNode );
        this.activeNode = nodeElement;
	    this.indicateNode( nodeElement );
	    this.onNodeSelected( nodeId );
        if( this.currentTierRequest ) this.currentTierRequest.cancel();
	    this.currentTierRequest = this.marshal.requestTier( nodeId, this );
	},
		
    onRemoveNodeClicked: function( e, nodeElement ){
//	    console.log( "onRemoveNodeClicked" );
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
//	    console.log( ":::::: onDrawerMouseEnter ::", this.nodeElement, this.nodeElement.getSize() );
	    this.drawer.morph( { 'top': top } );
	},
	
	onDrawerMouseLeave: function( e ){
	    var top = this.nodeElement.getSize().y - this.drawer.getElement( "h5" ).getSize().y;
	    this.drawer.morph( { 'top': this.drawer.retrieve( "initTop" ) } );
	},
	
	onAddObjectClicked: function( e, addObjectButton ){
	    mop.util.stopEvent( e );
	    var templateId = addObjectButton.getValueFromClassName( "templateId" );
	    console.log( "onAddObjectClicked", e, addObjectButton );
	    var addText = addObjectButton.get('text')
//	    var tempalteId = addObjectButton.getValueFromClassName( "templateId" );//mop.util.getValueFromClassName( 'templateId', addObjectButton.get("class") );
	    var nodeTitle = prompt( "What would you like to name this" + addText.substr( addText.lastIndexOf( " " ), addText.length ).toLowerCase() );
	    if( !nodeTitle ) return;
	    
	    console.log( "NODE TITLE", nodeTitle );
	    this.marshal.addObject( this.parentId, templateId, { title: nodeTitle } );
	},
	
	appendNode: function(){},
	
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

 