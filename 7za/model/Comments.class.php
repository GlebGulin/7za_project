<?PHP

class Comments extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $item_id                = "";
    var $comment_id             = 0;
    var $author                 = '';
    var $author_ip              = '';
    var $added_time             = '';
    var $comment_text           = '';

    var $limit                  = 0;

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function Comments()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    function getCommentsForItem( $item_id )
    {
        $this->item_id = $item_id;
        return Comments::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    }

    function addCommentForItem( $item_id )
    {
        $this->item_id = $item_id;
        $this->added_time = date("Y-m-d");
        $this->author_ip = $_SERVER['REMOTE_ADDR'];

        // check for existing comment for this day and IP
        $num_comments = Comments::runQuery( 2, "getNumRows", __FILE__ . ':' . __LINE__ );
        if ( $num_comments > 0 )
            return false;

        Comments::runQuery( 1, "none", __FILE__ . ':' . __LINE__ );
    }

    function getLastComments( $num_comments = 30 )
    {
        $this->limit = $num_comments;
        return Comments::runQuery( 3, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function getCommentById( $comment_id )
    {
        $this->comment_id = $comment_id;
        return Comments::runQuery( 4, "getArray", __FILE__ . ':' . __LINE__ );
    }

    function deleteComment( $comment_id )
    {
        $this->comment_id = $comment_id;
        Comments::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );
    }

    function saveComment( $comment_id )
    {
        $this->comment_id = $comment_id;
        Comments::runQuery( 6, "none", __FILE__ . ':' . __LINE__ );
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