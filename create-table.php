<?php
  $db = new PDO('sqlite:db/songcaller.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $db->exec('create table calls (
		id integer PRIMARY KEY,
		phone integer,
		schedule varchar(50),
		mp3 varchar(255)
		);'
  );
