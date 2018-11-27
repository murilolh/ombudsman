<?php

define('DB_NAME', 'ombudsman');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

if ( !defined('BASEURL') )
	define('BASEURL', '/');

if ( !defined('SYSTEMNAME') )
	define('SYSTEMNAME', 'Ombudsman');

if ( !defined('DBAPI') )
	define('DBAPI', ABSPATH . '../inc/database.php');

define('SEND_EMAILS', false);
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_USERNAME', 'Ombudsman');
define('EMAIL_OMBUDSMAN', 'ombudsman@ombudsman.com');

define('HEADER_TEMPLATE', ABSPATH . '../inc/header.php');
define('FOOTER_TEMPLATE', ABSPATH . '../inc/footer.php');

define('LANGUAGE', 'EN'); // EN or PT_BR
define('TIMEZONE', 'America/Fortaleza');
define('DATEFORMAT', 'd/m/Y H:i:s');

define('PAGINATOR_LIMIT', 8);
define('PAGINATOR_LINKS', 5);

define('DEBUG', true);
?>
