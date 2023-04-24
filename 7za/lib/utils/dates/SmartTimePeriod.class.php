<?php
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
 * SmartTimePeriod class [<i>utils.dates.SmartTimePeriod</i>].
 *
 * The class for visual navigating some period of time.
 * Here is an example how this tool may be used within SmartMVC framework:
 * <code>
 * // a fragment of your controller
 * $this->initSmartTimePeriod(strtotime("-1 week"), strtotime("now"));
 * $this->stp->setGETParams("book_id=12&user_id=15");
 * // getting code for passing to template engine
 * $outputCode = $this->stp->get();
 *
 * // for getting current period dates
 * $this->initSmartTimePeriod();
 * $startDate = $this->stp->getStartDate();
 * $endDate   = $this->stp->getEndDate();
 * </code>
 * This class is a part of SmartMVC library.
 *
 * @version 1.00 (02/11/2004)
 * @package utils 
 * @author  Alex Koshel <alex@belisar.de>
 * @idea    Ralf Kramer <rk@belisar.de>
 */
class SmartTimePeriod
{
    /**
    * Additional GET parameters.
    *
    * @var  string
    */
    var $addGetParams;

    /**
    * The URL of requested page.
    *
    * @var  string
    */
    var $urlPage;
    
    var $periodNames        = array("Today", "Yesterday", "Last 7 days", "Last 7 days (Mon-Sun)", "This month", "Last month", "All time");
    var $periodTimes        = array();
    var $monthes            = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    var $buttonText         = "Go";
    
    var $period             = 0;
    var $day1               = 0;
    var $day2               = 0;
    var $month1             = 0;
    var $month2             = 0;
    var $year1              = 0;
    var $year2              = 0;
    
    /**
    * Construtor for the class.
    *
    * @return  SmartTimePeriod
    */
    function SmartTimePeriod()
    {
        $this->urlPage = $_SERVER['SCRIPT_NAME'];
        $this->periodTimes[0] = "from=".date("Y-m-d")."&till=".date("Y-m-d")."&period=0";
        $this->periodTimes[1] = "from=".date("Y-m-d", strtotime("yesterday"))."&till=".date("Y-m-d", strtotime("yesterday"))."&period=1";
        $this->periodTimes[2] = "from=".date("Y-m-d", strtotime("-7 days"))."&till=".date("Y-m-d")."&period=2";
        $this->periodTimes[3] = "from=".date("Y-m-d", strtotime("last Monday", strtotime("-1 week")))."&till=".date("Y-m-d", strtotime("Sunday", strtotime("-1 week")))."&period=3";
        $this->periodTimes[4] = "from=".date("Y-m-d", mktime(0, 0, 0, date("n"), 1, date("Y")))."&till=".date("Y-m-d")."&period=4";
        $this->periodTimes[5] = "from=".date("Y-m-d", mktime(0, 0, 0, date("n", strtotime("last month")), 1, date("Y", strtotime("last month"))))."&till=".date("Y-m-d", mktime(0, 0, 0, date("n", strtotime("last month")), date("t", strtotime("last month")), date("Y", strtotime("last month"))))."&period=5";
        $this->periodTimes[6] = "from=".date("Y-m-d", 0)."&till=".date("Y-m-d")."&period=6";
        
        if (isset($_GET["period"]))
            $this->period = $_GET["period"];
        
        if (isset($_GET["from"]) && preg_match("/^\d{4}\-\d{2}\-\d{2}\$/", $_GET["from"]))
        {
            $date = explode("-", $_GET["from"]);
            $this->year1 = intval($date[0]);
            $this->month1 = intval($date[1]);
            $this->day1 = intval($date[2]);
        }
        else
        {
            $this->year1 = date("Y");
            $this->month1 = date("n");
            $this->day1 = date("j");
        }
        
        if (isset($_GET["till"]) && preg_match("/^\d{4}\-\d{2}\-\d{2}\$/", $_GET["till"]))
        {
            $date = explode("-", $_GET["till"]);
            $this->year2 = intval($date[0]);
            $this->month2 = intval($date[1]);
            $this->day2 = intval($date[2]);
        }
        else
        {
            $this->year2 = date("Y");
            $this->month2 = date("n");
            $this->day2 = date("j");
        }
    }
    
