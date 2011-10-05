<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Lms_post_api extends Module {

	public $version = '1.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'LMS Post API'
			),
			'description' => array(
				'en' => 'LMS Post API'
			),
			'frontend' => TRUE,
			'backend' => FALSE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		// Do nothing upon installation
		return true;
	}

	public function uninstall()
	{
		// Do nothing upon un-installation
		return true;
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>The LMS Post API module will work like magic. The End!</p>";
	}
}
/* End of file details.php */