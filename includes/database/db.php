<?php 

try {
	$DB = new PDO (
		'mysql:host=' . DB_HOST . 
		';dbname=' . DB_NAME,
		DB_USER,
		DB_PASS,
		[PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']
	);
	
	$DB->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
	die($e->getmessage());
}

/**
 * Inserting data to table function
 * @param  [string] $tableName table name variable
 * @param  [array] $fields    table fields
 * @return boolean            returns true if a new row inserted
 */
function insert($tableName, $fields)
{
	global $DB;
	foreach ($fields as $field  => $value) {
        $cols[] = $field;
        $binds[] = ":{$field}";
    }
    $columns = implode(', ', $cols);
    $bindings = implode(', ', $binds);
    $q = "INSERT INTO {$tableName} ";
    $q .= "({$columns}) VALUES ({$bindings})";
    $stmt = $DB->prepare($q); 
    foreach ($fields as $field => $value) {
    	$stmt->bindValue(":{$field}", $value);
    }
    
    return $stmt->execute();


}

/**
 * Inserting data to table function
 * @param  [string] $tableName table name variable
 * @param  [array] $fields    table fields
 * @return boolean            returns true if a new row inserted
 */
function firstOrInsert($tableName, $fields, $pk = 'id')
{
	$rows = where($tableName, $fields);
	if ($rows) {
		return $rows[0];
	}else{
		insert($tableName, $fields);
		$id = lastInsertedId();
		return get($tableName, $id, $pk);
	}

}

/**
 * Updating table row function
 * @param  [string] $tableName table name
 * @param  [array] $fields    table fields
 * @param  [array] $primary   array of table primary key and it's value
 * @return [boolean]            true if row updated
 */
function update($tableName, $fields, $primary)
{
	global $DB;
	$obj = get($tableName, $primary[1], $primary[0]);
	if ($obj[$primary[0]]) {
		foreach ($fields as $field  => $value) {
	        $cols[] 	= $field;
	        $binds[] 	= ":{$field}";
	    }
	    foreach ($fields as $field => $value) {
	    	$results[] = "$field = :{$field}";
	    }
	    $columns = implode(', ', $results);
	    $q = "UPDATE {$tableName} ";
	    $q .= "SET {$columns}";
	    $q .= " WHERE $primary[0] = :{$primary[0]}";
	    $stmt = $DB->prepare($q); 
	    foreach ($fields as $field => $value) {
	    	$stmt->bindValue(":{$field}", $value);
	    }
	    $stmt->bindValue(":{$primary[0]}", $obj[$primary[0]]);

	    // return $obj;
	    return $stmt->execute();
	}

	return false;

}

/**
 * [where description]
 * @param  [string] $tableName table name
 * @param  [array] $fields    table fields
 * @return [array]            array of rows found matchs
 */
function where($tableName, $fields, $operator = '=', $order = null, $limit = null)
{
	global $DB;
	$orderBy = isset($order) ? "ORDER BY $order[0] $order[1]" : "";
	$limit = isset($limit) ? "LIMIT $limit" : "";
	
	foreach ($fields as $field  => $value) {
        $cols[] 	= $field;
        $binds[] 	= ":{$field}";
    }
    foreach ($fields as $field => $value) {
    	$results[] = "$field $operator :{$field} AND";
    }
    $columns = implode(' ', $results);
    $columns = trim($columns, ' AND');
    $q = "SELECT * FROM {$tableName} ";
    $q .= "WHERE {$columns}";
    $stmt = $DB->prepare($q); 
    foreach ($fields as $field => $value) {
    	$stmt->bindValue(":{$field}", $value);
    }
    // return $q;
    return $stmt->execute() ? $stmt->fetchAll() : false;
}

/**
 * get a single row with primary field
 * @param  [string] $tableName table name
 * @param  [int] $value     field value
 * @param  string $field     field name
 * @return [array]            found row
 */
function get($tableName, $value, $field = 'id')
{	$keyValue = $value;
	$results = where($tableName, [$field => $keyValue]);
	return count($results) ? $results[0] : false;
}

/**
 * Fetch all table rows 
 * @param  [string] $tableName table name
 * @param  [array] $order     array of ordering field and method
 * @param  [int] $limit     the limit of rows fetched
 * @return [array]            All rows in the table
 */
function getAll($tableName, $order = null, $limit = null)
{
	global $DB;
	$orderBy = isset($order) ? " ORDER BY $order[0] $order[1] " : "";
	$limit = isset($limit) ? " LIMIT $limit " : "";
	$stmt = $DB->prepare("SELECT * FROM $tableName $orderBy $limit");
	return $stmt->execute() ? $stmt->fetchAll() : false;
}

function many($targetName, $targetPrimary, $targetPrimaryRef, $partnerPrimaryRef, $fieldValue, $container)
{
	global $DB;
	$q =	"SELECT 
				`$targetName`.*
			FROM
		    	`$targetName`
		    JOIN 
		    	`$container` 
		    ON 
		    	`$targetName`.`$targetPrimary` = `$container`.`$targetPrimaryRef`
			WHERE
		    	`$container`.`$partnerPrimaryRef` = ?";
	$stmt = $DB->prepare($q);
	// return $q;
	return $stmt->execute([$fieldValue]) ? $stmt->fetchAll() : false;
}

function manyToMany($targetTable, $currentTable, $container, $niddle, $order = null, $limit = null)
{
	global $DB;
	$columns_query = "SHOW COLUMNS FROM " . $targetTable['table'];
	$statement = $DB->prepare($columns_query);
	$statement->execute();
	$target_columns = $statement->fetchAll();

	$target_columns_in_string = '';
	$counter = 0;
	foreach ($target_columns as $column) {
		$target_columns_in_string .= '`' . $targetTable['table'] . '`.`' . $column['Field'] . '` AS `' . $targetTable['table'] . '_' . $column['Field'] . '`';
		if ($counter < count($target_columns) - 1) {
			$target_columns_in_string .=  ', ';
		}
		$counter++;
	}

	$orderBy = isset($order) ? " ORDER BY $order[0] $order[1] " : "";
	$limit = isset($limit) ? " LIMIT $limit " : "";

	$q = "SELECT 
				`$container`.*,
				" . $target_columns_in_string . "
			FROM
		    	`$container` 
		    INNER JOIN 
		    	`" . $targetTable['table'] . "`
		    ON 
		    	`" . $targetTable['table'] . "`.`" . $targetTable['pk'] . "` = `$container`.`" . $targetTable['fk'] . "`
			WHERE
		    	`$container`.`$niddle[0]` = ?
		    $orderBy
		    $limit";
	$stmt = $DB->prepare($q);
	// return $q;
	// dd($q);
	return $stmt->execute([$niddle[1]]) ? $stmt->fetchAll() : false;
}

function oneToMany($targetTable, $currentTable, $niddle, $order = null, $limit = null)
{
	global $DB;
	$orderBy = isset($order) ? " ORDER BY $order[0] $order[1] " : "";
	$limit = isset($limit) ? " LIMIT $limit " : "";

	$q =	"SELECT 
				`$targetTable[0]`.*
				`$currentTable[0]`.*
			FROM
		    	`$currentTable[0]`
		    INNER JOIN 
		    	`$currentTable[0]` 
		    ON 
		    	`$targetTable[0]`.`$targetTable[1]` = `$currentTable[0]`.`$targetTable[2]`
			WHERE
		    	`$currentTable`.`$niddle[0]` = ?
		    $orderBy
		    $limit";
	$stmt = $DB->prepare($q);
	// return $q;
	return $stmt->execute([$niddle[1]]) ? $stmt->fetchAll() : false;
}


function uploadImage($tableName, $primary, $imgField, $imgInput, $path, $oldImg, $ex = 'img')
{
	global $DB;

    $img = $_FILES[$imgInput]['name'];
    $oldImageFile = $oldImg !== 'default.jpg' ? $path . DS . basename($oldImg) : "";
    $temp = explode(".", $_FILES[$imgInput]["name"]);
	$newFileName = $ex . '_' . uniqid() . '.' . end($temp);
    $imageFile = $path . DS . $newFileName;
	// move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imageDirectory/" . $newFileName);
    $stmt = $DB->prepare("UPDATE $tableName SET $imgField = ? WHERE $primary[0] = ?");
    if (isset($_FILES[$imgInput]) && !empty($_FILES[$imgInput])) {
	    if ($stmt->execute(array($newFileName, $primary[1]))) {
	    	if (file_exists($oldImageFile)) unlink($oldImageFile);
	    	if (move_uploaded_file($_FILES[$imgInput]['tmp_name'], $imageFile)) {
	    		return true;
	    	}	
	    }
    }

    return false;
    // return $oldImageFile;
}

function uploadFile($fields, $inputName = "file", $path = "files")
{
	global $DB;

    $file = $_FILES[$inputName]['name'];
    $temp = explode(".", $_FILES[$inputName]["name"]);
	$newFileName = $ex . '_' . uniqid() . '.' . end($temp);
    $FileName = $path . DS . $newFileName;
	// move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imageDirectory/" . $newFileName);
    // $stmt = $DB->prepare("UPDATE $tableName SET $fileField = ? WHERE $primary[0] = ?");
    if (addFile($fields)) {
	    if (isset($_FILES[$inputName]) && !empty($_FILES[$inputName])) {
		    if ($stmt->execute(array($newFileName, $primary[1]))) {
		    	if (file_exists($oldFileName)) unlink($oldFileName);
		    	if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $FileName)) {
		    		return true;
		    	}	
		    }
	    }
    }

    return false;
    // return $oldImageFile;
}


