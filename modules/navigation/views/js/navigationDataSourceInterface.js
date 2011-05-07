if( !mop.modules.navigation ) mop.modules.navigation = {};
/*
    Interface NavDataSource
    See MopCore Class.Mutators.Interface... 
    Interface for objects holding a nav, throws errors if interface not implemented.
*/
mop.modules.navigation.NavigationDataSource = new Interface( "NavigationDataSource", { 
    requestTier: function( parentId, callback ){},
    onNodeSelected: function( nodeId, callback ){},
    // saveSort serializedIds should be an array right?
    saveSortRequest: function( parentId, serializedIds, callback ){},
    removeObjectRequest: function( nodeId, callback ){},
    togglePublishedStatusRequest: function( nodeId, callback ){},
});
