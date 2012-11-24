<?php
namespace Agl\More\Cron;

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
     * Library filename.
     */
    const LIB = 'cron.phar';

    /**
     * List of cron jobs to run.
     *
     * @var array
     */
    private $_jobsToRun = array();

	/**
	 * Cron constructor.
	 * Load the CronExpression library.
	 */
	public function __construct()
	{
		\Agl::loadModuleLib(__DIR__, self::LIB);
	}

	/**
	 * Load the cron jobs that should be runned and register them into the
	 * _jobsToRun class array.
	 *
	 * @return Cron
	 */
	private function _loadJobsToRun()
	{
		$jobs = \Agl::app()->getConfig('@module[' . \Agl::AGL_MORE_POOL . '/cron]/job', true);

		foreach ($jobs as $job) {
			if (is_array($job)
                and isset($job['instance'])
                and isset($job['method'])
                and isset($job['cron_expr'])) {
                if ($this->_isDue($job['cron_expr'])) {
					$this->_jobsToRun[] = $job;
				}
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
		$date = \Agl::getSingleton(\Agl::AGL_CORE_DIR . '/data/date');
		$currentDate = $date::toTz(date('Y-m-d H:i'));
		$currentTime = strtotime($currentDate);

		$cron = \Cron\CronExpression::factory($pCronExpr);

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

		foreach ($this->_jobsToRun as $key => $job) {
            $instance = \Agl::getSingleton($job['instance']);
            if ($instance and method_exists($instance, $job['method'])) {
                $instance::$job['method']();
            }
		}

		$this->_jobsToRun = array();

		return $this;
	}
}
