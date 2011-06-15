mop.modules.List = new Class({
	Extends: mop.modules.MoPList,
	/* Section: Getters & Setters */
	getAddObjectURL: function(){ return "ajax/html/"+this.getSubmissionController()+"/addObject/" + this.getObjectId(); },
	getSubmitSortOrderURL: function(){ return "ajax/html/" + this.getSubmissionController() + "/saveSortOrder/" + this.getObjectId(); },
	getRemoveObjectURL: function(){ return "ajax/data/list/removeObject/" + this.getObjectId(); },
	toString: function(){ return "[ object, mop.MoPObject, mop.modules.Module, mop.modules.MoPList, mop.modules.List ]"; },
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}
});
