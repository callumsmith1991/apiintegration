<?php

// session_start();

class Db
{

  public $connection;
  private $db_host = 'localhost';
  private $db_user = 'root';
  private $db_password = '';
  public $db_name = 'silverbullet';
  private static $instance = null;


  public function __construct()
  {

    try {
      $this->connection = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;", $this->db_user, $this->db_password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $this->error($e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new Db();
    }

    return self::$instance;
  }

  private function error($error)
  {

    die($error);
  }

  public function connect()
  {

    return $this->connection;
  }

  public function query($query, $params = array())
  {

    try {

      $stmt = $this->connection->prepare($query);

      if (count($params) > 0) {

        foreach ($params as $k => &$v) {

          $stmt->bindParam($k, $v);
        }
      }

      $stmt->execute();


      $row_count = $stmt->rowCount();

      if ($row_count > 0) {

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

      } else {

        return false;
      }
    } catch (PDOException $e) {

      // echo $e . '<br><br>';

    }
  }
}
