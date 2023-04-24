<?PHP

class Pages extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $page_id           						= 0;
    var $page_parent_id							= 0;
    var $title									= "";
    var $content								= "";
    var $link									= "";
    var $language								= "";
    var $position								= 0;
    var $visible								= 0;
    var $in_menu								= 1;
    
    var $admin_id								= 0;
    var $permissions							= array();

    

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function Pages()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

	/**
	 * Returns pages for parent_page
	 *
	 * @param int $page_parent_id
	 * @return array
	 */
    function getPagesForAdmin( $page_parent_id = 0 )
    {
    	$this->page_parent_id = $page_parent_id;
        $page_list = Pages::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
        if ( count( $page_list ))
        foreach( $page_list as $key=>$value )
        {
        	$page_list[$key]['pages'] = Pages::getPagesForAdmin( $value['page_id'] );
        }
        return $page_list;
    }
    
    /**
     * Returns page by its id
     *
     * @param int $page_id
     * @return array
     */
    function getPageById( $page_id )
    {
    	$this->page_id = $page_id;
    	return Pages::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    }
    
    /**
     * Save page
     *
     * @param int $page_id
     */
    function savePage( $page_id )
    {
    	$this->page_id = $page_id;
    	Pages::runQuery( 2, "none", __FILE__.":".__LINE__ );
    }
    
    /**
     * Add new page in parent_page
     *
     * @param int $page_id
     */
    function saveNewPage( $page_id )
    {
    	$this->page_id = $page_id;
    	$item = Pages::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    	$this->page_parent_id = $page_id;
    	$this->position = 1 + Pages::runQuery( 4, "getSingleValue", __FILE__.":".__LINE__ );
    	Pages::runQuery( 3, "none", __FILE__.":".__LINE__ );
    }
    
    /**
     * Change visibility for page
     *
     * @param int $page_id
     */
    function changeVisibility( $page_id )
    {
    	$this->page_id = $page_id;
    	$page = Pages::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    	$this->visible = $page['visible']?0:1;
    	Pages::runQuery( 5, "none", __FILE__.":".__LINE__ );
    }
    
    /**
     * Change position for page
     *
     * @param int $page_id
     */
    function movePageUp( $page_id )
    {
    	$item = Pages::getPageById( $page_id );
    	$this->position = $item["position"];
    	$this->page_parent_id = $item["page_parent_id"];
        // get page with less position
        $item2 = Pages::runQuery( 6, "getArray", __FILE__ . ':' . __LINE__ );
               
        if ( $item2 )
        {
            $this->page_id  = $item["page_id"];
            $this->position    = $item2["position"];
            Pages::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
            
            $this->page_id  = $item2["page_id"];
            $this->position = $item["position"];
            Pages::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
        }
    }  

    /**
     * Change position for page
     *
     * @param int $page_id
     */    
    function movePageDown( $page_id )
    {
    	$item = Pages::getPageById( $page_id );
    	$this->position = $item["position"];
    	$this->page_parent_id = $item["page_parent_id"];
        // get page with more position
        $item2 = Pages::runQuery( 7, "getArray", __FILE__ . ':' . __LINE__ );
               
        if ( $item2 )
        {
            $this->page_id  = $item["page_id"];
            $this->position    = $item2["position"];
            Pages::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
            
            $this->page_id  = $item2["page_id"];
            $this->position = $item["position"];
            Pages::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
        }
    }       
    
    /**
     * Remove page from db
     *
     * @param int $page_id
     */
    function deletePage( $page_id )
    {
    	$this->page_parent_id = $page_id;
    	$pages = Pages::runQuery( 9, "getIndexArray", __FILE__.":".__LINE__ );
    	if ( count($pages) ) 
    	foreach ( $pages as $page )
			Pages::deletePage( $page['page_id'] );
		$this->page_id = $page_id;	
    	Pages::runQuery( 10, "none", __FILE__.":".__LINE__ );
    }     
    
    /**
     * Returns path to page
     *
     * @param int $page_id
     * @return array
     */
    function getPagePath( $page_id )
    {
    	$this->page_id = $page_id;
    	if ( $this->page_id == 0 || !Pages::runQuery( 1, "getNumRows", __FILE__.":".__LINE__ )) return array();
    	$list = array();
    	$page_parent_id = $this->page_id;
    	while( $page_parent_id != 0 )
    	{
    		$item = Pages::getPageById( $page_parent_id );
    		$page['title'] = $item['title'];
    		$page['page_id'] = $item['page_id'];
    		$page['link'] = "/pages/".$item['page_id']."/";
    		$page_parent_id = $item['page_parent_id'];
    		$list[]=$page;
    	}
    	return array_reverse($list);
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