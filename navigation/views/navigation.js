 /*
	Section: mop.modules.navigation
*/
mop.modules.navigation = {};

/*
	Class: mop.modules.navigation Navigation
*/
mop.modules.navigation.Navigation = new Class({
	/*
		Constructor: initialize
	*/
	Extends: mop.modules.Module,
	Implements: Events,

	initialize: function( anElement, aMarshal ){

		this.parent( anElement );
		
		this.navElement = this.element.getElement( ".nav" );
		
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getSibling( ".breadCrumb" ), this.onBreadCrumbClicked.bind( this ) );
		
		this.mode = "browse";
		this.tiers = [];
		this.colWidth = 300;
		this.navTree = null;
		this.currentPage = null;

		this.navSlide = new Fx.Scroll( this.element );

		mop.HistoryManager.addListener( this );
		this.addEvent( "pageIdChanged", this.onPageIdChanged );
		this.getNavTree();

		this.addObjectPosition =	mop.util.getValueFromClassName( "addObjectPosition", this.element.get( "class" ) );

	},

	getMarshal: function(){
//		console.log( "mop.navigation.Navigation.getMarshal", this.getValueFromClassName( "marshal" ),  mop.ModuleManager.getModuleById( this.getValueFromClassName( "marshal" ) ) );
		return mop.ModuleManager.getModuleById( this.getValueFromClassName( "marshal" ) );
	},
	
	build: function(){},
	
	onPageIdChanged: function( pageId ){
//		console.log( "onStateChange", pageId );
		this.clearTier( 0 );
		this.getNavTree();
	},
	
	toString: function(){
		return "[ Object, mop.modules.navigation.Navigation ]";
	},

	/*
		Function: getNavTree
		Ajax call to get site's structure as json string. On callback calls buildNav
	 	Returns: Object representing JSON structure of site nav
		TODO: document final JSON structure... 
	*/
	getNavTree: function(){
//		console.log( "getNavTree ", url );
		new Request.JSON({
			url: mop.getAppURL() + 'ajax/'+ this.instanceName + "/getNavTree" + this.getDeepLinkTarget(),
			onComplete: this.buildNav.bind( this )
		}).send();
	},
	
	getDeepLinkTarget: function(){
		return ( mop.HistoryManager.getValue( "pageId" ) )? "/"+mop.HistoryManager.getValue( "pageId" ) : "";
	},

	/*
		Function: loadPage
		Ajax call to retrieve a page with 'pageId'
		Arguments:
			pageId - {Number} the desired page's id
	 	Callback: calls onPageReceived with JSON object { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	loadPage: function( pageId, whichTier, whereFrom ){
//		console.log( "loadPage ", "pageId: " + pageId, "called from :" + whereFrom );
		if( !pageId ) return;
		this.currentPage = pageId;
		this.clearTier( whichTier + 1 );
		this.getMarshal().loadPage( pageId );
	},

	setPublishedStatus: function( id ){
		this.getMarshal().togglePublishedStatus( id );
	},

	createNavTreeLookupTable: function( obj ){
		obj.each( function( aNode, index ){
			this.navTreeLookupTable.set( aNode.id, aNode );
			if( aNode.children ){
				this.createNavTreeLookupTable( aNode.children );
			}else{
				return;
			}
		}, this);
	},

	appendEntryToNavTree: function( parentId, node, isCategory ){
		if(this.addObjectPosition=='top'){
			this.navTreeLookupTable[parentId].children.unshift( node );
		}else{
			this.navTreeLookupTable[parentId].children.push( node );
		}
		if( isCategory ) this.navTreeLookupTable[ node.id ] = node;
	},

	/*
		Function: buildNav
		Callback to getNavTree
		Argument: navTree {String} returned argument from getNavTree method.
	*/
	buildNav: function( navTree ){
		this.navTree = navTree;
//		console.dir( navTree );
		this.navTreeLookupTable = new Hash();
		this.createNavTreeLookupTable( navTree );
		this.showCategory( this.navTree , 0 );
	},

	/*
		Function: addListing
		Argument: whichTier {Number} which tier are adding
	*/
	addListing: function( whichTier ){
		var leftMargin = ( whichTier > 0 )? this.colWidth * ( whichTier ) : 0;
		var navElementWidth  = ( ( whichTier ) * this.colWidth > 900 )? (whichTier) * ( this.colWidth + 3): 900 + 3;
		this.navElement.setStyle( "width", navElementWidth );
		this.navElement.setStyle( "white-space", "nowrap" );
		var newTier = new Element( "li", {
			"class": "navTier",
			styles: {
				"position": "absolute",
				"width": this.colWidth,
				"left": leftMargin
			}
		});

		var utilityNode = new Element( "ul",{ "class": "utility" } );
		var newList = new Element( "ul", { "class": "tier" } );

		newList.inject( newTier ); 
		utilityNode.inject( newTier ); 
		newTier.inject( this.navElement );
		
		newList = null;
		newTier = null;
		utilityNode = null;
		navElementWidth = null;
		leftMargin = null;
	},
	
	getTierElement: function( whichTier, from ){
		//console.log( "getTierElement >>>> " + whichTier + " called from " + from, this.navElement.getChildren() );
		return ( this.navElement.getChildren()[ whichTier ] )? this.navElement.getChildren()[ whichTier ].getElement( "ul.tier" ) : false;
	},

	/*
		Function: clearTier
		Argument: whichTier {Number} which tier are we clearing
	*/
	clearTier: function( whichTier ){
		
//		console.log( "\t\tclearTier ", whichTier );
		
		var targetListElement = this.getTierElement( whichTier, "clearTier" );
		if( !targetListElement ) return false;
		
		var theTier = this.tiers[ whichTier ];
		if( theTier ){
			theTier.activeChild = null;
			theTier.each( function( node, index){
//				console.log( node );
				theTier.erase( node );
				node.destroy();
			});
			this.tiers.erase(whichTier);
		}
		
		// clears out elements from this tier, and subsequent tiers
		subsequentTierElements = targetListElement.getParent().getAllNext();
		targetListElement.getParent().destroy();
		subsequentTierElements.each( function( aTier, index ){
			aTier.destroy();
		});
		
		this.breadCrumbs.clearCrumbs( whichTier );

		targetListElement = null;
		theTier = null;
//		crumb = null;
	},

	/*
		Function: showCategory
		Replaces a given 'tier' with new listing
		Arguments:
			aNode - node data from navTree
			whichTier - where are we doing this in the navigation...  
	*/
	showCategory: function( aNode, whichTier ){

		console.log( "showCategory :::: ", aNode );//, " : ", aNode.id, " : ", whichTier, aNode.children );

//		this.getMarshal().clearPage();

		var showPage = true;

		this.clearTier( whichTier );
		this.tiers[ whichTier ] = [];
		this.tiers[ whichTier ].activeChild = null;
		
		this.addListing( whichTier );

		if( aNode.addableObjects ) this.addUtilityNode( aNode, whichTier );
		var objectToTraverse = ( aNode.children )? aNode.children : aNode;

//		console.log( "objectToTraverse: ", objectToTraverse, objectToTraverse.length );

		if( objectToTraverse.length ){			
			objectToTraverse.each( function( childNode, anIndex ){
				// Todo: Figure out recursion for opening deeplinks
				var node;
				switch( childNode.nodetype.toLowerCase() ){
					case "leaf":
						node = this.addLeafNode( aNode.id, childNode, whichTier );
					break;
					case "category":
						node = this.addCategoryNode( aNode.id, childNode, whichTier );
					break;
				}

				if( childNode.follow == true ){
					childNode.follow = false;
					showPage = false;
					if( node ) this.setActiveChild( whichTier, node.element );
					var slideTier = new Fx.Scroll( this.getTierElement( whichTier ) );
					if( node )  slideTier.toElement( node.element );
					slideTier = null;
					this.breadCrumbs.addCrumb( { label: ( aNode.id )? aNode.title : "Main Menu", id: ( aNode.id )? aNode.id : null, index: whichTier } );
					this.showCategory( childNode, whichTier+1 );
				}
			}, this );
		}
		
		if( aNode.allowSort ) this.makeTierSortable( whichTier );
		
		this.navSlide.toElement( this.getTierElement( whichTier ) );

		if( showPage ) this.loadPage( aNode.id , whichTier, " inside showCategory " );
		
		objectToTraverse = null;
		showPage = null;

		
	},
	
	onBreadCrumbClicked: function( aNode ){
		if( !aNode.id ){
			node = this.navTree;
		}else{
			node = this.navTreeLookupTable[ aNode.id ];
		}
		
//		console.log( this.toString(), "onBreadCrumbClicked", node, aNode.index );
		this.showCategory( node, aNode.index );
	},
	
	addBreadCrumb: function( nodeParentId, whichTier ){
//		console.log( "\n\taddBreadCrumb", nodeParentId, whichTier );
		if( nodeParentId ){
			var node = this.navTreeLookupTable.get( nodeParentId );
			breadCrumbObj = { label: node.title, id: node.id, index: whichTier };
//			console.log( node, nodeParentId )
		}else{
			obj = null;
			if( whichTier == 0 ){
				breadCrumbObj = { label : "Main Menu", id : null, index: whichTier }
			}
		}
		this.breadCrumbs.addCrumb( breadCrumbObj );//{ label: node.title, id: node.id, anIndex: whichTier } );
	},
	
	addUtilityNode: function( aNode, whichTier ){
		var tierElement = this.getTierElement( whichTier );
		var tier = this.tiers[ whichTier ];
		console.log( this.toString(), "addUtilityNode : ", aNode, whichTier, tierElement, this.element.getSibling );
		
		if( aNode.addableObjects.length > 1 ){
			var utilityNode = tierElement.getSibling( ".utility" );
			var label = new Element( "li", {
				"class": "utility label",
				"html" : "<a'>Add an Item to this tier.</a><div class='clear'></div>"
			});
			utilityNode.adopt( label );			
		}
		
		if( aNode.addableObjects ){
			aNode.addableObjects.each( function( leafObj, index ){ 
				var node = new mop.modules.navigation.UtilityNode( aNode, true, index, this, whichTier );
				tier.unshift( node );
				node.element.inject( tierElement.getSibling(".utility") );			
			}, this );
			
			if( utilityNode ){
				utilityNode.set( "morph", { duration: 350 } );
				utilityNode.setStyle( "position", "relative" );		
				utilityNode.setStyle( "width", this.colWidth - 16 );
				utilityNode.setStyle( "width", "100%" );		
				utilityNode.morph( { top: 0 } );
				utilityNode.addEvent( "mouseenter", this.showUtilityNode.bindWithEvent( this, utilityNode ) );
				utilityNode.addEvent( "mouseleave", this.hideUtilityNode.bindWithEvent( this, utilityNode ) );				
			}

		}
	},

	showUtilityNode: function( e, aNode ){
		console.log( "showUtilityNode", aNode );
		mop.util.stopEvent( e );
		aNode.morph( { "top": - ( aNode.getSize().y - 24 ) } );
	},
	
	hideUtilityNode: function( e, aNode ){
		console.log( "showUtilityNode", aNode );
		mop.util.stopEvent( e );
		aNode.morph( { "top": 0 } );		
	},
	
	addLeafNode: function( parentId, node, whichTier, placementArg ){
		var placement = placementArg || 'bottom';
		var node = new mop.modules.navigation.LeafNode( parentId, node, this, whichTier );
		this.tiers[ whichTier ].unshift( node );
//		console.log( this + " addLeafNode");
		node.element.inject( this.getTierElement( whichTier, "addLeaf"), placement  );
		try{
			return node;
		}finally{
			node = null;
		}
	},
	
	addCategoryNode: function( parentId, node, whichTier, placementArg ){
		var placement = placementArg || 'bottom';
	 	var node = new mop.modules.navigation.CategoryNode( parentId, node, this, whichTier );
//		console.log( "addCategoryNode", this.tiers, whichTier, node );
		this.tiers[ whichTier ].unshift( node );
//		console.log( this + " addCategoryNode");
		node.element.inject( this.getTierElement( whichTier ), placement );
		try{
			return node;
		} finally {
			node = null;
		}
	},

	setActiveChild: function( whichTier, whichElement ){
		if( this.tiers[ whichTier ].activeChild ) this.tiers[ whichTier ].activeChild.removeClass("active");
		whichElement.addClass("active");
		this.tiers[ whichTier ].activeChild = whichElement;
	},
	
	getActiveChild: function ( whichTier ){
		return ( this.tiers[ whichTier ].activeChild )? this.tiers[ whichTier ].activeChild : null;
	},

	addObject: function( parentId, templateId, whichTier ){
//		console.log( this + " : addObject : " + parentId + " : " + whichTier + " : " + e );
		var name = prompt( "What would you like to name this Node?" );
		if( name ){
			var placeHolder = this.addPlaceHolder( name, whichTier );
			this.getMarshal().addObject( name, templateId, parentId, whichTier, placeHolder );
			placeHolder = null;
		}
		name = null;
	},
	
	onObjectAdded: function( node, parentId, whichTier, placeHolder ){
		placeHolder.destroy();
		mop.HistoryManager.changeState( "pageId", node.id );
		
		if( node.nodeType == "CATEGORY" ){
			var objectElement = this.addCategoryNode( parentId, node, whichTier, this.addObjectPosition ).element;			
		}else{
			var objectElement = this.addLeafNode( parentId, node, whichTier, this.addObjectPosition ).element;			
		}
//		if( ( node.allowAddCategory || node.allowAddLeaf ) && node.children.length < 1 ) node.children = [];
		this.appendEntryToNavTree( parentId, node, true );
		this.setActiveChild( whichTier, objectElement );
		if( this.tiers[whichTier].sortable ) this.tiers[whichTier].sortable.addItems( objectElement ); 
		if( node.addableObjects ) this.showCategory( node , whichTier+1 );
		//node.nodeType == "CATEGORY" ) 
	},
	
	addPlaceHolder: function( name, whichTier ){

		var placeHolder = new Element( "li", { "class": "placeHolder" } );
		var nodeTitle = new Element( "h5", { "text" : "Adding " + name + "…" } );		
		var clearBoth = new Element( "div", { "class": "clear" } );

		var tierElement = this.getTierElement( whichTier, "addPlaceHolder" );
		
		nodeTitle.inject( placeHolder );
		clearBoth.inject( placeHolder );
		placeHolder.inject( tierElement, this.addObjectPosition );	
		if( !this.tiers[whichTier].slideTier) this.tiers[whichTier].slideTier = new Fx.Scroll( tierElement );
		if(this.addObjectPosition == 'top'){
			this.tiers[whichTier].slideTier.toTop();
		} else {
			this.tiers[whichTier].slideTier.toBottom();
		}
		try{ 
			return placeHolder;
		}finally{
			placeHolder = null;
			nodeTitle = null;
			clearBoth = null;
			tierElement = null;
			slideTier = null;
		}
	},
	
	/*
		Function: toggleMode
		Toggle nav mode (sorting/browsing)
	*/
	makeTierSortable: function( whichTier ){
		this.tiers[whichTier].sortable = new mop.ui.Sortable(  this.getTierElement( whichTier ), this, {
			clone:  true,
			scrollElement: this.getTierElement( whichTier ),
			snap: 12,
			revert: true,
			velocity: .9,
			area: 24,
			constrain: true,
			onComplete: function( el ){
				if(!this.moved) return;
				this.moved = false;
				this.scroller.stop();
				this.marshal.onOrderChanged( el, whichTier );
			},
			onStart: function(){
				this.moved = true;
				this.scroller.start();
			}
	 	});
	},
		
	onOrderChanged: function( el, whichTier ){
//		console.log( "onOrderChanged, ", whichTier );
		var newOrder = this.serialize( el, whichTier );
		$clear( this.submitDelay );
		if( this.oldSort != newOrder ) this.submitDelay = this.submitSortOrder.periodical( 3000, this, [ newOrder, whichTier ] );
		newOrder = null;
	},
	
	submitSortOrder: function( newOrder, whichTier ){

		console.log( "submitSortOrder", newOrder, this.oldSort );

		if( this.oldSort != newOrder ){
//			console.log( "check sort order ", "\n\tnewOrder: " + newOrder, "\n\toldSort: "+ this.oldSort );
			$clear( this.submitDelay );
			this.JSONSend( "saveSortOrder", { sortorder: newOrder } );//, { onComplete: this.onSortsAved.bind( this, whichTier ) } );
			this.oldSort = newOrder;
		}

	},

	serialize: function( anElement, whichTier ){

		var children = this.getTierElement( whichTier ).getChildren();
		var sort = [];
		var newChildren = [];

		children.each( function( child, index ){
			newChildren.push( child.retrieve("Class").nodeData );
			sort.push( child.id.substr( "node_".length, child.id.length ) );
		});

		this.navTreeLookupTable[ anElement.retrieve( "Class" ).parentId ].children = newChildren;

		try{

			return sort.join(",");

		}finally{

			children = null;
			sort = null;
			newChildren = null;

		}

	},

	JSONSend: function( action, data, options ){
		mop.util.JSONSend( mop.getAppURL() + "ajax/"+ this.getMarshal().instanceName +  "/" + action + "/" + this.getRID(), data, options );
	},

	renameNode: function( aString ){
//		console.log( "rename node.... { " + aString + " }", $$( "#node_" + mop.ModuleManager.getRID() ),  $$( "#node_" + mop.ModuleManager.getRID() ).retrieve("Class") );
		this.element.getElement("#node_"+ mop.ModuleManager.getRID() ).retrieve("Class").rename( aString );
		
	},

	getNodeById: function( anId ){
		var node = false;
		this.tiers.each( function( nestedArray, index ){
			if( nestedArray.contains( $("node_"+anId).retrieve("Class") ) )   node = $("node_"+anId).retrieve("Class");
		});
		try{
			return node;
		}finally{
			node = null;
		}
	},
	
	removeNode: function( node, caller ){

		// if called from marshal, dont talk to marshal
		if( caller != this.getMarshal() ){
			this.getMarshal().deleteNode( node.id );
		}else{
		// if called from marshal we only know the node id
			node = this.getNodeById( node );
		}
		
		// set some local variables
		var id = node.instanceName;
		var parentId = node.parentId;
		var whichTier = node.tier;
		
		mop.HistoryManager.changeState("pageId", parentId);
		// get a reference to parentNode of navTree in the lookup table to delete the entry of this child...
		var parentRef = this.navTreeLookupTable[ parentId ];
		// dont know why child !== node when the ids are the same, but they arent so we cant just parentRef.child.erase( node )...
		if( parentRef ){
			parentRef.children.each( function( child, index ){
				if( child && node ){
					if( child.id == node.id ) parentRef.children.erase( child );				
				}
			});	
		}

		this.navTreeLookupTable.erase( id );

		var tierInQuestion = this.navElement.getChildren( "li" )[ whichTier ];
		var nodesInTier = tierInQuestion.getChildren( "ul" ).getChildren( "li" );

		if ( node.nodeData.children ) this.clearTier( whichTier + 1 );
		this.tiers[ whichTier ].erase( node );

		node.destroy();

		if( tierInQuestion.getElement( "ul" ).getChildren( "li" ).length == 0 && !tierInQuestion.getElement( "li.utility" ) ){
			tierInQuestion.destroy();
			this.navElement.setStyle( "width", this.colWidth * ( whichTier - 1 ) );
		}
		delete node;
		
		nodesInTier = null;
		tierInQuestion = null;
		parentRef = null;
		whichTier = null;
		parentId = null;
		id = null;

	},

	getElement: function(){
		return this.navElement;
	},
	
	destroyNode: function( aNode ){
		/*@TODO remove node from tiers array*/
		delete aNode;
	},
	
	destroy: function(){
		this.clearTier( 0 );
		this.breadCrumbs.destroy();
		delete this.breadCrumbs;
		this.breadCrumbs = null;
		mop.ModuleManager.destroyModule( this );
	}

});




