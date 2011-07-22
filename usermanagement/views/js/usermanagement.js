mop.modules.UserManagement = new Class({
	
	Extends: mop.modules.MoPList,	
	
	/* Section: Constructor */

	initialize: function( anElement, aMarshal, options ){
		this.parent( anElement, aMarshal, options );
		alert("USERMANAGEMENT!");
	},
	
	/* Section: Getters & Setters */
	
	getSaveFieldURL: function(){
	  var url = mop.util.getBaseURL() +"ajax/data/usermanagement/savefield/";
		console.log( "::::::", this.toString(), "getSaveFieldURL", url );
		return url;
	},
	
	getAddObjectURL: function(){
	    return mop.util.getBaseURL() + "ajax/data/usermanagement/addObject/";
	},
	
	getRemoveObjectURL: function( item ){
	    return mop.util.getBaseURL()  + "ajax/data/usermanagement/removeObject/" + item.getObjectId();
	},
	
	getSubmitSortOrderURL: function(){
	    return mop.util.getBaseURL() + "ajax/data/usermanagement/saveSortOrder/";
	},
	
	/* Section: Methods */

	toString: function(){ 
		return "[ Object, mop.MoPObject, mop.modules.List, mop.modules.MoPList, mop.modules.Usermanagement ]";
	}

});

if( !mop.util.hasDOMReadyFired() ){
	window.addEvent( 'domready', function(){
		mop.util.DOMReadyHasFired();
		//self instantiates only first instance
		mop.UserManagement = new mop.modules.UserManagement( $$( ".classPath-mop_modules_UserManagement" )[0] );
		mop.ModalManager = new mop.ui.ModalManager();
		mop.DepthManager = new mop.util.DepthManager(); 
		var doAuthTimeout = mop.util.getValueFromClassName( 'loginTimeout', $(document).getElement("body").get("class") );
		if( doAuthTimeout && doAuthTimeout != "0" ) mop.loginMonitor = new mop.util.LoginMonitor();
	})
}
	