<?php

include "pdo_ConStart.php";

$dbh->query("CREATE TABLE qarows (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	creationTimeUnicode INT(11) UNSIGNED NULL,
	creationTimeNatural TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updateTimeUnicode INT(11) UNSIGNED,
	updateTimeNatural TIMESTAMP NULL,
	questions TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci, 
	answers TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	usr VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci
)");
/* ALTER TABLE qarows ADD title varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci */ 
// Questions and answers should also be NULL
?>

subject VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci