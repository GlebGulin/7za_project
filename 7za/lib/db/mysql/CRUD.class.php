<?PHP
/**
 * CRUD means Create, Read, Update, Delete functions.
 * Almost in each model class we have a necessity of these main operations for
 * handling with table records. This class developed to free you from typing
 * this simple SQL queries and methods.
 *
 * @package SmartMVC
 * @version 1.1 (25.11.2007)
 * @author Alex Koshel <alex@fairpoint.com.ua>
 */
class CRUD extends wrapper
{

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function CRUD()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                             Main methods                                 *
 ****************************************************************************/

    /**
     * A function for getting the record from specified table by its ID.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @return  array
     */
    function getItemById( $id, $table_name )
    {
        $pri_key = $this->getPrimaryKeyField( $table_name );
        if ( !$pri_key )
            $this->addDebugMsg("Cannot determine primary key field!", __FILE__ . ':' . __LINE__ );

        $query = "SELECT * FROM " . $table_name . " WHERE " . $pri_key . " = '" . $id . "'";
        return $this->core->runQuery( $query, "getArray", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Removes a record from a specified table and with specified ID.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @return  int
     */
    function deleteItem( $id, $table_name )
    {
        $pri_key = $this->getPrimaryKeyField( $table_name );
        if ( !$pri_key )
            $this->addDebugMsg("Cannot determine primary key field!", __FILE__ . ':' . __LINE__ );

        $query = "DELETE FROM " . $table_name . " WHERE " . $pri_key . " = '" . $id . "'";
        return $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );
    }

    /**
     * Inserts new record into the specified table.
     *
     * This method takes the data from $data array (second parameter). If this parameter
     * not specified data taken from a POST array.
     *
     * Returns an ID of just added record.
     *
     * @param   string  $table_name
     * @param   array   $data
     * @return  int
     */
    function addItem( $table_name, $data = false )
    {
        if ( !$data )
            $data = $_POST;

        $fields = $this->getTableFields( $table_name );

        $query = "INSERT INTO " . $table_name . " SET ";
        $count = 0;
        for ( $i = 0; $i < count($fields); $i++ )
            if ( isset($data[ $fields[$i] ]) )
            {
                $query .= $fields[$i] . " = '" . $data[ $fields[$i] ] . "', ";
                $count++;
            }

        if ( $count > 0 )
        {
            $query = substr($query, 0, strlen($query) - 2);
            $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );
            return $this->lastInsertId();
        }
        else
            return 0;
    }

    /**
     * Updates the specified record in a specified table with given data.
     *
     * This method takes the data from $data array (second parameter). If this parameter
     * not specified data taken from a POST array.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @param   array   $data
     * @return  int
     */
    function saveItem( $id, $table_name, $data = false )
    {
        if ( !$data )
            $data = $_POST;

        $fields = $this->getTableFields( $table_name );
        $pri_key = $this->getPrimaryKeyField( $table_name );
        if ( !$pri_key )
            $this->addDebugMsg("Cannot determine primary key field!", __FILE__ . ':' . __LINE__ );

        $query = "UPDATE " . $table_name . " SET ";
        $count = 0;
        for ( $i = 0; $i < count($fields); $i++ )
            if ( isset($data[ $fields[$i] ]) )
            {
                $query .= $fields[$i] . " = '" . $data[ $fields[$i] ] . "', ";
                $count++;
            }

        if ( $count > 0 )
        {
            $query = substr($query, 0, strlen($query) - 2);
            $query .= " WHERE " . $pri_key . " = '" . $id . "'";
            return $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );
        }
        else
            return 0;
    }

    function moveItemUp( $id, $table_name, $limit_field = "" )
    {
        $pri_key = $this->getPrimaryKeyField( $table_name );
        if ( !$pri_key )
            $this->addDebugMsg("Cannot determine primary key field!", __FILE__ . ':' . __LINE__ );

        $item = $this->getItemById( $id, $table_name );

        $query = "SELECT * FROM " . $table_name . " WHERE position < " . $item["position"] .
            ($limit_field ? " AND " . $limit_field . " = '" . $item[$limit_field] . "'" : "") .
            " ORDER BY position DESC LIMIT 1";

        $item2 = $this->core->runQuery( $query, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $query = "UPDATE " . $table_name . " SET position = " . $item2["position"] .
                " WHERE " . $pri_key . " = " . $item[$pri_key];
            $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );

            $query = "UPDATE " . $table_name . " SET position = " . $item["position"] .
                " WHERE " . $pri_key . " = " . $item2[$pri_key];
            $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function moveItemDown( $id, $table_name, $limit_field = "" )
    {
        $pri_key = $this->getPrimaryKeyField( $table_name );
        if ( !$pri_key )
            $this->addDebugMsg("Cannot determine primary key field!", __FILE__ . ':' . __LINE__ );

        $item = $this->getItemById( $id, $table_name );

        $query = "SELECT * FROM " . $table_name . " WHERE position > " . $item["position"] .
            ($limit_field ? " AND " . $limit_field . " = '" . $item[$limit_field] . "'" : "") .
            " ORDER BY position LIMIT 1";

        $item2 = $this->core->runQuery( $query, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $query = "UPDATE " . $table_name . " SET position = " . $item2["position"] .
                " WHERE " . $pri_key . " = " . $item[$pri_key];
            $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );

            $query = "UPDATE " . $table_name . " SET position = " . $item["position"] .
                " WHERE " . $pri_key . " = " . $item2[$pri_key];
            $this->core->runQuery( $query, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function getNextPosition( $table_name, $condition = "" )
    {
        $query = "SELECT MAX(position) FROM " . $table_name .
            ( $condition ? " WHERE " . $condition : "" );

        $position = $this->core->runQuery( $query, "getSingleValue", __FILE__ . ':' . __LINE__ );
        return $position + 1;
    }

/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

    /**
     * Returns primary key field name for specified table.
     *
     * Returns false if primary key not found.
     *
     * @param   string  $table_name
     * @return  string
     */
    function getPrimaryKeyField( $table_name )
    {
        $fields = $this->core->runQuery( "SHOW FIELDS FROM " . $table_name, "getIndexArray", __FILE__ . ':' . __LINE__ );

        $i = 0;
        while ( $i < count($fields) && $fields[$i]["Key"] != "PRI" )
            $i++;

        if ( $i < count($fields) )
            return $fields[$i]["Field"];
        else
            return false;
    }

    /**
     * Returns a one-dimensional array with all fields of specified table.
     *
     * @param   string  $table_name
     * @return  array
     */
    function getTableFields( $table_name )
    {
        $fields = $this->core->runQuery( "SHOW FIELDS FROM " . $table_name, "getIndexArray", __FILE__ . ':' . __LINE__ );

        $fields_res = array();
        for ( $i = 0; $i < count($fields); $i++ )
            $fields_res[] = $fields[$i]["Field"];

        return $fields_res;
    }

}
?>