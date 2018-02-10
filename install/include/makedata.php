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


// include_once './class/dbmanager.php';
// RMV
// TODO: Shouldn't we insert specific field names??  That way we can use
// the defaults specified in the tmpbase...!!!! (and don't have problem
// of missing fields in install file, when add new fields to tmpbase)
function make_groups(&$dbm)
{
    return array();
}

/**
 * @param $dbm
 * @param $adminname
 * @param $hashedAdminPass
 * @param $adminmail
 * @param $language
 * @param $groups
 *
 * @return mixed
 */
function make_data(&$dbm, $adminname, $hashedAdminPass, $adminmail, $language, $groups)
{
    $dbm->insert('users', " VALUES (1,'','" . addslashes($adminname) . "','" . addslashes($adminmail) . "','" . API_URL . "/','avatars/blank.gif','" . time() . "','','','', '" . $temp . "',0,1,'".date_default_timezone_get() . "',".time().",".time().",1)");    
    return true;
}
