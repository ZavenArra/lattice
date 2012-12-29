var lattice = {
	baseURL: '<?=URL::base();?>',
	loginTimeout: <?=Kohana::config('lattice.loginTimeout');?>,
	defaultLanguage: '<?=Kohana::config('lattice.defaultLanguage');?>',
	debug: true
};
