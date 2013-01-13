<?php
namespace Agl\More\Cron;

use \Agl\Core\Agl,
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
	 * Load the cron jobs that should be runned and register them into the
	 * _jobsToRun class array.
	 *
	 * @return Cron
	 */
	private function _loadJobsToRun()
	{
		$jobs = Agl::app()->getConfig('@module[' . Agl::AGL_MORE_POOL . '/cron]');
		if (! is_array($jobs)) {
			return $this;
		}

		foreach ($jobs as $expr => $job) {
            if ($this->_isDue($expr)) {
				$this->_jobsToRun[] = $job;
			}
		}

		return $this;
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
		$date        = Agl::getSingleton(Agl::AGL_CORE_DIR . '/data/date');
		$currentDate = $date::toTz(date('Y-m-d H:i'));
		$currentTime = strtotime($currentDate);

		$cron = CronExpression::factory($pCronExpr);

		return ($currentTime == $cron->getNextRunDate($currentDate, 0, true)->getTimestamp());
	}

	/**
	 * Load the cron jobs to run and execute them.
	 *
	 * @return Cron
	 */
	public function run()
	{
		$this->_loadJobsToRun();

		foreach ($this->_jobsToRun as $job) {
			foreach ($job as $class => $methods) {
				if (is_array($methods)) {
	                $instance = Agl::getSingleton($class);
	                foreach ($methods as $method) {
	                    if ($instance and method_exists($instance, $method)) {
	                        $instance::$method();
	                    }
	                }
	            }
			}
		}

		$this->_jobsToRun = array();

		return $this;
	}
}
