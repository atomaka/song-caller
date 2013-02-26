<?php
require 'vendor/autoload.php';
require 'vendor/twilio/sdk/Services/Twilio.php';

use Symfony\Component\Yaml\Yaml;
$crontab = new \HybridLogic\Cron\Crontab;

$settings = Yaml::parse('conf/settings.yaml');
$client = new Services_Twilio(
  $settings['twilio']['sid'],
  $settings['twilio']['token']
);



$crontab->add_job(
  \HybridLogic\Cron\Job::factory('test')
    ->on('0 10-16 * * *')
    ->trigger(function() use($settings, $client) {
      $call = $client->account->calls->create(
        $settings['application']['from'],
        $settings['application']['to'],
        $settings['application']['xml']
      );
    })
);

$crontab->run();
