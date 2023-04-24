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
 * SmartSplitMenu class [<i>utils.splitMenu.SmartSplitMenu</i>].
 *
 * SmartSplitMenu class for outputing and fast maintenance of
 * scrolling line on your page.
 * This class is a part of SmartMVC library.
 *
 * @version 1.2 (29/09/2005)
 * @package utils 
 * @author Alex Koshel <alex@belisar.de>
 * @author Ralf Kramer <rk@belisar.de>
 */

class SmartSplitMenu
{ 

##=================================================================================##  
##                  MEMBER - VARIABLES                                             ##
##=================================================================================## 

    /**
    * Number of the last displayed page.
    *
    * @var      integer
    * @access   private
    */
    var $index;

    /**
    * Total number of avail records.
    *
    * @var      integer
    * @access   private
    */
    var $dataElements;

    /**
    * Determines how many records should be delivered.
    *
    * @var      integer
    * @access   private
    */
    var $indexLength;

    /**
    * Determines the maximum number of displayed chuncks/links in one direction.
    *
    * @var      integer
    * @access   private
    */
    var $maxElementsFromCenter      = 3;

    /**
    * Number of available sites.
    *
    * @var      integer
    * @access   private
    */
    var $availableSites;

    /**
    * @ignore
    * @access   private
    */
    var $targetUrl;

    /**
    * The name of CSS class for all links.
    *
    * @var      string
    * @access   public
    */
    var $cssClass;

    /**
    * The name of CSS class for selected page.
    *
    * @var      string
    * @access   public
    */
    var $cssSelectedClass;

    /**
    * The text which displayed as link back.
    *
    * @var      string
    * @access   public
    */
    var $backText                   = '&lt;';

    /**
    * The text which displayed as link forward.
    *
    * @var      string
    * @access   public
    */
    var $nextText                   = '&gt;';

    /**
    * The text which displayed as link to first page.
    *
    * @var      string
    * @access   public
    */
    var $firstText                  = '&lt;&lt;';

    /**
    * The text which displayed as link to last page.
    *
    * @var      string
    * @access   public
    */
    var $lastText                   = '&gt;&gt;';
    var $additionalParams           = "";

##=================================================================================##  
##                  INITIALIZATION                                                 ##
##=================================================================================## 

    /**
     * Constructor for the class.
     *
     * @return  smartSplitMenu
     */
    function SmartSplitMenu()
    {
    }

    /**
     * Creates the MenuBody - thus the Links between << and >>.
     *
     * @return  void
     * @ignore
     */
	function  makeLinkMenuBody() 
    {
        $linkMenuBody = "";
     
        $start = $this->index-$this->maxElementsFromCenter >= 0 ? $this->index-$this->maxElementsFromCenter : 0;
        $i = $start;

        if ( $start > 0 )
            $linkMenuBody = '<a class="'.$this->cssClass.'" href="'.$this->targetUrl.'?smIndex=0'.
                $this->additionalParams.'">1</a>&nbsp;';
        if ( $start > 1 )
            $linkMenuBody .= '...&nbsp;';
        
        while ($i <= $this->index+$this->maxElementsFromCenter && $i < $this->dataElements / $this->indexLength) {
            if ( $i == $this->index )
                $linkBody = '<span class="'.$this->cssSelectedClass.'">'.($i+1).'</span>';
            else
                $linkBody = '<a class="'.$this->cssClass.'" href="'.$this->targetUrl.'?smIndex='.$i.
                    $this->additionalParams.'">'.($i+1).'</a>';
            
            $linkMenuBody .= $linkBody.'&nbsp;';
            $i++;
        }
        
        if ( $i < $this->dataElements / $this->indexLength - 1 )
            $linkMenuBody .= '...&nbsp;';

        if ( $i < $this->dataElements / $this->indexLength )
            $linkMenuBody .= '<a class="'.$this->cssClass.'" href="'.$this->targetUrl.'?smIndex='.
                ceil($this->dataElements / $this->indexLength - 1).$this->additionalParams.
                '">'.ceil($this->dataElements / $this->indexLength).'</a>&nbsp;';

        return $linkMenuBody;	
	}

