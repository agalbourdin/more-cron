More/Cron
=========

Additional Cron module for AGL.

## Installation

Add the following package to the `require` section of your application's `composer.json` file:

	"agl/more-cron": "*"

Then run the following command:

	php composer.phar update

## Configuration

Edit `app/etc/config/more/cron.json` to create your Cron Jobs.

Example:

	{
		"0 1 * * *": {
			"model/user": [
				"deleteInactive",
				"sendDailyMail"
			],

			"model/log": [
				"clean"
			]
		},

		"@hourly": {
			"helper/system/backup": [
				"backupDb"
			]
		},
	}

* UserModel::deleteInactive(), UserModel::sendDailyMail() and LogModel::clean() will be called everyday at 1 am
* SystemBackupHelper::backupDb() will be called every hour

## Usage

To run dued Cron Jobs (based on the current date):

	$cron = Agl::getInstance('more/cron');
	$cron->run();

A PHP script that will be called by Cron can look like this:

	<?php
	require('./app/php/run.php');
	$cron = Agl::getInstance('more/cron');
	$cron->run();
