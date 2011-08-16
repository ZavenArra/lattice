lattice.modules.UserManagement = new Class({
	
	Extends: lattice.modules.MoPList,	
	
	/* Section: Constructor */

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
	},
	
	/* Section: Getters & Setters */
	
	getSaveFieldURL: function( itemObjectId  ){
	  var url = lattice.util.getBaseURL() +"ajax/data/usermanagement/savefield/" + itemObjectId;
		return url;
	},
	
	getAddObjectURL: function(){
	    return lattice.util.getBaseURL() + "ajax/html/usermanagement/addObject/";
	},
	
	getRemoveObjectURL: function( itemId ){
	    return lattice.util.getBaseURL()  + "ajax/data/usermanagement/removeObject/" + itemId;
	},
	
	getSubmitSortOrderURL: function(){
	    return lattice.util.getBaseURL() + "ajax/data/usermanagement/saveSortOrder/";
	},
	
	/* Section: Methods */

	toString: function(){ 
		return "[ Object, lattice.MoPObject, lattice.modules.List, lattice.modules.MoPList, lattice.modules.Usermanagement ]";
	}

});

if( !lattice.util.hasDOMReadyFired() ){
	window.addEvent( 'domready', function(){
		lattice.util.DOMReadyHasFired();
		//self instantiates only first instance
		lattice.UserManagement = new lattice.modules.UserManagement( $$( ".classPath-lattice_modules_UserManagement" )[0] );
		lattice.modalManager = new lattice.ui.ModalManager();
		var doAuthTimeout = lattice.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
		if( doAuthTimeout && doAuthTimeout != "0" ) lattice.loginMonitor = new lattice.util.LoginMonitor();
	})
}
	
