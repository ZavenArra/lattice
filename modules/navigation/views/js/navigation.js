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
	
	initialize: function( element, marshal, options ){
		this.parent( element, marshal, options );
	    this.dataSource = ( !this.options.dataSource )? this.marshal : this.options.dataSource;
		this.navPanes = this.element.getElements( ".pane" );
		var paneClass = "";
		switch( this.navPanes.length ){
		    case 1: paneClass = "container_12"; break;
		    case 2: paneClass = "grid_6"; break;
		    case 3: paneClass = "grid_4"; break;
		    case 4: paneClass = "grid_3"; break;
		    case 6: paneClass = "grid_2"; break;
		}
		this.navPanes.each( function( el ){ el.addClass( paneClass ) } );
		this.requestTier( 0 );
	},
	
	requestTier: function( parentId ){
	    this.currentParentId = parentId;
	    // do we have this tier cached?
	    if( this.tiers[ parentId ] ){
	        console.log( "requestTier", parentId, "cached" );
	        this.renderTier( this.tiers[ parentId ] );
	    }else{
	        console.log( "requestTier", parentId, "not cached send request" );
    	    this.dataSource.requestTier( parentId, this.onTierReceived.bind( this ) );	        
	    }
	},
	
	onTierReceived: function( json ){
	    console.log( "onTierReceived", json.response.data );
	    this.nodeData[ this.currentParentId ] = { data: json.response.data.nodes, html: json.response.html };
	    var tier = new mop.modules.navigation.Tier( this.navPanes[this.tierDepth], this, this.nodeData[ this.currentParentId ] );
        this.tiers[ this.currentParentId ] = tier;
	},
		
	displayNode: function( nodeId ){
        // marshal instead of dataSource here??? Even though at the moment they are the same?
        this.marshal.displayNode( nodeId );
	},
	
	removeObject: function( nodeId ){
	    
	},
	
	onRemoveObjectResponse: function( response ){
        if( response.error ) console.log( "onRemoveObjectResponse error:", response.error )
    }
	

});

mop.modules.navigation.Tier = new Class({

	Extends: mop.MoPObject,
	nodes: null,
	
	initialize: function( element, marshal, options ){
//	    console.log( "TIER", options.html );
        this.parent( element, marshal, options );
        this.render( options.data, options.html)
	},
	
	toString: function(){ return "[ Object, mop.MoPObject, mop.modules.navigation.Tier ]" },
	
	attachToPane: function( navPane, nodeData ){
	    navPane.empty();
	    this.element = navPane;
	    this.render( nodeData.data, nodeData.html );
	},
	
	render: function( data, html ){
        // focus/blur events are good for keyboard activation/indication
        console.log( this.toString(), "render", this.element, data, html );
        this.element.set( 'html', html );
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
	    console.log( "onNodeClicked" );
	    if( this.activeNode ) this.deindicateNode( this.activeNode );
        this.activeNode = nodeElement;        
	    this.indicateNode( nodeElement );
	    this.displayNode( this.getNodeIdFromElement( nodeElement ) );  
	},
		
    onRemoveNodeClicked: function( e, nodeElement ){
	    console.log( "onRemoveNodeClicked" );
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
	    console.log( "getNodeIdFromElement", anElement );
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
