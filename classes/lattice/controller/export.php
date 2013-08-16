<?php

class Lattice_Controller_Export extends Controller {

	public $output_dir;
	private $dtd;
	private $implementation;
	private $doc;
	private $doc_work;
	private $document_number = 1;

	public function __construct()
	{
		if ( ! is_writable('application/views/xmldumps/'))
		{
			// 	die('application/views/xmldumps/ must be writable');
		}
	}
	// all this logic should be moved to the export MODEL
	private function get_object_fields($object)
	{
		$nodes = array();
		$content = $object->get_content();
		foreach ($content as $key => $value)
		{
			if ($key == 'objectTypeName')
			{
				continue;
			}
			if ($key == 'id')
			{
				// continue;
			}
			$node = $this->doc->createElement($key);
			if (is_array($value))
			{

			} elseif (is_object($value))
			{
				switch (get_class($value))
				{
				case 'Model_File':
					// or copy to directory and just use filename
					if ($value->filename)
					{
						$target_path = $this->output_dir . $value->filename;
						if (file_exists($target_path))
						{
							$node->appendChild($this->doc->createTextNode($target_path));
						}
					}
					break;
				case 'Model_Page':
					foreach ($this->get_object_fields($value) as $sub_field)
					{
						$node->appendChild($sub_field);
					}
					break;
				}
			} else {
				$node->appendChild($this->doc->createTextNode($value));
			}
			$nodes[] = $node;
		}
		return $nodes;
	}

	private function get_object_fields_lattice_format($object)
	{
		$nodes = array();
		$content = $object->get_content();
		foreach ($content as $key => $value)
		{
			if ($key == 'objectTypeName' OR $key == 'dateadded')
			{
				continue;
			}
			if ($key == "slug" AND $value == "")
			{
				continue;
			}
			if ($key == "title" AND $value == "")
			{
				// $value = microtime();
			}
			if ($key == "id")
			{
				continue;
			}
			if ($key != "tags" AND is_array($value))
			{
				// skipping container objects.
				continue;
			}

			$node = $this->doc->createElement('field');
			$node_attr = $this->doc->createAttribute('name');
			$node_value = $this->doc->createTextNode($key);
			$node_attr->appendChild($node_value);
			$node->appendChild($node_attr);

			if (is_object($value))
			{

				switch (get_class($value))
				{
				case 'Model_File':
					// or copy to directory and just use filename
					if ($value->filename)
					{
						$target_path = $this->output_dir . $value->filename;
						if (file_exists($target_path))
						{
							$node->appendChild($this->doc->createTextNode($target_path));
						}
					}
					break;
				case 'Model_Object':
					foreach ($this->get_object_fields_lattice_format($value) as $sub_element)
					{
						$node->appendChild($sub_element);
					}
					break;
				}
			} elseif ($key == "tags")
			{

				$node->appendChild($this->doc->createTextNode(implode(',',$value)));

			} else {

				$node->appendChild($this->doc->createTextNode($value));
			}
			$nodes[] = $node;
		}
		$node = $this->doc->createElement('field');
		$node_attr = $this->doc->createAttribute('name');
		$node_value = $this->doc->createTextNode('published');
		$node_attr->appendChild($node_value);
		$node->appendChild($node_attr);
		$node->appendChild($this->doc->createTextNode($object->published));
		$nodes[] = $node;
		return $nodes;
	}

	private function export_tier($objects)
	{

		$nodes = array();
		foreach ($objects as $object)
		{
			
			//echo $object->objecttype->objecttypename."<br />";
			
			$element = $object->objecttype->objecttypename;
			
			$item = $this->doc->createElement($element);

			foreach ($this->get_object_fields($object) as $field)
			{
				$item->appendChild($field);
			}

			// and get the children
			$child_objects = $object->get_lattice_children();

			foreach ($this->export_tier($child_objects) as $child_item)
			{
				$item->appendChild($child_item);
			}
			$nodes[] = $item;
		}

		return $nodes;
	}

	private function export_tier_lattice_format($objects)
	{

		$nodes = array();
		foreach ($objects as $object)
		{
			$item = $this->doc->createElement('item');
			$object_type_attr = $this->doc->createAttribute('objectTypeName');
			$object_type_value = $this->doc->createTextNode($object->objecttype->objecttypename);
			$object_type_attr->appendChild($object_type_value);
			$item->appendChild($object_type_attr);

			foreach ($this->get_object_fields_lattice_format($object) as $field)
			{
				$item->appendChild($field);
			}

			$nodes[] = $item;

			// and get the children
			$child_objects = $object->get_lattice_children();
			foreach ($this->export_tier_lattice_format($child_objects) as $child_item)
			{
				// create a completely flat export array
				$nodes[] = $child_item;
			}
		}

		return $nodes;
	}

