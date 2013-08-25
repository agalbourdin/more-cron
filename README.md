AGL Framework - More/Cron
=========================

Additional Cron module for [AGL Framework](https://github.com/agl-php/agl-app).

## Installation

Run the following command in the root of your AGL application:

	php composer.phar require agl/more-cron:*

## Configuration

Edit `app/etc/config/more/cron/main.php` to create your Cron Jobs.

You will find an example in `app/etc/config/more/cron/samples/main.sample.php`.

## Usage

To run dued Cron Jobs (based on the current date):

	Agl::getInstance('more/cron')->run();
