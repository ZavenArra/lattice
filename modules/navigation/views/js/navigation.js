mop.modules.navigation = {};
mop.modules.navigation.Navigation = new Class({

	Extends: mop.MoPObject,
	Implements: [ Events, Options ],
	
	dataSource: null,
	nodeData: {},
	navPanes: [],
	breadCrumbs: null,
	tierDepth: 0,
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
		this.requestTier( 0, null );
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getElement( ".breadCrumb" ), this.onBreadCrumbClicked.bind( this ) );
		this.breadCrumbs.addCrumb( { label: "Main Menu", id: null, index: 0 } );
	},

	requestTier: function( parentId, parentPane ){
	    this.currentParentId = parentId;
	    paneIndex = this.navPanes.indexOf( parentPane );
	    console.log( "!!! requestTier", parentPane );
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
    	        this.onTierReceived( json, paneIndex );
    	    }.bind( this ) );	        
	    }
	},
    
	onTierReceived: function( json, paneIndex ){
//	    console.log( "onTierReceived", json );
	    var tier = new mop.modules.navigation.Tier( this, json.response );
        this.tiers[ this.currentParentId ] = tier;
	    this.renderPane( tier, paneIndex );
	    var pane = this.navPanes[ paneIndex ];
	    if( pane ) pane.getElement("ul").unspin();
	},

    renderPane: function( aTier, paneIndex ){
        var newPane;
        newPane = this.navPaneTemplate.clone();
	    if( this.navPanes.length > 0 ) this.clearPanes( paneIndex + 1 );
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

        var panesToRemove = this.navPanes.filter( function( aPane, i ){
            if( i >= startIndex && i < endIndex ) return aPane;
        });
        console.log( panesToRemove );
        panesToRemove.each( function( aPane, index ){
           this.navPanes.erase( aPane );
           aPane.getElement( "ul" ).unspin();
           aPane.retrieve( 'tier' ).detach();
           aPane.destroy();
        }, this );
    },
    
	displayNode: function( nodeId ){
        // marshal instead of dataSource here??? Even though at the moment they are the same?
        this.marshal.displayNode( nodeId );
        this.currentParentId = nodeId;
	},

	removeObject: function( nodeId ){
	    this.marshal.removeObject( nodeId, this.onRemoveObjectResponse.bind( this ) );
	},

	onRemoveObjectResponse: function( response ){
        if( response.error ) console.log( "onRemoveObjectResponse error:", response.error );
        },
    
    onBreadCrumbClicked: function( aNode ){
		this.requestTier( node, aNode.index );
	},
	
	addBreadCrumb: function( parentId, parentPane ){
		if( nodeParentId ){
			var node = this.tiers[ parentId ];
			breadCrumbObj = { label: node.data.title, id: node.data.id, index: this.navPanes.indexOf( parentPane ) };
		}
		this.breadCrumbs.addCrumb( breadCrumbObj );
	}
	
});

mop.modules.navigation.Tier = new Class({

 //       Extends: mop.MoPObject,
	nodes: null,
	nodeData: null,
	initialize: function( aMarshal, nodeData ){
	    this.marshal = aMarshal;
	    this.nodeData = nodeData;
	},
	
	toString: function(){ return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]" },
	
	attachToPane: function( navPane ){
	    console.log( "attachToPane", this, navPane );
	    navPane.store( "tier", this );
	    this.element = navPane;
	    navPane.empty();
	    this.render();
	},
	
	detach: function(){
        this.nodes = this.element = this.activeNode = null;
	},
	
	render: function(){
        this.element.set( 'html', this.nodeData.html );
	    this.nodes = this.element.getElements(".node");
	    this.nodes.each( function( aNodeElement, index ){
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
	    this.displayNode( nodeId );
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
    },
    
	displayNode: function( nodeId ){
	    this.marshal.displayNode( nodeId );
	},
	
	getNodeIdFromElement: function( anElement ){
//	    console.log( "getNodeIdFromElement", anElement );
	    return anElement.get("id").split( "_" )[1];
	},
	
	togglePublish: function( e ){
	    mop.util.stopEvent( e );
	    
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

 