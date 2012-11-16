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

// Connect to the MySQL database
mysql_connect($database_host, $database_user, $database_pass) or die("Could not connect to database: " . mysql_error());
mysql_select_db($database_name) or die("Could not select database: " . mysql_error());

// Assign important variables their setting values
$site_name = get_config('site_name');
$site_domain = get_config('site_domain');

// Call site cleanup function
cleanup();

// Get site configuration
function get_config($setting_name) {
  global $table_prefix;
  
  $setting_query = mysql_query("SELECT `value` FROM `" . $table_prefix . "settings` WHERE `setting` = '" . mysql_real_escape_string($setting_name) . "'");
  
  return mysql_result($setting_query, 0);
}

// Get clients IP address which is stored for security
function getClientIP() {
  $ip;
  
  if (getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  }else if(getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  }else if(getenv("REMOTE_ADDR")) {
    $ip = getenv("REMOTE_ADDR");
  }else{
    $ip = "UNKNOWN";
  }
  
  return $ip;
}

function generate_random_letters($length) {
  $random = '';
  for ($i = 0; $i < $length; $i++) {
    $random .= chr(rand(ord('a'), ord('z')));
  }
  
  return $random;
}

function id_is_in_files($access_id) {
  global $table_prefix;
  
  $check_query = mysql_query("SELECT * FROM `" . $table_prefix . "files` WHERE `access_id` = '" . mysql_real_escape_string($access_id) . "'");
  
  if( mysql_num_rows($check_query) ) {
    return true;
  }else{
    return false;
  }
}

function generate_access_id($id_length) {
  do {
    $unique_id = generate_random_letters($id_length);
  } while (id_is_in_files($unique_id));
  
  return $unique_id;
}

// Function to shorten long file names
function shorten_title($file_name) {
  if (strlen($file_name) > 28) {
    return substr($file_name, 0, 15) . '...' . substr($file_name, -13);
  }else{
    return $file_name;
  }
}

// Cleanup function used to remove expired files and download sessions
function cleanup() {
  global $table_prefix;
  
  // Perform cleanup of expired sessions
  mysql_query("DELETE FROM `" . $table_prefix . "dlsession` WHERE `expiry` < '" . time() . "';");
  
  // Perform cleanup of expired files, get expired files which have not been deleted
  $expired_files_result = mysql_query("SELECT `access_id`, `expiry` FROM `" . $table_prefix . "files` WHERE (`expiry` != '0' AND `expiry` <  '" . time() . "') AND (`deleted` = '0');");
  
  // Loop through expired files
  while( $file = mysql_fetch_array($expired_files_result, MYSQL_ASSOC) ) {
    // Delete file from server
    if( unlink("./uploads/" . $file['access_id']) ) {
      // Update file record, set deleted to true
      mysql_query("UPDATE `" . $table_prefix . "files` SET `deleted` = '1' WHERE `access_id` = '" . $file['access_id'] . "';");
    }
  }
  
  return true;
}

// Convert bytes to friendly format
function bytesToSize($bytes, $precision = 2) {
  $kilobyte = 1024;
  $megabyte = $kilobyte * 1024;
  $gigabyte = $megabyte * 1024;
  $terabyte = $gigabyte * 1024;
  
  if (($bytes >= 0) && ($bytes < $kilobyte)) {
    return $bytes . ' B';
  } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
    return round($bytes / $kilobyte, $precision) . ' KB';
  } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
    return round($bytes / $megabyte, $precision) . ' MB';
  } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
    return round($bytes / $gigabyte, $precision) . ' GB';
  } elseif ($bytes >= $terabyte) {
    return round($bytes / $terabyte, $precision) . ' TB';
  } else {
    return $bytes . ' B';
  }
}
?>