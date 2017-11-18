<?php
// @author: Abu Sadat Mohammed Yasin, Dhaka, Bangladesh. <abusadatyasin@gmail.com>

require 'vendor/autoload.php';

require 'config/slim-app-config.php';

require 'routes/hello.php';

require 'routes/file-upload.php';


$app->run();