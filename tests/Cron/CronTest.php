<?php
class CronTest
    extends PHPUnit_Framework_TestCase
{
    protected static $_instance = NULL;

    public static function task() { }

    public static function setUpBeforeClass()
    {
        self::$_instance = new \Agl\More\Cron\Cron(array(
            '*/1 * * * *' => array(
                'CronTest' => array(
                    'task', // valid
                    'other'
                ),
                'Test' => array(
                    'task'
                )
            )));
    }

    public function testRun()
    {
        $this->assertEquals(1, self::$_instance->run());
    }

    public function testCleaned()
    {
        $this->assertEquals(array(), self::$_instance->getJobsToRun());
    }
}
