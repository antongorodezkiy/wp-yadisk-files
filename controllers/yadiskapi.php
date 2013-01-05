<?php if (!defined('WPINC')) die();

class YadiskAPI {
	
	protected $yadisk = null;
	private $login;
	private $pass;
	
	public function __construct($login, $pass) {
		
		if (!class_exists('webdav_client')) {
			require(YADISK_FILES_APPPATH.'/libraries/class_webdav_client.php');
		}
		
		if (!class_exists('yadisk')) {
			require(YADISK_FILES_APPPATH.'/libraries/yadisk.class.php');
		}
		
		$this->login = $login;
		$this->pass = $pass;
	}
	
	
	protected static function entryIsDir($entry) {
		return ( isset($entry['resourcetype']) && $entry['resourcetype'] == 'collection' );
	}
	
	
	public function init() {
		 
		$this->yadisk = new Yadisk();
		$this->yadisk->set_server('ssl://webdav.yandex.ru');
		$this->yadisk->set_port(443);
		$this->yadisk->set_user($this->login);
		$this->yadisk->set_pass($this->pass);
		
		// use HTTP/1.1
		$this->yadisk->set_protocol(1);
		
		// enable debugging
		$this->yadisk->set_debug(true);
		
		if (!$this->yadisk->open())
			$notify->returnError('Error: could not open server connection');
		
		// check if server supports webdav rfc 2518
		if (!$this->yadisk->check_webdav())
			$notify->returnError('Error: server does not support webdav or user/password may be wrong');
		
		
	}
	
	/*
	 * 
	 */
	function getList()
	{
		global $notify;

		if (is_null($this->yadisk))
			$this->init();

		$path = urldecode($_POST['path']);
		
		$dir = $this->yadisk->ls($path);

		$folders = array();
		$files = array();
		foreach ($dir as $key => $file) {
			
			if ($key == 0)
				continue;
			
			if (self::entryIsDir($file))
				$folders[] = array(
					'name' => $file['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'],
					'href' => $file['href'],
					'size' => $file['getcontentlength']
				);
			else
				$files[] = array(
					'name' => $file['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'],
					'href' => $file['href'],
					'size' => formatBytes($file['getcontentlength'])
				);
		}

		$notify->setData(array('folders' => $folders, 'files' => $files));
		
		// return final message to user
			if ($dir)
				$notify->returnSuccess(__('Success', 'yadisk-files'));
			else
				$notify->returnError(__('Error listing '.$path, 'yadisk-files'));
	}
	
	
	
	/*
	 * 
	 */
	function publish()
	{
		global $notify;

		if (is_null($this->yadisk))
			$this->init();

		$path = urldecode($_POST['path']);
		
		$href = $this->yadisk->publish($path);

		$notify->setData(array('href' => $href));
		
		// return final message to user
			if ($href)
				$notify->returnSuccess(__('Success', 'yadisk-files'));
			else
				$notify->returnError(__('Error publishing '.$path, 'yadisk-files'));
	}
	
	
	/*
	 * 
	 */
	function unpublish()
	{
		global $notify;

		if (is_null($this->yadisk))
			$this->init();

		$path = urldecode($_POST['path']);
		
		$href = $this->yadisk->post($path.'?unpublish');

		$notify->setData(array('folders' => $folders, 'files' => $files));
		
		// return final message to user
			if ($dir)
				$notify->returnSuccess(__('Success', 'yadisk-files'));
			else
				$notify->returnError(__('Error publishing '.$path, 'yadisk-files'));
	}

}


