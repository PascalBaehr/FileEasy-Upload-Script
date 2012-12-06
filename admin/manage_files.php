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

$filesnum_result = mysql_query("SELECT COUNT(*) as num FROM `".$table_prefix."files` WHERE (`expiry` = '0' OR `expiry` >  '" . time() . "') AND (`deleted` = '0')");
$total_files = mysql_fetch_array($filesnum_result);
$total_files = $total_files['num'];

$files_limit = 15;
$stages = 3;
$page = mysql_escape_string($_GET['page']);
if($page){
  $start = ($page - 1) * $files_limit; 
}else{
  $start = 0;  
}

$files_result = mysql_query("SELECT * FROM `".$table_prefix."files` WHERE (`expiry` = '0' OR `expiry` >  '" . time() . "') AND (`deleted` = '0') ORDER BY `id` DESC LIMIT " . $start . ", " . $files_limit);
if ($page == 0) { $page = 1; }
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_files / $files_limit);
$LastPagem1 = $lastpage - 1;

$pagename = "Manage Files";
include("./admin_header.php");
?>
  <div id="content">
    <ul id="topTabs">
      <li><a href="./index.php">Dashboard</a></li>
      <li><a href="./site_settings.php">Site Settings</a></li>
      <li><a href="./admin_settings.php">Admin Settings</a></li>
      <li class="selected"><a href="./manage_files.php">Manage Files</a></li>
    </ul>
    <div class="clear"></div>
    <h2>Manage Files</h2>
<?php
if($_GET['action'] == "deleted") {
  print("    <div class=\"message\">The file has been successfully deleted.</div>");
}
?>
    <table width="100%" border="0" class="files">
      <tr>
        <td width="10%" align="center"><b>File ID</b></td>
        <td width="31%" align="center"><b>File Name</b></td>
        <td width="10%" align="center"><b>File Size</b></td>
        <td width="17%" align="center"><b>Uploaded</td>
        <td width="17%" align="center"><b>IP Address</b></td>
        <td width="15%" align="center"><b>Manage</b></td>
      </tr>
<?php while($files_row = mysql_fetch_array($files_result)) { ?>
      <tr class="file">
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><?php print($files_row['access_id']); ?></td>
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><acronym title="<?php print($files_row['file_name']); ?>"><?php print(shorten_title($files_row['file_name'])); ?></acronym></td>
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><?php print(bytesToSize($files_row['file_size'])); ?></td>
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><?php print(date("M j, Y, g:i A", $files_row['timestamp'])); ?></td>
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><?php print($files_row['ip_address']); ?></td>
        <td align="center" valign="top" style="border-top: 1px dashed grey; padding: 5px 5px 5px 5px;"><a href="./download_file.php?access_id=<?php print($files_row['access_id']); ?>" style="color: green;">Download</a> / <a href="./delete_file.php?access_id=<?php print($files_row['access_id']); ?>" style="color: red;">Delete</a></td>
      </tr>
<?php } ?>
    </table>
<?php
print "<p>\n";
if($lastpage > 1) {
  print "<div class='paginate'>\n";
  if ($page > 1){
    print "<a href='./manage_files.php?page=$prev'>previous</a>\n";
  }else{
    print "<span class='disabled'>previous</span>\n";
  }
  if ($lastpage < 7 + ($stages * 2)) {
    for ($counter = 1; $counter <= $lastpage; $counter++) {
      if ($counter == $page){
        print "<span class='current'>$counter</span>\n";
      }else{
        print "<a href='./manage_files.php?page=$counter'>$counter</a>\n";
      }
    }
  }else if($lastpage > 5 + ($stages * 2)) {
    if($page < 1 + ($stages * 2)) {
      for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
        if ($counter == $page) {
          print "<span class='current'>$counter</span>\n";
        }else{
          print "<a href='./manage_files.php?page=$counter'>$counter</a>\n";
        }
      }
      print "...";
      print "<a href='./manage_files.php?page=$LastPagem1'>$LastPagem1</a>\n";
      print "<a href='./manage_files.php?page=$lastpage'>$lastpage</a>\n";
    }elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
      print "<a href='./manage_files.php?page=1'>1</a>\n";
      print "<a href='./manage_files.php?page=2'>2</a>\n";
      print "...";
      for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
        if ($counter == $page) {
          print "<span class='current'>$counter</span>\n";
        }else{
          print "<a href='./manage_files.php?page=$counter'>$counter</a>\n";
        }
      }
      print "...";
      print "<a href='./manage_files.php?page=$LastPagem1'>$LastPagem1</a>\n";
      print "<a href='./manage_files.php?page=$lastpage'>$lastpage</a>\n";
    }else{
      print "<a href='./manage_files.php?page=1'>1</a>\n";
      print "<a href='./manage_files.php?page=2'>2</a>\n";
      print "...";
      for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
        if ($counter == $page) {
          print "<span class='current'>$counter</span>\n";
        }else{
          print "<a href='./manage_files.php?page=$counter'>$counter</a>\n";
        }
      }
    }
  }
  if ($page < $counter - 1){
    print "<a href='./manage_files.php?page=$next'>next</a>\n";
  }else{
    print "<span class='disabled'>next</span>\n";
  }
  print "</div>\n";
}
print "</p>\n";
?>
  </div>
<?php
include("./admin_footer.php");
?>
