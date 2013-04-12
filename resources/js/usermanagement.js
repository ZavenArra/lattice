lattice.modules.UserManagement = new Class({
	
	Extends: lattice.modules.LatticeList,	
	
  controller: null,

	/* Section: Constructor */

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
    var elementClass = anElement.get( 'class' );
    this.controller = lattice.util.getValueFromClassName( "controller", elementClass );
	},
	
	/* Section: Getters & Setters */
	
	getSaveFieldURL: function( itemObjectId  ){
	  var url = lattice.util.getBaseURL() +"ajax/data/"+this.controller+"/save_field/" + itemObjectId;
		return url;
	},
	
	getAddObjectURL: function(){
	    return lattice.util.getBaseURL() + "ajax/html/"+this.controller+"/add_object/";
	},
	
	getRemoveObjectURL: function( itemId ){
	    return lattice.util.getBaseURL()  + "ajax/data/"+this.controller+"/remove_object/" + itemId;
	},
	
	getSubmitSortOrderURL: function(){
	    return lattice.util.getBaseURL() + "ajax/data/"+this.controller+"/save_sort_order/";
	},
	
	/* Section: Methods */

	toString: function(){ 
		return "[ Object, lattice.LatticeObject, lattice.modules.List, lattice.modules.LatticeList, lattice.modules.Usermanagement ]";
	}

});

if( !lattice.util.hasDOMReadyFired() ){
	window.addEvent( 'domready', function(){
		lattice.util.DOMReadyHasFired();
		//self instantiates only first instance
		lattice.UserManagement = new lattice.modules.UserManagement( $$( ".classPath-lattice_modules_UserManagement" )[0] );
		lattice.modalManager = new lattice.ui.ModalManager();
		var doAuthTimeout = lattice.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
		if( doAuthTimeout && doAuthTimeout != "0" ) loginMonitor = new lattice.util.LoginMonitor();
	})
}
	
