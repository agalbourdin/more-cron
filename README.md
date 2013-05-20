More/Cron
=========

Additional Cron module for AGL.

## Installation

Add the following package to the `require` section of your application's `composer.json` file:

	"agl/more-cron": "*"

Then run the following command:

	php composer.phar update

## Configuration

Edit `app/etc/config/more/cron/main.php` to create your Cron Jobs.

You will find an example in `app/etc/config/more/cron/samples/main.sample.php`:

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

## Usage

To run dued Cron Jobs (based on the current date):

	Agl::getInstance('more/cron')->run();
