<?php

use Koj\Base\App;
use Koj\Base\HttpNotFoundException;
use Koj\Base\View;

defined('DEBUG') or define('DEBUG', false);
defined('ROOT_DIR') or define('ROOT_DIR', rtrim(__DIR__, '/'));
defined('APP_DIR') or define('APP_DIR', ROOT_DIR . '/app');
defined('CONFIG_DIR') or define('CONFIG_DIR', APP_DIR . '/config');
defined('TEMPLATES_PATH') or define('TEMPLATES_PATH', APP_DIR . '/views');


error_reporting( - DEBUG );
ini_set('display_errors', DEBUG);

try
{
    session_start();

    require_once ROOT_DIR . '/app/vendor/autoload.php';

    require_once APP_DIR . '/helpers/functions.php';

    (new App())->run();
}
catch(HttpNotFoundException $e) {
    View::showError($e->getMessage());
}
catch(Exception $e) {
    require_once TEMPLATES_PATH . '/chunks/header.php';
    echo $e->getMessage();
    require_once TEMPLATES_PATH . '/chunks/footer.php';
}