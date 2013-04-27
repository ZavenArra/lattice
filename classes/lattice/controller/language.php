<?php

Class Lattice_Controller_Language extends Controller {

  public function action_change_language($language_code, $redirect_object_id = NULL)
  {

    core_lattice::set_current_language($language_code);
    if ($redirect_object_id)
    {
      // process redirect with new language_code
      // this is actually the core_view::get_language_aware_slug call
      $this->request->redirect(core_view::slug($redirect_object_id));
    }
  }


  public function action_language_controls()
  {
    $languages = Graph::languages();
    $view = new View('language_controls');
    $view->languages = $languages;
    $this->response->body($view->render());
  }
}
