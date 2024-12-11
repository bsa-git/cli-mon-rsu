<?
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
define(CRLF, "\r\n"); 
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Header
// purpose: represents an http header string ie. "<name>: <value>"
///////////////////////////////////////////////////////////////////////////////
class HTTP_Header
{
	var $m_name;
	var $m_value;
	var $m_header;

	///////////////////////////////////////////////////////////////////////////
	//	Constructor
	//	input: fieldName - name of the header eg. 'Referer'
	//	input: filedValue - value of the header eg. 'localhost'
	function HTTP_Header($fieldName, $fieldValue)
	{
		$this->m_name = $fieldName;
		$this->m_value = $fieldValue;
		$this->m_header = $fieldName.": ".$fieldValue;
	}	
	///////////////////////////////////////////////////////////////////////////
	// purpose: get the entire header line
	// return: header string without crlf
	function Get()
	{
		return $this->m_header;	
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: get just the value of the header
	// return: string value of header
	function GetValue()
	{	
		return $this->m_value;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: get just the name of the header
	// return: string name of header
	function GetName()
	{
		return $this->m_name;
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Message 
// purpose: represents a http message
///////////////////////////////////////////////////////////////////////////////
class HTTP_Message
{
	var $m_headers;
	var $m_entityBody;

	///////////////////////////////////////////////////////////////////////////
	// Constructor
	// input: HTTP_Headers - array of header objs to use with this message
	// input: entityBody - an entity body 
	function HTTP_Message($HTTP_Headers, $entityBody="")
	{		
		$this->m_headers = array();		
		$this->SetHeaders($HTTP_Headers);
		$this->m_entityBody = $entityBody;		
	}	
	///////////////////////////////////////////////////////////////////////////
	// purpose: append header objs to this message
	// input: array of header objs
	function SetHeaders($HTTP_Headers)
	{
		if (is_array($HTTP_Headers))
		{
			while(list(,$HTTP_Header) = each($HTTP_Headers))
			{
				$this->m_headers[]= $HTTP_Header;
			}	
		}		
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: append a single header obj
	// input: a header obj
	function SetHeader($HTTP_Header)
	{
		$this->m_headers[]= $HTTP_Header;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the first header obj found based on its name 
	// return: header obj
	function GetHeader($fieldName)
	{
		if (is_array($this->m_headers))
		{
			while(list(,$HTTP_Header) = each($this->m_headers))			
			{
				if ($HTTP_Header->GetName() == $fieldName)
					return $HTTP_Header;
			}		
		}		
		return 0;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return array of header objs for this message
	// return: array of header objs
	function GetHeaders()
	{		
		return $this->m_headers;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the entity body
	// return: entity body string
	function GetEntityBody()
	{
		return $this->m_entityBody;
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Request extends HTTP_Message
// purpose: represents a http request to send to the server.Care must be taken 
//			with uri for use with proxy server
///////////////////////////////////////////////////////////////////////////////
class HTTP_Request extends HTTP_Message
{	
	var $m_method;
	var $m_uri;
	var $m_version;
	
	///////////////////////////////////////////////////////////////////////////
	// Constructor:
	// input: method - the method for this request
	// input: uri - the URI for this request
	// input: version - the HTTP verison for this request
	// input: HTTP_Headers - array of header objs
	// input: entityBody - entity body this request
	function HTTP_Request($method, $uri, $version, $HTTP_Headers, $entityBody="")
	{			
		$this->HTTP_Message($HTTP_Headers, $entityBody);
		$this->m_version = $version;
		$this->m_method = $method;
		$this->m_uri = $uri;
	}	
	///////////////////////////////////////////////////////////////////////////
	// purpose: returns the method
	// return: method string
	function GetMethod()
	{
		return $this->m_method;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: returns request uri
	// return: uri string
	function GetURI()
	{
		return $this->m_uri;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the http version
	// return: http version string
	function GetVersion()
	{
		return $this->m_version;
	} 
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Response extends HTTP_Message
// purpose: represents a http response message read from the server
///////////////////////////////////////////////////////////////////////////////
class HTTP_Response extends HTTP_Message
{
	var $m_version;
	var $m_statusCode;
	var $m_phrase;
	
	///////////////////////////////////////////////////////////////////////////
	// Constructor
	// input: version - http version 
	// input: statusCode - statusCode
	// input: phrase - phrase
	// input: headers - array of header objs
	// input: entityBody - entity body
	function HTTP_Response($version , $statusCode, $phrase, $HTTP_Headers="", $entityBody="")
	{
		$this->HTTP_Message($HTTP_Headers, $entityBody);
		$this->m_version = $version;
		$this->m_statusCode = $statusCode;
		$this->m_phrase = $phrase;
	}		
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the http version
	// return: http version string
	function GetVersion()
	{
		return $this->m_version;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the status code
	// return: status code string
	function GetStatusCode()
	{
		return $this->m_statusCode;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: return the phrase
	// return: phrase string
	function GetPhrase()
	{
		return $this->m_phrase;
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Connection 
// purpose: represents a http connection to the http server 
// 			use to send and read http messages from server
///////////////////////////////////////////////////////////////////////////////	
class HTTP_Connection
{
	var $m_host;
	var $m_port;
	var $m_timeout;
	var $m_fp;
	var $m_debug = false; // set true to print debug messages

	///////////////////////////////////////////////////////////////////////////
	// Constructor
	// input: host - host name to connect (ip or domain name) 
	// input: port - port to use on host for http
	// input: timeout - timeout for connection
	function HTTP_Connection($host, $port=80, $timeOut=30)
	{
		$this->m_host = $host;
		$this->m_port = $port;
		$this->m_timeOut = $timeOut;
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: connect to the host in constructor
	function Connect()
	{	
		//
		// open up the socket to host
		$this->m_fp = fsockopen($this->m_host, $this->m_port, &$errno, &$errstr, $this->m_timeOut);	
		if (!$this->m_fp)
			die("Error: Connect: ${errstr} (${errno})");			
		
		if ($this->m_debug)
			echo "DEBUG: opening connection<br>";
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: close the connection to the host
	function Close()
	{
		if ($this->m_debug)
			echo "DEBUG: closing connection<br>";
		fclose($this->m_fp);
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: send a http request to the host/port in constructor
	// input: HTTP_Request - request obj
	function Request($HTTP_Request)
	{
		// 
		// write request line
		
		if ($this->m_debug) 
				echo "DEBUG: sending request line: ".$HTTP_Request->GetMethod()." ".$HTTP_Request->GetURI()." ".$HTTP_Request->GetVersion()."<br>";
				
		fwrite($this->m_fp, $HTTP_Request->GetMethod()." ".$HTTP_Request->GetURI()." ".$HTTP_Request->GetVersion().CRLF);
		
		//
		// write headers
		$HTTP_Headers = $HTTP_Request->GetHeaders();				
		while(list(,$HTTP_Header) = each($HTTP_Headers))
		{			
			if ($this->m_debug) 
				echo "DEBUG: sending header: ", $HTTP_Header->Get()."<br>";
				
			fwrite($this->m_fp, $HTTP_Header->Get()."\n");
		}
		//
		// write entity body
		$body = $HTTP_Request->GetEntityBody();		
		if (!empty($body))
		{	
			$HTTP_Header = $HTTP_Request->GetHeader("Content-Length");					
			if ($this->m_debug) 
				echo "DEBUG: sending entity body length: ", ($HTTP_Header->GetValue()? $HTTP_Header->GetValue() : "unknown")."<br>";				
			
			fwrite($this->m_fp, CRLF);
			fwrite($this->m_fp, $body, $HTTP_Header->GetValue());
			fwrite($this->m_fp, CRLF);
		}
		fwrite($this->m_fp, CRLF);
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: read a http response from the host
	// output: HTTP_Response - creates a response obj
	function Response(&$HTTP_Response)
	{		
		//
		// read status line				
		$statusLine = fgets($this->m_fp, 1024);
				
		if ($this->m_debug) 
			"DEBUG: read status line: ".$statusLine;
			
		$this->_SplitResponseLine($statusLine, $version, $statusCode, $phrase);		
		
		//
		// read in headers		
		$HTTP_Headers = array();
		while(!feof($this->m_fp))
		{
			$line = fgets($this->m_fp, 1024);			
									
			if ($line == CRLF)
				break;

			$this->_SplitHeader($line, $fieldName, $fieldValue);		
			
			if ($this->m_debug)
				echo "DEBUG: read header: ".$fieldName.": ".$fieldValue."<br>";
				
			if ($fieldName == "Content-Length")
				$len = $fieldValue;
				
			$HTTP_Headers[] = new HTTP_Header($fieldName, $fieldValue);			
		}
		
		if ($this->m_debug)
			echo "DEBUG: reading entity body - length: ", ($len ? $len : "unknown"), "<br>";
			
		//
		// read in entity body (if there is one)					
		if (!$len)
			$len = 1024;		
			
		while(!feof($this->m_fp))
		{
			$body .= fread($this->m_fp, $len);			
		}
		
		//
		// create the response		
		$HTTP_Response = new HTTP_Response($version, $statusCode, $phrase, $HTTP_Headers, $body);						
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: splits up a header into its different parts
	function _SplitHeader($header, &$fieldName, &$fieldValue)
	{
		$header = str_replace(CRLF, "", $header);		
		$pos = strpos($header, ':');
		
		$fieldName = substr($header, 0, $pos);		
		$fieldValue = substr($header, $pos+2);
	}
	///////////////////////////////////////////////////////////////////////////
	// purpose: splits up a response line into its different parts
	function _SplitResponseLine($line, &$version, &$statusCode, &$phrase)
	{
		$line = str_replace(CRLF, "", $line); 		
		$regs = split("[[:space:]]+", $line, 3);
						
		$version = $regs[0];
		$statusCode = $regs[1];
		$phrase = $regs[2]; 
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_Cookie_Header extends HTTP_Header
// purpose: represents a http cookie header
///////////////////////////////////////////////////////////////////////////////	
class HTTP_Cookie_Header extends HTTP_Header
{
	///////////////////////////////////////////////////////////////////////////
	// constructor: 
	// input: hash containing keys=>values to be stored in this cookie
	function HTTP_Cookie_Header($values)
	{
		while(list($k, $v) = each($values))
			$encValues .= $k."=".urlencode($v).";";			
		$this->HTTP_Header("Cookie", $encValues);
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_BasicAuth_Header extends HTTP_Header
// purpose: represents a http basic auth header
///////////////////////////////////////////////////////////////////////////////	
class HTTP_BasicAuth_Header extends HTTP_Header
{
	///////////////////////////////////////////////////////////////////////////
	// constructor: 
	// input: username - username for auth
	// input: password - password for auth
	function HTTP_BasicAuth_Header($username, $password)
	{
		$this->HTTP_Header("Authorization", 
			"BASIC ".base64_encode($username.":".$password));
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_GET_Request extends HTTP_Request
// purpose: represents a http GET request
///////////////////////////////////////////////////////////////////////////////	
class HTTP_GET_Request extends HTTP_Request
{
	///////////////////////////////////////////////////////////////////////////
	// constructor: 
	// input: uri - uri to get
	// input: HTTP_Headers - array of header objs for this request
	function HTTP_GET_Request($uri, $HTTP_Headers=0)
	{
		$this->HTTP_Request("GET", $uri, "HTTP/1.0", $HTTP_Headers);
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_HEAD_Request extends HTTP_Request
// purpose: represents a http HEAD request
///////////////////////////////////////////////////////////////////////////////	
class HTTP_HEAD_Request extends HTTP_Request
{
	///////////////////////////////////////////////////////////////////////////
	// constructor: 
	// input: uri - uri to get headers for
	// input: HTTP_Headers - array of header objs for this request
	function HTTP_HEAD_Request($uri, $HTTP_Headers=0)
	{
		$this->HTTP_Request("HEAD", $uri, "HTTP/1.0", $HTTP_Headers);
	}
};
///////////////////////////////////////////////////////////////////////////////
// class: HTTP_POST_Request extends HTTP_Request
// purpose: represent a POST http request.Headers (Content-Type,Content-Length)
//			and entityBody sent for you
///////////////////////////////////////////////////////////////////////////////	
class HTTP_POST_Request extends HTTP_Request
{
	///////////////////////////////////////////////////////////////////////////
	// constructor: 
	// input: uri - uri to post to
	// input: postValues - hash of unencoded post values to use
	// input: HTTP_Headers - array of header objs for this request	
	function HTTP_POST_Request($uri, $postValues, $HTTP_Headers)
	{
		while(list($key,$val) = each($postValues))
			$queryString .= urlencode($key)."=".urlencode($val)."&";
			
		$HTTP_Headers[] = new HTTP_Header("Content-Type", "application/x-www-form-urlencoded");	
		$HTTP_Headers[] = new HTTP_Header("Content-Length", strlen($queryString));
		
		$this->HTTP_Request("POST", $uri, "HTTP/1.0", $HTTP_Headers, $queryString);		
	}
};
?>