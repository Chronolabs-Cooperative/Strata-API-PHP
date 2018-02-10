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
 * Usage of APIFormCaptcha
 *
 * For form creation:
 * Add form element where proper: <code>$apiform->addElement(new APIFormCaptcha($caption, $name, $skipmember, $configs));</code>
 *
 * For verification:
 * <code>
 *               api_load('apicaptcha');
 *               $apiCaptcha = APICaptcha::getInstance();
 *               if (! $apiCaptcha->verify() ) {
 *                   echo $apiCaptcha->getMessage();
 *                   ...
 *               }
 * </code>
 */

/**
 * API Form Captcha
 *
 * @author             Taiwen Jiang <phppp@users.sourceforge.net>
 * @package            kernel
 * @subpackage         form
 */
class APIFormCaptcha extends APIFormElement
{
    public $captchaHandler;

    /**
     * Constructor
     * @param string  $caption    Caption of the form element, default value is defined in captcha/language/
     * @param string  $name       Name for the input box
     * @param boolean $skipmember Skip CAPTCHA check for members
     * @param array   $configs
     */
    public function __construct($caption = '', $name = 'apicaptcha', $skipmember = true, $configs = array())
    {
        api_load('APICaptcha');
        $this->captchaHandler  = APICaptcha::getInstance();
        $configs['name']       = $name;
        $configs['skipmember'] = $skipmember;
        $this->captchaHandler->setConfigs($configs);
        if (!$this->captchaHandler->isActive()) {
            $this->setHidden();
        } else {
            $caption = !empty($caption) ? $caption : $this->captchaHandler->getCaption();
            $this->setCaption($caption);
            $this->setName($name);
        }
    }

    /**
     * @param $name
     * @param $val
     *
     * @return mixed
     */
    public function setConfig($name, $val)
    {
        return $this->captchaHandler->setConfig($name, $val);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        // if (!$this->isHidden()) {
        return $this->captchaHandler->render();
        // }
    }

    /**
     * @return mixed
     */
    public function renderValidationJS()
    {
        return $this->captchaHandler->renderValidationJS();
    }
}
