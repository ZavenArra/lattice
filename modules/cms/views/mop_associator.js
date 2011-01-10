mop.modules.Associator = new Class({
    
	Extends: mop.modules.List,

    initialize: function( anElement, aMarshal, options ){
        console.log( this.toString() );
        this.super( anElement, aMarshal, options );
    },
    
    toString: function(){
        return "[ mop.modules.Module, mop.modules.Associator ]";
    },
    
    associate: function(){
        
    },
    
    desociate: function(){
        
    }
    
});