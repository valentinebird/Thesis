<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


use PHPUnit\Framework\TestCase;
class ConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        require '/home/thebwvas/madar-szakdolgozat.online/dbconfig.php';
        global $con;


        // Assert that the $con variable is an instance of mysqli
        $this->assertInstanceOf(mysqli::class, $con);

        // Check that the connection was successful (no errors)
        $this->assertEquals(0, mysqli_connect_errno());

        // Optionally, you can also check if the connection error is null
        $this->assertNull($con->connect_error);
    }


    public function testDatabaseConnectionFailure()
    {
        // Set incorrect database credentials
        $DATABASE_HOST = "invalid_host";
        $DATABASE_USER = "invalid_user";
        $DATABASE_PASS = "invalid_pass";
        $DATABASE_NAME = "invalid_db";

        // Attempt to establish a connection with incorrect credentials
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        // Assert that there was a connection error
        $this->assertNotNull($con->connect_error);

        // Optionally, check if the error code corresponds to access denied
        $this->assertEquals(1045, mysqli_connect_errno());
    }
}

