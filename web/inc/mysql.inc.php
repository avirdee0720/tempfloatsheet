<?php
/*****************************************************************************/
/*                                                                           */
/*  mySQL Function Wrapper Class                                             */
/*                                                                           */
/*  (C) 2001 Thomas Wolf (two@DONTSPAMMEchello.at)                                     */
/*                                                                           */
/*  Wed 21 Nov 17:41:53 2001                                                 */
/*  Thu 29 Nov 19:20:22 2001 -lu                                             */
/*                                                                           */
/*****************************************************************************/



define("CMySQL_Included","1");

class CMySQL
{
    // default values

    var $def_host   = "localhost";        // default host name
    var $def_user   = "floatsheetweb";    // default user name
    var $def_pass   = "16nEwi7udokO";     // default password
    var $def_dbname = "floatsheets";      // default database name

    // class-internal variables
    var $linkid     = 0;             // mysql link id
    var $errstr     = "";            // last mysql error string
    var $lastsql    = "";            // last mysql query
    var $last_result;                // last mysql query result
    var $m_start    = 0;
    var $m_diff     = 0;

    /* Constructor:
     *  Set default values and stuff.
     */
    function CMySQL()
    {
        $errstr = "no connection";
    }
    /* CMySQL->Open:
     *  Connect to specified mySQL server.
     */
    function Open($dbname="",$host="",$user="",$pass="",$pcon=0)
    {
        // use defaults?
        if (!$dbname) $dbname = $this->def_dbname;
        if (!$host  ) $host   = $this->def_host;
        if (!$user  ) $user   = $this->def_user;
        if (!$pass  ) $pass   = $this->def_pass;

        // open persistent or normal connection
        if ($pcon) {
            $this->linkid = @mysql_pconnect($host,$user,$pass);
        } else {
            $this->linkid = @mysql_connect ($host,$user,$pass);
        }
        // connect to mysql server failed?
        if (!$this->linkid)
        {
            $this->errstr  = $pcon ? "persistent " : "";
            $this->errstr .= "connect failed ('$user:haselo@$host')";
            return 0; // error
        }
        // select database
        $result = mysql_select_db($dbname);
        if (!$result)
        {
            // db select failed
            @mysql_close($this->linkid);
            $this->errstr = "database not found ('$dbname')";
            return 0; // error
        }
        // return with success
        return 1;
    }
    /* CMySQL->Test:
     *  Tests a database connection and returns
     *  1 on success or 0 on error.
     */
    function Test($dbname,$host="",$user="",$pass="")
    {
        return $this->Open($dbname,$host,$user,$pass,0);
    }
    /* CMySQL->Error:
     *  Returns the last mySQL error as text.
     */
    function Error()
    {
        if (!empty($this->errstr))
            return $this->errstr."<br>\n";

        if (empty($this->linkid))
        {
            $this->errstr = "no BD link!";
            $em = $this->errstr;
        }
        else {
            $en = @mysql_errno($this->linkid);
            $em = @mysql_error($this->linkid);
            if (!$en || !$em)
            {
                $this->errstr = "no connection";
                $em = $this->errstr;
                if (!$en) $en = "0";
            }
        }
        return "$em (#$en)<br>\n";
    }
    /* CMySQL->Kill:
     *  Dies script with last mySQL error message.
     */
    function Kill()
    {
        die ($this->Error());
    }
    /* CMySQL->ErrorNum:
     *  Returns the last mySQL error as number.
     */
    function ErrorNum()
    {
        return @mysql_errno($this->linkid);
    }
    /* CMySQL->Close:
     *  Close current mySQL connection.
     */
    function Close()
    {
        return @mysql_close($this->linkid);
    }
    /* CMySQL->Query:
     *  Executes the given SQL query and returns
     *  the proper results.
     */
    function Query($sql="")
    {
        $this->lastsql = $sql;
        $this->last_result = @mysql_query($sql,$this->linkid);
        if (!$this->last_result)
        {
            $en = @mysql_errno($this->linkid);
            $em = @mysql_error($this->linkid);
			$this->errstr = "query failed ('$sql')<br>\n $em (#$en)";
            return 0; // error
        }
        return $this->last_result;
    }
    /* CMySQL->QueryM:
     *  Executes the given SQL query, measures
     *  it and returns the proper results.
     */
    function QueryM($sql="")
    {
        $this->Start();
        $result = $this->Query($sql);
        $this->Stop();
        return $result;
    }
    /* CMySQL->Start:
     *  Starts time measurement.
     */
    function Start()
    {
        $parts = explode(" ",microtime());
        $this->m_diff  = 0;
        $this->m_start = $parts[1].substr($parts[0],1);
    }
    /* CMySQL->Stop:
     *  Stops time measurement.
     */
    function Stop()
    {
        $parts  = explode(" ",microtime());
        $m_stop = $parts[1].substr($parts[0],1);
        $this->m_diff  = ($m_stop - $this->m_start);
        $this->m_start = 0;
    }
    /* CMySQL->Duration:
     *  Returns last measured duration (time
     *  between Start() and Stop()).
     */
    function Duration($decimals=4)
    {
        return number_format($this->m_diff,$decimals);
    }
    /* CMySQL->Rows:
     *  Returns the last query's number of rows.
     */
    function Rows()
    {
        if (!$this->last_result) return 0;
        return @mysql_num_rows($this->last_result);
    }
    /* CMySQL->Fix:
     *  Returns string suitable for mySQL queries.
     */
    function Fix($str)
    {
        return @addslashes($str);
    }
    /* CMySQL->Unfix:
     *  Returns mySQL string as normal string.
     */
    function Unfix($str)
    {
        return @stripslashes($str);
    }
    /* CMySQL->Row:
     *  Reads the current row and returns contents
     *  as an PHP object or returns 0 on error.
     */
    function Row()
    {
        if ($this->last_result) {
            $row = mysql_fetch_object($this->last_result);
        } else {
            $row = 0;
        }
        return $row;
    }
    /* CMySQL->RowA:
     *  Reads the current row and returns contents
     *  as an array or returns 0 on error.
     */
    function RowA()
    {
        if ($this->last_result) {
            $row = mysql_fetch_array($this->last_result);
        } else {
            $row = 0;
        }
        return $row;
    }
    /* CMySQL->Seek:
     *  Sets the internal database pointer to the
     * specified row number and returns the result.
     */
    function Seek($rownum)
    {
        return mysql_data_seek($this->last_result,$rownum);
    }
    /* CMySQL->Free:
     *  Frees memory used by the query results and
     *  returns the function result.
     */
    function Free()
    {
        return @mysql_free_result($this->last_result);
    }
}
/*****************************************************************************/
?>
