<?php
mysqli_report(MYSQLI_REPORT_STRICT);

function open_database() {
	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}

function close_database($conn) {
	try {
		mysqli_close($conn);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function query( $query ) {

	$database = open_database();
	$found = null;

	try {
	    $result = $database->query($query);

			if ($result->num_rows > 0) {
				while($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$found[] = $row;
				}
	    }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }

	close_database($database);
	return $found;
}


function queryUnique( $query ) {

	$database = open_database();
	$found = null;

	try {
	    $result = $database->query($query);

			if ($result->num_rows > 0) {
	      $found = $result->fetch_assoc();
	    }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }

	close_database($database);
	return $found;
}

function queryUpdate( $query ) {

	$database = open_database();

	try {
	    $database->query($query);
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }

	close_database($database);
}

function find( $table = null, $id = null ) {

	$database = open_database();
	$found = null;

	try {
	  if ($id) {
	    $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
	    $result = $database->query($sql);

	    if ($result->num_rows > 0) {
	      $found = $result->fetch_assoc();
	    }

	  } else {

	    $sql = "SELECT * FROM " . $table  . " ORDER BY id";
	    $result = $database->query($sql);

			if ($result->num_rows > 0) {
				while($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$found[] = $row;
				}
	    }
	  }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }

	close_database($database);
	return $found;
}

function find_all( $table ) {
	return find($table);
}

function save($table = null, $data = null) {
	$database = open_database();
	$columns = null;
  $values = null;

  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
		if($value == ''){
			$values .= "NULL,";
		} else {
    	$values .= "'$value',";
		}
  }

  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');

  $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
	try {
	  $database->query($sql);

    $_SESSION['message'] = $msg['record'] . $msg['success_ins'];
    $_SESSION['type'] = 'success';

  } catch (Exception $e) {
	  $_SESSION['message'] = $msg['err_operation'];
    $_SESSION['type'] = 'danger';
  }

  close_database($database);
}

function update($table = null, $id = 0, $data = null) {

  $database = open_database();
  $items = null;

  foreach ($data as $key => $value) {
		if($value == ''){
			$items .= trim($key, "'") . "=NULL,";
		} else {
			$items .= trim($key, "'") . "='$value',";
		}
  }

  $items = rtrim($items, ',');

  $sql  = "UPDATE " . $table;
  $sql .= " SET $items";
  $sql .= " WHERE id=" . $id . ";";

  try {
    $database->query($sql);

    $_SESSION['message'] = $msg['record'] . $msg['success_upd'];
    $_SESSION['type'] = 'success';
  } catch (Exception $e) {
    $_SESSION['message'] = $msg['err_operation'];
    $_SESSION['type'] = 'danger';
  }

  close_database($database);
}

function remove( $table = null, $id = null ) {

  $database = open_database();

  try {
    if ($id) {

      $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
      $result = $database->query($sql);

      if ($result = $database->query($sql)) {
        $_SESSION['message'] = $msg['record'] . $msg['success_rem'];
        $_SESSION['type'] = 'success';
      }
    }
  } catch (Exception $e) {

    $_SESSION['message'] = $e->GetMessage();
    $_SESSION['type'] = 'danger';
  }

  close_database($database);
}

?>
