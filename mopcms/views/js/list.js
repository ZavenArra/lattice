mop.modules.List = new Class({
	Extends: mop.modules.MoPList,	
	/* Section: Getters & Setters */
	getAddItemURL: function(){
	    return "ajax/html/"+this.getSubmissionController()+"/addItem/" + this.getObjectId();
	},
	
	getSubmitSortOrderURL: function(){
	    return "ajax/html/" + this.getSubmissionController() + "/saveSortOrder/" + this.getObjectId();
	},

	getDeleteItemURL: function( item ){ 
	    return "ajax/data/list/deleteItem/" + item.getObjectId();
	},

	toString: function(){
	    return "[ object, mop.MoPObject, mop.modules.List, mop.modules.MoPList, mop.modules.List ]";
	},

	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}

});
