<?PHP 

class Links extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    
    var $title              = "";
    var $shown              = 0;
    var $link_id                 = 0;
    var $href               = 0;
    var $language           = "";
    var $position           = 0;
    var $description         = "";
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function Links()
    {
        parent::wrapper();
    }


/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	

    
    function getAllLinks()
    {
        return Links::runQuery( 1, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }
    
    function getLinksItemById($id)
    {   
    	$this->link_id = $id;
    	return Links::runQuery( 3, "getArray", __FILE__ . ':' . __LINE__ );
    }
    
    function saveLinksItem($id)
    {   
    	$this->link_id = $id;
    	Links::runQuery( 5, "none", __FILE__.':'.__LINE__ );
    }
    
    function deleteLinksItem($id)
    {
    	$this->link_id = $id;
    	Links::runQuery( 4, "none", __FILE__.':'.__LINE__ );    	
    }
    
    function saveNewLinksItem()
    {
    	$this->position = 1 + Links::runQuery( 9, "getSingleValue", __FILE__ . ':' . __LINE__ );
    	Links::runQuery( 0, "none", __FILE__.':'.__LINE__ );    
    }
    
    function hideLinksItem($id)
    {   
    	$this->link_id = $id;
    	$links_item = $this->getLinksItemById($id);
        $this->shown = $links_item["shown"] == 1 ? 0 : 1;
    	Links::runQuery( 2, "none", __FILE__.':'.__LINE__ ); 
    }
    
    function moveLinkUp( $id )
    {
        $item = $this->getLinksItemById($id);
        $this->position = $item["position"];
        // get link with less position
        $item2 = Links::runQuery( 6, "getArray", __FILE__ . ':' . __LINE__ );
               
        if ( $item2 )
        {
            $this->link_id  = $item["link_id"];
            $this->position = $item2["position"];
            Links::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
            
            $this->link_id  = $item2["link_id"];
            $this->position = $item["position"];
            Links::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
        }
    }    
    
    function moveLinkDown( $id )
    {
        $item = $this->getLinksItemById($id);
        $this->position = $item["position"];
        // get link with less position
        $item2 = Links::runQuery( 7, "getArray", __FILE__ . ':' . __LINE__ );
        
        if ( $item2 )
        {
            $this->link_id  = $item["link_id"];
            $this->position = $item2["position"];
            Links::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
            
            $this->link_id  = $item2["link_id"];
            $this->position = $item["position"];
            Links::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function getLinksForLanguage($lng)
    {
    	$this->language = $lng;
    	return Links::runQuery( 10, "getIndexArray", __FILE__ . ':' . __LINE__ );
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
    function runQuery( $query_id, $result, $msg_id ) {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }
   
}
?>