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
 
// Including Master Controller class
require_once( "MasterController.class.php" );

/**
 * Parent class for all controllers within one area of the site.
 *
 * This class is a part of SmartMVC framework. Every controller
 * class must extend it.
 *
 * @package SmartMVC
 * @version 1.00 (01/09/2004)
 * @author Alex Koshel <alex@belisar.de>
 */

class AdminBaseController extends MasterController 
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    var $tplToDisplay       = "";
    var $mode               = "";
  
/****************************************************************************
 *                      Initialization                                       *
 ****************************************************************************/   
  
    /**
     * Constructor for the class.
     *
     * @return  AreaBaseController
     */
    function AdminBaseController()
    {
        parent::MasterController();
    }

    /**
     * Initialization method for all controllers within one area.
     *
     * This method invoked automatically in every controller. So it is intended
     * for common area actions (like session initialization, user authorization
     * checking etc.). But it may be overriden in inherited controller with
     * processing necessary init routines.
     *
     * @return  void
     */
    function init()
    {
        parent::init();
        // importing GET vars into the class
        $this->importIntoClass("GET");
        if (!isset($_SESSION['admin_user'])) {
            $_SESSION['admin_user'] = 1;
        }
        $this->tplToDisplay = "admin/main.tpl.html";
    }
    
} // End Class

?>