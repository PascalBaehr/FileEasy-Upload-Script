<?php
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Asad Haider <asad@asadhaider.co.uk>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package     FileEasy-Upload-Script
 * @author      Asad Haider <asad@asadhaider.co.uk>
 * @copyright   2012 Asad Haider.
 * @link        http://asadhaider.co.uk
 * @version     1.0.0
 */

session_start();
include("../utils/config.php");
include("../utils/functions.php");
include("../utils/admin_functions.php");

if(!isset($_SESSION['adminsession'])) {
  header("location: ./login.php");
}

if(isset($_POST['sitesettings'])) {
  if(trim($_POST['site_name']) == "") {
    $error = "You did not enter a site name.";
  }else if(trim($_POST['site_domain']) == "") {
    $error = "You did not enter a site URL.";
  }else if(!is_numeric($_POST['upload_sizelimit'])) {
    $error = "You did not enter a numeric value for upload size limit.";
  }else if(!is_numeric($_POST['download_waittime'])) {
    $error = "You did not enter a numeric value for download wait time.";
  }else if(!is_numeric($_POST['download_sessionexpiry'])) {
    $error = "You did not enter a numeric value for session expiry time.";
  }else{
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['site_name']) . "' WHERE `setting` = 'site_name';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['site_metakey']) . "' WHERE `setting` = 'site_metakey';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['site_metadesc']) . "' WHERE `setting` = 'site_metadesc';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['site_domain']) . "' WHERE `setting` = 'site_domain';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['upload_sizelimit']) . "' WHERE `setting` = 'upload_sizelimit';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['download_waittime']) . "' WHERE `setting` = 'download_waittime';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['download_sessionexpiry']) . "' WHERE `setting` = 'download_sessionexpiry';");
    if( $_POST['download_sponsor'] == 1 ) { $download_sponsor = 1; }else{ $download_sponsor = 0; }
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . $download_sponsor . "' WHERE `setting` = 'download_sponsor';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['download_sponsorcode']) . "' WHERE `setting` = 'download_sponsorcode';");
    $success = "The admin settings have been successfully updated.";
  }
}

$settings_result = mysql_query("SELECT * FROM `".$table_prefix."settings`");
$settings_row = mysql_fetch_array($settings_result);

$pagename = "Site Settings";
include("./admin_header.php");
?>
  <div id="content">
    <ul id="topTabs">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="selected"><a href="./site_settings.php">Site Settings</a></li>
      <li><a href="./admin_settings.php">Admin Settings</a></li>
      <li><a href="./manage_files.php">Manage Files</a></li>
    </ul>
    <div class="clear"></div>
    <h2>Site Settings</h2>
<?php
if(isset($error)) {
  print("    <div class=\"error\"><b>Error:</b> ".$error."</div>");
}
if(isset($success)) {
  print("    <div class=\"message\">".$success."</div>");
}
?>
    <form method="post" action="./site_settings.php" id="sitesettings">
      <input type="hidden" name="sitesettings" value="1" />
      
      <label for="site_name">Site Name</label><br />
      <input type="text" name="site_name" id="site_name" value="<?php print stripslashes(get_config('site_name')); ?>" size="40" /><br />
      <span class="supporting">The name of the website. E.g. <i>Easy File</i></span><br /><br />
      
      <label for="site_metakey">Meta Keywords</label><br />
      <input type="text" name="site_metakey" id="site_metakey" value="<?php print stripslashes(get_config('site_metakey')); ?>" size="85" /><br />
      <span class="supporting">The meta keywords that will be displayed on all pages.</span><br /><br />
      
      <label for="site_metadesc">Meta Description</label><br />
      <input type="text" name="site_metadesc" id="site_metadesc" value="<?php print stripslashes(get_config('site_metadesc')); ?>" size="85" /><br />
      <span class="supporting">The meta description that will be displayed on all pages.</span><br /><br />
      
      <label for="site_domain">Site Domain</label><br />
      <input type="text" name="site_domain" id="site_domain" value="<?php print stripslashes(get_config('site_domain')); ?>" size="40" /><br />
      <span class="supporting">The full site domain excluding http:// and any slashes. E.g. <i>www.fileeasy.co.uk</i></span><br /><br />
      
      <label for="upload_sizelimit">Upload Size Limit (megabytes)</label><br />
      <input type="text" name="upload_sizelimit" id="upload_sizelimit" value="<?php print stripslashes(get_config('upload_sizelimit')); ?>" size="20" /><br />
      <span class="supporting">Maximum MB limit for uploaded files.</span><br /><br />
      
      <label for="download_waittime">Download Wait Time (seconds)</label><br />
      <input type="text" name="download_waittime" id="download_waittime" value="<?php print stripslashes(get_config('download_waittime')); ?>" size="20" /><br />
      <span class="supporting">Number of seconds a user must wait on the file page before the download starts.</span><br /><br />
      
      <label for="download_sessionexpiry">Download Session Expiry (minutes)</label><br />
      <input type="text" name="download_sessionexpiry" id="download_sessionexpiry" value="<?php print stripslashes(get_config('download_sessionexpiry')); ?>" size="20" /><br />
      <span class="supporting">Number of minutes a download session is valid for.</span><br /><br />
      
      <label for="download_sponsor">Show Download Sponsor</label><br />
      <input type="checkbox" name="download_sponsor" id="download_sponsor" value="1" <?php if( get_config('download_sponsor') == 1 ) { print "checked"; } ?>> Enable sponsor text on download file page.<br /><br />

      <label for="download_sponsorcode">Download Sponsor Code</label><br />
      <textarea rows="6" cols="80" name="download_sponsorcode" id="download_sponsorcode"><?php print stripslashes(get_config('download_sponsorcode')); ?></textarea><br />
      <span class="supporting">Code for download sponsor (250 x 250 advert).</span><br /><br />
      
      <input type="submit" value="Save" class="submit" /> <input type="reset" value="Reset" class="submit" />
    </form>
  </div>
<?php
include("./admin_footer.php");
?>
