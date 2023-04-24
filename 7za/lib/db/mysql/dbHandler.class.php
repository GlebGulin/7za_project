<?PHP
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004  Belisar Systems
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 *
 */

/**
 * The class for interacting with the database.
 * This class is a part of SmartMVC framework.
 *
 * @version 1.08 (28/11/2005)
 * @package SmartMVC
 * @author Ralf Kramer <rk@belisar.de>
 * @author Alex Koshel <alex@belisar.de>
 */

class dbHandler extends debugHandler
{

##=================================================================================##
##                  MEMBER - VARIABLES                                             ##
##=================================================================================##

	/**
	* The DB server name taken from config.inc.php.
	* @var string
	*/
    var $dbServer           = DB_SERVER;
	/**
	* The DB user name taken from config.inc.php.
	* @var string
	*/
    var $dbUser             = DB_USER;
	/**
	* The DB password taken from config.inc.php.
	* @var string
	*/
    var $dbPassword         = DB_PASSWORD;
	/**
	* The DB name taken from config.inc.php.
	* @var string
	*/
    var $dbName             = DB_NAME;

	/**
	* Holds the handler for DB connection.
	* @var integer
	*/
    var $conn               = 0;

    /**
	* Shows whether connection to DB exists.
	* @var boolean
	*/
    var $hasConnect         = FALSE;

	/**
	* Contains ID of last inserted record.
	* @var integer
	*/
    var $last_insert_id;

    /**
	* Status of queries outputing.
	* @var boolean
	*/
    var $showQuery          = false;

    /**
	* The global counter for queries.
	* @var int
	*/
    var $queryCounter       = 0;
    /**
    * All found such prefixes in query files will be replaced to set in
    * config file prefix.
    *
    * @see  makeURLHashes()
    * @var  string
    */
    var $devTablePrefix     = '#__';
    /**
    * This variable used for putting prefixes in model classes.
    *
    * You may change the value of a prefix in config.inc.php file.
    *
    * @see  makeURLHashes()
    * @var  string
    */
    var $tablePrefix        = TABLE_PREFIX;

##=================================================================================##
##                  INITIALIZATION                                                 ##
##=================================================================================##

	/**
	* Constructor for the class.
	* @return dbHandler
	*/
	function dbHandler( )
    {

	}

	/**
	* Does DB connect and validates connection.
	* Returns true if connect was successfull and false otherwise.
	* @return boolean
	*/
	function  dbConnect()
    {
        if (!$this->conn)
            $this->conn = @mysql_connect( $this->dbServer, $this->dbUser , $this->dbPassword )
                or $this->addDebugMsg( "MySQL connect failed: " . mysql_error()
		                    . "<h3>Check The Database Settings In /lib/config.inc.php</h3>",
		                    "dbConnect Error" );

	    $use = mysql_select_db( $this->dbName, $this->conn); 

	    if ( !$use )
	       $this->addDebugMsg( "MySQL connect failed: " . mysql_error(), "dbConnect Error" );

	    // Could a connection be established...?
	    if ( is_resource( $this->conn ) )
		    return $this->hasConnect = TRUE;

        // ...if not!
		$this->addDebugMsg( "MySQL connect failed: " . mysql_error()
		                    . "<h3>Check The Database Settings In /lib/config.inc.php</h3>",
		                    "dbConnect Error" );

        return FALSE;
	}

##=================================================================================##
##                      QUERY - HANDLING                                           ##
##=================================================================================##

    /**
    * Executes a given SQL query.
    * Takes SQL query to be executed,
    * the type of a result in second parameter and a message which
    * may be used for debugging.
    * The second parameter represents the type of resulting data expected
    * after query execution and may be one of the following values:
    * "getSingleValue", "getArray", "getIndexArray", "getNumRows", "none"
    *
    * @return mixed
    * @param string $query SQL query to be executed
    * @param string $resultType Type of expected result
    * @param string $queryID Message for debugging purposes
    */
    function runQuery( $query, $resultType, $queryID )
    {
        $this->queryCounter++;

        // replacing table prefixes
        $query = str_replace($this->devTablePrefix, $this->tablePrefix, $query);

        if ( $this->showQuery )
            $this->displayQuery( $query, $queryID );

        // run the query and give the resultset to
        // the according member function
         if( $result = mysql_query( $query ,$this->conn ) )
            return $this->$resultType( $result );

        // in case that no resultset is even valid
		if( !$result && $resultType == "none" )
			return $this->none($result);

        // If the query fails
        $this->addDebugMsg( "mysql says: " . mysql_error() . "@query is:" . $query, $queryID  );

        return FALSE;
    }

    /**
    * Sets the status whether to output following SQL queries
    * before their execution.
    *
    * @return void
    * @param boolean $status
    */
    function displayQueries( $status = true ) {
        $this->showQuery = $status;
    }

    /**
    * The function for getting array of records from DB.
    * Moves the results into an array, after execution you may
    * access to fields with $result[$i]['column_name'].
    * Used by runQuery() method.
    *
    * @return array
    * @param mixed $result
    */
    function getIndexArray( $result )
    {
       	for ( $i = 0; $i < @mysql_num_rows( $result ); $i++ )
		   	$search_results[$i] = @mysql_fetch_array( $result, MYSQL_ASSOC );

        // PROGRESS
        if( empty( $search_results ) )
            return;

        return  $search_results;
    }

