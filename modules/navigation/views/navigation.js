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
	isSorting: false,
	navElement: null,
	breadCrumbs: null,
	navWidth: null,
	colWidth: null,
	navTree: null,
    addObjectPosition: null,
    userLevel: null,
    
	initialize: function( anElement, aMarshal ){
		this.parent( anElement, aMarshal );
		this.navElement = this.element.getElement( ".nav" );
		
		this.userLevel = ( Cookie.read( 'userLevel' ) )? Cookie.read( 'userLevel' ) : "superuser";
		console.log( this.userLevel );
		
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getSibling( ".breadCrumb" ), this.onBreadCrumbClicked.bind( this ) );
		this.breadCrumbs.addCrumb( { label: "Main Menu", id: null, index: 0 } );
		
		this.tiers = [];
		this.totalWidth = this.element.getSize().x;
		this.colWidth = this.totalWidth*.33333;
		console.log( "WIDTHS: ", this.totalWidth, this.colWidth );
		this.navTree = null;
		this.navSlide = new Fx.Scroll( this.element );

		mop.HistoryManager.addListener( this );
		this.addEvent( "pageIdChanged", this.onPageIdChanged );
		this.getNavTree();

		this.addObjectPosition = mop.util.getValueFromClassName( "addObjectPosition", this.element.get( "class" ) );

	},

	displaySuperuserAddObjectDialogue: function( targetId, whichTier, targetName ){
		console.log( "displaySuperuserAddObjectDialogue", targetId, whichTier, targetName, this.addableTemplates );
	    if( !this.addableTemplates ){
	        this.getTemplates( targetId, whichTier, targetName );
	        return;
	    }
	    if( this.superuserAddObjectDialogue ) mop.ModalManager.removeModal( this.superuserAddObjectDialogue );
		this.superuserAddObjectDialogue = new mop.ui.MessageDialogue( this, { 
		    title: "Add an Object to " + targetName,
		    confirmText: "Add Object",
		    cancelText: "Cancel",
		    onConfirm: function(){ console.log( "add the goddamned object" ); }
		});
		this.superuserAddObjectDialogue.setContent( this.buildOptionsListing( this.addableTemplates, targetId, whichTier, this.superuserAddObjectDialogue ) );
		this.superuserAddObjectDialogue.show();
	},
		
	buildOptionsListing: function( objectToTraverse, targetId, whichTier, modal ){
	    
//	    console.log( "buildOptionsListing", objectToTraverse, targetId, whichTier );
	    
	    var ul = new Element( "ul", { 'class': 'listing' } );
	    this.addableTemplates.each( function( aTemplateObj, index ){
	        console.log( aTemplateObj );
	        var moduloClass = ""
	        switch( index%3 ){
	            case 0:
	                moduloClass = "alpha";
	            break;
	            case 1:
                    moduloClass = "";	            
	            break;
	            case 2:
                    moduloClass = "omega";    
	            break;
	        };
	        if( index == this.addableTemplates.length -1 ) moduloClass = "omega";
	        var item = new Element( "li", { 'text': aTemplateObj.templateName, "class": 'menuItem ' + moduloClass } );
	        item.addEvent( 'click', function( e ){
	            mop.util.stopEvent( e );
	            this.addObject( targetId, aTemplateObj.templateName, whichTier );
	            modal.close();
	        }.bindWithEvent( this ) );
    	    ul.adopt( item );
	    }, this );
	    return ul;
	},
	
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
		console.log( "getNavTree ", this.getDeepLinkTarget() );
		new Request.JSON({
			url: mop.util.getAppURL() + 'ajax/'+ this.instanceName + "/getNavTree/" + this.getDeepLinkTarget(),
			onComplete: this.buildNav.bind( this )
		}).send();
	},
	
	getTemplates: function( targetId, whichTier, targetName ){
		new Request.JSON({
			url: mop.util.getAppURL() + 'ajax/'+ this.instanceName + "/getTemplates",
			onComplete: function( templateObj ){
			    console.log( "getTemplates onComplete" );
			    this.addableTemplates = templateObj;
			    this.displaySuperuserAddObjectDialogue( targetId, whichTier, targetName );
			}.bind( this )
		}).send();
	},
	
	getDeepLinkTarget: function(){
		return ( mop.HistoryManager.getValue( "pageId" ) )? mop.HistoryManager.getValue( "pageId" ) : "";
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
		this.marshal.loadPage( pageId );
	},

	setPublishedStatus: function( id ){
		this.marshal.togglePublishedStatus( id );
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
//		console.log( navTree );
		this.navTree = navTree;
		this.navTreeLookupTable = new Hash();
		this.createNavTreeLookupTable( navTree );
		this.showCategory( this.navTree , 0 );
	},

	/*
		Function: addListing
		Argument: whichTier {Number} which tier are adding
	*/
	addListing: function( whichTier, hasAddableObjects ){

        
		var leftMargin = ( whichTier > 0 )? this.colWidth * ( whichTier ) : 0;
		
		var navElementWidth  = ( ( whichTier ) * this.colWidth > this.totalWidth )? ( whichTier ) * ( this.colWidth ): this.totalWidth;
        
        this.navElement.setStyles( {
            "width": navElementWidth,
            "white-space": "nowrap"
        });

		var newTier = new Element( "li", {
			"class": "navTier grid_4",
			styles: {
				"position": "absolute",
				"left": leftMargin
			}
		});

		var newList = new Element( "ul", { "class": ( hasAddableObjects )? "tier grid_4" : "tier tall grid_4" } );
console.log( "A : ", newList ); 
		newList.inject( newTier ); 
		newTier.inject( this.navElement );
		
	},
	
	getTierElement: function( whichTier ){
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
		
		this.breadCrumbs.clearCrumbs( whichTier + 1 );

		targetListElement = null;
		theTier = null;
//		crumb = null;
	},

	/*
		Function: showCategory
		Replaces a given re with new listing
		Arguments:
			aNode - node data from navTree
			whichTier - where are we doing this in the navigation...  
	*/
	showCategory: function( aNode, whichTier ){

//		console.log( "showCategory :::: ", aNode );//, " : ", aNode.id, " : ", whichTier, aNode.children );

		var showPage = true;

		this.clearTier( whichTier );
		this.tiers[ whichTier ] = [];
		this.tiers[ whichTier ].activeChild = null;
		
		this.addListing( whichTier, Boolean( aNode.addableObjects || this.userLevel == "superuser" ) );
		console.log( "*** ** ** ", aNode.addableObjects );
		if( aNode.addableObjects || this.userLevel == 'superuser' ) this.addUtilityNode( aNode, whichTier );
		
		var objectToTraverse;
	    
		if( aNode.children ){
		    console.log("::::::::: A");
		    objectToTraverse = aNode.children;
		}else{ 
		    console.log("::::::::: B");
		    objectToTraverse = aNode;
		}


		if( objectToTraverse.length ){
		    var deepLinkTarget = this.getDeepLinkTarget();
			objectToTraverse.each( function( childNode, anIndex ){
				// Todo: Figure out recursion for opening deeplinks
				var node;
				switch( childNode.contentType ){
					default:
					case "document":
						node = this.addLeafNode( aNode.id, childNode, whichTier );
					break;
					case "category":
						node = this.addCategoryNode( aNode.id, childNode, whichTier );
					break;
				}
//                console.log( ":: ", childNode.title, childNode.slug, childNode.follow, deepLinkTarget );
				if( childNode.follow || childNode.slug == deepLinkTarget ){
					childNode.follow = false;
					showPage = false;
					if( node ) this.setActiveChild( whichTier, node.element );
					var slideTier = new Fx.Scroll( this.getTierElement( whichTier ) );
					if( node )  slideTier.start( node.element.getCoordinates().left, node.element.getCoordinates().top );
					slideTier = null;
					if( aNode.id ) this.breadCrumbs.addCrumb( { label: aNode.title, id: aNode.id, index: whichTier } );
					this.showCategory( childNode, whichTier+1 );
				}
			}, this );
		}
		
		if( aNode.allowChildSort == "true" ) this.makeTierSortable( whichTier );
		
		this.navSlide.toElement( this.getTierElement( whichTier ) );

		if( showPage ) this.loadPage( aNode.id , whichTier );
		
		objectToTraverse = null;
		
	},
	
	onBreadCrumbClicked: function( aNode ){
		if( !aNode.id ){
			node = this.navTree;
		}else{
			node = this.navTreeLookupTable[ aNode.id ];
		}
		this.showCategory( node, aNode.index );
	},
	
	addBreadCrumb: function( nodeParentId, whichTier ){
		if( nodeParentId ){
			var node = this.navTreeLookupTable.get( nodeParentId );
			breadCrumbObj = { label: node.title, id: node.id, index: whichTier };
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
		if( !tierElement.getElement( '.utility' ) ){
    		var utilityNode = new Element( "ul", { "class": "utility grid_4" } );
    		utilityNode.inject( tierElement );		    
		}
		var tier = this.tiers[ whichTier ];
		if( !tierElement ) return;
				
		var utilityNode;
		if( tierElement.getSibling( ".utility" ) ){
			utilityNode = tierElement.getSibling( ".utility" )
		} else { 
			utilityNode = new Element( "ul",{ "class": "utility grid_4" } );
			utilityNode.inject( tierElement, "after" );
		}

		var label = new Element( "li", {
			"class": "label",
			"html" : "<a'>Add an Item to this tier.</a><div class='clear'></div>"
		});
		
		utilityNode.adopt( label );			
		
		if( aNode.addableObjects ){
    		aNode.addableObjects.each( function( leafObj, index ){ 
    			var node = new mop.modules.navigation.UtilityNode( leafObj, aNode.id, this, whichTier );
    			tier.unshift( node );
    			tierElement.getSibling(".utility").adopt( node.element  );			
    		}, this );		    
		}
		
		if( this.userLevel == "superuser" ){
		    console.log( "superuser", aNode.id, this, whichTier );
		    var node = new mop.modules.navigation.SuperUserUtilityNode( aNode.id, this, whichTier, aNode.title );
			tier.unshift( node );
			console.log( ":: ", node.element );
	        tierElement.getSibling(".utility").adopt( node.element );
		}
		
		if( utilityNode ){
			utilityNode.set( "morph", { duration: 350 } );
			utilityNode.setStyle( "position", "relative" );		
			utilityNode.setStyle( "width", this.colWidth );
			utilityNode.setStyle( "width", "100%" );		
			utilityNode.morph( { top: 0 } );
			utilityNode.addEvent( "mouseenter", this.showUtilityNode.bindWithEvent( this, utilityNode ) );
			utilityNode.addEvent( "mouseleave", this.hideUtilityNode.bindWithEvent( this, utilityNode ) );				
		}

	},

	showUtilityNode: function( e, aNode ){
		console.log( "showUtilityNode",  this.isSorting );
		mop.util.stopEvent( e );
		if( this.isSorting ) return;
		aNode.morph( { "top": - ( aNode.getSize().y - 24 ) } );
	},
	
	hideUtilityNode: function( e, aNode ){
//		console.log( "showUtilityNode", aNode );
		mop.util.stopEvent( e );
		aNode.morph( { "top": 0 } );		
	},
	
	addLeafNode: function( parentId, node, whichTier, placementArg ){
		var placement = placementArg || 'bottom';
	 	var node = new mop.modules.navigation.Node( parentId, node, this, whichTier );
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
	 	var node = new mop.modules.navigation.Node( parentId, node, this, whichTier );
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
		console.log( "addObject", parentId, templateId, whichTier );
		var name = prompt( "What would you like to name this Node?" );
		if( name ){
			var placeHolder = this.addPlaceHolder( name, whichTier );
			this.marshal.addObject( name, templateId, parentId, whichTier, placeHolder );
			placeHolder = null;
		}
		name = null;
	},
	
	onObjectAdded: function( node, parentId, whichTier, placeHolder ){
		placeHolder.destroy();
		mop.HistoryManager.changeState( "pageId", node.id );
		if( node.nodeType == "container"){
			var objectElement = this.addCategoryNode( parentId, node, whichTier, this.addObjectPosition ).element;			
		}else{
			var objectElement = this.addLeafNode( parentId, node, whichTier, this.addObjectPosition ).element;			
		}
		this.appendEntryToNavTree( parentId, node, true );
		this.setActiveChild( whichTier, objectElement );
		if( this.getTierElement( whichTier ).retrieve( "sortable" ) ) this.getTierElement( whichTier ).retrieve( "sortable" ).addItems( objectElement ); 
		if( node.addableObjects ) this.showCategory( node , whichTier+1 );
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
	
	makeTierSortable: function( whichTier ){
        var container = this.getTierElement( whichTier );
        var sortable = container.retrieve( "sortable" );
        if( !sortable ){
    		sortable = new mop.ui.Sortable( container, this, container );
            container.store( "sortable", sortable );
        }
	},
	
		
	onOrderChanged: function( sortableElement, sortedItem ){
//		console.log( "onOrderChanged, ", tier.retrieve( "tier" ) );
		var newOrder = this.serialize( sortableElement, sortedItem );
		$clear( this.submitDelay );
		if( this.oldSort != newOrder ) this.submitDelay = this.submitSortOrder.periodical( 3000, this, newOrder );
		newOrder = null;
	},
	
	serialize: function( sortableElement, sortedItem ){
	    console.log( "serialize", sortableElement, sortedItem.retrieve("Class"));
		var children = sortableElement.getChildren( 'li' );
		var sort = [];
		var newChildren = [];
		children.each( function( child, index ){
			newChildren.push( child.retrieve("Class").nodeData );
			sort.push( child.id.substr( "node_".length, child.id.length ) );
		});
		this.navTreeLookupTable[ sortedItem.retrieve( "Class" ).parentId ].children = newChildren;
		return sort.join(",");
	},

	submitSortOrder: function( newOrder, whichTier ){
		if( this.oldSort != newOrder ){
			$clear( this.submitDelay );
			this.JSONSend( "saveSortOrder", { sortorder: newOrder } );
			this.oldSort = newOrder;
		}
	},

	JSONSend: function( action, data, options ){
		mop.util.JSONSend( mop.util.getAppURL() + "ajax/"+ this.marshal.instanceName +  "/" + action + "/" + mop.objectId, data, options );
	},

	renameNode: function( aString ){
		this.element.getElement("#node_"+ mop.objectId ).retrieve("Class").rename( aString );
		
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
	
	removeNode: function( node, fromMarshal ){

		// if called from marshal, dont talk to marshal
		if( Boolean( fromMarshal ) ){
			// if called from marshal we only know the node id
	        console.log( "removeNode A", Boolean( fromMarshal ), node, node.id );
			node = this.getNodeById( node );
		}else{
	    	console.log( "removeNode B", node );
			this.marshal.deleteNode( node.id, node.nodeData.title );
		}
		
		// set some local variables
		var id = node.instanceName;
		var parentId = node.parentId;
		var whichTier = node.tier;
		
		mop.HistoryManager.changeState("pageId", parentId);
		// get a reference to parentNode of navTree in the lookup table to delete the entry of this child...
		var parentRef = this.navTreeLookupTable[ parentId ];
		
		// remove child from children array of parent node
		if( parentRef ){
			parentRef.children.each( function( child, index ){
//				console.log( "parentRef each loop", child.toString(), node.toString(), child );
				if( child == node.nodeData ) parentRef.children.erase( child );				
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
	}

});




/* Class: mop.modules.navigation.Node
	Navigation node superclass
*/
mop.modules.navigation.Node = new Class({
	
	/*
		Constructor: initialize
	*/
	className: "node",
	initialize: function( parentId, nodeData, nav, aTier ){
//		console.log( "::::: initializing : " + this.toString(), nodeData );
		this.nav = nav;
		this.parentId = parentId;
		this.nodeData = nodeData;
		this.nodeType = nodeData.nodeType;
		this.allowTogglePublish = ( nodeData.allowTogglePublish == "true" )? true : false;
		this.allowDelete = ( nodeData.allowDelete == "true" )? true : false;
		this.contentType = nodeData.contentType;
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
			"class": "node " + this.nodeType + " " + this.contentType,
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
	    
		if( !this.allowTogglePublish && !this.allowDelete ) return false;

		this.methods = new Element( "div", { "class": "methods" });
		
		if( this.allowTogglePublish ){			
			var pubState = ( this.nodeData.published )? "published" : "unpublished";
			this.publishLink = new Element( "a", {
				"class": "icon " + pubState,
				"href": "#",
				"title" : ( this.nodeData.published )? "unpublish" : "publish",
				"html": "<span>publish</span>",
				"events": {
			        "click": this.togglePublished.bindWithEvent( this )
			    }
			});
			pubState = null;
			this.publishLink.inject( this.methods );
		}
		if( this.allowDelete ){
			this.deleteLink = new Element( "a", {
				"class": "icon delete",
				"html": "<span>delete</span>",
				"title": "delete",
				"events": {
			        "click": this.onDelete.bindWithEvent( this )
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
	
	togglePublished: function( e ){
		mop.util.stopEvent( e );
		this.publishLink.toggleClass("published");
		this.publishLink.toggleClass("unpublished");
		/* TODO test to see if once you do it before reload toggling sticks. It should... */
		this.nodeData.published = !this.nodeData.published;
		this.nav.setPublishedStatus( this.id );
	},
	
	onDelete: function( e ){
		console.log( "onDelete", this.toString(), this.nodeData );
		mop.util.stopEvent( e );
		this.nav.removeNode( this );
	},
	
	destroy: function(){
		this.element.destroy();
		delete this.nodeData, this.element, this.contentType, this.nodeType;
 		this.nodeData = this.element = this.contentType = this.nodeType = null;
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
		this.nav.setActiveChild( this.tier, this.element );
		this.nav.addBreadCrumb( this.parentId, this.tier );
		mop.HistoryManager.changeState( "pageId", this.nodeData.id );
		if( this.nodeData.addableObjects  || ( this.nodeData.children && this.nodeData.children.length > 0 )  ){
			this.nav.showCategory( this.nodeData, this.tier + 1 );
		}else if( this.nodeData.landing != "NO_LANDING" ){
			this.nav.loadPage( this.nodeData.id, this.tier, "leafNodeOnClick" );
		}
		mop.util.setObjectId( this.nodeData.id );	}
});

mop.modules.navigation.UtilityNode = new Class({

	Extends: mop.modules.navigation.Node,
	className: "utility",

	initialize: function( leafObj, targetId, nav, whichTier ){
	    this.nav = nav;
	    this.targetId = targetId;
		this.templateId = leafObj.templateId;
		this.templateAddText = leafObj.templateAddText;
		this.nodeType = leafObj.nodeType;
		this.contentType = leafObj.contentType;
		this.tier = whichTier;
		this.build();
		return this;
	},

	build: function(){
	    console.log( this.toString(), this.className, this.nodeType, this.contentType, this.templateAddText );
		this.element = new Element( "li", { "class": this.className + " " + this.nodeType + " " + this.contentType  });
		this.addObjectLink = new Element( "a", {
			"text" : this.templateAddText,
			"events": {
				"click" :  this.onAddObjectClicked.bindWithEvent( this )
			}
		});
		this.element.adopt( this.addObjectLink );
		this.clearBoth = new Element( "div", { "class": "clear" } );
		this.element.store( "Class", this );
		this.element.adopt( this.clearBoth );
		return this.element;
	},
	
	toString: function(){
		return "[ object, mop.modules.navigation.UtilityNode ]";
	},
	
	saveSort: function( e ){
		mop.util.stopEvent( e );
		this.nav.saveSort( this.nodeData, this.tier );
	},

	onAddObjectClicked: function( e ){
		mop.util.stopEvent( e );
		this.nav.addObject( this.targetId, this.templateId, this.tier );
	},
	
	addControls: function(){ return false; },
	
	destroy: function(){
		this.templateId = null;
		this.templateAddText = null;
		this.parent();
	}

});


mop.modules.navigation.SuperUserUtilityNode = new Class({
    
    Extends : mop.modules.navigation.UtilityNode,
    className: "utility",
    
	initialize: function( targetId, nav, whichTier, targetName ){
	    this.nav = nav;
	    this.targetName = targetName;
	    this.targetId = targetId;
		this.tier = whichTier;
		this.build();
		return this;
    },
    
	build: function(){

		this.element = new Element( "li", { "class": this.className + " object document" });

		this.link = new Element( "a", {
			"text" : "Add any object",
			"events": {
				"click" :  this.onClicked.bindWithEvent( this )
			}
		});
			
        this.link.inject( this.element );

		this.clearBoth = new Element( "div", { "class": "clear" } );
		
		this.element.store( "Class", this );
		this.clearBoth.inject( this.element );
		return this.element;

	},
	
	onClicked: function( e ){
	    mop.util.stopEvent( e );
	    this.nav.displaySuperuserAddObjectDialogue( this.targetId, this.tier, this.targetName );
	}
    
});