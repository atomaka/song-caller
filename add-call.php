<?php

if(count($argv) != 4) {
  die("Usage: php ./add-call 15555555555 '* * * * *' http://domain.com/file.xml\n");
}

$phone = $argv[1];
$schedule = $argv[2];
$xml = $argv[3];

if(preg_match('/^\d{11}$/', $phone) != 1) {
  die("Phone should be all numbers with no symbols. ex: 15555555555\n");
}

if(count(split(' ', $schedule)) != 5) {
  die("Schedule requires a properly formed cron schedule.\n");
}

if(!filter_var($xml, FILTER_VALIDATE_URL)) {
  die("XML must be a vaild url.\n");
}

try {
  $db = new PDO('sqlite:db/songcaller.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("PDOException (connect): " . $e->getMessage() . "\n");
}
try {
  $db->exec("INSERT INTO calls (phone, schedule, xml) VALUES($phone, '$schedule', '$xml')");
} catch(PDOException $e) {
  die("PDOException (query): " . $e->getMessage() . "\n");
}
echo "Successfully added call.\n";