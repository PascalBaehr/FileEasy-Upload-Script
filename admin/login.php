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


if(isset($_SESSION['adminsession'])) {
  header("location: ./index.php");
}

if(isset($_POST['login'])) {
  if($_POST['username'] == "") {
    $error = "Please enter a username.";
  }else if($_POST['password'] == "") {
    $error = "Please enter a password.";
  //}else if(!mysql_num_rows(mysql_query("SELECT * FROM " . $table_prefix . "settings WHERE admin_user = '" . mysql_real_escape_string($_POST['username']) . "' AND admin_pass = '" . $_POST['password'] . "'"))) {
  }else if( ( $_POST['username'] !== get_config('admin_username') ) || ( $_POST['password'] !== get_config('admin_password') ) ) {
    $error = "Those login credentials are incorrect.";
  }else{
    $_SESSION['adminsession'] = true;
    header("Location: ./index.php");
  }
}

$pagename = "Log In";
include("./admin_header.php");
?>
  <div id="content">
    <h2>Log In</h2>
<?php
if(isset($error)) {
  print("    <div class=\"error\"><b>ERROR:</b> ".$error."</div>");
}
?>
    <form method="post" action="./login.php" id="login">
      <input type="hidden" name="login" value="1" />
      <label for="username">Username</label><br />
      <input type="text" name="username" id="username" value="<?php echo $_POST['username']; ?>" size="40" class="w40" /><br /><br />
      <label for="password">Password</label><br />
      <input type="password" name="password" id="password" value="" size="40" maxlength="60" class="w40" /><br />
      <input type="submit" value="Log In" class="submit" />
    </form>
  </div>
<?php
include("./admin_footer.php");
?>
