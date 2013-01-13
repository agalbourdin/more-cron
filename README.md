More/Cron
=========

Additional Cron module for AGL.

## Installation

Add the following package to the `require` section of your application's `composer.json` file:

	"agl/more-cron": "*"

## Configuration

In your application, create a file `app/etc/config/more/cron.json`. Cron Jobs will be declared in this file.

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

**Instantiate Cron class:**

	$cron = Agl::getInstance('more/cron');

**Run Cron Jobs**

	$cron->run();

Cron Jobs will be automatically runned if dued, based on the current date.
