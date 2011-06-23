mop.modules.UserManagement = new Class({
	Extends: mop.modules.MoPList,	
	/* Section: Getters & Setters */
	getAddObjectURL: function(){
	    return "ajax/html/"+this.getSubmissionController()+"/addObject/";
	},
	getRemoveObjectURL: function( item ){
	    return "ajax/data/usermanagement/removeObject/" + item.getObjectId();
	},
	getSubmitSortOrderURL: function(){
	    return "ajax/html/" + this.getSubmissionController() + "/saveSortOrder/";
	},
	/* Section: Constructor */
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	},
    /* Section: Methods */
	toString: function(){ 
	    return "[ Object, mop.MoPObject, mop.modules.List, mop.modules.MoPList, mop.modules.Usermanagement ]";
    }
});
