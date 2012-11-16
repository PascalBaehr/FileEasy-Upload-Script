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

if(isset($_POST['check-connection'])) {
  if(!@mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password'])) {
    $error = "An error occured connecting to the database server, check your server hostname and credentials.";
    
    $showdbform = true;
    $showwriteform = false;
    $showtableform = false;
  }else if(!@mysql_select_db($_POST['database'])) {
    $error = "An error occured selecting the database, verify it exists and you have permission to access it.";
    
    $showdbform = true;
    $showwriteform = false;
    $showtableform = false;
  }else{
    // Write database details to config.php file
    $config_file = "../utils/config.php";
    $file_handle = fopen($config_file, 'w');
    $config_data = "<?php\n$"."database_host = \"".mysql_real_escape_string($_POST['hostname'])."\";\n$"."database_user = \"".mysql_real_escape_string($_POST['username'])."\";\n$"."database_pass = \"".mysql_real_escape_string($_POST['password'])."\";\n$"."database_name = \"".mysql_real_escape_string($_POST['database'])."\";\n$"."table_prefix = \"".$_POST['prefix']."\";\n?>";
    fwrite($file_handle, $config_data);
    fclose($file_handle);
    
    $showdbform = false;
    $showwriteform = true;
    $showtableform = false;
  }
}else if(isset($_POST['create-tables'])) {
  include("../utils/config.php");
  
  mysql_connect($database_host, $database_user, $database_pass);
  mysql_select_db($database_name);
  
  $handle = fopen("./database.sql", "r");
  if($handle) {
    while (!feof($handle)) {
      $query .= fgets($handle, 4096);
      if (substr(rtrim($query), -1) == ";") {
        $query = str_replace("{DATABASE_NAME}", $database_name, $query);
        $query = str_replace("{TABLE_PREFIX}", $table_prefix, $query);
        mysql_query($query);
        unset($query);
      }
    }
    fclose($handle);
  }
  
  $showdbform = false;
  $showwriteform = false;
  $showtableform = true;
}else if(isset($_POST['setup-script'])) {
  header("Location: ./step4-setup.php");
}else{
  $showdbform = true;
  $showwriteform = false;
  $showtableform = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Database Setup :: Easy File Upload Script Installation</title>
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
    <h2>Database Setup</h2>
<?php
if(isset($error)) {
  print("    <div class=\"error\"><b>Error:</b> ".$error."</div>");
}
if($showdbform == true) {
?>
    <p>Enter your database details below, it will be written to the config.php file.</p>
    <form method="post" action="./step3-database.php" id="check-connection">
      <input type="hidden" name="check-connection" value="1" />
      <label for="hostname">Database Server</label><br />
      <input type="text" name="hostname" id="hostname" size="40" tabindex="1" class="w40" value="<?php if(isset($_POST['hostname'])) { print $_POST['hostname']; }else{ print "localhost"; } ?>" /><br />
      <span class="supporting">The database server hostname, usually <i>localhost</i>.</span><br /><br />
      <label for="username">Database Username</label><br />
      <input type="text" name="username" id="username" size="40" tabindex="1" class="w40" value="<?php if(isset($_POST['username'])) { print $_POST['username']; } ?>" /><br />
      <span class="supporting">The database server username.</span><br /><br />
      <label for="password">Database Password</label><br />
      <input type="text" name="password" id="password" size="40" tabindex="1" class="w40" value="<?php if(isset($_POST['password'])) { print $_POST['password']; } ?>" /><br />
      <span class="supporting">The database server password.</span><br /><br />
      <label for="database">Database Name</label><br />
      <input type="text" name="database" id="database" size="40" tabindex="1" class="w40" value="<?php if(isset($_POST['database'])) { print $_POST['database']; } ?>" /><br />
      <span class="supporting">The database's name.</span><br /><br />
      <label for="prefix">Table Prefix</label><br />
      <input type="text" name="prefix" id="prefix" size="40" tabindex="1" class="w40" value="<?php if(isset($_POST['prefix'])) { print $_POST['prefix']; } ?>" /><br />
      <span class="supporting">The table prefix in the database.</span><br /><br />
      <input type="submit" name="submit" value="Check Connection & Write Config" class="submit" />
    </form>
<?php
}else if($showwriteform == true) {
?>
    <p>Your database details were correct and have been written to the config.php file, click the button below to create the tables.</p>
    <form method="post" action="./step3-database.php" id="create-tables">
      <input type="hidden" name="create-tables" value="1" />
      <b>Database Server</b><br />
      <?php print $_POST['hostname']; ?><br /><br />
      <b>Database Username</b><br />
      <?php print $_POST['username']; ?><br /><br />
      <b>Database Password</b><br />
      <?php print $_POST['password']; ?><br /><br />
      <b>Database Name</b><br />
      <?php print $_POST['database']; ?><br /><br />
      <b>Table Prefix</b><br />
      <?php if($_POST['prefix'] == "") { print "none"; }else{ print $_POST['prefix']; } ?><br /><br />
      <input type="submit" name="submit" value="Create Database Tables" class="submit" />
    </form>
<?
}else if($showtableform == true) {
?>
    <p>The tables have now been created in the database, click the button below to setup the script.</p>
    <form method="post" action="./step3-database.php" id="setup-script">
      <input type="hidden" name="setup-script" value="1" />
      <input type="submit" name="submit" value="Setup Script" class="submit" />
    </form>
<?php
}
?>
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
