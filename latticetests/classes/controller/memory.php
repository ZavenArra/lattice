<?

Class Controller_Memory extends Controller {

	public function action_index(){

			for($i=0; $i<1000; $i++){
				echoFlush('Memory usage 1 '.number_format(memory_get_usage(true)));

				//$object = Graph::object();
				//$object->addObject('singleIPE');
				//
				$lang = ORM::Factory('language');
				$lang->save();
				//$lang->__destruct();
				$lang = NULL;
				unset($lang);
				//gc_collect_cycles();
				//
				//$object = ORM::Factory('object');
				//$object->save();

				echoFlush('Memory usage 2 '.number_format(memory_get_usage(true)));


			}
	}
}
