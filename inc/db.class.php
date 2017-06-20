<?php
include_once("SqlSelectStatement.class.php");
/**
	* @author Guy Chabra 
	* Databse util api
**/
class Db{
	// database connection
	private $_connection;

	public function __construct()
    {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        mysqli_report(MYSQLI_REPORT_STRICT);
        $this->connect();
    }
	// on destruct close connection
	public function __destruct()
	{
        if($this->_connection)
            $this->disconnect();
    }
	private function connect()
	{
        if(!isset($this->_connection))
        {
        	try {
	            // Load configuration as an array. Use the actual location of your configuration file
	            $config = parse_ini_file('config.ini'); 
	            $this->_connection = new mysqli('localhost', $config['username'], $config['password'], $config['dbname']);
	        } catch ( Exception $e ) {
            	die( 'Unable to connect to database' );
        	}
        }
	}
	/**
		* Insert query to database method
		* @access public
		* @param tableName - A String parameter indicating the desired table name.
		* @param variables - A key-value map indicating the desired row to insert (column name => value).
		* @return true if insert action succeeded, false otherwise.
		* example:
		* $variables = array(
	    *	'title' => "title test 1",
	    *	'description' => "description test 1",
	    *	'image' => "testImage1.jpg"
		* );
	**/
	public function insertQuery($tableName, $variables = array())
	{
		$conn = $this->_connection;
		if(!$conn)
			return false;
		if(empty($variables) || empty($tableName) || !$this->checkTableName($tableName))
			return false;
		// start building the sql statement
       	$sql 	= "INSERT INTO ". $tableName;
        $fields = array();
        $values = array();
        // add all values and fields to their arrays
        foreach($variables as $field => $value)
        {
            $fields[] = $field;
            $values[] = "'".$value."'";
        }
        // transform the fields and values arrays into a string for SQL QUERY use
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';
        // concatenate the required parts of the sql statement
        $sql .= $fields .' VALUES '. $values;
        // execute query
        $query = $conn->query( $sql );
        
        if( $conn->error )
        {
            //$this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
            return $conn->insert_id;
	}
	/**
		* Update rows at the database
		* @access public
		* @param String tableName 		- A String parameter indicating the desired table name.
		* @param Array(Map) variables 	- A key-value map indicating the column and values to update (column name => value).
		* @param Array(Map) where 	   	- A key-value map indicating the desired rows to update (column name => value).
		* @param int limit 				- Limit the amount of rows affected
		* @return true if insert action succeeded, false otherwise.
		* example:
		* $variables = array(
	    *	'title' => "updated title test 1",
	    *	'description' => "updated description test 1",
	    *	'image' => "updated_testImage1.jpg"
		* );
		*
		* $where = array(
		* 	'id' => 1
		* );
		*
	**/
	public function updateQuery($tableName, $variables = array(), $where = array(), $limit = '')
	{
		$conn = $this->_connection;
		if(!$conn)
			return false;
		if(empty($variables) || empty($tableName) || empty($where) || !$this->checkTableName($tableName))
			return false;

        // start building the sql statement
        $sql = new SqlSelectStatement("UPDATE ". $tableName ." SET ");

        foreach($variables as $field => $value)
        {
            $updates[] = "`$field` = '$value'";
        }

        $sql->addToBody(implode(', ', $updates))
            ->addWhere($where)
            ->addLimit($limit);

        $query = $conn->query($sql->getSqlStatement());
        if($conn->error)
        {
            //$this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
            return true;
	}
	/**
	     * Delete data from table
	     *
	     * Example usage:
	     * $where = array( 'user_id' => 44, 'email' => 'someotheremail@email.com' );
	     * $database->delete( 'users_table', $where, 1 );
	     *
	     * @access public
	     * @param String tableName - the table name
	     * @param Array(Map) where - parameters table column => column value
	     * @param int limit 	   - max number of rows to remove.
	     * @return true if delete action succeeded, false otherwise.
    **/
    public function deleteQuery($tableName, $where = array(), $limit = '')
    {
        $conn = $this->_connection;
		if(!$conn)
			return false;
		if(empty($tableName) || empty($where) || !$this->checkTableName($tableName))
			return false;
        
        $sql = new SqlSelectStatement("DELETE");
        $sql->addTableName($tableName)
            ->addWhere($where)
            ->addLimit($limit);

        $conn->query($sql->getSqlStatement());
        if( $conn->error )
        {
            echo 'error deleteQuery db.class </br>';
            //$this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
			return true;  
    }
    /**
		* Fetch rows from the database (SELECT query)
		* @param $query The query string
		* @return false on failure / array Database rows on success
    **/
    public function selectQuery($query)
    {
    	$conn = $this->_connection;
    	$rows 	= array();
    	$result = $conn->query($query);

    	if($result === false)
            return false;
        
        while ($row = $result -> fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    
    /**
    * Select Query
    * example:
    * $tableName = "posts";
    * $where = array( 'postType' => 1);
    * $orderBy = "time";
    * $order = "DESC";
    * $limit = 0;
    * $count = 10;
    * storageManager->simpleSelectQuery($tableName, $where, $orderBy, $order, $limit, $count);
    * Will return 10 posts starting 0 to 10, that their type is 1,  DESC order.
    *
    * @access public
    * @param tableName -        table name
    * @param Array(Map) where - parameters table column => column value
    * @param orderBy -          the column to orderby
    * @param order -            DESC or ASC
    * @param limit -            the start position
    * @param count -            how many rows to return
    * @return selected rows
    **/
    public function simpleSelectQuery($tableName, $where = array(), $orders = array('id' => 'DESC'), $limit = '', $count = '')
    {
        $conn = $this->_connection;
        $rows = array();
        if(!$conn)
            return false;
        if(empty($tableName) || !$this->checkTableName($tableName))
            return false;

        $sql = new SqlSelectStatement("SELECT");
        $sql->addSelectFields(array( $tableName => array('*')))
            ->addTableName($tableName)
            ->addWhere($where)
            ->addOrderBy($orders)
            ->addLimit($limit, $count);

        $result = $conn->query($sql->getSqlStatement());
        if($conn->error)
        {
            //$this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            while ($row = $result -> fetch_assoc())
            {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
    * Get average of a column with where clause.
    * @access public
    * @param tableName -        table name
    * @param columnName -       the column name
    * @param Array(Map) where - parameters table column => column value
    * @return the selected average or false if there was an error
    **/
    public function simpleSelectAvg($tableName, $columnName, $where, $orders = array(), $limit = '', $count = '')
    {
        if(empty($tableName) || empty($columnName) || !$this->checkTableName($tableName))
            return false;
        $conn = $this->_connection;

        $sql = new SqlSelectStatement("SELECT AVG(".$columnName.") AS res");
        $sql->addTableName($tableName)
            ->addWhere($where)
            ->addOrderBy($orders)
            ->addLimit($limit, $count);

        $result = $conn->query($sql->getSqlStatement());
        if($conn->error)
        {
            //$this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        $row = $result -> fetch_assoc();
        return $row['res'];
    }

	/**
	     * Truncate entire tables
	     *
	     * Example usage:
	     * $remove_tables = array( 'users_table', 'user_data' );
	     * echo $database->truncate( $remove_tables );
	     *
	     * @access public
	     * @param String array tables - database table names
	     * @return int number of tables truncated
    **/
    public function truncate($tables = array())
    {
    	$conn = $this->_connection;
		if(!$conn)
			return false;

        if( !empty( $tables ) )
        {
            $truncated = 0;
            foreach($tables as $table)
            {
                if($this->checkTableName($table))
                {
                    $truncate = "TRUNCATE TABLE `".trim($table)."`";
                    $conn->query($truncate);
                    if(!$conn->error)
                        $truncated++;
                }
            }
            return $truncated;
        }
    }
	public function disconnect()
	{
        $this->_connection->close();
    }
    
    /**
    	* Get last auto-incrementing ID associated with an insertion
    	* @access public
    	* @param none
    	* @return int
    	*
    **/
    public function lastid()
    {
    	$conn = $this->_connection;
		if(!$conn)
			return false;
        return $conn->insert_id;
    }

    /**
        * Check if a table name is exists
        * @access public
        * @param tableName
        * @return bool
        *
    **/
    public function checkTableName($tableName)
    {
       $conn = $this->_connection;
        if(!$conn)
            return false;
        if(empty($tableName))
            return flase; 
        $result = $conn->query("SHOW TABLES LIKE '".$tableName."'");
        if($result->num_rows == 1)
            return true;
        return false;
    }

     /**
     * Count number of rows found matching a specific query
     *
     * Example usage:
     * $rows = $database->num_rows( "SELECT id FROM users WHERE user_id = 44" );
     *
     * @access public
     * @param string
     * @return int
     *
     */
    public function numRows($query)
    {
        $conn = $this->_connection;
        if(!$conn)
            return false;
        $result = $conn->query($query);
        if( $conn->error )
        {
            //$this->log_db_errors( $this->link->error, $query );
            return 0;
        }
        else
            return $result->num_rows;
    }

    //--------------------------------------------------- Utilities ----------------------------------------------------//
    /**
	     * Sanitize user data
	     *
	     * Example usage:
	     * $user_name = $database->filter( $_POST['user_name'] );
	     * 
	     * Or to filter an entire array:
	     * $data = array( 'name' => $_POST['name'], 'email' => 'email@address.com' );
	     * $data = $database->filter( $data );
	     *
	     * @access public
	     * @param mixed $data
	     * @return mixed $data
    **/
    public function filter($data)
    {
		$conn = $this->_connection;
		if(!is_array($data)){
			$data = $conn->real_escape_string($data);
			$data = trim(htmlentities($data, ENT_QUOTES, 'UTF-8', false));
		}
        //Self call function to sanitize array data
        else
			$data = array_map(array($this, 'filter'), $data); // array($this, 'filter') is the way to trasfer inner class function to array_map
        return $data;
    }
}
?>