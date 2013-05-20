<?php
return array(

	/**
	 * UserModel::deleteInactive(), UserModel::sendDailyMail() and
	 * LogModel::clean() will be called everyday at 1am.
	 */
	'0 1 * * *' => array(
		'model/user' => array(
			'deleteInactive',
			'sendDailyMail'
		),

		'model/log' => array(
			'clean'
		)
	),

	/**
	 * SystemBackupHelper::backupDb() will be called every hour.
	 */
	'@hourly' => array(
		'helper/system/backup' => array(
			'backupDb'
		)
	)

);