/* Class: mop.modules.navigation.Node
	Navigation node superclass
*/
mop.modules.navigation.Node = new Class({
	/* Constructor: initialize */
	className: "node",
	initialize: function( parentId, nodeData, nav, aTier ){
//		console.log( "::::: initializing : " + this + " : " + aTier );
		this.nav = nav;
		this.parentId = parentId;
		this.nodeData = nodeData;
		this.id = nodeData.id;
		this.tier = aTier;
		this.build();
		return this;
	},

	/* 
		Function: toString
		Returns: String reference to mop.modules.navigation.Node
	*/
	toString: function(){
		return "[ Object, mop.modules.navigation.Node ]";
	},

	/* Function: build
	   Builds basic navigation node wiith
		- icon, title, publishToggle, delete
		Returns: the htmlElement attached to the class
	*/
	build: function(){
		this.element = new Element( "li", {
			"class": this.className,
			"events": {
				"click": this.onClick.bindWithEvent( this ),
				"mouseover": this.onMouseOver.bind( this ),
				"mouseout": this.onMouseOut.bind( this )
			}
		});
		this.element.set( "id", "node_"+this.id );
		
		this.element.store( "Class", this );
		this.addNodeTitle();
		this.addControls();
		this.clearBoth = new Element( "div", {
			"class": "clear"
		});
		this.clearBoth.inject( this.element );
		return this.element;
	},
	
	addNodeTitle: function(){
		this.nodeTitle = new Element( "h5", {
			"text" : this.nodeData.title
		});
		this.nodeTitle.inject( this.element );
	},
	
	rename: function( aString ){
//		console.log( "node.rename >>> " + aString );
		this.nodeTitle.set( "text", aString );
		this.nodeData.title = aString;
	},
	
	show: function(){
		this.element.removeClass("hidden");
	},
	hide: function(){
		this.element.addClass("hidden");
	},
	addControls: function(){
		if( !Boolean( this.nodeData.allowTogglePublish) && !Boolean(this.nodeData.allowDelete) ) return false;

		this.methods = new Element( "div", {
			"class": "methods"
		});
		if( Boolean( this.nodeData.allowTogglePublish ) ){			
			var pubState = ( this.nodeData.published )? "published" : "unpublished";
			this.publishLink = new Element( "a", {
				"class": "icon " + pubState,
				"href": "#",
				"title" : ( this.nodeData.published )? "unpublish" : "publish",
				"html": "<span>publish</span>",
				"events": {
			        "click": this.togglePublished.bind( this )
			    }
			});
			pubState = null;
			this.publishLink.inject( this.methods );
		}
		if( Boolean(this.nodeData.allowDelete) ){
			this.deleteLink = new Element( "a", {
				"class": "icon delete",
				"html": "<span>delete</span>",
				"title": "delete",
				"events": {
			        "click": this.onDelete.bind( this )
			    }
			});			
			this.deleteLink.inject( this.methods );
		}
		this.methods.inject( this.element );
	},
	
	showControls: function(){
		this.methods.removeClass("hidden");		
	},
	hideControls: function(){
		this.methods.addClass("hidden");		
	},
	togglePublished: function( event ){
		event.stop();
		this.publishLink.toggleClass("published");
		this.publishLink.toggleClass("unpublished");
		/* TODO test to see if once you do it before reload toggling sticks. It should... */
		this.nodeData.published = !this.nodeData.published;
		this.nav.setPublishedStatus( this.id );
	},
	onDelete: function( event ){
		event.stop();
		var confirmed = confirm( "Are you sure you wish to delete the node: “" + this.nodeData.title + "”?\nThis cannot be undone." );
		if( confirmed ) this.nav.removeNode( this );
		confirmed = null;
	},
	destroy: function(){
		delete this.nodeData;
		this.element.destroy();
		delete this.element;
		this.nav.destroyNode( this );
	},
	onMouseOver: function(){
		this.element.addClass("active");
	},
	onMouseOut: function(){
		if( this.nav.getActiveChild( this.tier ) != this.element ) this.element.removeClass("active");
	},
	onClick: function( e ){
		mop.util.stopEvent( e );
	}
});

