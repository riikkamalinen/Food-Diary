<?php
class Database {
  private $connection;

  public function __construct($url, $username, $password, $db) {
    $this->connection = new mysqli($url, $username, $password, $db);
  }

  public function query($string, $data = "") {
    if (!empty($data)) {
      $statement = $this->connection->prepare($string);
      $tmp_data = array();
      foreach($data as $key => $value) $tmp_data[$key] = &$data[$key];
      call_user_func_array(array($statement, "bind_param"), $tmp_data);
      $statement->execute();
      return $statement->get_result();
    } else {
      return $this->connection->query($string);
    }
  }

}
?>
