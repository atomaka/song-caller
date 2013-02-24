<?php
require 'vendor/autoload.php';
require 'vendor/twilio/sdk/Services/Twilio.php';

use Symfony\Component\Yaml\Yaml;

$settings = Yaml::parse('conf/settings.yaml');

$client = new Services_Twilio(
  $settings['twilio']['sid'],
  $settings['twilio']['token']
);

try {
  $call = $client->account->calls->create(
    $settings['application']['from'],
    $settings['application']['to'],
    $settings['application']['xml']
  );
} catch(Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
