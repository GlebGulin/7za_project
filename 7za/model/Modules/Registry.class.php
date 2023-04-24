<?PHP 
/**
 * The emulation of registry.
 *
 * This class allows easy handling with options you need in applications.
 *
 * @author  Alex Koshel <alex@belisar.de>
 * @version 1.0 (14.07.2005)
 */
class Registry extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    
    var $application        = "";
    var $module             = "";
    var $name               = "";
    var $value              = "";
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     */
    function Registry()
    {
        parent::wrapper();
        
        // take application name from the core
        $this->application = $this->applicationName;
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	

    /**
     * Saves the value for an option.
     *
     * @return   void
     * @param    string     $module
     * @param    string     $name
     * @param    mixed      $value
     * @access   public
     */
    function setValue( $module, $name, $value )
    {
        $this->module       = $module;
        $this->name         = $name;
        $this->value        = addslashes( serialize( $value ) );
        if ( Registry::runQuery( 0, "getNumRows", __FILE__ . ':' . __LINE__ ) > 0 )
            // updating the record
            Registry::runQuery( 1, "none", __FILE__ . ':' . __LINE__ );
        else 
            // inserting new record
            Registry::runQuery( 2, "none", __FILE__ . ':' . __LINE__ );
    }
    
    /**
     * Get value from registry.
     *
     * @return   mixed
     * @param    string     $module
     * @param    string     $name
     * @access   public
     */
    function getValue( $module, $name )
    {
        $this->module       = $module;
        $this->name         = $name;
        $option = Registry::runQuery( 0, "getArray", __FILE__ . ':' . __LINE__ );
        
        if ( $option )
            return unserialize( $option["value"] );
        else 
            return false;
    }
    
    /**
     * Returns all options by module.
     *
     * @return   array
     * @param    string     $module
     * @access   public
     */
    function getValuesByModule( $module )
    {
        $this->module       = $module;
        $options = Registry::runQuery( 3, "getIndexArray", __FILE__ . ':' . __LINE__ );
        
        $result = array();
        for ( $i = 0; $i < count($options); $i++ )
            $result[$options[$i]["name"]] = unserialize($options[$i]["value"]);
            
        return $result;
    }
    
    /**
     * Set group of options for specified module.
     *
     * @return   void
     * @param    string     $module
     * @param    array      $options
     * @access   public
     */
    function setValuesForModule( $module, $options )
    {
        if ( !is_array($options) || empty($options) )
            return false;
            
        foreach ( $options as $key => $value )
        {
            $this->setValue($module, $key, $value);
        }
    }
    
    /**
     * Removes record from registry.
     *
     * @return   void
     * @param    string     $module
     * @param    string     $name
     * @access   public
     */
    function deleteValue( $module, $name )
    {
        $this->module       = $module;
        $this->name         = $name;
        Registry::runQuery(4, "none", __FILE__ . ':' . __LINE__ );
    }
    
    /**
     * Sets the application name with which preocessing required.
     *
     * @return   void
     * @param    string $application
     * @access   public
     */
    function setApplication( $application )
    {
        $this->application = $application;
    }
    
/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/  

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     *
     * requires the appropiate query file for this class and
     * passes the query to dbHandler::runQuery()
     * returns an array or a string in accordance to the wanted result
     * The requirement for query file: it must have filename
     * <classname>.sql.php
     *
     * @author  Ralf Kramer, Alex Koshel
     * @param   int  query_id ( array index of the query within the 
     *                          required query file ) 
     * @param   string result ( specifies the type of the expected
     *          result set
     *          e.g. "getArray", "getIndexArray", "getSingleValue" etc. )
     * @param   msq_id ( a hint that is thrown by the system when an error occurs )
     *
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