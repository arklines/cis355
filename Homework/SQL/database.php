
<?php
//$dbName: Database name which you use to store tables.
//$dbHost: Database host, this is normally "localhost".
//$dbUsername: Database username.
//$dbUserPassword: Database user's password.
class Database
{
    private static $dbName = 'arklines' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'arklines';
    private static $dbUserPassword = '560431';
     
    private static $cont  = null;
     
	 //This is the constructor of class Database. Since it is a static class, initialization of this class is not allowed. To prevent misuse of the class, we use a "die" function to remind users.
    public function __construct() {
        die('Init function is not allowed');
    }
     
	 //make sure only one PDO connection exist across the whole application.
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);  
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
       