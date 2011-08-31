if( !lattice ) var lattice = {
//this file should be auto-generated, looped from some setting file, then people can add what they want, but dont have to do it in two places for existing vars?
	baseURL: '<?=URL::base();?>',
	loginTimeout: <?=Kohana::config('lattice.loginTimeOut');?>,
	defaultLanguage: '<?=Kohana::config('lattice.defaultLanguage');?>'
};
