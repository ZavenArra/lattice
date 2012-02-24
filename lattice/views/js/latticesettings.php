/* conditional is probably not necessary here since its latticesettings should be the first thing to load always... its vestigeous */
if( !lattice ) var lattice = {
	baseURL: '<?=URL::base();?>',
	loginTimeout: <?=Kohana::config('lattice.loginTimeOut');?>,
	defaultLanguage: '<?=Kohana::config('lattice.defaultLanguage');?>',
	debug: true
};
