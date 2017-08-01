<?php

class User extends Item {
  public $username = "varchar(255) NOT NULL";
  public $password = "varchar(255) NOT NULL DEFAULT ''";
  public $initials = "varchar(50) DEFAULT NULL";
  public $group_id = "tinyint(3) UNSIGNED NOT NULL DEFAULT '1'";
  public $job_description = "tinyint(3) UNSIGNED";
  public $first_name = "varchar(255) NOT NULL";
  public $last_name = "varchar(255) NOT NULL";
  public $times_logged = "int(10) UNSIGNED NOT NULL DEFAULT '0'";
  public $last_login = "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
  public $last_login_ip = "varchar(50) DEFAULT NULL";
  public $login_history = "mediumtext";
  public $active = "varchar(255) DEFAULT NULL";

  public function __construct($username = "", $password = "") {
    if (!empty($username) && !empty($password)) {
      $user = $this->check_login($username, $password);
      if ($user)
        $this->get_item($user);
      else
        throw new Exception("Virheellinen käyttäjätunnus tai salasana.");
    }
  }

  public function check_login($username, $password) {
    $data = array(
      "s",
      $username
    );
    $class_name = get_class($this);
    $query = "SELECT * FROM {$class_name} WHERE username = ?";
    $retval = $GLOBALS["db_connection"]->query($query, $data);
    if ($retval->num_rows === 0)
      return false;
    $hash = $retval->fetch_array(MYSQLI_ASSOC)["password"];
    if (password_verify($password, $hash))
      return $retval->fetch_array(MYSQLI_ASSOC)["id"];
    else
      return false;
  }

  public function check_user() {
    $class_name = get_class($this);
    $data = array(
      "ssi",
      $this->username,
      $this->password,
      $this->id
    );
    $query = "SELECT * FROM {$class_name} WHERE username = ? AND password = ? AND id = ?";
    return $GLOBALS["db_connection"]->query($query, $data)->num_rows == 0 ? false : true;
  }
}

?>
