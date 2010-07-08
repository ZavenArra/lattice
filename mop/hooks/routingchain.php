<?


Event::clear('system.routing');
Event::add('system.routing', array('Router', 'find_uri'));
if(Kohana::config('mop.staging_enabled')){
	Event::add('system.routing', array('StagingHook', 'RouteStaging'));
}
//add this event at the end of the pre-routing chain
Event::add('system.routing', array('ProtocolRoutingHook', 'RouteProtocol'));

Event::add('system.routing', array('Router', 'setup'));

Event::add('system.post_routing', array('RouteVirtualModulesHook', 'RouteVirtualModules'));
if(Kohana::config('mop.slugs_enabled')){
	//add this event at the end of the routing chain
	Event::add('system.post_routing', array('RouteSlugsHook', 'RouteSlugs'));
}
