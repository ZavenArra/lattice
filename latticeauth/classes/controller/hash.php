<?php

Class Controller_Hash extends Controller {


	public function action_hash($password){
		echo Auth::instance()->hash($password);
	}
}