    /**
    * Initializes SmartTimePeriod with default values.
    *
    * Parameters may be set in the format of yyyy-mm-dd or in unix time.
    *
    * @return void
    * @param    mixed   $startDate
    * @param    mixed   $endDate
    * @access   public
    */
    function setInitValues($startDate = '', $endDate = '')
    {
        if (preg_match("/^(\d{4})\-(\d{2})\-(\d{2})\$/", $startDate, $matches))
        {
            // start date specified in the format of yyyy-mm-dd
            $this->year1 = $matches[1];
            $this->month1 = intval($matches[2]);
            $this->day1 = intval($matches[3]);
            //print_r($matches);
        }
        elseif (preg_match("/^\d+\$/", $startDate))
        {
            // start date specified in unix time
            $this->year1 = date("Y", $startDate);
            $this->month1 = date("n", $startDate);
            $this->day1 = date("j", $startDate);
        }
        
        if (preg_match("/^(\d{4})\-(\d{2})\-(\d{2})\$/", $endDate, $matches))
        {
            // end date specified in the format of yyyy-mm-dd
            $this->year2 = $matches[1];
            $this->month2 = intval($matches[2]);
            $this->day2 = intval($matches[3]);
        }
        elseif (preg_match("/^\d+\$/", $endDate))
        {
            // end date specified in unix time
            $this->year2 = date("Y", $endDate);
            $this->month2 = date("n", $endDate);
            $this->day2 = date("j", $endDate);
        }
    }
    
    /**
    * Returns current value of start date in the format of yyyy-mm-dd.
    *
    * @return   string
    * @access   public
    */
    function getStartDate()
    {
        return $this->year1 . "-" . str_pad($this->month1, 2, '0', STR_PAD_LEFT) . "-" . str_pad($this->day1, 2, '0', STR_PAD_LEFT);
    }
    
    /**
    * Returns current value of end date in the format of yyyy-mm-dd.
    *
    * @return   string
    * @access   public
    */
    function getEndDate()
    {
        return $this->year2 . "-" . str_pad($this->month2, 2, '0', STR_PAD_LEFT) . "-" . str_pad($this->day2, 2, '0', STR_PAD_LEFT);
    }

    /**
    * You can set up names of periods.
    *
    * This method is for multilanguage support.
    *
    * Example:
    * <code>
    * $cal->setPeriodNames(array("Today", "Yesterday", "Last 7 days", "Last 7 days (Mon-Sun)", "This month", "Last month", "All time"));
    * </code>
    * These values are set by default.
    *
    * @param   array   $periods     Array of periods' names
    * @return  void
    */
    function setPeriodNames( $periods )
    {
        $this->periodNames = $periods;
    }

    /**
    * You can set up names of monthes.
    *
    * This method is for multilanguage support.
    *
    * Example: <code>$stp->setMonthes(array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"));</code>
    * These values are set by default.
    *
    * @param   array   $monthes_str    Array of monthes' names
    * @return  void
    */
    function setMonthes( $monthes_str )
    {
        $this->monthes = $monthes_str;
    }

    /**
    * This method helps you to use this tool in any .php file.
    *
    * Current page by default.
    * Example: <code>$stp->setURL("stats.php");</code>
    *
    * @param   string  $url    Target URL
    * @return  void
    */
    function setURL($url)
    {
        $this->urlPage = $url;
    }
    
    function setButtonText( $text )
    {
        $this->buttonText = $text;
    }

    /**
    * By using this method you can set up arbitrary GET parameters.
    *
    * Example: <code>$stp->setGETParams("cart=48&id=15");</code>
    *
    * @param   string  $params Additional GET params
    * @return  void
    */
    function setGETParams($params)
    {
        $this->addGetParams = $params;
        if ($this->addGetParams{0} == "&")
            $this->addGetParams = substr($this->addGetParams, 1);
    }

