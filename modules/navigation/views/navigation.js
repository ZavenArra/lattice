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
	navTree: [],
    
	initialize: function( anElement, aMarshal ){
		this.parent( anElement, aMarshal );
		this.navElement = this.element.getElement( ".nav" );
		this.userLevel = ( Cookie.read( 'userLevel' ) )? Cookie.read( 'userLevel' ) : "superuser";	
		this.breadCrumbs =  new mop.ui.navigation.BreadCrumbTrail( this.element.getSibling( ".breadCrumb" ), this.onBreadCrumbClicked.bind( this ) );
		this.breadCrumbs.addCrumb( { label: "Main Menu", id: null, index: 0 } );
		this.tiers = [];
		this.totalWidth = this.element.getSize().x;
		this.colWidth = this.totalWidth*.33333;
		this.navSlide = new Fx.Scroll( this.element );
		mop.HistoryManager.addListener( this );
		this.addEvent( "pageIdChanged", this.onPageIdChanged );
		//@thiago
		//this should absolutely not be a hash
		//there really isn't any gain to it being a hash
		//this.navTreeLookupTable = new Hash();
		this.navTreeLookupTable = new Array();
		//console.log("############## ", this.navTree );
		//this.createNavTreeLookupTable( this.navTree );
		this.loadNaviNode( 0 , 0 ); 
		//guess what!  this.navTree is never initialized
		this.navTreeLookupTable[0] = null;
		//this.createNavTreeLookupTable( this.navTree );
		//and we don't create athe beginning now, because we lazy load
		//everything gets appended in loadTier

		//@thiago
		//no loadContent since this node is the tree root
		
		
		this.addObjectPosition = mop.util.getValueFromClassName( "addObjectPosition", this.element.get( "class" ) );
	},

	displaySuperuserAddObjectDialogue: function( targetId, tierIndex, targetName ){
		console.log( "displaySuperuserAddObjectDialogue", targetId, tierIndex, targetName, this.addableTemplates );
	    if( !this.addableTemplates ){
	        this.getTemplates( targetId, tierIndex, targetName );
	        return;
	    }
	    if( this.superuserAddObjectDialogue ) mop.ModalManager.removeModal( this.superuserAddObjectDialogue );
		this.superuserAddObjectDialogue = new mop.ui.MessageDialogue( this, { 
		    title: "Add an Object to " + targetName,
		    confirmText: "Add Object",
		    cancelText: "Cancel",
		    onConfirm: function(){ console.log( "add the goddamned object" ); }
		});
		this.superuserAddObjectDialogue.setContent( this.buildOptionsListing( this.addableTemplates, targetId, tierIndex, this.superuserAddObjectDialogue ) );
		this.superuserAddObjectDialogue.show();
	},
		
	buildOptionsListing: function( objectToTraverse, targetId, tierIndex, modal ){
	    
//	    console.log( "buildOptionsListing", objectToTraverse, targetId, tierIndex );
	    
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
	            this.addObject( targetId, aTemplateObj.templateName, tierIndex );
	            modal.close();
	        }.bindWithEvent( this ) );
    	    ul.adopt( item );
	    }, this );
	    return ul;
	},
	
	onPageIdChanged: function( pageId ){
		console.log( "onPageIdChanged", pageId );
	},
	
	toString: function(){
		return "[ Object, mop.modules.navigation.Navigation ]";
	},
	
	getTemplates: function( targetId, tierIndex, targetName ){
		new Request.JSON({
			url: mop.util.getAppURL() + 'ajax/'+ this.instanceName + "/getTemplates",
			onComplete: function( templateObj ){
			    console.log( "getTemplates onComplete" );
			    this.addableTemplates = templateObj;
			    this.displaySuperuserAddObjectDialogue( targetId, tierIndex, targetName );
			}.bind( this )
		}).send();
	},
	
	getDeepLinkTarget: function(){
		return ( mop.HistoryManager.getValue( "pageId" ) )? mop.HistoryManager.getValue( "pageId" ) : "";
	},

	/*
		Function: loadContent
		Ajax call to retrieve a page with 'pageId'
		Arguments:
			pageId - {Number} the desired page's id
	 	Callback: calls onPageReceived with JSON object { css: [ "pathToCSSFile", "pathToCSSFile", ... ], js: [ "pathToJSFile", "pathToJSFile", "pathToJSFile", ... ], html: "String" }
	*/
	loadContent: function( pageId, tierIndex ){
//		console.log( "loadContent ", "pageId: " + pageId );
		if( !pageId ) return;
		this.currentPage = pageId;
		this.clearTier( tierIndex + 1 );
		this.marshal.loadContent( pageId );
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
		console.log("nav tree lookup",this.navTreeLookupTable);
	},

	appendNodeToNavTree: function( parentId, node ){
		console.log( "appendNodeToNavTree", parentId, node );
		if(this.addObjectPosition=='top'){
			this.navTreeLookupTable[parentId].children.unshift( node );
		}else{
			this.navTreeLookupTable[parentId].children.push( node );
		}
	},

	/*
		Function: injectAddObjectTool
		Argument: tierIndex {Number} which tier are adding
	*/
	injectAddObjectTool: function( tierIndex, hasAddableObjects ){

        
		var leftMargin = ( tierIndex > 0 )? this.colWidth * ( tierIndex ) : 0;
		
		var navElementWidth  = ( ( tierIndex ) * this.colWidth > this.totalWidth )? ( tierIndex ) * ( this.colWidth ): this.totalWidth;
        
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
		newList.inject( newTier ); 
		newTier.inject( this.navElement );
		
	},
	
	getTierElement: function( tierIndex ){
		return ( this.navElement.getChildren()[ tierIndex ] )? this.navElement.getChildren()[ tierIndex ].getElement( "ul.tier" ) : false;
	},

	/*
		Function: clearTier
		Argument: tierIndex {Number} which tier are we clearing
	*/
	clearTier: function( tierIndex ){
		
//		console.log( "\t\tclearTier ", tierIndex );
		
		var targetListElement = this.getTierElement( tierIndex, "clearTier" );
		if( !targetListElement ) return false;
		
		var theTier = this.tiers[ tierIndex ];
		if( theTier ){
			theTier.activeChild = null;
			theTier.each( function( node, index){
//				console.log( node );
				theTier.erase( node );
			//	node.destroy();
			});
			this.tiers.erase(tierIndex);
		}
		
		// clears out elements from this tier, and subsequent tiers
		subsequentTierElements = targetListElement.getParent().getAllNext();
		targetListElement.getParent().destroy();
		subsequentTierElements.each( function( aTier, index ){
			aTier.destroy();
		});
		
		this.breadCrumbs.clearCrumbs( tierIndex + 1 );

		targetListElement = null;
		theTier = null;
//		crumb = null;
	},
	
	/* Function: showNode
	   Called on loadNaviNode response
	   Arguments: objectToTraverse 
    */
