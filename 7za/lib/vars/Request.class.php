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

require_once(LIB . "utils/forms/FormValidator.class.php");

/**
 * The class for manipulating with request variables.
 *
 * This class is a part of SmartMVC framework.
 *
 * @package SmartMVC
 * @version 0.4 (29/10/2004)
 * @author Alex Koshel <alex@belisar.de>
 */

class Request extends FormValidator
{

    /**
    * Returns an array of given scope.
    *
    * Strip slashes (if needed) and returns required array from the request.
    * Possible values of a param are: "GET", "POST", "SESSION", "ENV", "COOKIE", "SERVER".
    *
    * @return   array
    * @param    string  $scope
    * @access   public
    */
    function &data( $scope = "POST" )
    {
        $scopes = array(
            "get"       => $_GET,
            "post"      => $_POST,
            "cookie"    => $_COOKIE,
            "session"   => $_SESSION,
            "server"    => $_SERVER,
            "env"       => $_ENV
        );
        
        $result = array();
        
        $env = strtolower($scope);
        if ( isset($scopes[$env]) )
            while (list($key, $value) = each($scopes[$env]))
            {
                if (!is_array($value) && get_magic_quotes_gpc() &&
                    ($env == "get" || $env == "post" || $env == "cookie"))
                        $result[$key] = stripslashes($value);
                else $result[$key] = $value;
                
                if (is_string($result[$key]))
                    $result[$key] = str_replace("'", "\\'", $result[$key]);
            }
        
        return $result;
    }
    
    /**
    * Validates an array for given pattern.
    *
    * First parameter may be assigned to the name of request array like "GET" or
    * array to be checked. The latter parameter is a name of XML file or array of
    * the pattern. See the manual for pattern array description.
    *
    * @return   boolean
    * @param    mixed   $ary
    * @param    mixed   $tpl
    */
    function validateRequest( $ary, $tpl )
    {
        if (!is_array($ary))
            $ary = $this->data($ary);
            
        if (is_array($tpl))
            $this->validateForm($ary, $tpl);
        else 
            $this->validateFormXML($ary, $tpl);
        
        if (count($this->wrong_items) == 0)
            return true;
        else 
            return false;
    }
    
    /**
    * Validates one parameter from specified request array.
    *
    * First parameter is a name of request array like "GET" or the array itself.
    *
    * @return   mixed
    * @param    mixed   $ary    array to be checked
    * @param    string  $name   name of a parameter to be checked
    * @param    string  $type   required type of a parameter
    */
    function validateParam( $ary, $name, $type )
    {
        // check whether this param was validated already
        if (isset($this->passed_items[$name]))
            return $this->passed_items[$name];
            
        if (!is_array($ary))
            $ary = $this->data($ary);
            
        $num_processed = count($this->passed_items);
        $this->validateForm( $ary, array(array("name"=>$name, "type"=>$type)) );
        
        if (count($this->passed_items) > $num_processed)
        {
            if (is_string($this->passed_items[$name]))
                $this->passed_items[$name] = trim($this->passed_items[$name]);
            return $this->passed_items[$name];
        }
        else 
            return false;
    }
    
}

?>