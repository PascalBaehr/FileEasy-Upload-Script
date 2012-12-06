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

if(isset($_POST['adminsettings'])) {
  if($_POST['adminuser'] == "") {
    $error = "You did not enter an admin username";
  }else if($_POST['adminpass'] == "") {
    $error = "You did not enter an admin password";
  }else if($_POST['adminemail'] == "") {
    $error = "You did not enter an admin email";
  }else if(!verifyEmail($_POST['adminemail'])) {
    $error = "You did not enter a valid admin email";
  }else{
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['adminemail']) . "' WHERE `setting` = 'admin_email';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['adminuser']) . "' WHERE `setting` = 'admin_username';");
    mysql_query("UPDATE `".$table_prefix."settings` SET `value` = '" . mysql_real_escape_string($_POST['adminpass']) . "' WHERE `setting` = 'admin_password';");
    
    $success = "The admin settings have been successfully updated.";
  }
}

$pagename = "Admin Profile Settings";
include("./admin_header.php");
?>
  <div id="content">
    <ul id="topTabs">
      <li><a href="./index.php">Dashboard</a></li>
      <li><a href="./site_settings.php">Site Settings</a></li>
      <li class="selected"><a href="./admin_settings.php">Admin Settings</a></li>
      <li><a href="./manage_files.php">Manage Files</a></li>
    </ul>
    <div class="clear"></div>
    <h2>Admin Profile Settings</h2>
<?php
if(isset($error)) {
  print("    <div class=\"error\"><b>Error:</b> ".$error."</div>");
}
if(isset($success)) {
  print("    <div class=\"message\">".$success."</div>");
}
?>
    <form method="post" action="./admin_settings.php" id="adminsettings">
      <input type="hidden" name="adminsettings" value="1" />
      <label for="adminuser">Admin Username</label><br />
      <input type="text" name="adminuser" id="adminuser" value="<?php print get_config('admin_username'); ?>" size="40" /><br />
      <span class="supporting">The admin accounts username.</span><br /><br />
      <label for="adminpass">Admin Password</label><br />
      <input type="text" name="adminpass" id="adminpass" value="<?php print get_config('admin_password'); ?>" size="40" /><br />
      <span class="supporting">The admin accounts password.</span><br /><br />
      <label for="adminemail">Admin Email</label><br />
      <input type="text" name="adminemail" id="adminemail" value="<?php print get_config('admin_email'); ?>" size="40" /><br />
      <span class="supporting">Admin email address, emails sent out by the script will be sent from this address.</span><br /><br />
      <input type="submit" value="Save" class="submit" /> <input type="reset" value="Reset" class="submit" />
    </form>
  </div>
<?php
include("./admin_footer.php");
?>
