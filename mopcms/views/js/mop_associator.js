mop.modules.Associator = new Class({
    
	Extends: mop.modules.List,
	
    possibleAssociations: null,
    
    initialize: function( anElement, aMarshal, options ){
        console.log( this.toString() );
        this.parent( anElement, aMarshal, options );
        this.possibleAssociations = this.element.getElement( ".pool" );
    },
    
    toString: function(){
        return "[ mop.modules.Module, mop.modules.Associator ]";
    },
    
    associate: function(){
        
    },
    
    desociate: function(){
        
    },
    
    destroy: function(){
        this.parent();
    }
    
});

mop.modules.AssociatorItem = new Class({

    initialize: function(){
        
    },
    
    associate: function(){
        
    },
    
    desociate: function(){
        
    },
    
    destroy: function(){
        
    }
    
});