<?php
require_once('./vendor/autoload.php');
// configurations folder
define('CONFIG_PATH', __DIR__ . '/sample/config/');
define('DEFAULT_FILE',  'app');
// config('config_name','defualt_value','enviroment')

// config_name
// string like: database.mysql.driver 
// array like: ['database','mysql',driver']



// default_value(string,double,int .. act)
// envirment string: (development,production)

echo Config::get(['app','name']);
echo "<br>";
echo config(['app','not_found'],'this is default','development');
echo "<br>";
echo Config::get('app.name');
echo "<br>";
echo config(['app','name'],'my app','development');