loadTier: function( nodeData, tierIndex){
						nodeData = JSON.decode( nodeData );
						console.log( "loadTier .....", nodeData, tierIndex );

						//place the new node data into the navTree book keepping
						var parentNode = this.getActiveChild( tierIndex - 1 );
						parentId = 0;
						if(parentNode){	
							parentId = parentNode.retrieve( "Class" ).id;
						}
						this.appendNodeToNavTree( parentId, nodeData );


						//display the tier eelement for this node
						//we always do this when a node loads
						if( nodeData.allowChildSort == "true" ) this.makeTierSortable( tierIndex );
						this.navSlide.toElement( this.getTierElement( tierIndex ) );

						//add the addable objects tool to this tier
						this.injectAddObjectTool( tierIndex, Boolean( nodeData.addableObjects || this.userLevel == "superuser" ) );
						if( nodeData.addableObjects || this.userLevel == 'superuser' ) this.addUtilityNode( nodeData, tierIndex );

						//loop through the child nodes and see if we are deeplinking 
						var followedChild = true;
						if( nodeData.length ){
							var deepLinkTarget = this.getDeepLinkTarget();
							nodeData.each( function( childNode, anIndex ){
									var node = this.addNode( nodeData.id, childNode, tierIndex );
									if( childNode.follow || childNode.slug == deepLinkTarget ){
											childNode.follow = false;
											followedChild = false;
											if( node ) this.setActiveChild( tierIndex, node.element );
											//@thiago
											//I don't think we need this here
											//var slideTier = new Fx.Scroll( this.getTierElement( tierIndex ) );
											//if( node )  slideTier.start( node.element.getCoordinates().left, node.element.getCoordinates().top );
											//slideTier = null;
											if( nodeData.id ) this.breadCrumbs.addCrumb( { label: nodeData.title, id: nodeData.id, index: tierIndex } );
											//i think this function gets called here
											//this.nav.addBreadCrumb( this.parentId, tierIndex );
											this.loadNaviNode( childNode.id, tierIndex+1 );
									}
							}, this );
						}

						return followedChild;
		
        
    },
    
	/*
		Function: loadNaviNode
		Replaces a given re with new listing
		Arguments:
			aNode - node data from navTree
			tierIndex - where are we doing this in the navigation...  
	*/
					//this is completely convoluted
					//how coudl you load a node, with already knowing the nodes data
	loadNaviNode: function( nodeId, tierIndex ){
		console.log( "loadNaviNode :::: ", nodeId );//, " : ", aNode.id, " : ", tierIndex, aNode.children );
		this.clearTier( tierIndex );
		this.tiers[ tierIndex ] = [];
		this.tiers[ tierIndex ].activeChild = null;
		
		

		var url = mop.util.getAppURL() + "ajax/"+ this.instanceName + "/getNavNode/" + nodeId;
		console.log( url );
		new Request.JSON({
			url: url,
			onComplete: function( response, nodeDataJSON ){ this.loadTier( nodeDataJSON, tierIndex ) }.bind( this )
		}).send();

		//we don't want this in here, since loadNaviNode sould just load that one node
		//we don't always want to load content, necessarily
 //   this.loadContent( aNode.id , tierIndex );

	},
	
	onBreadCrumbClicked: function( nodeData ){
		if( !nodeData.id ){
			node = this.navTree;
		}else{
			node = this.navTreeLookupTable[ nodeData.id ];
		}
		this.loadNaviNode( node.id, nodeData.index );
		this.loadContent( nodeData.id, nodeData.index); 
	},
	
	addBreadCrumb: function( nodeParentId, tierIndex ){
		if( nodeParentId ){
			var node = this.navTreeLookupTable.get( nodeParentId );
			breadCrumbObj = { label: node.title, id: node.id, index: tierIndex };
		}else{
			obj = null;
			if( tierIndex == 0 ){
				breadCrumbObj = { label : "Main Menu", id : null, index: tierIndex }
			}
		}
		this.breadCrumbs.addCrumb( breadCrumbObj );//{ label: node.title, id: node.id, anIndex: tierIndex } );
	},
	
	addUtilityNode: function( aNode, tierIndex ){
		var tierElement = this.getTierElement( tierIndex );
		if( !tierElement.getElement( '.utility' ) ){
    		var utilityNode = new Element( "ul", { "class": "utility grid_4" } );
    		utilityNode.inject( tierElement );		    
		}
		var tier = this.tiers[ tierIndex ];
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
    			var node = new mop.modules.navigation.UtilityNode( leafObj, aNode.id, this, tierIndex );
    			tier.unshift( node );
    			tierElement.getSibling(".utility").adopt( node.element  );			
    		}, this );		    
		}
		
		if( this.userLevel == "superuser" ){
		    console.log( "superuser", aNode.id, this, tierIndex );
		    var node = new mop.modules.navigation.SuperUserUtilityNode( aNode.id, this, tierIndex, aNode.title );
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
	
	addNode: function( parentId, node, tierIndex, placementArg ){
		var placement = placementArg || 'bottom';
	 	var node = new mop.modules.navigation.Node( parentId, node, this, tierIndex );
		this.tiers[ tierIndex ].unshift( node );
		node.element.inject( this.getTierElement( tierIndex ), placement  );
		try{
			return node;
		}finally{
			node = null;
		}
	},
	
	setActiveChild: function( tierIndex, whichElement ){
		if( this.tiers[ tierIndex ].activeChild ) this.tiers[ tierIndex ].activeChild.removeClass("active");
		whichElement.addClass("active");
		this.tiers[ tierIndex ].activeChild = whichElement;
	},
	
	getActiveChild: function ( tierIndex ){
		if(tierIndex < 0){
			return 0;
		}
		return ( this.tiers[ tierIndex ].activeChild )? this.tiers[ tierIndex ].activeChild : null;
	},

	addObject: function( parentId, templateId, tierIndex ){
		console.log( "addObject", parentId, templateId, tierIndex );
		var name = prompt( "What would you like to name this Node?" );
		if( name ){
			var placeHolder = this.addPlaceHolder( name, tierIndex );
			this.marshal.addObject( name, templateId, parentId, tierIndex, placeHolder );
			placeHolder = null;
		}
		name = null;
	},
	
	onObjectAdded: function( node, parentId, tierIndex, placeHolder ){
		placeHolder.destroy();
		mop.HistoryManager.changeState( "pageId", node.id );
        var objectElement = this.addNode( parentId, node, tierIndex, this.addObjectPosition ).element;			
		this.appendNodeToNavTree( parentId, node );
		this.setActiveChild( tierIndex, objectElement );
		if( this.getTierElement( tierIndex ).retrieve( "sortable" ) ) this.getTierElement( tierIndex ).retrieve( "sortable" ).addItems( objectElement ); 
		// @thiago
		// this doesn't seem to make a lot of sense
		// seems to indicate that a naviNode gets loaded only when it has addableObjects
		// actually it should basically always be loaded, since anything may have children
		// or am i wrong here
		if( node.addableObjects ) this.loadNaviNode( node.id , tierIndex+1 );
		//@thiago
		//loadContent downstairs anytime it's not a container onObjectAdded
		if( node.nodeType != 'containter'){
			this.nav.loadContent( this.nodeData.id, tierIndex+1 );
		}
	},
	
	addPlaceHolder: function( name, tierIndex ){

		console.log("addPlaceHolder");
		var placeHolder = new Element( "li", { "class": "placeHolder" } );
		var nodeTitle = new Element( "h5", { "text" : "Adding " + name + "…" } );		
		var clearBoth = new Element( "div", { "class": "clear" } );

		var tierElement = this.getTierElement( tierIndex, "addPlaceHolder" );
		
		nodeTitle.inject( placeHolder );
		clearBoth.inject( placeHolder );
		placeHolder.inject( tierElement, this.addObjectPosition );	
		if( !this.tiers[tierIndex].slideTier) this.tiers[tierIndex].slideTier = new Fx.Scroll( tierElement );
		if(this.addObjectPosition == 'top'){
			this.tiers[tierIndex].slideTier.toTop();
		} else {
			this.tiers[tierIndex].slideTier.toBottom();
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
	
	makeTierSortable: function( tierIndex ){
        var container = this.getTierElement( tierIndex );
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

	submitSortOrder: function( newOrder, tierIndex ){
		if( this.oldSort != newOrder ){
			$clear( this.submitDelay );
			this.JSONSend( "saveSortOrder", { sortorder: newOrder } );
			this.oldSort = newOrder;
		}
	},

	JSONSend: function( action, data, options ){
	    console.log( "NAV JSONSEND", action, data, options );
	    var objectId = ( mop.objectId )? mop.objectId : 0;
		mop.util.JSONSend( mop.util.getAppURL() + "ajax/"+ this.marshal.instanceName +  "/" + action + "/" + objectId, data, options );
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


		//@thiago
		//this is an example of a convoluted block of code
		//the procedures need to be isolated
		//on procedure is deleting from marshal
		//the other is deleting from the navi
		//they should be called separately where appropriate, not lumped together into a one size fits all
		// if called from marshal, dont talk to marshal
		if( Boolean( fromMarshal ) ){
			// if called from marshal we only know the node id
	        console.log( "removeNode A", Boolean( fromMarshal ), node, node.id );
			node = this.getNodeById( node );
			//the node has already been delete by the marshal
		}else{
	    	console.log( "removeNode B", node );
			this.marshal.deleteNode( node.id, node.nodeData.title );
		}
		
		// set some local variables
		var id = node.instanceName;
		var parentId = node.parentId;
		var tierIndex = node.tier;
		
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

		var tierInQuestion = this.navElement.getChildren( "li" )[ tierIndex ];
		var nodesInTier = tierInQuestion.getChildren( "ul" ).getChildren( "li" );

		if ( node.nodeData.children ) this.clearTier( tierIndex + 1 );
		this.tiers[ tierIndex ].erase( node );

		node.destroy();

		if( tierInQuestion.getElement( "ul" ).getChildren( "li" ).length == 0 && !tierInQuestion.getElement( "li.utility" ) ){
			tierInQuestion.destroy();
			this.navElement.setStyle( "width", this.colWidth * ( tierIndex - 1 ) );
		}
		delete node;
		
		nodesInTier = null;
		tierInQuestion = null;
		parentRef = null;
		tierIndex = null;
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

		notFollowingChild = true;
		if( this.nodeData.addableObjects  || ( this.nodeData.children && this.nodeData.children.length > 0 )  ){
			notFollowingChild = this.nav.loadTier( this.nodeData, this.tier + 1 );
		}
		if(notFollowingChild && this.nodeData.nodeType != 'container' ){
			this.nav.loadContent( this.nodeData.id, this.tier );
		}
		
		mop.util.setObjectId( this.nodeData.id );	}
});

mop.modules.navigation.UtilityNode = new Class({

	Extends: mop.modules.navigation.Node,
	className: "utility",

	initialize: function( leafObj, targetId, nav, tierIndex ){
	    this.nav = nav;
	    this.targetId = targetId;
		this.templateId = leafObj.templateId;
		this.templateAddText = leafObj.templateAddText;
		this.nodeType = leafObj.nodeType;
		this.contentType = leafObj.contentType;
		this.tier = tierIndex;
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
    
	initialize: function( targetId, nav, tierIndex, targetName ){
	    this.nav = nav;
	    this.targetName = targetName;
	    this.targetId = targetId;
		this.tier = tierIndex;
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
