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



require_once './include/common.inc.php';
defined('API_INSTALL') || die('API Installation wizard die');

$pageHasForm = true;
$pageHasHelp = true;

$vars =& $_SESSION['settings'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = array('DB_TYPE', 'DB_HOST', 'DB_USER', 'DB_PASS');
    foreach ($params as $name) {
        $vars[$name] = $_POST[$name];
    }
    $vars['DB_PCONNECT'] = @$_POST['DB_PCONNECT'] ? 1 : 0;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($vars['DB_HOST']) && !empty($vars['DB_USER'])) {
    $hostConnectPrefix = empty($vars['DB_PCONNECT']) ? '' : 'p:';
    $link = new mysqli($hostConnectPrefix.$vars['DB_HOST'], $vars['DB_USER'], $vars['DB_PASS']);
    if (0 !== $link->connect_errno) {
        $error = ERR_NO_DBCONNECTION .' (' . $link->connect_errno . ') ' . $link->connect_error;;
    }
    if (empty($error)) {
        $wizard->redirectToPage('+1');
        exit();
    }
}

if (@empty($vars['DB_HOST'])) {
    // Fill with default values
    $vars = array_merge($vars, array(
                                 'DB_TYPE'     => 'mysql',
                                 'DB_HOST'     => 'localhost',
                                 'DB_USER'     => '',
                                 'DB_PASS'     => '',
                                 'DB_PCONNECT' => 0));
}
ob_start();
?>
<?php if (!empty($error)) {
    echo '<div class="alert alert-danger"><span class="fa fa-ban text-danger"></span> ' . $error . "</div>\n";
} ?>
    <div class="panel panel-info">
    <div class="panel-heading"><?php echo LEGEND_CONNECTION; ?></div>
    <div class="panel-body">
        <?php echo xoFormSelect('DB_TYPE', $vars['DB_TYPE'], DB_DATABASE_LABEL, $wizard->configs['db_types']) ?>

        <?php echo xoFormField('DB_HOST', $vars['DB_HOST'], DB_HOST_LABEL, DB_HOST_HELP); ?>
        <?php echo xoFormField('DB_USER', $vars['DB_USER'], DB_USER_LABEL, DB_USER_HELP); ?>
        <?php echo xoPassField('DB_PASS', $vars['DB_PASS'], DB_PASS_LABEL, DB_PASS_HELP); ?>

        <div class="checkbox">
            <label>
                <input class="checkbox" type="checkbox" name="DB_PCONNECT" value="1" <?php echo $vars['DB_PCONNECT'] ? 'checked' : ''; ?>/>
                <?php echo DB_PCONNECT_LABEL; ?>
            </label>
            <div class="xoform-help alert alert-info"><?php echo DB_PCONNECT_HELP; ?></div>
        </div>
    </div>

<?php
$content = ob_get_contents();
ob_end_clean();
include './include/install_tpl.php';
