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

$page_name = "file download";
$css_type = "download";
include("./utils/templates/header.php");
?>
  <div id="content">
<?php
if(!mysql_num_rows(mysql_query("SELECT * FROM `" . $table_prefix . "files` WHERE access_id = '" . mysql_real_escape_string($access_id) . "'"))) {
?>
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>File not found</h2>
        Please verify the URL.
      </div>
    </div>
<?php
}else{
  // fetch file information
  $fileinfo_result = mysql_query("SELECT * FROM `" . $table_prefix . "files` WHERE access_id = '" . mysql_real_escape_string($access_id) . "'");
  $fileinfo = mysql_fetch_array($fileinfo_result);
  
  // do expiry calculations
  $current_timestamp = time();
  $expiry_timestamp = $fileinfo["expiry"];
  
  if( (intval($expiry_timestamp) !== 0) && ($current_timestamp > $expiry_timestamp) ) {
?>
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
    <div id="box">
      <div class="notice">
        <h2>File has expired</h2>
        The file you are trying to download has expired and is no longer available.
      </div>
    </div>
<?php
  }else if( $fileinfo['deleted'] == 1 ) {
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
  }else{
    // Generate a random security string
    $security_id = sha1(time() . uniqid());
    $client_ip = getClientIP();
    $security_expire = time() + (get_config('download_sessionexpiry') * 60);
    
    // Create download session
    mysql_query("INSERT INTO `" . $table_prefix . "dlsession` (`id`, `session_id`, `access_id`, `ip_address`, `expiry`) VALUES (NULL, '" . $security_id . "', '" . $access_id . "', '" . $client_ip . "', " . $security_expire . ");");
    
    // set file information
    $file_name = $fileinfo["file_name"];
    $file_size = $fileinfo["file_size"];
    
    // calculate file size
    $file_size_class = new getFileSize();
    $size_text = $file_size_class->fileSizeConversion($file_size, 'B');
    
    // create file download url
    $file_download_url = "/file/" . $access_id . "/" . $security_id . "/" . rawurlencode($file_name);
?>
    <div id="info">
      <script type="text/javascript">
        document.write("Your download will begin immediately");
        setTimeout("window.location = '<?php print $file_download_url; ?>'", <?php print(get_config('download_waittime') * 1000); ?>);
      </script>
      <noscript>
        <a href="<?php print $file_download_url; ?>">Click here to start your download</a>
      </noscript>
    </div>
    <div id="file_info">
      File Name: <i><?php print shorten_title($file_name); ?></i><br />
      File Size: <?php print $size_text; ?>
    </div>
<?php
    // Is download sponsor enabled?
    if( get_config('download_sponsor') == 1 ) {
?>
    <div id="sponsor">
      <div class="message">Please support our sponsor. Thank you!</div>
      <div style="height: 250px;">
<?php
      // Print out download sponsor code
      print(stripslashes(get_config('download_sponsorcode')));
?>
      </div>
      <img src="/images/ad_box_top_left.gif" style="position:absolute; left:0px; top:0px;" />
      <img src="/images/ad_box_top_right.gif" style="position:absolute; right:0px; top:0px;" />
      <img src="/images/ad_box_bottom_left.gif" style="position:absolute; left:0px; bottom:0px;" />
      <img src="/images/ad_box_bottom_right.gif" style="position:absolute; right:0px; bottom:0px;" />
    </div>
<?php
    }
  }
}
?>
  </div>
<?php
include("./utils/templates/footer.php");
?>