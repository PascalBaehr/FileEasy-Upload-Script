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

if($_POST['submit'] == "Agree") {
  header("Location: ./step2-requirements.php");
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
    <h2>Unchained Media Software License Agreement</h2>
<?php
if(isset($_POST['submit'])) {
  if($_POST['submit'] !== "Agree") {
    print("    <div class=\"error\"><b>Error:</b> You must accept the license agreement to continue.</div>");
  }
}
?>
    <form method="post" action="./index.php" id="login">
      <textarea rows="15" cols="80%" style="border: 1px dashed #CC3300; padding: 10px 10px 10px 10px;" readonly="readonly">            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
</textarea><br />
      <input type="submit" name="submit" value="Agree" class="submit" />
      <input type="submit" name="submit" value="Disagree" class="submit" />
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
