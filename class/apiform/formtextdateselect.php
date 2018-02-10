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



defined('API_ROOT_PATH') || exit('API root path not defined');

/**
 * A text field with calendar popup
 */
class APIFormTextDateSelect extends APIFormText
{
    /**
     * @param string $caption
     * @param string $name
     * @param int $size
     * @param int $value
     */
    public function __construct($caption, $name, $size = 15, $value = 0)
    {
        $value = !is_numeric($value) ? time() : (int)$value;
        $value = ($value == 0) ? time() : $value;
        parent::__construct($caption, $name, $size, 25, $value);
    }

    /**
     * {@inheritDoc}
     * @see APIFormText::render()
     */
    public function render()
    {
        return APIFormRenderer::getInstance()->get()->renderFormTextDateSelect($this);
    }
}
