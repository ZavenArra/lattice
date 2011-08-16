<?php

//check for setup
Lattice_Initializer::check(
	array(
		'latticeauth'
	)
);

Route::set('authWithRedirect', '<controller>/<action>(/<redirect>)', array(
    'controller' => 'auth',
    'redirect' => '[A-z\/0-9]++',
        )
);







