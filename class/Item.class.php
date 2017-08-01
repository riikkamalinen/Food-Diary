<?php
class Item {
  public $id = "int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT";

  public function get_item($id) {
    $class_name = get_class($this);
    $query = "SELECT * FROM {$class_name} WHERE id = {$id}";
    $data = $GLOBALS["db_connection"]->query($query)->fetch_array(MYSQLI_ASSOC);
    foreach ($data as $name => $value) {
      $this->$name = $value;
    }
  }

  public function install() {
    $this->sql_create();
  }

  public function sql_update() {
    $class_name = get_class($this);
    $variables = array();
    foreach (get_object_vars($this) as $name => $value) {
      if ($name != "id") {
        array_push($variables, "{$name}=\"{$value}\"");
      }
    }
    $inserts = join(", ", $variables);
    $query = "UPDATE {$class_name} SET {$inserts} WHERE id=?";
    $data = array(
      "i",
      $this->id
    );
    $GLOBALS["db_connection"]->query($query, $data);
  }

  public function sql_delete($confirm) {
    if ($confirm == true) {
      $class_name = get_class($this);
      $query = "DELETE FROM {$class_name} WHERE id=?";
      $data = array(
        "i",
        $this->id
      );
      $GLOBALS["db_connection"]->query($query, $data);
    }
  }

  public function sql_insert() {
    $class_name = get_class($this);
    $var_names = array();
    $var_values = array();
    foreach (get_object_vars($this) as $name => $value) {
      if ($name != "id") {
        array_push($var_names, $name);
        array_push($var_values, "\"{$value}\"");
      }
    }
    $names = join(", ", $var_names);
    $values = join(", ", $var_values);
    $query = "INSERT INTO {$class_name} ({$names}) VALUES ({$values})";
    $GLOBALS["db_connection"]->query($query);
  }

  protected function sql_create() {
    $class_name = get_class($this);
    $variables = join(", ", $this->get_var_data());
    $query = "CREATE TABLE {$class_name} ({$variables})";
    $GLOBALS["db_connection"]->query($query);
  }

  protected function get_var_data() {
    $return_value = array();
    foreach (get_object_vars($this) as $name => $value) {
      $data_type = "{$name} {$value}";
      array_push($return_value, $data_type);
    }
    return $return_value;
  }

  public static function get_all() {
    $class_name = get_called_class();
    $query = $GLOBALS["db_connection"]->query("SELECT * FROM {$class_name}");
    $retval = array();
    while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
      array_push($retval, $row);
    }
    return $retval;
  }


}
?>
