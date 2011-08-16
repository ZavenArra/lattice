if( !lattice.modules.navigation ) lattice.modules.navigation = {};
/*
    Interface NavDataSource
    See MopCore Class.Mutators.Interface... 
    Interface for objects holding a nav, throws errors if interface not implemented.
*/
lattice.modules.navigation.NavigationDataSource = new Interface( "NavigationDataSource", { 
    requestTier: function( parentId, callback ){},
    onNodeSelected: function( nodeId, callback ){},
    saveTierSortRequest: function( parentId, serializedIds, callback ){},
    removeObjectRequest: function( nodeId, callback ){},
    togglePublishedStatusRequest: function( nodeId, callback ){},
    getRootNodeId: function(){},
});
