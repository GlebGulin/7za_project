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
 * Simple hits counter [<i>utils.counters.SimpleCounter</i>].
 *
 * This class itself determines whether the table for collecting statistics
 * exists in a DB and if not it creates it. So you need to permit your MySQL
 * user to create tables or to create the table manually from a SQL query #1.
 *
 * The example of SimpleCounter using:
 * <code>
 * // in any controller to count a hit for the page of "Products" area
 * // page class has a wrapper for SimpleCounter
 * $this->countHitForArea("Products");
 *
 * // to get statistics for Smarty template engine
 * // in render() method of your controller
 * $this->tplToDisplay = "simpleCounter.tpl.html";
 * $this->tpl->assign("stats", $this->getCounterStats());
 * $this->display();
 *
 * // or simply print the HTML page
 * print $this->getCounterStatsPage();
 * </code>
 *
 * @package utils
 * @version 0.9 (18/11/2004)
 * @author Alex Koshel <alex@belisar.de>
 */
class SimpleCounter extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    /**
    * Table name for collesting stats.
    *
    * @var string
    */
    var $tableStatsName         = "#__sc_stats";
    
    /**
    * @ignore
    */
    var $area                   = "";
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     */
    function SimpleCounter()
    {
        parent::wrapper();
        
        if (!$this->checkTablePresence($this->tableStatsName))
            $this->createTable();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	
    	
    /**
    * Checks whether the table for collecting statistics exists.
    *
    * @return   boolean
    * @param    string  $table_name
    */
    function checkTablePresence( $table_name )
    {
        // check whether table presence was performed
        if (isset($_SESSION["sc_table_checked"]) && $_SESSION["sc_table_checked"] == 1)
            return true;
            
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
        if ($present) $_SESSION["sc_table_checked"] = 1;
        return $present;
    }
    
    /**
    * Creates the stats table.
    *
    * @return void
    */
    function createTable()
    {
        $this->runQuery( 1, "none", __FILE__.':'.__LINE__ );
    }
    
    /**
    * Call this method to count a hit for specified area.
    *
    * @return void
    * @param    string  $area
    */
    function countHit( $area )
    {
        $this->area = $area;
        // get last hit time for the area in the format of YYYY-MM
        $last_hit = $this->runQuery( 2, "getSingleValue", __FILE__.':'.__LINE__ );
        if ($last_hit)
        {
            $last_hit = substr($last_hit, 0, 7);
            if ($last_hit != date("Y-m"))
                $this->resetStats($area, $last_hit);
        }
        else 
        {
            // the record for the area doesn't exist
            $this->runQuery( 4, "none", __FILE__.':'.__LINE__ );
        }
            
        // increase counter for the current month and total
        $this->runQuery( 3, "none", __FILE__.':'.__LINE__ );
        // manage unique hits
        if (!isset($_COOKIE["sc_unique"]))
        {
            setcookie("sc_unique", $area, strtotime("+24 hours"), "/");
            // increase unique hits for the current month and total
            $this->runQuery(9, "none", __FILE__ . ':' . __LINE__ );
        }
        else 
        {
            $areas = explode(",", $_COOKIE["sc_unique"]);
            if (!in_array($area, $areas))
            {
                $areas[] = $area;
                setcookie("sc_unique", implode(",", $areas), strtotime("+24 hours"), "/");
                // increase unique hits for the current month and total
                $this->runQuery(9, "none", __FILE__ . ':' . __LINE__ );
            }
        }
    }
    
    /**
    * Clears stats on new month starting.
    *
    * @return void
    * @param    string  $area       the area
    * @param    string  $last_hit   the month of last hit in a format of YYYY-MM
    */
    function resetStats( $area, $last_hit )
    {
        $last_hit_month = substr($last_hit, 5);
        if ($last_hit_month == date("m", strtotime("-1 month")))
        {
            // put current month hits on a place of last month
            $this->runQuery( 5, "none", __FILE__.':'.__LINE__ );
        }
        else 
        {
            // put zeros on places of last month and current month
            $this->runQuery( 6, "none", __FILE__.':'.__LINE__ );
        }
    }
    
    /**
    * Returns the array with all stats.
    *
    * The format of returning array is following:<br>
    * $stats["total"] - total hits amount<br>
    * $stats["unique_total"] - total unique hits amount<br>
    * $stats["total_this_month"] - total hits quantity for current month<br>
    * $stats["unique_total_this_month"] - total unique hits quantity for current month<br>
    * $stats["total_last_month"] - total hits quantity for last month<br>
    * $stats["unique_total_last_month"] - total unique hits quantity for last month<br>
    * $stats["areas"] - is an array where each record has the structure:<br>
    * $stats["areas"][$i]["area"] - area name<br>
    * $stats["areas"][$i]["hits_this_month"] - hits for current month<br>
    * $stats["areas"][$i]["unique_hits_this_month"] - unique hits for current month<br>
    * $stats["areas"][$i]["hits_last_month"] - hits for last month<br>
    * $stats["areas"][$i]["unique_hits_last_month"] - unique hits for last month<br>
    * $stats["areas"][$i]["hits_total"] - total hits amount for the area
    * $stats["areas"][$i]["unique_hits_total"] - total unique hits amount for the area
    *
    * You may use this function for passing to template engine for creating own
    * template of stats page.
    *
    * @return   array
    */
    function getStats()
    {
        $stats = $this->runQuery( 7, "getArray", __FILE__.':'.__LINE__ );
        $stats["total"] = $this->divideByDots($stats["total"]);
        $stats["unique_total"] = $this->divideByDots($stats["unique_total"]);
        $stats["total_this_month"] = $this->divideByDots($stats["total_this_month"]);
        $stats["unique_total_this_month"] = $this->divideByDots($stats["unique_total_this_month"]);
        $stats["total_last_month"] = $this->divideByDots($stats["total_last_month"]);
        $stats["unique_total_last_month"] = $this->divideByDots($stats["unique_total_last_month"]);
        
        $stats["areas"] = $this->runQuery( 8, "getIndexArray", __FILE__.':'.__LINE__ );
        for ($i=0; $i<count($stats["areas"]); $i++)
        {
            $stats["areas"][$i]["hits_this_month"] = $this->divideByDots($stats["areas"][$i]["hits_this_month"]);
            $stats["areas"][$i]["unique_hits_this_month"] = $this->divideByDots($stats["areas"][$i]["unique_hits_this_month"]);
            $stats["areas"][$i]["hits_last_month"] = $this->divideByDots($stats["areas"][$i]["hits_last_month"]);
            $stats["areas"][$i]["unique_hits_last_month"] = $this->divideByDots($stats["areas"][$i]["unique_hits_last_month"]);
            $stats["areas"][$i]["hits_total"] = $this->divideByDots($stats["areas"][$i]["hits_total"]);
            $stats["areas"][$i]["unique_hits_total"] = $this->divideByDots($stats["areas"][$i]["unique_hits_total"]);
        }
        return $stats;
    }
    
    /**
    * Returns HTML page of statistics.
    *
    * @return string
    */
    function getStatsPage()
    {
        $stats = $this->getStats();
        $code = '<html>';
        $code .= '<head>';
        $code .= '<title>Statistics</title>';
        $code .= '<meta http-equiv="Content-Type" content="text/html">';
        $code .= '</head>';
        $code .= '<body bgcolor="#FFFFFF">';
        $code .= '<table width="100%" cellpadding="3" cellspacing="1" border="0">';
        $code .= ' <tr bgcolor="#A5A5E5">';
        $code .= '  <td><strong>Stats</strong></td>';
        $code .= '  <td>&nbsp;</td>';
        $code .= '  <td>&nbsp;</td>';
        $code .= ' </tr>';
        $code .= ' <tr bgcolor="#E5E5F5">';
        $code .= '  <td>Hits total summary</td>';
        $code .= '  <td>until now in this month</td>';
        $code .= '  <td>last month</td>';
        $code .= ' </tr>';
        $code .= ' <tr bgcolor="#F5F5F5">';
        $code .= '  <td>'.$stats["total"].'</td>';
        $code .= '  <td>'.$stats["total_this_month"].'</td>';
        $code .= '  <td>'.$stats["total_last_month"].'</td>';
        $code .= ' </tr>';
        $code .= ' <tr bgcolor="#A5A5E5">';
        $code .= '  <td><strong>Content</strong></td>';
        $code .= '  <td>&nbsp;</td>';
        $code .= '  <td>&nbsp;</td>';
        $code .= ' </tr>';
        $code .= ' <tr bgcolor="#E5E5F5">';
        $code .= '  <td>Area name</td>';
        $code .= '  <td>until now in this month</td>';
        $code .= '  <td>last month</td>';
        $code .= ' </tr>';
        foreach ($stats["areas"] as $area)
        {
            $code .= ' <tr bgcolor="#F5F5F5">';
            $code .= '  <td>'.$area["area"].'</td>';
            $code .= '  <td>'.$area["hits_this_month"].'</td>';
            $code .= '  <td>'.$area["hits_last_month"].'</td>';
            $code .= ' </tr>';
        }
        $code .= '</table>';
        $code .= '</body>';
        $code .= '</html>';
        return $code;
    }
    
    /**
    * Gets a number and divides it for 3 digits ("2347654" -> "2.347.654").
    *
    * @return   string
    * @param    int     $number
    */
    function divideByDots( $number )
    {
        $i = strlen($number);
        $new_number = "";
        while ($i>0)
        {
            if ($i != strlen($number) && (strlen($number) - $i) % 3 == 0)
                $new_number = $number{$i-1} . '.' . $new_number;
            else
                $new_number = $number{$i-1} . $new_number;
            $i--;
        }
        return $new_number;
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