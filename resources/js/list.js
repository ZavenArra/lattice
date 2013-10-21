lattice.modules.List = new Class({
	
	Extends: lattice.modules.LatticeList,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/list/save_field/" + itemObjectId;
		return url;
	},
	
	getAddObjectURL: function( path ){
		var url = lattice.util.getBaseURL() + 'ajax/html/list/' + path;
		return url;
	},
	
	getRemoveObjectURL: function( objectId ){
		return lattice.util.getBaseURL() + "ajax/data/list/remove_object/" + objectId;
	},
	
	getSubmitSortOrderURL: function(){
		return lattice.util.getBaseURL() + "ajax/data/list/save_sort_order/" + this.getObjectId();
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeList, lattice.modules.List ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	}
	
});
