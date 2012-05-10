<?php

require 'dbconfig.php';

class User {

    function checkUser($uid , $email, $username) 
	{
        $query = mysql_query("SELECT * FROM `signups` WHERE uid = '$uid'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `signups` ( uid,username,email ) VALUES ($uid,'$username','$email')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `signups` WHERE uid = '$uid'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }
}

?>
