if( !mop.modules.navigation) mop.modules.navigation = {};

mop.modules.navigation.Navigation = new Class({

	Extends: mop.MoPObject,
	Implements: [ Events, Options ],
	
	dataSource: null,
	nodeData: {},
	navPanes: [],
	breadCrumbs: null,
	tiers: [],
	numberOfVisiblePanes: null,
	
	initialize: function( element, marshal, options ){
		this.parent( element, marshal, options );
	    this.dataSource = ( !this.options.dataSource )? this.marshal : this.options.dataSource;
	    this.numberOfVisiblePanes = Number( this.getValueFromClassName( "numberOfPanes" ) );
	    this.paneContainer = this.element.getElement( ".panes" );
	    this.navPaneTemplate = this.element.getElement( ".pane" ).dispose();
		this.paneContainer.empty();
		this.navPanes = this.element.getElements( ".pane" );
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
	    console.log( "requestTier", parentId, parentTier );
	    var title;
	    var paneIndex = 0;
	    if( parentTier ){
	        title = parentTier.getActiveNode().getElement( "h5" ).get( 'text' );
	        parentId = parentTier.getActiveNodeId();
	        paneIndex = this.navPanes.indexOf( parentTier.getElement() );
	        console.log( "addCrumb", paneIndex );
            this.addCrumb( title, parentId, paneIndex );
	    }
	    if( this.navPanes.length > 0 ) this.clearPanes( paneIndex + 1 );	    
        var newPane = this.addPane( parentId );
	    this.currentParentId = parentId;

	    // do we have this tier cached?
	    if( this.tiers[ parentId ] ){
	        console.log( "requestTier", "cached" );
	        this.renderPane( this.tiers[ parentId ], newPane );
	    }else{
	        console.log( "requestTier", "uncached" );
    	    this.dataSource.requestTier( parentId, function( json ){ this.requestTierResponse( json, newPane ); }.bind( this ) );
	    }
	},

	requestTierResponse: function( json, newPane ){
	    console.log( ">>>>>>>>>>>>>>>>>>>>", newPane.getSibling() );
//	    console.log( "onTierReceived", json );
        this.nodeData[ this.currentParentId ] = json.response.data.nodes;
	    var tier = new mop.modules.navigation.Tier( this, json.response.html, this.currentParentId );
        this.tiers[ this.currentParentId ] = tier;
	    this.renderPane( tier, newPane);
	},

    renderPane: function( aTier, newPane ){
        newPane.unspin();
	    aTier.attachToPane( newPane );
	    if( this.navPanes.indexOf( newPane ) < this.numberOfVisiblePanes -1 ){
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
        this.marshal.onNodeSelected( nodeId );
	},

	removeObject: function( nodeId ){
	    this.marshal.removeObjectRequest( nodeId, this.onRemoveObjectResponse.bind( this ) );
	},
	
	onRemoveObjectResponse: function( json ){
	    console.log( this.toString(), "onRemoveObjectResponse", json );
	},

    togglePublishedStatus: function( nodeId ){
	    this.marshal.togglePublishedStatusRequest( nodeId );        
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
	html: null,
	parentId: null,
	activeNode: null,
	
	initialize: function( aMarshal, html, parentId ){
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
	
	getActiveNode: function(){
        return this.activeNode;
	},

	getActiveNodeId: function(){
        return this.getNodeIdFromElement( this.activeNode );
	},
	
	render: function(){
        this.element.set( 'html', this.html );
	    this.nodes = this.element.getElements(".node");
	    this.nodes.each( function( aNodeElement, i ){
//    	    aNodeElement.addEvent( "focus", this.indicateNode.bindWithEvent( this, aNodeElement ) );
  //  	    aNodeElement.addEvent( "blur", this.deindicateNode.bindWithEvent( this, aNodeElement ) );
    	    aNodeElement.addEvent( "click", this.onNodeClicked.bindWithEvent( this, aNodeElement ) );
	        var togglePublishedStatusElement = aNodeElement.getElement(".togglePublish");
	        if( togglePublishedStatusElement ){
        	    togglePublishedStatusElement.addEvent( "click", this.onTogglePublishedStatusClicked.bindWithEvent( this, aNodeElement ) );
	        }
	        var removeNodeElement = aNodeElement.getElement(".removeNode");
	        if( removeNodeElement ){
        	    removeNodeElement.addEvent( "click", this.onRemoveNodeClicked.bindWithEvent( this, aNodeElement ) );
	        }
	    }, this );
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
	    if( this.activeNode )this.deindicateNode( this.activeNode );
        this.activeNode = nodeElement;        
	    this.indicateNode( nodeElement );
        var nodeId = this.getNodeIdFromElement( nodeElement );
	    this.marshal.requestTier( nodeId, this );
	    this.onNodeSelected( nodeId );
	},
		
    onRemoveNodeClicked: function( e, nodeElement ){
//	    console.log( "onRemoveNodeClicked" );
	    mop.util.stopEvent( e );
        var nodeId = this.getNodeIdFromElement( nodeElement );
        nodeElement.destroy();
        this.removeObject( nodeId );
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
	    this.togglePublishedStatus( nodeId );
    },
    
	onNodeSelected: function( nodeId ){
	    this.marshal.onNodeSelected( nodeId );
	},
	
	togglePublishedStatus: function( nodeId ){
	    this.marshal.togglePublishedStatusRequest( nodeId );
	    
	},
	
    // is it better to have this function here? Or just add it if it ever grows beyond one line of code?
	removeObject: function( nodeId ){
	    this.marshal.removeObject( nodeId );
	},
	
	appendNode: function(){
	    
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

 