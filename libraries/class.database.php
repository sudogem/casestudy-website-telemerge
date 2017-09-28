<?php
/**
 * @author		Arman Ortega
 * @created		Dec 30 2006
 */

class database
{
  var $conn;
  var $host = '' ;
  var $username = '' ;
  var $password = '' ;
  var $databasename = '' ;
  /**
   * connect to the database
   */
  function database( $host = '' , $username = '' , $password = '' , $databasename = '' )
  {
    global $conn;
    // $this->conn = mysql_connect( $host , $username , $password ) or die(mysql_error());
    $this->conn = mysqli_connect( $host , $username , $password, $databasename) or die('mysqli_connect:' . mysql_error());
    $conn = $this->conn;
    if ( !$this->conn ) die('Cannot connect to database. ');
    // $db = mysql_select_db($databasename, $this->conn);
    // if ( !$db ) die( $this->error() );
    return $this->conn;
  }

  function &getInstance( ) {
    static $instance;
    if ( !isset( $instance ) ) {
      $instance = new database ( $host , $username , $password , $databasename ) ;
    }
    return $instance;
  }

  /**
   * performs a sql query
   */
  function query( $sql )
  {
    global $conn;
    if ( $sql != '' )
    {
      // $this->query_result = mysql_query($sql, $conn);
      $this->query_result = mysqli_query($conn, $sql);
      print '<br><br>';
      print_r('query() $this->query_result: ');
      print_r($this->query_result);
      return $this->query_result;
      // if ( !$this->query_result )
      // {
      //   return false;
      // }
      // else
      // {
      //   return true;
      // }
    }
  }

  function buffered_query( $sql , $type = 'OBJECT' )
  {
    if ( $sql != '' )
    {
      $buffered_data = array( );
      if ( $type == 'OBJECT' )
      {
        $result = $this->query( $sql );
        while( $row = $this->fetchobject($result) )
        {
          $buffered_data[] = $row ;
        }
      }
      elseif ( $type == 'ARRAY' )
      {
        $result = $this->query( $sql );
        while( $row = $this->fetcharray( ) )
        {
          $buffered_data[] = $row ;
        }
      }
      return $buffered_data ;
    }
  }

  /**
   * get query results in objects
   */
  function fetchobject( $resourceid = 0 )
  {
    global $conn;
    if ( !$resourceid ) $resourceid = $this->query_result;
    // $this->row = mysql_fetch_object( $resourceid );
    $this->row = mysqli_fetch_object($resourceid);
    print_r('fetchobject() resourceid: ');
    print_r($resourceid);
    print '<br><br>';
    print_r('fetchobject() $this->query_result: ');
    print_r($this->query_result);
    return $this->row;
  }


  /**
   * get query results in array
   */
  function fetcharray( $resourceid = 0 )
  {
    if ( !$resourceid ) $resourceid = $this->query_result;
    // $this['row'] = mysql_fetch_array( $resourceid );
    $this['row'] = mysqli_fetch_array( $resourceid );
    return $this['row'];
  }

  /**
   * will free all memory associated with the result identifier result.
   */
  function freeresult( $result = 0 )
  {
    if ( !$result ) $result = $this->query_result;
    // mysql_free_result( $result );
    mysqli_free_result( $result );
  }

  /**
   * get the number of recordset rows
   */
  function getnumrows( $result = 0 )
  {
    if ( !$result ) $result = $this->query_result;
    // return mysql_num_rows( $result );
    return mysqli_num_rows($this->query_result);
  }

  function close() {
    if ( $this->conn ) {
      // @mysql_close( $this->conn );
      @mysqli_close( $this->conn );
      unset( $this->conn );
    }
  }

  /**
  * Get the ID generated from the previous INSERT operation
  */
  function getInsertID()
  {
    // return mysql_insert_id($this->conn);
    return mysqli_insert_id($this->conn);
  }

  /**
   * return previous mysql errors
   */
  function error()
  {
    // return mysql_error();
    return mysqli_error();
  }

  /**
   * attach quote chars to strings
   */
  function quote( $str )
  {
    return "'" . $str . "'";
  }

  /**
   * Escapes special characters in a string for use in a SQL statement
   */
  function real_escape_str( $str )
  {
    if ( get_magic_quotes_gpc( ) )  $str = stripslashes( $str );
    // return mysql_real_escape_string( $str ) ;
    return mysqli_real_escape_string( $str ) ;
  }

}
?>
