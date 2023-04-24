<?php
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004-2005  Belisar Systems
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
 * SmartCalendar class [<i>utils.dates.SmartCalendar</i>].
 *
 * The class for visual navigating dates, weeks and monthes.
 * This class is a part of SmartMVC library.
 *
 * @version 1.01 (24/01/2005)
 * @package utils
 * @author Alex Koshel <alex@belisar.de>
 * @author Ralf Kramer <rk@belisar.de>
 */

class SmartCalendar
{
    /**
    * The value of table cellspacing.
    *
    * @var  integer
    */
    var $cellspacing;

    /**
    * The value of table cellpadding.
    *
    * @var  integer
    */
    var $cellpadding;

    /**
    * Array of monthes' names.
    *
    * @var  array
    */
    var $monthes;

    /**
    * Array of 1-letter weekdays names.
    *
    * @var  array
    */
    var $days;

    /**
    * Array of 3-letters weekdays names.
    *
    * @var  array
    */
    var $days_short;

    /**
    * Additional GET parameters.
    *
    * @var  string
    */
    var $add_get_params;

    /**
    * The URL of requested page.
    *
    * @var  string
    */
    var $url_page;

    /**
    * Optional target attribute (for frames and iframes).
    *
    * @var  string
    */
    var $target;

/**
 * Construtor for the class.
 *
 * @return  SmartCalendar
 * @param   integer $padding    The value of table cellpadding
 * @param   integer $spacing    The value of table cellspacing
 */
function SmartCalendar($padding = 2, $spacing = 0) {
    //Set values by default
    $this->setCellpadding($padding);
    $this->setCellspacing($spacing);
    //$this->setMonthes(array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"));
    $this->setMonthes(array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"));
    //$this->setShortWeekDays(array("M", "T", "W", "T", "F", "S", "S"));
    $this->setShortWeekDays(array("П", "В", "С", "Ч", "П", "С", "В"));
    $this->setWeekDays(array("Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"));
    $this->setURL($_SERVER['PHP_SELF']);
    $this->setGETParams("");
    $this->setTarget("");
}

/**
 * By using this method you can change cellspacing of the HTML table.
 *
 * Default value is 2.
 * Example: <code>$cal->setCellpadding(3);</code>
 *
 * @param   integer $cp The value of table cellpadding
 * @return  void
 */
function setCellpadding($cp) {
    $this->cellpadding = $cp;
}

/**
 * By using this method you can change cellspacing of the HTML table.
 *
 * Default value is 0.
 * Example: <code>$cal->setCellspacing(2);</code>
 *
 * @param   integer $cs The value of table cellspacing
 * @return  void
 */
function setCellspacing($cs) {
    $this->cellspacing = $cs;
}

/**
 * You can set up names of monthes.
 *
 * This method is for multilanguage support.
 *
 * Example: <code>$cal->setMonthes(array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"));</code>
 * These values are set by default.
 *
 * @param   array   $monthes_str    Array of monthes' names
 * @return  void
 */
function setMonthes($monthes_str) {
    $this->monthes = $monthes_str;
}

/**
 * Sets short names of weekdays which are on
 * the top bar of the calendar.
 *
 * This method is for multilanguage support.
 * Example: <code>$cal->setShortWeekDays(array("M", "T", "W", "T", "F", "S", "S"));</code>
 * These values are set by default.
 *
 * @param   array   $weekdays   The array of weekdays' names
 * @return  void
 */
function setShortWeekDays($weekdays) {
    $this->days = $weekdays;
}

/**
 * Sets names of weekdays which are in the status bar of the calendar.
 *
 * This method is for multilanguage support.
 * Example: <code>$cal->setWeekDays(array("Mon", "Tue", "Wed", "Thi", "Fri", "Sat", "Sun"));</code>
 * These values are set by default.
 *
 * @param   array   $weekdays   The array of weekdays' names
 * @return  void
 */
function setWeekDays($weekdays) {
    $this->days_short = $weekdays;
}

/**
 * This method helps you to use the calendar in any .php file.
 *
 * Current page by default.
 * Example: <code>$cal->setURL("news.php");</code>
 *
 * @param   string  $url    Target URL
 * @return  void
 */
function setURL($url) {
    $this->url_page = $url;
}

/**
 * By using this method you can set up arbitrary GET parameters to all
 * links of the calendar.
 *
 * Example: <code>$cal->setGETParams("cart=48&id=15");</code>
 *
 * @param   string  $params Additional GET params
 * @return  void
 */
function setGETParams($params) {
    $this->add_get_params = $params;
}

/**
 * Method for setting an optional attribute target.
 *
 * Empty by default.
 * May be comfortable when you use frames or iframes. It inserts atribute target=""
 * in every link of the SmartCalendar.
 * Example: <code>$cal->setTarget("_blank");</code>
 *
 * @param   string  $tgt    Target value
 * @return  void
 */
function setTarget($tgt) {
    $this->target = $tgt;
}

/**
 * Generating the URL for previous month link.
 *
 * @ignore
 */
function urlPrevMonth($month, $year) {
    $url = $this->url_page.'?month='.date("Y-m",mktime(0,0,0,$month-1,1,$year));
    $url .= date("Y-m", mktime(0, 0, 0, $month-1, 1, $year))==date("Y-m") ? "&from=".date("Y-m-d")."&till=".date("Y-m-d") : "&from=".date("Y-m-d", mktime(0, 0, 0, $month-1, 1, $year)) . "&till=" . date("Y-m-d", mktime(0, 0, 0, $month-1, 1, $year));
    $url .= (!empty($this->add_get_params)?'&'.$this->add_get_params:'');
    return $url;
}

/**
 * Generating the URL for next month link.
 *
 * @ignore
 */
function urlNextMonth($month, $year) {
    $url = $this->url_page.'?month='.date("Y-m",mktime(0,0,0,$month+1,1,$year));
    $url .= date("Y-m", mktime(0, 0, 0, $month+1, 1, $year))==date("Y-m") ? "&from=".date("Y-m-d")."&till=".date("Y-m-d") : "&from=".date("Y-m-d", mktime(0, 0, 0, $month+1, 1, $year)) . "&till=" . date("Y-m-d", mktime(0, 0, 0, $month+1, 1, $year));
    $url .= (!empty($this->add_get_params)?'&'.$this->add_get_params:'');
    return $url;
}

/**
 * Generating the URL for month link.
 *
 * @ignore
 */
function urlSelectMonth($month, $year) {
    $url = $this->url_page.'?month='.date("Y-m",mktime(0,0,0,$month,1,$year)).'&from='.date("Y-m",mktime(0,0,0,$month,1,$year)).'-01&till='.date("Y-m-t",mktime(0,0,0,$month,1,$year)).(!empty($this->add_get_params)?'&'.$this->add_get_params:'');
    return $url;
}

/**
 * Generating the URL for week links.
 *
 * @ignore
 */
function urlSelectWeek($day, $month, $year, $week) {
    $url = $this->url_page.'?month='.(isset($_GET["month"])?$_GET["month"]:date("Y-m")).'&from='.date("Y-m-d",mktime(0,0,0,$month,$day,$year)).'&till='.date("Y-m-d",strtotime("+6 days",mktime(0,0,0,$month,$day,$year))).'&week='.$week.(!empty($this->add_get_params)?'&'.$this->add_get_params:'');
    return $url;
}

/**
 * Generating the URL for day links.
 *
 * @ignore
 */
function urlSelectDay($day, $month, $year) {
    $url = $this->url_page.'?month='.(isset($_GET["month"])?$_GET["month"]:date("Y-m")).'&from='.date("Y-m-d",mktime(0,0,0,$month,$day,$year)).'&till='.date("Y-m-d",mktime(0,0,0,$month,$day,$year)).(!empty($this->add_get_params)?'&'.$this->add_get_params:'');
    return $url;
}

/**
 * Selecting the class for the day cell.
 *
 * @ignore
 */
function classOfDay($day, $month, $year, $week) {
    $month_f = isset($_GET["month"])?$_GET["month"]:date("Y-m");
    if ($day==date("j") && $month==date("n") && $year==date("Y")) $cl = 'cal_cell_current_day';
    elseif (@$_GET["week"] == $week) $cl = 'cal_cell_selected_week';
    elseif (isset($_GET["from"]) && isset($_GET["till"]) && date("Y-m-d",mktime(0,0,0,$month,$day,$year))>=$_GET["from"] && date("Y-m-d",mktime(0,0,0,$month,$day,$year))<=$_GET["till"]) $cl = 'cal_cell_selected_day';
    elseif (date("Y-m",mktime(0,0,0,$month,$day,$year))<$month_f) $cl = 'cal_cell_previous_month';
    elseif (date("Y-m",mktime(0,0,0,$month,$day,$year))>$month_f) $cl = 'cal_cell_next_month';
    else $cl = 'cal_cell_current_month';
    return $cl;
}

/**
 * Generating the status bar of the SmartCalendar.
 *
 * @ignore
 */
function getStatusBar() {
    if (isset($_GET["from"]) && isset($_GET["till"])) {
        $day1 = explode("-",$_GET["from"]);
        $day2 = explode("-",$_GET["till"]);
        if ($_GET["from"]==$_GET["till"]) $status = $this->days_short[date("w",mktime(0,0,0,$day1[1],$day1[2],$day1[0]))==0?6:date("w",mktime(0,0,0,$day1[1],$day1[2],$day1[0]))-1].' '.date("d.m.Y",mktime(0,0,0,$day1[1],$day1[2],$day1[0]));
        elseif ($day1[2]==1 && $day2[2]==date("t",mktime(0,0,0,$day2[1],$day2[2],$day2[0]))) $status = $this->monthes[$day2[1]-1].'&nbsp;'.$day2[0];
        else $status = $day1[2].'.'.$day1[1].'.'.$day1[0].'-'.$day2[2].'.'.$day2[1].'.'.$day2[0];
    } else $status = $this->days_short[date("w")==0?6:date("w")-1].' '.date("d.m.Y");
    return $status;
}

/**
 * Generating the HTML code for the calendar.
 *
 * @return  string
 */
function get() {
    $output = '<table cellpadding="'.$this->cellpadding.'" cellspacing="'.$this->cellspacing.'" width="50" class="cal_table">';
    //Checking for current month and year of SmartCalendar
    $month = isset($_GET["month"])?substr($_GET["month"],strpos($_GET["month"],'-')+1,strlen($_GET["month"])-strpos($_GET["month"],'-')):date("n");
    $year = isset($_GET["month"])?substr($_GET["month"],0,strpos($_GET["month"],'-')):date("Y");

    //The line with current month and month navigators
    $output .= '<tr>';
    $output .= '<td class="cal_nav_back_cell"><a href="'.$this->urlPrevMonth($month,$year).'" class="cal_link_nav"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>&lt;&lt;</a></td>';
    $output .= '<td class="cal_month" colspan="6"><a href="'.$this->urlSelectMonth($month,$year).'" class="cal_show_month"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$this->monthes[$month-1].'&nbsp;'.$year.'</a></td>';
    $output .= '<td class="cal_nav_next_cell"><a href="'.$this->urlNextMonth($month,$year).'" class="cal_link_nav"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>&gt;&gt;</a></td>';
    $output .= '</tr><tr class="cal_days_row">';

    //The line with days of a week
    $output .= '<td class="cal_days_cells">&nbsp;</td>';
    for ($i=0; $i<7; $i++) $output .= '<td class="cal_days_cells">'.$this->days[$i].'</td>'."\n";

    //The number of the first week
    $week_no = date("W",mktime(1,0,0,$month,1,$year));
    $output .= '</tr><tr'.(@$_GET["week"]==$week_no?' class="cal_row_selected_week"':'').'>';
    //On which day of a week the month begins
    $beg_month = date("w",mktime(0,0,0,$month,1,$year))==0?7:date("w",mktime(0,0,0,$month,1,$year));

    //Outputing days in previous month
    $output .= '<td class="'.(@$_GET["week"]==$week_no?'cal_cell_selected_week':'cal_cell_week').'"><a href="'.$this->urlSelectWeek(date("t",mktime(0,0,0,$month-1,1,$year))-$beg_month+2,$month-1,$year,$week_no).'" class="cal_show_week"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$week_no.'</a></td>';
    for ($i=date("t",mktime(0,0,0,$month-1,1,$year))-$beg_month+2; $i<=date("t",mktime(0,0,0,$month-1,1,$year)); $i++) $output .= '<td class="'.$this->classOfDay($i,date("n",mktime(0,0,0,$month-1,$i,$year)),date("Y",mktime(0,0,0,$month-1,$i,$year)),$week_no).'"><a href="'.$this->urlSelectDay($i,date("n",mktime(0,0,0,$month-1,$i,$year)),date("Y",mktime(0,0,0,$month-1,$i,$year))).'" class="cal_show_day"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$i.'</a></td>';

    $week_day = $beg_month;
    $month_day = 1;

    //Outputing days in current month
    while ($month_day <= date("t",mktime(0,0,0,$month,1,$year))) {
        $output .= '<td class="'.$this->classOfDay($month_day,$month,$year,$week_no).'"><a href="'.$this->urlSelectDay($month_day,$month,$year).'" class="cal_show_day"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$month_day.'</a></td>';
        $month_day++;
        if (++$week_day == 8) {
            $week_day = 1;
            $week_no = date("W",mktime(0,0,0,$month,$month_day,$year));
            if ($month_day <= date("t",mktime(0,0,0,$month,1,$year))) $output .= '</tr><tr'.(@$_GET["week"]==$week_no?' class="cal_row_selected_week"':'').'><td class="'.(@$_GET["week"]==$week_no?'cal_cell_selected_week':'cal_cell_week').'"><a href="'.$this->urlSelectWeek($month_day,$month,$year,$week_no).'" class="cal_show_week"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$week_no.'</a></td>';
        }
    }

    //Outputing days of next month
    if ($week_day > 1) {
        $i = 1;
        while ($week_day < 8) {
            $output .= '<td class="'.$this->classOfDay($i,date("n",mktime(0,0,0,$month+1,$i,$year)),date("Y",mktime(0,0,0,$month+1,$i,$year)),$week_no).'"><a href="'.$this->urlSelectDay($i,date("n",mktime(0,0,0,$month+1,$i,$year)),date("Y",mktime(0,0,0,$month+1,$i,$year))).'" class="cal_show_day"'.(!empty($this->target)?' target="'.$this->target.'"':'').'>'.$i++.'</a></td>';
            $week_day++;
        }
    }
    $output .= '</tr><tr><td colspan="8" class="cal_row_status_bar">'.$this->getStatusBar().'</td></tr>';
    $output .= '</table>';
    return $output;
}

/**
 * Outputs the calendar to the screen.
 *
 * @return  void
 */
function printCalendar() {
    echo $this->get();
}

}
?>