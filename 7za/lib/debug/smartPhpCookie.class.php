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
 * Class for manipulating with cookies [<i>debug.smartPhpCookie</i>].
 *
 * Usage:
 * before any output of your script
 * <code>
 * $cookie = $this->getClassOf('smartPhpCookie');
 * if ( $cookie->canSetCookie() ) {
 *  // Cookies are accepted by the client browser
 * }
 * </code>
 *
 * @package utils
 * @version 1.00 (19/08/2004)
 * @author Alex Koshel <alex@belisar.de>
 * @author Ralf Kramer <rk@belisar.de>
 */

class smartPhpCookie {

    /**
    * Whether client browser accepts cookies.
    *
    * @var  boolean
    */
    var $canSetCookie   = false;

/**
 * Constructor for the class.
 *
 * It tries to set the cookie, reloads the page and check if 
 * the cookie is set.
 *
 * @return smartPhpCookie
*/
function smartPhpCookie() {
    if ( session_id() == "" ) session_start();
    if (!isset($_SESSION["SmartCookieReloaded"])) {
        $_SESSION["SmartCookieReloaded"] = "yes";
        $_SESSION["canSetCookie"] = false;
        setcookie( "SmartCookie" , "isSet" );
        $this->reloadPage();
    } else {
        if (@$_COOKIE["SmartCookie"] == "isSet" && !$_SESSION["canSetCookie"])
            $_SESSION["canSetCookie"] = true;
        $this->canSetCookie = $_SESSION["canSetCookie"];
    }
}

/**
 * This method reloads current page.
 *
 * @return void
*/
function reloadPage() {
    $line = '';

    foreach ($_GET as $key=>$value)
        $line .= $key . '=' . $value . '&';
    $line .= session_name() . "=" . session_id();
    
    $url = $_SERVER["PHP_SELF"] . '?' . $line;
    header( "Location: " . $url );
}

/**
 * This function returns true if it possible to set cookies.
 *
 * @return boolean
*/
function canSetCookie() {
    return $this->canSetCookie;
}

}
?>