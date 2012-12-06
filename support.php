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

$page_name = "support";
include("./utils/templates/header.php");
?>
  <div id="content">
    <div id="long_text">
      <h1>Support</h1>
      <?php print $site_name; ?> is a quick and super easy way to simply upload files, without all the complicated bits based on the KISS (Keep it simple, Stupid!) principle.
      <h2>General Queries</h2>
      To get in touch with the developers behind <?php print $site_name; ?>, drop an email to <a href="mailto:<?php print(get_config('admin_email')); ?>?subject=<?php print ("RE: " . ucfirst($site_name) . " Query"); ?>"><?php print(get_config('admin_email')); ?></a> with the subject "RE: <?php print ucfirst($site_name); ?> Query".
      <h2>Abuse</h2>
      To report abuse of our Terms of Service, send us an email at <a href="mailto:<?php print(get_config('admin_email')); ?>?subject=<?php print ("RE: " . ucfirst($site_name) . " Abuse"); ?>"><?php print(get_config('admin_email')); ?></a> with the subject "RE: <?php print ucfirst($site_name); ?> Abuse".
    </div>
  </div>
<?php
include("./utils/templates/footer.php");
?>
