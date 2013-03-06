<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Lattice {

	public function action_index()
	{
		throw new HTTP_Exception_404('Ajax controller called without action. Check URL.');
	}
   
   private function handle_exception($e){
      
      // Get the exception information
      $type    = get_class($e);
      $code    = $e->get_code();
      $message = $e->get_message();
      $file    = $e->get_file();
      $line    = $e->get_line();

      // Get the exception backtrace
      $trace = $e->get_trace();
      
      ob_start();

      // Include the exception HTML
      if ($view_file = Kohana::find_file('views', Kohana_Exception::$error_view))
      {
        include $view_file;
      }
      else
      {
        throw new Kohana_Exception('Error view file does not exist: views/:file', array(
          ':file' => Kohana_Exception::$error_view,
        ));
      }

      // Display the contents of the output buffer
      $message = ob_get_clean();
      return $message;
   }

	public function action_data($uri)
	{
		//request to child, just data
		$arguments = explode('/', $uri);

		try {
			$sub_request = Request::Factory($uri);
			$data = $sub_request->execute()->data();
		} catch (Exception $e) {
			//return HTML from exception
         
          // Start an output buffer
   
			$ajax_response = array(
				'return_value' => FALSE,
				'response' => $this->handle_exception($e),
				'arguments'=>$arguments

			);
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode($ajax_response));
			return;
		}
		$ajax_response = array(
			'return_value' => TRUE,
			'response'=>$data,
			'arguments'=>$arguments
		);
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($ajax_response));
		$this->response->body();
	}

	public function action_html($uri)
	{
//		Kohana::$log->add(Log::INFO, 'Ajax html request begin');
		$arguments = explode('/', $uri);

		try {
			$sub_request = Request::Factory($uri);
			$html = $sub_request->execute()->body();
		} catch (Exception $e) {
			//return HTML from exception

			$message = $e;
			$ajax_response = array(
				'return_value' => FALSE,
				'response' => $this->handle_exception($e),
				'arguments'=>$arguments

			);
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode($ajax_response));
			return;
		}


		$css_resources = array();
		foreach($this->resources['librarycss'] as $css){
			array_push($css_resources, $css);
		}
		foreach($this->resources['css'] as $css){
			array_push($css_resources, $css);
		}

		$js_resources = array();
		foreach($this->resources['libraryjs'] as $js){
			array_push($js_resources, $js);
		}
		foreach($this->resources['js'] as $js){
			array_push($js_resources, $js);
		}

		$ajax_response = array(
			'response'=>array(
				'html'=>$html,
				'js'=>$js_resources,
				'css'=>$css_resources
			),
			'return_value' => TRUE,
			'arguments'=>$arguments
		);
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($ajax_response));
	}

	public function action_compound($uri)
	{
		$arguments = explode('/', $uri);

		try {
   		$sub_request = Request::Factory($uri);
			$request_response = $sub_request->execute();
   	} catch (Exception $e) {
			//return HTML from exception
			$message = $e;
			$ajax_response = array(
				'return_value' => FALSE,
				'response' => $this->handle_exception($e),
				'arguments'=>$arguments
			);
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode($ajax_response));
			return;
		}


		$css_resources = array();
		foreach($this->resources['librarycss'] as $css){
			array_push($css_resources, $css);
		}
		foreach($this->resources['css'] as $css){
			array_push($css_resources, $css);
		}

		$js_resources = array();
		foreach($this->resources['libraryjs'] as $js){
			array_push($js_resources, $js);
		}
		foreach($this->resources['js'] as $js){
			array_push($js_resources, $js);
		}


		$compound_response = array(
			'data' => $request_response->data(),
			'html' => $request_response->body(),
			'css' => $css_resources,
			'js' => $js_resources,
		);
		$ajax_response = array(
			'return_value' => TRUE,
			'response'=>$compound_response,
			'arguments'=>$arguments
		);
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($ajax_response));
	}

} // End Welcome
