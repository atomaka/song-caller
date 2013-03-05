<?php

$id = isset($_GET['id']) ? $_GET['id'] : 'bad';

if(!filter_var($id, FILTER_VALIDATE_INT)) {
  die("\n");
}

$db = new PDO('sqlite:db/songcaller.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = $db->query("SELECT mp3 FROM calls WHERE id=$id LIMIT 1");

$row = $result->fetch();

header('Content-Type: text/xml');
?>
<Response>
    <Play><?php echo $row['mp3']; ?></Play>
</Response>