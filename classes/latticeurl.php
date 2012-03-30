<?
/* @package Lattice */

Class LatticeUrl {

	public static function site($url){
		return url::site($url, null, false);
	}
}
