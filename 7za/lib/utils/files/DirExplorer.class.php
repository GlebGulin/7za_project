<?PHP 
/**
* The class for generating the listing of a directory.
*
* @author   Alex Koshel <alex@belisar.de>
* @version  1.0 (07.03.2005)
* @package  utils
*/

class DirExplorer extends wrapper
{ 
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    
    var $dirStructure           = array();
    var $avoidNames             = array();
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * The constructor.
     */
    function DirExplorer()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	
    	
    /**
    * The main function, used for getting dir's content.
    *
    * @return   array
    * @param    string  $dir
    */
    function getContent( $dir )
    {
        if (!is_dir($dir))
            $this->addDebugMsg("$dir is not a directory", "DirExplorer error");
        $this->dirStructure = array();
        $this->getDirContent($dir, $this->dirStructure);
        
        return $this->dirStructure;
    }
    
    /**
    * The method for setting file and dir names for ignoring.
    *
    * @return   void
    * @param    string  $names
    */
    function setAvoidNames( $names )
    {
        $this->avoidNames = explode(" ", $names);
    }
    
    /**
    * Recursive function for generating dir content.
    *
    * @return   array
    * @param    string  $dir
    * @param    array   $contentAry
    */
    function getDirContent( $dir, &$contentAry )
    {
        $contentAry["dir_name"] = $dir;
        $contentAry["files"] = array();
        $contentAry["dirs"] = array();
        
        $content = $this->scandir($dir);
        foreach ($content as $file)
        {
            if ($file != "." && $file != "..")
            {
                $match = false;
                $i = 0;
                while ($i<count($this->avoidNames) && !$match)
                {
                    if (preg_match("/".$this->avoidNames[$i]."/", $file))
                        $match = true;
                    $i++;
                }
                
                if (!$match)
                {
                    if (is_file($dir . DIR_SEP . $file))
                        $contentAry["files"][] = $file;
                    elseif (is_dir($dir . DIR_SEP . $file))
                    {
                        $num = count($contentAry["dirs"]);
                        $contentAry["dirs"][$num] = array();
                        $this->getDirContent($dir . DIR_SEP . $file, $contentAry["dirs"][$num]);
                    }
                }
            }
        }
    }
    
    /**
    * The function for making list of files in given directory (analog scandir() in PHP5).
    *
    * Returns an array of files and dirs of $dir folder.
    *
    * @return   array
    * @param    string  $dir    The directory for listing files in it
    */
    function scandir( $dir )
    {
        $dh  = opendir($dir);
        $files = array();
        while (false !== ($filename = readdir($dh)))
        {
            $files[] = $filename; 
        }
        closedir($dh);
        sort($files);
        return $files;
    }
    
}
?>