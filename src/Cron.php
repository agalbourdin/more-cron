<?php
namespace Agl\More\Cron;

use \Agl\Core\Agl,
	\Agl\Core\Data\Date as DateData,
	\Cron\CronExpression;

/**
 * Generic methods to manipulate dates.
 *
 * @category Agl_More
 * @package Agl_More_Cron
 * @version 0.1.0
 */

class Cron
{
    /**
     * List of cron jobs to run.
     *
     * @var array
     */
    private $_jobsToRun = array();

    /**
     * Class constructor. Load jobs to run.
     *
     * Load the cron jobs that should be runned and register them into the
	 * _jobsToRun array.
     */
    public function __construct($pJobs = NULL)
    {
    	if ($pJobs === NULL) {
    		$jobs = Agl::app()->getConfig('@module[' . Agl::AGL_MORE_POOL . '/cron]');
    	} else {
    		$jobs = $pJobs;
    	}

		if (! is_array($jobs)) {
			return $this;
		}

		foreach ($jobs as $expr => $job) {
            if ($this->_isDue($expr)) {
				$this->_jobsToRun[] = $job;
			}
		}
    }

	/**
	 * Check if a cron job should be run.
	 * The expression could be any cron expression or a predefined value :
	 * - @yearly
	 * - @annually
	 * - @monthly
	 * - @weekly
	 * - @daily
	 * - @hourly
	 *
	 * @param string $pCronExpr The cron expression
	 * @return bool
	 */
	private function _isDue($pCronExpr)
	{
		$currentDate = DateData::toTz(date('Y-m-d H:i'), 'Europe/Paris');
		$currentTime = strtotime($currentDate);

		$cron = CronExpression::factory($pCronExpr);

		return ($currentTime == $cron->getNextRunDate($currentDate, 0, true)->getTimestamp());
	}

	/**
	 * Load the cron jobs to run and execute them.
	 *
	 * @return int Number of runned tasks
	 */
	public function run()
	{
		$i = 0;

		foreach ($this->_jobsToRun as $job) {
			foreach ($job as $class => $methods) {
				if (is_array($methods)) {
	                $instance = Agl::getSingleton($class);
	                if ($instance) {
		                foreach ($methods as $method) {
		                    if (method_exists($instance, $method)) {
		                        $instance::$method();
		                        $i++;
		                    }
		                }
		            }
	            }
			}
		}

		$this->_jobsToRun = array();

		return $i;
	}

	/**
	 * Return the list of jubs to run.
	 *
	 * @return array
	 */
	public function getJobsToRun()
	{
		return $this->_jobsToRun;
	}
}
