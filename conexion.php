<?php

class Conexion
{
	private $con;
	private $id;
	
	function __construct()
	{
		$this->con = mysqli_connect("localhost","williams","Palacios","webfinanza") or die ("Error " . mysqli_error($this->con));
	}

	public function retrieveQuery($sql)
	{
		$query = $this->con->query($sql);
		$this->id = mysqli_insert_id($this->con);
		
		return $query;
	}
	
	public function retrieveArray($sql)
	{
		$array = array();
		$res = $this->retrieveQuery($sql);
		
		while($row = mysqli_fetch_array($res))
		{
			$array[] = $row;
		}
		
		return $array;
	}
	
	public function retrieveLastID()
	{
		return $this->id;
	}
	
	public function retrieveField($sql)
	{
		$retorno = '';
		$res = $this->retrieveQuery($sql);
		
		while($row = mysqli_fetch_array($res))
		{
			$retorno = $row[0];
		}
		
		return $retorno;
	}
}

?>
