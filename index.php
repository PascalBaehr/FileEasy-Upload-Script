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

$page_name = "file sharing made easy";
include("./utils/templates/header.php");
?>
  <div id="content">
    <img src="/images/instructions.gif" id="instructions" alt="Step 1: Upload your file.  Step 2: Share your private link."/>
<?php
$show_upload = true;
$show_success = false;

if($_POST["uploadform"] == 1) {
  // Check for no file
  if((!empty($_FILES["file"])) && ($_FILES["file"]["error"] == 0)) {
    // Check to file over upload limit
    if( ($_FILES["file"]["error"] == 1) || ($_FILES["file"]["size"] > ( get_config('upload_sizelimit') * 1024000 )) ) {
      print("    <div id=\"notice\">\n");
      print("      <span>The uploaded file can not be over " . get_config('upload_sizelimit') . "MB.</span>\n");
      print("    </div>\n");
      
      $show_upload = true;
      $show_success = false;
    // Check for upload error
    }else if(($_FILES["file"]["error"] == 3)) {
      print("    <div id=\"notice\">\n");
      print("      <span>The file was only partially uploaded. Please try again.</span>\n");
      print("    </div>\n");
      
      $show_upload = true;
      $show_success = false;
    // Check for upload error
    }else if(($_FILES["file"]["error"] == 7)) {
      print("    <div id=\"notice\">\n");
      print("      <span>An error occured saving the file. Please try again.</span>\n");
      print("    </div>\n");
      
      $show_upload = true;
      $show_success = false;
    // Everything is fine
    }else{
      // Generate random file ID
      $file_id = generate_access_id(6);
      $client_ip = getClientIP();
      
      // Calculate file name
      $file_name = $_FILES["file"]["name"];
      $name_text = $file_name;
      
      // Calculate file type
      $file_type = $_FILES["file"]["type"];
      
      // Calculate file size
      $file_size = $_FILES["file"]["size"];
      $file_size_class = new getFileSize();
      $file_size_text = $file_size_class->fileSizeConversion($file_size, 'B');
      
      // Calculate file expiry time
      switch ($_POST["expire_time"]) {
        case 1800: // 30 minutes
          $file_expiry = time() + 1800;
          $expiry_text = "in 30 minutes";
          break;
        case 3600: // 1 hour
          $file_expiry = time() + 3600;
          $expiry_text = "in 1 hour";
          break;
        case 18000: // 5 hours
          $file_expiry = time() + 18000;
          $expiry_text = "in 5 hours";
          break;
        case 86400: // 1 day
          $file_expiry = time() + 86400;
          $expiry_text = "in 1 day";
          break;
        case 172800: // 2 days
          $file_expiry = time() + 172800;
          $expiry_text = "in 2 days";
          break;
        case 259200: // 3 days
          $file_expiry = time() + 259200;
          $expiry_text = "in 3 days";
          break;
        case 345600: // 4 days
          $file_expiry = time() + 345600;
          $expiry_text = "in 4 days";
          break;
        case 432000: // 5 days
          $file_expiry = time() + 432000;
          $expiry_text = "in 5 days";
          break;
        case 518400: // 6 days
          $file_expiry = time() + 518400;
          $expiry_text = "in 6 days";
          break;
        case 604800: // 1 week
          $file_expiry = time() + 604800;
          $expiry_text = "in 1 week";
          break;
        case 0: // never expire
          $file_expiry = 0;
          $expiry_text = "never";
          break;
        default: // 30 minutes
          $file_expiry = time() + 1800;
          $expiry_text = "in 30 minutes";
      }
      
      // Store uploaded file on server
      if(!move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/" . $file_id)) {
        print("    <div id=\"notice\">\n");
        print("      <span>An error occured saving the file. Please try again.</span>\n");
        print("    </div>\n");
        
        $show_upload = true;
        $show_success = false;
      }
      
      // Insert file info into database
      mysql_query("INSERT INTO `" . $table_prefix . "files` (`id`, `access_id`, `file_name`, `file_type`, `file_size`, `expiry`, `ip_address`, `timestamp`) VALUES (NULL, '" . $file_id . "', '" . $file_name . "', '" . $file_type . "', '" . $file_size . "', " . $file_expiry . ", '" . $client_ip . "', " . time() . ");");
      
      $email_subject = "Download " . $name_text . " from " . $site_name;
      $email_body = "To download " . $name_text . " from " . $site_name . ", click on this link, or paste it in your web browser: http://" . $site_domain . "/" . $file_id;
      
      $show_upload = false;
      $show_success = true;
    }
  }else{
    print("    <div id=\"notice\">\n");
    print("      <span>You did not select a file to upload.</span>\n");
    print("    </div>\n");
      
    $show_upload = true;
    $show_success = false;
  }
}

if($show_success == true) {
?>
    <div id="box">
      <div id="filename_label">
        <?php print shorten_title($name_text); ?>
      </div>
      <div id="download_instructions">
        This is your download URL.
        It expires <?php print $expiry_text; ?>.
      </div>
      <input type="text" id="download_url" value="http://<?php print $site_domain . "/" . $file_id; ?>" onkeyup="select_text();" onclick="select_text();" readonly="readonly"/>
      <script type="text/javascript">select_text();</script>
      <div id="file_size">File Size: <?php print $file_size_text; ?></div>
      <div id="email_link">
        <a href="mailto:?subject=<?php print $email_subject; ?>&amp;body=<?php print $email_body; ?>">Email this link</a>
        &nbsp;|&nbsp;
        <a href="/">Upload another file</a>
      </div>
    </div>
<?php
}

if($show_upload == true) {
?>
    <div id="box">
      <form enctype="multipart/form-data" action="/" method="post">
        <input type="hidden" name="uploadform" value="1"/>
        <label id="file_label" for="file">File:</label>
        <div id="limit_label"><?php print (get_config('upload_sizelimit')); ?>MB limit</div>
        <input type="file" name="file" id="file"/>
        <label id="expire_label" class="label">Expire in:</label>
        <select id="expire_in" name="expire_time">
          <option value="1800">30 minutes</option>
          <option value="3600">1 hour</option>
          <option value="18000">5 hours</option>
          <option value="86400">1 day</option>
          <option value="172800">2 days</option>
          <option value="259200">3 days</option>
          <option value="345600">4 days</option>
          <option value="432000">5 days</option>
          <option value="518400">6 days</option>
          <option value="604800">1 week</option>
          <option value="0" selected="selected">never</option>
        </select>
        <input type="image" src="/images/upload.gif" id="upload_button" onclick="document.getElementById('upload_button').style.display='none'; document.getElementById('upload_notification').style.display='inline';"/>
        <div id="upload_notification">
          <img src="/images/progress.gif" id="progress_bar" alt="Uploading..."/><br /><br />
          Upload in progress.<br/>
          This may take a moment.
        </div>
      </form>
    </div>
<?php
}
?>
  </div>
<?php
include("./utils/templates/footer.php");
?>