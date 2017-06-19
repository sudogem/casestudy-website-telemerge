<?php
/**
 * @author		Arman Ortega <arman.ortega@yahoo.com> 
 * @copyright	Telemerge Corporation
 * @created		jan 07 2006
 */

class status extends database
{
	var $table_status = 'status';
	var $table_testimonial_status = 'testimonial_status';
	
	function status()
	{
		// nothing to say , get lost ,,
	}
	
	function &getInstance()
	{
		static $instance ;
		if ( !isset( $instance ) )
		{
			$instance = new status();
		}
		return $instance ;
	}
	
	function setStatusId( $id )
	{
		$this->statusID = $id ;
	}

	function setTestiStatusId( $id )
	{
		$this->testi_statusID = $id ;
	}
	
	function setStatus( $stats )
	{
		$this->status = $stats ;
	}

	function setTestiStatus( $stats )
	{
		$this->testi_status = $stats ;
	}
	
	function getStatusId()
	{
		return $this->statusID ;
	}

	function getTestiStatusId()
	{
		return $this->testi_statusID ;
	}
	
	function getStatus()
	{
		return $this->status  ;
	}

	function getTestiStatus()
	{
		return $this->testi_status  ;
	}
	
	function getAllStatus ()
	{
		$sql = " select * from $this->table_status ";
		$result = $this->query( $sql );
		$status = array();
		while( $row = $this->fetchobject() ) $status[] = $row ;
		return $this->formatStatusResultSet( $status );
	}
	
	function getStatusById( $id )
	{
		$sql = " select * from $this->table_status ";
		$sql .= " where statusID = " . intval( $id );
		$result = $this->query( $sql );		
		$status = array();		
		while( $row = $this->fetchobject() ) $status[] = $row ;
		return $this->formatStatusResultSet( $status );
	}
	
	function getTestimonialStatusById( $id )
	{
		$sql = " select * from $this->table_testimonial_status ";
		$sql .= " where statusID = " . intval( $id ) ;
		$result = $this->query( $sql );
		$status = array();
		while( $row = $this->fetchobject() ) $status[] = $row ;
		return $this->formatTestiStatusResultSet( $status );
	}
	
	function getAllTestimonialStatus()
	{
		$sql = " select * from $this->table_testimonial_status ";
		$result = $this->query( $sql );
		$status = array();
		while( $row = $this->fetchobject() ) $status[] = $row ;
		return $this->formatTestiStatusResultSet( $status );
	}
	
	function formatTestiStatusResultSet( $result ) 
	{
		$statusdata = array();
		if ( $result != null )
		{
			$n = count( $result ) ;
			for( $i=0 ; $i < $n ; $i++ )
			{
				$status = new status();
				$status->setTestiStatusId ( $result[$i]->statusID );
				$status->setTestiStatus ( $result[$i]->status );
				$statusdata[$i] = $status ;
			}
			return $statusdata ;
		}
	}
	
	function formatStatusResultSet( $result ) 
	{
		$statusdata = array();
		if ( $result != null )
		{
			$n = count( $result ) ;
			for( $i=0 ; $i < $n ; $i++ )
			{
				$status = new status();
				$status->setStatusId ( $result[$i]->statusID );
				$status->setStatus ( $result[$i]->status );
				$statusdata[$i] = $status ;
			}
			return $statusdata ;
		}
	}
	
	
}
?>