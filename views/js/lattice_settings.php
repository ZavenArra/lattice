var lattice = {
	baseURL: '<?=URL::base();?>',
	loginTimeout: <?=Kohana::config('lattice.login_timeout');?>,
	defaultLanguage: '<?=Kohana::config('lattice.default_language');?>',
	debug: true
};
