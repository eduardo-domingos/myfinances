<?php

require __DIR__.'/../../App/config/constants.php';

require __DIR__.'/../../App/debug/phpError.php';

require __DIR__.'/../../vendor/autoload.php';
    
\App\Libraries\Environment::loadVariables(__DIR__.'env/');