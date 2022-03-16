<?php


$question = "You are a noob";
$answer = "I know.";

//Connect to SQL
$con=mysqli_connect("localhost","memory",
	"V0kQMRwf2mTx","memory");

if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// End

$sql="CREATE TABLE `members` (
  `id` int(11) NOT NULL auto_increment,
  `usr` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `pass` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `regIP` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `dt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `usr` (`usr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";


if (mysqli_query($con,$sql)) {
  echo "Table persons created successfully";
} else {
  echo "Error creating table: " . mysqli_error($con);

}





mysqli_close($con);


?>