mop.modules.navigation.CategoryNode = new Class({
	Extends: mop.modules.navigation.Node,
	className: "category",
	toString: function(){
		return "[ object, mop.modules.navigation.CategoryNode ]";
	},
	initialize: function( parentId, nodeData, nav, whichTier ){
		this.parent( parentId, nodeData, nav, whichTier );
	},
	onClick: function( event ){
		this.parent( event );
		this.nav.setActiveChild( this.tier, this.element );
		this.nav.addBreadCrumb( this.parentId, this.tier );
		mop.HistoryManager.changeState("pageId", this.nodeData.id );
		if( ( this.nodeData.addableObjects && this.nodeData.addableObjects.length > 0 ) || this.nodeData.children.length > 0  ){
			this.nav.showCategory( this.nodeData, this.tier + 1 );
		}else if( this.nodeData.landing != "NO_LANDING" ){
			this.nav.loadPage( this.nodeData.id, this.tier, "leafNodeOnClick" );
		}
		mop.ModuleManager.setRID( this.nodeData.id );
	},
});

mop.modules.navigation.LeafNode = new Class({
	Extends: mop.modules.navigation.Node,
	className: "leaf",
	initialize: function( parentId, nodeData, nav, whichTier ){
		this.parent( parentId, nodeData, nav, whichTier );
	},
	toString: function(){
		return "[ object, mop.modules.navigation.LeafNode ]";
	},
	onClick: function( event ){
		this.parent( event );
//		console.log( "onCLICK!!!!! ", this.parentId, this.tier );
		this.nav.addBreadCrumb( this.parentId, this.tier );
		this.nav.setActiveChild( this.tier, this.element );
		mop.HistoryManager.changeState("pageId", this.nodeData.id );
		if( this.nodeData.landing != "NO_LANDING" ) this.nav.loadPage( this.nodeData.id, this.tier, "leafNodeOnClick" );
	}
});

mop.modules.navigation.UtilityNode = new Class({

	Extends: mop.modules.navigation.Node,
	className: "utility",
	initialize: function( nodeData, isLeaf, index, nav, whichTier ){
		this.templateId = nodeData.addableObjects[ index ].templateId;
		this.templateAddText = nodeData.addableObjects[ index ].templateAddText;
		this.parent( null, nodeData, nav, whichTier );

	},

	build: function(){

		this.element = new Element( "li", { "class": this.className });

		if( this.isLeaf ){
			this.addLeaf = new Element( "a", {
				"class" : "addLeaf",
				"text" : this.templateAddText,
				"events": {
					"click" :  this.onAddLeafClicked.bindWithEvent( this )
					//this.nav.addLeaf.bindWithEvent( this.nav, [ this.nodeData.id, this.nodeData, this.tier ] )
				}
			});
			
			this.addLeaf.inject( this.element );
		}else{
			this.addCategory = new Element( "a", {
				"class" : "addCategory",
				"text" : this.templateAddText,
				"events": {
					"click" : this.onAddCategoryClicked.bindWithEvent( this )
				}
			});
			this.addCategory.inject( this.element );
		}

		this.clearBoth = new Element( "div", { "class": "clear" } );
		
		this.element.store( "Class", this );
		this.clearBoth.inject( this.element );
		return this.element;

	},
	
	toString: function(){
		return "[ object, mop.modules.navigation.UtilityNode ]";
	},
	
	saveSort: function( e ){
		mop.util.stopEvent( e );
		this.nav.saveSort( this.nodeData, this.tier );
	},

	onAddLeafClicked: function( e ){
		mop.util.stopEvent( e );
		this.nav.addObject( this.nodeData.id, this.templateId, this.tier );
//		this.nav.addLeaf( this.nodeData.id, this.templateId, this.tier );
	},
	
	onAddCategoryClicked: function( e ){
		mop.util.stopEvent( e );
		this.nav.addObject( this.nodeData.id, this.templateId, this.tier );
	},
	
	addControls: function(){ return false; },
	
	destroy: function(){
		this.templateId = null;
		this.templateAddText = null;
		this.parent();
	}

});
