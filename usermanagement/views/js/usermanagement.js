mop.modules.UserManagement = new Class({
	Extends: mop.modules.MoPList,	
	/* Section: Getters & Setters */
	getAddObjectURL: function(){
	    return mop.util.getBaseURL() + "ajax/data/usermanagement/addObject/";
	},
	getRemoveObjectURL: function( item ){
	    return mop.util.getBaseURL()  + "ajax/data/usermanagement/removeObject/" + item.getObjectId();
	},
	getSubmitSortOrderURL: function(){
	    return mop.util.getBaseURL() + "ajax/data/usermanagement/saveSortOrder/";
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
