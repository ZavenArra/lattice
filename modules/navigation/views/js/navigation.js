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
        this.element.set( 'html', html );
        console.log( this.toString(), "render", this.element, data, html );
	    this.nodes = this.element.getElements(".node");
	    this.nodes.each( function( aNodeElement, index ){
	        if( aNodeElement.getElement(".togglePublish") ) aNodeElement.getElement(".togglePublish").store( "nodeElement", aNodeElement );
	        if( aNodeElement.getElement(".remove") ) aNodeElement.getElement(".removeNode").store( "nodeElement", aNodeElement );
	    });
	    this.element.addEvent( "focus:relay(.node)", this.indicateNode.bindWithEvent( this ) );
	    this.element.addEvent( "blur:relay(.node)", this.deindicateNode.bindWithEvent( this ) );
	    this.element.addEvent( "click:relay(.node)", this.onNodeClicked.bindWithEvent( this ) );
	    this.element.addEvent( "click:relay(.node .togglePublish)", this.onTogglePublishClicked.bindWithEvent( this ) );
	    this.element.addEvent( "click:relay(.node .remove)", this.onRemoveNodeClicked.bindWithEvent( this ) );
	    
	},
	
	/**
	 * Section: Event Handlers
	 */
	indicateNode: function( e, clickedElement ){
	    mop.util.stopEvent( e );
	    e.target.addClass("active");
	},
	
	deindicateNode: function( e, clickedElement ){
	    mop.util.stopEvent( e );
	    if( this.activeNode != e.target ) e.target.removeClass("active");	    
	},
	
	onNodeClicked: function( e, clickedElement ){
	    mop.util.stopEvent( e );
	    console.log( "onNodeClicked" );
	    this.displayNode( this.getNodeIdFromElement( clickedElement ) );  
	},
		
    onRemoveNodeClicked: function( e, clickedElement ){
	    console.log( "onRemoveNodeClicked" );
	    mop.util.stopEvent( e );
        var nodeId = this.getNodeIdFromElement( clickedElement.retrieve("nodeElement") );
        clickedElement.retrieve("nodeElement").destroy();
        this.removeObject( nodeId );
    },

    onTogglePublishClicked: function( e, clickedElement ){
	    console.log( "onTogglePublishClicked" );
    },
    
	displayNode: function( nodeId ){
	    if( this.activeNode ) this.activeNode.removeClass( "active" );
	    this.indicateNode( e );
	    this.activeNode = e.target;
	    indicateNode( e );
	    this.marshal.displayNode( this.getNodeIdFromElement( e.target ) );
	},
	
	getNodeIdFromElement: function( anElement ){
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
