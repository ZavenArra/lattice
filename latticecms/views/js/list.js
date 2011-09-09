lattice.modules.List = new Class({
	
	Extends: lattice.modules.LatticeList,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/list/savefield/" + itemObjectId;
		return url;
	},
	
	getAddObjectURL: function(){
	    return lattice.util.getBaseURL() + "ajax/html/list/addObject/" + this.getObjectId();
	},
	
	getRemoveObjectURL: function( itemObjectId ){
	    return lattice.util.getBaseURL() + "ajax/data/list/removeObject/" + itemObjectId;
	},
	
	getSubmitSortOrderURL: function(){
	    return lattice.util.getBaseURL() + "ajax/data/list/saveSortOrder/" + this.getObjectId();
	},
	
	toString: function(){
	    return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeList, lattice.modules.List ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
        this.parent( anElement, aMarshal, options );
	}
	
});
