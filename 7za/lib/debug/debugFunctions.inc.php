<?php

    /**
    * Outputs 1-Dim array as a table.
    *
    * Use this method for debugging purposes only.
    *
    * @return boolean
    * @param array $data 1-Dim array
    */
    function displayArray( $data ) {
        if( empty( $data ) )
        {
            echo "<h3>no elements found</h3>";
            return false;
        }
        
        // write initial table tag
        echo '<table border="0" cellpadding="2" cellspacing="2" style="background-color: #e6eaee"><tr>';
        foreach ($data as $key=>$value)
            echo '<tr><td bgcolor="#DDDDDD">'.$key.'</td><td bgcolor="#DDDDDD">'.$value.'</td></tr>';
        echo '</table>';
        return true;
    }
    
    /**
     * Displays the content of a 2 dimensional array as table.
     *
     * This dirty method is intended for development purposes only.
     * It renders the keys of the first record as <th>.
     *
     * @param   array  $data 2-Dim array
     * @author  Ralf Kramer
     * @return  void
     */  
    function displayRecords( $data )
    {
        if( empty( $data ) )
        {
            echo "<h3>no records found</h3>";
            return ;
        }
        
        // write initial table tag
        echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\" style=\"background-color: #e6eaee\"><tr>";
        
        // add descriptive <th>
        $record = $data[0];
        foreach( $record as $key => $value)
            echo "<th>" .$key ;
        
        // write the records
        for ( $i = 0; $i < count( $data ); $i++)
        {
            echo "<tr>";
            $record = $data[$i];
            foreach( $record as $key => $value)
            {
                // if nec. write it recursive
                if( is_array( $value ) )
                {
                    echo "<td bgcolor=\"#DDDDDD\">";
                    displayRecords( $value );                
                }    
                else 
                {
                    echo "<td bgcolor=\"#DDDDDD\">" . $value ;
                }
            }
        }
        echo "</table>";
    }

    /**
    * This method prepares and outputs the template for the SQL query.
    *
    * You must specify the table name, for which you are going to run a SQL query
    * and an operation type (insert|delete|update|select). After running this method you
    * will get the template of a SQL query on the screen, copy&paste it to query file
    * or do whatever you want with it ;-).
    *
    * @return   void
    * @param    string  $table          table name
    * @param    string  $operation      Type of an operation: insert|delete|update|select
    * @param    int     $indent_size    The quantity of spaces to put as indent
    */
    function queryProposal( $table, $operation = "select", $indent_size = 8 )
    {
        global $core;
        $fields = $core->runQuery( "SHOW FIELDS FROM " . $table, "getIndexArray", __FILE__ . ':' . __LINE__ );
        $operation = strtolower($operation);
        $result     = "";
        $indent     = str_repeat(" ", $indent_size);
        $halfindent = str_repeat(" ", $indent_size - 4);
        $pre_text   = $halfindent . '1 => "' . "\r\n" . $indent . "# query: 1\r\n";
        $post_text  = $halfindent . '",';
        switch ($operation)
        {
            case "insert" :
                            $result = $indent . "INSERT INTO\r\n$indent    " . $table . "\r\n" . $indent ."SET";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . str_pad($field["Field"], 20);
                                $result .= "= '\$this->" . $field["Field"] . "',";
                            }
                            if ($result{strlen($result)-1} == ",") $result = substr($result, 0, strlen($result)-1);
                            $result .= "\r\n";
                            break;
            case "update" :
                            $result = $indent . "UPDATE\r\n$indent    " . $table . "\r\n" . $indent . "SET";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . str_pad($field["Field"], 20);
                                $result .= "= '\$this->" . $field["Field"] . "',";
                            }
                            if ($result{strlen($result)-1} == ",") $result = substr($result, 0, strlen($result)-1);
                            $result .= "\r\n" . $indent . "WHERE";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . str_pad($field["Field"], 20) . "= '\$this->". $field["Field"] ."'\r\n" . $indent . "AND";
                            }
                            if (substr($result, strlen($result)-3, 3) == "AND") $result = substr($result, 0, strlen($result)-3-$indent_size);
                            break;
            case "delete" :
                            $result = $indent . "DELETE FROM\r\n$indent    " . $table . "\r\n" . $indent . "WHERE";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . str_pad($field["Field"], 20) . "= '\$this->". $field["Field"] ."'\r\n" . $indent . "AND";
                            }
                            if (substr($result, strlen($result)-3, 3) == "AND") $result = substr($result, 0, strlen($result)-3-$indent_size);
                            break;
            case "select":
            default :
                            $result = $indent . "SELECT";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . $field["Field"] . ",";
                            }
                            if ($result{strlen($result)-1} == ",") $result = substr($result, 0, strlen($result)-1);
                            $result .= "\r\n" . $indent . "FROM\r\n$indent    " . $table . "\r\n" . $indent . "WHERE";
                            foreach ($fields as $field)
                            {
                                $result .= "\r\n$indent    " . str_pad($field["Field"], 20) . "= '\$this->". $field["Field"] ."'\r\n" . $indent . "AND";
                            }
                            if (substr($result, strlen($result)-3, 3) == "AND") $result = substr($result, 0, strlen($result)-3-$indent_size);
        }
        print "<pre>\r\n" . $pre_text . $result . $post_text . "\r\n</pre>";
    }
    
?>