Requirements

Kohana 3.1
ORM, Database, Auth, and Image modules


Install & Details

The file wiki.html contains the entire lattice wiki


Here is that file converted to Markdown.  Your mileage may vary...



[Source](https://raw.github.com/deepwinter/lattice/dev/wiki.html "Permalink to Lattice")

# Lattice

**Index by title**

* * *

The associator has 2 fundamental API calls, one to create an association and one to remove association. The parentId is the id of the master document, the objectId is the object id of the object being associated to the master document, and the $lattice argument is the name of the association itself (congruous with the notion of the associator's 'name').

  * associate($parentId, $objectId, $lattice) - associator/associate/{$parentId}/{$objectId}/$lattice
Returns html of the meta object view.
  * disassociate($parentId, $objectId, $lattice) - associator/dissociate/{$parentId}/{$objectId}/$lattice
  * filterPoolByWord($parentId, $lattice, $word) - associator/filterPoolByWord/$parentId/$lattice/$word

* * *

views/lattice/associator/specianame.php
and views/lattice/associator/specianame/item.php

* * *



* * *

[Defining Object Types][1]

[CMS Root Node][1]

[Custom CMS Views for Object Types][1]

[Associator Setup][1]

[CMS Modules][1]

* * *

Configuring the objectType in object.xml cmsRootNode allows you to determine what happens at the top level of the CMS nav.
(Root node addableObjects, components, and elements.


    
        
    


* * *

Custom views for object types can be created to change the order of display for object elements or customize the view.

## File Placement[¶][2]

The custom views should be placed in views/lattice/objectTypes/{objectTypeName}.php . Kohana's cascading file system will find them there.

## Echoing CMS UI elements in custom views[¶][3]

Use the syntax



    


### Lists
Use the syntax


    


## Other data provided to custom views[¶][4]

By default, custom views always have access to the follow variables

  * $object - the object being displayed
  * $objectId - the id of the object being displayed

* * *

## Defining Object Types[¶][5]

### objects.xml[¶][6]

{description of objects.xml}

### tags for each object type[¶][7]

#### Default Fields[¶][8]

All object types share a common set of fields, unless otherwise noted

##### DTD:


    


##### XML:


    


#### Associator[¶][9]

##### DTD:


    
    


##### XML:


    


##### DTD for Filters:


    
    


##### XML with Filters:


    
        
    


* * *

[Associator][1]

[Move Feature][1]

* * *

Lattice supports a robust mechanism for exporting and importing all data in the cms. This allows for an entire site architecture to be dumped and archived, and then re-imported at a later date.

## Exporting[¶][10]

Export in lattice import format (to be used to share data between lattice installs or back up):


    export/lattice/{exportName}


Export in standard xml format (for importing into other applications)


    export/xml/{exportName}


Exports are stored in application/export/{exportName} including all media from the site.

## Importing[¶][11]

Using the exportName above, run the import route. This assumes that the corresponding export is present in the application/export/ directory



    builder/initializeSite/{exportName}


WARNING: running this route will wipe the database of all lattice data - so run an export beforehand if you have anything valuable currently in lattice.

ALSO: if your import is very large (ie: if there are a lot of images) you may need to import via. the command line. Here is the command



    php index.php --uri=builder/initializeSite/march_3


There is a fragmentation issue with php so you may also need to increate the memory limit(memory_limit) in php.ini

## CSV Export/Import[¶][12]

Lattice also support exporting and importing of a CSV file.

The data in lattice can be exported using the following Kohana route:



    csv/export


Data can be imported using the following Kohana route:



    csv/import


* * *

Lattice contains a useful utility for configuring and auto-generating frontend views that can be styled and manipulated by designers. The basic idea is to provide a syntax for providing objects or sets of objects, and creating php views that echo that information. The frontend.xml implements a set of parameters allowing for filtering of data provided and echoed in frontend views.

## Generating Views[¶][13]

By default, running the view builder will generate the necessary php view files to display data for each objectType declared in objects.xml. You run the view builder using the following Kohana route:



    builder/frontend



This generates views and places the files in


    application/views/generated/



These files are overwritten every time the views are re-generated, and are not meant to be edited. To edit and create custom views, copy these files into


    application/views/frontend/



which takes precedence in the search path over application/views/generated/

## Writing frontend.xml to provide custom data to default views[¶][14]

  1. Each view is named to match the object type name defined in objects.xml:

          
      


  2. Custom data is added using the include data tag. The 'label' here is used to name the variable that contains this data in the generated view.

          
         
      


  3. and then apply a few filters to indicate which data should be loaded
    * objectTypeFilter="" can be used to select objects by their type
    * from="" can be used to select objects that are only children of a certain other object
      * from can be either the text "parent," describing a match against the slug that corresponds to the loading page
      * or from can be set to an existing slug in the current lattice database
      * a third option is to set from to "all" to grab all of the elements of that type in the whole site
***COMMON GOTCHA: make sure to set each label to a unique name, or none of the frontend definitions will be found

Examples:


      
         
      


or :


      
         
      


or (for example when a page with slug 'home' exists):


      
         
      


## Setting the default route (which view to load on your frontend site root)[¶][15]

Is currently done by editing application/boostrap.php or by naming your index objecttype 'homepage' (default value)



    Route::set('defaultLatticeFrontend', '()', array( 'controller'=&gt;'', ) )-&gt;defaults(array(
        'controller' =&gt; 'homepage',
        'action' =&gt; 'index',
    ));


* * *

( please rename is it still latticeViews )

* * *

## Dependencies:
You must have a basic Apache and PHP environment


    sudo apt-get install apache2 php5 libapache2-mod-php5 php5-curl


If you don't already have Kohana, follow these instructions:

1\. Clone Lattice-development into the root of your server or sub-folder in the root of your server if need be.



    git clone https://github.com/codebase/Lattice-Development.git


2\. Then run ant checkout



    cd Lattice-Development
    ant checkout



OR


    cd sub-folder/Lattice-Development
    ant checkout


3\. run ant init



    ant init


4\. edit the database settings in application/config/database.php (to match the database you'll be using)

5\. Check Lattice-Development/modules/lattice and if resources are missing, navigate to modules/lattice and run git submodule init and git submodule update to pull in all related resources



    cd modules/lattice
    git submodule init
    git submodule update


6\. access the cms at {WebRoot}/cms or 

7\. Lattice will report that it is not installed. Click install and keep track of the generated admin password.

You can now start using Lattice!

**\-------- Old installation instructions below --------------**

Lattice auto-configures itself one it finds the database, so there is no sql to import manually.

1\. Place a copy of a lattice site at your deployment or development location. For development you would probably git clone the Lattice-Development repository and then run the ant checkout script, while for deployment you would probably want to simply copy an existing build (stripped of all non-deployment files) into place at your development location.

2\. Ensure that the database settings in application/config/database.php are correct for your installation location, and then access the cms at {WebRoot}/cms

3\. Lattice will report that it is not installed, and offer a link for installation. Click this link, and make a note of the admin password. Lattice is now installed (unless you see errors).

4\. Start using lattice, unless you have an existing data export that you would like to use. In this case, use the importing details documented in the [Export/Import][1] page to do so.

### Re-initialization[¶][16]

The initializers can be re-run by deleting rows from the 'initialized_modules' table. If all else fails, deleting all lattice related tables (the whole database structure if nothing else is installed) will cause complete re-installation.

* * *

[PHP Memory Issues][1]

* * *

public function action_move($objectId, $newParentId, $lattice='lattice', $oldParentId=NULL)

The API is as such:
cms/move/$objectId/$newParentId

the 3rd and 4th arguments are optional, and only become meaningful when dealing with associator lattices or multiple parents within the same lattice.

* * *


    echo "" | php -d memory_limit=500M | grep memory_limit


## Dreamhost[¶][17]

Dreamhost has PHP5.3 installed at /usr/local/php53/bin/php . This is much much better.


    /usr/local/php53/bin/php -d memory_limit=500M -d max_execution_time=2000  index.php --uri=builder/initializeSite/3-14-12-FromCSV 2&gt; error.log


alias 'php=/usr/local/php53/bin/php'

* * *

hi

* * *

* * *

## Using Lattice[¶][18]

[Installation][1]

[CMS][1]

[Frontend][1]

[Export/Import][1]

[ Accessing objects in frontend templates][1]

[ Lost Paswords ][1]

[ Lattice Config File][1]

## Development Workflow and Infrastructure[¶][19]

[Dev Docs][1]

[Custom Controllers][1]

[Screen Shots][1]

[CI][1] (Continuous integration)

[Misc][1]

* * *

## Exporting Lattice Data[¶][20]

### API Commands[¶][21]

#### Lattice 3.0 Beta:[¶][22]

Export in lattice import format (to be used to share data between lattice installs or back up):

  * export/lattice/{exportName}

Export in standard xml format:

#### Lattice 3.0 Alpha:[¶][23]

Export in lattice import format (to be used to share data between lattice installs or back up):

  * exportxml/exportMOPFormat/{exportName}

* * *

* * *

latticeviews.php


    $config = array();
    $config['layoutsForObjectType']['recentMedia'] = 'nothing';
    $config['layoutsForObjectType']['designItem'] = 'nothing';
    $config['layoutsForObjectType']['designsForArtist'] = 'nothing';
    $config['layoutsForObjectType']['releasesForArtist'] = 'nothing';
    $config['layoutsForObjectType']['release'] = 'nothing';

    return $config;


* * *

If you've forgotten your password, and an email for recovery has not been set, follow these steps:

1\. open the Database
2\. open initializedmodules
3\. delete the latticeauth entry
4\. navigate to {webroot}/setup and a new admin password will be generated!

   [1]: https://raw.github.com#
   [2]: https://raw.github.com#File-Placement
   [3]: https://raw.github.com#Echoing-CMS-UI-elements-in-custom-views
   [4]: https://raw.github.com#Other-data-provided-to-custom-views
   [5]: https://raw.github.com#Defining-Object-Types
   [6]: https://raw.github.com#objectsxml
   [7]: https://raw.github.com#tags-for-each-object-type
   [8]: https://raw.github.com#Default-Fields
   [9]: https://raw.github.com#Associator
   [10]: https://raw.github.com#Exporting
   [11]: https://raw.github.com#Importing
   [12]: https://raw.github.com#CSV-ExportImport
   [13]: https://raw.github.com#Generating-Views
   [14]: https://raw.github.com#Writing-frontendxml-to-provide-custom-data-to-default-views
   [15]: https://raw.github.com#Setting-the-default-route-which-view-to-load-on-your-frontend-site-root
   [16]: https://raw.github.com#Re-initialization
   [17]: https://raw.github.com#Dreamhost
   [18]: https://raw.github.com#Using-Lattice
   [19]: https://raw.github.com#Development-Workflow-and-Infrastructure
   [20]: https://raw.github.com#Exporting-Lattice-Data
   [21]: https://raw.github.com#API-Commands
   [22]: https://raw.github.com#Lattice-30-Beta
   [23]: https://raw.github.com#Lattice-30-Alpha
  
