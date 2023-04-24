<?PHP
/****************************************************************************
 *   This is the skeleton of the developing class.
 *   It shows what the page-oriented class should be.
 *   Remove this comment when you'll start developing.
 ****************************************************************************/

class Skeleton extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $some_var           = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function Skeleton()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/
    /**
     * This is just an example class
     *
     * here comes a longer description of the example class.  here comes a longer description
     * of the example class.  here comes a longer description of the example class.
     *
     * @author  Ralf Kramer
     * @return  array
     */
    function getSomeArray()
    {
        // Put the comment for the following query here
        return Skeleton::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
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