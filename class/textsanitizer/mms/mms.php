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

/**
 * Class MytsMms
 */
class MytsMms extends MyTextSanitizerExtension
{
    /**
     * @param $textarea_id
     *
     * @return array
     */
    public function encode($textarea_id)
    {
        $config     = parent::loadConfig(__DIR__);
        if ($config['enable_mms_entry'] === false) {
            return array();
        }
        $code = "<button type='button' class='btn btn-default btn-sm' onclick='apiCodeMms(\"{$textarea_id}\",\""
            . htmlspecialchars(_API_FORM_ENTERMMSURL, ENT_QUOTES) . "\",\""
            . htmlspecialchars(_API_FORM_ALT_ENTERHEIGHT, ENT_QUOTES) . "\",\""
            . htmlspecialchars(_API_FORM_ALT_ENTERWIDTH, ENT_QUOTES)
            . "\");' onmouseover='style.cursor=\"hand\"' title='" . _API_FORM_ALTMMS
            . "'><span class='fa fa-fw fa-server' aria-hidden='true'></span></button>";

        //$code       = "<img src='{$this->image_path}/mmssrc.gif' alt='" . _API_FORM_ALTMMS . "' title='" . _API_FORM_ALTMMS . "' '". "' onclick='apiCodeMms(\"{$textarea_id}\",\"" . htmlspecialchars(_API_FORM_ENTERMMSURL, ENT_QUOTES) . "\",\"" . htmlspecialchars(_API_FORM_ALT_ENTERHEIGHT, ENT_QUOTES) . "\",\"" . htmlspecialchars(_API_FORM_ALT_ENTERWIDTH, ENT_QUOTES) . "\");'  onmouseover='style.cursor=\"hand\"'/>&nbsp;";
        $javascript = <<<EOH
            function apiCodeMms(id,enterMmsPhrase, enterMmsHeightPhrase, enterMmsWidthPhrase)
            {
                var selection = apiGetSelect(id);
                if (selection.length > 0) {
                    var selection="mms://"+selection;
                    var text = selection;
                } else {
                    var text = prompt(enterMmsPhrase+"       mms or http", "mms://");
                }
                var domobj = apiGetElementById(id);
                if (text.length > 0 && text != "mms://") {
                    var text2 = prompt(enterMmsWidthPhrase, "480");
                    var text3 = prompt(enterMmsHeightPhrase, "330");
                    var result = "[mms="+text2+","+text3+"]" + text + "[/mms]";
                    apiInsertText(domobj, result);
                }
                domobj.focus();
            }
EOH;

        return array(
            $code,
            $javascript);
    }

    /**
     * @param $ts
     *
     * @return bool
     */
    public function load($ts)
    {
        $ts->patterns[] = "/\[mms=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/mms\]/sU";
        $rp             = "<OBJECT id=videowindow1 height='\\3' width='\\2' classid='CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6'>";
        $rp .= "<PARAM NAME=\"URL\" VALUE=\"\\4\">";
        $rp .= "<PARAM NAME=\"rate\" VALUE=\"1\">";
        $rp .= "<PARAM NAME=\"balance\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"currentPosition\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"defaultFrame\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"playCount\" VALUE=\"1\">";
        $rp .= "<PARAM NAME=\"autoStart\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"currentMarker\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"invokeURLs\" VALUE=\"-1\">";
        $rp .= "<PARAM NAME=\"baseURL\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"volume\" VALUE=\"50\">";
        $rp .= "<PARAM NAME=\"mute\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"uiMode\" VALUE=\"full\">";
        $rp .= "<PARAM NAME=\"stretchToFit\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"windowlessVideo\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"enabled\" VALUE=\"-1\">";
        $rp .= "<PARAM NAME=\"enableContextMenu\" VALUE=\"-1\">";
        $rp .= "<PARAM NAME=\"fullScreen\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"SAMIStyle\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"SAMILang\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"SAMIFilename\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"captioningID\" VALUE=\"\">";
        $rp .= "<PARAM NAME=\"enableErrorDialogs\" VALUE=\"0\">";
        $rp .= "<PARAM NAME=\"_cx\" VALUE=\"12700\">";
        $rp .= "<PARAM NAME=\"_cy\" VALUE=\"8731\">";
        $rp .= '</OBJECT>';
        $ts->replacements[] = $rp;

        return true;
    }
}
