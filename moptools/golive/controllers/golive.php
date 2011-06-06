<?
/*
 * Class: GoLive_Controller
 * Copies all files and data between staging and production copies of the site,
 * when using the encapsulated mop staging environment
 */

class GoLive_Controller extends Controller {

	/*
	 * Function: copytolive()
	 * Copies all files and data between staging and production copies of the site,
	 * when using the encapsulated mop staging environment
	 */
	public function copytolive(){
		$cwd = getcwd();
		$livedb = Kohana::config('database.default.connection');
		$mediaDirectory = $cwd.'/application/media/';
		$backupMediaDirectory = $cwd.'/modules/golive/backup/';
		
		//remove all old media files
		$return = system('\rm -R '.$backupMediaDirectory.'*', $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error cleaning backup media dir');
		}
		//copy current live media to backup
		$return = system('cp -R '.$mediaDirectory.' '.$backupMediaDirectory, $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error copying live media to backup');
		}
		//clean out live media dir
		$return = system('\rm -R '.$mediaDirectory.'*', $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error cleaning out live media');
		}

		//copy all new media files
		$return = system('cp -R '.$cwd.'/staging/application/media/* '.$mediaDirectory, $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error copying new media files');
		}

		//dump this database to be imported
		$stagingdb = Kohana::config('database.staging.connection');
		$stagingconnect = ' -h '.$stagingdb['host'].' -u '.$stagingdb['user'].' -p'.$stagingdb['pass'].' '.$stagingdb['database'].' ';
		$return = system('mysqldump '.$stagingconnect.' > '.$backupMediaDirectory.'newdb.sql', $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error dumping staging database');
		}

		//dump database to backup
		$liveconnect = ' -h '.$livedb['host'].' -u '.$livedb['user'].' -p'.$livedb['pass'].' '.$livedb['database'].' ';
		$return = system('mysqldump '.$liveconnect.' > '.$backupMediaDirectory.'backup.sql', $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error backing up live database');
		}

		//delete everything from live database
		$return = system('mysql '.$liveconnect." -e \"show tables\" | grep -v Tables_in | grep -v \"+\" | \ gawk '{print \"drop table \" $1 \";\"}' | mysql ".$liveconnect , $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error cleaning out live database');
		}

		//add everything from new to live database
		$return = system('mysql '.$liveconnect.' < '.$backupMediaDirectory.'newdb.sql', $return_val);
		if($return===FALSE ){
			throw new Kohana_User_Exception('GOLIVE ERROR', 'error importing to live database');
		}

		//done
		return true;

	}
}
