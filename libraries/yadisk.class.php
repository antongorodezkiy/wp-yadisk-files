<?php


class Yadisk extends webdav_client {

	/**
	* Publish file
	*/
	/*public function publish($path) {
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
	}*/
	
	public function publish($path) {
		$this->_path = $this->_translate_uri($path);

		$this->_header_unset();
		$this->_create_basic_request('PROPPATCH');
		$this->_header_add('Depth: 0');
		$this->_header_add('Content-type: text/xml');
		// create profind xml request...
		
		$xml .= "<propertyupdate xmlns=\"DAV:\">\r\n";
		$xml .= "  <set>\r\n";
		$xml .= "    <prop>\r\n";
		$xml .= "    	<public_url xmlns=\"urn:yandex:disk:meta\">true</public_url>\r\n";
		$xml .= "    </prop>\r\n";
		$xml .= "  </set>\r\n";
		$xml .= "</propertyupdate>\r\n";
		$this->_header_add('Content-length: ' . strlen($xml));
		$this->_send_request();
		$this->_error_log($xml);
		fputs($this->_fp, $xml);
		$this->_get_respond();
		$response = $this->_process_respond();
		
		$this->_parser = xml_parser_create_ns();
		// forget old data...
		unset($this->_xmltree[$this->_parser]);
		unset($this->_ls[$this->_parser]);
		xml_parser_set_option($this->_parser,XML_OPTION_SKIP_WHITE,0);
		xml_parser_set_option($this->_parser,XML_OPTION_CASE_FOLDING,0);
		xml_set_object($this->_parser, $this);
		xml_set_element_handler($this->_parser, "_propfind_startElement", "_endElement");
		xml_set_character_data_handler($this->_parser, "_propfind_cdata");


		if (!xml_parse($this->_parser, $response['body'])) {
			die(sprintf("XML error: %s at line %d",
									 xml_error_string(xml_get_error_code($this->_parser)),
									 xml_get_current_line_number($this->_parser)));
		}

		// Free resources
		xml_parser_free($this->_parser);
		
		return isset($this->_ls_ref['dav::multistatus_dav::response_dav::propstat_dav::prop_urn:yandex:disk:meta:public_url_']) ? $this->_ls_ref['dav::multistatus_dav::response_dav::propstat_dav::prop_urn:yandex:disk:meta:public_url_'] : false;
	}
	
	/**
	* Is file published
	*/
	public function isPublished($path) {
		$this->_path = $this->_translate_uri($path);

		$this->_header_unset();
		$this->_create_basic_request('PROPFIND');
		$this->_header_add('Depth: 0');
		$this->_header_add('Content-type: text/xml');
		// create profind xml request...
		
		$xml .= '<propfind xmlns="DAV:">';
		
		$xml .= '    <prop>';
		$xml .= '    	<public_url xmlns="urn:yandex:disk:meta"/>';
		$xml .= '    </prop>';
		
		$xml .= '</propfind>';
		$this->_header_add('Content-length: ' . strlen($xml));
		$this->_send_request();
		$this->_error_log($xml);
		fputs($this->_fp, $xml);
		$this->_get_respond();
		$response = $this->_process_respond();
		
		$this->_parser = xml_parser_create_ns();
		// forget old data...
		unset($this->_xmltree[$this->_parser]);
		unset($this->_ls[$this->_parser]);
		xml_parser_set_option($this->_parser,XML_OPTION_SKIP_WHITE,0);
		xml_parser_set_option($this->_parser,XML_OPTION_CASE_FOLDING,0);
		xml_set_object($this->_parser, $this);
		xml_set_element_handler($this->_parser, "_propfind_startElement", "_endElement");
		xml_set_character_data_handler($this->_parser, "_propfind_cdata");


		if (!xml_parse($this->_parser, $response['body'])) {
			die(sprintf("XML error: %s at line %d",
									 xml_error_string(xml_get_error_code($this->_parser)),
									 xml_get_current_line_number($this->_parser)));
		}

		// Free resources
		xml_parser_free($this->_parser);
		
		$this->_connection_closed = true;
		
		return stristr($this->_ls_ref['status'],'200');
	}

}
