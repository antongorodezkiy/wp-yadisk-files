<?php


class Yadisk extends webdav_client {

	/**
	* Public method get
	*
	* Gets a file from a webdav collection.
	* @param string path, string &buffer 
	* @return status code and &$buffer (by reference) with response data from server on success. False on error. 
	*/
	function publish($path) {
		$this->_path = $this->_translate_uri($path).'?publish';
		$this->_header_unset();
		$this->_create_basic_request('POST');
		$this->_send_request();
		$this->_get_respond();
		$response = $this->_process_respond();
		
		// validate the response
		// check http-version
		if ($response['status']['http-version'] == 'HTTP/1.1' ||
			 $response['status']['http-version'] == 'HTTP/1.0') {
			// seems to be http ... proceed
			// We expect a 302 code
			if ($response['status']['status-code'] == 302 ) {
				return $response['header']['Location'];
			}
		 }
		 // ups: no http status was returned ?
		 return false;
	}

}
