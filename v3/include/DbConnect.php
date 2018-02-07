<?php

//Class DbConnect
class DbConnect
{
    //Variable to store database link
    private $con;

    //Class constructor
    function __construct()
    {

    }

    //This method will connect to the database
    function connect()
    {
        //Including the constants.php file to get the database constants
        $db_username = 'root';
        $db_password = '';
        $db_host = 'localhost';
        $db_name = 'db_emr';

        //connecting to mysql database
        $this->con = new mysqli($db_host, $db_username, $db_password, $db_name);

        //Checking if any error occured while connecting
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        //finally returning the connection link 
        return $this->con;
    }

}