    /**
    * Returns the amount of records in resultset.
    * Used by {@link runQuery()} method.
    *
    * @return integer
    * @param mixed $result
    */
    function  getNumRows( $result )
    {
        return  @mysql_num_rows( $result );
    }

    /**
    * Returns an associative array - one record from DB.
    * Use this method if
    * only one record is expected after query execution. You may
    * access to fields of the record by $arr['column_name'].
    * Used by {@link runQuery()} method.
    *
    * @return array
    * @param mixed $result
    */
    function  getArray( $result )
    {
		$search_results = @mysql_fetch_array($result, MYSQL_ASSOC);
        return  $search_results;
    }

    /**
    * Returns the value of the first key of an 1-Dim result array.
    * Used if the executed query gets only one result value.
    * Used by {@link runQuery()} method.
    *
    * @return string
    * @param mixed $result
    */
    function  getSingleValue( $result )
    {
		$search_results = @mysql_fetch_array($result, MYSQL_ASSOC);

        if( !is_array( $search_results ) )
            return 0;

        $key = key( $search_results );
        return  $search_results[$key];
    }

    /**
    * Function for empty resultset.
    * Invoked when a query with empty resultset is expected.
    * Returns the number of affected rows. Useful for UPDATE queries.
    * Used by {@link runQuery()} method.
    *
    * @return integer
    */
    function  none()
    {
       if( mysql_errno() > 0 )
            return FALSE;

       return mysql_affected_rows();
    }


##=================================================================================##
##							HELPER - FUNCTIONS                                     ##
##=================================================================================##

    /**
    * The function for getting key of last inserted record.
    * Returns the value of the AUTO_INCREMENT column from the last
    * inserted record.
    *
    * @return integer
    */
    function lastInsertId()
    {
        $query = "
            SELECT last_insert_id() AS id
        ";

        $last_insert = dbHandler::runQuery( $query, "getArray", "last_insert_id" );
        $this->last_insert_id = $last_insert['id'];
        return $last_insert['id'];
    }

    /**
     * Gets the next auto_increment value from a table.
     *
     * @param   string  $table
     * @return  int     the value of the next auto_increment
     * @access public
     * @todo check whether you need to lock this table
     * @author  Ralf Kramer <rk@belisar.de>
     */
    function getNextAutoIncrement( $table )
    {
        $status = $this->getTableStatus( $table );
        return $status['Auto_increment'];
    }

    /**
     * Returns the table status array.
     *
     * @param   string  $table
     * @return  array
     * @access  public
     * @author  Ralf Kramer <rk@belisar.de>
     */
    function getTableStatus( $table )
    {
        $query = "SHOW TABLE STATUS FROM " . DB_NAME . " LIKE '" .  $table . "'";
        return dbHandler::runQuery( $query, "getArray", __FILE__.":".__LINE__." get table status" );
    }

   /**
    * Outputs the number of executed queries.
    *
    * @return void
    */
    function displayQueryCounter()
    {
        echo "<br>=================executed MySQL-Queries===============<br>";
        echo "Total number: <b>" . $this->queryCounter . "</b>";
        echo "<br>================/executed MySQL-Queries===============<br>";
    }

   /**
    * Returns the number of executed queries.
    *
    * @return int
    */
    function getQueryCounter()
    {
        return $this->queryCounter;
    }

    /**
    * Outputs on the screen the specified SQL query with
    * highlighted syntax.
    *
    * @return void
    * @param string $query
    * @param string $queryID
    */
    function displayQuery( $query, $queryID )
    {
        echo "<div style=\"background-color: #eeeed5\">";
        $lines = explode( "\n", $query );
        for( $i = 0; $i < count( $lines ); $i++ )
        {
            if( strstr( $lines[$i], "# query" ) )
                echo "<hr><b>" . $lines[$i] . "  $queryID </b><hr>";
            else
                 $this->displayQueryLine( $lines[$i] );
        }
        echo "</div>";
    }

    /**
    * Outputs the line of a SQL query.
    * This method used by displayQuery().
    *
    * @return void
    * @param string $line
    * @ignore
    */
    function displayQueryLine( $line )
    {
        $sql_words = array( "SELECT", "FROM", "WHERE", "LEFT JOIN", "AND", "OR", "ON",
                            "ORDER BY", "GROUP BY", "LIMIT", "HAVING", "SET", "INSERT INTO",
                            "REPLACE", "UPDATE" );

        $is_displayed = FALSE;
        for( $i = 0; $i < count( $sql_words ); $i++ )
        {
            if( !empty( $line ) && strstr( $line, $sql_words[$i] ) && $is_displayed == FALSE )
            {
                echo "<div style=\"color: #bd1818\"><b>" . $line . "</b><br></div>";
                $is_displayed = TRUE;
            }
        }

        if( !empty( $line ) && $is_displayed == FALSE )
            echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $line . "<br>";
    }

} // End of dbHandler

?>
