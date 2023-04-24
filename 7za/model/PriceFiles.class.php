<?PHP 

class PriceFiles extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    
    var $price_id           = 0;
    var $title              = "";
    var $price_file_id      = 0;
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     */
    function PriceFiles()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	
    	
    /**
     * Returns all prices for all languages.
     *
     * @return   array
     * @access   public
     */
    function getAllPrices()
    {
        $prices = PriceFiles::runQuery( 0, "getIndexArray", __FILE__.':'.__LINE__ );
        
        $MM =& $this->getClassOf("Modules.MediaManager");
        for ( $i = 0; $i < count($prices); $i++ )
            $prices[$i]["file"] = $MM->getFile($prices[$i]["price_file_id"]);
            
        return $prices;
    }

    /**
     * Adds new price.
     *
     * @return   boolean
     * @access   public
     */
    function addNewPrice()
    {
        $MM =& $this->getClassOf("Modules.MediaManager");
        if ( $this->price_file_id = $MM->addFile("price_file") )
            PriceFiles::runQuery( 1, "none", __FILE__ . ':' . __LINE__ );
        else 
            return false;
        return true;
    }

    /**
     * Returns a price record by ID.
     *
     * @return   array
     * @param    int        $price_id
     * @access   public
     */
    function getPriceById( $price_id )
    {
        $MM =& $this->getClassOf("Modules.MediaManager");
        $this->price_id = $price_id;
        $price = PriceFiles::runQuery( 2, "getArray", __FILE__ . ':' . __LINE__ );
        $price["file"] = $MM->getFile($price["price_file_id"]);
        return $price;
    }
    
    /**
     * Saves the price.
     *
     * @return   void
     * @param    int        $price_id
     * @access   public
     */
    function savePrice( $price_id )
    {
        $price = $this->getPriceById($price_id);
        $MM =& $this->getClassOf("Modules.MediaManager");
        if ( !$this->price_file_id = $MM->addFile("price_file") )
            $this->price_file_id = $price["price_file_id"];
        else 
            $MM->deleteFile($price["price_file_id"]);
            
        $this->price_id = $price_id;
        PriceFiles::runQuery( 3, "none", __FILE__ . ':' . __LINE__ );
    }
    
    /**
     * Removes price from DB.
     *
     * @return   void
     * @param    int        $price_id
     * @access   public
     */
    function deletePrice( $price_id )
    {
        $price = $this->getPriceById($price_id);
        if ( !$price )
            return false;
            
        $MM =& $this->getClassOf("Modules.MediaManager");
        $MM->deleteFile($price["price_file_id"]);
        $this->price_id = $price_id;
        PriceFiles::runQuery( 4, "none", __FILE__ . ':' . __LINE__ );
        return true;
    }
    
    /**
     * Returns prices for specified language.
     *
     * @return   array
     * @param    string     $language
     * @access   public
     */
    function getPricesForLanguage( $language )
    {
        $prices = $this->getAllPrices();
        $prices_res = array();
        
        for ( $i = 0; $i < count($prices); $i++ )
            if ( $prices[$i]["language"] == $language )
                $prices_res[] = $prices[$i];
                
        return $prices_res;
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