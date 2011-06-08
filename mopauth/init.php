<?php

Route::set('authWithRedirect', '<controller>/<action>(/<redirect>)', array(
    'controller' => 'auth',
    'redirect' => '[A-z\/0-9]++',
        )
);







