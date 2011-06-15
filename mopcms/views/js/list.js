mop.modules.List = new Class({
	Extends: mop.modules.MoPList,	
	/* Section: Getters & Setters */
	getAddObjectURL: function( item ){
	    console.log( "getAddObjectURL", this.getObjectId() );
	    return mop.util.getBaseURL() + "ajax/html/list/addObject/" + this.getObjectId();
	},
	getSubmitSortOrderURL: function(){
	    return mop.util.getBaseURL() + "ajax/html/list/saveSortOrder/" + this.getObjectId();
	},
	getRemoveObjectURL: function( item ){ 
	    return mop.util.getBaseURL() + "ajax/data/list/removeObject/" + item.getObjectId();
	},
	toString: function(){
	    return "[ object, mop.MoPObject, mop.modules.Module, mop.modules.List, mop.modules.MoPList, mop.modules.List ]";
	},
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}
});