    //

    /**
    * Generates the link for "Back" button.
    *
    * @return string
    * @param string $linkText
    * @access private
    * @ignore
    */
    function makeBackLink( $linkText  )
    {
        // Create the header << or Backbutton

		if ( $this->index == 0 )
        { 
			$menuHeader = "";
		}
        else
        {
			$headerIndex = $this->index - 1;
			$linkHeader = $this->targetUrl . "?smIndex=$headerIndex" . $this->additionalParams;
			$menuHeader = "<a class=\"" . $this->cssClass . "\" href=\"$linkHeader\">" . $linkText . "</a>&nbsp;";
		}   
        return $menuHeader;
    }

    /**
    * Generates the link for "Next" button.
    *
    * @return string
    * @param string $linkText
    * @access private
    * @ignore
    */
    function makeNextLink( $linkText )
    {
		// Create the Footer >> oder Nextbutton

		if ($this->index==$this->availableSites -1) { 
			$menuFooter = "";
		} else {
			$headerIndex = $this->index +1;
			$linkFooter = $this->targetUrl."?smIndex=$headerIndex"  . $this->additionalParams;
			$menuFooter = "<a class=\"" . $this->cssClass . "\" href=\"$linkFooter\">" . $linkText . "</a>&nbsp;";
		}  
        return $menuFooter;
    }

    /**
    * Generates the link for "First" button.
    *
    * @return string
    * @param string $linkText
    * @since v.1.1
    * @access private
    * @ignore
    */
    function makeFirstLink( $linkText )
    {
		if ( $this->index == 0 )
        { 
			$menuHeader = "";
		}
        else
        {
			$headerIndex = 0;
			$linkHeader = $this->targetUrl . "?smIndex=$headerIndex" . $this->additionalParams;
			$menuHeader = '<a class="' . $this->cssClass . '" href="' . $linkHeader . '">' . $linkText . '</a>&nbsp;';
		}   
        return $menuHeader;
    }

    /**
    * Generates the link for "Last" button.
    *
    * @return string
    * @param string $linkText
    * @since v.1.1
    * @access private
    * @ignore
    */
    function makeLastLink( $linkText )
    {
		if ($this->index==$this->availableSites -1) { 
			$menuFooter = "";
		} else {
			$headerIndex = $this->availableSites-1;
			$linkFooter = $this->targetUrl."?smIndex=$headerIndex"  . $this->additionalParams;
			$menuFooter = '<a class="' . $this->cssClass . '" href="' . $linkFooter . '">' . $linkText . '</a>&nbsp;';
		}  
        return $menuFooter;
    }
    
    /**
    * Generates the entire menu.
    *
    * Use this function for generating the splitMenu.
    *
    * @return string
    * @access public
    */
	function makeLinkMenu()
	{
		if ($this->availableSites <= 1 ) { 
			return;
		}

        $menuHeader     = $this->makeFirstLink( $this->firstText ).
                          $this->makeBackLink( $this->backText );
		$menuBody       = $this->makeLinkMenuBody();
        $menuFooter     = $this->makeNextLink( $this->nextText ).
                          $this->makeLastLink( $this->lastText );

		return $linkMenu = $menuHeader . $menuBody . $menuFooter;
	}

    /**
    * Returns the current limit clause.
    *
    * @return string
    * @access private
    * @ignore
    */
    function getLimitClause()
    {
		$start = $this->index * $this->indexLength;
		
        if ( $this->dataElements == 0 )
            return "";

        if( $start == $this->dataElements )
        {
            $this->index = $this->index - 1;
            $start = $this->index * $this->indexLength;
        }  

		$limit = " LIMIT $start, $this->indexLength ";
		return $limit;       
    }

