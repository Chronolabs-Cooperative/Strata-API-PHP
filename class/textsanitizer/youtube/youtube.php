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


class MytsYoutube extends MyTextSanitizerExtension
{
    /**
     * @param $textarea_id
     *
     * @return array
     */
    public function encode($textarea_id)
    {
        $config = parent::loadConfig(__DIR__);
        $code = "<button type='button' class='btn btn-default btn-sm' onclick='apiCodeYoutube(\"{$textarea_id}\",\""
            . htmlspecialchars(_API_FORM_ENTERYOUTUBEURL, ENT_QUOTES) . "\",\""
            . htmlspecialchars(_API_FORM_ALT_ENTERHEIGHT, ENT_QUOTES) . "\",\""
            . htmlspecialchars(_API_FORM_ALT_ENTERWIDTH, ENT_QUOTES)
            . "\");' onmouseover='style.cursor=\"hand\"' title='" . _API_FORM_ALTYOUTUBE
            . "'><span class='fa fa-fw fa-youtube' aria-hidden='true'></span></button>";
        $javascript = <<<EOH
            function apiCodeYoutube(id, enterFlashPhrase, enterFlashHeightPhrase, enterFlashWidthPhrase)
            {
                var selection = apiGetSelect(id);
                if (selection.length > 0) {
                    var text = selection;
                } else {
                    var text = prompt(enterFlashPhrase, "");
                }
                var domobj = apiGetElementById(id);
                if (text.length > 0) {
                    var text2 = prompt(enterFlashWidthPhrase, "16x9");
                    var text3 = prompt(enterFlashHeightPhrase, "");
                    var result = "[youtube="+text2+","+text3+"]" + text + "[/youtube]";
                    apiInsertText(domobj, result);
                }
                domobj.focus();
            }
EOH;

        return array($code, $javascript);
    }

    /**
     * @param $match
     *
     * @return string
     */
    public static function myCallback($match)
    {
        return self::decode($match[4], $match[2], $match[3]);
    }

    /**
     * @param $ts
     */
    public function load($ts)
    {
        //        $ts->patterns[] = "/\[youtube=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/youtube\]/esU";
        //        $ts->replacements[] = __CLASS__ . "::decode( '\\4', '\\2', '\\3' )";

        //mb------------------------------
        $ts->callbackPatterns[] = "/\[youtube=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/youtube\]/sU";
        $ts->callbacks[]        = __CLASS__ . '::myCallback';
        //mb------------------------------
    }

    /**
     * @param $url
     * @param $width
     * @param $height
     *
     * @return string
     */
    public static function decode($url, $width, $height)
    {
        // modernized responsive youtube handling suggested by API user xd9527 -- thanks!
        // http://api.org/modules/newbb/viewtopic.php?post_id=359913

        // match known youtube urls
        // from: http://stackoverflow.com/questions/2936467/parse-youtube-video-id-using-preg-match/6382259#6382259
        $youtubeRegex = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)'
            .'([^"&?/ ]{11})%i';

        if (preg_match($youtubeRegex, $url, $match)) {
            $videoId = $match[1]; // extract just the video id from a url
        } elseif (preg_match('%^[^"&?/ ]{11}$%', $url)) {
            $videoId = $url; // have a bare video id
        } else {
            trigger_error("Not matched: {$url} {$width} {$height}", E_USER_WARNING);
            return '';
        }

        $width = empty($width) ? 426 : (int) $width;
        switch ($width) {
            case 4:
                $height = 3;
                break;
            case 16:
                $height = 9;
                break;
            default:
                $height = empty($height) ? 240 : (int) $height;
                break;
        }

        $aspectRatio = $width/$height; // 16x9 = 1.777777778, 4x3 = 1.333333333
        $responsiveAspect = ($aspectRatio < 1.4) ? 'embed-responsive-4by3' : 'embed-responsive-16by9';
        if ($width < 17 && $height < 10) {
            $scale = (int) 450 / $width;
            $width = $width * $scale;
            $height = $height * $scale;
        }

        $template = <<<'EOD'
        <div class="embed-responsive %4$s">
        <iframe class="embed-responsive-item" width="%2$d" height="%3$d" src="https://www.youtube.com/embed/%1$s" frameborder="0" allowfullscreen></iframe>
        </div>
EOD;

        $code = sprintf($template, $videoId, $width, $height, $responsiveAspect);
        return $code;
    }
}
