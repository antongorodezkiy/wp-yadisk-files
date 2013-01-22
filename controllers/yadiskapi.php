<?php if (!defined('WPINC')) die();

class YadiskAPI {
	
	protected $yadisk = null;
	private $login;
	private $pass;
	private $initErrors = array();
	
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
		
		global $notify;
		
		if (is_null($this->yadisk)) {
		 
			$this->yadisk = new Yadisk();
			$this->yadisk->set_server('ssl://webdav.yandex.ru');
			$this->yadisk->set_port(443);
			$this->yadisk->set_user($this->login);
			$this->yadisk->set_pass($this->pass);
			
			// use HTTP/1.1
			$this->yadisk->set_protocol(1);
			
			// enable debugging
			$this->yadisk->set_debug(false);
			
			if (!$this->yadisk->open()) {
				$this->initErrors[] = __('Error: could not open server connection','wp-yadisk-files');
			}
			
			// check if server supports webdav rfc 2518
			$this->yadisk->check_webdav();
			$options = $this->yadisk->options();
			if ($options['status']['status-code'] == '401') {
				$this->initErrors[] = __('Error: server does not support webdav or user/password may be wrong','wp-yadisk-files');
			}
			
		}
		

		if (!empty($this->initErrors)) {
			foreach($this->initErrors as $error) {
				$notify->error($error);
			}
		}
		
	}
	
	/*
	 * 
	 */
	function getList()
	{
		global $notify;

		$this->init();

		$path = urldecode($_POST['path']);
		
		$dir = $this->yadisk->ls($path);

		$folders = array();
		$files = array();
		if (!empty($dir)) {
			foreach ($dir as $key => $file) {
				
				if ($key == 0)
					continue;
				
				if (self::entryIsDir($file))
					$folders[] = array(
						'name' => $file['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'],
						'ext' => '',
						'href' => $file['href'],
						'size' => $file['getcontentlength']
					);
				else
					$files[] = array(
						'name' => $file['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'],
						'ext' => pathinfo($file['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'], PATHINFO_EXTENSION),
						'href' => $file['href'],
						'size' => formatBytes($file['getcontentlength'])
					);
			}
	
			$notify->setData(array('folders' => $folders, 'files' => $files));
		}
		// return final message to user
			if ($dir)
				$notify->returnSuccess(__('Success', 'wp-yadisk-files'));
			else
				$notify->returnError(__('Error listing ', 'wp-yadisk-files').' "'.$path.'"');
	}
	
	
	
	/*
	 * 
	 */
	function publish()
	{
		global $notify;

		$this->init();

		$path = urldecode($_POST['path']);
		
		$href = $this->yadisk->publish($path);

		$notify->setData(array('href' => $href));
		
		// return final message to user
			if ($href)
				$notify->returnSuccess(__('Success', 'wp-yadisk-files'));
			else
				$notify->returnError(__('Error publishing ', 'wp-yadisk-files').' "'.$path.'"');
	}
	
	
	/*
	 * 
	 */
	function unpublish()
	{
		global $notify;

		$this->init();

		$path = urldecode($_POST['path']);
		
		$href = $this->yadisk->post($path.'?unpublish');

		$notify->setData(array('folders' => $folders, 'files' => $files));
		
		// return final message to user
			if ($dir)
				$notify->returnSuccess(__('Success', 'wp-yadisk-files'));
			else
				$notify->returnError(__('Error publishing ', 'wp-yadisk-files').' "'.$path.'"');
	}
	
	
	public function getPopupTemplate() {
		global $notify;
		include_once(YADISK_FILES_APPPATH.'/views/popup.php');
		die();
	}

}


