<?php
/*
 * Class: Controller_HTML
 * This controller provides a simple manual override to the auto layout wrapping
 * implemented in Controller_Layout subclasses. 
 */

Class Controller_HTML extends Controller_Lattice {

		public function action_html($uri) {

				$sub_request = Request::Factory($uri)->execute();
				$this->response->body($sub_request->body());
		}

}
