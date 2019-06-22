<?php
        include_once ("session.php");
        include_once ("admin.php");
        
        $site = new admin;
        $title = htmlentities(trim($_POST["title"]));
        $address = htmlentities(trim($_POST["address"]));
        $type = htmlentities(trim($_POST["type"]));
        $estate = htmlentities(trim($_POST["estate"]));
        $state = htmlentities(trim($_POST["state"]));
        $city = htmlentities(trim($_POST["city"]));
        $area = htmlentities(trim($_POST["area"]));
        $status = htmlentities(trim($_POST["status"]));
        $owner = htmlentities(trim($_POST["owner"]));
        $postal_code = htmlentities(trim($_POST["postal_code"]));
        $method = htmlentities(trim($_POST["method"]));
        if ($method == 'geojson') {
            $str = file_get_contents($_FILES['myGeo']['tmp_name']);
            $json = json_decode($str, true);
            $cordy = $json['features'][0]['geometry']['coordinates'][0];
            $num = count($cordy);
            if ($num < 3) {
                $ckr = 'nada';
                echo "Sorry, we are unable to parse this file, please make sure you uploaded the right file type";
            }else{
                $ckr = 'si';
                $cords = '';
                foreach ($cordy as $key => $value) {
                    $cords .= $value[0].':'.$value[1].',';
                }
                $cords = rtrim($cords,',');
            } 
        }elseif ($method == 'cordinate') {
            $ckr = 'si';
          $cords = htmlentities(trim($_POST["cords"]));  
        }else{
            $ckr = 'nada';
            echo "Sorry, looks like you didn\'t select a cordinate method";
        }

        if ($ckr != 'nada') {
            $coordinates = '{'.$cords.'}';
            $date = date('d-F-Y');
            $characters = '123456789ABCDEFGHIJKLMNOPQRSTUV';
            $characterslength=31;
            $randomString='';
            for ($i = 1; $i < 7; $i++){
               $randomString.=$characters[rand(0,$characterslength - 1)];
            }
            $landId = 'RGY-'.$randomString;
            $check = $site->checkLandDuplicate($title);
            if ($check > 0) {
               echo "Sorry this land already exist";     
            }else{
                       $signers = array(
                        array("key"=>"Transaction_description","type"=>"string","value"=>"Land Registry"),
                        array("key"=>"Land_title","type"=>"string","value"=>$title),
                        array("key"=>"Address","type"=>"string","value"=>$address),
                        array("key"=>"Postal_code","type"=>"string","value"=>$postal_code),
                        array("key"=>"Coordinates","type"=>"string","value"=>$coordinates),
                        array("key"=>"Status","type"=>"string","value"=>$status),
                        array("key"=>"Area","type"=>"string","value"=>$area),
                        array("key"=>"LandID","type"=>"string","value"=>$landId),
                        array("key"=>"Date","type"=>"string","value"=>$date)
                    );
                    $saveSign = $site->wavesTransaction($signers);
                    if ($saveSign != 'error') {
                            $txnID = $saveSign;$link = 'https://wavesexplorer.com/tx/'.$txnID;
                            $query = "INSERT INTO lands (landId, landTitle, coords, postal_code, area, address, state, city, status, currentOwner, txnID,txnLink, prevOwner,dateAdded, lastModified,land_type,estate_id) VALUES('$landId','$title','$cords','$postal_code','$area','$address','$state','$city','$status','$owner','$txnID','$link','N/A','$date','N/A','$type','$estate')";
                            $login = $site->saveLand($query);
                            if ($login == 'false') {
                                    echo 'Sorry, there was error trying to add this land';
                            }else{
                                    echo 'done';
                            }
                    }else{
                     echo "Opps, we could not save transaction on blockchain";
                    }
            }  
        }
        
        
        // $unique=time();
        // $pix=$_FILES['photo']['name'];
        // $pix = $unique.$pix;
        // $rphoto=$_FILES['photo']['tmp_name'];
        // $target="../../passports/".$pix;
        // move_uploaded_file($rphoto, $target);

?>