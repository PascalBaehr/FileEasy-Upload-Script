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

include("../utils/config.php");

mysql_connect($database_host, $database_user, $database_pass) or die("Could not connect to database: " . mysql_error());
mysql_select_db($database_name) or die("Could not select database: " . mysql_error());

if(isset($_POST['setup-script'])) {
  if(trim($_POST['site_name']) == "") {
    $error = "You did not enter a site name.";
  }else if(trim($_POST['site_domain']) == "") {
    $error = "You did not enter a site URL.";
  }else{
  	// Delete any settings already in the table
  	mysql_query("TRUNCATE TABLE `".$table_prefix."settings`");
  	
  	mysql_query("INSERT INTO `".$table_prefix."settings` (`setting`, `value`) VALUES ('site_name', '" . mysql_real_escape_string($_POST['site_name']) . "'), ('site_metakey', 'File Upload Script makes sharing files easy.'), ('site_metadesc', 'File Upload Script, upload, secure storage'), ('site_domain', '" . mysql_real_escape_string($_POST['site_domain']) . "'), ('download_waittime', '4'), ('download_sessionexpiry', '60'), ('download_sponsor', '0'), ('download_sponsorcode', ''), ('admin_email', 'support@uploadscript.com'), ('admin_username', 'admin'), ('admin_password', 'admin'), ('upload_sizelimit', '100');");
  	
    header("Location: ./step5-finish.php");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Database Setup :: Easy File Upload Script Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="image/x-icon" href="../favicon.ico" rel="icon" />
<link type="image/x-icon" href="../favicon.ico" rel="shortcut icon" />
<link type="text/css" href="../admin/stylesheet.css" rel="stylesheet" />
</head>

<body>
<div id="wrapper">
  <div id="header">
    <div id="logo"><a>Easy File Upload Script Installation</a></div>
    <div class="clear"></div>
  </div>
  <div id="content">
    <h2>Database Setup</h2>
<?php
if(isset($error)) {
  print("    <div class=\"error\"><b>Error:</b> ".$error."</div>");
}
?>
    <p>Enter your database details below, it will be written to the config.php file.</p>
    <form method="post" action="./step4-setup.php" id="setup-script">
      <input type="hidden" name="setup-script" value="1" />
      
      <label for="site_name">Site Name</label><br />
      <input type="text" name="site_name" id="site_name" value="<?php if(isset($_POST['site_domain'])) { print $_POST['site_name']; } ?>" size="40" /><br />
      <span class="supporting">The name of the website. E.g. <i>Easy File</i></span><br /><br />
      
      <label for="site_domain">Site Domain</label><br />
      <input type="text" name="site_domain" id="site_domain" value="<?php if(isset($_POST['site_domain'])) { print $_POST['site_domain']; }else{ echo $_SERVER['HTTP_HOST']; } ?>" size="40" /><br />
      <span class="supporting">The full site domain excluding http:// and any slashes. E.g. <i>www.fileeasy.co.uk</i></span><br /><br />
      
      <input type="submit" name="submit" value="Save Settings" class="submit" />
    </form>
  </div>
</div>
<div id="footer">
  <ul id="footernav">
    <li>Powered by <a href="https://github.com/asadhaider/FileEasy-Upload-Script">Easy File Upload Script</a></li>
  </ul>
  &copy; <?php print date('Y'); ?>. All Rights Reserved.
  <div class="clear"></div>
</div>

</body>
</html>
