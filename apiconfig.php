<?php
/**
 * Chronolabs REST Blowfish Salts Repository API
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
 * @package         salty
 * @since           2.0.1
 * @author          Simon Roberts <wishcraft@users.sourceforge.net>
 * @version         $Id: apiconfig.php 1000 2015-06-16 23:11:55Z wishcraft $
 * @subpackage		api
 * @description		Blowfish Salts Repository API
 * @link			http://cipher.labs.coop
 * @link			http://sourceoforge.net/projects/chronolabsapis
 */


if (!is_file(__DIR__ . DIRECTORY_SEPARATOR . 'mainfile.php') || !is_file(__DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'license.php'))
{
    header('Location: ' . "./install");
    exit(0);
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'mainfile.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Opens Access Origin Via networking Route NPN
 */
header('Access-Control-Allow-Origin: *');
header('Origin: *');

/**
 * Turns of GZ Lib Compression for Document Incompatibility
 */
ini_set("zlib.output_compression", 'Off');
ini_set("zlib.output_compression_level", -1);

/**
 * Checks for Database to be Initalised
 * @var Ambiguous $sql
 */
$sql = "SELECT count(*) FROM `" . $GLOBALS['APIDB']->prefix('strata_fallouts') . "`";
list($count) = $GLOBALS['APIDB']->fetchRow($GLOBALS['APIDB']->queryF($sql));
if ($count==0) {
    $GLOBALS['APIDB']->queryF('START TRANSACTION');
    foreach(json_decode(getURIData(API_PLACES_API_URL."/v3/list/list/json.api", 120, 120), true) as $key => $values) {
        if (!empty($values['TLD']))
        {
            if (empty($values['Population']))
                $values['Population'] = '0';
            if (empty($values['ISON']))
                $values['ISON'] = '0';
            $sql = "INSERT INTO `" . $GLOBALS['APIDB']->prefix('strata_fallouts') . "` (`Country`, `ISO2`, `FIPS104`, `ISO3`, `ISON`, `TLD`, `Capital`, `Continent`, `NationalitySingular`, `NationalityPlural`, `FiscalNomial`, `FiscalNomialCode`, `Population`) VALUES('" . $GLOBALS['APIDB']->escape($values['Country']) . "', '" . $GLOBALS['APIDB']->escape($values['ISO2']) . "', '" . $GLOBALS['APIDB']->escape($values['FIPS104']) . "', '" . $GLOBALS['APIDB']->escape($values['ISO3']) . "', '" . $GLOBALS['APIDB']->escape($values['ISON']) . "', '" . $GLOBALS['APIDB']->escape($values['TLD']) . "', '" . $GLOBALS['APIDB']->escape($values['Capital']) . "', '" . $GLOBALS['APIDB']->escape($values['Continent']) . "', '" . $GLOBALS['APIDB']->escape($values['NationalitySingular']) . "', '" . $GLOBALS['APIDB']->escape($values['NationalityPlural']) . "', '" . $GLOBALS['APIDB']->escape($values['Currency']) . "', '" . $GLOBALS['APIDB']->escape($values['CurrencyCode']) . "', '" . $GLOBALS['APIDB']->escape($values['Population']) . "')";
            if (!$GLOBALS['APIDB']->queryF($sql))
                die("SQL Failed: $sql;");
        }
    }
    $GLOBALS['APIDB']->queryF('COMMIT');
}

$sql = "SELECT count(*) FROM `" . $GLOBALS['APIDB']->prefix('strata_realms') . "`";
list($count) = $GLOBALS['APIDB']->fetchRow($GLOBALS['APIDB']->queryF($sql));
if ($count==0) {
    $GLOBALS['APIDB']->queryF('START TRANSACTION');
    foreach(explode("\n",getURIData(API_REALMS_URL, 120, 120)) as $key => $realm) {
        if (!empty($realm) && trim($realm) != '' && substr($realm, 0, 1) != '#')
        {
            $sql = "INSERT INTO `" . $GLOBALS['APIDB']->prefix('strata_realms') . "` (`uid`, `active`, `realm`, `md5`, `stored`) VALUES('1', 'Yes', '" . $GLOBALS['APIDB']->escape(strtoupper($realm)) . "', MD5('" . $GLOBALS['APIDB']->escape(strtoupper($realm)) . "'), UNIX_TIMESTAMP())";
            if (!$GLOBALS['APIDB']->queryF($sql))
                die("SQL Failed: $sql;");
        }
    }
    $GLOBALS['APIDB']->queryF('COMMIT');
}
?>