    /**
    * Returns a hint about the current area e.g "you are watching items 3 - 7".
    *
    * @return string
    * @access private
    * @ignore
    */
	function getCurrentArea()
    {	
		$area_start = $this->index * $this->indexLength +1;
		$area_end = $area_start + $this->indexLength -1;
		if( $area_end > $this->dataElements) 
        {
			$area_end=$this->dataElements;
		}

		$actualArea = "$area_start - $area_end";
		return $actualArea;
	}

    /**
    * Returns the current start index.
    *
    * @return integer
    * @access private
    * @ignore
    */
	function getStartIndex()
    {	
		$area_start = $this->index * $this->indexLength;
		return $area_start;
	}	

    /**
    * Returns the current stop index.
    *
    * @return integer
    * @access private
    * @ignore
    */
	function getStopIndex()
    {	
		$area_end = $this->getStartIndex() + $this->indexLength;
		if( $area_end > $this->dataElements) 
			$area_end = $this->dataElements;
		return $area_end;
	}

    /**
    * Computes the number pages that where displayed in the link menu.
    *
    * @return void
    * @access private
    * @ignore
    */
	function setAvailableSites()
    {	
		$neededLinks = ceil($this->dataElements / $this->indexLength);
		$this->availableSites = $neededLinks;
	}


##=================================================================================##    
##					HELPER - FUNCTIONS                                             ##
##=================================================================================## 

    /**
    * Sets the number of last displayed page number.
    *
    * @return void
    * @access public
    * @param    integer $index
    */
    function setIndex( $index )
    {
        $this->index = $index;
    }

    /**
    * Sets the elements of menu.
    *
    * @return void
    * @access public
    * @param    array   $elements
    */
    function setDataElements( $elements )
    {
        $this->dataElements = $elements;
    }

    /**
    * Sets the length of menu.
    *
    * @return void
    * @access public
    * @param    integer $indexLength
    */
    function setIndexLength( $indexLength )
    {
        $this->indexLength = $indexLength;
    }

    /**
    * Sets the target URL.
    *
    * @return void
    * @access public
    * @param    string  $url
    */
    function setTargetUrl( $url )
    {
        $this->targetUrl = $url;
    }

    /**
    * Sets the CSS class name for all links in menu.
    *
    * @return void
    * @param string $class
    * @access public
    */
    function setCssClass( $class )
    {
        $this->cssClass = $class;
    }

    /**
    * Sets the CSS class name for selected item.
    *
    * @return void
    * @param string $class
    * @since v.1.1
    * @access public
    */
    function setCssSelectedClass( $class )
    {
        $this->cssSelectedClass = $class;
    }
    
    /**
    * This method sets textline for the link one item back.
    *
    * @return void
    * @param string $back_text
    * @access public
    */
    function setBackText( $back_text )
    {
        $this->backText = $back_text;
    }

    //

    /**
    * This method sets textline for the link one item forward.
    *
    * @return void
    * @param string $next_text
    * @access public
    */
    function setNextText( $next_text )
    {
        $this->nextText = $next_text;
    }
    
    /**
    * This method sets textline for the link on first item.
    *
    * @return void
    * @param string $first_text
    * @access public
    */
    function setFirstText( $first_text )
    {
        $this->firstText = $first_text;
    }
    
    /**
    * This method sets textline for the link on last item.
    *
    * @return void
    * @param string $last_text
    * @access public
    */
    function setLastText( $last_text )
    {
        $this->lastText = $last_text;
    }
    
    /**
    * Sets the maximum length of menu from selected in one direction.
    *
    * @return void
    * @param integer $max
    * @access public
    */
    function setMaxElementsFromCenter( $max )
    {
        $this->maxElementsFromCenter = $max;
    }

    /**
    * Sets the additional params which added to target URL.
    *
    * @return void
    * @param string $params
    * @access public
    */
    function setAdditionalParams( $params )
    {
        if (substr($params, 0, 1) == "&")
            $this->additionalParams = $params;
        elseif (!empty($params))
            $this->additionalParams = "&" . $params;
    }

    /**
    * Returns the array with data elements.
    *
    * @return array
    * @access public
    */
    function getDataElements()
    {
        return $this->dataElements;
    }

}  

?>