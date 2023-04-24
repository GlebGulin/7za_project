<?PHP 
/**
 * Deletes records from DB tables which have lost their references.
 * The table deletable_references contains the names of tables and
 * fields and triggers. If a trigger matches to a record in this table
 * all fields with the name of field and a passed value gets deleted.
 *
 * @package SmartMVC
 * @version 1.0 (23.06.2004)
 * @author Ralf Kramer <rk@belisar.de>
 */
class deleteableReferences extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    /**
     * Table which contains a field broken reference
     *
     * @var string
     */
    var $table         = "";
    
    /**
     * fieldname of a broken reference
     *
     * @var string
     */
    var $field         = "";
    
    /**
     * name of the event wich is stored in refs table
     *
     * @var string
     */
    var $trigger       = "";    
    
    /**
     * value of the field with the broken reference
     *
     * @var string
     */    
    var $value         = "";
  
    /**
     * new value for the field with the broken reference
     *
     * @var string
     */    
    var $new_value     = "";
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     */
    function deleteableReferences()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	
    	
    /**
    * Checks whether the table exists
    *
    * @return   boolean
    * @param    string  $table_name
    * @todo     check whether this method is needed ever
    */
    function checkTablePresence( $table_name )
    {
        $tables = $this->runQuery( 0, "getIndexArray", __FILE__.':'.__LINE__ );
        $present = false;
        for ($i=0; $i<count($tables); $i++)
        {
            if (in_array($table_name, $tables[$i]))
            {
                $present = true;
                break;
            }
        }
        return $present;
    }
    
    /**
     * DELETE's records with broken references
     *
     * @param   string  $trigger
     * @param   mixed   $value
     * @return  void
     * @access  public
     * @author  Ralf Kramer <kramer@ebimos.com>    
     */
    function cleanReferences( $trigger, $value )
    {
        $this->trigger  = $trigger;
        $this->value    = $value;
        $refs           = deleteableReferences::runQuery( 1, "getIndexArray", __FILE__.":".__LINE__ ); 
        
        for( $i = 0; $i < count( $refs ); $i++ )
        {
            $this->field = $refs[$i]['field'];
            $this->table = $refs[$i]['table'];
            deleteableReferences::runQuery( 2, "getNumRows", __FILE__.":".__LINE__ ); 
        }
    }
    
    /**
     * Updates records with broken references.
     *
     * @return   void
     * @param    string  $trigger
     * @param    mixed   $value
     * @param    mixed   $new_value
     * @access   public
     * @author   Alex Koshel <alex@belisar.de>
     */
    function updateReferences( $trigger, $value, $new_value = 0 )
    {
        $this->trigger      = $trigger;
        $this->value        = $value;
        $this->new_value    = $new_value;
        $refs               = deleteableReferences::runQuery( 1, "getIndexArray", __FILE__ . ':' . __LINE__ );
        
        for ( $i = 0; $i < count($refs); $i++ )
        {
            $this->field = $refs[$i]["field"];
            $this->table = $refs[$i]["table"];
            deleteableReferences::runQuery( 3, "none", __FILE__ . ':' . __LINE__ );
        }
    }
    
    
/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/  

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     * @return  mixed
     */
    function runQuery( $query_id, $result, $msg_id ) 
    {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }
   
}
?>