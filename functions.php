<?php
/**
 * Chronolabs REST Internet Strata & Fallout API
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
 * @package         strata
 * @since           1.0.3
 * @author          Simon Roberts <wishcraft@users.sourceforge.net>
 * @version         $Id: functions.php 1000 2013-06-07 01:20:22Z wishcraft $
 * @subpackage		api
 * @description		Internet Strata & Fallout API Service
 * @link			Chronolabs API's http://sourceforge.net/projects/chronolabsapis
 * @link			Chronolabs Cooperative http://sourceforge.net/projects/chronolabs
 */

if (!class_exists("XmlDomConstruct")) {
	/**
	 * class XmlDomConstruct
	 * 
	 * 	Extends the DOMDocument to implement personal (utility) methods.
	 *
	 * @author 		Simon Roberts (Chronolabs) wishcraft@users.sourceforge.net
	 */
	class XmlDomConstruct extends DOMDocument {
	
		/**
		 * Constructs elements and texts from an array or string.
		 * The array can contain an element's name in the index part
		 * and an element's text in the value part.
		 *
		 * It can also creates an xml with the same element tagName on the same
		 * level.
		 *
		 * ex:
		 * <nodes>
		 *   <node>text</node>
		 *   <node>
		 *     <field>hello</field>
		 *     <field>world</field>
		 *   </node>
		 * </nodes>
		 *
		 * Array should then look like:
		 *
		 * Array (
		 *   "nodes" => Array (
		 *     "node" => Array (
		 *       0 => "text"
		 *       1 => Array (
		 *         "field" => Array (
		 *           0 => "hello"
		 *           1 => "world"
		 *         )
		 *       )
		 *     )
		 *   )
		 * )
		 *
		 * @param mixed $mixed An array or string.
		 *
		 * @param DOMElement[optional] $domElement Then element
		 * from where the array will be construct to.
		 * 
		 * @author 		Simon Roberts (Chronolabs) wishcraft@users.sourceforge.net
		 *
		 */
		public function fromMixed($mixed, DOMElement $domElement = null) {
	
			$domElement = is_null($domElement) ? $this : $domElement;
	
			if (is_array($mixed)) {
				foreach( $mixed as $index => $mixedElement ) {
	
					if ( is_int($index) ) {
						if ( $index == 0 ) {
							$node = $domElement;
						} else {
							$node = $this->createElement($domElement->tagName);
							$domElement->parentNode->appendChild($node);
						}
					}
					 
					else {
						$node = $this->createElement($index);
						$domElement->appendChild($node);
					}
					 
					$this->fromMixed($mixedElement, $node);
					 
				}
			} else {
				$domElement->appendChild($this->createTextNode($mixed));
			}
			 
		}
		 
	}
}

if (!function_exists("newakeGetFallout")) {

	/**
	 * Returns the Internet Regional Fallout placements
	 *
	 * @return array
	 */
	function newakeGetFallout() 
	{
		$return = array("ISO2", "FIPS104", "ISO3", "ISON", "TLD", "CurrencyCode");
		$fallouts = simplexml_load_file(__DIR__ . DIRECTORY_SEPARATOR . "fallout.---");
		$result = array();
		foreach($fallouts as $line => $fallout)
		{
			if (!empty($fallout->TLD))
			{
				$row = array();
				foreach ($fallout as $key => $value)
					if (in_array($key, $return))
						$row[strtolower($key)] = $fallout->$key;
				$row['key'] = sha1(json_encode($row));
				$result[str_replace('.', '', $row['tld'])] = $row;
			}
		}
		return $result;
	}
}

if (!function_exists("newakeGetStrata")) 
{

	/**
	 * Returns Realms, TLD, gTLD, Domains and Networking Topology Data Set
	 * 
	 * @param integer $length Only return with length set all or when set to zero
	 * @param string $start Only return network strata beginning with or any empty()
	 * @return array
	 */
	function newakeGetStrata($length = null, $start = null) 
	{
		$return = array("key", "node");
		$toplogy = "";
		$results = array();
		if (@filemtime(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json") + 3600 * 1.21 <= time() )
		{
			chmod(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json", 0777);
			unlink(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json");
		}
		if (@filesize(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json")<=2048)
		{
			chmod(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json", 0777);
			unlink(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json");
		}
		
		if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json"))
		{
			$results = array();
			foreach(file("http://data.iana.org/TLD/tlds-alpha-by-domain.txt") as $pointer)
			{
				$topology = str_replace(array('.', '-', '_'), '', $realm = trim(strtolower($pointer)));
				if (!strpos(' '.$topology,"#")  && !empty($topology))
				{
					$row = array();
					$row["node"] = ".".$realm;
					$row['key'] = sha1($toplogy);
					$results[$topology] = $row;
				}
			}
		
			$io = fopen(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json", "w+");
			fwrite($io, $json = json_encode($results), strlen($json));
			fclose($io);
			
		} else {
			if (!$results = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json"), true))
			{
				chmod(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json", 0777);
				unlink(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json");
				if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json")) 
				{
					$results = array();
					foreach(file("http://data.iana.org/TLD/tlds-alpha-by-domain.txt") as $pointer)
					{
						$topology = str_replace(array('.', '-', '_'), '', $realm = trim(strtolower($pointer)));
						if (!strpos(' '.$topology,"#")  && !empty($topology))
						{
							$row = array();
							$row["node"] = ".".$realm;
							$row['key'] = sha1($topology);
							$results[$topology] = $row;
						}
					}
				
					$io = fopen(__DIR__ . DIRECTORY_SEPARATOR . "stratas.json", "w+");
					fwrite($io, $json = json_encode($results), strlen($json));
					fclose($io);
				}
			}
		
		}

		if (strlen($start)>0 && !is_null($start))
		{
			$result = array();
			foreach($results as $topology => $row)
			{
				if (strtolower(substr($topology,0,strlen($start)))==strtolower($start))
				{
					if ($length!=0 && !is_null($length))
					{
						if ($strlen($topology)<=$length)
							$result[$topology] = $row;
					} else 
						$result[$topology] = $row;
				} 
			}
			return $result;
		}
		return $results;
	}
}
?>