<?php

//General Config
$config['BASE_PATH'] = '';

//Themes
$config['THEMEMODULE'] = 'blog';
$config['THEME'] = 'parsidefault';

//Database
$config['db']['host'] = 'localhost';
$config['db']['port'] = '3306';
$config['db']['dbname'] = '';
$config['db']['user'] = '';
$config['db']['pass'] = '';
$config['db']['prefix'] = '';

//Cache
$config['cache']['cache-control'] = 'private';
$config['cache']['max-age'] = '2592000999865';
$config['cache']['active'] = '0';

//Extensions auth
$config['ext']['png'] = 'image/png';
$config['ext']['jpg'] = 'image/jpeg';
$config['ext']['jpeg'] = 'image/jpeg';
$config['ext']['gif'] = 'image/gif';
$config['ext']['ico'] = 'image/vnd.microsoft.icon';
$config['ext']['svg'] = 'image/svg+xml';
$config['ext']['js'] = 'application/x-javascript';
$config['ext']['css'] = 'text/css';
$config['ext']['html'] = 'text/html';
$config['ext']['json'] = 'application/json';
$config['ext']['xml'] = 'application/xml';
$config['ext']['pdf'] = 'application/pdf';
$config['ext']['zip'] = 'application/zip';
$config['ext']['rar'] = 'application/x-rar-compressed';

//Security
$config['security']['allowedipadmin'] = '';
$config['security']['salt'] = '';

//Devices
$config['devices']['desktop'] = '1';
$config['devices']['mobile'] = '1';
$config['devices']['tablet'] = '1';
$config['devices']['tv'] = '0';
$config['devices']['defaultDevice'] = 'desktop';

//Dev
$config['dev']['status'] = 'dev';
$config['dev']['serialization'] = 'obj';

//Localization
$config['localization']['default_language'] = 'en_EN';
$config['localization']['timezone'] = 'America/Adak';

//Sessions
$config['session']['renew'] = '300';
$config['session']['maxlifetime'] = '86400';
$config['session']['depth'] = '0';

//Mailing conf
$config['mail']['adminMail'] = '';
$config['mail']['type'] = '';
$config['mail']['server'] = '';
$config['mail']['port'] = '25';

/* Modules */
$config['modules']['active']['core'] = '1';
$config['modules']['active']['blog'] = '1';
$config['modules']['default'] = 'blog';

$config['sitename'] = 'My WebSite';
