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

require_once( LIB.'view'.DIR_SEP.'smarty'.DIR_SEP.'Smarty.class.php');
/**
 * Smarty template engine initiator [<i>view.smartyMVC</i>].
 *
 * This class makes the initialization of Smarty template engine.
 * This class is a part of SmartMVC library.
 *
 * @version 1.00 (06/05/2004)
 * @package Smarty
 * @author Alex Koshel <alex@belisar.de>
 */

class smartyMVC extends Smarty {

    /**
    * The handler for FormGenerator class.
    *
    * @var class
    */
    var $frmGenerator       = "";
    
/**
 * Construtor for the class.
 *
 * This constructor must be called from the constructor of every
 * page-oriented class of SmartMVC. Class <i>page</i> makes this call.
 *
 * @return  smartyMVC
 */
function smartyMVC() {
    parent::Smarty();

    $this->template_dir = TEMPLATE_DIR;
    $this->compile_dir = LIB."view".DIR_SEP."smarty".DIR_SEP.'templates_c';
    $this->config_dir = LIB."view".DIR_SEP."smarty".DIR_SEP.'configs';
    $this->cache_dir = LIB."view".DIR_SEP."smarty".DIR_SEP.'cache';

    $this->caching = false;
    $this->assign('app_name','SmartMVC');

    if ( STRIP_WHITESPACES )
        $this->load_filter('output', 'trimwhitespace');
}

/**
 * Passes the variable to Smarty.
 *
 * It's a shortcut to <i>assign()</i> method of Smarty for compatibility
 * with patTemplate engine.
 *
 * @return  void
 */
function addGlobalVar( $varname, $value ) {
    $this->assign( $varname, $value );
}

}
?>