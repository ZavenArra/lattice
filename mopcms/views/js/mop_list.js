mop.modules.List = new Class({

	Extends: mop.modules.MoPList,
	
	/* Section: Getters & Setters */
	getAddItemURL: function(){ return "ajax/html/"+this.getSubmissionController()+"/addObject/" + this.getObjectId(); },
	getSubmitSortOrderURL: function(){ return "ajax/html/" + this.getSubmissionController() + "/saveSortOrder/" + this.getObjectId(); },
	getDeleteItemURL: function(){ return "ajax/data/list/removeObject/" + this.getObjectId(); },
    
	toString: function(){ return "[ object, mop.modules.List, mop.modules.MoPList ]"; },

	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}

});
