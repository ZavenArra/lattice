<?php

//check for setup
MOP_Initializer::check(
	array(
		'mopauth'
	)
);

Route::set('authWithRedirect', '<controller>/<action>(/<redirect>)', array(
    'controller' => 'auth',
    'redirect' => '[A-z\/0-9]++',
        )
);







