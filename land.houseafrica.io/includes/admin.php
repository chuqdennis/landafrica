<?php
	include("dbc.php");
	/**
	 * 
	 */
	class admin extends config
	{
		public function adminLogin($data)
		{
			$result = $this->query($data);
			if ($this->getRows($result) > 0) {
				$row = $this->getArray($result);
				return $row;
			}
			else{
				return 'false';
			}
		}

		public function checkLandDuplicate($title){
			$q = $this->getRows($this->query("SELECT * FROM lands WHERE landTitle='$title' "));
			return $q;
		}

		public function allLandRows(){
			$q = $this->getRows($this->query("SELECT * FROM lands"));
			return $q;
		}

		public function saveMember($fullname,$email,$photo,$position,$phone)
		{
			$date = date("Y-F-d");
	    	$ins = $this->query("INSERT INTO our_team(fullname,email,position,phone,pic,date_added) VALUES('$fullname', '$email', '$position', '$phone', '$photo', '$date')");
	    	if ($ins == true) {
				return 'done';
	    	}else{
	    		return '<span>Failed To add member, please try again later</span>';
	    	}
		}

		public function siteQuery($query)
		{
	    	$ins = $this->query($query);
	    	if ($ins == true) {
				return 'done';
	    	}else{
	    		return 'error';
	    	}
		}

		public function landStatus($status)
		{
	    	if ($status == 'Allocated') {
	    		$badge = 'info';
	    	}elseif ($status == 'Vacant') {
	    		$badge = 'warning';
	    	}elseif ($status == 'Mixed') {
	    		$badge = 'success';
	    	}else{
	    		$badge = 'info';
	    	}
	    	return $badge;
		}

		public function mapStatus($status)
		{
	    	if ($status == 'Allocated') {
	    		$badge = '#926dde';
	    	}elseif ($status == 'Vacant') {
	    		$badge = '#ffba00';
	    	}elseif ($status == 'Mixed') {
	    		$badge = '#0cca0c';
	    	}else{
	    		$badge = '#926dde';
	    	}
	    	return $badge;
		}

		public function saveLand($query)
		{
	    	$ins = $this->query($query);
	    	if ($ins == true) {
				return 'done';
	    	}else{
	    		return 'error';
	    	}
		}

		public function projectAction($query,$action)
		{
	    	$ins = $this->query($query);
	    	if ($ins == true) {
				return $action;
	    	}else{
	    		return 'failed';
	    	}
		}

		public function getLands($status,$offset,$limit){
			if ($status == 'All') {
			  $query = $this->query("SELECT * FROM lands LIMIT {$limit} OFFSET {$offset}");
			}else{
			  $query = $this->query("SELECT * FROM lands WHERE status='$status' ORDER BY id DESC");
			}
			$services = array();
            while($row = $this->getArray($query)){
                $obj = new stdClass();
                $obj->id = $row["id"];
                $obj->landTitle = $row["landTitle"];
                $obj->land_type = $row["land_type"];
                $obj->estate_id = $row["estate_id"];
                $obj->landId = $row["landId"];
                $obj->coords = $row["coords"];
                $obj->postal_code = $row["postal_code"];
                $obj->area = $row["area"];
                $obj->address = $row["address"];
                $obj->state = $row["state"];
                $obj->city = $row["city"];
                $obj->status = $row["status"];
                $obj->currentOwner = $row["currentOwner"];
                $obj->prevOwner = $row["prevOwner"];
                $obj->txnID = $row["txnID"];
                $obj->txnLink = $row["txnLink"];
                $obj->dateAdded = $row["dateAdded"];
                $coords = $row['coords'];
                $codSplit = $this->split(",",$coords);
            	foreach ($codSplit as $key => $value) {
            	  $codSplit2 = $this->split(":",$value);
            	  $arr1 = array("lat" => (double)$codSplit2[0], "lng" => (double)$codSplit2[1]);
            	  $lat = (double)$codSplit2[0];
            	  $lng = (double)$codSplit2[1];
            	}
            	$obj->lat = $lat;
                $obj->lng = $lng;
                $services[] = $obj;
            }
            return $services;
		}

		public function getEstates(){
			$query = $this->query("SELECT * FROM lands WHERE land_type='Estate' ");
			$services = array();
            while($row = $this->getArray($query)){
                $obj = new stdClass();
                $obj->id = $row["id"];
                $obj->landTitle = $row["landTitle"];
                $obj->land_type = $row["land_type"];
                $obj->estate_id = $row["estate_id"];
                $obj->landId = $row["landId"];
                $services[] = $obj;
            }
            return $services;
		}

		public function split($delimeter,$data){
			$result = explode($delimeter,$data);
			return $result;
		}

		public function checkForType($type)
		{
			if ($type == 'Estate') {
				$fill = 0.1;
			}else{
				$fill = 0.5;
			}
			return $fill;
		}
		public function getLandsForMap(){
			  $query = $this->query("SELECT * FROM lands");
			$services = array();
            while($row = $this->getArray($query)){
            	$path = array();
            	$coords = $row['coords'];
            	$id = $row['id'];
            	$status = $row['status'];
            	$land_type = $row['land_type'];
            	$fill = $this->checkForType($land_type);
            	$color = $this->mapStatus($status);
            	$codSplit = $this->split(",",$coords);
            	foreach ($codSplit as $key => $value) {
            	  $codSplit2 = $this->split(":",$value);
            	  $arr1 = array("lat" => (double)$codSplit2[0], "lng" => (double)$codSplit2[1]);
            	  $path[] = $arr1;
            	}
            	$mini = array("cords"=>$path,"id"=> $id,"color"=>$color,"fill"=>$fill);
                $services[] = $mini;
            }
            return $services;
		}

		public function getLandsForMapById($id){
			  $row = $this->getArray($this->query("SELECT * FROM lands WHERE id='$id' "));
            	$path = array();
            	$coords = $row['coords'];
            	$status = $row['status'];
            	$color = $this->mapStatus($status);
            	$codSplit = $this->split(",",$coords);
            	foreach ($codSplit as $key => $value) {
            	  $codSplit2 = $this->split(":",$value);
            	  $arr1 = array("lat" => (double)$codSplit2[0], "lng" => (double)$codSplit2[1]);
            	  $lat = (double)$codSplit2[0];
            	  $lng = (double)$codSplit2[1];
            	  $path[] = $arr1;
            	}
            	$mini = array("cords"=>$path,"id"=> $row['id'],"lat"=>$lat,"lng"=>$lng,"color"=>$color);
            	$res = json_encode($mini);
            	return $res;
		}

		public function getEstateMapById($id){
			   $query = $this->query("SELECT * FROM lands WHERE id='$id' OR estate_id='$id' ");
            	$services = array();
	            while($row = $this->getArray($query)){
	            	$path = array();
	            	$coords = $row['coords'];
	            	$id = $row['id'];
	            	$status = $row['status'];
	            	$land_type = $row['land_type'];
	            	$fill = $this->checkForType($land_type);
	            	$color = $this->mapStatus($status);
	            	$codSplit = $this->split(",",$coords);
	            	foreach ($codSplit as $key => $value) {
	            	  $codSplit2 = $this->split(":",$value);
	            	  $arr1 = array("lat" => (double)$codSplit2[0], "lng" => (double)$codSplit2[1]);
	            	  $path[] = $arr1;
	            	}
	            	$mini = array("cords"=>$path,"id"=> $id,"color"=>$color,"fill"=>$fill);
	                $services[] = $mini;
	            }
	            return $services;
		}

		public function searchLands($searchWord,$status){
			if ($status == 'All') {
				$query = $this->query("SELECT * FROM lands WHERE landTitle LIKE '%$searchWord%' OR landId LIKE '%$searchWord%' OR address LIKE '%$searchWord%' OR state LIKE '%$searchWord%' OR city LIKE '%$searchWord%' OR currentOwner LIKE '%$searchWord%' ");
			}else{
				$query = $this->query("SELECT * FROM lands WHERE status = '$status' AND (landTitle LIKE '%$searchWord%' OR landId LIKE '%$searchWord%' OR address LIKE '%$searchWord%' OR state LIKE '%$searchWord%' OR city LIKE '%$searchWord%' OR currentOwner LIKE '%$searchWord%') ");
			}
			$search = array();
            while($row = $this->getArray($query)){
                $obj = new stdClass();
                $obj->id = $row["id"];
                $obj->landTitle = $row["landTitle"];
                $obj->landId = $row["landId"];
                $obj->postal_code = $row["postal_code"];
                $obj->land_type = $row["land_type"];
                $obj->estate_id = $row["estate_id"];
                $obj->coords = $row["coords"];
                $obj->area = $row["area"];
                $obj->address = $row["address"];
                $obj->state = $row["state"];
                $obj->city = $row["city"];
                $obj->status = $row["status"];
                $obj->currentOwner = $row["currentOwner"];
                $obj->prevOwner = $row["prevOwner"];
                $obj->txnID = $row["txnID"];
                $obj->txnLink = $row["txnLink"];
                $obj->dateAdded = $row["dateAdded"];
                $coords = $row['coords'];
                $codSplit = $this->split(",",$coords);
            	foreach ($codSplit as $key => $value) {
            	  $codSplit2 = $this->split(":",$value);
            	  $arr1 = array("lat" => (double)$codSplit2[0], "lng" => (double)$codSplit2[1]);
            	  $lat = (double)$codSplit2[0];
            	  $lng = (double)$codSplit2[1];
            	}
            	$obj->lat = $lat;
                $obj->lng = $lng;
                $search[] = $obj;
            }
            return $search;
		}

		public function getLandInfo($id){
				$row = $this->getArray($this->query("SELECT * FROM lands WHERE id='$id' "));
                $obj = new stdClass();
                $obj->id = $row["id"];
                $obj->landTitle = $row["landTitle"];
                $obj->landId = $row["landId"];
                $obj->coords = $row["coords"];
                $obj->postal_code = $row["postal_code"];
                $obj->area = $row["area"];
                $obj->address = $row["address"];
                $obj->state = $row["state"];
                $obj->city = $row["city"];
                $obj->status = $row["status"];
                $obj->currentOwner = $row["currentOwner"];
                $obj->prevOwner = $row["prevOwner"];
                $obj->txnID = $row["txnID"];
                $obj->txnLink = $row["txnLink"];
                $obj->dateAdded = $row["dateAdded"];
                return $obj;
		}
		public function getSiteInfo(){
				$row = $this->getArray($this->query("SELECT * FROM site_settings"));
                $obj = new stdClass();
                $obj->id = $row["id"];
                $obj->myAdmin = $row["myAdmin"];
                $obj->about_us = $row["about_us"];
                $obj->after_sale_support = $row["after_sale_support"];
                $obj->more_on_maintenance = $row["more_on_maintenance"];
                $obj->slogan = $row["slogan"];
                $obj->address = $row["address"];
                $obj->phone1 = $row["phone1"];
                $obj->phone2 = $row["phone2"];
                $obj->email = $row["email"];
                $obj->banner_desc = $row["banner_desc"];
                $obj->banner_pic = json_decode($row["banner_pic"], JSON_PRETTY_PRINT);
                $obj->g_map_address = $row["g_map_address"];
                $obj->company_name = $row["company_name"];
                $obj->fb_link = $row["fb_link"];
                $obj->tw_link = $row["tw_link"];
                $obj->ig_link = $row["ig_link"];
                $obj->lk_link = $row["lk_link"];
                $obj->logo = $row["logo"];
            	return $obj;
		}

		public function wavesTransaction($signers)
	    {
	            $data = array("version" => "1", "sender" => "3PBjfSe5jKzXUQbN4A2VG64TLFfAUEN9zca","data"=>$signers,"type"=>12,"fee"=>100000);                                      
	            $data_string = json_encode($data,JSON_PRETTY_PRINT);                              
	            $ch = curl_init('https://demitto.serveo.net/transactions/sign'); 
	            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                               
	                  'Content-Type: application/json',                                                                                
	                  'Content-Length: ' . strlen($data_string),
	                  'X-API-Key: Assotel@1')                                                                       
	              );
	              $response_body = curl_exec($ch);
	              if (curl_error($ch)) {
	                return 'error';
	              }else{
	                $res = json_decode($response_body);
	                $txnID = $res->id;
	                $ch = curl_init('https://nodes.wavesnodes.com/transactions/broadcast'); 
	            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($ch, CURLOPT_POSTFIELDS, $response_body);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                           
	            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	                      'Content-Type: application/json',                                                                                
	                      'Content-Length: ' . strlen($response_body),
	                      'X-API-Key: Assotel@1')                                                                       
	                  );
	                  $broadcast = curl_exec($ch);
	                  return $txnID;
	              }
	    }
		public function logout(){
			// remove all session variables
			session_unset();
			// destroy the session
			session_destroy(); 
		}
	}

?>