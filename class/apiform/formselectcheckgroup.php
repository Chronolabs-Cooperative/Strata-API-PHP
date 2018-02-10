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


defined('API_ROOT_PATH') || exit('Restricted access');

api_load('APIFormCheckBox');

/**
 * API Form Select Check Groups
 *
 * @author              John Neill <catzwolf@api.org>
 * @copyright       (c) 2000-2016 API Project (www.api.org)
 * @package             kernel
 * @subpackage          form
 * @access              public
 */
class APIFormSelectCheckGroup extends APIFormCheckBox
{
    /**
     * Constructor
     *
     * @param string $caption
     * @param string $name
     * @param mixed  $value    Pre-selected value (or array of them).
     */
    public function __construct($caption, $name, $value = null)
    {
        /* @var $member_handler APIMemberHandler */
        $member_handler   = api_getHandler('member');
        $userGroups = $member_handler->getGroupList();
        parent::__construct($caption, $name, $value);
        $this->columns = 3;
        foreach ($userGroups as $group_id => $group_name) {
            $this->addOption($group_id, $group_name);
        }
    }
}
