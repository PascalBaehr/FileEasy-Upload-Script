<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print $site_name; ?> / <?php print $page_name; ?></title>
<meta name="keywords" content="<?php echo $site_name; ?>, upload, secure storage" />
<meta name="description" content="<?php echo ucfirst($site_name); ?> makes sharing files easy." />
<base href="http://<?php print $site_domain; ?>/" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="/stylesheets/style.css" media="screen" type="text/css" />
<?php if($css_type == "download") { ?>
<link rel="stylesheet" href="/stylesheets/download.css" media="screen" type="text/css" />
<?php } ?>
<script type="text/javascript" src="/javascript/functions.js"></script>
</head>
<body>

<div id="wrapper">
  <a href="/"><img src="/images/logo.png" id="logo" alt="<?php print $site_name; ?>"/></a>
