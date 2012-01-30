if( !lattice ) var lattice = {
	baseURL: '<?=URL::base();?>',
	loginTimeout: <?=Kohana::config('lattice.loginTimeOut');?>,
	defaultLanguage: '<?=Kohana::config('lattice.defaultLanguage');?>'
};
