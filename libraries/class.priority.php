<?php
/**
 * @author		Arman Ortega <arman.ortega@yahoo.com> 
 * @copyright	Telemerge Corporation
 * @created		feb 25 2006
 */

class priority extends database
{
	var $table_priority = 'priority';
	
	function priority()
	{
		
	}
	
	function &getInstance()
	{
		static $instance ;
		if ( !isset( $instance ) )
		{
			$instance = new priority();
		}
		return $instance ;
	}
	
	function setPriorityId( $id )
	{
		$this->priorityId = $id ;
	}
	
	function setPriority( $str )
	{
		$this->prioritys = $str ;
	}
	
	function getPriorityId()
	{
		return $this->priorityId ;
	}
	
	function getPriority()
	{
		return $this->prioritys ;
	}
	
	function getAllPriority ()
	{
		$sql = " select * from $this->table_priority";
		$result = $this->query( $sql ) or die(mysql_error());
		$priorityarr = array();
		while( $row = $this->fetchobject() ) $priorityarr[] = $row ;
		return $this->formatPriorityResultSet( $priorityarr );
	}

	function formatPriorityResultSet( $result ) 
	{
		$prioritydata = array();
		if ( $result != null )
		{
			$n = count( $result ) ;
			for( $i=0 ; $i < $n ; $i++ )
			{
				$objpriority = new Priority();
				$objpriority->setPriorityId ( $result[$i]->priorityId );
				$objpriority->setPriority ( $result[$i]->priority );
				$prioritydata[$i] = $objpriority ;
			}
			return $prioritydata ;
		}
	}
	
}
?>