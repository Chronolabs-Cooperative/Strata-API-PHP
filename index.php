<?php
/**
 * Chronolabs REST API File
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Cooperative http://labs.coop
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         whois
 * @since           1.1.2
 * @author          Simon Roberts <meshy@labs.coop>
 * @version         $Id: help.php 1000 2013-06-07 01:20:22Z mynamesnot $
 * @subpackage		api
 * @description		Whois API Service REST
 */

	$parts = explode(".", microtime(true));
	mt_srand(mt_rand(-microtime(true), microtime(true))/$parts[1]);
	mt_srand(mt_rand(-microtime(true), microtime(true))/$parts[1]);
	mt_srand(mt_rand(-microtime(true), microtime(true))/$parts[1]);
	mt_srand(mt_rand(-microtime(true), microtime(true))/$parts[1]);
	$salter = ((float)(mt_rand(0,1)==1?'':'-').$parts[1].'.'.$parts[0]) / sqrt((float)$parts[1].'.'.intval(cosh($parts[0])))*tanh($parts[1]) * mt_rand(1, intval($parts[0] / $parts[1]));
	header('Blowfish-salt: '. $salter);
	
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'apiconfig.php';
	
	
	/**
	 * URI Path Finding of API URL Source Locality
	 * @var unknown_type
	 */
	$odds = $inner = array();
	foreach($_GET as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	foreach($_POST as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	foreach(parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'], '?')?'&':'?').$_SERVER['QUERY_STRING'], PHP_URL_QUERY) as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	$help=false;
	if (!isset($inner['mode']) || empty($inner['mode'])) {
		$help=true;
	} elseif (isset($inner['output']) || !empty($inner['output']) && in_array(trim($inner['mode']), array('strata', 'fallout'))) {
		$mode = trim($inner['mode']);
		$output = trim($inner['output']);
		$length = (isset($inner['length'])?trim($inner['length']):null);
		$start = (isset($inner['start'])?trim($inner['start']):null);
	} else {
		$help=true;
	}
	
	/**
	 * Buffers Help
	 */
	if ($help==true) {
		if (function_exists("http_response_code"))
			http_response_code(400);
		include dirname(__FILE__).'/help.php';
		exit;
	}
	
	/**
	 * Calculates Whitelist
	 */
	if (function_exists('whitelistGetIP') && function_exists('whitelistGetIPAddy') && defined('MAXIMUM_QUERIES'))
	{
		session_start();
		if (!in_array(whitelistGetIP(true), whitelistGetIPAddy())) {
			if (isset($_SESSION['reset']) && $_SESSION['reset']<microtime(true))
				$_SESSION['hits'] = 0;
			if ($_SESSION['hits']<=MAXIMUM_QUERIES) {
				if (!isset($_SESSION['hits']) || $_SESSION['hits'] = 0)
					$_SESSION['reset'] = microtime(true) + 3600;
				$_SESSION['hits']++;
			} else {
				header("HTTP/1.0 404 Not Found");
				if (function_exists("http_response_code"))
					http_response_code(404);
				exit;
			}
		}
	}
	
	/**
	 * Commences Execution of API Functions
	 */
	if (function_exists("http_response_code"))
		http_response_code(201);
		
	switch ($mode)
	{
		case "strata":
			$data = newakeGetStrata($length, $start);
			break;
		case "fallout":
			$data = newakeGetFallout();
			break;
	}
	
	switch ($output) {
		default:
			echo '<pre style="font-family: \'Courier New\', Courier, Terminal; font-size: 0.77em;">';
			echo implode(" ", $data);
			echo '</pre>';
			break;
		case 'raw':
		    header('Content-type: application/x-httpd-php');
		    echo "<?php\n\n return " . var_export($data, true) . ";\n\n?>";
		    break;
		case 'json':
			header('Content-type: application/json');
			echo json_encode($data);
			break;
		case 'serial':
			header('Content-type: text/html');
			echo serialize($data);
			break;
		case 'xml':
			header('Content-type: application/xml');
			$dom = new XmlDomConstruct('1.0', 'utf-8');
			$dom->fromMixed(array($mode=>$data));
 			echo $dom->saveXML();
			break;
	}
	exit(0);
?>