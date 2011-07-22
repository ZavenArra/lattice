mop.modules.List = new Class({
	
	Extends: mop.modules.MoPList,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function(){
	  var url = mop.util.getBaseURL() +"ajax/data/list/savefield/" + this.getObjectId();
		console.log( "::::::", this.toString(), "getSaveFieldURL", url );
		return url;
	},
		
	getAddObjectURL: function( item ){
	    console.log( "getAddObjectURL", this.getObjectId(), this.element );
	    return mop.util.getBaseURL() + "ajax/html/list/addObject/" + this.getObjectId();
	},
	
	getRemoveObjectURL: function( item ){
	    return mop.util.getBaseURL() + "ajax/data/list/removeObject/" + item.getObjectId();
	},
	
	getSubmitSortOrderURL: function(){
	    return mop.util.getBaseURL() + "ajax/html/list/saveSortOrder/" + this.getObjectId();
	},
	
	toString: function(){
	    return "[ object, mop.MoPObject, mop.modules.Module, mop.modules.MoPList, mop.modules.List ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}
	
});
