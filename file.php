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

include("./utils/config.php");
include("./utils/functions.php");
include("./utils/classes/filesize.php");

$access_id = $_GET["id"];
$security_id = $_GET["secid"];

if(!mysql_num_rows(mysql_query("SELECT * FROM `" . $table_prefix . "dlsession` WHERE session_id = '" . mysql_real_escape_string($security_id) . "' AND access_id = '" . mysql_real_escape_string($access_id) . "'"))) {
  $page_name = "file download";
  include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>Session Invalid</h2>
        This download session is invalid. <a href="/<?php print $access_id; ?>">Click here</a> to download the file.
      </div>
    </div>
  </div>
<?php
  include("./utils/templates/footer.php");
}else{
  $fileinfo_result = mysql_query("SELECT * FROM `" . $table_prefix . "files` WHERE access_id = '" . mysql_real_escape_string($access_id) . "'");
  $fileinfo = mysql_fetch_array($fileinfo_result);
  
  $sessioninfo_result = mysql_query("SELECT * FROM `" . $table_prefix . "dlsession` WHERE session_id = '" . mysql_real_escape_string($security_id) . "' AND access_id = '" . mysql_real_escape_string($access_id) . "'");
  $sessioninfo = mysql_fetch_array($sessioninfo_result);
  
  $current_timestamp = time();
  $file_expiry = $fileinfo["expiry"];
  $session_expiry = $sessioninfo["expiry"];
  
  $client_ip = getClientIP();
  $session_ip = $sessioninfo["ip_address"];
  
  if( (intval($expiry_timestamp) !== 0) && ($current_timestamp > $expiry_timestamp) ) {
    $page_name = "file download";
    include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>File has expired</h2>
        The file you are trying to download has expired and is no longer available.
      </div>
    </div>
  </div>
<?php
    include("./utils/templates/footer.php");
  }else if($current_timestamp > $session_expiry) {
    $page_name = "file download";
    include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>Session Expired</h2>
        This download session has expired due to inactivity. <a href="/<?php print $access_id; ?>">Click here</a> to download the file.
      </div>
    </div>
  </div>
<?php
    include("./utils/templates/footer.php");
  }else if($client_ip !== $session_ip) {
    // Hotlinking download file link, redirect to download page
    $page_name = "file download";
    include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>Session Invalid</h2>
        This download session is invalid. <a href="/<?php print $access_id; ?>">Click here</a> to download the file.
      </div>
    </div>
  </div>
<?php
    include("./utils/templates/footer.php");
  }else if( $fileinfo['deleted'] == 1 ) {
    // File deleted
    $page_name = "file download";
    include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>File Deleted</h2>
        The file you are trying to download has been deleted and is no longer available.
      </div>
    </div>
  </div>
<?php
    include("./utils/templates/footer.php");
  }else{
    $file_path = "./uploads/" . $access_id;
    
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Type: " . $fileinfo["file_type"]);
    header("Content-Disposition: attachment; filename=\"" . $fileinfo["file_name"] . "\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $fileinfo["file_size"]);
    
    $file = @fopen($file_path, "rb");
    if ($file) {
      while(!feof($file)) {
        print(fread($file, 1024*8));
        flush();
        if (connection_status()!=0) {
          @fclose($file);
          die();
        }
      }
      @fclose($file);
    }
  }
}
?>