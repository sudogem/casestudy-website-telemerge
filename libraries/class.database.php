<?php
/**
 * @author    Arman Ortega
 * @created   Dec 30 2006
 */

class database
{
  var $conn;
  var $host = '' ;
  var $username = '' ;
  var $password = '' ;
  var $databasename = '' ;
  public $query_result;
  /**
   * connect to the database
   */
  function database( $host = '' , $username = '' , $password = '' , $databasename = '' )
  {
    global $conn;
    // $this->conn = mysql_connect( $host , $username , $password ) or die(mysql_error());
    switch(DB_PROVIDER){
      case 'mysql':
        $this->conn = mysqli_connect( $host , $username , $password, $databasename) or die(mysql_error());
        $conn = $this->conn;
        if ( !$this->conn ) die('Cannot connect to database. ');
        // $db = mysql_select_db($databasename, $this->conn);
        // if ( !$db ) die( $this->error() );
      break;
      case 'postgres':
        $this->conn = pg_connect("host=$host port=5432 user=$username password=$password dbname=$databasename");
        $conn = $this->conn;
      break;
    }

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
      switch(DB_PROVIDER){
        case 'mysql':
          $this->query_result = mysqli_query($conn, $sql);
          return $this->query_result;
          // if ( !$this->query_result )
          // {
          //   //die( $this->error() );
          //   return false;
          // }
          // else
          // {
          //   return true;
          // }
        break;
        case 'postgres':
          $this->query_result = pg_query($conn, $sql);
          return $this->query_result;
        break;
      }
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
    if ( !$resourceid ) $resourceid = $this->query_result;
    // $this->row = mysql_fetch_object( $resourceid );
      switch(DB_PROVIDER){
        case 'mysql':
          $this->row = mysqli_fetch_object($resourceid);
          return $this->row;
        break;
        case 'postgres':
          $this->row = pg_fetch_object($resourceid);
          return $this->row;
        break;
      }
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
      switch(DB_PROVIDER){
        case 'mysql':
          return mysqli_num_rows( $result );
        break;

        case 'postgres':
          return pg_num_rows( $result );
        break;
      }
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
    global $conn;
    if ( get_magic_quotes_gpc( ) )  $str = stripslashes( $str );
    // return mysql_real_escape_string( $str ) ;
    return mysqli_real_escape_string($conn, $str);
  }

}
?>
