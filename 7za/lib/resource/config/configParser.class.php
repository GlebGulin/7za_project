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
 * Config file parser.
 *
 * This class is a part of SmartMVC framework.
 * Included by each script within the webroot.
 *
 * Deals with config and/or language files:
 * <ul><li>reads a file
 *  <li>analyse the contents
 *  <li>returns an array
 * </ul>
 * See the example below:
 * <pre>
 * ## language file
 * ## 
 * ## [comments]
 * ## - comments must start with two hashes like ##
 * ##
 * ## [section_header]
 * ## - lines that contains smth. [whatever] are section_header's
 * ## - a valid section header contains no whitespaces
 * ## - DONT translate section_header's into other languages
 * ## 
 * ## [params]
 * ## - a valid param is the first word of a line which is:
 * ##      - NOT a section_header
 * ##      - OR a comment 
 * ##      - OR an empty line.
 * ## - the first word MUST be followed by at least one whitespace
 * ## - the next char MUST be a equals sign like =
 * ## - this equals sign must MUST be follow by a whitespace
 * ##
 *
 * [global]
 * release  = alpha 0.0.2
 * title    = admin-inface
 * status   = 3%
 * </pre>
 *
 * Example usage:
 * <code>
 * $configParser = new configParser();
 * $lang = $configParser->getConfigFile();
 * echo $lang['global']['release'];
 * </code>
 * Output is: alpha 0.0.2
 *
 * @package SmartMVC
 * @version 1.00 (12/05/2003)
 * @author Ralf Kramer <rk@belisar.de>
 */

class configParser
{
##==========================================================================##  
##                  MEMBER - VARIABLES                                      ##
##==========================================================================## 

    /**
    * Path to language can.
    *
    * @var  boolean
    * @ignore
    */
    var $lngFile        = FALSE;

    /**
    * @ignore
    */
    var $lines          = FALSE;

    /**
    * 2-Dim array contains the results: $this->resAry['section']['variable']
    *
    * @var  array
    */
    var $resAry         = array();

    /**
    * @ignore
    */
    var $curSection     = FALSE;
    /**
    * @ignore
    */
    var $curVarName     = FALSE;    // contains the current section header

##==========================================================================##    
##                  INITIALISATION                                          ##
##==========================================================================## 
	
    /**
     * Construtor for the class.
     *
     * @return  configParser
     * @param   string  $path_to_lang_file  The path to config file
     */
    function configParser( $path_to_lang_file ) 
    {	
        $this->lngFile  = $path_to_lang_file;
    }

##==========================================================================##    
##                  MAIN FUNCTIONS                                          ##
##==========================================================================##

    /**
     * Main function.
     *
     * <ul>
     *  <li>reads the language file
     *  <li>contains the core loop
     *  <li>controls the class
     * </ul>
     *
     * @access  public
     * @return  array
     */
    function getConfigFile()
    {
        // read the the lang file...
        $this->lines = file( $this->lngFile );
        
        // enter the core loop
        foreach ( $this->lines as $line_num => $line ) 
        {
            $skip = FALSE;  // this flag starts the next iteration
            
             // strip comments
            if( substr( $line, 0, 2) == "##" )
                $skip = TRUE;      
            
            // strip white lines
            $line = trim( $line );
            if( empty( $line ) )
                $skip = TRUE;            
            
            // check for new section marker...
            if( !$skip && $this->isNewSection( $line ) )
            {
                // ...if you find one...prepare it...
                $line = $this->stripBrackets( $line );
                
                // ...keep it...
                $this->curSection = $line ;
                
                // ...go the next iteration.
                $skip = TRUE;
            }

            // assign a new var to the result array
            if( !$skip )
                $this->appendVar( $line );
        
        }
        // show debug infos
        #$this->showResults();
        
        return $this->resAry;
    }

    /**
     * TRUE if a new section marker was detected.
     *
     * @return  boolean
     * @access  private
     * @param   string  $line
     * @ignore
     */
    function isNewSection( $line )
    {
        if( strstr( $line , "["  ) && strstr( $line , "]"  ) )
            return TRUE;
    }


    /**
     * Add a new var.
     *
     * @return  void
     * @access  private
     * @param   string  $line
     * @ignore
     */
    function appendVar( $line )
    {
        // load each word in one array-field
        // by stripping multiple whitespaces like "  "
        $words = $this->getProperArray( $line );

        // add a new var if an equal is detected
        if( isset( $words[1] ) && trim( $words[1] ) == "=")
        {
            $value = $this->getValue( $line );
            $this->resAry[$this->curSection][$words[0]] = $value ;
            $this->curVarName = $words[0];
        }
        else // append the line to the current var
        {
            $this->resAry[$this->curSection][$this->curVarName] .= $line ;
        }
    }

##==========================================================================##    
##                  HELPER FUNCTIONS                                        ##
##==========================================================================##

    /**
     * Returns the section header and strips the brackets [].
     *
     * @return  string
     * @access  private
     * @param   string  $section
     * @ignore
     */
    function stripBrackets( $section )
    {
        $section = str_replace( "[", "", $section );
        $section = str_replace( "]", "", $section );
        return $section;
    }

    /**
     * Loads each word in one array-field by stripping multiple whitespaces like "  ".
     *
     * @return  array
     * @access  private
     * @param   string  $str
     * @ignore
     */
    function getProperArray( $str )
    {
        // remove tab's
        while( stristr(  $str, "\t" ) )
            $str = str_replace( "\t", " ", $str );

        // remove multiple whitespaces
        while( stristr(  $str, "  " ) )
            $str = str_replace( "  ", " ", $str );
    
        $words = explode( ' ', $str );
        return $words;
    }

    /**
     * Removes the varname and the equals sign.
     *
     * @return  string
     * @access  private
     * @param   string  $str
     * @ignore
     */
    function getValue( $line )
    {
        return trim(substr( $line, strpos($line, "=") +1 , strlen($line) ));
    }


    /**
     * Debug output.
     *
     * @return  void
     * @access  private
     * @ignore
     */
    function showResults()
    {
        // show results - uncomment this lines for debugging
        foreach( $this->resAry as $sec_name => $sec_value )
        {
            echo "<b><i>sec_name</i> => " . $sec_name . "</b><br>";
            foreach( $sec_value as $varName => $varValue )
            {
                echo "<i>varName</i>: <b>" . $varName . " = </b>" . $varValue . "<br>"; 
            }
        }
    }

} // End

?>