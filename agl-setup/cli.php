<?php
$currentDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

return array(

    // Copy configuration file, sample and callable PHP script.
    'file:copy' => array(
        array(
            $currentDir . 'app/etc/config/more/cron/main.php',
            $appPath    . 'app/etc/config/more/cron/main.php'
        ),

        array(
            $currentDir . 'app/etc/config/more/cron/samples/main.sample.php',
            $appPath    . 'app/etc/config/more/cron/samples/main.sample.php'
        ),

        array(
            $currentDir . 'cron.php',
            $appPath    . 'cron.php'
        ),
    )
);
