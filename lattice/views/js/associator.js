lattice.modules.Associator = new Class({
	
	Extends: lattice.modules.LatticeAssociator,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/associator/savefield/" + itemObjectId;
		if( lattice.debug ) console.log( '\t\getSaveFieldURL', url );
		return url;
	},
	
	getAssociateURL: function( id ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/' + id;
		if( lattice.debug ) console.log( '\t\getAssociateURL', id );
		return url;
	},
	
	getDissociateURL: function( id ){
		var url = lattice.util.getBaseURL() + "ajax/html/associator/dissociate/" + id;
		if( lattice.debug ) console.log( '\t\getDesociateURL', url );
		return url;
	},
	
	getSubmitSortOrderURL: function(){
		var url = lattice.util.getBaseURL() + "ajax/data/associator/saveSortOrder/" + this.getObjectId();
		if( lattice.debug ) console.log( '\t\getSubmitSortOrderURL', url );
		return url;
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeAssociator, lattice.modules.Associator ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
		if( lattice.debug ) console.log( 'constructor for ', this.toString() );
		this.parent( anElement, aMarshal, options );
	}
	
});
