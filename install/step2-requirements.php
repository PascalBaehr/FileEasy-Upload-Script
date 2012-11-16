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

// Installation mod_rewrite check
if($_GET['checkrewrite'] == 1) { die("1"); }

// Check php version
if( phpversion() < 5 ) {
  $error = true;
  $php_msg = "<font color='red'>You must have PHP version 5 or above installed to use this script. This server has PHP version ".phpversion()." installed.</font>";
}else{
  $php_msg = "<font color='green'>PHP version ".phpversion()." installed!</font>";
}

// Check for mysql support
if( !extension_loaded("mysql") ) {
  $error = true;
  $mysql_msg = "<font color='red'>The PHP MySQL extension could not be found on this server.</font>";
}else{
  $mysql_msg = "<font color='green'>PHP MySQL extension enabled!</font>";
}

// Check config file is writable
if( !@is_writable("../utils/config.php") ) {
  $error = true;
  $config_msg = "<font color='red'>The includes/config.php file is not writable by the script, please CHMOD it to 755 or above.</font>";
}else{
  $config_msg = "<font color='green'>Configuration file writable by script!</font>";
}

// Check uploads directory is writable
if( !@is_writable("../uploads/") ) {
  $error = true;
  $upload_msg = "<font color='red'>The uploads file is not writable by the script, please CHMOD it to 755 or above.</font>";
}else{
  $upload_msg = "<font color='green'>Uploads directory writable by script!</font>";
}

// Check Apache mod_rewrite support
if( !in_array('mod_rewrite', apache_get_modules()) ) {
  $error = true;
  $rewrite_msg = "<font color='red'>Apache mod_rewrite can not be detected as being installed.</font>";
}else{
  $rewrite_msg = "<font color='green'>Apache mod_rewrite installed!</font>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Server Requirements :: Easy File Upload Script Installation</title>
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
    <h2>Check Server Requirements</h2>
    <p>
      The script will now check that your server meets the requirements. If any errors are found, they must be fixed before you 
      can install this script.
    </p>
    <p>
      <b>PHP Version 5 or Higher</b><br />
      <?php print $php_msg; ?>
    </p>
    <p>
      <b>MySQL Support</b><br />
      <?php print $mysql_msg; ?>
    </p>
    <p>
      <b>Make sure config file is writable</b><br />
      <?php print $config_msg; ?>
    </p>
    <p>
      <b>Make sure uploads directory is writable</b><br />
      <?php print $upload_msg; ?>
    </p>
    <p>
      <b>Make sure Apache mod_rewrite module is installed</b><br />
      <?php print $rewrite_msg; ?>
    </p>
    <form method="get" action="./step3-database.php" id="continue-setup">
      <input type="submit" name="submit" value="Continue Setup" class="submit" <?php if($error == true) { print "disabled"; } ?> />
      <?php if($error == true) { print "Or <a href=\"./step3-database.php\">click here</a> to continue anyway.\n"; } ?>
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
