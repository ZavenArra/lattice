lattice.modules.Associator = new Class({
	
	Extends: lattice.modules.LatticeAssociator,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/associator/savefield/" + itemObjectId;
//		lattice.log( '\t\getSaveFieldURL', url );
		return url;
	},
	
	getAssociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/associate/' + id + "/" + itemid + "/" + latticeid;
//		lattice.log( '\t\getAssociateURL', id );
		return url;
	},
	
	getDissociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/dissociate/' + id + "/" + itemid + "/" + latticeid;
//		lattice.log( '\t\getDissociateURL', url );
		return url;
	},
	
	getSubmitSortOrderURL: function(){
		var url = lattice.util.getBaseURL() + "ajax/data/associator/saveSortOrder/" + this.getObjectId();
//		lattice.log( '\t\getSubmitSortOrderURL', url );
		return url;
	},
	
	getFilterPoolByWordURL: function( pid, latticeid, word ){
		lattice.log( lattice, lattice.util );
		var url = lattice.util.getBaseURL() + "ajax/html/associator/filterPoolByWord/" + pid + "/" + latticeid + "/" + word;
		lattice.log( '\t\getFilterPoolByWordURL', url );
		return url;
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeAssociator, lattice.modules.Associator ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	}
	
});

lattice.modules.RadioAssociator = new Class({
	
	Extends: lattice.modules.LatticeRadioAssociator,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/associator/savefield/" + itemObjectId;
		lattice.log( '\t\getSaveFieldURL', url );
		return url;
	},
	
	getAssociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/associate/' + id + "/" + itemid + "/" + latticeid;
//		lattice.log( 'getAssociateURL', id, itemid, latticeid  );
//		lattice.log( url );
		return url;
	},
	
	getDissociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/dissociate/' + id + "/" + itemid + "/" + latticeid;
//		lattice.log( '\t\getDissociateURL', url );
		return url;
	},
	
	getSubmitSortOrderURL: function(){
		var url = lattice.util.getBaseURL() + "ajax/data/associator/saveSortOrder/" + this.getObjectId();
		lattice.log( '\t\getSubmitSortOrderURL', url );
		return url;
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeAssociator, lattice.modules.Associator ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	}
});
