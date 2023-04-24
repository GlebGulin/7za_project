<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $Products = $this->getClassOf("Products");
        $Holidays = $this->getClassOf("Holidays");

        $mode = $this->getParam( "GET", "mode", "string" );
        $date = $this->getParam( "GET", "date", "string" );
        $holiday_id = $this->getParam("GET", "holiday_id", "int");

        $date_start = $this->getParam("GET", "from", "string");
        $date_end = $this->getParam("GET", "till", "string");

        $date_start = $date_start ? $date_start : date("Y-m-d");
        $date_end = $date_end ? $date_end : date("Y-m-d");

        $this->contentFile = "admin/holidays/index.tpl.html";

        if ( $mode == "delete" && $holiday_id )
        {
            $Holidays->deleteHoliday($holiday_id);
            $this->redirect("index.php", "msg=deleted&from=".$date_start."&till=".$date_end);
        }

        if ( $mode == "save_new" )
        {
            $Holidays->importIntoClass("POST");
            $Holidays->description = $this->getEditorCode("description");
            $Holidays->addNewHoliday();
            $this->redirect("index.php", "msg=added_new&from=".$date_start."&till=".$date_end);
        }

        if ( $mode == "save" && $holiday_id )
        {
            $Holidays->importIntoClass("POST");
            $Holidays->description = $this->getEditorCode("description");
            $Holidays->saveHoliday($holiday_id);
            $this->redirect("index.php", "msg=saved&from=".$date_start."&till=".$date_end);
        }

        if ( $mode == "edit" && $holiday_id )
        {
            $this->contentFile = "admin/holidays/edit.tpl.html";
            $holiday = $Holidays->getHolidayById($holiday_id);
            $this->tpl->assign("holiday", $holiday);
			$this->initEditor("description", $holiday["description"] , "editor_code" );
        }

        if ( $mode == "add_new" )
        {
            $this->contentFile = "admin/holidays/new.tpl.html";
			$this->initEditor("description", "" , "editor_code" );
        }

        $Calendar = $this->getClassOf("utils.dates.SmartCalendar");
        $this->tpl->assign("calendar_code", $Calendar->get());

        $this->tpl->assign("date_start", $date_start);
        $this->tpl->assign("date_end", $date_end);

        $this->tpl->assign("holidays", $Holidays->getHolidays($date_start, $date_end));

        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "added_new" )
            $this->showMessage("Праздник добавлен");

        if ( $msg == "saved" )
            $this->showMessage("Праздник сохранен");

        if ( $msg == "deleted" )
            $this->showMessage("Праздник удален");
    }

    function render()
    {
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>