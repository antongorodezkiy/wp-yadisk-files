<?php if (!defined('WPINC')) die();

class YadiskAPI {
	
	protected $yadisk = null;
	private $login;
	private $pass;
	private $initErrors = array();
	protected $base_uri = 'ssl://webdav.yandex.ru';
	
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
	
	protected function build_transparent_url($path) {
		return '/index.php?'.YADISK_FILES_PLUGIN.'=1&action=download&filename='.$path.'&path_hash='.md5($path);
	}
	
	protected static function entryIsDir($entry) {
		return ( isset($entry['resourcetype']) && $entry['resourcetype'] == 'collection' );
	}
	
	
	public function init() {
		
		global $notify;
		
		if (is_null($this->yadisk)) {
		 
			$this->yadisk = new Yadisk();
			$this->yadisk->set_server($this->base_uri);
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
	 * Get directory listing
	 */
	public function getList() {
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
	 * Publish
	 */
	public function publish() {
		global $notify;

		$this->init();

		$path = urldecode($_POST['path']);
		
		$href = $this->yadisk->publish($path);
		
		if (get_option('wp-yadisk-files-transparent-mode')) {
			$href = get_site_url() . $this->build_transparent_url($path);
		}

		$notify->setData(array(
			'href' => $href,
			'path_hash' => md5($path)
		));
		
		// return final message to user
			if ($href)
				$notify->returnSuccess(__('Success', 'wp-yadisk-files'));
			else
				$notify->returnError(__('Error publishing ', 'wp-yadisk-files').' "'.$path.'"');
	}
	

	
	
	/*
	 * Upload
	 */
	public function upload() {
		global $notify;
		
		$error_messages = array(
			1 => __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'wp-yadisk-files'),
			2 => __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'wp-yadisk-files'),
			3 => __('The uploaded file was only partially uploaded', 'wp-yadisk-files'),
			4 => __('No file was uploaded', 'wp-yadisk-files'),
			6 => __('Missing a temporary folder', 'wp-yadisk-files'),
			7 => __('Failed to write file to disk', 'wp-yadisk-files'),
			8 => __('A PHP extension stopped the file upload', 'wp-yadisk-files')
		);

		$this->init();

		$target_dir_path = strip_tags(urldecode($_POST['path']));
		
		if ($_FILES['yadisk_file']['error']) {
			$notify->returnError(__('Error uploading validation', 'wp-yadisk-files').': '.$error_messages[$_FILES['yadisk_file']['error']]);
		}
		
		if (!$_FILES['yadisk_file']['size']) {
			$notify->returnError(__('Error uploading validation', 'wp-yadisk-files').': '. __('File is empty', 'wp-yadisk-files'));
		}
		
		$filename = strip_tags($_FILES['yadisk_file']['name']);
		$path = $target_dir_path.'/'.$filename;
	
		$uploaded = $this->yadisk->put_file($path, $_FILES['yadisk_file']['tmp_name']);
		
		if ($uploaded) {

			$notify->setData(array('path' => $path));
			
			$notify->returnSuccess(__('Success', 'wp-yadisk-files'));
		}
		else {
			$notify->returnError(__('Error uploading ', 'wp-yadisk-files').' "'.$path.'"');
		}
		
	}
	
	public function download() {
		$this->init();
		
		$srcpath = urldecode($_REQUEST['filename']);
		
		if (!$this->yadisk->isPublished($srcpath)) {
			status_header(404);
			nocache_headers();
			include( get_404_template() );
			exit;
		}
		
		$temp_file = tempnam("/tmp", "wp-yadisk-files");
		$this->yadisk->get_file($srcpath, $temp_file);
		ci_force_download(pathinfo($srcpath, PATHINFO_BASENAME), $temp_file);
	}
	
	public function getPopupTemplate() {
		global $notify;
		include_once(YADISK_FILES_APPPATH.'/views/popup.php');
		die();
	}

}


