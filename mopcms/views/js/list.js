mop.modules.List = new Class({
	
	Extends: mop.modules.MoPList,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function(itemObjectId){
	  var url = mop.util.getBaseURL() +"ajax/data/list/savefield/" + itemObjectId;
		console.log( "::::::", this.toString(), "getSaveFieldURL", url );
		return url;
	},
		
	getAddObjectURL: function(){
	    console.log( "getAddObjectURL", this.getObjectId(), this.element );
	    return mop.util.getBaseURL() + "ajax/html/list/addObject/" + this.getObjectId();
	},
	
	getRemoveObjectURL: function( itemObjectId ){
	    return mop.util.getBaseURL() + "ajax/data/list/removeObject/" + itemObjectId;
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