    /**
    * Generates the HTML code for the period selector.
    *
    * @return  string
    */
    function get()
    {
        $output = '<form name="time_period" method="POST" class="tpForm">'.
            '<input type="radio" name="type" id="type1" value="1" checked onClick="disable(1)" class="tpRadio">&nbsp;'.
            '<select name="period" id="period" onChange="submitForm()" class="tpSelect">';
            
        for ($i=0; $i<count($this->periodNames); $i++)
            $output .= '<option value="'.$this->periodTimes[$i].'"'.($i==$this->period?' selected':'').'>'.$this->periodNames[$i];
        
        $output .= '</select><br />'.
            '<input type="radio" name="type" id="type2" value="2" onClick="disable(0)" class="tpRadio">&nbsp;'.
            '<select name="day1" id="day1" class="tpSelect">';
            
        for ($i=1; $i<32; $i++)
            $output .= '<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"'.($i==$this->day1?" selected":"").'>'.$i;
        
        $output .= '</select> <select name="month1" id="month1" class="tpSelect">';
        
        for ($i=1; $i<13; $i++)
            $output .= '<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"'.($i==$this->month1?" selected":"").'>'.$this->monthes[$i-1];
        
        $output .= '</select> <select name="year1" id="year1" class="tpSelect">';
        $year = floor(date("Y")/10)*10;
        for ($i=$year; $i<$year+10; $i++)
            $output .= '<option value="'.$i.'"'.($i==$this->year1?" selected":"").'>'.$i;
        
        $output .= '</select> - <select name="day2" id="day2" class="tpSelect">';
            
        for ($i=1; $i<32; $i++)
            $output .= '<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"'.($i==$this->day2?" selected":"").'>'.$i;
        
        $output .= '</select> <select name="month2" id="month2" class="tpSelect">';
        
        for ($i=1; $i<13; $i++)
            $output .= '<option value="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"'.($i==$this->month2?" selected":"").'>'.$this->monthes[$i-1];
        
        $output .= '</select> <select name="year2" id="year2" class="tpSelect">';
        $year = floor(date("Y")/10)*10;
        for ($i=$year; $i<$year+10; $i++)
            $output .= '<option value="'.$i.'"'.($i==$this->year2?" selected":"").'>'.$i;
        
        $output .= '</select> &nbsp;<button onClick="submitForm()" id="go" class="tpButton">'.$this->buttonText.'</button>';
        
        $output .= '
            <script language="JavaScript" type="text/javascript">
             <!--
                function disable(type) {
                    if (type==1) {
                        document.getElementById("day1").disabled = true;
                        document.getElementById("day2").disabled = true;
                        document.getElementById("month1").disabled = true;
                        document.getElementById("month2").disabled = true;
                        document.getElementById("year1").disabled = true;
                        document.getElementById("year2").disabled = true;
                        document.getElementById("period").disabled = false;
                        document.getElementById("type1").checked = true;
                    } else {
                        document.getElementById("day1").disabled = false;
                        document.getElementById("day2").disabled = false;
                        document.getElementById("month1").disabled = false;
                        document.getElementById("month2").disabled = false;
                        document.getElementById("year1").disabled = false;
                        document.getElementById("year2").disabled = false;
                        document.getElementById("period").disabled = true;
                        document.getElementById("type2").checked = true;
                    }
                }
                function submitForm() {
                    if (document.getElementById("type2").checked) {
                        var url = "'.$this->urlPage.'?from="+
                            document.getElementById("year1").value+"-"+
                            document.getElementById("month1").value+"-"+
                            document.getElementById("day1").value+"&till="+
                            document.getElementById("year2").value+"-"+
                            document.getElementById("month2").value+"-"+
                            document.getElementById("day2").value+"'.(!empty($this->addGetParams)?"&".$this->addGetParams:"").'";
                    } else {
                        var url = "'.$this->urlPage.'?"+
                            document.getElementById("period").value+
                            "'.(!empty($this->addGetParams)?"&".$this->addGetParams:"").'";
                    }
                    window.location.href=url;
                }
                disable('.((isset($_GET["from"]) && !isset($_GET["period"]))?0:1).');
             //-->
            </script>
        ';
            
        $output .= '</form>';
        return $output;
    }

    /**
    * Outputs the time period selector to the screen.
    *
    * @return  void
    */
    function printTimePeriod()
    {
        print $this->get();
    }

}
?>