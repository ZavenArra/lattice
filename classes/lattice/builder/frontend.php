<?php

Class Lattice_Builder_Frontend {

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

    core_lattice::config('objects', '//objectTypes');

    cms_util::flush_ob();

    $created_views = array();
    foreach (core_lattice::config('objects', '//objectType') as $object_type)
    {
      $view = core_lattice::config('frontend', '//view[@name="'.$object_type->getAttribute('name').'"]');
      if (count($view))
      {
        $view = $view->item(0);
      }

      if ($view)
      {
        $view_name = $view->getAttribute('name');
      } else {
        $view_name = $object_type->getAttribute('name');
      }
      echo $view_name."\n";

      cms_util::flush_ob();

      ob_start();
      if ( ! $view OR  ($view AND $view->getAttribute('load_page')=='TRUE'))
      {
        echo "<h1><?php echo \$content['main']['title'];?></h1>\n\n";
        // this also implies that name is a objecttypename
        foreach (core_lattice::config('objects', 
          sprintf('//objectType[@name="%s"]/elements/*', $view_name )) as $element)
        {

          switch($element->tagName)
          {
          case 'list':
            $this->make_list_data_html($element, "\$content['main']");
            break;
          case 'associator':
            $this->make_associator_data_html($element, "\$content['main']");
            break;
          default:
            frontend_core::make_html_element($element, "\$content['main']");
            break;
          }

        }

        if ($view AND $view->getAttribute('load_page')=='TRUE')
        {

          // Now the include_data
          if ($i_data_nodes = core_lattice::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/includeData"))
          {
            foreach ($i_data_nodes as $i_data_config)
            {
              $prefix = "\$content";
              $this->make_include_data_html($i_data_config, $prefix, NULL);
            }
          }

          if ($subviews = core_lattice::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/subview"))
          {
            foreach ($subviews as $subview_config)
            {
              echo "\n<?php echo \$".$subview_config->getAttribute('label')."; ?>\n";
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
    cms_util::flush_ob();

    // and any virtual views
    foreach (core_lattice::config('frontend', '//view') as $view_config)
    {
      $view_name = $view_config->getAttribute('name');

      if ( in_array($view_name, $created_views))
      {
        continue;
      }
      echo 'Virtual View: '.$view_name . "\n";
      touch($this->base_path.$view_name.'.php');

      cms_util::flush_ob();
      ob_start();


      // Now the include_data
      if ($i_data_nodes = core_lattice::config('frontend',"//view[@name=\"".$view_name."\"]/includeData"))
      {
        foreach ($i_data_nodes as $i_data_config)
        {
          $prefix = "\$content";
          $this->make_include_data_html($i_data_config, $prefix, NULL);
        }
      }

      if ($subviews = core_lattice::config('frontend',"//view[@name=\"".$view_name."\"]/subview"))
      {
        foreach ($subviews as $subview_config)
        {
          echo "\n<?php echo \$".$subview_config->getAttribute('label')."; ?>\n";
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
      foreach (core_lattice::config('objects', 'addable_object', $list_data_config) as $addable)
      {
        $objectTypeName = $addable->getAttribute('objectTypeName');
        $object_types[$objectTypeName] = $objectTypeName;
      }

      $this->make_multi_object_type_loop($object_types, $list_data_config->getAttribute('name'),  $prefix, $indent);

    }

    // TODO: This doesn't currently support filter types that don't declare objec_type_names or 
    // nor with multiple objectTypeNames per filter
    public function make_associator_data_html($associator_data_config, $prefix, $indent = '')
    {
      $object_types = array();
      $filters = core_lattice::config('objects', 'filter', $associator_data_config);
      foreach ($filters as $filter)
      {
        if ($filter->getAttribute('objectTypeName'))
        {
          $object_types[] = $filter->getAttribute('objectTypeName');
        }
      }

      $this->make_multi_object_type_loop($object_types, $associator_data_config->getAttribute('name'),  $prefix, $indent);
    }


    public function make_include_data_html($i_data_config, $prefix, $parent_template, $indent='')
    {
      $label = $i_data_config->getAttribute('label');


      $object_types = array();
      // if slug defined, get object_type from slug
      if ($slug = $i_data_config->getAttribute('slug'))
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
        $object_types = $i_data_config->getAttribute('object_type_filter');
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
        $from=$i_data_config->getAttribute('from');
        if ($from=="parent")
        {

          // get the info from addable_objects of the current
          foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/addable_object', $parent_template)) as $addable)
          {
            $objectTypeName = $addable->getAttribute('objectTypeName');
            $object_types[$objectTypeName] = $objectTypeName;
          }

          // and we can also check all the existing data to see if it has any other object_types
          $parent_objects = Graph::object()->objecttype_filter($parent_template)->published_filter()->find_all();
          foreach ($parent_objects as $parent)
          {
            $children = $parent->get_published_children();
            foreach ($children as $child)
            {
              $objectTypeName = $child->objecttype->objecttypename;
              $object_types[$objectTypeName] = $objectTypeName;
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

      echo $indent."<?php foreach ({$prefix}['$label'] as \${$label}Item):?>\n";
      if ($do_switch)
      {
        echo $indent." <?php switch(\${$label}Item['objectTypeName'])
      {\n";
      }

      if (count($object_types) == 0)
      {
        echo $indent." <?php echo core_view::Factory(\${$label}Item)->view()->render(); ?>\n";
      }

      $i=0;
      foreach ($object_types as $objectTypeName)
      {
        if ($do_switch)
        {
          echo $indent;
          if ($i==0)
            echo "    case '$objectTypeName':?>\n";
          else 
            echo " <?php case '$objectTypeName':?>\n";
        }
        echo $indent . "  <li class=\"$objectTypeName\">\n";
        echo $indent . "   " . "<h2><?php echo \${$label}Item['title'];?></h2>\n\n";
        foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $objectTypeName)) as $element)
        {
          switch($element->tagName)
          {
          case 'list':
            $this->make_list_data_html($element, "\${$label}Item", $indent);
            break;
          case 'associator':
            $this->make_associator_data_html($element, "\${$label}Item", $indent);
            break;
          default:
            frontend_core::make_html_element($element, "\${$label}Item", $indent . "   ");
            break;
          }
        }

        // handle lower levels
        if ($frontend_node)
        {
          foreach (core_lattice::config('frontend', 'includeData', $frontend_node) as $next_level)
          {
            $this->make_include_data_html($next_level, "\${$label}Item", $objectTypeName, $indent . "   ");
          }
        }

        echo $indent . "  </li>\n";
        if ($do_switch)
        {
          echo $indent . " <?php  break; ?>\n";
        }
        $i++;
      }
      if ($do_switch)
      {
        echo $indent . "<?php } ?>\n";
      }


      echo $indent . "<?php endforeach; ?>\n" .
        $indent . "</ul>\n\n";
    }

    protected function get_children_object_types($object)
    {
      $object_types = array();
      if ($object->loaded())
      {
        // find its addable objects
        foreach (core_lattice::config('objects', sprintf('//objectType[@name="%s"]/addable_object', $object->objecttype->objecttypename)) as $addable)
        {
          $objectTypeName = $addable->getAttribute('objectTypeName');
          $object_types[$objectTypeName] = $objectTypeName;
        }
        // and follow up with any existing data
        $children = $object->get_published_children();
        foreach ($children as $child)
        {
          $objectTypeName = $child->objecttype->objecttypename;
          $object_types[$objectTypeName] = $objectTypeName;
        }
      }
      return $object_types;

    }
  }
