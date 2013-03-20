<?php

Class Builder_Frontend {

  private $base_path = 'application/views/generated/';

  public function __construct()
  {
    if ( ! is_writable($this->base_path))
    {
      die($this->base_path.' must be writable');
    }
  }

  public function index()
  {
    echo "Configuring Frontend\n";
    echo "Reading application/config/frontend.xml\n";

    lattice::config('objects', '//object_types');

    flush();
    ob_flush();
    flush();

    $created_views = array();
    // 	foreach (lattice::config('frontend', '//view') as $view )
    {
      // 	//this has removed the ability to build virtual views
      foreach (lattice::config('objects', '//object_type') as $object_type)
      {
        $view = lattice::config('frontend', '//view[@name="'.$object_type->get_attribute('name').'"]');
        if (count($view))
        {
          $view = $view->item(0);
        }
        if ($view)
        {
          $view_name = $view->get_attribute('name');
        } else {
          $view_name = $object_type->get_attribute('name');
        }

        echo $view_name."\n";
        flush();
        ob_flush();
        flush();

        ob_start();
        if ( ! $view OR  ($view AND $view->get_attribute('load_page')=='TRUE'))
        {
          echo "<h1><?php=\$content['main']['title'];?></h1>\n\n";
          // this also implies that name is a objecttypename
          foreach (lattice::config('objects', 
            sprintf('//object_type[@name="%s"]/elements/*', $view_name )) as $element)
          {

            switch($element->tag_name)
            {
            case 'list':
              $this->make_list_data_html($element, "\$content['main']");
              break;
            case 'associator':
              $this->make_associator_data_html($element, "\$content['main']");
              break;
            default:
              frontend::make_html_element($element, "\$content['main']");
              break;
            }

          }

          if ($view AND $view->get_attribute('load_page')=='TRUE')
          {

            // Now the include_data
            if ($i_data_nodes = lattice::config('frontend',"// view[@name=\"".$view->get_attribute('name')."\"]/include_data"))
            {
              foreach ($i_data_nodes as $i_data_config)
              {
                $prefix = "\$content";
                $this->make_include_data_html($i_data_config, $prefix, NULL);
              }
            }

            if ($subviews = lattice::config('frontend',"// view[@name=\"".$view->get_attribute('name')."\"]/subview"))
            {
              foreach ($subviews as $subview_config)
              {
                echo "\n<?php=\$".$subview_config->get_attribute('label').";?>\n";
              }
            }

          }



          $html = ob_get_contents();
          ob_end_clean();
          $file = fopen($this->base_path.$view_name.'.php', 'w');
          fwrite($file, $html);
          fclose($file);

          $created_views[] = $view_name;
        }
      }

      echo 'Completed all basic object views' . "\n";
      flush();
      ob_flush();
      flush();

      // and any virtual views
      foreach (lattice::config('frontend', '//view') as $view_config)
      {
        $view_name = $view_config->get_attribute('name');

        if ( in_array($view_name, $created_views))
        {
          continue;
        }
        echo 'Virtual View: '.$view_name . "\n";
        flush();
        ob_flush();
        flush();


        touch($this->base_path.$view_name.'.php');

        ob_start();
        // Now the include_data

        if ($i_data_nodes = lattice::config('frontend',"// view[@name=\"".$view_name."\"]/include_data"))
        {
          foreach ($i_data_nodes as $i_data_config)
          {
            $prefix = "\$content";
            $this->make_include_data_html($i_data_config, $prefix, NULL);
          }
        }

        if ($subviews = lattice::config('frontend',"// view[@name=\"".$view_name."\"]/subview"))
        {
          foreach ($subviews as $subview_config)
          {
            echo "\n<?php=\$".$subview_config->get_attribute('label').";?>\n";
          }
        }


        $html = ob_get_contents();
        ob_end_clean();
        $file = fopen($this->base_path.$view_name.'.php', 'w');
        fwrite($file, $html);
        fclose($file);
      }



      echo "Done\n";
    }

    public function make_list_data_html($list_data_config, $prefix, $indent = '')
    {
      $object_types = array();
      foreach (lattice::config('objects', 'addable_object', $list_data_config) as $addable)
      {
        $object_type_name = $addable->get_attribute('objectTypeName');
        $object_types[$object_type_name] = $object_type_name;
      }

      $this->make_multi_object_type_loop($object_types, $list_data_config->get_attribute('name'),  $prefix, $indent);

    }

    // TODO: This doesn't currently support filter types that don't declare objec_type_names or 
    // nor with multiple object_type_names per filter
    public function make_associator_data_html($associator_data_config, $prefix, $indent = '')
    {
      $object_types = array();
      $filters = lattice::config('objects', 'filter', $associator_data_config);
      foreach ($filters as $filter)
      {
        if ($filter->get_attribute('objectTypeName'))
        {
          $object_types[] = $filter->get_attribute('objectTypeName');
        }
      }

      $this->make_multi_object_type_loop($object_types, $associator_data_config->get_attribute('name'),  $prefix, $indent);
    }


    public function make_include_data_html($i_data_config, $prefix, $parent_template, $indent='')
    {
      $label = $i_data_config->get_attribute('label');


      $object_types = array();
      // if slug defined, get object_type from slug
      if ($slug = $i_data_config->get_attribute('slug'))
      {
        $object = Graph::object($slug);
        if ( ! $object->loaded())
        {
          // error out,
          // object must be loaded from data.xml for this type of include conf
        }
        $object_types[] = $object->objecttype->objecttypename;
      }
      if ( ! count($object_types))
      {
        $object_types = $i_data_config->get_attribute('object_type_filter');
        if ($object_types!='all')
        {
          $object_types = explode(',', $object_types);
        } else {
          $object_types = array();
        }
      }

      if ( ! count($object_types))
      {
        // no where for object_types
        // assume that we'll have to make a good guess based off 'from' parent
        $from=$i_data_config->get_attribute('from');
        if ($from=="parent")
        {

          // get the info from addable_objects of the current
          foreach (lattice::config('objects', sprintf('//object_type[@name="%s"]/addable_object', $parent_template)) as $addable)
          {
            $object_type_name = $addable->get_attribute('objectTypeName');
            $object_types[$object_type_name] = $object_type_name;
          }

          // and we can also check all the existing data to see if it has any other object_types
          $parent_objects = Graph::object()->objecttype_filter($parent_template)->published_filter()->find_all();
          foreach ($parent_objects as $parent)
          {
            $children = $parent->get_published_children();
            foreach ($children as $child)
            {
              $object_type_name = $child->objecttype->objecttypename;
              $object_types[$object_type_name] = $object_type_name;
            }
          }
        } else {
          // see if from is a slug
          $object_types_from_parent = $this->get_children_object_types(Graph::object($from));
          $object_types = array_merge($object_types, $object_types_from_parent);


        }
      }	

      //  now $object_types contains all the needed object_types in the view


      $this->make_multi_object_type_loop($object_types, $label, $prefix, $indent, $i_data_config);
    }

    protected function make_multi_object_type_loop($object_types, $label, $prefix, $indent='', $frontend_node=NULL )
    {
      echo $indent."<h2>$label</h2>\n\n";
      echo $indent."<ul id=\"$label\" >\n";
      $do_switch = FALSE;


      if (count($object_types)>1)
      {
        $do_switch = TRUE;
      }

      echo $indent."<?phpforeach ({$prefix}['$label'] as \${$label}Item):?>\n";
      if ($do_switch)
      {
        echo $indent." <?phpswitch(\${$label}Item['object_type_name'])
      {\n";
      }

      if (count($object_types) == 0)
      {
        echo $indent." <?php=latticeview::Factory(\${$label}Item)->view()->render();?>\n";
      }

      $i=0;
      foreach ($object_types as $object_type_name)
      {
        if ($do_switch)
        {
          echo $indent;
          if ($i==0)
            echo "    case '$object_type_name':?>\n";
          else 
            echo " <?php case '$object_type_name':?>\n";
        }
        echo $indent . "  <li class=\"$object_type_name\">\n";
        echo $indent . "   " . "<h2><?php=\${$label}Item['title'];?></h2>\n\n";
        foreach (lattice::config('objects', sprintf('//object_type[@name="%s"]/elements/*', $object_type_name)) as $element)
        {
          switch($element->tag_name)
          {
          case 'list':
            $this->make_list_data_html($element, "\${$label}Item", $indent);
            break;
          case 'associator':
            $this->make_associator_data_html($element, "\${$label}Item", $indent);
            break;
          default:
            frontend::make_html_element($element, "\${$label}Item", $indent . "   ");
            break;
          }
        }

        // handle lower levels
        if ($frontend_node)
        {
          foreach (lattice::config('frontend', 'include_data', $frontend_node) as $next_level)
          {
            $this->make_include_data_html($next_level, "\${$label}Item", $object_type_name, $indent . "   ");
          }
        }

        echo $indent . "  </li>\n";
        if ($do_switch)
        {
          echo $indent . " <?php  break;?>\n";
        }
        $i++;
      }
      if ($do_switch)
      {
        echo $indent . "<?php }?>\n";
      }


      echo $indent . "<?phpendforeach;?>\n" .
        $indent . "</ul>\n\n";
    }

    protected function get_children_object_types($object)
    {
      $object_types = array();
      if ($object->loaded())
      {
        // find its addable objects
        foreach (lattice::config('objects', sprintf('//object_type[@name="%s"]/addable_object', $object->objecttype->objecttypename)) as $addable)
        {
          $object_type_name = $addable->get_attribute('objectTypeName');
          $object_types[$object_type_name] = $object_type_name;
        }
        // and follow up with any existing data
        $children = $object->get_published_children();
        foreach ($children as $child)
        {
          $object_type_name = $child->objecttype->objecttypename;
          $object_types[$object_type_name] = $object_type_name;
        }
      }
      return $object_types;

    }
  }
