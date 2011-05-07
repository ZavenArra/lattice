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
	    this.navPaneTemplate = this.element.getElement( ".pane" ).clone();
		this.paneContainer.empty();
		this.navPanes = this.element.getElements( ".pane" );
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onCrumbClicked.bind( this ) );
		this.requestTier( 0, null );
	},

	requestTier: function( parentId, parentPane ){
	    console.log( "requestTier", parentId, parentPane );
	    var paneIndex = ( parentPane ) ? this.navPanes.indexOf( parentPane ) : 0;
	    if( this.navPanes.length > 0 ) this.clearPanes( paneIndex );
	    var title = "";
	    var parentId = 0;
	    if( parentId != 0 ){
	        title = parentPane.retrieve( "tier" ).getActiveNode().getElement( "h5" ).get( 'text' );
	        parentId = parentPane.retrieve( "tier" ).getActiveNodeId();	        
	    }else{
	        title = "Site Root";
	        parentId = 0;
	        paneIndex = -1;
	    }
        this.addCrumb( title, parentId, paneIndex + 1  );
	    this.currentParentId = parentId;
	    // do we have this tier cached?
	    if( this.tiers[ parentId ] ){
//	        console.log( "requestTier", "cached" );
	        this.renderPane( this.tiers[ parentId ], paneIndex );
	    }else{
//	        console.log( "requestTier", "uncached" );
            if( parentPane ){
                parentPane.getElement( "ul" ).spin();
            }
    	    this.dataSource.requestTier( parentId, function( json ){ 
    	        this.requestTierResponse( json, paneIndex );
    	    }.bind( this ) );	        
	    }
	},
    
	requestTierResponse: function( json, paneIndex ){
	    console.log( ":::: ", arguments );
//	    console.log( "onTierReceived", json );
        this.nodeData[ this.currentParentId ] = json.response.data.nodes;
	    var tier = new mop.modules.navigation.Tier( this, json.response.html, this.currentParentId );
        this.tiers[ this.currentParentId ] = tier;
	    this.renderPane( tier, paneIndex );
	    var pane = this.navPanes[ paneIndex ];
	    if( pane ) pane.getElement("ul").unspin();
	},

    renderPane: function( aTier, paneIndex ){
        var newPane;
        newPane = this.navPaneTemplate.clone();
        this.navPanes.push( newPane );
        var elementDimensions = this.paneContainer.getDimensions();
        this.element.getElement( ".panes" ).adopt( newPane );
        this.paneContainer.setStyle( "width", elementDimensions.width + newPane.getDimensions().width );
	    aTier.attachToPane( newPane );
	    if( paneIndex < this.numberOfVisiblePanes -1 ){
    	    var myFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toLeft();	        
	    }else{	        
    	    var myFx = new Fx.Scroll( this.element.getElement( ".container" ) ).toElementEdge( newPane );
	    }
    },
    
    clearPanes: function( startIndex, endIndex ){
        if( startIndex == -1 ) startIndex = 0;
        if( !endIndex ) endIndex = this.navPanes.length;
        var panesToRemove = this.navPanes.filter( function( aPane, i ){ if( i >= startIndex && i < endIndex ) return aPane; });
//        console.log( panesToRemove );
        panesToRemove.each( function( aPane, index ){
            this.removeCrumb( index + 1 ); // we want to remove the crumbs FOLLOWING the crumb that represents the current pane 
            this.navPanes.erase( aPane );
            aPane.getElement( "ul" ).unspin();
            aPane.retrieve( 'tier' ).detach();
            aPane.destroy();
        }, this );
    },
    
	onNodeSelected: function( nodeId ){
        // marshal instead of dataSource here??? Even though at the moment they are the same?
        this.marshal.onNodeSelected( nodeId );
	},

	removeObject: function( nodeId ){
	    this.marshal.removeObject( nodeId, this.onRemoveObjectResponse.bind( this ) );
	},

    togglePublished: function( nodeId ){
	    this.marshal.togglePublished( nodeId, this.onTogglePublishedResponse.bind( this ) );        
    },
    
	onRemoveObjectResponse: function( json ){
        if( !json.returnValue ) console.log( "onRemoveObjectResponse error:", json.response.error );
    },

	onTogglePublishedResponse: function( json ){
        if( !json.returnValue ) console.log( "onTogglePublishedResponse error:", json.response.error );
    },
    
    onCrumbClicked: function( aNode ){
        console.log( ":::::::::::: onBreadCrumbClicked ", aNode );
		this.requestTier( aNode.id, this.navPanes[ aNode.index ] );
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
    	
	attachToPane: function( navPane ){
//	    console.log( "attachToPane", this, navPane );
	    navPane.store( "tier", this );
	    this.element = navPane;
	    navPane.empty();
	    this.render();
	},
	
	detach: function(){
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
	        var togglePublishElement = aNodeElement.getElement(".togglePublish");
	        if( togglePublishElement ){
        	    togglePublishElement.addEvent( "click", this.onTogglePublishClicked.bindWithEvent( this, aNodeElement ) );
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
	    this.marshal.requestTier( nodeId, this.element );
	    this.onNodeSelected( nodeId );
	},
		
    onRemoveNodeClicked: function( e, nodeElement ){
//	    console.log( "onRemoveNodeClicked" );
	    mop.util.stopEvent( e );
        var nodeId = this.getNodeIdFromElement( nodeElement );
        clickedElement.retrieve("nodeElement").destroy();
        this.removeObject( nodeId );
    },

    onTogglePublishClicked: function( e, nodeElement ){
        mop.util.stopEvent( e );
	    console.log( "onTogglePublishClicked", e, nodeElement );
        var nodeId = this.getNodeIdFromElement( nodeElement );
        var togglePublishLink = nodeElement.getElement( ".togglePublish" );
        if( togglePublishLink.hasClass( "published" ) ){
            togglePublishLink.removeClass( "published" );
        }else{
            togglePublishLink.addClass( "published" );            
        }
	    this.togglePublished( nodeId );
    },
    
	onNodeSelected: function( nodeId ){
	    this.marshal.onNodeSelected( nodeId );
	},
	
	togglePublished: function( nodeId ){
	    this.marshal.togglePublished( nodeId );
	    
	},
	
    // is it better to have this function here? Or just add it if it ever grows beyond one line of code?
	removeObject: function( nodeId ){
	    this.marshal.removeNavNode( nodeId );
	},
	
	appendNode: function(){
	    
	},
	
	
	makeSortable: function(){
	    
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

 