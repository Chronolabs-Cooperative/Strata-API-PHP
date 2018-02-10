<?php
/**
 * Internet domain Fallout + Class Strata REST Services API
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Cooperative http://syd.au.snails.email
 * @license         ACADEMIC APL 2 (https://sourceforge.net/u/chronolabscoop/wiki/Academic%20Public%20License%2C%20version%202.0/)
 * @license         GNU GPL 3 (http://www.gnu.org/licenses/gpl.html)
 * @package         strata-api
 * @since           2.1.11
 * @author          Dr. Simon Antony Roberts <simon@snails.email>
 * @version         2.1.13
 * @description		An Internet REST API which provides domain fallout + classing strata listing.
 * @link            http://internetfounder.wordpress.com
 * @link            https://github.com/Chronolabs-Cooperative/WhoIS-API-PHP
 * @link            https://sourceforge.net/p/chronolabs-cooperative
 * @link            https://facebook.com/ChronolabsCoop
 * @link            https://twitter.com/ChronolabsCoop
 * 
 */




//   Scheduled Cron Job Details.,
//   Execute:-
//
//   $ sudo crontab -e
//
//   CronTab Entry:
//
//   * */12 * * * /usr/bin/php -q /path/to/cronjobs/align-strata.php


ini_set('display_errors', true);
ini_set('log_errors', true);
error_reporting(E_ERROR);

$seconds = floor(mt_rand(1, floor(3600 * 4.75)));
set_time_limit($seconds ^ 4);
sleep($seconds);

include_once dirname(__DIR__).'/mainfile.php';
include_once dirname(__DIR__).'/apiconfig.php';

$realms = explode("\n", strtolower(getURIData(API_REALMS_URL, 120, 120)));

$sql = "UPDATE `" . $GLOBALS['APIDB']->prefix('strata_realms') . '` SET `active` = "Suspended" WHERE `realm` NOT IN ("' . implode('", "', $realms) . '")';
$GLOBALS["APIDB"]->queryF($sql);

$sql = "SELECT * FROM `" . $GLOBALS['APIDB']->prefix('strata_realms') . '` WHERE `active` = "Yes" ORDER BY `realm` ASC';
$result = $GLOBALS["APIDB"]->queryF($sql);
$dbrealms = array();
while($row = $GLOBALS['APIDB']->fetchArray($result))
    $dbrealms[strtolower($row['realm'])] = strtolower($row['realm']);

foreach($realms as $key => $realm)
    if (!in_array($realm, array_keys($dbrealms)))
    {
        $sql = "INSERT INTO `" . $GLOBALS['APIDB']->prefix('strata_realms') . '` (`uid`,`typal`,`md5`.`realm`,`active`,`stored`) VALUES(1, "TLD", md5("'.$realm.'"), "'.$realm.'", "Yes", UNIX_TIMESTAMP())';
        if (!$GLOBALS["APIDB"]->queryF($sql))
            die("SQL Failed: $sql;");
    }
