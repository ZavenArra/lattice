<?php
/* @package Lattice */

Class Lattice_url {

	public static function site($url)
{
		return url::site($url, NULL, false);
	}
}
