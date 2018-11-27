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

define('SEND_EMAILS', false);
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_USERNAME', 'Ombudsman');
define('EMAIL_OMBUDSMAN', 'ombudsman@ombudsman.com');

define('HEADER_TEMPLATE', ABSPATH . '../inc/header.php');
define('FOOTER_TEMPLATE', ABSPATH . '../inc/footer.php');

define('LANGUAGE', getenv('OMBUD_LANGUAGE')); // EN or PT_BR
define('TIMEZONE', getenv('OMBUD_TIMEZONE');
define('DATEFORMAT', getenv('OMBUD_DATEFORMAT');

define('PAGINATOR_LIMIT', 8);
define('PAGINATOR_LINKS', 5);

define('DEBUG', true);
?>
