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


	$length = mt_rand(3,7);
	$start = chr(ord("a") + mt_rand(2,23));
	$typal = array("raw" => "RAW Document Output", "html" => "HTML Document Output", "serial" => "Serialisation Document Output", "json" => "JSON Document Output", "xml" => "eXtendable Markup Output");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta property="og:title" content="<?php echo API_VERSION; ?>"/>
<meta property="og:type" content="api<?php echo API_TYPE; ?>"/>
<meta property="og:image" content="<?php echo API_URL; ?>/assets/images/logo_500x500.png"/>
<meta property="og:url" content="<?php echo (isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>" />
<meta property="og:site_name" content="<?php echo API_VERSION; ?> - <?php echo API_LICENSE_COMPANY; ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="rating" content="general" />
<meta http-equiv="author" content="wishcraft@users.sourceforge.net" />
<meta http-equiv="copyright" content="<?php echo API_LICENSE_COMPANY; ?> &copy; <?php echo date("Y"); ?>" />
<meta http-equiv="generator" content="Chronolabs Cooperative (<?php echo $place['iso3']; ?>)" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo API_VERSION; ?> || <?php echo API_LICENSE_COMPANY; ?></title>
<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50f9a1c208996c1d"></script>
<script type="text/javascript">
  addthis.layers({
	'theme' : 'transparent',
	'share' : {
	  'position' : 'right',
	  'numPreferredServices' : 6
	}, 
	'follow' : {
	  'services' : [
		{'service': 'facebook', 'id': 'Chronolabs'},
		{'service': 'twitter', 'id': 'JohnRingwould'},
		{'service': 'twitter', 'id': 'ChronolabsCoop'},
		{'service': 'twitter', 'id': 'Cipherhouse'},
		{'service': 'twitter', 'id': 'OpenRend'},
	  ]
	},  
	'whatsnext' : {},  
	'recommended' : {
	  'title': 'Recommended for you:'
	} 
  });
</script>
<!-- AddThis Smart Layers END -->
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/style.css" type="text/css" />
<!-- Custom Fonts -->
<link href="<?php echo API_URL; ?>/assets/media/Labtop/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Bold Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Superwide Boldish/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Thin/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Unicase/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/LHF Matthews Thin/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Life BT Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Life BT Bold Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite Normal/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/gradients.php" type="text/css" />
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/shadowing.php" type="text/css" />

</head>
<body>
<div class="main">
	<img style="float: right; margin: 11px; width: auto; height: auto; clear: none;" src="<?php echo API_URL; ?>/assets/images/logo_350x350.png" />
    <h1><?php echo API_VERSION; ?> -- <?php echo API_LICENSE_COMPANY; ?></h1>
    <p>This is an API Service for retieving the Internet Strata & Fallout via the sub-layering systems in physics, even though you may not see the physical code running it is meta code that will adapt to the libraries that require it by simply pasting the director in and connecting the variable *.class or *.functions to your existing libraries -- the API inclusing JSON, XML, Serialisation, HTML and RAW outputs.</p>
	<h2>Code API Documentation</h2>
    <p>You can find the phpDocumentor code API documentation at the following path :: <a href="<?php echo API_URL . '/'; ?>docs/" target="_blank"><?php echo API_URL . '/'; ?>docs/</a>. These should outline the source code core functions and classes for the API to function!</p>
    <?php 
    foreach($typal as $mode => $title) {
    ?>
    <h2><?php echo $title; ?></h2>
    <p>This is done with the <em><?php echo $mode; ?>.api</em> extension at the end of the url, you replace the example address with either a domain, an IPv4 or IPv6 address the following example is of calls to the api</p>
    <blockquote>
        <font class="help-title-text">This is for a complete list of </em>networking strata topologies!</em></font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL . '/'; ?>v2/strata/<?php echo $mode; ?>.api" target="_blank"><?php echo API_URL . '/'; ?>v2/strata/<?php echo $mode; ?>.api</a></font><br /><br />
        <font class="help-title-text">This is for a list of </em>networking strata topologies;</em> that have a length of <strong>'<?php echo $length; ?>'</strong></font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL . '/'; ?>v2/strata/<?php echo $length; ?>/<?php echo $mode; ?>.api" target="_blank"><?php echo API_URL . '/'; ?>v2/strata/<?php echo $length; ?>/<?php echo $mode; ?>.api</a></font><br /><br />
        <font class="help-title-text">This is for a list of </em>networking strata topologies;</em> that start with the letter <strong>'<?php echo $start; ?>'</strong> - you can have more than one character!</font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL . '/'; ?>v2/strata/<?php echo $start; ?>/<?php echo $mode; ?>.api" target="_blank"><?php echo API_URL . '/'; ?>v2/strata/<?php echo $start; ?>/<?php echo $mode; ?>.api</a></font><br /><br />
        <font class="help-title-text">This is for a list of </em>networking strata topologies;</em> that are <strong>'<?php echo $length; ?>'</strong> in length, starting with the letter <strong>'<?php echo $start; ?>'</strong></font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL . '/'; ?>v2/strata/<?php echo $length; ?>/<?php echo $start; ?>/<?php echo $mode; ?>.api" target="_blank"><?php echo API_URL . '/'; ?>v2/strata/<?php echo $length; ?>/<?php echo $start; ?>/<?php echo $mode; ?>.api</a></font><br /><br />
        <font class="help-title-text">This is for a a complete list of </em>the regional network topologies that base and key in the networking strata!</em></font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL . '/'; ?>v2/fallout/<?php echo $mode; ?>.api" target="_blank"><?php echo API_URL . '/'; ?>v2/fallout/<?php echo $mode; ?>.api</a></font><br /><br />
    </blockquote>
    <?php }
     if (file_exists(API_FILE_IO_FOOTER)) {
    	readfile(API_FILE_IO_FOOTER);
    }?>	
    <h2>The Author</h2>
    <p>This was developed by Simon Roberts in 2013 and is part of the Chronolabs System and api's.<br/><br/>This is open source which you can download from <a href="https://sourceforge.net/projects/chronolabsapis/">https://sourceforge.net/projects/chronolabsapis/</a> contact the scribe  <a href="mailto:wishcraft@users.sourceforge.net">wishcraft@users.sourceforge.net</a></p></body>
</div>
</html>
<?php 
