lattice.modules.Associator = new Class({
	
	Extends: lattice.modules.LatticeAssociator,
	
	/* Section: Getters & Setters */	

	getSaveFieldURL: function( itemObjectId ){
	  var url = lattice.util.getBaseURL() +"ajax/data/associator/save_field/" + itemObjectId;

		return url;
	},
	
	getAssociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/associate/' + id + "/" + itemid + "/" + latticeid;

		return url;
	},
	
	getDissociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/dissociate/' + id + "/" + itemid + "/" + latticeid;

		return url;
	},
	
	getSubmitSortOrderURL: function( itemid, latticeid ){
		var url = lattice.util.getBaseURL() + "ajax/data/cms/save_sort_order/" + itemid + "/" + latticeid;

		return url;
	},
	
	getFilterPoolByWordsURL: function( pid, latticeid, word ){
		var url = lattice.util.getBaseURL() + "ajax/compound/associator/filter_pool_by_word/" + pid + "/" + latticeid + "/0/" + word;
  	//stuffing in page number as 0
		//alert("dfdsf");

		return url;
	},

	getAutocompleteOptionsURL: function( pid, latticeid, word){
		var url = lattice.util.getBaseURL() + "ajax/compound/associator/autocomplete_options/" + pid + "/" + latticeid + "/" + word;

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
	getAssociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/associate/' + id + "/" + itemid + "/" + latticeid;


		return url;
	},
	
	getDissociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/dissociate/' + id + "/" + itemid + "/" + latticeid;

		return url;
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeAssociator, lattice.modules.RadioAssociator ]";
	},
	
	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	}
});

lattice.modules.CheckboxAssociator = new Class({
	
	Extends: lattice.modules.LatticeCheckboxAssociator,

	initialize: function( anElement, aMarshal, options ){

		this.parent( anElement, aMarshal, options );
	},

	/* Section: Getters & Setters */	
	
	getAssociateURL: function( id, itemid, latticeid ){

		var url = lattice.util.getBaseURL() + 'ajax/html/associator/associate/' + id + "/" + itemid + "/" + latticeid;

		return url;
	},
	
	getDissociateURL: function( id, itemid, latticeid ){
		var url = lattice.util.getBaseURL() + 'ajax/html/associator/dissociate/' + id + "/" + itemid + "/" + latticeid;

		return url;
	},
	
	toString: function(){
		return "[ object, lattice.LatticeObject, lattice.modules.Module, lattice.modules.LatticeAssociator, lattice.modules.CheckboxAssociator ]";
	}

});
