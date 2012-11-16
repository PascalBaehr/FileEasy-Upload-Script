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

if(!session_is_registered(adminsession)) {
  header("location: ./login.php");
}

$file_query = mysql_query("SELECT * FROM `".$table_prefix."files`");

$pagename = "Dashboard";
include("./admin_header.php");
?>
  <div id="content">
    <ul id="topTabs">
      <li class="selected"><a href="./index.php">Dashboard</a></li>
      <li><a href="./site_settings.php">Site Settings</a></li>
      <li><a href="./admin_settings.php">Admin Settings</a></li>
      <li><a href="./manage_files.php">Manage Files</a></li>
    </ul>
    <div class="clear"></div>
    <h2>Admin Dashboard</h2>
    <table width="100%" border="0">
      <tr>
        <td width="100%" colspan="4"><b>Site Statistics</b></td>
      </tr>
      <tr>
        <td width="25%">Total Uploads:</td>
        <td width="25%"><?php print(mysql_num_rows($file_query)); ?></td>
        <td width="25%">Active Uploads Size:</td>
        <td width="25%"><?php $totalsize = 0; while( $file = mysql_fetch_array($file_query) ) { $totalsize += $file['file_size']; } print(bytesToSize($totalsize)); ?></td>
     </tr>
      <tr>
        <td width="25%">Active Files:</td>
        <td width="25%"><?php print(mysql_num_rows(mysql_query("SELECT * FROM `".$table_prefix."files` WHERE (`expiry` = '0' OR `expiry` >  '" . time() . "') AND (`deleted` = '0')"))); ?> [ <a href="./manage_files.php">Manage</a> ]</td>
        <td width="25%"></td>
        <td width="25%"></td>
      </tr>
    </table>
  </div>
<?php
include("./admin_footer.php");
?>