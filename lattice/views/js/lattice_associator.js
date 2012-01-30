lattice.modules.Associator = new Class({
    
	Extends: lattice.modules.List,
	
    possibleAssociations: null,
    
    initialize: function( anElement, aMarshal, options ){
        console.log( this.toString() );
        this.parent( anElement, aMarshal, options );
        this.possibleAssociations = this.element.getElement( ".pool" );
    },
    
    toString: function(){
        return "[ lattice.modules.Module, lattice.modules.Associator ]";
    },
    
    associate: function(){
        
    },
    
    desociate: function(){
        
    },
    
    destroy: function(){
        this.parent();
    }
    
});

lattice.modules.AssociatorItem = new Class({

    initialize: function(){
        
    },
    
    associate: function(){
        
    },
    
    desociate: function(){
        
    },
    
    destroy: function(){
        
    }
    
});