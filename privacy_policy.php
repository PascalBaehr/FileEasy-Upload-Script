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

$page_name = "privacy policy";
include("./utils/templates/header.php");
?>
  <div id="content">
    <div id="long_text">
      <h1>Privacy Policy</h1>
      No uploaded file is advertised to the public and no file can be accessed without its private address.
      <h2>File Privacy</h2>
      The name, type, contents, and origin of your file are not saved, reviewed, or analyzed. The only monitoring that takes place are our automated tallies of file uploads and our automated cleaning of expired files.
      <h2>Transfer and Storage Security</h2>
      We take appropriate possible security measures on our server in order to ensure the privacy and security of our user's data, and safeguard against the loss of data, inaccurate use of information, as well as file damage. Files saved for transferring are available for viewing only to our representatives or via the link that is given to the user who uploaded the file. Files saved on our server are deleted automatically after a certain period of time.
      <h2>File Expiration</h2>
      If selected during upload, all uploaded files are designated to expire at the point in time chosen (anywhere from 30 minutes to 1 week); after a file has expired, it becomes inaccessible to the public and is permanently removed from our systems. If a file has been set to never expire, then it will remain on our servers until it 30 days of download inactivity.
    </div>
  </div>
<?php
include("./utils/templates/footer.php");
?>