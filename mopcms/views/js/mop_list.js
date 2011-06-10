mop.modules.List = new Class({

	Extends: mop.modules.MoPList,
	
	/* Section: Getters & Setters */
	getAddItemURL: function(){ return "ajax/html/"+this.getSubmissionController()+"/addItem/" + this.getObjectId(); },
	getSubmitSortOrderURL: function(){ return "ajax/html/" + this.getSubmissionController() + "/saveSortOrder/" + this.getObjectId(); },
	
	toString: function(){ return "[ object, mop.modules.List, mop.modules.MoPList ]"; },

	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}

});

mop.modules.ListItem = new Class({

	Extends: mop.modules.MoPListItem,

    /* Section: Getters & Setters */
	getDeleteItemURL: function(){ return "ajax/data/list/deleteItem/" + this.getObjectId(); },
	
	initialize: function( anElement, aMarshal, addItemDialogue, options ){
	    this.parent( anElement, aMarshal, addItemDialogue, options );
    }
	
}