	// this should call action_export and then convert with xslt
	public function action_lattice($outputfilename='export')
	{

		$this->export('Lattice_format', $outputfilename);

	} 

	public function action_xml($outputfilename='export')
	{

		$this->export('XMLFormat', $outputfilename);

	} 

	public function create_document(){
		$implementation = new DOMImplementation();
		$dtd = $implementation->createDocumentType('data',
			'-//WINTERROOT//DTD Data//EN',
			'../../../modules/lattice/lattice/data.dtd');
		$doc = $implementation->createDocument('', '', $dtd);
		return $doc;
	}

	public function write_document($doc){

		$doc->xml_version="1.0";
		$doc->encoding="UTF-8";
		$doc->formatOutput = true;
		$file_path = $this->output_dir . '/' . $this->document_number++ . '.xml';
		$doc->save($file_path);

	}


	public function export($format, $outputfilename)
	{

		$this->output_dir = 'application/export/' . $outputfilename . '/';

		try 
		{
			mkdir($this->output_dir, 777);
		} 
		catch ( Exception $e)
		{
			// if the folder already exists, just continue
		}

		//give permission to application/
		chmod(getcwd() . '/' . $this->output_dir, 0777);
		$files = glob($this->output_dir.'*.xml'); // get all xml file names
		foreach($files as $file){ // iterate files
			if(is_file($file))
				unlink($file); // delete file
		}

		//now copy object.xml to export
		$source_xml = APPPATH.'lattice/objects.xml';
		$destination_xml = $this->output_dir.'objects.xml';

		if (copy($source_xml, $destination_xml)) 
		{
			echo "copied $source_xml to $destination_xml <br />";
		}
		else
		{
			echo "failed to copy $source_xml to $destination_xml  <br />";
		}

		$XML = new DOMDocument();
		$this->implementation = new DOMImplementation();

		$this->dtd = $this->implementation->createDocumentType('data',
			'-//WINTERROOT//DTD Data//EN',
			'../../../modules/lattice/lattice/data.dtd');
		$object = Graph::get_root_node('cms_root_node');
		$objects = $object->get_lattice_children();

		$export_function = NULL;
		// XML Format Export is not now supported by this controller
		$export_function = 'export_tier_lattice_format';

		$this->doc = $this->create_document();
		$all_nodes = $this->$export_function($objects);

		$max_entries_per_document = 50;
		$count = count($all_nodes);
		$document_begun = false;
		$data = null;
		$nodes = null;
		$doc = null;
		for($i=0; $i<$count; $i++){
			if($i % $max_entries_per_document == 0){
				// start a new nodes document
				$doc = $this->create_document();
				$data = $doc->createElement('data');
				$nodes = $doc->createElement('nodes');
				$document_begun = true;
			}

			$node = $doc->importNode($all_nodes[$i], true);
			$nodes->appendChild($node);

			if($i % $max_entries_per_document == $max_entries_per_document - 1){
				// end the document and output

				$data->appendChild($nodes);
				$doc->appendChild($data);
				$this->write_document($doc);
				$document_begun = false;
			}
		}

		if($document_begun){
			// last document has not been closed / written
			$data->appendChild($nodes);
			$doc->appendChild($data);
			$this->write_document($doc);
			$document_begun = false;
		}

		// For now we will handles lattices as each a separate file
		// if this doesn't scale well, we can switch to chunking by lattice rather than by item count
		$lattices = Graph::lattices();
		foreach ($lattices as $lattice)
		{
			$doc = $this->create_document();
			$data = $doc->createElement('data');
			$relationships = $doc->createElement('relationships');

			$l = $doc->createElement('lattice');
			$name_attr = $doc->createAttribute('name');
			$name_value = $doc->createTextNode($lattice->name);
			$name_attr->appendChild($name_value);
			$l->appendChild($name_attr);

			if(count($lattice->get_relationships()) < 1){
				continue;
			}

			foreach ($lattice->get_relationships() as $relationship)
			{
				$r = $doc->createElement('relationship');
				$parent_slug = $doc->createTextNode(Graph::object($relationship->object_id)->slug);
				$parent = $doc->createAttribute('parent');
				$parent->appendChild($parent_slug);
				$child_slug = $doc->createTextNode(Graph::object($relationship->connectedobject_id)->slug);
				$child = $doc->createAttribute('child');
				$child->appendChild($child_slug);
				$r->appendChild($parent);
				$r->appendChild($child);
				$l->appendChild($r);
			}

			$relationships->appendChild($l);
			$data->appendChild($relationships);
			$doc->appendChild($data);
			$this->write_document($doc);
		}


		// Copy media last to avoid mysql timeout
		system('cp -Rp application/media/* ' . $this->output_dir);

		flush();
		ob_flush();

		//format file
		echo 'done with export..';

	}
	

}
