lattice.modules.List = new Class({
	
	Extends: lattice.modules.MoPList,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/list/savefield/" + itemObjectId;
		console.log( "::::::", this.toString(), "getSaveFieldURL", url, itemObjectId );
		return url;
	},
		
	getAddObjectURL: function(){
	    console.log( "getAddObjectURL", this.getObjectId(), this.element );
	    return lattice.util.getBaseURL() + "ajax/html/list/addObject/" + this.getObjectId();
	},
	
	getRemoveObjectURL: function( itemObjectId ){
	    return lattice.util.getBaseURL() + "ajax/data/list/removeObject/" + itemObjectId;
	},
	
	getSubmitSortOrderURL: function(){
	    return lattice.util.getBaseURL() + "ajax/data/list/saveSortOrder/" + this.getObjectId();
	},
	
	toString: function(){
	    return "[ object, lattice.MoPObject, lattice.modules.Module, lattice.modules.MoPList, lattice.modules.List ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}
	
});
