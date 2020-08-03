<?php
require_once('./vendor/autoload.php');

echo Config::get(['app','name']);
echo config(['app','name'],'my app','development');

echo Config::get('app.name');
echo config(['app','name'],'my app','development');



