<?php
$currentDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

return array(

    // Copy configuration file, sample and callable PHP script.
    'file:copy' => array(
        array(
            $currentDir . 'app/etc/config/more/cron/main.php',
            APP_PATH    . 'app/etc/config/more/cron/main.php'
        ),

        array(
            $currentDir . 'app/etc/config/more/cron/samples/main.sample.php',
            APP_PATH    . 'app/etc/config/more/cron/samples/main.sample.php'
        ),

        array(
            $currentDir . 'cron.php',
            APP_PATH    . 'cron.php'
        ),
    )
);
