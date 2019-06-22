<?php

/**
 * 
 */
class config
{
	
	public function open()
	{
			 $con = mysqli_connect("localhost","housnjtd_land_registry","EBJxSmZJDheU","housnjtd_land_registry");
			//$con = mysqli_connect("localhost","root","","land_registry");

		// Check connection
		if (mysqli_connect_errno())
		{
		    //echo "Failed to connect to MySQL: " . mysqli_connect_error();
		    echo "System failed to connect to server";
		}else{
			return $con;
		}
	}

	public function close($con)
	{
		mysqli_close($con);
	}

	public function query($query)
	{
		$con = $this->open();
			$q = mysqli_query($con,$query);
			return $q;
		$this->close($con);
	}
	public function getArray($query)
	{
			$q = mysqli_fetch_array($query);
			return $q;
	}
	public function getRows($query)
	{
			$q = mysqli_num_rows($query);
			return $q;
	}
	public function checkDuplicate($email){
		$q = $this->getRows($this->query("SELECT * FROM user WHERE email='$email' "));
		return $q;
	}
}

?>