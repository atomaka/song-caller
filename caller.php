<?php
require 'vendor/autoload.php';
require 'vendor/twilio/sdk/Services/Twilio.php';

use Symfony\Component\Yaml\Yaml;

$crontab = new \HybridLogic\Cron\Crontab;

$db = new PDO('sqlite:db/songcaller.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$settings = Yaml::parse('conf/settings.yml');
$client = new Services_Twilio(
  $settings['twilio']['sid'],
  $settings['twilio']['token']
);

$result = $db->query('SELECT id, schedule, phone FROM calls');

foreach($result as $row) {
  $crontab->add_job(
    \HybridLogic\Cron\Job::factory('test')
      ->on($row['schedule'])
      ->trigger(function() use($settings, $client, $row) {
        $call = $client->account->calls->create(
          $settings['application']['from'],
          $row['phone'],
          $settings['application']['generator'] . '?id=' . $row['id']
        );
      })
  );
}

$crontab->run();

$db = null;