function like($tableName, $fields, $bindType = 'AND', $order = null, $limit = null)
{
	global $DB;
	$orderBy = isset($order) ? " ORDER BY $order[0] $order[1] " : "";
	$limit = isset($limit) ? " LIMIT $limit " : "";

	foreach ($fields as $field  => $value) {
        $cols[] 	= $field;
        $binds[] 	= ":{$field}";
    }
    foreach ($fields as $field => $value) {
    	$results[] = "$field LIKE :{$field} " . $bindType;
    }

    $columns = implode(' ', $results);
    $columns = trim($columns, ' ' . $bindType);
    $q = "SELECT * FROM {$tableName} ";
    $q .= "WHERE {$columns}";
    $stmt = $DB->prepare($q); 
    
    foreach ($fields as $field => $value) {
    	$stmt->bindValue(":{$field}", "%" . $value . "%");
    }
    // return $q;
    return $stmt->execute() ? $stmt->fetchAll() : false;
}

function delete($tableName, $primary = [])
{
	global $DB;
	$obj = get($tableName, $primary[1], $primary[0]);
	if ($obj[$primary[0]]) {
		$stmt = $DB->prepare("DELETE FROM $tableName WHERE $primary[0] = :{$primary[0]}");
		$stmt->bindValue(":{$primary[0]}", $obj[$primary[0]]);
		return $stmt->execute();
	}
	return false;
	// return $obj;
}

function deleteBy(string $tableName, array $columns)
{
	global $DB;
	$keys = array_keys($columns);
	array_walk($keys, function(&$value, $key) { $value .= ' = ?'; } );
	$values = array_values($columns);
	$keys_in_string = implode(" AND ", $keys);
	$q = "DELETE FROM $tableName WHERE $keys_in_string";
	$stmt = $DB->prepare($q);
	return $stmt->execute($values);
}

function lastInsertedId()
{
	global $DB;
	return $DB->lastInsertId();
}
?>