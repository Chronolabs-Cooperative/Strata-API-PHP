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

api_load('APIFormElement');

/**
 * A textarea
 */
class APIFormTextArea extends APIFormElement
{
    /**
     * number of columns
     *
     * @var int
     * @access private
     */
    public $_cols;

    /**
     * number of rows
     *
     * @var int
     * @access private
     */
    public $_rows;

    /**
     * initial content
     *
     * @var string
     * @access private
     */
    public $_value;

    /**
     * Constuctor
     *
     * @param string $caption caption
     * @param string $name    name
     * @param string $value   initial content
     * @param int    $rows    number of rows
     * @param int    $cols    number of columns
     */
    public function __construct($caption, $name, $value = '', $rows = 5, $cols = 50)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_rows = (int)$rows;
        $this->_cols = (int)$cols;
        $this->setValue($value);
    }

    /**
     * get number of rows
     *
     * @return int
     */
    public function getRows()
    {
        return $this->_rows;
    }

    /**
     * Get number of columns
     *
     * @return int
     */
    public function getCols()
    {
        return $this->_cols;
    }

    /**
     * Get initial content
     *
     * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
     * @return string
     */
    public function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value) : $this->_value;
    }

    /**
     * Set initial content
     *
     * @param  $value string
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * prepare HTML for output
     *
     * @return sting HTML
     */
    public function render()
    {
        return APIFormRenderer::getInstance()->get()->renderFormTextArea($this);
    }
}
