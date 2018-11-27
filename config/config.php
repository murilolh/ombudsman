<?php

define('DB_NAME', getenv('OMBUD_DB_NAME'));
define('DB_USER', getenv('OMBUD_DB_USER'));
define('DB_PASSWORD', getenv('OMBUD_DB_PASSWORD'));
define('DB_HOST', getenv('OMBUD_DB_HOST'));

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

if ( !defined('BASEURL') )
	define('BASEURL', getenv('OMBUD_BASE_URL'));

if ( !defined('SYSTEMNAME') )
	define('SYSTEMNAME', 'Ombudsman');

if ( !defined('DBAPI') )
	define('DBAPI', ABSPATH . '../inc/database.php');

define('SEND_EMAILS', getenv('OMBUD_SEND_EMAILS'));
define('SMTP_HOST', getenv('OMBUD_SMTP_HOST'));
define('SMTP_PORT', getenv('OMBUD_SMTP_PORT'));
define('SMTP_USER', getenv('OMBUD_SMTP_USER'));
define('SMTP_PASS', getenv('OMBUD_SMTP_PASS'));
define('SMTP_USERNAME', getenv('OMBUD_SMTP_USERNAME'));
define('EMAIL_OMBUDSMAN', getenv('OMBUD_EMAIL_OMBUDSMAN'));

define('HEADER_TEMPLATE', ABSPATH . '../inc/header.php');
define('FOOTER_TEMPLATE', ABSPATH . '../inc/footer.php');

define('LANGUAGE', getenv('OMBUD_LANGUAGE')); // EN or PT_BR
define('TIMEZONE', getenv('OMBUD_TIMEZONE'));
define('DATEFORMAT', getenv('OMBUD_DATEFORMAT'));

define('PAGINATOR_LIMIT', getenv('OMBUD_PAGINATOR_LIMIT'));
define('PAGINATOR_LINKS', getenv('OMBUD_PAGINATOR_LINKS'));

define('DEBUG', getenv('OMBUD_DEBUG'));
?>
