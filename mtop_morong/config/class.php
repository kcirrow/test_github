<?php

session_start();
/**
 * 
 */
class Myclass extends Dbh
{
	public $lastdata = 0;
	private $dbname = "bplomorongrizal_mtop";
	private $uza = "root";
	private $pazz = "";
	
	public function printsession () {
	    return $_SESSION['fullname'];
	}

	public function base_url()
	{
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$burl =  "/mtop_morong";
		return $burl;
	}
	
	public function generatePIN() {
		$data = $this->connect()->query("SELECT humanid FROM tbl_humans");
		$data->execute();
		$dataz = $data->fetch(PDO::FETCH_ASSOC);
		
		foreach($data as $key) {
		    $stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', max(right(humanpin, 5)) + 1), 5, 0) as autopin FROM tbl_humans");
    		$stmt->execute();
    		$pin = $stmt->fetch();
    		$pin = $this->random_str() . "-" . date("Y") . "-" . $pin['autopin'];
    		
    		$x = $this->connect()->prepare("UPDATE tbl_humans SET humanpin = ? WHERE humanid = ?");
    		$x->bindValue(1, $pin);
    		$x->bindValue(2, $key['humanid']);
    		$x->execute();
    		
    		echo $pin + " assigned to " + $key['humanid'] + "<br>";
		}
	}

	public function checkAddressOrigin($addr) {
		$arr_addr = explode(',', $addr);
		// var_dump($arr_addr);
		// echo "<br>";
		foreach($arr_addr AS $key => $value){
			$stmt = $this->conn()->prepare("SELECT a.brgyCode, a.brgyDesc, b.citymunCode, b.citymunDesc, c.provCode, c.provDesc, d.regCode, d.regDesc FROM refbrgy AS a JOIN refcitymun AS b ON a.citymunCode = b.citymunCode JOIN refprovince AS c ON a.provCode = c.provCode JOIN refregion AS d ON a.regCode = d.regCode WHERE UPPER(REPLACE(?, ' ','')) LIKE CONCAT(REPLACE(UPPER(brgyDesc), ' ',''), '%') AND a.citymunCode = '045809'" );
			$stmt->bindValue(1, $value);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				$psaddr = $stmt->fetch(PDO::FETCH_ASSOC);
				return array("houseno" => $addr, "brgyCode" => $psaddr['brgyCode'], "brgyDesc" => $psaddr['brgyDesc'], "citymunCode" => $psaddr['citymunCode'], "citymunDesc" => $psaddr['citymunDesc'], "provCode" => $psaddr['provCode'], "provDesc" => $psaddr['provDesc'], "regCode" => $psaddr['regCode'], "regDesc" => $psaddr['regDesc']);
			}
		}

		return array("houseno" => $addr);
	}

	public function nameDisection ($name) {
		$arr_name = explode(' ',$name);

		$first = "";
		$middle = "";
		$last = "";
		$suf = "";

		for ($i=0; $i < count($arr_name); $i++) {
			if (strpos($arr_name[$i],'JR.') !== false || strpos($arr_name[$i],'SR.') !== false || strpos($arr_name[$i],'III') !== false) {
				$suf = " " .$arr_name[$i];
				continue;
			}

			if (strpos($arr_name[$i], '.')) {
				$middle = " " . $arr_name[$i];
				continue;
			}

			if (!empty($middle)) {
				$last .= (empty($last) ? $arr_name[$i] : " ".$arr_name[$i]);
			} else {
				$first .= (empty($first) ? $arr_name[$i] : " ".$arr_name[$i]);
			}
		} 

		return array("firstname" => $first, "middle" => $middle, "lastname" => $last, "suffix" => $suf);
	} 

	public function formigration () {
		$stmt = $this->connect()->prepare("SELECT * FROM formigration_copy1");
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data as $key => $value) {
			$addr = $this->checkAddressOrigin($value['address']);
			$opname = $this->nameDisection($value['operator_name']);
			$drname = $this->nameDisection($value['driver_name']);
			$dtreg = date_create($value['dtreg']);
			$dtreg = date_format($dtreg, "Y-m-d");
			$today = date_create("2022-11-15");
			$bday = date_create($value['birthdate']);
			$age = date_diff($today, $bday);
			$bday = date_format($bday, "Y-m-d");
			$age = $age->format("%Y");
			$issuedon = date_create($value['issuedon']);
			$issuedon = date_format($issuedon, "Y-m-d");

			$stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', max(right(humanpin, 5)) + 1), 5, 0) as autopin FROM tbl_humans");
  		$stmt->execute();
  		$pin = $stmt->fetch();
  		$pin = $this->random_str() . "-" . date("Y") . "-" . $pin['autopin'];

			$stmt = $this->connect()->prepare("INSERT INTO tbl_humans(last_name, first_name, middle_name, ext_name, address_house_no, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, address_region, mobile_no, birth_date, certno, certon, certat, conperson, conaddress, conconnum, cin, age, humanpin) VALUES (:last_name, :first_name, :middle_name, :ext_name, :address_house_no, :psgc_brgy, :address_brgy, :psgc_municipality, :address_municipality, :psgc_province, :address_province, :psgc_region, :address_region, :mobile_no, :birth_date, :certno, :certon, :certat, :conperson, :conaddress, :conconnum, :cin, :age, :humanpin)");
			$stmt->bindParam(":last_name", $opname['lastname']);
			$stmt->bindParam(":first_name", $opname['firstname']);
			$stmt->bindParam(":middle_name", $opname['middle']);
			$stmt->bindParam(":ext_name", $opname['suffix']);
			$stmt->bindParam(":address_house_no", $addr['houseno']);
			$stmt->bindParam(":psgc_brgy", $addr['brgyCode']);
			$stmt->bindParam(":address_brgy", $addr['brgyDesc']);
			$stmt->bindParam(":psgc_municipality", $addr['citymunCode']);
			$stmt->bindParam(":address_municipality", $addr['citymunDesc']);
			$stmt->bindParam(":psgc_province", $addr['provCode']);
			$stmt->bindParam(":address_province", $addr['provDesc']);
			$stmt->bindParam(":psgc_region", $addr['regCode']);
			$stmt->bindParam(":address_region", $addr['regDesc']);
			$stmt->bindParam(":mobile_no", $value['contactno']);
			$stmt->bindParam(":birth_date", $bday);
			$stmt->bindParam(":certno", $value['cedula']);
			$stmt->bindParam(":certon", $issuedon);
			$stmt->bindParam(":certat", $value['issuedat']);
			$stmt->bindParam(":conperson", $value['emer_name']);
			$stmt->bindParam(":conaddress", $value['emer_addr']);
			$stmt->bindParam(":conconnum", $value['emer_contactno']);
			$stmt->bindParam(":cin", $value['id']);
			$stmt->bindParam(":age", $age);
			$stmt->bindParam(":humanpin", $pin);
			$stmt->execute();

			$stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', max(right(motorpin, 5)) + 1), 5, 0) as autopin FROM tbl_motor");
  		$stmt->execute();
  		$mpin = $stmt->fetch();
  		$mpin =  "MT-" . date("Y") . "-" . $mpin['autopin'];

			$stmt = $this->connect()->prepare("INSERT INTO tbl_motor(motorpin, opercode, drivercode, toda, make, yearmodel, engine, chassis, plateno) VALUES (:motorpin, :opercode, :drivercode, :toda, :make, :yearmodel, :engine, :chassis, :plateno)");
			$stmt->bindParam(":motorpin", $mpin);
			$stmt->bindParam(":opercode", $pin);
			$stmt->bindParam(":drivercode", $pin);
			$stmt->bindParam(":toda", $value['toda']);
			$stmt->bindParam(":make", $value['make']);
			$stmt->bindParam(":yearmodel", $value['year']);
			$stmt->bindParam(":engine", $value['engine']);
			$stmt->bindParam(":chassis", $value['chassis']);
			$stmt->bindParam(":plateno", $value['plateno']);
			$stmt->execute();

			echo "Done! <br>";
		}

		
	}

	public function concataddress($data)
	{
		$addr = "";
		$addr .= (isset($data["address_house_no"]) ? ($data["address_house_no"] != "" ? ($data["address_house_no"] . " ") : "") : "");
		$addr .= (isset($data["address_street_name"]) ? ($data["address_street_name"] != "" ? ($data["address_street_name"] . " ") : "") : "");
		$addr .= (isset($data["address_subdivision"]) ? ($data["address_subdivision"] != "" ? ($data["address_subdivision"] . ", ") : "") : "");
		$addr .= (isset($data["address_brgy"]) ? ($data["address_brgy"] != "" ? ($data["address_brgy"] . ", ") : "") : "");
		$addr .= (isset($data["address_municipality"]) ? ($data["address_municipality"] != "" ? ($data["address_municipality"] . ", ") : "") : "");
		$addr .= (isset($data["address_province"]) ? ($data["address_province"] != "" ? ($data["address_province"] . " ") : "") : "");
		$addr .= (isset($data["address_region"]) ? ($data["address_region"] != "" ? ($data["address_region"] . " ") : "") : "");
		return preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $addr);
	}

	public function concatfullname($data)
	{
		$name = "";
		$name .= ($data["first_name"] != "" ? ($data["first_name"] . " ") : "");
		$name .= ($data["middle_name"] != "" ? (substr($data["middle_name"], 0, 1) . ". ") : "");
		$name .= ($data["last_name"] != "" ? ($data["last_name"] . " ") : "");
		$name .= ($data["ext_name"] != "" ? ($data["ext_name"] . " ") : "");
		return preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $name);
	}

	public function removeDoubleSpaces($data)
	{
		return preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $data);
	}

	public function random_str(
		int $length = 3,
		string $keyspace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
	): string {
		if ($length < 1) {
			throw new \RangeException("Length must be a positive integer");
		}
		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$pieces[] = $keyspace[random_int(0, $max)];
		}
		return implode('', $pieces);
	}
	
	public function foreachBtn($arr, $haha, $cat, $catobj) {
	    $btn = "";
	    foreach ($arr as $value) {
          switch ($value) {
              case "view":
                  if ($haha[$catobj.'view'] == 1) {
                      $btn .= "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> ";
                  }
                  break;
              case "inspection":
                  if ($haha[$catobj.'inspection'] == 1) {
                     $btn .= "<button class='btn btn-warning' id='btn-".$cat."-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> "; 
                  }
                  break;
              case "assessment":
                  if ($haha[$catobj.'assessment'] == 1) {
                      $btn .= "<button class='btn btn-info' id='btn-".$cat."-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> ";
                  }
                  break;
              case "releasing":
                  if ($haha[$catobj.'releasing'] == 1) {
                      $btn .= "<button class='btn btn-info' id='btn-".$cat."-release' data-toggle='tooltip' data-placement='top' title='Release'><i class='fa fa-check'></i></button> ";
                  }
                  break;
              case "cancel":
                  if ($haha[$catobj.'cancel'] == 1) {
                      $btn .= "<button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button> ";
                  }
                  break;
              case "payencode":
             			if ($haha[$catobj.'orencode'] == 1) {
                      $btn .= "<button class='btn btn-secondary' id='btn-payencode' data-toggle='tooltip' data-placement='top' title='OR Encode'><i class='fa fa-money-bill-wave'></i></button> ";
                  }	
                  break;
              case "form":
              		if ($haha[$catobj.'appform'] == 1) {
                      $btn .= "<button class='btn btn-info' id='btn-".$cat."-form' data-toggle='tooltip' data-placement='top' title='Application Form'><i class='fa fa-file'></i></button> ";
                  }	
                  break;
              default:
                  break;
          }
        }
        
        return $btn;
	}
	
	public function getJunjiito () {
	    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE id = ?");
	    $stmt->bindValue(1, $_SESSION['acc']);
	    $stmt->execute();
	    return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getAitai ($id) {
	    $stmt = $this->connect()->prepare("SELECT username, fullname, designation, tf_application, tf_view, tf_inspection, tf_assessment, tf_releasing, tf_cancel, cm_application, cm_view, cm_inspection, cm_assessment, cm_releasing, cm_cancel, co_application, co_view, co_inspection, co_assessment, co_releasing, co_cancel, dp_application, dp_view, dp_inspection, dp_assessment, dp_releasing, dp_cancel, sett_opdr, sett_motor, sett_toda, sett_franpertoda, ref_requirements, ref_assfees, ref_signa, ref_make, ref_lto, rep_newrenew, rep_cm, rep_co, rep_drop, rep_franexprd, rep_collection, rep_abstract, tf_orencode, tf_appform, cm_orencode, cm_appform, co_orencode, co_appform, dp_orencode, dp_appform FROM users WHERE id = ?");
	    $stmt->bindValue(1, $id);
	    $stmt->execute();
	    return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function statusButton($status, $type) {
	  $arr = array();
	  
	  $haha = $this->getJunjiito();
	  if ($status == "FOR ASSESSMENT" || $status == "FOR PAYMENT") {
	      $arr = array('view', 'inspection', 'assessment', 'cancel', 'payencode');
	  } else if ($status == "FOR INSPECTION" || $status == "DENIED") {
	      $arr = array('view', 'inspection', 'cancel');
	  } else if ($status == "FOR RELEASING" || $status == "RELEASED") {
	      $arr = array('view', 'inspection', 'releasing', 'form', 'cancel');
	  }
	  
	    
      switch ($type) {
        case "franchise":
          return $this->foreachBtn($arr, $haha, "operator", "tf_");
          break;
    
        case "changemotor":
          return $this->foreachBtn($arr, $haha, "changemotor", "cm_");
          break;
    
        case "changeownership":
          return $this->foreachBtn($arr, $haha, "changeownership", "co_");
          break;
		
		// case "changedriver":
		// 	return $this->foreachBtn($arr, $haha, "changedriver", "cd_");
		// 	break;
    
        case "dropping":
          return $this->foreachBtn($arr, $haha, "dropping", "dp_");
          break;
        default:
          return "";
      }
      
    }

	public function getUser($email, $password)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = :user AND `password` = :pass");
			$stmt->bindParam(":user", $email);
			$stmt->bindParam(":pass", $password);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				$_SESSION['acc'] = $data['id'];
				$_SESSION['fullname'] = $data['fullname'];
				$_SESSION['username'] = $data['username'];
				return $_SESSION['acc'];
			} else {
				return "error";
			}
		} catch (PDOexception $e) {
			echo "Error Connection : " . $e->getMessage();
			return "error";
		}
	}

	public function signUser($fname, $user, $pass, $pos, $tfran_application, $tfran_view, $tfran_inspection, $tfran_assessment, $tfran_release, $tfran_cancel, $cm_application, $cm_view, $cm_inspection, $cm_assessment, $cm_release, $cm_cancel, $co_application, $co_view, $co_inspection, $co_assessment, $co_release, $co_cancel,$drop_application, $drop_view, $drop_inspection, $drop_assessment, $drop_release, $drop_cancel, $settings_operator, $settings_motor, $settings_toda, $settings_frantoda, $references_requirement, $references_assessment, $references_signa, $references_make, $references_lto, $report_franchise, $report_cm, $report_co, $report_drop, $report_exprdfran, $report_collection, $report_abstract, $tfran_orencode, $tfran_appform, $cm_orencode, $cm_appform, $co_orencode, $co_appform, $drop_orencode, $drop_appform)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE UPPER(username) = UPPER(?)");
		$stmt->bindValue(1, $user);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "Username is already in use."));
		}
		
		$stmt = $this->connect()->prepare("INSERT INTO `users` (username, password, fullname, designation, tf_application, tf_view, tf_inspection, tf_assessment, tf_releasing, tf_cancel, cm_application, cm_view, cm_inspection, cm_assessment, cm_releasing, cm_cancel, co_application, co_view, co_inspection, co_assessment, co_releasing, co_cancel, dp_application, dp_view, dp_inspection, dp_assessment, dp_releasing, dp_cancel, sett_opdr, sett_motor, sett_toda, sett_franpertoda, ref_requirements, ref_assfees, ref_signa, ref_make, ref_lto, rep_newrenew, rep_cm, rep_co, rep_drop, rep_franexprd, rep_collection, rep_abstract, tf_orencode, tf_appform, cm_orencode, cm_appform, co_orencode, co_appform, dp_orencode, dp_appform) VALUES (:user, :pass, :full, :des, :tf_application, :tf_view, :tf_inspection, :tf_assessment, :tf_releasing, :tf_cancel, :cm_application, :cm_view, :cm_inspection, :cm_assessment, :cm_releasing, :cm_cancel, :co_application, :co_view, :co_inspection, :co_assessment, :co_releasing, :co_cancel, :dp_application, :dp_view, :dp_inspection, :dp_assessment, :dp_releasing, :dp_cancel, :sett_opdr, :sett_motor, :sett_toda, :sett_franpertoda, :ref_requirements, :ref_assfees, :ref_signa, :ref_make, :ref_lto, :rep_newrenew, :rep_cm, :rep_co, :rep_drop, :rep_franexprd, :rep_collection, :rep_abstract, :tf_orencode, :tf_appform, :cm_orencode, :cm_appform, :co_orencode, :co_appform, :dp_orencode, :dp_appform)");
		$stmt->bindParam(":user", $user);
		$stmt->bindParam(":pass", $pass);
		$stmt->bindParam(":full", $fname);
		$stmt->bindParam(":des", $pos);
		
		$stmt->bindParam(":tf_application", $tfran_application);
		$stmt->bindParam(":tf_view", $tfran_view);
		$stmt->bindParam(":tf_inspection", $tfran_inspection);
		$stmt->bindParam(":tf_assessment", $tfran_assessment);
		$stmt->bindParam(":tf_releasing", $tfran_release);
		$stmt->bindParam(":tf_cancel", $tfran_cancel);
		$stmt->bindParam(":tf_orencode", $tfran_orencode);
		$stmt->bindParam(":tf_appform", $tfran_appform);
		
		$stmt->bindParam(":cm_application", $cm_application);
		$stmt->bindParam(":cm_view", $cm_view);
		$stmt->bindParam(":cm_inspection", $cm_inspection);
		$stmt->bindParam(":cm_assessment", $cm_assessment);
		$stmt->bindParam(":cm_releasing", $cm_release);
		$stmt->bindParam(":cm_cancel", $cm_cancel);
		$stmt->bindParam(":cm_orencode", $cm_orencode);
		$stmt->bindParam(":cm_appform", $cm_appform);
		
		$stmt->bindParam(":co_application", $co_application);
		$stmt->bindParam(":co_view", $co_view);
		$stmt->bindParam(":co_inspection", $co_inspection);
		$stmt->bindParam(":co_assessment", $co_assessment);
		$stmt->bindParam(":co_releasing", $co_release);
		$stmt->bindParam(":co_cancel", $co_cancel);
		$stmt->bindParam(":co_orencode", $co_orencode);
		$stmt->bindParam(":co_appform", $co_appform);

		
		$stmt->bindParam(":dp_application", $drop_application);
		$stmt->bindParam(":dp_view", $drop_view);
		$stmt->bindParam(":dp_inspection", $drop_inspection);
		$stmt->bindParam(":dp_assessment", $drop_assessment);
		$stmt->bindParam(":dp_releasing", $drop_release);
		$stmt->bindParam(":dp_cancel", $drop_cancel);
		$stmt->bindParam(":dp_orencode", $drop_orencode);
		$stmt->bindParam(":dp_appform", $drop_appform);
		
		$stmt->bindParam(":sett_opdr", $settings_operator);
		$stmt->bindParam(":sett_motor", $settings_motor);
		$stmt->bindParam(":sett_toda", $settings_toda);
		$stmt->bindParam(":sett_franpertoda", $settings_frantoda);
		
		$stmt->bindParam(":ref_requirements", $references_requirement);
		$stmt->bindParam(":ref_assfees", $references_assessment);
		$stmt->bindParam(":ref_signa", $references_signa);
		$stmt->bindParam(":ref_make", $references_make);
		$stmt->bindParam(":ref_lto", $references_lto);
		
		$stmt->bindParam(":rep_newrenew", $report_franchise);
		$stmt->bindParam(":rep_cm", $report_cm);
		$stmt->bindParam(":rep_co", $report_co);
		$stmt->bindParam(":rep_drop", $report_drop);
		$stmt->bindParam(":rep_franexprd", $report_exprdfran);
		$stmt->bindParam(":rep_collection", $report_collection);
		$stmt->bindParam(":rep_abstract", $report_abstract);
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "User has been registered successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}
	
	public function updateUser($fname, $user, $pos, $tfran_application, $tfran_view, $tfran_inspection, $tfran_assessment, $tfran_release, $tfran_cancel, $cm_application, $cm_view, $cm_inspection, $cm_assessment, $cm_release, $cm_cancel, $co_application, $co_view, $co_inspection, $co_assessment, $co_release, $co_cancel,$drop_application, $drop_view, $drop_inspection, $drop_assessment, $drop_release, $drop_cancel, $settings_operator, $settings_motor, $settings_toda, $settings_frantoda, $references_requirement, $references_assessment, $references_signa, $references_make, $references_lto, $report_franchise, $report_cm, $report_co, $report_drop, $report_exprdfran, $report_collection, $report_abstract, $tfran_orencode, $tfran_appform, $cm_orencode, $cm_appform, $co_orencode, $co_appform, $drop_orencode, $drop_appform, $id)
	{
		$stmt = $this->connect()->prepare("UPDATE `users` SET username = :user, fullname = :full, designation = :des, tf_application = :tf_application, tf_view = :tf_view, tf_inspection = :tf_inspection, tf_assessment = :tf_assessment, tf_releasing = :tf_releasing, tf_cancel = :tf_cancel, cm_application = :cm_application, cm_view = :cm_view, cm_inspection = :cm_inspection, cm_assessment = :cm_assessment, cm_releasing = :cm_releasing, cm_cancel = :cm_cancel, co_application = :co_application, co_view = :co_view, co_inspection = :co_inspection, co_assessment = :co_assessment, co_releasing = :co_releasing, co_cancel = :co_cancel, dp_application = :dp_application, dp_view = :dp_view, dp_inspection = :dp_inspection, dp_assessment = :dp_assessment, dp_releasing = :dp_releasing, dp_cancel = :dp_cancel, sett_opdr = :sett_opdr, sett_motor = :sett_motor, sett_toda = :sett_toda, sett_franpertoda = :sett_franpertoda, ref_requirements = :ref_requirements, ref_assfees= :ref_assfees, ref_signa = :ref_signa, ref_make = :ref_make, ref_lto = :ref_lto, rep_newrenew = :rep_newrenew, rep_cm = :rep_cm, rep_co = :rep_co, rep_drop = :rep_drop, rep_franexprd = :rep_franexprd, rep_collection = :rep_collection, rep_abstract = :rep_abstract, tf_orencode = :tf_orencode, tf_appform = :tf_appform, cm_orencode = :cm_orencode, cm_appform = :cm_appform, co_orencode = :co_orencode, co_appform = :co_appform, dp_orencode = :dp_orencode, dp_appform = :dp_appform WHERE id = :id");
		$stmt->bindParam(":user", $user);
		$stmt->bindParam(":full", $fname);
		$stmt->bindParam(":des", $pos);
		
		$stmt->bindParam(":tf_application", $tfran_application);
		$stmt->bindParam(":tf_view", $tfran_view);
		$stmt->bindParam(":tf_inspection", $tfran_inspection);
		$stmt->bindParam(":tf_assessment", $tfran_assessment);
		$stmt->bindParam(":tf_releasing", $tfran_release);
		$stmt->bindParam(":tf_cancel", $tfran_cancel);
		$stmt->bindParam(":tf_orencode", $tfran_orencode);
		$stmt->bindParam(":tf_appform", $tfran_appform);
		
		$stmt->bindParam(":cm_application", $cm_application);
		$stmt->bindParam(":cm_view", $cm_view);
		$stmt->bindParam(":cm_inspection", $cm_inspection);
		$stmt->bindParam(":cm_assessment", $cm_assessment);
		$stmt->bindParam(":cm_releasing", $cm_release);
		$stmt->bindParam(":cm_cancel", $cm_cancel);
		$stmt->bindParam(":cm_orencode", $cm_orencode);
		$stmt->bindParam(":cm_appform", $cm_appform);
		
		$stmt->bindParam(":co_application", $co_application);
		$stmt->bindParam(":co_view", $co_view);
		$stmt->bindParam(":co_inspection", $co_inspection);
		$stmt->bindParam(":co_assessment", $co_assessment);
		$stmt->bindParam(":co_releasing", $co_release);
		$stmt->bindParam(":co_cancel", $co_cancel);
		$stmt->bindParam(":co_orencode", $co_orencode);
		$stmt->bindParam(":co_appform", $co_appform);

		$stmt->bindParam(":dp_application", $drop_application);
		$stmt->bindParam(":dp_view", $drop_view);
		$stmt->bindParam(":dp_inspection", $drop_inspection);
		$stmt->bindParam(":dp_assessment", $drop_assessment);
		$stmt->bindParam(":dp_releasing", $drop_release);
		$stmt->bindParam(":dp_cancel", $drop_cancel);
		$stmt->bindParam(":dp_orencode", $drop_orencode);
		$stmt->bindParam(":dp_appform", $drop_appform);

		
		$stmt->bindParam(":sett_opdr", $settings_operator);
		$stmt->bindParam(":sett_motor", $settings_motor);
		$stmt->bindParam(":sett_toda", $settings_toda);
		$stmt->bindParam(":sett_franpertoda", $settings_frantoda);
		
		$stmt->bindParam(":ref_requirements", $references_requirement);
		$stmt->bindParam(":ref_assfees", $references_assessment);
		$stmt->bindParam(":ref_signa", $references_signa);
		$stmt->bindParam(":ref_make", $references_make);
		$stmt->bindParam(":ref_lto", $references_lto);
		
		$stmt->bindParam(":rep_newrenew", $report_franchise);
		$stmt->bindParam(":rep_cm", $report_cm);
		$stmt->bindParam(":rep_co", $report_co);
		$stmt->bindParam(":rep_drop", $report_drop);
		$stmt->bindParam(":rep_franexprd", $report_exprdfran);
		$stmt->bindParam(":rep_collection", $report_collection);
		$stmt->bindParam(":rep_abstract", $report_abstract);
		
		$stmt->bindParam(":id", $id);
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "User has been registered successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function saveAudit($subject, $det)
	{
		$mac = "NOT SET";
		// 		foreach(explode("\n",str_replace(' ','',trim(`getmac`,"\n"))) as $i)
		// 		if(strpos($i,'Tcpip')>-1){$mac=substr($i,0,17);break;}

		try {
			$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, :subject, NOW(), date(NOW()), :transdetails, :pcname)");
			$user = ($_SESSION['username'] === null ? 'N/A' : $_SESSION['username']);
			$stmt->bindParam(':username', $user);
			$full = ($_SESSION['fullname'] === null ? 'N/A' : $_SESSION['fullname']);
			$stmt->bindParam(':realname', $full);
			$stmt->bindParam(':pcname', $mac);
			$stmt->bindParam(':subject', $subject);
			$stmt->bindParam(':transdetails', $det);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error Connection : " . $e->getMessage();
		}
	}
	
	public function saveLogs($action, $prevData, $currData, $keyData, $username, $lamesa) {
	    try {

            $responseMatch = json_decode($prevData) == json_decode($currData);
            
            $isSame = 1;
        
            if($responseMatch){     
                $isSame = 0;
            }
            
            $stmt = $this->connect()->prepare("INSERT INTO data_logs (action, previous_data, updated_data, key_data, hasChange, username, lamesa) VALUES(:action, :previous_data, :updated_data, :key_data, :hasChange, :username, :lamesa)");
            $stmt->bindParam(":action", $action);
            $stmt->bindParam(":previous_data", $prevData);
            $stmt->bindParam(":updated_data", $currData);
            $stmt->bindParam(":key_data", $keyData);
            $stmt->bindParam(":hasChange", $isSame);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":lamesa", $lamesa);
            $stmt->execute();
		} catch (PDOException $e) {
			echo "Error Connection : " . $e->getMessage();
		}
	}

	public function islogin()
	{
		if (!isset($_SESSION['acc'])) {
			header("Location: /mtop_morong/admin/login/index.php", true, 301);
			exit;
		}
	}

	public function islogged()
	{
		if (isset($_SESSION['acc'])) {
			header("Location: ../dashboard.php");
			exit;
		}
	}
	
	public function dashboardcount() {
	  $stmt = $this->connect()->prepare("SELECT count(*) as fran FROM tbl_application WHERE iscancel = 0 AND appl_status = 'NEW' AND yr = ?");
		$stmt->bindValue(1, date('Y'));
		$stmt->execute();
		$newrenew = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt6 = $this->connect()->prepare("SELECT count(*) as franr FROM tbl_application WHERE iscancel = 0 AND appl_status = 'RENEW' AND yr = ?");
		$stmt6->bindValue(1, date('Y'));
		$stmt6->execute();
		$renew = $stmt6->fetch(PDO::FETCH_ASSOC);
		
		$stmt2 = $this->connect()->prepare("SELECT count(*) AS cm FROM tbl_changemotor WHERE iscancel = 0 AND yr = ?");
		$stmt2->bindValue(1, date('Y'));
		$stmt2->execute();
		$cm = $stmt2->fetch(PDO::FETCH_ASSOC);
		
		$stmt3 = $this->connect()->prepare("SELECT count(*) AS co FROM tbl_changeownership WHERE iscancel = 0 AND yr = ?");
		$stmt3->bindValue(1, date('Y'));
		$stmt3->execute();
		$co = $stmt3->fetch(PDO::FETCH_ASSOC);

		$stmt4 = $this->connect()->prepare("SELECT count(*) AS cd FROM tbl_changedriver WHERE iscancel = 0 AND yr = ?");
		$stmt4->bindValue(1, date('Y'));
		$stmt4->execute();
		$cd = $stmt4->fetch(PDO::FETCH_ASSOC);
		
		$stmt4 = $this->connect()->prepare("SELECT count(*) AS cdrop FROM tbl_drop WHERE iscancel = 0 AND year = ?");
		$stmt4->bindValue(1, date('Y'));
		$stmt4->execute();
		$drop = $stmt4->fetch(PDO::FETCH_ASSOC);

		$stmt5 = $this->connect()->prepare("SELECT sum(dueamt) as totamt FROM tbl_payment WHERE iscancel = 0 AND yr = ?");
		$stmt5->bindValue(1, date('Y'));
		$stmt5->execute();
		$totamt = $stmt5->fetch(PDO::FETCH_ASSOC);
		
		$data = array("newrenew" => $newrenew["fran"], "renew" => $renew["franr"], "cm" => $cm["cm"], "co" => $co["co"], "cd" => $cd["cd"], "drop" => $drop["cdrop"],"totamt" => $totamt["totamt"]? number_format(str_replace(",", "", $totamt['totamt']), 2) : '0.00');
		
		return $data;
	}

	public function countFranchise()
	{
		$stmt = $this->connect()->prepare("SELECT count(*) as fran FROM tbl_application WHERE iscancel = 0 AND appl_status <> 'TDP' AND yr = ?");
		$stmt->bindValue(1, date('Y'));
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function countDriverPermit()
	{
		$stmt = $this->connect()->prepare("SELECT count(*) as tdp FROM tbl_application WHERE iscancel = 0 AND appl_status = 'TDP' AND yr = ?");
		$stmt->bindValue(1, date('Y'));
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function countDropping()
	{
		$stmt = $this->connect()->query("SELECT count(*) as drp FROM tbl_drop WHERE iscancel = 0");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function countFranchiseToday()
	{
		$stmt = $this->connect()->query("SELECT count(*) as actoday FROM tbl_application WHERE iscancel = 0 AND dtreg = NOW()");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function sumFranchiseCollection()
	{
		$stmt = $this->connect()->query("SELECT SUM(amount) as total FROM new_morong_ebpls.acf51det WHERE iscancel = 0 AND collnature IN (SELECT collnature FROM tbl_nature) AND datecreate BETWEEN CONCAT(YEAR(NOW()), '-01-01') AND CONCAT(YEAR(NOW()), '-12-31')");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getOperators()
	{
		$stmt = $this->connect()->query("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, address_house_no, address_street_name, address_subdivision, address_brgy, address_municipality, address_province, mobile_no, sex, target_path, drivlis FROM tbl_humans WHERE humantype = 0");
		$stmt->execute();
		$data = array();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"humanid" => $key["humanid"],
				"humanpin" => $key["humanpin"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				"mobile_no" => $key["mobile_no"],
				"sex" => $key["sex"],
				"target_path" => $key["target_path"],
				"drivlis" => $key["drivlis"]
			));
		}
		return json_encode(array("data" => $data));
	}

	public function getDrivers()
	{
		$stmt = $this->connect()->query("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, address_house_no, address_street_name, address_subdivision, address_brgy, address_municipality, address_province, mobile_no, sex, target_path, drivlis FROM tbl_humans WHERE humantype = 0");
		$stmt->execute();
		$data = array();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"humanid" => $key["humanid"],
				"humanpin" => $key["humanpin"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				"mobile_no" => $key["mobile_no"],
				"sex" => $key["sex"],
				"target_path" => $key["target_path"],
				"drivlis" => $key["drivlis"]
			));
		}
		return json_encode(array("data" => $data));
	}

	public function getdetOperator($code)
	{
		
		$stmt = $this->connect()->prepare("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path, occupation,cin FROM tbl_humans WHERE humanpin = ?");
		

		//$stmt = $this->connect()->prepare("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path, occupation FROM tbl_humans WHERE humanpin = ?");
		

		//$stmt = $this->connect()->prepare("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path, occupation FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function getdetDriver($code)
	{
		$stmt = $this->connect()->prepare("SELECT humanid, humanpin, first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function insertOperator($firstname, $midinit, $lastname, $extname, $bday, $age, $gender, $civstats, $hse, $st, $subd, $brgy, $brgydesc, $mun, $mundesc, $prov, $provdesc, $region, $regiondesc, $drivlic, $drivissue, $drivplace, $contact, $ctc, $ctcissue, $ctcplace, $emername, $emercontact, $emeraddr, $remarks, $targetpath, $imgname, $cin, $occupation)
	{
		$stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', max(right(humanpin, 5)) + 1), 5, 0) as autopin FROM tbl_humans");
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $this->random_str() . "-" . date("Y") . "-" . $pin['autopin'];
        
        if ($imgname == "") {
            $targetpath = "";
        }
        
		include_once "connection.php";

		try {
			$dbh = new PDO('mysql:host=localhost;dbname='.$this->dbname, $this->uza, $this->pazz);
			$stmt = $dbh->prepare("INSERT INTO tbl_humans(first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, address_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path, humanpin, cin, occupation) VALUES(:first_name, :middle_name, :last_name, :ext_name, :birth_date, :age, :sex, :civil_status, :address_house_no, :address_street_name, :address_subdivision, :psgc_brgy, :address_brgy, :psgc_municipality, :address_municipality, :psgc_province, :address_province, :psgc_region, :address_region, :drivlis, :dateissued, :placeissued, :mobile_no, :certno, :certon, :certat, :conperson, :conaddress, :conconnum, :remarks, :profile_img, :target_path, :humanpin, :cin, :occupation)");
			try {
				$dbh->beginTransaction();

				$stmt->bindParam(":first_name", $firstname);
				$stmt->bindParam(":middle_name", $midinit);
				$stmt->bindParam(":last_name", $lastname);
				$stmt->bindParam(":ext_name", $extname);
				$bday = ($bday == "" ? '1990-01-01' : $bday);
				$stmt->bindParam(":birth_date", $bday);
				$stmt->bindParam(":age", $age);
				$stmt->bindParam(":sex", $gender);
				$stmt->bindParam(":civil_status", $civstats);
				$stmt->bindParam(":address_house_no", $hse);
				$stmt->bindParam(":address_street_name", $st);
				$stmt->bindParam(":address_subdivision", $subd);
				$stmt->bindParam(":psgc_brgy", $brgy);
				$stmt->bindParam(":address_brgy", $brgydesc);
				$stmt->bindParam(":psgc_municipality", $mun);
				$stmt->bindParam(":address_municipality", $mundesc);
				$stmt->bindParam(":psgc_province", $prov);
				$stmt->bindParam(":address_province", $provdesc);
				$stmt->bindParam(":psgc_region", $region);
				$stmt->bindParam(":address_region", $regiondesc);
				$stmt->bindParam(":drivlis", $drivlic);
				$drivissue = ($drivissue == "" ? '1990-01-01' : $drivissue);
				$stmt->bindParam(":dateissued", $drivissue);
				$stmt->bindParam(":placeissued", $drivplace);
				$stmt->bindParam(":mobile_no", $contact);
				$stmt->bindParam(":certno", $ctc);
				$ctcissue = ($ctcissue == "" ? '1990-01-01' : $ctcissue);
				$stmt->bindParam(":certon", $ctcissue);
				$stmt->bindParam(":certat", $ctcplace);
				$stmt->bindParam(":conperson", $emername);
				$stmt->bindParam(":conaddress", $emeraddr);
				$stmt->bindParam(":conconnum", $emercontact);
				$stmt->bindParam(":remarks", $remarks);
				$stmt->bindParam(":profile_img", $imgname);
				$stmt->bindParam(":target_path", $targetpath);
				$stmt->bindParam(":humanpin", $pin);
				$stmt->bindParam(":cin", $cin);
				$stmt->bindParam(":occupation", $occupation);
				if ($stmt->execute()) {
				    $lid = $dbh->lastInsertId();
    				$dbh->commit();
    				$this->saveAudit("Add Operator", $pin . " / " . $firstname . " " . $lastname . " info has been added to records.");
    				$stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
    				$stmt->bindValue(1, $pin);
    				$stmt->execute();
    				$data = $stmt->fetch(PDO::FETCH_ASSOC);
    				$this->saveLogs("INSERT OPERATOR", json_encode(array()), json_encode(array($data)), json_encode(array("humanpin" => $pin)), $_SESSION['username'], "OPERATOR");
    				return json_encode(array("result" => true, "msg" => "Operator's record has been successfully added.", "ophumanpin" => $pin));
				} else {
    				return json_encode(array("result" => false, "msg" => $stmt->errorInfo()));
				}
			} catch (PDOException $e) {
				$dbh->rollback();
				return json_encode(array("result" => false, "msg" => $e->getMessage()));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function insertDriver($firstname, $midinit, $lastname, $extname, $bday, $age, $gender, $civstats, $hse, $st, $subd, $brgy, $brgydesc, $mun, $mundesc, $prov, $provdesc, $region, $regiondesc, $drivlic, $drivissue, $drivplace, $contact, $ctc, $ctcissue, $ctcplace, $emername, $emercontact, $emeraddr, $remarks, $targetpath, $imgname, $cin)
	{

		$stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(humanpin), 5), 5)) + 1, 5, 0) as autopin FROM tbl_humans");
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $this->random_str() . "-" . date("Y") . "-" . $pin['autopin'];
		
		if ($imgname == "") {
            $targetpath = "";
        }

		$stmt = $this->connect()->prepare("INSERT INTO tbl_humans(first_name, middle_name, last_name, ext_name, birth_date, age, sex, civil_status, address_house_no, address_street_name, address_subdivision, psgc_brgy, address_brgy, psgc_municipality, address_municipality, psgc_province, address_province, psgc_region, address_region, drivlis, dateissued, placeissued, mobile_no, certno, certon, certat, conperson, conaddress, conconnum, remarks, profile_img, target_path, humanpin, cin) VALUES(:first_name, :middle_name, :last_name, :ext_name, :birth_date, :age, :sex, :civil_status, :address_house_no, :address_street_name, :address_subdivision, :psgc_brgy, :address_brgy, :psgc_municipality, :address_municipality, :psgc_province, :address_province, :psgc_region, :address_region, :drivlis, :dateissued, :placeissued, :mobile_no, :certno, :certon, :certat, :conperson, :conaddress, :conconnum, :remarks, :profile_img, :target_path, :humanpin, :cin)");

		$stmt->bindParam(":first_name", $firstname);
		$stmt->bindParam(":middle_name", $midinit);
		$stmt->bindParam(":last_name", $lastname);
		$stmt->bindParam(":ext_name", $extname);
		$bday = ($bday == "" ? '1990-01-01' : $bday);
		$stmt->bindParam(":birth_date", $bday);
		$stmt->bindParam(":age", $age);
		$stmt->bindParam(":sex", $gender);
		$stmt->bindParam(":civil_status", $civstats);
		$stmt->bindParam(":address_house_no", $hse);
		$stmt->bindParam(":address_street_name", $st);
		$stmt->bindParam(":address_subdivision", $subd);
		$stmt->bindParam(":psgc_brgy", $brgy);
		$stmt->bindParam(":address_brgy", $brgydesc);
		$stmt->bindParam(":psgc_municipality", $mun);
		$stmt->bindParam(":address_municipality", $mundesc);
		$stmt->bindParam(":psgc_province", $prov);
		$stmt->bindParam(":address_province", $provdesc);
		$stmt->bindParam(":psgc_region", $region);
		$stmt->bindParam(":address_region", $regiondesc);
		$stmt->bindParam(":drivlis", $drivlic);
		$drivissue = ($drivissue == "" ? '1990-01-01' : $drivissue);
		$stmt->bindParam(":dateissued", $drivissue);
		$stmt->bindParam(":placeissued", $drivplace);
		$stmt->bindParam(":mobile_no", $contact);
		$stmt->bindParam(":certno", $ctc);
		$ctcissue = ($ctcissue == "" ? '1990-01-01' : $ctcissue);
		$stmt->bindParam(":certon", $ctcissue);
		$stmt->bindParam(":certat", $ctcplace);
		$stmt->bindParam(":conperson", $emername);
		$stmt->bindParam(":conaddress", $emeraddr);
		$stmt->bindParam(":conconnum", $emercontact);
		$stmt->bindParam(":remarks", $remarks);
		$stmt->bindParam(":profile_img", $imgname);
		$stmt->bindParam(":target_path", $targetpath);
		$stmt->bindParam(":humanpin", $pin);
		$stmt->bindParam(":cin", $cin);

		$this->saveAudit("Add Driver", $firstname . " " . $lastname . " info has been added to records.");
        
		if ($stmt->execute()) {
		    $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
			$stmt->bindValue(1, $pin);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("INSERT DRIVER", json_encode(array()), json_encode(array($data)), json_encode(array("humanpin" => $pin)), $_SESSION['username'], "DRIVER");
			return json_encode(array("result" => true, "msg" => "Driver's record has been successfully added.", "drcode" => $pin));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function updateDriver($firstname, $midinit, $lastname, $extname, $bday, $age, $gender, $civstats, $hse, $st, $subd, $brgy, $brgydesc, $mun, $mundesc, $prov, $provdesc, $region, $regiondesc, $drivlic, $drivissue, $drivplace, $contact, $ctc, $ctcissue, $ctcplace, $emername, $emercontact, $emeraddr, $remarks, $targetpath, $imgname, $file_id, $cin)
	{
	  $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $file_id);
		$stmt->execute();
		$prevData = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($imgname == "") {
            $targetpath = "";
        }
		
		$stmt = $this->connect()->prepare("UPDATE tbl_humans SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, ext_name = :ext_name, birth_date = :birth_date, age = :age, sex = :sex, civil_status = :civil_status, address_house_no = :address_house_no, address_street_name = :address_street_name, address_subdivision = :address_subdivision, psgc_brgy = :psgc_brgy, address_brgy = :address_brgy, psgc_municipality = :psgc_municipality, address_municipality = :address_municipality, psgc_province = :psgc_province, address_province = :address_province, psgc_region = :psgc_region, address_region = :address_region, drivlis = :drivlis, dateissued = :dateissued, placeissued = :placeissued, mobile_no = :mobile_no, certno = :certno, certon = :certon, certat = :certat, conperson = :conperson, conaddress = :conaddress, conconnum = :conconnum, remarks = :remarks, profile_img = :profile_img, target_path = :target_path, cin = :cin WHERE humanpin = :humanpin");
		$stmt->bindParam(":first_name", $firstname);
		$stmt->bindParam(":middle_name", $midinit);
		$stmt->bindParam(":last_name", $lastname);
		$stmt->bindParam(":ext_name", $extname);
		$stmt->bindParam(":birth_date", $bday);
		$stmt->bindParam(":age", $age);
		$stmt->bindParam(":sex", $gender);
		$stmt->bindParam(":civil_status", $civstats);
		$stmt->bindParam(":address_house_no", $hse);
		$stmt->bindParam(":address_street_name", $st);
		$stmt->bindParam(":address_subdivision", $subd);
		$stmt->bindParam(":psgc_brgy", $brgy);
		$stmt->bindParam(":address_brgy", $brgydesc);
		$stmt->bindParam(":psgc_municipality", $mun);
		$stmt->bindParam(":address_municipality", $mundesc);
		$stmt->bindParam(":psgc_province", $prov);
		$stmt->bindParam(":address_province", $provdesc);
		$stmt->bindParam(":psgc_region", $region);
		$stmt->bindParam(":address_region", $regiondesc);
		$stmt->bindParam(":drivlis", $drivlic);
		$stmt->bindParam(":dateissued", $drivissue);
		$stmt->bindParam(":placeissued", $drivplace);
		$stmt->bindParam(":mobile_no", $contact);
		$stmt->bindParam(":certno", $ctc);
		$stmt->bindParam(":certon", $ctcissue);
		$stmt->bindParam(":certat", $ctcplace);
		$stmt->bindParam(":conperson", $emername);
		$stmt->bindParam(":conaddress", $emeraddr);
		$stmt->bindParam(":conconnum", $emercontact);
		$stmt->bindParam(":remarks", $remarks);
		$stmt->bindParam(":profile_img", $imgname);
		$stmt->bindParam(":target_path", $targetpath);
		$stmt->bindParam(":humanpin", $file_id);
    $stmt->bindParam(":cin", $cin);

		$this->saveAudit("Update Driver", $firstname . " " . $lastname . " info has been updated.");

		if ($stmt->execute()) {
		    $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
    		$stmt->bindValue(1, $file_id);
    		$stmt->execute();
    		$currData = $stmt->fetch(PDO::FETCH_ASSOC);
            
    		$this->saveLogs("UPDATE DRIVER", json_encode(array($prevData)), json_encode(array($currData)), json_encode(array("humanpin" => $file_id)), $_SESSION['username'], "DRIVER");
			return json_encode(array("result" => true, "msg" => "Driver's record has been successfully updated."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	
	public function getopMotor($code)
	{
		// $stmt = $this->connect()->prepare("SELECT humanid, humanpin, CONCAT(first_name,' ', LEFT(middle_name, 1), '. ', last_name, ' ', ext_name) as fullname, CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province, ', ', address_region) as addr, target_path FROM tbl_humans WHERE humanpin = ? AND humantype = 0");
		$stmt = $this->connect()->prepare("SELECT b.trcode, b.tags, a.humanid, a.humanpin, CONCAT(a.first_name,' ', LEFT(a.middle_name, 1), '. ', a.last_name, ' ', a.ext_name) as fullname, CONCAT(a.address_house_no, ' ', a.address_street_name, ' ', a.address_subdivision, ' ', a.address_brgy, ' ', a.address_municipality, ', ', a.address_province, ', ', a.address_region) as addr,
		target_path FROM tbl_humans as a left join tbl_application as b on a.humanpin = b.opercode WHERE humanpin = ? AND humantype = 0 ");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function getopMotor1($code)
	{
		// $stmt = $this->connect()->prepare("SELECT humanid, humanpin, CONCAT(first_name,' ', LEFT(middle_name, 1), '. ', last_name, ' ', ext_name) as fullname, CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province, ', ', address_region) as addr, target_path FROM tbl_humans WHERE humanpin = ? AND humantype = 0");
		$stmt = $this->connect()->prepare("SELECT b.trcode, b.tags, a.humanid, a.humanpin, CONCAT(a.first_name,' ', LEFT(a.middle_name, 1), '. ', a.last_name, ' ', a.ext_name) as fullname, CONCAT(a.address_house_no, ' ', a.address_street_name, ' ', a.address_subdivision, ' ', a.address_brgy, ' ', a.address_municipality, ', ', a.address_province, ', ', a.address_region) as addr,
		target_path FROM tbl_humans as a left join tbl_application as b on a.humanpin = b.opercode WHERE humanpin = ?AND humantype = 0 and yr =year(curdate())");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}
	
	// //carlo
	public function getdetStatus($code)
	{
		$stmt = $this->connect()->prepare("SELECT trcode, opercode,drivercode, motorcode, franchise_no, appl_status, Tags,tagscode, dttm FROM tbl_application where motorcode = ?");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}
	
	
	public function getStatus()
	{
		//  $stmt = $this->connect()->query("SELECT motorid, motorpin, b.humanpin as ophumanpin, c.humanpin as drhumanpin, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) as cname, CONCAT(toda, '-', bodyno) as todabody, engine, chassis, plateno, a.franchiseno as franno, opercode, CONCAT(c.first_name,' ', LEFT(c.middle_name, 1), '. ', c.last_name, ' ', c.ext_name) as dname, status, a.last_renew, make, platecolor, dtexprdstick, dtexprd, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, c.humanid as drivercode, CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province, ', ', c.address_region) as draddr, b.target_path AS optp, c.target_path AS drtp, c.mobile_no as drcont_no FROM tbl_motor as a left join tbl_humans as b on a.opercode = b.humanpin left join tbl_humans as c on a.drivercode = c.humanpin WHERE status = 'AVAILABLE' AND isdeleted = 0");
		$stmt = $this->connect()->query("SELECT d.trcode, d.tags, d.appl_status, d.franchise_no, motorid, motorpin, b.humanpin as ophumanpin, c.humanpin as drhumanpin, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) as cname, CONCAT(toda, '-', bodyno) as todabody, engine, chassis, plateno, a.franchiseno as franno, a.opercode, CONCAT(c.first_name,' ', LEFT(c.middle_name, 1), '. ', c.last_name, ' ', c.ext_name) as dname, status, a.last_renew, make, platecolor, dtexprdstick, a.dtexprd, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, c.humanid as drivercode, CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province, ', ', c.address_region) as draddr, b.target_path AS optp, c.target_path AS drtp, c.mobile_no as drcont_no 
		FROM tbl_motor as a 
		left join tbl_humans as b on a.opercode = b.humanpin
		left join tbl_humans as c on a.drivercode = c.humanpin
		left join tbl_application as d on a.drivercode = d.drivercode 
		WHERE iscancel = 0 AND appl_status <> 'TDP'  AND status = 'AVAILABLE' AND isdeleted = 0 GROUP BY trcode ORDER BY trcode DESC
		");
		$stmt->execute();
		$data = array();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"tags" => $key["tags"],
				"franchise_no" => $key["franchise_no"],
				"appl_status" => $key["appl_status"],
				
				"opercode" => $key["opercode"],
				"ophumanpin" => $key["ophumanpin"],
				"opname" => $this->removeDoubleSpaces($key['cname']),
				"addr" => $this->removeDoubleSpaces($key['addr']),
				"opmobile_no" => $key["mobile_no"],
				"optp" => $key["optp"],
				"drivercode" => $key["drivercode"],
				"drhumanpin" => $key["drhumanpin"],
				"drname" => $this->removeDoubleSpaces($key['dname']),
				"draddr" => $this->removeDoubleSpaces($key['draddr']),
				"drmobile_no" => $key["drcont_no"],
				"drtp" => $key["drtp"],
				"motorpin" => $key["motorpin"],
				"todabody" => $key["todabody"],
				"engine" => $key["engine"],
				"chassis" => $key["chassis"],
				"plateno" => $key["plateno"],
				"franchiseno" => $key["franno"],
				"status" => $key["status"],
				"make" => $key["make"],
				"platecolor" => $key["platecolor"],
				"dtexprdstick" => $key["dtexprdstick"],
				"dtexprd" => $key["dtexprd"],
				"last_renew" => $key["last_renew"]
			));
		}
		return json_encode(array("data" => $data));
	}

	// //carlo END



	public function getMotor()
	{
		$stmt = $this->connect()->query("SELECT motorid, motorpin, b.humanpin as ophumanpin, c.humanpin as drhumanpin, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) as cname, CONCAT(toda, '-', bodyno) as todabody, engine, chassis, plateno, a.franchiseno as franno, opercode, CONCAT(c.first_name,' ', LEFT(c.middle_name, 1), '. ', c.last_name, ' ', c.ext_name) as dname, status, a.last_renew, make, platecolor, dtexprdstick, dtexprd, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, c.humanid as drivercode, CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province, ', ', c.address_region) as draddr, b.target_path AS optp, c.target_path AS drtp, c.mobile_no as drcont_no FROM tbl_motor as a left join tbl_humans as b on a.opercode = b.humanpin left join tbl_humans as c on a.drivercode = c.humanpin WHERE status = 'AVAILABLE' AND isdeleted = 0");
		$stmt->execute();
		$data = array();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"opercode" => $key["opercode"],
				"ophumanpin" => $key["ophumanpin"],
				"opname" => $this->removeDoubleSpaces($key['cname']),
				"addr" => $this->removeDoubleSpaces($key['addr']),
				"opmobile_no" => $key["mobile_no"],
				"optp" => $key["optp"],
				"drivercode" => $key["drivercode"],
				"drhumanpin" => $key["drhumanpin"],
				"drname" => $this->removeDoubleSpaces($key['dname']),
				"draddr" => $this->removeDoubleSpaces($key['draddr']),
				"drmobile_no" => $key["drcont_no"],
				"drtp" => $key["drtp"],
				"motorpin" => $key["motorpin"],
				"todabody" => $key["todabody"],
				"engine" => $key["engine"],
				"chassis" => $key["chassis"],
				"plateno" => $key["plateno"],
				"franchiseno" => $key["franno"],
				"status" => $key["status"],
				"make" => $key["make"],
				"platecolor" => $key["platecolor"],
				"dtexprdstick" => $key["dtexprdstick"],
				"dtexprd" => $key["dtexprd"],
				"last_renew" => $key["last_renew"]
			));
		}
		return json_encode(array("data" => $data));
	}

	public function getdetMotor($motorid)
	{
		$stmt = $this->connect()->prepare("SELECT motorpin, opercode, bodyno, toda, franchiseno, make, status, engine, chassis, yearmodel, color, foryear, crno, mvno, crdate, plateno, ltobranch, remarks, platecolor, crname, crswitch, orcr, orcrdate, munplateno, dtexprd FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $motorid);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}


	public function updateOperator($firstname, $midinit, $lastname, $extname, $bday, $age, $gender, $civstats, $hse, $st, $subd, $brgy, $brgydesc, $mun, $mundesc, $prov, $provdesc, $region, $regiondesc, $drivlic, $drivissue, $drivplace, $contact, $ctc, $ctcissue, $ctcplace, $emername, $emercontact, $emeraddr, $remarks, $targetpath, $imgname, $file_id, $cin, $occupation)
	{
	    
	    $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $file_id);
		$stmt->execute();
		$prevData = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($imgname == "") {
            $targetpath = "";
        }
		
		$stmt = $this->connect()->prepare("UPDATE tbl_humans SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, ext_name = :ext_name, birth_date = :birth_date, age = :age, sex = :sex, civil_status = :civil_status, address_house_no = :address_house_no, address_street_name = :address_street_name, address_subdivision = :address_subdivision, psgc_brgy = :psgc_brgy, address_brgy = :address_brgy, psgc_municipality = :psgc_municipality, address_municipality = :address_municipality, psgc_province = :psgc_province, address_province = :address_province, psgc_region = :psgc_region, address_region = :address_region, drivlis = :drivlis, dateissued = :dateissued, placeissued = :placeissued, mobile_no = :mobile_no, certno = :certno, certon = :certon, certat = :certat, conperson = :conperson, conaddress = :conaddress, conconnum = :conconnum, remarks = :remarks, profile_img = :profile_img, target_path = :target_path, cin = :cin, occupation = :occupation WHERE humanpin = :humanpin");
		$stmt->bindParam(":first_name", $firstname);
		$stmt->bindParam(":middle_name", $midinit);
		$stmt->bindParam(":last_name", $lastname);
		$stmt->bindParam(":ext_name", $extname);
		$stmt->bindParam(":birth_date", $bday);
		$stmt->bindParam(":age", $age);
		$stmt->bindParam(":sex", $gender);
		$stmt->bindParam(":civil_status", $civstats);
		$stmt->bindParam(":address_house_no", $hse);
		$stmt->bindParam(":address_street_name", $st);
		$stmt->bindParam(":address_subdivision", $subd);
		$stmt->bindParam(":psgc_brgy", $brgy);
		$stmt->bindParam(":address_brgy", $brgydesc);
		$stmt->bindParam(":psgc_municipality", $mun);
		$stmt->bindParam(":address_municipality", $mundesc);
		$stmt->bindParam(":psgc_province", $prov);
		$stmt->bindParam(":address_province", $provdesc);
		$stmt->bindParam(":psgc_region", $region);
		$stmt->bindParam(":address_region", $regiondesc);
		$stmt->bindParam(":drivlis", $drivlic);
		$stmt->bindParam(":dateissued", $drivissue);
		$stmt->bindParam(":placeissued", $drivplace);
		$stmt->bindParam(":mobile_no", $contact);
		$stmt->bindParam(":certno", $ctc);
		$stmt->bindParam(":certon", $ctcissue);
		$stmt->bindParam(":certat", $ctcplace);
		$stmt->bindParam(":conperson", $emername);
		$stmt->bindParam(":conaddress", $emeraddr);
		$stmt->bindParam(":conconnum", $emercontact);
		$stmt->bindParam(":remarks", $remarks);
		$stmt->bindParam(":profile_img", $imgname);
		$stmt->bindParam(":target_path", $targetpath);
		$stmt->bindParam(":humanpin", $file_id);
		$stmt->bindParam(":occupation", $occupation);
        $stmt->bindParam(":cin", $cin);
		$this->saveAudit("Update Operator", $file_id . " - " . $firstname . " " . $lastname . " info has been updated.");
		
		
	    if ($stmt->execute() == 1) {
	        $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
    		$stmt->bindValue(1, $file_id);
    		$stmt->execute();
    		$currData = $stmt->fetch(PDO::FETCH_ASSOC);
            
    		$this->saveLogs("UPDATE OPERATOR", json_encode(array($prevData)), json_encode(array($currData)), json_encode(array("humanpin" => $file_id)), $_SESSION['username'], "OPERATOR");
			return json_encode(array("result" => true, "msg" => "Operator's record has been updated added."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}





	public function submitFranchise($opcode, $opmotor, $yr, $applstatus, $drcode)
	{
		try {
			// CHECK IF THE OPERATOR ALREADY APPLIED WITH THE SAME MOTOR IN SPECIFIED YEAR
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE opercode = ? AND motorcode = ? AND yr = ? AND iscancel = 0");
			$stmt->bindValue(1, $opcode);
			$stmt->bindValue(2, $opmotor);
			$stmt->bindValue(3, $yr);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				return json_encode(array("result" => false, "msg" => "This operator already has an franchise application with this motor."));
			}

			// CHECK IF THE MOTOR IS LINKED TO THE OPERATOR CORRECTLY
			$stmt = $this->connect()->prepare("SELECT motorid FROM tbl_motor WHERE motorpin = ? AND opercode = ?");
			$stmt->bindValue(1, $opmotor);
			$stmt->bindValue(2, $opcode);
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				return json_encode(array("result" => false, "msg" => "The motor is not linked to the operator properly."));
			}

			// GET motor data
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
			$stmt->bindValue(1, $opmotor);
			$stmt->execute();
			$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

			// GET AUTO PIN
			$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_application WHERE appl_status <> 'TDP' AND yr = ? AND RIGHT(trcode,1) = 'F'");
			$stmt->bindValue(1, $yr);
			$stmt->execute();
			$pin = $stmt->fetch();
			$pin = $yr . "-" . $pin['autopin'] . "-F";


			// GET SETTINGS FOR NO OF YEARS
			$stmt = $this->connect()->query("SELECT noofyr, expmode FROM ysettings");
			$stmt->execute();
			$yset = $stmt->fetch(PDO::FETCH_ASSOC);
			$dtyr = "";
			if ($yset['expmode'] == 0) {
				$year = date("Y") + intval($yset['noofyr']);
				$dtyr = $year . date("-m-d");
			} else {
				$dtyr = date("Y") . "-12-31";
			}

			//SAVE MOTOR LINKINGS
			$zxc = date('Y-m-d');
			$stmt = $this->connect()->prepare("INSERT INTO tbl_motorlinking (previous_operator, previous_motor, previous_driver, operator, motor, driver, franchiseno, toda, foryear, trcode, appl_status) VALUES (:previous_operator, :previous_motor, :previous_driver, :operator, :motor, :driver, :franchiseno, :toda, :foryear, :trcode, :appl_status)");
			$stmt->bindParam(":previous_operator", $opcode);
			$stmt->bindParam(":previous_motor", $opmotor);
			$stmt->bindParam(":previous_driver", $motordata['drivercode']);
			$stmt->bindParam(":operator", $opcode);
			$stmt->bindParam(":motor", $opmotor);
			$stmt->bindParam(":driver", $drcode);
			$stmt->bindParam(":franchiseno", $motordata['fracnchiseno']);
			$stmt->bindParam(":toda", $motordata['toda']);
			$stmt->bindParam(":foryear", $yr);
			$stmt->bindParam(":trcode", $pin);
			$stmt->bindParam(":appl_status", $applstatus);
			$stmt->execute();
			
			//DATA LOGS FOR MOTORLINK
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE trcode = ?");
            $stmt->bindValue(1, $pin);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->saveLogs("INSERT MOTORLINK", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "MOTORLINK");

			// FRANCHISE SAVING
			$stmt = $this->connect()->prepare("INSERT INTO tbl_application (yr, trcode, opercode, motorcode, dtreg, dtexprd, appl_status, Tags, tagscode, encoded_by, drivercode) VALUES (?,?,?,?,?, ?,?,?,?,?, ?)");
			$stmt->bindValue(1, $yr);
			$stmt->bindValue(2, $pin);
			$stmt->bindValue(3, $opcode);
			$stmt->bindValue(4, $opmotor);
			$stmt->bindValue(5, date('Y-m-d'));
			$stmt->bindValue(6, $dtyr);
			$stmt->bindValue(7, $applstatus);
			$stmt->bindValue(8, "FOR INSPECTION");
			$stmt->bindValue(9, 2);
			$stmt->bindValue(10, $_SESSION['username']);
			$stmt->bindValue(11, $drcode);


			$this->saveAudit("Franchise Applied.", $pin . "(" . $applstatus . ")" . " - " . $opcode . " - " . $opmotor . " info has been recorded.");
			
			if ($stmt->execute() == 1) {
			    $stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
            	$stmt->bindValue(1, $pin);
            	$stmt->execute();
            	$data = $stmt->fetch(PDO::FETCH_ASSOC);
            	$this->saveLogs("SAVE APPLICATION", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "FRANCHISE");
			    
				return json_encode(array("result" => true, "msg" => "Application has been submited successfully.", "trcode" => $pin));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong when submitting the application. Please contact your administrator."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}
public function submitChangeMotor($opcode, $opmotor, $newmotor, $yr, $drcode, $remarks, $newopcode)
	{
		// CHECK IF THE OPERATOR ALREADY APPLIED WITH THE SAME MOTOR IN SPECIFIED YEAR
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE opercode = ? AND motorpin = ? AND dtexprd >= ? AND status = 'AVAILABLE'");
		$stmt->bindValue(1, $opcode);
		$stmt->bindValue(2, $opmotor);
		$stmt->bindValue(3, date('Y-m-d'));
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "This operator has no active application."));
		}

		// CHECK IF THE NEW MOTOR HAS AN ACTIVE FRANCHISE
		$stmt = $this->connect()->prepare("SELECT motorid FROM tbl_motor WHERE motorpin = ? AND franchiseno = ''");
		$stmt->bindValue(1, $newmotor);
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "New motor is suggested to be used in change motor process."));
		}

		// GET motor data
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $opmotor);
		$stmt->execute();
		$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

		// GET AUTO PIN
		$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_changemotor WHERE yr = ? AND RIGHT(trcode,1) = 'C'");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $yr . "-" . $pin['autopin'] . "-C";

		$zxc = date('Y-m-d');
		//SAVE MOTOR LINKINGS
		$stmt = $this->connect()->prepare("INSERT INTO tbl_motorlinking (previous_operator, previous_motor, previous_driver, operator, motor, driver, franchiseno, toda, foryear, trcode, appl_status) VALUES (:previous_operator, :previous_motor, :previous_driver, :operator, :motor, :driver, :franchiseno, :toda, :foryear, :trcode, 'CHANGE MOTOR')");
		$stmt->bindParam(":previous_operator", $opcode);
		$stmt->bindParam(":previous_motor", $opmotor);
		$stmt->bindParam(":previous_driver", $drcode);
		$stmt->bindParam(":operator", $newopcode);
		$stmt->bindParam(":motor", $newmotor);
		$stmt->bindParam(":driver", $drcode);
		$stmt->bindParam(":franchiseno", $motordata['franchiseno']);
		$stmt->bindParam(":toda", $motordata['toda']);
		$stmt->bindParam(":foryear", $yr);
		$stmt->bindParam(":trcode", $pin);
		$stmt->execute();
		
		//DATA LOGS FOR MOTORLINK
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE trcode = ?");
        $stmt->bindValue(1, $pin);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->saveLogs("INSERT MOTORLINK", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "MOTORLINK");

		// CHANGE MOTOR SAVING
		$stmt = $this->connect()->prepare("INSERT INTO tbl_changemotor (trcode, yr, opercode, motorcode, newopercode, newmotorcode, dateapplication, tagscode, Tags, encoded_by, remarks) VALUES (:trcode, :yr, :opercode, :newmotorcode, :newopercode, :newmotorcode, :dateapplication, 2, 'FOR INSPECTION', :encoded_by, :remarks)");
		$stmt->bindParam(":trcode", $pin);
		$stmt->bindParam(":yr", $yr);
		$stmt->bindParam(":opercode", $opcode);
		$stmt->bindParam(":motorcode", $newmotor);
		$stmt->bindParam(":newopercode", $newopcode);
		$stmt->bindParam(":newmotorcode", $newmotor);
		$stmt->bindParam(":dateapplication", $zxc);
		$stmt->bindParam(":encoded_by", $_SESSION['username']);
		$stmt->bindParam(":remarks", $remarks);
        
        if ($opcode != $newopcode) {
            $this->saveAudit("Change Motor Applied.", $pin . " - " . $opcode . " changed to " . $newopcode . " - " . $opmotor . "changed to " . $newmotor . " info has been recorded.");
        } else {
            $this->saveAudit("Change Motor Applied.", $pin . " - " . $newopcode . " - " . $opmotor . "changed to " . $newmotor . " info has been recorded.");
        }
		
		if ($stmt->execute() == 1) {
		    $stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE trcode = ?");
        	$stmt->bindValue(1, $pin);
        	$stmt->execute();
        	$data = $stmt->fetch(PDO::FETCH_ASSOC);
        	$this->saveLogs("SAVE APPLICATION", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "CHANGE MOTOR");
			return json_encode(array("result" => true, "msg" => "Application has been submited successfully.", "trcode" => $pin));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong when submitting the application. Please contact your administrator."));
		}
	}

	public function submitChangeOwnership($opcode, $opmotor, $newopcode, $yr, $drcode, $remarks)
	{
		// CHECK IF THE OPERATOR ALREADY APPLIED WITH THE SAME MOTOR IN SPECIFIED YEAR
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE opercode = ? AND motorpin = ? AND dtexprd >= ? AND status = 'AVAILABLE'");
		$stmt->bindValue(1, $opcode);
		$stmt->bindValue(2, $opmotor);
		$stmt->bindValue(3, date('Y-m-d'));
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "This operator has no active application."));
		}

		// GET motor data
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $opmotor);
		$stmt->execute();
		$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

		// GET AUTO PIN
		$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_changeownership WHERE yr = ? AND RIGHT(trcode,1) = 'O'");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $yr . "-" . $pin['autopin'] . "-O";

		$zxc = date('Y-m-d');
		//SAVE MOTOR LINKINGS
		$stmt = $this->connect()->prepare("INSERT INTO tbl_motorlinking (previous_operator, previous_motor, previous_driver,  operator, motor, driver, franchiseno, toda, foryear, trcode, appl_status, dtreg) VALUES (:previous_operator, :previous_motor, :previous_driver, :operator, :motor, :driver, :franchiseno, :toda, :foryear, :trcode, 'CHANGE OWNERSHIP', :dtreg)");
		$stmt->bindParam(":previous_operator", $opcode);
		$stmt->bindParam(":previous_motor", $opmotor);
		$stmt->bindParam(":previous_driver", $drcode);
		$stmt->bindParam(":operator", $newopcode);
		$stmt->bindParam(":motor", $opmotor);
		$stmt->bindParam(":driver", $drcode);
		$stmt->bindParam(":franchiseno", $motordata['franchiseno']);
		$stmt->bindParam(":toda", $motordata['toda']);
		$stmt->bindParam(":foryear", $yr);
		$stmt->bindParam(":trcode", $pin);
		$stmt->bindParam(":dtreg", $zxc);
		$stmt->execute();
		
		//DATA LOGS FOR MOTORLINK
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE trcode = ?");
        $stmt->bindValue(1, $pin);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->saveLogs("INSERT MOTORLINK", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "MOTORLINK");

		// CHANGE OWNERSHIP SAVING
		$stmt = $this->connect()->prepare("INSERT INTO tbl_changeownership (trcode, yr, opercode, motorcode, newopercode, dateapplication, tagscode, Tags, encoded_by, remarks) VALUES (:trcode, :yr, :opercode, :motorcode, :newopercode, :dateapplication, 2, 'FOR INSPECTION', :encoded_by, :remarks)");
		$stmt->bindParam(":trcode", $pin);
		$stmt->bindParam(":yr", $yr);
		$stmt->bindParam(":opercode", $opcode);
		$stmt->bindParam(":motorcode", $opmotor);
		$stmt->bindParam(":newopercode", $newopcode);
		$stmt->bindParam(":dateapplication", $zxc);
		$stmt->bindParam(":encoded_by", $_SESSION['username']);
		$stmt->bindParam(":remarks", $remarks);

		$this->saveAudit("Change Ownership Applied.", $pin . " - " . $opcode . "changed to " . $newopcode . " - " . $opmotor  . " info has been recorded.");

		if ($stmt->execute() == 1) {
		    $stmt = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE trcode = ?");
        	$stmt->bindValue(1, $pin);
        	$stmt->execute();
        	$data = $stmt->fetch(PDO::FETCH_ASSOC);
        	$this->saveLogs("SAVE APPLICATION", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "CHANGE OWNERSHIP");
			return json_encode(array("result" => true, "msg" => "Application has been submited successfully.", "trcode" => $pin));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong when submitting the application. Please contact your administrator."));
		}
	}

	public function submitChangeDriver($opcode, $opmotor, $newopcode, $yr, $drcode, $remarks)
	{
			// CHECK IF THE OPERATOR ALREADY APPLIED WITH THE SAME MOTOR IN SPECIFIED YEAR
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE opercode = ? AND motorpin = ? AND dtexprd >= ? AND status = 'AVAILABLE'");
		$stmt->bindValue(1, $opcode);
		$stmt->bindValue(2, $opmotor);
		$stmt->bindValue(3, date('Y-m-d'));
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "This operator has no active application."));
		}

		// CHECK IF THE NEW MOTOR HAS AN ACTIVE FRANCHISE
		$stmt = $this->connect()->prepare("SELECT id FROM tbl_changedriver WHERE trcode = ?");
		$stmt->bindValue(1, $drcode);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			return json_encode(array("result" => false, "msg" => "New Driver is suggested to be used in change driver process."));
		}

		// GET motor data
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $opmotor);
		$stmt->execute();
		$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

			// GET AUTO PIN
		$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_changedriver WHERE yr = ? AND RIGHT(trcode,2) = 'CD'");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $yr . "-" . $pin['autopin'] . "-CD";


		$zxc = date('Y-m-d');

	
		$stmt = $this->connect()->prepare("INSERT INTO tbl_motorlinking (previous_operator, previous_motor, previous_driver,  operator, motor, driver, franchiseno, toda, foryear, trcode, appl_status, dtreg) VALUES (:previous_operator, :previous_motor, :previous_driver, :operator, :motor, :driver, :franchiseno, :toda, :foryear, :trcode, 'CHANGE DRIVER', :dtreg)");
		$stmt->bindParam(":previous_operator", $opcode);
		$stmt->bindParam(":previous_motor", $opmotor);
		$stmt->bindParam(":previous_driver", $drcode);
		$stmt->bindParam(":operator", $newopcode);
		$stmt->bindParam(":motor", $opmotor);
		$stmt->bindParam(":driver", $drcode);
		$stmt->bindParam(":franchiseno", $motordata['franchiseno']);
		$stmt->bindParam(":toda", $motordata['toda']);
		$stmt->bindParam(":foryear", $yr);
		$stmt->bindParam(":trcode", $pin);
		$stmt->bindParam(":dtreg", $zxc);
		$stmt->execute();
		
		//DATA LOGS FOR MOTORLINK
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE trcode = ?");
        $stmt->bindValue(1, $pin);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->saveLogs("INSERT MOTORLINK", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "MOTORLINK");



		// CHANGE OWNERSHIP SAVING
		$stmt = $this->connect()->prepare("INSERT INTO tbl_changedriver (trcode, yr, opercode, motorcode, newopercode, dateapplication, tagscode, Tags, encoded_by, remarks) VALUES (:trcode, :yr, :opercode, :motorcode, :newopercode, :dateapplication, 2, 'FOR INSPECTION', :encoded_by, :remarks)");
		$stmt->bindParam(":trcode", $pin);
		$stmt->bindParam(":yr", $yr);
		$stmt->bindParam(":opercode", $opcode);
		$stmt->bindParam(":motorcode", $opmotor);
		$stmt->bindParam(":newopercode", $newopcode);
		$stmt->bindParam(":dateapplication", $zxc);
		$stmt->bindParam(":encoded_by", $_SESSION['username']);
		$stmt->bindParam(":remarks", $remarks);

		$this->saveAudit("Change Driver Applied.", $pin . " - " . $opcode . "changed to " . $newopcode . " - " . $opmotor  . " info has been recorded.");

		if ($stmt->execute() == 1) {
		    $stmt = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE trcode = ?");
        	$stmt->bindValue(1, $pin);
        	$stmt->execute();
        	$data = $stmt->fetch(PDO::FETCH_ASSOC);
        	$this->saveLogs("SAVE APPLICATION", json_encode(array()), json_encode(array($data)), json_encode(array("trcode" => $pin)), $_SESSION['username'], "CHANGE DRIVER");
			return json_encode(array("result" => true, "msg" => "Application has been submited successfully.", "trcode" => $pin));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong when submitting the application. Please contact your administrator."));
		}
	}
	
	

	public function submitDriverPermit($opcode, $opmotor, $yr, $drcode, $tdpexp)
	{
		// CHECK IF THE DRIVER ALREADY APPLIED WITH THE SAME MOTOR IN SPECIFIED YEAR
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE drivercode = ? AND motorcode = ? AND yr = ? AND iscancel = 0");
		$stmt->bindValue(1, $drcode);
		$stmt->bindValue(2, $opmotor);
		$stmt->bindValue(3, $yr);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "This driver already has an application with this motor."));
		}

		// CHECK IF THE MOTOR IS LINKED TO THE OPERATOR CORRECTLY
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorid = ? AND opercode = ?");
		$stmt->bindValue(1, $opmotor);
		$stmt->bindValue(2, $opcode);
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "The motor is not linked to the operator properly."));
		}

		// GET AUTO PIN
		$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_application WHERE appl_status = 'TDP' AND yr = ? AND RIGHT(trcode,1) = 'T'");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $yr . "-" . $pin['autopin'] . "-T";

		// Saving Expiration Date to tbl_motor
		$stmt = $this->connect()->prepare("UPDATE tbl_motor SET dtexprd = ? WHERE motorid = ?");
		$stmt->bindValue(1, $yr . "-12-31");
		$stmt->bindValue(2, $opmotor);
		$stmt->execute();


		$this->saveAudit("Drivers Permit Applied.", $pin . " - " . $opcode . " - " . $drcode . " - " . $opmotor . " info has been updated.");

		if ($stmt->execute() == 1) {
			return json_encode(array("result" => true, "msg" => "Application has been submited successfully.", "trcode" => $pin));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong when submitting the application. Please contact your administrator."));
		}
	}

	public function getFranchise($yr, $trstats, $start, $length, $column, $order, $search)
	{

		$sql = "SELECT trcode, humanpin, motorcode, first_name, middle_name, last_name, ext_name, address_house_no, address_street_name, address_subdivision, address_brgy, address_municipality, address_province, a.franchise_no, appl_status, Tags, dttm, target_path, make FROM tbl_application AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE iscancel = 0 AND appl_status <> 'TDP' AND yr = " . $yr;

		$search_arr = array(0 => "trcode", 1 => "CONCAT(first_name, ' ', last_name)", 2 => "a.franchise_no", 3 => "CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_subdivision, ' ', address_municipality, ' ', address_province, ' ', address_region)", 4 => "dttm", 5 => "humanpin", 6 => "motorcode", 7 => "make");
        
		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}


		if (!empty($trstats)) {
			$sql .= " AND Tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}
		
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		$rc = $stmt->rowCount();

		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;

		$data = array();
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"opcode" => $key["humanpin"],
				"motorid" => $key["motorcode"],
				"target_path" => $key["target_path"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				"franchise_no" => $key["franchise_no"],
				"appl_status" => $key["appl_status"],
				"Tags" => $key["Tags"],
				"dttm" => $key["dttm"],
				"make" => $key["make"],
			    "buttons" => $this->statusButton($key["Tags"], "franchise")	
			));
		}

		return json_encode(array("data" => $data, "recordsTotal" => $stmt->rowCount(), "recordsFiltered" => $rc));
	}

	public function getDriversPermit($yr, $trstats, $start, $length, $column, $order, $search)
	{

		$sql = "SELECT trcode, CONCAT(own_fn, ' ', own_ln) AS fullname, CONCAT(hse_no, ' ', lot_no, ' ', blk_no, ' ', st, ' ', subdivision, ' ', brgy, ' ', Mun, ', ', prov, ', ', zip) as addr, a.franchise_no, appl_status, Tags, dttm FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.drivercode = b.file_id WHERE iscancel = 0 AND appl_status = 'TDP' AND yr = " . $yr;

		$search_arr = array(0 => "trcode", 1 => "CONCAT(own_fn, ' ', own_ln)", 2 => "a.franchise_no", 3 => "CONCAT(hse_no, ' ', lot_no, ' ', blk_no, ' ', st, ' ', subdivision, ' ', brgy, ' ', Mun, ', ', prov, ', ', zip)", 4 => "dttm");

		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}

		if (!empty($trstats)) {
			$sql .= " AND Tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}

		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;


		$stmt = $this->connect()->prepare($sql);

		$stmt->execute();
		return json_encode(array("data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
	}

	public function getDrop($yr, $trstats, $start, $length, $column, $order)
	{

		$sql = "SELECT a.trcode, a.opercode, first_name, middle_name, last_name, ext_name,  motorcode, CONCAT(toda, '-', bodyno) AS todabody, franchiseno, engine, chassis, reason, tags, dttm, target_path FROM tbl_drop AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS d ON a.motorcode = d.motorpin WHERE iscancel = 0 AND `year` = " . $yr;

		$search_arr = array(0 => "a.trcode", 1 => "CONCAT(b.first_name, ' ', b.last_name)", 2 => "CONCAT(toda, '-', bodyno)", 3 => "dttm", 4 => "a.opercode", 5 => "a.motorcode");

		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}

		if (!empty($trstats)) {
			$sql .= " AND tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}
		
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		$rc = $stmt->rowCount();

		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;

		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		$data = array();

		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"opcode" => $key["opercode"],
				"motorid" => $key["motorcode"],
				"target_path" => $key["target_path"],
				"fullname" => $this->concatfullname($key),
				"franchise_no" => $key["franchiseno"],
				"appl_status" => "DROPPING",
				"todabody" => $key["todabody"],
				"engine" => $key["engine"],
				"chassis" => $key["chassis"],
				"reason" => $key["reason"],
				"Tags" => $key["tags"],
				"dttm" => $key["dttm"],
				"buttons" => $this->statusButton($key["tags"], "dropping")
			));
		}

		return json_encode(array("data" => $data, "recordsTotal" => $stmt->rowCount(), "recordsFiltered" => $rc));
	}

	public function getdetFranchise($trcode)
	{
		// $stmt = $this->connect()->prepare("SELECT b.file_id as opercode, a.franchise_no, CONCAT(b.own_fn, ' ', b.own_ln) AS fullname, CONCAT(b.hse_no, ' ', b.lot_no, ' ', b.blk_no, ' ', b.st, ' ', b.subdivision, ' ', b.brgy, ' ', b.Mun, ', ', b.prov) as addr, b.cont_no, motorid, CONCAT(mo1, ' - ', f1) AS tbody, mo2, mo7, mo5, mo6, c.last_renew, trcode, b.target_path, appl_status, a.yr, Tags, a.operCode, a.drivercode, CONCAT(d.own_fn, ' ', d.own_ln) AS drname FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_motor AS c ON a.motorcode = c.motorid JOIN tbl_opdriver AS d ON a.drivercode = d.file_id WHERE trcode = ?");
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, c.platecolor, c.dtexprdstick, c.dtexprd, c.franchiseno, c.last_renew, a.trcode, b.target_path AS optp, d.target_path AS drtp, appl_status, a.yr, Tags, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no, c.status, c.remarks FROM tbl_application AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_motor AS c ON a.motorcode = c.motorpin LEFT JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE a.trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function getdetCMinitialMotor($motor)
	{
	    $stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE motorcode = ? AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Motor has pending application in Tricycle Franchise. Please settle it first."));
		}
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE (motorcode = ? OR newmotorcode = ?) AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
	    $stmt->bindValue(2, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Motor has pending application in Change Motor. Please settle it first."));
		}
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE motorcode = ? AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Motor has pending application in Change Ownership. Please settle it first."));
		}
	    
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, toda, bodyno, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew, b.target_path AS optp, d.target_path AS drtp, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no FROM tbl_motor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE a.motorpin = ?");
		$stmt->bindValue(1, $motor);
		$stmt->execute();
		return json_encode(array("result" => true, "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
	}

	public function getdetCMinitialMotors($motor)
	{
	    $stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE motorcode = ? AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Motor has pending application in Tricycle Franchise. Please settle it first."));
		}
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE (motorcode = ? OR newmotorcode = ?) AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
	    $stmt->bindValue(2, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Motor has pending application in Change Motor. Please settle it first."));
		}
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE motorcode = ? AND Tags <> 'RELEASED' AND iscancel = 0");
	    $stmt->bindValue(1, $motor);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
		    return json_encode(array("result" => false, "msg" => "Mot or has pending application in Change Driver. Please settle it first."));
		}
	    
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, toda, bodyno, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew, b.target_path AS optp, d.target_path AS drtp, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no FROM tbl_motor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE a.motorpin = ?");
		$stmt->bindValue(1, $motor);
		$stmt->execute();
		return json_encode(array("result" => true, "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
	}

	public function getdetChangeMotor($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew, b.target_path AS optp, d.target_path AS drtp, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no, Tags, trcode, appl_status, yr FROM tbl_changemotor AS c JOIN  tbl_motor AS a ON c.motorcode = a.motorpin JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE c.trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("SELECT motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew FROM tbl_changemotor AS a JOIN tbl_motor AS b ON a.newmotorcode = b.motorpin WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data['newmotor'] = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no AS mobile_no, b.target_path AS optp FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data['newoper'] = $stmt->fetch(PDO::FETCH_ASSOC);

		return json_encode($data);
	}

	public function getdetChangeOwnership($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew, b.target_path AS optp, d.target_path AS drtp, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no, Tags, trcode, appl_status, yr FROM tbl_changeownership AS c JOIN  tbl_motor AS a ON c.motorcode = a.motorpin JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE c.trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no AS mobile_no, b.target_path AS optp FROM tbl_changeownership AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data['newoper'] = $stmt->fetch(PDO::FETCH_ASSOC);

		return json_encode($data);
	}

	public function getdetChangeDriver($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, platecolor, dtexprdstick, dtexprd, franchiseno, last_renew, b.target_path AS optp, d.target_path AS drtp, a.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no, Tags, trcode, appl_status, yr FROM tbl_changedriver AS c JOIN  tbl_motor AS a ON c.motorcode = a.motorpin JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE c.trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no AS mobile_no, b.target_path AS optp FROM tbl_changedriver AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data['newoper'] = $stmt->fetch(PDO::FETCH_ASSOC);

		return json_encode($data);
	}

	public function getdetDriverPermit($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT b.file_id as opercode, CONCAT(b.own_fn, ' ', b.own_ln) AS fullname, CONCAT(b.hse_no, ' ', b.lot_no, ' ', b.blk_no, ' ', b.st, ' ', b.subdivision, ' ', b.brgy, ' ', b.Mun, ', ', b.prov) as addr, b.cont_no, motorid, CONCAT(mo1, ' - ', f1) AS tbody, mo2, mo7, mo5, mo6, c.franchise_no, c.last_renew, a.trcode, b.target_path AS optp, d.target_path AS drtp, appl_status, a.yr, Tags, a.operCode, a.drivercode, CONCAT(d.own_fn, ' ', d.own_ln) AS drname, CONCAT(d.hse_no, ' ', d.lot_no, ' ', d.blk_no, ' ', d.st, ' ', d.subdivision, ' ', d.brgy, ' ', d.Mun, ', ', d.prov) as draddr, d.cont_no as drcont_no, e.tdpno, tdpexp FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_motor AS c ON a.motorcode = c.motorid JOIN tbl_opdriver AS d ON a.drivercode = d.file_id JOIN tbl_tdp AS e ON a.trcode = e.trcode WHERE a.trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}
	
	public function getCurAssFees($trcode) {
	    $stmt = $this->connect()->prepare("SELECT feesid FROM tbl_assessment WHERE trcode = ?");
	    $stmt->bindValue(1, $trcode);
	    $stmt->execute();
	    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return json_encode(array("curass" => $data));
	}

	public function getAssFees($applstatus, $trcode)
	{
		try {
			$app = $this->connect()->prepare("SELECT a.foryear, b.dtexprd FROM tbl_motorlinking AS a JOIN tbl_motor AS b ON a.motor = b.motorpin WHERE trcode = ?");
			$app->bindValue(1, $trcode);
			$app->execute();
			$data = $app->fetch(PDO::FETCH_ASSOC);

			$stmt = $this->connect()->prepare("SELECT * FROM tbl_assoffees WHERE trans = ? ORDER BY ID");
			$stmt->bindValue( 1, $applstatus);
			$stmt->execute();
			$ass = $stmt->fetchAll(PDO::FETCH_ASSOC);	

			$stmt = $this->connect()->prepare("SELECT expmode FROM ysettings");
			$stmt->execute();
			$settings = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($applstatus == "RENEW") {
				$dtnow = date_create(date("Y-m-d"));
				$dtreg = ($settings['expmode'] == 0 ? ($data['dtexprd'] != "2023-12-31" ? date_create($data['dtexprd']) : $dtnow) : date_create($data['foryear']."-01-01"));
			
				$month = date_diff($dtreg, $dtnow);
				$months = ($dtreg == $dtnow ? 0 : $month->format("%m") + 1);

				for ($i=0; $i < count($ass); $i++) {
					if ($ass[$i]['collnature'] == '21672') {
							if ($months == 0) {
								unset($ass[$i]);
							} else {
								$pen = floatval($months) * floatval($ass[$i]['AmtDue']); 
								$ass[$i]['AmtDue'] = number_format((float)$pen, 2, '.', '');
							}
					}
				}
			}

			$fuck = array();
			foreach ($ass as $key => $value) {
			    array_push($fuck, $value);
			}

			return json_encode(array("data" => $fuck));
		} catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}

	public function getRequirements($applstatus)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_requirements WHERE trans = ?");
		$stmt->bindValue(1, $applstatus);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function saveAssessment($spay, $trcode, $trans)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ? AND status = 'PAID'");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => 'This application is already paid..'));
		}
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
    	$stmt->bindValue(1, $trcode);
    	$stmt->execute();
    	$prevdata = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("DELETE FROM tbl_assessment WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$stmt = "";
		$app = "";
		switch ($trans) {
			case "NEW":
			case "RENEW":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
				break;
			case "CHANGE MOTOR":
				$stmt = $this->connect()->prepare("SELECT yr, newmotorcode AS motorcode FROM tbl_changemotor WHERE trcode = ?");
				break;
			case "CHANGE OWNERSHIP":
				$stmt = $this->connect()->prepare("SELECT yr, motorcode FROM tbl_changeownership WHERE trcode = ?");
				break;
			case "CHANGE DRIVER":
				$stmt = $this->connect()->prepare("SELECT yr, motorcode FROM tbl_changedriver WHERE trcode = ?");
				break;
			case "DROPPING":
				$stmt = $this->connect()->prepare("SELECT year as yr, motorcode FROM tbl_drop WHERE trcode = ?");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		$app = $stmt->fetch();

		foreach ($spay as $key => $value) {
			$stmt = $this->connect()->prepare("INSERT INTO tbl_assessment (trcode, yr, motorid, feesid, Fees, AmtDue, collnature, istin) VALUES(?,?,?,?,?, ?,?,?)");
			$stmt->bindValue(1, $trcode);
			$stmt->bindValue(2, $app['yr']);
			$stmt->bindValue(3, $app['motorcode']);
			$stmt->bindValue(4, $value['ID']);
			$stmt->bindValue(5, $value['Fees']);
			// if($value['Fees'] == 'SURCHARGES'){
			// 	$stmt->bindValue(6, ($totamt*0.25));
			// } else {
			// 	$stmt->bindValue(6, $value['AmtDue']);
			// 	$totamt += $value['AmtDue'];
			// }
			$stmt->bindValue(6, $value['AmtDue']);
			$stmt->bindValue(7, $value['collnature']);
			$stmt->bindValue(8, 1);
			$stmt->execute();
		}

		switch ($trans) {
			case "NEW":
			case "RENEW":
				$stmt = $this->connect()->prepare("UPDATE tbl_application SET tags = 'FOR PAYMENT', tagscode = 4 WHERE trcode = ?");
				$this->saveAudit("Franchise Assessment", $trcode . " have been assessed.");
				break;
			case "CHANGE MOTOR":
				$stmt = $this->connect()->prepare("UPDATE tbl_changemotor SET tags = 'FOR PAYMENT', tagscode = 4 WHERE trcode = ?");
				$this->saveAudit("Change Motor Assessment", $trcode . " have been assessed.");
				break;
			case "CHANGE OWNERSHIP":
				$stmt = $this->connect()->prepare("UPDATE tbl_changeownership SET tags = 'FOR PAYMENT', tagscode = 4 WHERE trcode = ?");
				$this->saveAudit("Change Ownership Assessment", $trcode . " have been assessed.");
				break;
			case "CHANGE DRIVER":
				$stmt = $this->connect()->prepare("UPDATE tbl_changedriver SET tags = 'FOR PAYMENT', tagscode = 4 WHERE trcode = ?");
				$this->saveAudit("Change Driver Assessment", $trcode . " have been assessed.");
				break;	
			case "DROPPING":
				$stmt = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'FOR PAYMENT', tagscode = 4 WHERE trcode = ?");
				$this->saveAudit("Dropping Assessment", $trcode . " have been assessed.");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
    	$stmt->bindValue(1, $trcode);
    	$stmt->execute();
    	$currdata = $stmt->fetch(PDO::FETCH_ASSOC);
    	$this->saveLogs("SAVE ASSESSMENT", json_encode(array($prevdata)), json_encode(array($currdata)), json_encode(array("trcode" => $trcode)), $_SESSION['username'], "ASSESSMENT");
		
		// if ($app['appl_status']  'TDP') {

		// } else {
		// 	$this->saveAudit("Drivers Permit Assessment", $trcode." have been assessed.");
		// }

		return json_encode(array("result" => true, "msg" => "This application has been assessed successfully."));
	}

	public function getdetAssFee($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT a.trcode, a.appl_status, a.dtreg, a.issticker, a.isprovi, b.certno, b.certat, b.certon, CONCAT(e.own_fn, ' ', e.own_ln) AS operator, CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, CONCAT(b.hse_no, ' ', b.lot_no, ' ', b.blk_no, ' ', b.st, ' ', b.subdivision, ' ', b.brgy, ' ',b.Mun, ', ', b.prov) as addr, CONCAT(mo1, ' - ', f1) AS tbody, LEFT( mo1,(LENGTH(mo1) - 5)) AS tdesc, mo2, mo7, mo5, mo6, mo3, Fees, AmtDue FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_motor AS c ON a.motorcode = c.motorid LEFT JOIN tbl_opdriver AS e ON a.drivercode = e.file_id JOIN tbl_assessment AS d ON a.trcode = d.trcode WHERE a.trcode = ? ORDER BY assid");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function getdetAssRelease($trcode, $trans)
	{
		$stmt = $this->connect()->prepare("SELECT AmtDue, or_number, or_date, Fees FROM tbl_assessment WHERE trcode = ? ORDER BY assid ASC");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$stmt2 = "";
		$nmtp = "";
		switch ($trans) {
			case "NEW":
			case "RENEW":
				$stmt2 = $this->connect()->prepare("SELECT a.dtexprd, a.franchise_no, a.trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(toda , ' - #', bodyno) AS tbody, toda, make FROM tbl_application AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE a.trcode = ?");

				$nmtp = $this->connect()->prepare("SELECT IFNULL(LPAD((MAX(franchise_no)+1), 4, 0) ,'0001') as next_mtop FROM tbl_application WHERE yr = (SELECT yr from tbl_application where trcode = ?) AND franchise_no <> '' AND appl_status <> 'TDP' ORDER BY franchise_no DESC");
				$nmtp->bindValue(1, $trcode);
				$nmtp->execute();

				break;
			case "CHANGE MOTOR":
				$stmt3 = $this->connect()->prepare("SELECT tags FROM tbl_changemotor WHERE trcode = ?");
				$stmt3->bindValue(1, $trcode);
				$stmt3->execute();
				$zad = $stmt3->fetch(PDO::FETCH_ASSOC);

				if ($zad['tags'] == "RELEASED") {
					$stmt2 = $this->connect()->prepare("SELECT c.dtexprd, c.franchiseno AS franchise_no, a.trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(toda , ' - #', bodyno) AS tbody, c.make FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.newmotorcode = c.motorpin WHERE a.trcode = ?");
				} else if ($zad['tags'] == "FOR RELEASING") {
					$stmt2 = $this->connect()->prepare("SELECT c.dtexprd, d.franchiseno AS franchise_no, a.trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(c.toda , ' - #', c.bodyno) AS tbody, c.make FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.newmotorcode = c.motorpin JOIN tbl_motor AS d ON a.motorcode = d.motorpin WHERE a.trcode = ?");
				} else {
					return json_encode(array("result" => false, "msg" => 'Application is still in ' + $zad['tags'] + ' status'));
				}

				break;
			case "CHANGE OWNERSHIP":
				$stmt2 = $this->connect()->prepare("SELECT c.dtexprd, c.franchiseno AS franchise_no, a.trcode, CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), '/', CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name)) AS opname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as addr, CONCAT(toda , ' - #', bodyno) AS tbody, make FROM tbl_changeownership AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON a.newopercode = d.humanpin WHERE a.trcode = ?");
				break;
			case "CHANGE DRIVER":
				$stmt2 = $this->connect()->prepare("SELECT c.dtexprd, c.franchiseno AS franchise_no, a.trcode, CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), '/', CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name)) AS opname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as addr, CONCAT(toda , ' - #', bodyno) AS tbody, make FROM tbl_changedriver AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON a.newopercode = d.humanpin WHERE a.trcode = ?");
				break;	
			case "DROPPING":
				$stmt2 = $this->connect()->prepare("SELECT c.dtexprd, c.franchiseno AS franchise_no, a.trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(toda , ' - #', bodyno) AS tbody, make FROM tbl_drop AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE a.trcode = ?");
				break; 
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}

		$stmt2->bindValue(1, $trcode);
		$stmt2->execute();


		$data = $stmt2->fetch(PDO::FETCH_ASSOC);
		if ($nmtp) {
			$data += $nmtp->fetch(PDO::FETCH_ASSOC);
		}
		return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "info" => $data));
	}

	public function getLastRenew($op, $dr, $motor)
	{
		$stmt = $this->connect()->prepare("SELECT DISTINCT yr as lastyr FROM tbl_application WHERE motorcode = ? AND iscancel = 0 ORDER BY yr DESC LIMIT 1");
		$stmt->bindValue(1, $motor);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function saveRelease($mtp, $mtpdt, $dtexp, $trcode, $trans)
	{
		// try {
		$stmt = "";
		$stmt2 = "";
		switch ($trans) {
			case "NEW":
			case "RENEW":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ? AND Tags = 'RELEASED'");
				break;
			case "CHANGE MOTOR":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE trcode = ? AND Tags = 'RELEASED'");
				break;
			case "CHANGE OWNERSHIP":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE trcode = ? AND Tags = 'RELEASED'");
				break;
			case "CHANGE DRIVER":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE trcode = ? AND Tags = 'RELEASED'");
				break;
			case "DROPPING":
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ? AND tags = 'RELEASED'");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}

		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "This is already released.."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($data as $key => $value) {
			if ($value['status'] == "UNPAID") {
				return json_encode(array("result" => false, "msg" => "This is not PAID at all."));
			}
		}
		
		switch ($trans) {
			case "NEW":
			case "RENEW":
				$idataq = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
				break;
			case "CHANGE MOTOR":
				$idataq = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE trcode = ?");
				break;
			case "CHANGE OWNERSHIP":
				$idataq = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE trcode = ?");
				break;
			case "CHANGE DRIVER":
				$idataq = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE trcode = ?");
				break;
			case "DROPPING":
				$idataq = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ?");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}
		
		$idataq->bindValue(1, $trcode);
		$idataq->execute();
		$idata = $idataq->fetch(PDO::FETCH_ASSOC);
		
		$iquery = $this->connect()->prepare("SELECT make FROM tbl_motor WHERE motorpin = ?");
		if ($trans != "CHANGE MOTOR") {
		    $iquery->bindValue(1, $idata['motorcode']);
		} else {
		    $iquery->bindValue(1, $idata['newmotorcode']);
		}
		$iquery->execute();
		$imake = $iquery->fetch(PDO::FETCH_ASSOC);
		
		// if ($imake['make'] != "E-TRIKE") {
		//     $tquery = $this->connect()->prepare("SELECT toda FROM tbl_motorlinking WHERE trcode = ?");
    //         $tquery->bindValue(1, $trcode);
    //         $tquery->execute();
    //         $todas = $tquery->fetch(PDO::FETCH_ASSOC);
    
    // 		$stmt = $this->connect()->prepare("SELECT todacode FROM tbl_toda WHERE CAST(? AS UNSIGNED INT) BETWEEN CAST(rangelow AS UNSIGNED INT) AND CAST(rangehigh AS UNSIGNED INT) AND todacode <> 'ETRIKE'");
    // 		$stmt->bindValue(1, $mtp);
    // 		$stmt->execute();
    //         $todaz = $stmt->fetch(PDO::FETCH_ASSOC);
            
    // 		if ($todaz['todacode'] != $todas['toda']) {
    // 			return json_encode(array("result" => false, "msg" => "Franchise is not in the range of this TODA.", "data" => $todas));
    // 		}
		// } 
	
		switch ($trans) {
			case "NEW":
			case "RENEW":
			    // GET APPLICATION DATA
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
				$stmt->bindValue(1, $trcode);
				$stmt->execute();
				$fapp = $stmt->fetch(PDO::FETCH_ASSOC);
				
				// APPLICATION UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_application SET tags = 'RELEASED', tagscode = 6, franchise_no = :franchise_no, franchise_date = :franchise_date, dtexprd = :dtexprd WHERE trcode = :trcode");
				$stmt->bindValue(":franchise_no", $mtp);
				$stmt->bindValue(":franchise_date", $mtpdt);
				$stmt->bindValue(":dtexprd", $dtexp);
				$stmt->bindValue(":trcode", $trcode);
				$stmt->execute();
				
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
      	$stmt->bindValue(1, $trcode);
      	$stmt->execute();
      	$currdata = $stmt->fetch(PDO::FETCH_ASSOC);
      	$this->saveLogs("SAVE RELEASE", json_encode(array($fapp)), json_encode(array($currdata)), json_encode(array("trcode" => $trcode)), $_SESSION['username'], "RELEASE_APPLICATION");

				// MOTOR UPDATE
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
            	$stmt->bindValue(1, $fapp['motorcode']);
            	$stmt->execute();
            	$prevdata = $stmt->fetch(PDO::FETCH_ASSOC);
				
				$stmt2 = $this->connect()->prepare("UPDATE tbl_motor AS a JOIN tbl_application AS b ON a.motorpin = b.motorcode SET a.franchiseno = b.franchise_no, a.bodyno = b.franchise_no, last_renew = b.franchise_date, last_renew_sticker = b.franchise_date, foryear = year(now()), a.dtexprd = b.dtexprd, a.dtexprdstick = b.dtexprd, orfran = b.f4, orstick = b.f4, a.drivercode = b.drivercode WHERE b.trcode = :trcode");
				$stmt2->bindValue(":trcode", $trcode);
				$stmt2->execute();
				
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
      	$stmt->bindValue(1, $fapp['motorcode']);
      	$stmt->execute();
      	$currdata = $stmt->fetch(PDO::FETCH_ASSOC);
      	$this->saveLogs("SAVE RELEASE", json_encode(array($prevdata)), json_encode(array($currdata)), json_encode(array("motorpin" => $fapp['motorcode'])), $_SESSION['username'], "RELEASE_MOTOR");
				
				// UPDATE FRANCHISE LIST TABLE
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_franlist WHERE franchiseno = ?");
            	$stmt->bindValue(1, $mtp);
            	$stmt->execute();
            	$prevdata = $stmt->fetch(PDO::FETCH_ASSOC);
				
				// $stmt = $this->connect()->prepare("UPDATE tbl_franlist SET opercode = ?, motorid = ?, trcode = ?, status = 'NOT AVAILABLE', dtissue = ?, dtexprd = ? WHERE franchiseno = ?");
        // $stmt->bindValue(1, $fapp['opercode']);
        // $stmt->bindValue(2, $fapp['motorcode']);
        // $stmt->bindValue(3, $fapp['trcode']);
        // $stmt->bindValue(4, $mtpdt);
        // $stmt->bindValue(5, $dtexp);
        // $stmt->bindValue(6, $mtp);
        // $stmt->execute();

		    // MARK AS DRIVER OPERATOR
		    $stmt = $this->connect()->prepare("UPDATE tbl_humans SET isoperator = 1 WHERE humanpin = ?");
        $stmt->bindValue(1, $fapp['opercode']);
        $stmt->execute();

        $stmt = $this->connect()->prepare("UPDATE tbl_humans SET isdriver = 1 WHERE humanpin = ?");
        $stmt->bindValue(1, $fapp['drivercode']);
        $stmt->execute();

				// MOTOR LINKING UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET franchiseno = ?, dtexprd = ?, dtreg = ? WHERE trcode = ?");
				$stmt->bindValue(1, $mtp);
				$stmt->bindValue(2, $dtexp);
				$stmt->bindValue(3, $mtpdt);
				$stmt->bindValue(4, $trcode);
				$stmt->execute();
				
				
				break;
			case "CHANGE MOTOR":
				// GET APPLICATION DATA
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE trcode = ?");
				$stmt->bindValue(1, $trcode);
				$stmt->execute();
				$cmapp = $stmt->fetch(PDO::FETCH_ASSOC);

				// GET motor data
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
				$stmt->bindValue(1, $cmapp['motorcode']);
				$stmt->execute();
				$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

				// Saving Expiration Date to tbl_motor
				$stmt = $this->connect()->prepare("UPDATE tbl_motor SET franchiseno = ? WHERE motorpin = ?");
				$stmt->bindValue(1, $motordata['franchiseno']);
				$stmt->bindValue(2, $cmapp['newmotorcode']);
				$stmt->execute();

				// MARK AS DROPPING THE OLD MOTOR
				$stmt = $this->connect()->prepare("UPDATE tbl_motor SET isdrop = 1, remarks = 'DROPPED DUE TO CHANGE MOTOR', status = 'UNAVAILABLE' WHERE motorpin = ?");
				$stmt->bindValue(1,  $cmapp['motorcode']);
				$stmt->execute();

				// APPLICATION UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_changemotor SET tags = 'RELEASED', tagscode = 6 WHERE trcode = :trcode");
				$stmt->bindValue(":trcode", $trcode);
				$stmt->execute();

				// MOTOR UPDATE
				$stmt2 = $this->connect()->prepare("UPDATE tbl_motor AS a JOIN tbl_changemotor AS b ON a.motorpin = b.newmotorcode SET a.franchiseno = a.munplateno, a.bodyno = a.munplateno, last_renew = :franchise_date, last_renew_sticker = :franchise_date, foryear = year(now()), a.dtexprd = :dtexprd, a.dtexprdstick = :dtexprd, orfran = b.orno, orstick = b.orno WHERE b.trcode = :trcode");
				$stmt2->bindValue(":franchise_date", $mtpdt);
				$stmt2->bindValue(":dtexprd", $dtexp);
				$stmt2->bindValue(":trcode", $trcode);
				$stmt2->execute();
				
				// UPDATE FRANCHISE LIST TABLE
				$stmt = $this->connect()->prepare("UPDATE tbl_franlist SET opercode = ?, motorid = ?, trcode = ?, status = 'NOT AVAILABLE', dtissue = ?, dtexprd = ? WHERE franchiseno = ?");
		        $stmt->bindValue(1, $cmapp['newopercode']);
		        $stmt->bindValue(2, $cmapp['newmotorcode']);
		        $stmt->bindValue(3, $cmapp['trcode']);
		        $stmt->bindValue(4, $mtpdt);
		        $stmt->bindValue(5, $dtexp);
		        $stmt->bindValue(6, $motordata['franchiseno']);
		        $stmt->execute();

				
				// MOTOR LINKING UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET franchiseno = ?, dtexprd = ?, dtreg = ? WHERE trcode = ?");
				$stmt->bindValue(1, $mtp);
				$stmt->bindValue(2, $dtexp);
				$stmt->bindValue(3, $mtpdt);
				$stmt->bindValue(4, $trcode);
				$stmt->execute();
				break;
				
			case "CHANGE OWNERSHIP":
				// GET APPLICATION DATA
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE trcode = ?");
				$stmt->bindValue(1, $trcode);
				$stmt->execute();
				$coapp = $stmt->fetch(PDO::FETCH_ASSOC);

				// CHANGING NEW OPERATOR
				$stmt = $this->connect()->prepare("UPDATE tbl_motor SET opercode = ? WHERE motorpin = ?");
				$stmt->bindValue(1, $coapp['newopercode']);
				$stmt->bindValue(2, $coapp['motorcode']);
				$stmt->execute();

				// APPLICATION UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_changeownership SET tags = 'RELEASED', tagscode = 6 WHERE trcode = :trcode");
				$stmt->bindValue(":trcode", $trcode);
				$stmt->execute();
				
				// UPDATE FRANCHISE LIST TABLE
				$stmt = $this->connect()->prepare("UPDATE tbl_franlist SET opercode = ?, motorid = ?, trcode = ?, status = 'NOT AVAILABLE', dtissue = ?, dtexprd = ? WHERE franchiseno = ?");
		        $stmt->bindValue(1, $coapp['newopercode']);
		        $stmt->bindValue(2, $coapp['motorcode']);
		        $stmt->bindValue(3, $coapp['trcode']);
		        $stmt->bindValue(4, $mtpdt);
		        $stmt->bindValue(5, $dtexp);
		        $stmt->bindValue(6, $mtp);
		        $stmt->execute();

				// MOTOR LINKING UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET dtexprd = ?, dtreg = ? WHERE trcode = ?");
				$stmt->bindValue(1, $dtexp);
				$stmt->bindValue(2, $mtpdt);
				$stmt->bindValue(3, $trcode);
				$stmt->execute();
				break;


				case "CHANGE DRIVER":
				// GET APPLICATION DATA
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE trcode = ?");
				$stmt->bindValue(1, $trcode);
				$stmt->execute();
				$coapp = $stmt->fetch(PDO::FETCH_ASSOC);

				// CHANGING NEW OPERATOR
				$stmt = $this->connect()->prepare("UPDATE tbl_motor SET opercode = ? WHERE motorpin = ?");
				$stmt->bindValue(1, $coapp['newopercode']);
				$stmt->bindValue(2, $coapp['motorcode']);
				$stmt->execute();

				// APPLICATION UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_changedriver SET tags = 'RELEASED', tagscode = 6 WHERE trcode = :trcode");
				$stmt->bindValue(":trcode", $trcode);
				$stmt->execute();
				
				// UPDATE FRANCHISE LIST TABLE
				$stmt = $this->connect()->prepare("UPDATE tbl_franlist SET opercode = ?, motorid = ?, trcode = ?, status = 'NOT AVAILABLE', dtissue = ?, dtexprd = ? WHERE franchiseno = ?");
		        $stmt->bindValue(1, $coapp['newopercode']);
		        $stmt->bindValue(2, $coapp['motorcode']);
		        $stmt->bindValue(3, $coapp['trcode']);
		        $stmt->bindValue(4, $mtpdt);
		        $stmt->bindValue(5, $dtexp);
		        $stmt->bindValue(6, $mtp);
		        $stmt->execute();

				// MOTOR LINKING UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET dtexprd = ?, dtreg = ? WHERE trcode = ?");
				$stmt->bindValue(1, $dtexp);
				$stmt->bindValue(2, $mtpdt);
				$stmt->bindValue(3, $trcode);
				$stmt->execute();
				break;

			case "DROPPING":
				// GET APPLICATION DATA
				$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ?");
				$stmt->bindValue(1, $trcode);
				$stmt->execute();
				$dapp = $stmt->fetch(PDO::FETCH_ASSOC);

				// CHANGING NEW OPERATOR
				$stmt = $this->connect()->prepare("UPDATE tbl_motor SET isdrop = 1, remarks = ?, `status` = 'UNAVAILABLE' WHERE motorpin = ?");
				$stmt->bindValue(1, $dapp['reason']);
				$stmt->bindValue(2, $dapp['motorcode']);
				$stmt->execute();

				// APPLICATION UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'RELEASED', tagscode = 6 WHERE trcode = :trcode");
				$stmt->bindValue(":trcode", $trcode);
				$stmt->execute();
				
				// UPDATE FRANCHISE LIST TABLE
				$stmt = $this->connect()->prepare("UPDATE tbl_franlist SET opercode = '', motorid = '', trcode = '', status = 'AVAILABLE', dtissue = '', dtexprd = '' WHERE franchiseno = ?");
		        $stmt->bindValue(1, $mtp);
		        $stmt->execute();

				// MOTOR LINKING UPDATE
				$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET dtreg = ? WHERE trcode = ?");
				$stmt->bindValue(1, $mtpdt);
				$stmt->bindValue(2, $trcode);
				$stmt->execute();
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}

		// $stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ? AND collnature = 185 AND status = 'PAID'");
		// $stmt->bindValue(1, $trcode);
		// $stmt->execute();
		// if ($stmt->rowCount() > 0) {
		// 	$stmt = $this->connect()->prepare("UPDATE tbl_application SET issticker = 1 WHERE trcode = ?");
		// 	$stmt->bindValue(1, $trcode);
		// 	$stmt->execute();
		// }

		$mac = "UNKNOWN";
// 		foreach (explode("\n", str_replace(' ', '', trim(`getmac`, "\n"))) as $i)
// 			if (strpos($i, 'Tcpip') > -1) {
// 				$mac = substr($i, 0, 17);
// 				break;
// 			}

		if ($trans == 'DROPPING') {
			$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Dropping Release', NOW(), date(NOW()), :transdetails, :pcname)");
			$stmt->bindParam(':username', $_SESSION['username']);
			$stmt->bindParam(':realname', $_SESSION['fullname']);
			$stmt->bindParam(':pcname', $mac);
			$det = $dapp['motorcode'] . ' has been officially drop due to ' . $dapp['reason'] . ' - ' . $trcode;
			$stmt->bindParam(':transdetails', $det);
			$stmt->execute();
		} else {
			$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Franchise Release', NOW(), date(NOW()), :transdetails, :pcname)");
			$stmt->bindParam(':username', $_SESSION['username']);
			$stmt->bindParam(':realname', $_SESSION['fullname']);
			$stmt->bindParam(':pcname', $mac);
			$det = 'Issue Franchise #' . $mtp . ' to ' . $trcode;
			$stmt->bindParam(':transdetails', $det);
			$stmt->execute();
		}


		return json_encode(array("result" => true, "msg" => 'Issue Franchise #' . $mtp . ' to ' . $trcode));
		// } catch (Exception $e) {
		// 	return json_encode(array("result" => false, "msg" => $e->getMessage()));
		// }
	}

	public function saveTDPRelease($tdp, $tdpexp, $reldt, $trcode)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ? AND Tags = 'RELEASED'");
			$stmt->bindValue(1, $trcode);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				return json_encode(array("result" => false, "msg" => "This is already released.."));
			}

			$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
			$stmt->bindValue(1, $trcode);
			$stmt->execute();
			$data = $stmt->fetchAll();

			foreach ($data as $key => $value) {
				if ($value['status'] == "UNPAID") {
					return json_encode(array("result" => false, "msg" => "This is not PAID at all."));
				}
			}

			$stmt = $this->connect()->prepare("UPDATE tbl_application SET tags = 'RELEASED', tagscode = 5, franchise_no = ?, franchise_date = ?, dtexprd = ? WHERE trcode = ?");
			$stmt->bindValue(1, $tdp);
			$stmt->bindValue(2, $reldt);
			$stmt->bindValue(3, $tdpexp);
			$stmt->bindValue(4, $trcode);
			$stmt->execute();

			$stmt = $this->connect()->prepare("UPDATE tbl_opdriver AS a JOIN tbl_application AS b ON a.file_id = b.drivercode SET a.franchise_no = ?, last_renew = ? WHERE b.trcode = ?");
			$stmt->bindValue(1, $tdp);
			$stmt->bindValue(2, $reldt);
			$stmt->bindValue(3, $trcode);
			$stmt->execute();

			$stmt = $this->connect()->prepare("UPDATE tbl_motor AS a JOIN tbl_application AS b ON a.motorid = b.motorcode SET a.drivercode = b.drivercode, lastor = b.f4 WHERE b.trcode = ?");
			$stmt->bindValue(1, $trcode);
			$stmt->execute();

			$stmt = $this->connect()->prepare("UPDATE tbl_tdp SET tdpno = ?, tdpexp = ? WHERE trcode = ?");
			$stmt->bindValue(1, $tdpno);
			$stmt->bindValue(2, $tdpexp);
			$stmt->bindValue(3, $trcode);
			$stmt->execute();

			$mac = "UNKNOWN";
			foreach (explode("\n", str_replace(' ', '', trim(`getmac`, "\n"))) as $i)
				if (strpos($i, 'Tcpip') > -1) {
					$mac = substr($i, 0, 17);
					break;
				}

			$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Franchise Release', NOW(), date(NOW()), :transdetails, :pcname)");
			$stmt->bindParam(':username', $_SESSION['username']);
			$stmt->bindParam(':realname', $_SESSION['fullname']);
			$stmt->bindParam(':pcname', $mac);
			$det = 'Issue TDP #' . $tdp . ' to ' . $trcode;
			$stmt->bindParam(':transdetails', $det);
			$stmt->execute();

			return json_encode(array("result" => true, "msg" => $det));
		} catch (Exception $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function getDropList()
	{
		$stmt = $this->connect()->prepare("SELECT b.file_id AS appcode, CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, c.file_id AS opercode, CONCAT(c.own_fn, ' ', c.own_ln) AS operator, motorid, mo1, mo7, mo6 FROM tbl_motor AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id LEFT JOIN tbl_opdriver AS c ON a.drivercode = c.file_id WHERE mo9 = 'AVAILABLE'");
		// $stmt = $this->connect()->prepare("SELECT b.file_id AS appcode, CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, c.file_id AS opercode, CONCAT(c.own_fn, ' ', c.own_ln) AS operator, motorid, mo1, mo7, mo6 FROM tbl_motor AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_opdriver AS c ON a.drivercode = c.file_id WHERE mo9 = 'AVAILABLE'");
		$stmt->execute();
		return json_encode($stmt->fetchAll());
	}

	public function getdetDrop($code)
	{
		$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, b.mobile_no, motorpin, CONCAT(toda, ' - ', bodyno) AS tbody, make, engine, chassis, plateno, c.platecolor, c.dtexprdstick, c.dtexprd, c.franchiseno, c.last_renew, a.trcode, b.target_path AS optp, d.target_path AS drtp, 'DROPPING' AS appl_status, `year` AS yr, Tags, c.drivercode, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province, ', ', d.address_region) as draddr, d.mobile_no as drcont_no, c.status, c.remarks, reason FROM tbl_drop AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON c.drivercode = d.humanpin WHERE a.trcode = ?");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function submitDrop($motorcode, $opercode, $drivercode, $reason, $yr, $mtp, $remarks)
	{
		// CHECKING IF THE MOTOR IS ALREADY UNAVAILABLE
		$stmt = $this->connect()->prepare("SELECT `status` FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $motorcode);
		$stmt->execute();
		$data = $stmt->fetch();

		if ($data['status'] == "UNAVAILABLE") {
			return json_encode(array("result" => false, "msg" => "This motor is already dropped"));
		}

		// GET AUTO PIN
		$stmt = $this->connect()->prepare("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(trcode), 7), 5)) + 1, 5, 0) as autopin FROM tbl_drop WHERE year = ? AND RIGHT(trcode,1) = 'D'");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = $yr . "-" . $pin['autopin'] . "-D";

		// GET motor data
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $motorcode);
		$stmt->execute();
		$motordata = $stmt->fetch(PDO::FETCH_ASSOC);

		// SAVE DROPPING RECORD
		$stmt = $this->connect()->prepare("INSERT INTO tbl_drop (opercode, franchise_no, motorcode, username, date_create, tags, reason, trcode, tagscode, year) VALUES(:fileid, :franchiseno, :motorcode, :username, DATE(NOW()), 'FOR INSPECTION', :reason, :trcode, 2, :year)");
		$stmt->bindParam(':fileid', $opercode);
		$stmt->bindParam(':franchiseno', $mtp);
		$stmt->bindParam(':motorcode', $motorcode);
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':reason', $reason);
		$stmt->bindParam(':trcode', $pin);
		$stmt->bindParam(':year', $yr);
		$stmt->execute();

		// JUST SELECTING NOTHING SPECIAL
		// $stmt = $this->connect()->prepare("SELECT CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, CONCAT(c.own_fn, ' ', c.own_ln) AS operator FROM tbl_motor AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_opdriver AS c ON a.drivercode = c.file_id WHERE motorid = ?");
		// $stmt->bindValue(1, $motorcode);
		// $stmt->execute();
		// $data = $stmt->fetch();

		// MOTOR LINKING
		$zxc = date('Y-m-d');
		$stmt = $this->connect()->prepare("INSERT INTO tbl_motorlinking (previous_operator, previous_motor, previous_driver, operator, motor, driver, franchiseno, toda, foryear, trcode, appl_status) VALUES (:previous_operator, :previous_motor, :previous_driver, :operator, :motor, :driver, :franchiseno, :toda, :foryear, :trcode, :appl_status)");
		$stmt->bindParam(":previous_operator", $opercode);
		$stmt->bindParam(":previous_motor", $motorcode);
		$stmt->bindParam(":previous_driver", $motordata['drivercode']);
		$stmt->bindParam(":operator", $opercode);
		$stmt->bindParam(":motor", $motorcode);
		$stmt->bindParam(":driver", $drivercode);
		$stmt->bindParam(":franchiseno", $motordata['fracnchiseno']);
		$stmt->bindParam(":toda", $motordata['toda']);
		$stmt->bindParam(":foryear", $yr);
		$stmt->bindParam(":trcode", $pin);
		$applstatus = "DROPPING";
		$stmt->bindParam(":appl_status", $applstatus);
		$stmt->execute();

		// AUDIT TRAIL
		$mac = "UNKNOWN";
		foreach (explode("\n", str_replace(' ', '', trim(`getmac`, "\n"))) as $i)
			if (strpos($i, 'Tcpip') > -1) {
				$mac = substr($i, 0, 17);
				break;
			}

		$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Drop Franchise', NOW(), date(NOW()), :transdetails, :pcname)");
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':realname', $_SESSION['fullname']);
		$stmt->bindParam(':pcname', $mac);
		$det = $opercode . ' / ' . $drivercode . ' - ' . $motorcode;
		$stmt->bindParam(':transdetails', $det);
		$stmt->execute();

		// // AUTO ASSESS
		// $stmt = $this->connect()->prepare("SELECT * FROM tbl_assoffees WHERE trans = 'DROPPING' AND collnature <> 0");
		// $stmt->execute();
		// $data = $stmt->fetchAll();

		// $stmt = $this->connect()->prepare("DELETE FROM tbl_otherassess WHERE trcode = ?");
		// $stmt->bindValue(1, $pin);
		// $stmt->execute();

		// $i = 1;
		// foreach ($data as $key => $value) {
		// 	$stmt = $this->connect()->prepare("INSERT INTO tbl_otherassess(motorcode, yr, feesid, Fees, AmtDue, collnature, status, isdrop, trcode) VALUES(:motorcode, YEAR(NOW()), :feesid, :Fees, :AmtDue, :collnature, 'UNPAID', '1', :trcode)");
		// 	$stmt->bindParam(":motorcode", $motorcode);
		// 	$stmt->bindParam(":feesid", $i);
		// 	$stmt->bindParam(":Fees", $value['Fees']);
		// 	$stmt->bindParam(":AmtDue", $value['AmtDue']);
		// 	$stmt->bindParam(":collnature", $value['collnature']);
		// 	$stmt->bindParam(":trcode", $pin);
		// 	$stmt->execute();
		// 	$i++;
		// }

		return json_encode(array("result" => true, "msg" => "Motor has been dropped successfully.", "trcode" => $pin));
	}

	public function getdetDropAssRelease($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop AS a JOIN tbl_otherassess AS b ON a.trcode = b.trcode WHERE b.trcode = ? ORDER BY assid ASC");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
	}

	public function getdetDropAssFee($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT CONCAT(own_ln, ' ',own_fn) as applicant, CONCAT(hse_no, ' ', lot_no, ' ', blk_no, ' ', st, ' ', subdivision, ' ', brgy, ' ', Mun, ', ', prov) AS addr, mo1, mo2, mo7, mo6, mo5, Fees, AmtDue, reason FROM tbl_drop AS a JOIN tbl_motor AS b ON a.motorcode = b.motorid JOIN tbl_opdriver AS c ON a.file_id = c.file_id JOIN tbl_otherassess AS d ON a.trcode = d.trcode WHERE a.trcode = ? AND iscancel = 0");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function saveDropRelease($trcode)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_otherassess WHERE trcode = ? AND status = 'UNPAID'");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "Payment is required to release."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop AS a JOIN tbl_motor AS b ON a.motorcode = b.motorpin WHERE trcode = ? AND iscancel = 0");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		// UPDATE MOTOR TO UNAVAILABLE
		$stmt = $this->connect()->prepare("UPDATE tbl_motor SET isdrop = '1', status = 'UNAVAILABLE', remarks = CONCAT('Dropped Franchise, ', DATE(NOW()), ' Reason: ', ?) WHERE motorpin = ?");
		$stmt->bindValue(1, $data['reason']);
		$stmt->bindValue(2, $data['motorcode']);
		$stmt->execute();

		$stmt = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'RELEASED', tagscode = 6 WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$det = "Release Dropping Application for " . $trcode . " (" . $data['make'] . "/" . $data['engine'] . "/" . $data['chassis'] . "/" . $data['plateno'] . ")";
		$this->saveAudit("Dropping Release", $det);

		return json_encode(array("result" => true, "msg" => "Dropping Application Released!!"));
	}

	public function getAllApplication()
	{
		$stmt = $this->connect()->prepare("SELECT a.trcode, CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, CONCAT(c.own_fn, ' ', c.own_ln) AS operator, mo1, mo6, appl_status, Tags FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.opercode = b.file_id JOIN tbl_opdriver AS c ON a.drivercode = c.file_id JOIN tbl_motor AS d ON a.motorcode = d.motorid WHERE iscancel = 0 AND Tags <> 'RELEASED' UNION SELECT a.trcode, CONCAT(b.own_fn, ' ', b.own_ln) AS applicant, CONCAT(c.own_fn, ' ', c.own_ln) AS operator, mo1, mo6, 'DROPPING' as appl_status, trans_status FROM tbl_drop AS a JOIN tbl_motor AS d ON a.motorcode = d.motorid JOIN tbl_opdriver AS b ON d.opercode = b.file_id JOIN tbl_opdriver AS c ON d.drivercode = c.file_id WHERE trans_status <> 'RELEASED' AND iscancel = 0");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function getCountAppTodas($yr)
	{
		$stmt = $this->connect()->prepare("SELECT *, (nn+rn) AS tot FROM (SELECT mo1, SUM(IF((appl_status = 'NEW' OR appl_status = 'NEW/CM'), 1, 0)) AS nn,SUM(IF((appl_status = 'RENEW' OR appl_status = 'RENEW/CM'), 1, 0)) AS rn FROM tbl_application AS a JOIN tbl_motor AS b ON a.motorcode = b.motorid WHERE yr = ? AND iscancel = 0 GROUP BY mo1) as z");
		$stmt->bindValue(1, $yr);
		$stmt->execute();
		return json_encode($stmt->fetchAll());
	}

	public function SaveORnoRelease($trcode, $orno, $ordate)
	{
		$stmt = $this->connect()->prepare("UPDATE tbl_application SET f4 = ?, Tags = 'FOR RELEASING', tagscode = 4 WHERE trcode = ? AND iscancel = 0");
		$stmt->bindValue(1, $orno);
		$stmt->bindValue(2, $trcode);
		$stmt->execute();

		$stmt = $this->connect()->prepare("UPDATE tbl_assessment SET or_number = ?, or_date = ?, status = 'PAID' WHERE trcode = ?");
		$stmt->bindValue(1, $orno);
		$stmt->bindValue(2, $ordate);
		$stmt->bindValue(3, $trcode);
		$stmt->execute();

		$stmt = $this->connect()->prepare("UPDATE tbl_payment SET or_number = ?, or_date = ? WHERE trcode = ?");
		$stmt->bindValue(1, $orno);
		$stmt->bindValue(2, $ordate);
		$stmt->bindValue(3, $trcode);
		$stmt->execute();

		$mac = "UNKNOWN";
		foreach (explode("\n", str_replace(' ', '', trim(`getmac`, "\n"))) as $i)
			if (strpos($i, 'Tcpip') > -1) {
				$mac = substr($i, 0, 17);
				break;
			}

		$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Save ORNO', NOW(), date(NOW()), :transdetails, :pcname)");
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':realname', $_SESSION['fullname']);
		$stmt->bindParam(':pcname', $mac);
		$det = "Set Orno to " . $orno . " dated " . $ordate . " to " . $trcode;
		$stmt->bindParam(':transdetails', $det);
		$stmt->execute();

		return json_encode(array("result" => true, "msg" => "Official Receipt No. has been recorded!!"));
	}

	public function SaveDropORnoRelease($trcode, $orno, $ordate)
	{
		$stmt = $this->connect()->prepare("UPDATE tbl_drop SET trans_status = 'FOR RELEASING', tagscode = 4 WHERE trcode = ? AND iscancel = 0");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$stmt = $this->connect()->prepare("UPDATE tbl_otherassess SET or_number = ?, or_date = ?, status = 'PAID' WHERE trcode = ?");
		$stmt->bindValue(1, $orno);
		$stmt->bindValue(2, $ordate);
		$stmt->bindValue(3, $trcode);
		$stmt->execute();

		$stmt = $this->connect()->prepare("UPDATE tbl_payment SET or_number = ?, or_date = ? WHERE trcode = ?");
		$stmt->bindValue(1, $orno);
		$stmt->bindValue(2, $ordate);
		$stmt->bindValue(3, $trcode);
		$stmt->execute();

		$mac = "UNKNOWN";
		foreach (explode("\n", str_replace(' ', '', trim(`getmac`, "\n"))) as $i)
			if (strpos($i, 'Tcpip') > -1) {
				$mac = substr($i, 0, 17);
				break;
			}

		$stmt = $this->connect()->prepare("INSERT INTO audit_trail (username, realname, transaction, datetransact, dttransact, transdetails, pcname) VALUES(:username, :realname, 'Save ORNO', NOW(), date(NOW()), :transdetails, :pcname)");
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':realname', $_SESSION['fullname']);
		$stmt->bindParam(':pcname', $mac);
		$det = "Set Orno to " . $orno . " dated " . $ordate . " to " . $trcode;
		$stmt->bindParam(':transdetails', $det);
		$stmt->execute();

		return json_encode(array("result" => true, "msg" => "Official Receipt No. has been recorded!!"));
	}

    
	public function DeleteOperator($opcode, $reason, $auth)
	{
		// if (!$this->checkAdminAuth($auth)) {
		// 	return json_encode(array("result" => false, "msg" => "Authorization Failed. Please try again."));
		// }

		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
                    $stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE ((previous_operator = :code OR operator = :code) OR (previous_driver = :code OR driver = :code)) AND iscancel = 0");
                    $stmt->bindParam(":code", $opcode);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        return json_encode(array("result" => false, "msg" => "Operator/Driver is used to some record deleting it might corrupt some application."));
                    }
            
                    $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
                    $stmt->bindValue(1, $opcode);
                    $stmt->execute();
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
                    $stmt = $this->connect()->prepare("UPDATE tbl_humans SET humantype = 1 WHERE humanpin = ?");
                    $stmt->bindParam(1, $opcode);
            
                    if ($stmt->execute()) {
                        $this->saveAudit("Delete Human", $opcode . " has been deleted from the records.");
                        $stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
                        $stmt->bindValue(1, $opcode);
                        $stmt->execute();
                        $datas = $stmt->fetch(PDO::FETCH_ASSOC);
                        $this->saveLogs("DELETE HUMAN", json_encode(array($datas)), json_encode(array($data)), json_encode(array("humanpin" => $opcode, "reason" => $reason)), $_SESSION['username'], "HUMAN");
                        return json_encode(array("result" => true, "msg" => "Operator/Driver has been deleted successfully!!"));

                    }
				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator", "error" => $e));
		}

	}

	// public function DeleteOperator($opcode, $reason, $auth)
	// {
	// 	if (!$this->checkAdminAuth($auth)) {
	// 		return json_encode(array("result" => false, "msg" => "Authorization Failed. Please try again."));
	// 	}

	// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE ((previous_operator = :code OR operator = :code) OR (previous_driver = :code OR driver = :code)) AND iscancel = 0");
	// 	$stmt->bindParam(":code", $opcode);
	// 	$stmt->execute();
	// 	if ($stmt->rowCount() > 0) {
	// 		return json_encode(array("result" => false, "msg" => "Operator/Driver is used to some record deleting it might corrupt some application."));
	// 	}

	// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
	// 	$stmt->bindValue(1, $opcode);
	// 	$stmt->execute();
	// 	$data = $stmt->fetch(PDO::FETCH_ASSOC);

	// 	$stmt = $this->connect()->prepare("UPDATE tbl_humans SET humantype = 1 WHERE humanpin = ?");
	// 	$stmt->bindParam(1, $opcode);

	// 	if ($stmt->execute()) {
	// 		$this->saveAudit("Delete Human", $opcode . " has been deleted from the records.");
	// 		$stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
	// 		$stmt->bindValue(1, $opcode);
	// 		$stmt->execute();
	// 		$data = $stmt->fetch(PDO::FETCH_ASSOC);
	// 		$this->saveLogs("DELETE HUMAN", json_encode(array($pdate)), json_encode(array($data)), json_encode(array("humanpin" => $pin, "reason" => $reason)), $_SESSION['username'], "HUMAN");
	// 		return json_encode(array("result" => true, "msg" => "Operator/Driver has been deleted successfully!!"));
	// 	}
	// }

	public function DeleteDriver($opcode, $reason, $auth)
	{
		if (!$this->checkAdminAuth($auth)) {
			return json_encode(array("result" => false, "msg" => "Authorization Failed. Please try again."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE ((previous_operator = :code OR operator = :code) OR (previous_driver = :code OR driver = :code)) AND iscancel = 0");
		$stmt->bindParam(":code", $opcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "Operator/Driver is used to some record deleting it might corrupt some application."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $opcode);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("UPDATE tbl_humans SET humantype = 1 WHERE humanpin = ?");
		$stmt->bindParam(1, $opcode);

		if ($stmt->execute()) {
			$this->saveAudit("Delete Human", $opcode . " has been deleted from the records.");
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_humans WHERE humanpin = ?");
			$stmt->bindValue(1, $opcode);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("DELETE HUMAN", json_encode(array($pdate)), json_encode(array($data)), json_encode(array("humanpin" => $pin, "reason" => $reason)), $_SESSION['username'], "HUMAN");
			return json_encode(array("result" => true, "msg" => "Operator/Driver has been deleted successfully!!"));
		}
	}


    public function DeleteMotor($opcode, $reason, $auth)
	{
		// if (!$this->checkAdminAuth($auth)) {
		// 	return json_encode(array("result" => false, "msg" => "Authorization Failed. Please try again."));
		// }

		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					//query
                    
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE ((previous_operator = :code OR operator = :code) OR (previous_driver = :code OR driver = :code)) AND iscancel = 0");
		$stmt->bindParam(":code", $opcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "Operator/Driver is used to some record deleting it might corrupt some application."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $opcode);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("UPDATE tbl_motor SET isdeleted = 1 WHERE motorpin = ?");
		$stmt->bindParam(1, $opcode);

		if ($stmt->execute()) {
			$this->saveAudit("Delete Human", $opcode . " has been deleted from the records.");
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
			$stmt->bindValue(1, $opcode);
			$stmt->execute();
			$datas = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("DELETE MOTOR", json_encode(array($datas)), json_encode(array($data)), json_encode(array("humanpin" => $opcode, "reason" => $reason)), $_SESSION['username'], "MOTOR");
			return json_encode(array("result" => true, "msg" => "Motor has been deleted successfully!!"));
			
		}


				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator", "error" => $e));
		}
	}

	

	public function saveMotor($opcode, $body, $toda, $make, $engine, $chassis, $yrmodel, $color, $cert, $dtissue, $plate, $agency, $remarks, $platecolor, $mvno, $orcrswitch, $orcrname, $orcr, $orcrdate, $munplate)
	{
	    if ($body != "") {
	        $stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE toda = ? AND CONVERT(bodyno,UNSIGNED INTEGER) = ? AND status = 'AVAILABLE'");
    		$stmt->bindValue(1, $toda);
    		$stmt->bindValue(2, $body);
    		$stmt->execute();
    		if ($stmt->rowCount() > 0) {
    			return json_encode(array("result" => false, "msg" => "Motor cannot be duplicated. There is an existing motor with the same TODA and body#."));
    		}
	    }
		
// 		$stmt = $this->connect()->prepare("SELECT status, isdrop, mvno, chassis, engine, crno, plateno FROM tbl_motor WHERE status = 'AVAILABLE' AND isdrop = 0 AND (mvno = :mvno OR chassis = :chassis OR engine = :engine OR crno = :crno)");
// 		$stmt->bindParam(":mvno", $mvno);
// 		$stmt->bindParam(":chassis", $chassis);
// 		$stmt->bindParam(":engine", $engine);
// 		$stmt->bindParam(":crno", $cert);
//         $stmt->execute();
//         if ($stmt->rowCount() > 0) {
//             return json_encode(array("result" => false, "msg" => "Motor cannot be duplicated. There is an existing motor with the same MVNO/CHASSIS/ENGINE/CRNO.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
//         }

		$stmt = $this->connect()->query("SELECT LPAD(IF(count(*) = 0, '00000', left(right(max(motorpin), 5), 5)) + 1, 5, 0) as autopin FROM tbl_motor");
		$stmt->execute();
		$pin = $stmt->fetch();
		$pin = "MT-" . date("Y") . "-" . $pin['autopin'];

  	$stmt = $this->connect()->prepare("INSERT INTO tbl_motor (opercode, drivercode, toda, make, engine, chassis, yearmodel, color, crno, crdate, plateno, ltobranch, remarks, platecolor, mvno, motorpin, crname, crswitch, orcr, orcrdate, munplateno) VALUES (:opercode, :drivercode, :toda, :make, :engine, :chassis, :yearmodel, :color, :crno, :crdate, :plateno, :ltobranch, :remarks, :platecolor, :mvno, :motorpin, :crname, :crswitch, :orcr, :orcrdate, :munplate)");
    $dtissue = ($dtissue == "" ? '1990-01-01' : $dtissue);
    $orcrdate = ($orcrdate == "" ? '1990-01-01' : $orcrdate);
    	// $dtis = explode("-", $dtissue);
	    // $dtissue = $dtis[1]."-".$dtis[0]."-01";
		$stmt->bindParam(":opercode", $opcode);
		$stmt->bindParam(":drivercode", $opcode);
		$stmt->bindParam(":toda", $toda);
		$stmt->bindParam(":make", $make);
		$stmt->bindParam(":engine", $engine);
		$stmt->bindParam(":chassis", $chassis);
		$stmt->bindParam(":yearmodel", $yrmodel);
		$stmt->bindParam(":color", $color);
		$stmt->bindParam(":crno", $cert);
		$stmt->bindParam(":crdate", $dtissue);
		$stmt->bindParam(":plateno", $plate);
		$stmt->bindParam(":ltobranch", $agency);
		$stmt->bindParam(":remarks", $remarks);
		$stmt->bindParam(":platecolor", $platecolor);
		$stmt->bindParam(":mvno", $mvno);
		$stmt->bindParam(":motorpin", $pin);
		$stmt->bindParam(":crname", $orcrname);
		$stmt->bindParam(":crswitch", $orcrswitch);
		$stmt->bindParam(":orcr", $orcr);
		$stmt->bindParam(":orcrdate", $orcrdate);
		$stmt->bindParam(":munplate", $munplate);
		
		if ($stmt->execute()) {
			$this->saveAudit("Add Motor", $pin . " (" . $toda . "-" . $body . ") has been added to the records.");
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
			$stmt->bindValue(1, $pin);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("INSERT MOTOR", json_encode(array()), json_encode(array($data)), json_encode(array("motorpin" => $pin)), $_SESSION['username'], "MOTOR");
			return json_encode(array("result" => true, "msg" => "Motor Information has been added successfully!!", "motorpin" => $pin));
		} else {
		    return json_encode(array("result" => false, "msg" => "Error has occured. Please call administrator"));
		}

	}

	public function updateMotor($mid, $opcode, $body, $toda, $make, $engine, $chassis, $yrmodel, $color, $cert, $dtissue, $plate, $agency, $remarks, $platecolor, $mvno, $orcrswitch, $orcrname, $orcr, $orcrdate, $munplate, $franchiseno, $dtexprd)
	{
		if ($body != "") {
	      $stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE toda = ? AND CONVERT(bodyno,UNSIGNED INTEGER) = ? AND status = 'AVAILABLE'");
    		$stmt->bindValue(1, $toda);
    		$stmt->bindValue(2, $body);
    		$stmt->execute();
    		if ($stmt->rowCount() > 0) {
    			return json_encode(array("result" => false, "msg" => "Motor cannot be duplicated. There is an existing motor with the same TODA and body#."));
    		}
	    }
		
		$stmt = $this->connect()->prepare("SELECT * FROM (SELECT status, isdrop, mvno, chassis, engine, crno, plateno, motorpin FROM tbl_motor WHERE status = 'AVAILABLE' AND isdrop = 0 AND (mvno = :mvno OR chassis = :chassis OR engine = :engine OR crno = :crno OR plateno = :plateno)) AS a WHERE motorpin <> :mid");
		$stmt->bindParam(":mid", $mid);
		$stmt->bindParam(":mvno", $mvno);
		$stmt->bindParam(":chassis", $chassis);
		$stmt->bindParam(":engine", $engine);
		$stmt->bindParam(":crno", $cert);
		$stmt->bindParam(":plateno", $plateno);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return json_encode(array("result" => false, "msg" => "Motor cannot be duplicated. There is an existing motor with the same MVNO/CHASSIS/ENGINE/CRNO.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    }

    $stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
		$stmt->bindValue(1, $mid);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);


		//carlo
			//$stmt = $this->connect()->prepare("UPDATE tbl_application SET  franchise_no = :franchiseno WHERE trcode = :trcode");
				//	$stmt->bindValue(1, $franchiseno);
					//$stmt->bindValue(2, date("Y-m-d h:i:s"));
					//$stmt->bindValue(2, $trcode);
				//	$stmt->execute();
				
		//carlo
	
		

		$stmt = $this->connect()->prepare("UPDATE tbl_motor SET opercode = :opercode, toda = :toda, make = :make, engine = :engine, chassis = :chassis, yearmodel = :yearmodel, color = :color, crno = :crno, crdate = :crdate, plateno = :plateno, ltobranch = :ltobranch, remarks = :remarks, platecolor = :platecolor, mvno = :mvno, crname = :crname, crswitch = :crswitch, orcr = :orcr, orcrdate = :orcrdate, munplateno = :munplateno, franchiseno = :franchiseno, dtexprd = :dtexprd WHERE motorpin = :motorpin");

		$dtissue = ($dtissue == "" ? '1990-01-01' : $dtissue);
		$orcrdate = ($orcrdate == "" ? '1990-01-01' : $orcrdate);
		// $dtis = explode("-", $dtissue);
	 //  $dtissue = $dtis[1]."-".$dtis[0]."-01";
		$stmt->bindParam(":opercode", $opcode);
		// $stmt->bindValue(2, $body);
		$stmt->bindParam(":toda", $toda);
		$stmt->bindParam(":make", $make);
		$stmt->bindParam(":engine", $engine);
		$stmt->bindParam(":chassis", $chassis);
		$stmt->bindParam(":yearmodel", $yrmodel);
		$stmt->bindParam(":color", $color);
		// $stmt->bindValue(9, $mtpyr);
		$stmt->bindParam(":crno", $cert);
		$stmt->bindParam(":crdate", $dtissue);
		$stmt->bindParam(":plateno", $plate);
		$stmt->bindParam(":ltobranch", $agency);
		$stmt->bindParam(":remarks", $remarks);
		$stmt->bindParam(":motorpin", $mid);
		$stmt->bindParam(":platecolor", $platecolor);
		$stmt->bindParam(":mvno", $mvno);
		$stmt->bindParam(":crswitch", $orcrswitch);
		$stmt->bindParam(":crname", $orcrname);
		$stmt->bindParam(":orcr", $orcr);
		$stmt->bindParam(":orcrdate", $orcrdate);
		$stmt->bindParam(":munplateno", $munplate);
		$stmt->bindParam(":franchiseno", $franchiseno);
		$stmt->bindParam(":dtexprd", $dtexprd);

		if ($stmt->execute()) {
			$this->saveAudit("Update Motor", $mid . " (" . $toda . "-" . $body . ") has been updated.");
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_motor WHERE motorpin = ?");
			$stmt->bindValue(1, $mid);
			$stmt->execute();
			$ndata = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("UPDATE MOTOR", json_encode(array($data)), json_encode(array($ndata)), json_encode(array("motorpin" => $mid)), $_SESSION['username'], "MOTOR");
			return json_encode(array("result" => true, "msg" => "Motor has been updated successfully!!"));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getTodaOption()
	{
		$stmt = $this->connect()->query("SELECT ID, todacode, todaRoute, todadesc,  todaRemarks, franchiseAllowed, rangelow, rangehigh, contactno, IFNULL(ctoda, 0) AS ctoda, todaPres FROM tbl_toda AS a LEFT JOIN (SELECT toda, count(toda) AS ctoda FROM tbl_motorlinking WHERE iscancel = 0 AND dtexprd > NOW() GROUP BY toda) AS z ON a.todacode = z.toda");
		// $stmt = $this->connect()->query("SELECT  todacode FROM tbl_toda");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "msg" => "success."));
		} else {
			return json_encode(array("result" => false, "data" => "", "msg" => "Ops! something went wrong. Please contact the administrator/programmer."));
		}
	}


	public function getAllToda()
	{
		$stmt = $this->connect()->query("SELECT ID, todacode, todaRoute, todadesc, todaRemarks, franchiseAllowed, rangelow, rangehigh, contactno, IFNULL(ctoda, 0) AS ctoda, todaPres FROM tbl_toda AS a LEFT JOIN (SELECT toda, count(toda) AS ctoda FROM tbl_motorlinking WHERE iscancel = 0 AND dtexprd > NOW() GROUP BY toda) AS z ON a.todacode = z.toda");
		// $stmt = $this->connect()->query("SELECT  todacode FROM tbl_toda");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "msg" => "success."));
		} else {
			return json_encode(array("result" => false, "data" => "", "msg" => "Ops! something went wrong. Please contact the administrator/programmer."));
		}
	}


	public function getAllTodaDetails()
	{
		$stmt = $this->connect()->query("SELECT ID, todacode, todaRoute, todadesc, todaRemarks, franchiseAllowed, rangelow, rangehigh, contactno, IFNULL(ctoda, 0) AS ctoda, todaPres FROM tbl_toda AS a LEFT JOIN (SELECT toda, count(toda) AS ctoda FROM tbl_motorlinking WHERE iscancel = 0 AND dtexprd > NOW() GROUP BY toda) AS z ON a.todacode = z.toda");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "msg" => "success."));
		} else {
			return json_encode(array("result" => false, "data" => "", "msg" => "Ops! something went wrong. Please contact the administrator/programmer."));
		}
	}

	public function getAllStatusDetails()
	{
		$stmt = $this->connect()->query("SELECT trcode, opercode,drivercode, motorcode, franchise_no, appl_status, Tags,tagscode, dttm FROM tbl_application  ");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "msg" => "success."));
		} else {
			return json_encode(array("result" => false, "data" => "", "msg" => "Ops! something went wrong. Please contact the administrator/programmer."));
		}
	}

	public function getdetToda($tcode)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_toda WHERE todacode = ?");
		$stmt->bindValue(1, $tcode);
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "data" => $stmt->fetch(PDO::FETCH_ASSOC), "msg" => "success."));
		} else {
			return json_encode(array("result" => false, "data" => "", "msg" => "Ops! something went wrong. Please contact the administrator/programmer."));
		}
	}

	public function saveToda($code, $route, $remarks, $toda, $pres, $contactno)
	{
		include_once "connection.php";

		try {
			$dbh = new PDO('mysql:host=localhost;dbname='.$this->dbname, $this->uza, $this->pazz);

			$stmt = $dbh->prepare("INSERT INTO tbl_toda (todacode, todaRoute, todaRemarks, todaPres, contactno) VALUES (?,?,?,?,?)");

			try {
				$dbh->beginTransaction();
				$stmt->execute(array($code, $route, $remarks,$pres,$contactno));
				$lid = $dbh->lastInsertId();
				$dbh->commit();
				$this->saveAudit("Add TODA", $lid . " (" . $code . ") has been added to the records.");
				return json_encode(array("result" => true, "msg" => "TODA has been added successfully!!", "todaid" => $lid));
			} catch (PDOException $e) {
				$dbh->rollback();
				return json_encode(array("result" => false, "msg" => $e->getMessage()));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}


	public function updateToda($id, $code, $route, $remarks, $pres, $contactno, $test)
	{
		$stmt = $this->connect()->prepare("UPDATE tbl_toda SET todacode = ?, todaRoute = ?, todaRemarks = ?, todaPres = ?, contactno = ?, testcol = ?  WHERE ID = ?");
		$stmt->bindValue(1, $code);
		$stmt->bindValue(2, $route);
		$stmt->bindValue(3, $remarks);
		$stmt->bindValue(4, $pres);
		$stmt->bindValue(5, $contactno);
		$stmt->bindValue(6, $test);
		$stmt->bindValue(7, $id);

		if ($stmt->execute()) {
			$this->saveAudit("Update TODA", $id . " (" . $code . ") has been updated.");
			return json_encode(array("result" => true, "msg" => "TODA has been updated successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}


	public function deleteToda($id)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_toda AS a JOIN tbl_motor AS b ON a.todacode = b.mo1 WHERE a.ID = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "This TODA cannot be deleted if someone is enlisted into it."));
		}

		$stmt = $this->connect()->prepare("DELETE FROM tbl_toda WHERE ID = ?");
		$stmt->bindValue(1, $id);

		if ($stmt->execute()) {
			$this->saveAudit("Delete TODA", $id . " has been added to the records.");
			return json_encode(array("result" => true, "msg" => "TODA has been deleted successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getMasterListFranchise($toda, $from, $to, $yr)
	{
    	$stmt = $this->connect()->prepare("SELECT IF(make <> 'E-TRIKE', LPAD(bodyno, 4,'0'), bodyno) AS bodyno,trcode, last_name, middle_name, first_name, addr,mvno, make, chassis, engine, plateno, franchise_date,IF(make <> 'E-TRIKE', LPAD(fno, 4,'0'), fno) AS fno, last_renew, toda, appl_status FROM (SELECT bodyno, ifnull(last_name,'N/A') as last_name, ifnull(first_name,'N/A') as first_name, ifnull(middle_name,'N/A') as middle_name, ifnull(CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province),'N/A') as addr,mvno, make,chassis,engine,plateno, a.franchise_date,a.franchise_no as fno,a.yr as last_renew,toda,appl_status, trcode FROM tbl_application AS a LEFT JOIN tbl_motor AS b ON a.motorcode = b.motorpin LEFT JOIN tbl_humans AS c ON a.opercode = c.humanpin WHERE toda LIKE ? AND (franchise_date BETWEEN ? AND ?) AND yr = ? AND a.franchise_no <> '' AND appl_status <> 'TDP' AND iscancel = 0 ORDER BY bodyno asc) as z GROUP BY trcode ORDER BY bodyno asc ");
		$stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $from);
		$stmt->bindValue(3, $to);
		$stmt->bindValue(4, $yr);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Report loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}
	
    public function getChangeMotorReport($toda, $from, $to, $yr) {
        $stmt = $this->connect()->prepare("SELECT CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opfname, CONCAT(c.first_name,' ', LEFT(c.middle_name, 1), '. ', c.last_name, ' ', c.ext_name) AS opnewfname, ifnull(CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province),'N/A') as addr, franchiseno, dateapplication, Tags, toda, motorpin FROM tbl_changemotor AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_humans AS c ON a.newopercode = c.humanpin LEFT JOIN tbl_motor AS d ON a.newmotorcode = d.motorpin WHERE toda LIKE ? AND (dateapplication BETWEEN ? AND ?) AND yr = ? AND iscancel = 0");
        $stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $from);
		$stmt->bindValue(3, $to);
		$stmt->bindValue(4, $yr);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Report loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
    }
    
    public function getChangeOwnershipReport($toda, $from, $to, $yr) {
        $stmt = $this->connect()->prepare("SELECT CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opfname, CONCAT(c.first_name,' ', LEFT(c.middle_name, 1), '. ', c.last_name, ' ', c.ext_name) AS opnewfname, ifnull(CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province),'N/A') as addr, franchiseno, dateapplication, Tags, toda, motorpin FROM tbl_changemotor AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_humans AS c ON a.newopercode = c.humanpin LEFT JOIN tbl_motor AS d ON a.motorcode = d.motorpin WHERE toda LIKE ? AND (dateapplication BETWEEN ? AND ?) AND yr = ? AND iscancel = 0");
        $stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $from);
		$stmt->bindValue(3, $to);
		$stmt->bindValue(4, $yr);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Report loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
    }

	public function getMasterListTDP($toda, $from, $to, $yr)
	{
		$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(mo1, ' - #', IF(LENGTH(f1)<3,LPAD(CONVERT(f1,INTEGER),3,'000'), f1)) as todabody, own_ln, own_fn, addr, drivlis, lisexp, dtreg, tdpexp FROM ( SELECT a.trcode, mo1, CONVERT(f1, INTEGER)as f1, ifnull(own_ln,'N/A') as own_ln, ifnull(own_fn,'N/A') as own_fn, ifnull(own_mi,'N/A') as own_mi, ifnull(concat(hse_no, ' ',blk_no, ' ', lot_no, ' ', st, ' ', subdivision, ' ', brgy),'N/A') as addr, ifnull(drivlis, 'N/A') as drivlis, ifnull(lisexp, 'N/A') as lisexp, dtreg, tdpexp FROM tbl_application AS a LEFT JOIN tbl_motor AS b ON a.motorcode = b.motorid LEFT JOIN tbl_opdriver AS c ON a.drivercode = c.file_id JOIN tbl_tdp AS d ON a.trcode = d.trcode WHERE mo1 = ? AND a.dtreg BETWEEN ? AND ? AND a.yr = ? AND a.franchise_no <> '' AND appl_status = 'TDP' AND a.iscancel = 0 AND mo9 = 'AVAILABLE' ORDER BY f1 asc) as z ORDER BY f1 asc");
		$stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $from);
		$stmt->bindValue(3, $to);
		$stmt->bindValue(4, $yr);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Masterlist loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getMasterListDrop($toda, $from, $to)
	{
		$stmt = $this->connect()->prepare("SELECT LPAD(franchiseno, 4,'0') AS bodyno, own_ln, own_mi, own_fn, addr, mo2, mo7, mo5, mo6, mo1, reason, date_create FROM (SELECT franchiseno, ifnull(last_name,'N/A') as own_ln, ifnull(first_name,'N/A') as own_fn, ifnull(middle_name,'N/A') as own_mi, ifnull(CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province),'N/A') as addr, make AS mo2, chassis AS mo7, engine AS mo5, plateno AS mo6, toda AS mo1, reason, date_create FROM tbl_drop AS a LEFT JOIN tbl_motor AS b ON a.motorcode = b.motorpin LEFT JOIN tbl_humans AS c ON a.opercode = c.humanpin WHERE toda LIKE ? AND date_create BETWEEN ? AND ? AND tags = 'RELEASED' AND iscancel = 0 ORDER BY franchiseno asc) as z ORDER BY franchiseno asc");
		$stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $from);
		$stmt->bindValue(3, $to);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Masterlist loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}


	public function getExpiringTDP()
	{
		$stmt = $this->connect()->query("SELECT a.trcode, a.drivercode, CONCAT(own_fn, ' ', own_mi, ' ', own_ln) AS nname, CONCAT(mo1, '-', f1) AS todabody, b.tdpno, tdpapp, tdpexp, dttm FROM (SELECT MAX(trcode) as trcode, drivercode, motorcode, MAX(dttm) as dttm FROM tbl_application WHERE appl_status = 'TDP' AND iscancel = 0 GROUP BY drivercode) AS a JOIN tbl_tdp AS b ON a.trcode = b.trcode JOIN tbl_motor AS c ON a.motorcode = c.motorid LEFT JOIN tbl_opdriver AS d ON a.drivercode = d.file_id WHERE tdpexp <= DATE(NOW()) ORDER BY dttm desc");

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Masterlist loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getExpiredFranchise($toda, $yr)
	{
		$stmt = $this->connect()->prepare("SELECT franid, last_name, middle_name, first_name, ifnull(CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province),'N/A') as addr, CONCAT(toda, ' - ', LPAD(bodyno, 4,'0')) AS tbody, LPAD(a.franchiseno, 4,'0') AS franchise_no,c.dtexprd, a.last_renew FROM tbl_franlist AS c  LEFT JOIN tbl_motor AS a ON c.motorid = a.motorpin LEFT JOIN tbl_humans AS b ON c.opercode = b.humanpin WHERE todacode LIKE ? AND c.dtexprd <= DATE(NOW()) AND c.status = 'NOT AVAILABLE'");
		$stmt->bindValue(1, "%".$toda."%");

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Masterlist loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}
	
	public function getExpiringFranchise($toda, $from, $to)
	{
	    $month = date('m', strtotime($from));
	    $year = date('Y', strtotime($from));
		$stmt = $this->connect()->prepare("SELECT franid, last_name, middle_name, first_name, ifnull(CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province),'N/A') as addr, toda, LPAD(a.franchiseno, 4,'0') AS franchise_no,c.dtexprd, a.last_renew FROM tbl_franlist AS c  LEFT JOIN tbl_motor AS a ON c.motorid = a.motorpin LEFT JOIN tbl_humans AS b ON c.opercode = b.humanpin WHERE todacode LIKE ? AND (MONTH(c.dtexprd) = ? AND YEAR(c.dtexprd) = ?)");
		$stmt->bindValue(1, "%".$toda."%");
		$stmt->bindValue(2, $month);
		$stmt->bindValue(3, $year);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Masterlist loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}


	public function getSignatories()
	{
		$stmt = $this->connect()->query("SELECT * FROM tbl_signatories");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Signatories loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getFees($category)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assoffees WHERE trans = ?");
		$stmt->bindValue(1, $category);
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Fees loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getFeesOption()
	{
		$stmt = $this->conn()->query("SELECT * FROM collmast WHERE groupcol = 1041");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Fees Option loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}
	
	public function saveSignatories( $name, $position)
	{
		$stmt = $this->connect()->prepare("INSERT INTO tbl_signatories (nm, position) VALUES (?, ?)");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $position);
		if ($stmt->execute()) {
			$this->saveAudit("Add Signatories", $id . " - " . $name . " has been added to the records.");
			return json_encode(array("result" => true, "msg" => "Signatories has been updated successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function updateSignatories($id, $name, $position)
	{
		$stmt = $this->connect()->prepare("UPDATE tbl_signatories SET nm = ?, position = ? WHERE ID = ?");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $position);
		$stmt->bindValue(3, $id);
		if ($stmt->execute()) {
			$this->saveAudit("Update Signatories", $id . " - " . $name . " has been updated to the records.");
			return json_encode(array("result" => true, "msg" => "Signatories has been updated successfully."));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getdetSignatories($id)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_signatories WHERE ID = ?");
		$stmt->bindValue(1, $id);
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Signatories lodaded successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}


	public function getReportCollection($from, $to)
	{
		$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS opname, toda, or_number, or_date, sum(dueamt) AS totamt FROM tbl_payment AS a JOIN tbl_humans AS b ON a.opcode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE or_date BETWEEN :datefrom AND :dateto GROUP BY trcode");
		$stmt->bindParam(":datefrom", $from);
		$stmt->bindParam(":dateto", $to);

		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Collection lodaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getRecentApplication()
	{
		$stmt = $this->connect()->query("SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, Tags, appl_status, dttm FROM tbl_application AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin UNION SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, Tags, appl_status, dttm FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin UNION SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, Tags, appl_status, dttm FROM tbl_changeownership AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin ORDER BY dttm DESC");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getAllUsers()
	{
		$stmt = $this->connect()->query("SELECT * FROM users");
		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getOperatorHistory($code)
	{
		$stmt = $this->connect()->prepare("SELECT humanpin,  CONCAT(first_name,' ', LEFT(middle_name, 1), '. ', last_name, ' ', ext_name) as fullname, CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_brgy, ' ', address_municipality, ', ', address_province, ', ', address_region) as addr, mobile_no, sex, target_path FROM tbl_humans WHERE humanpin = ?");
		$stmt->bindValue(1, $code);
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			return json_encode(array("result" => false, "msg" => "We are having trouble finding this operator's history."));
		}

		// 		$drivers = $this->connect()->prepare("SELECT a.trcode, CONCAT(b.own_fn, ' ', b.own_ln) as fname, motorid, a.yr, d.tdpno, d.tdpapp, d.tdpexp FROM tbl_application AS a JOIN tbl_opdriver AS b ON a.drivercode = b.file_id JOIN tbl_motor AS c ON a.motorcode = c.motorid JOIN tbl_tdp AS d ON a.trcode = d.trcode WHERE a.appl_status = 'TDP' AND a.iscancel = 0 AND a.operCode = ?");
		// 		$drivers->bindValue(1, $code);
		// 		$drivers->execute();

		$drivers = $this->connect()->prepare("SELECT a.trcode, CONCAT(first_name,' ', LEFT(middle_name, 1), '. ', last_name, ' ', ext_name) as fname, motorpin, a.foryear FROM tbl_motorlinking AS a JOIN tbl_humans AS b ON a.driver = b.humanpin JOIN tbl_motor AS c ON a.motor = c.motorpin WHERE a.iscancel = 0 AND a.operator = ?");
		$drivers->bindValue(1, $code);
		$drivers->execute();

		$motors = $this->connect()->prepare("SELECT motorpin, CONCAT(toda, ' - #', bodyno) as tbody, plateno, engine, chassis, `status`, franchiseno, foryear, remarks, last_renew, dtexprd FROM tbl_motor WHERE opercode = ?");
		$motors->bindValue(1, $code);
		$motors->execute();

		// $links = $this->connect()->prepare("SELECT trcode, driver, operator, motor, franchiseno, dtreg, appl_status FROM tbl_motorlinking WHERE operator = ?");
		// $links->bindValue(1, $code);
		// $links->execute();

		$trail = $this->connect()->prepare("SELECT trcode FROM tbl_motorlinking WHERE operator = :code ORDER BY trcode");
		$trail->bindParam(":code", $code);
		$trail->execute();

		$datatrail = $trail->fetchAll(PDO::FETCH_ASSOC);
		$audits = array();
		foreach ($datatrail as $key => $value) {
			$trail = $this->connect()->query("SELECT * FROM audit_trail WHERE transdetails LIKE '%" . $value['trcode'] . "%'");
			$trail->execute();
			if ($trail->rowCount() > 0) {
				foreach ($trail->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
					array_push($audits, $value);
				}
			}
		}

		return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "operator" => $stmt->fetch(PDO::FETCH_ASSOC), "drivers" => $drivers->fetchAll(PDO::FETCH_ASSOC), "motors" => $motors->fetchAll(PDO::FETCH_ASSOC), "audits" => $audits));
	}

	public function cancelFranchise($trcode, $reason, $auth)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
					$stmt->bindValue(1, $trcode);
					$stmt->execute();

					$app = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($app['Tags'] == "FOR RELEASING" || $app['Tags'] == "RELEASED") {
						return json_encode(array("result" => false, "msg" => "This application is already paid. Please call an administrator if you want to continue"));
					}

				// 	$stmt = $this->connect()->prepare("SELECT row_num FROM (SELECT *, ROW_NUMBER() OVER(ORDER BY datecreated DESC) AS row_num   FROM tbl_motorlinking WHERE motor = ? ORDER BY datecreated DESC) AS a WHERE trcode = ?");
				// 	$stmt->bindValue(1, $app['motorcode']);

				// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE motor = ? AND iscancel = 0 ORDER BY datecreated DESC LIMIT 1, 1");
				// 	$stmt->bindValue(1, $app['motorcode']);
				// 	$stmt->execute();
				// 	$mlink = $stmt->fetch(PDO::FETCH_ASSOC);

				// 	$stmt = $this->connect()->prepare("UPDATE tbl_motor SET dtexprd = ? WHERE motorpin = ?");
				// 	$fxdt = "1990-01-01";
				// 	$stmt->bindValue(1, $fxdt);
				// 	$stmt->bindValue(2, $mlink['motor']);
				// 	$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET iscancel = 1, cancelreason = ?, dtcancel = ? WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, date("Y-m-d h:i:s"));
					$stmt->bindValue(3, $trcode);
					$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_application SET remarks = ?, cancelledby = ?, dtcancelled = ?, iscancel = 1 WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, $_SESSION['username']);
					$stmt->bindValue(3, date("Y-m-d h:i:s"));
					$stmt->bindValue(4, $trcode);
					if ($stmt->execute()) {
						$this->saveAudit("Cancel Franchise Application", $trcode . " has been cancelled due to "  . $reason);
						return json_encode(array("result" => true, "msg" => "This application has been cancelled successfully."));
					} else {
						return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
					}
				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator", "error" => $e));
		}
	}


	public function cancelChangeMotor($trcode, $reason, $auth)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					$stmt = $this->connect()->prepare("SELECT * FROM tbl_changemotor WHERE trcode = ?");
					$stmt->bindValue(1, $trcode);
					$stmt->execute();

					$app = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($app['Tags'] == "FOR RELEASING" || $app['Tags'] == "RELEASED") {
						return json_encode(array("result" => false, "msg" => "This application is already paid. Please call an administrator if you want to continue"));
					}

				// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE motor = ? AND iscancel = 0 ORDER BY datecreated DESC LIMIT 1, 1");
				// 	$stmt->bindValue(1, $app['motorcode']);
				// 	$stmt->execute();
				// 	$mlink = $stmt->fetch(PDO::FETCH_ASSOC);

				// 	$stmt = $this->connect()->prepare("UPDATE tbl_motor SET dtexprd = ? WHERE motorpin = ?");
				// 	$stmt->bindValue(1, $mlink['motor']);
				// 	$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET iscancel = 1, cancelreason = ?, dtcancelled = ? WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, date("Y-m-d h:i:s"));
					$stmt->bindValue(3, $trcode);
					$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_changemotor SET remarks = ?, cancelledby = ?, dtcancelled = ?, iscancel = 1 WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, $_SESSION['username']);
					$stmt->bindValue(3, date("Y-m-d h:i:s"));
					$stmt->bindValue(4, $trcode);
					if ($stmt->execute()) {
						$this->saveAudit("Cancel Change Motor Application", $trcode . " has been cancelled due to "  . $reason);
						return json_encode(array("result" => true, "msg" => "This application has been cancelled successfully."));
					} else {
						return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
					}
				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator", "error" => $e));
		}
	}
	
	public function cancelChangeOwnership($trcode, $reason, $auth)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					$stmt = $this->connect()->prepare("SELECT * FROM tbl_changeownership WHERE trcode = ?");
					$stmt->bindValue(1, $trcode);
					$stmt->execute();

					$app = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($app['Tags'] == "FOR RELEASING" || $app['Tags'] == "RELEASED") {
						return json_encode(array("result" => false, "msg" => "This application is already paid. Please call an administrator if you want to continue"));
					}

				// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE motor = ? AND iscancel = 0 ORDER BY datecreated DESC LIMIT 1, 1");
				// 	$stmt->bindValue(1, $app['motorcode']);
				// 	$stmt->execute();
				// 	$mlink = $stmt->fetch(PDO::FETCH_ASSOC);

					$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET iscancel = 1, cancelreason = ?, dtcancelled = ? WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, date("Y-m-d h:i:s"));
					$stmt->bindValue(3, $trcode);
					$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_changeownership SET remarks = ?, cancelledby = ?, dtcancelled = ?, iscancel = 1 WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, $_SESSION['username']);
					$stmt->bindValue(3, date("Y-m-d h:i:s"));
					$stmt->bindValue(4, $trcode);
					if ($stmt->execute()) {
						$this->saveAudit("Cancel Change Ownership Application", $trcode . " has been cancelled due to "  . $reason);
						return json_encode(array("result" => true, "msg" => "This application has been cancelled successfully."));
					} else {
						return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
					}
				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator"));
		}
	}


	public function cancelDropping($trcode, $reason, $auth)
	{
		// if (!$this->checkAdminAuth($auth)) {
		// 	return json_encode(array("result" => false, "msg" => "Authorization Failed. Please try again."));
		// }

		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					//query
                    
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE ((previous_operator = :code OR operator = :code) OR (previous_driver = :code OR driver = :code)) AND iscancel = 0");
		$stmt->bindParam(":code", $trcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return json_encode(array("result" => false, "msg" => "Operator/Driver is used to some record deleting it might corrupt some application."));
		}

		$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $this->connect()->prepare("UPDATE tbl_drop SET iscancel = 1 WHERE trcode = ?");
		$stmt->bindParam(1, $trcode);

		if ($stmt->execute()) {
			$this->saveAudit("Delete Human", $trcode . " has been deleted from the records.");
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ?");
			$stmt->bindValue(1, $trcode);
			$stmt->execute();
			$datas = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->saveLogs("DELETE MOTOR", json_encode(array($datas)), json_encode(array($data)), json_encode(array("humanpin" => $trcode, "reason" => $reason)), $_SESSION['username'], "MOTOR");
			return json_encode(array("result" => true, "msg" => "Motor has been deleted successfully!!"));
			
		}


				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator", "error" => $e));
		}
	}

	

	// public function cancelDrop($trcode, $reason, $auth)
	// {
	// 	$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
	// 	$stmt->bindValue(1, $_SESSION['username']);
	// 	$stmt->bindValue(2, $auth);
	// 	$stmt->execute();

	// 	if ($stmt->rowCount() > 0) {
	// 		$au = $stmt->fetch(PDO::FETCH_ASSOC);
	// 		if ($au['UserLevel'] != 'user') {
	// 			$stmt = $this->connect()->prepare("SELECT * FROM tbl_drop WHERE trcode = ?");
	// 			$stmt->bindValue(1, $trcode);
	// 			$stmt->execute();

	// 			$app = $stmt->fetch(PDO::FETCH_ASSOC);
	// 			if ($app['trans_status'] == "FOR RELEASING" || $app['trans_status'] == "RELEASED") {
	// 				return json_encode(array("result" => false, "msg" => "This application is already paid. Please call an administrator if you want to continue"));
	// 			}

	// 			$stmt = $this->connect()->prepare("UPDATE tbl_motor SET remarks = '', isdrop = 0, mo9 = 'UNAVAILABLE' WHERE motorid = ?");
	// 			$stmt->bindValue(1, $app['motorcode']);
	// 			$stmt->execute();

	// 			$stmt = $this->connect()->prepare("UPDATE tbl_drop SET remarks = ?, cancelledby = ?, dtcancelled = ?, iscancel = 1 WHERE trcode = ?");
	// 			$stmt->bindValue(1, $reason);
	// 			$stmt->bindValue(2, $_SESSION['username']);
	// 			$stmt->bindValue(3, date("Y-m-d h:i:s"));
	// 			$stmt->bindValue(4, $trcode);
	// 			if ($stmt->execute()) {
	// 				$this->saveAudit("Cancel Dropping", $trcode . " has been cancelled due to "  . $name);
	// 				return json_encode(array("result" => true, "msg" => "This application has been cancelled successfully."));
	// 			} else {
	// 				return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
	// 			}
	// 		} else {
	// 			return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
	// 		}
	// 	} else {
	// 		return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
	// 	}
	// }
//carlo
	public function cancelChangeDriver($trcode, $reason, $auth)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? AND `password` = ?");
			$stmt->bindValue(1, $_SESSION['username']);
			$stmt->bindValue(2, $auth);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				$au = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($au['UserLevel'] != 'user') {
					$stmt = $this->connect()->prepare("SELECT * FROM tbl_changedriver WHERE trcode = ?");
					$stmt->bindValue(1, $trcode);
					$stmt->execute();

					$app = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($app['Tags'] == "FOR RELEASING" || $app['Tags'] == "RELEASED") {
						return json_encode(array("result" => false, "msg" => "This application is already paid. Please call an administrator if you want to continue"));
					}

				// 	$stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE motor = ? AND iscancel = 0 ORDER BY datecreated DESC LIMIT 1, 1");
				// 	$stmt->bindValue(1, $app['motorcode']);
				// 	$stmt->execute();
				// 	$mlink = $stmt->fetch(PDO::FETCH_ASSOC);

					$stmt = $this->connect()->prepare("UPDATE tbl_motorlinking SET iscancel = 1, cancelreason = ?, dtcancelled = ? WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, date("Y-m-d h:i:s"));
					$stmt->bindValue(3, $trcode);
					$stmt->execute();

					$stmt = $this->connect()->prepare("UPDATE tbl_changedriver SET remarks = ?, cancelledby = ?, dtcancelled = ?, iscancel = 1 WHERE trcode = ?");
					$stmt->bindValue(1, $reason);
					$stmt->bindValue(2, $_SESSION['username']);
					$stmt->bindValue(3, date("Y-m-d h:i:s"));
					$stmt->bindValue(4, $trcode);
					if ($stmt->execute()) {
						$this->saveAudit("Cancel Change Driver Application", $trcode . " has been cancelled due to "  . $reason);
						return json_encode(array("result" => true, "msg" => "This application has been cancelled successfully."));
					} else {
						return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
					}
				} else {
					return json_encode(array("result" => false, "msg" => "Sorry, you are not authorized to make this decision."));
				}
			} else {
				return json_encode(array("result" => false, "msg" => "Wrong authentication detected."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "System encountered a problem. Contact Administrator"));
		}
	}
//carlo

	public function getReportAbstract($from, $to)
	{
		$stmt = $this->connect()->query("SELECT * FROM tbl_nature WHERE collnature <> 0 ORDER BY ID");
		$stmt->execute();
		$nature = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$sql = "";

		foreach ($nature as $key => $value) {
			$sql .= ", sum((case when collnature = '" . $value['collnature'] . "' then amount else 0 end)) as col" . $value['ID'];
		}

		$sql .= ", sum(amount) as totamt from acf51det where (datecreate BETWEEN '" . $from . "' AND '" . $to . "') and iscancel = '0' AND acf51det.collnature in ('106', '115', '125', '127', '129', '132', '190', '21671', '21672', '21675','118') group by orno,datecreate,payor";


		//$stmt = $this->connect()->prepare("cv ");

		$sql = "SELECT orno, datecreate, payor, descript, amount" . $sql ;

		$stmt = $this->conn()->query($sql);
			
		if ($stmt->execute()) { 
		    return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator.", "data" => []));
		}
	}

	public function getPermitDetails($trcode, $trans, $app)
	{
		$stmt = "";
		switch ($trans) {
			case "NEW":
			case "RENEW":
				$stmt = $this->connect()->prepare("SELECT trcode, IF(c.crswitch = 'on', CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name), '/', c.crname), CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name)) as fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr,CONCAT( b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addre, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drivername, CONCAT(d.address_brgy, ', ', d.address_municipality, ', ', d.address_province) as driveraddr, a.franchise_no, yr, a.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, appl_status, b.certno, b.certat, b.certon, encoded_by, franchise_date, dtreg, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, d.birth_date AS driverbirthday, d.age AS driverage, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_application AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON a.drivercode = d.humanpin WHERE trcode = ?");
				break;
				
			case "CHANGE MOTOR":
				// $stmt = $this->connect()->prepare("SELECT trcode, IF(d.crswitch = 'on', CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), '/', d.crname), CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name)) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, d.franchiseno AS franchise_no, d.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch,encoded_by, target_path, toda FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS d ON a.newmotorcode = d.motorpin WHERE trcode = ?");
				// break;
				// $stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(e.first_name,' ', LEFT(e.middle_name, 2), '. ', e.last_name, ' ', e.ext_name), '/', CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name)) AS fullname,CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drivername, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as driveraddr, c.franchiseno AS franchise_no, c.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, appl_status, b.certno, b.certat, b.certon, encoded_by, last_renew AS franchise_date, dateapplication AS dtreg, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, d.birth_date AS driverbirthday, d.age AS driverage, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON c.drivercode = d.humanpin JOIN tbl_humans AS e ON a.opercode = e.humanpin WHERE trcode = ?");
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name)) AS fullname,CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drivername, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as driveraddr, c.franchiseno AS franchise_no, c.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, appl_status, b.certno, b.certat, b.certon, encoded_by, last_renew AS franchise_date, dateapplication AS dtreg, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, d.birth_date AS driverbirthday, d.age AS driverage, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON c.drivercode = d.humanpin JOIN tbl_humans AS e ON a.opercode = e.humanpin WHERE trcode = ?");
				
				break;

			case "CHANGE OWNERSHIP":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(e.first_name,' ', LEFT(e.middle_name, 2), '. ', e.last_name, ' ', e.ext_name), '/', CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name)) AS fullname,CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name) AS drivername, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as driveraddr, c.franchiseno AS franchise_no, c.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, appl_status, b.certno, b.certat, b.certon, encoded_by, last_renew AS franchise_date, dateapplication AS dtreg, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, d.birth_date AS driverbirthday, d.age AS driverage, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_changeownership AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON c.drivercode = d.humanpin JOIN tbl_humans AS e ON a.opercode = e.humanpin WHERE trcode = ?");
				break;
			case "CHANGE DRIVER":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(e.first_name,' ', LEFT(e.middle_name, 2), '. ', e.last_name, ' ', e.ext_name)) AS fullname,CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, CONCAT( CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name)) AS drivername, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as driveraddr, c.franchiseno AS franchise_no, c.dtexprd, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, appl_status, b.certno, b.certat, b.certon, encoded_by, last_renew AS franchise_date, dateapplication AS dtreg, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, d.birth_date AS driverbirthday, d.age AS driverage, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_changedriver AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_humans AS d ON c.drivercode = d.humanpin JOIN tbl_humans AS e ON a.opercode = e.humanpin WHERE trcode = ?");
				break;
			case "DROPPING":
					$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 2), '. ', b.last_name, ' ', b.ext_name) AS fullname, yearmodel, chassis, engine, plateno, make, bodyno, ltobranch, b.target_path, toda, b.occupation, b.certno, b.certat, b.certon, `username` AS encoded_by, mvno, date_released, b.mobile_no AS opcontact, b.age, b.birth_date, b.sex, b.civil_status, b.conperson, b.conconnum, b.conaddress, munplateno, b.humanpin FROM tbl_drop AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE trcode = ? AND tags = 'RELEASED'");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}

		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($data)) {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}

		$stmt = $this->connect()->prepare("SELECT Fees, or_number, or_date, a.dueamt FROM tbl_payment AS a JOIN tbl_assoffees AS b ON a.feesid = b.ID WHERE trcode = ? AND iscancel = 0");
		$stmt->bindValue(1, $trcode);
		if ($stmt->execute()) {
			$data += array("payment" =>  $stmt->fetchAll(PDO::FETCH_ASSOC));
			$stmt = $this->connect()->prepare("SELECT * FROM tbl_approve WHERE app_id = ?");
			$stmt->bindValue(1, $app);
			$stmt->execute();
			$data += $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = $this->connect()->prepare("SELECT fullname AS enc FROM users WHERE username = ?");
			$stmt->bindValue(1, $data['encoded_by']);
			$stmt->execute();
			$data += $stmt->fetch(PDO::FETCH_ASSOC);
			

			return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "data" => $data));
		} else {
			return json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
		}
	}

	public function getApprovePersonel()
	{
		$stmt = $this->connect()->query("SELECT * FROM tbl_approve");
		if ($stmt->execute()) {
			return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
	}

	public function getAssforPrint($type, $trcode)
	{
		$stmt = "";
		switch ($type) {
			case "NEW":
			case "RENEW":
				$stmt = $this->connect()->prepare("SELECT trcode, IF(appl_status <> 'TDP', CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name)) AS fullname, IF(appl_status <> 'TDP', CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province), CONCAT(c.address_house_no, ' ', c.address_street_name, ' ', c.address_subdivision, ' ', c.address_brgy, ' ', c.address_municipality, ', ', c.address_province)) as addr, Tags, appl_status, dttm, CONCAT(toda, ' - ', bodyno) AS tbody, engine, chassis, plateno, make, yearmodel FROM tbl_application AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS c ON a.drivercode = c.humanpin JOIN tbl_motor AS d ON a.motorcode = d.motorpin WHERE trcode = ?");
				break;
			case "CHANGE MOTOR":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, Tags, appl_status, dttm, CONCAT(toda, ' - ', bodyno) AS tbody, engine, chassis, plateno, make, yearmodel FROM tbl_changemotor AS a JOIN tbl_humans AS b ON a.newopercode = b.humanpin JOIN tbl_motor AS d ON a.newmotorcode = d.motorpin WHERE trcode = ?");
				break;
			case "CHANGE OWNERSHIP":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), '/', CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name)) AS fullname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as addr, Tags, appl_status, dttm, CONCAT(toda, ' - ', bodyno) AS tbody, engine, chassis, plateno, make, yearmodel FROM tbl_changeownership AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.newopercode = d.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE trcode = ?");
				break;
			case "CHANGE DRIVER":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name), '/', CONCAT(d.first_name,' ', LEFT(d.middle_name, 1), '. ', d.last_name, ' ', d.ext_name)) AS fullname, CONCAT(d.address_house_no, ' ', d.address_street_name, ' ', d.address_subdivision, ' ', d.address_brgy, ' ', d.address_municipality, ', ', d.address_province) as addr, Tags, appl_status, dttm, CONCAT(toda, ' - ', bodyno) AS tbody, engine, chassis, plateno, make, yearmodel FROM tbl_changedriver AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_humans AS d ON a.newopercode = d.humanpin JOIN tbl_motor AS c ON a.motorcode = c.motorpin WHERE trcode = ?");
				break;
			case "DROPPING":
				$stmt = $this->connect()->prepare("SELECT trcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province) as addr, Tags, 'DROPPING' AS appl_status, dttm, CONCAT(toda, ' - ', bodyno) AS tbody, engine, chassis, plateno, make, yearmodel FROM tbl_drop AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin JOIN tbl_motor AS d ON a.motorcode = d.motorpin WHERE trcode = ?");
				break;
			default:
				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
		}

		$stmt->bindValue(1, $trcode);
		$stmt->execute();

		$application = $stmt->fetch(PDO::FETCH_ASSOC);
		$application['assby'] = $_SESSION['fullname'];
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
		$stmt->bindValue(1, $trcode);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$assessment = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return json_encode(array("result" => true, "msg" => "Data lodaded successfully.", "data" => array("application" => $application, "assessment" => $assessment)));
		} else {
			return json_encode(array("result" => false, "msg" => "No assessment has been made yet."));
		}
	}

	public function saveFees($option, $amount, $category)
	{
		try {
			$stmt = $this->conn()->prepare("SELECT * FROM collmast WHERE collnature = ?");
			$stmt->bindValue(1, $option);
			$stmt->execute();
			$coll = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = $this->connect()->prepare("INSERT INTO tbl_assoffees(Fees, AmtDue, trans, collnature) VALUE (?, ?, ?, ?)");
			$stmt->bindValue(1, $coll['descript']);
			$stmt->bindValue(2, $amount);
			$stmt->bindValue(3, $category);
			$stmt->bindValue(4, $option);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Assessment fee added successfully."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}
	
	public function updateFees($option, $amount, $category, $id)
	{
		try {
			$stmt = $this->conn()->prepare("SELECT * FROM collmast WHERE collnature = ?");
			$stmt->bindValue(1, $option);
			$stmt->execute();
			$coll = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = $this->connect()->prepare("UPDATE tbl_assoffees SET Fees = ?, AmtDue = ?, trans = ?, collnature = ? WHERE ID = ?");
			$stmt->bindValue(1, $coll['descript']);
			$stmt->bindValue(2, $amount);
			$stmt->bindValue(3, $category);
			$stmt->bindValue(4, $option);
			$stmt->bindValue(5, $id);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Assessment fee updated successfully."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function getAllRequirements($cat)
	{
		$stmt = $this->connect()->prepare("SELECT * FROM tbl_requirements WHERE trans = ?");
		$stmt->bindValue(1, $cat);
		if ($stmt->execute()) {
			return json_encode(array("data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
		}
	}

	public function updateReq($desc, $cat, $id)
	{
		try {
			$stmt = $this->connect()->prepare("UPDATE tbl_requirements SET reqdesc = ?, trans = ? WHERE reqid = ?");
			$stmt->bindValue(1, $desc);
			$stmt->bindValue(2, $cat);
			$stmt->bindValue(3, $id);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Requirement updated successfully."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function saveReq($desc, $cat)
	{
		try {
			$stmt = $this->connect()->prepare("INSERT INTO tbl_requirements (reqdesc, trans) VALUES (?,?)");
			$stmt->bindValue(1, $desc);
			$stmt->bindValue(2, $cat);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Requirement saved successfully."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function getFranExpDate()
	{
		try {
			$stmt = $this->connect()->prepare("SELECT noofyr, expmode FROM ysettings");
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Data loaded successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}
	
	public function updateFranExpDate($franexp, $expmode)
	{
		try {
			$stmt = $this->connect()->prepare("UPDATE ysettings SET noofyr = ?, expmode = ?");
			$stmt->bindValue(1, $franexp);
			$stmt->bindValue(2, $expmode);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Data Saved successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't save the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function getReqApplication($trcode, $apptype)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT a.reqid, a.reqdesc, target_path, imgname from tbl_requirements AS a LEFT JOIN tbl_reqapplication AS b ON a.reqid = b.reqid AND b.trcode = ? WHERE a.trans = ? ORDER BY a.reqid");
			$stmt->bindValue(1, $trcode);
			$stmt->bindValue(2, $apptype);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Data loaded successfully.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function getdetInspection($trcode)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT trcode, opercode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, motorcode, toda, make, engine, chassis, bodyno, plateno, fuel, model, yearacquired, headlightSW, headlight, signallightSW, signallight, stoplightSW, stoplight, handfootbrakeSW, handfootbrake, lightinsidecarSW, lightinsidecar, trashcanSW, trashcan, plateSW, plate, drivlisSW, a.drivlis, stencil1, stencil2, status, inspectedby, approvedby, a.remarks FROM tbl_inspection AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin WHERE trcode = ?");
			$stmt->bindValue(1, $trcode);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				return json_encode(array("result" => true, "msg" => "Data loaded successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
			}

			$stmt = $this->connect()->prepare("SELECT b.humanpin as opcode, CONCAT(b.first_name,' ', LEFT(b.middle_name, 1), '. ', b.last_name, ' ', b.ext_name) AS fullname, CONCAT(b.address_house_no, ' ', b.address_street_name, ' ', b.address_subdivision, ' ', b.address_brgy, ' ', b.address_municipality, ', ', b.address_province, ', ', b.address_region) as addr, motorpin, c.toda, bodyno, make, engine, chassis, plateno, c.platecolor, a.trcode FROM tbl_motorlinking AS a JOIN tbl_humans AS b ON a.operator = b.humanpin JOIN tbl_motor AS c ON a.motor = c.motorpin WHERE a.trcode = ?");
			$stmt->bindValue(1, $trcode);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Data loaded successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}
	
	public function getdetInspectionforPrint($trcode)
	{
		try {
			$stmt = $this->connect()->prepare("SELECT trcode, opercode, b.first_name, b.middle_name, b.last_name, b.ext_name, b.address_house_no, b.address_street_name, b.address_subdivision, b.address_brgy, b.address_municipality, b.address_province, b.address_region, motorcode, toda, make, engine, chassis, bodyno, plateno, fuel, model, yearacquired, headlightSW, headlight, signallightSW, signallight, stoplightSW, stoplight, handfootbrakeSW, handfootbrake, lightinsidecarSW, lightinsidecar, trashcanSW, trashcan, plateSW, plate, drivlisSW, a.drivlis, stencil1, stencil2, status, inspectedby, approvedby, a.remarks FROM tbl_inspection AS a JOIN tbl_humans AS b ON a.opercode = b.humanpin WHERE trcode = ?");
			$stmt->bindValue(1, $trcode);
			if ($stmt->execute()) {
				return json_encode(array("result" => true, "msg" => "Data loaded successfully.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function submitInspection($trcode, $opercode, $motorcode, $toda, $make, $engine, $chassis, $bodyno, $plateno, $fuel, $model, $yearacquired, $headlightSW, $headlight, $signallightSW, $signallight, $stoplightSW, $stoplight, $handfootbrakeSW, $handfootbrake, $lightinsidecarSW, $lightinsidecar, $trashcanSW, $trashcan, $plateSW, $plate, $drivlisSW, $drivlis, $stencil1, $stencil2, $remarks, $appl_status)
	{
		$status = "PASSED";
		$remarks = "";
		if ($headlightSW == "off" || $signallightSW == "off" || $stoplightSW == "off" || $handfootbrakeSW == "off" || $lightinsidecarSW == "off" || $trashcanSW == "off" || $plateSW == "off" || $drivlisSW == "off") {
			$status = "FAILED";
		}

		try {
			$stmt2 = "";
			switch ($appl_status) {
				case "NEW":
				case "RENEW":
					$stmt2 = $this->connect()->prepare("SELECT Tags FROM tbl_application WHERE trcode = ?");
					break;
				case "CHANGE MOTOR":
					$stmt2 = $this->connect()->prepare("SELECT Tags FROM tbl_changemotor WHERE trcode = ?");
					break;
				case "CHANGE OWNERSHIP":
					$stmt2 = $this->connect()->prepare("SELECT Tags FROM tbl_changeownership WHERE trcode = ?");
					break;
				case "CHANGE DRIVER":
					$stmt2 = $this->connect()->prepare("SELECT Tags FROM tbl_changedriver WHERE trcode = ?");
					break;
				case "DROPPING":
					$stmt2 = $this->connect()->prepare("SELECT tags as Tags FROM tbl_drop WHERE trcode = ?");
					break;
				default:
					return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
			}
			$stmt2->bindValue(1, $trcode);
			$stmt2->execute();
			$hrb = $stmt2->fetch(PDO::FETCH_ASSOC);
			if ($hrb['Tags'] == "FOR RELEASING" || $hrb['Tags'] == "RELEASED") {
				return json_encode(array("result" => false, "msg" => 'This is already paid can\'t take back the inspection result.'));
			}

			$stmt1 = $this->connect()->prepare("SELECT trcode FROM tbl_inspection WHERE trcode = ?");
			$stmt1->bindValue(1, $trcode);
			$stmt1->execute();

			$stmt = "";
			if ($stmt1->rowCount() > 0) {
				$stmt = $this->connect()->prepare("UPDATE tbl_inspection SET opercode = :opercode, motorcode = :motorcode, toda = :toda, make = :make, engine = :engine, chassis = :chassis, bodyno = :bodyno, plateno = :plateno, fuel = :fuel, model = :model, yearacquired = :yearacquired, headlightSW = :headlightSW, headlight = :headlight, signallightSW = :signallightSW, signallight = :signallight, stoplightSW = :stoplightSW, stoplight = :stoplight, handfootbrakeSW = :handfootbrakeSW, handfootbrake = :handfootbrake, lightinsidecarSW = :lightinsidecarSW, lightinsidecar = :lightinsidecar, trashcanSW = :trashcanSW, trashcan = :trashcan, plateSW = :plateSW, plate = :plate, drivlisSW = :drivlisSW, drivlis = :drivlis, stencil1 = :stencil1, stencil2 = :stencil2, status = :status, inspectedby = :inspectedby, approvedby = :approvedby, remarks = :remarks WHERE trcode = :trcode");
			} else {
				$stmt = $this->connect()->prepare("INSERT INTO tbl_inspection (trcode, opercode, motorcode, toda, make, engine, chassis, bodyno, plateno, fuel, model, yearacquired, headlightSW, headlight, signallightSW, signallight, stoplightSW, stoplight, handfootbrakeSW, handfootbrake, lightinsidecarSW, lightinsidecar, trashcanSW, trashcan, plateSW, plate, drivlisSW, drivlis, stencil1, stencil2, status, inspectedby, approvedby, remarks) VALUES (:trcode, :opercode, :motorcode, :toda, :make, :engine, :chassis, :bodyno, :plateno, :fuel, :model, :yearacquired, :headlightSW, :headlight, :signallightSW, :signallight, :stoplightSW, :stoplight, :handfootbrakeSW, :handfootbrake, :lightinsidecarSW, :lightinsidecar, :trashcanSW, :trashcan, :plateSW, :plate, :drivlisSW, :drivlis, :stencil1, :stencil2, :status, :inspectedby, :approvedby, :remarks)");
			}

			$stmt->bindParam(":trcode", $trcode);
			$stmt->bindParam(":opercode", $opercode);
			$stmt->bindParam(":motorcode", $motorcode);
			$stmt->bindParam(":toda", $toda);
			$stmt->bindParam(":make", $make);
			$stmt->bindParam(":engine", $engine);
			$stmt->bindParam(":chassis", $chassis);
			$stmt->bindParam(":bodyno", $bodyno);
			$stmt->bindParam(":plateno", $plateno);
			$stmt->bindParam(":fuel", $fuel);
			$stmt->bindParam(":model", $model);
			$stmt->bindParam(":yearacquired", $yearacquired);
			$stmt->bindParam(":headlightSW", $headlightSW);
			$stmt->bindParam(":headlight", $headlight);
			$stmt->bindParam(":signallightSW", $signallightSW);
			$stmt->bindParam(":signallight", $signallight);
			$stmt->bindParam(":stoplightSW", $stoplightSW);
			$stmt->bindParam(":stoplight", $stoplight);
			$stmt->bindParam(":handfootbrakeSW", $handfootbrakeSW);
			$stmt->bindParam(":handfootbrake", $handfootbrake);
			$stmt->bindParam(":lightinsidecarSW", $lightinsidecarSW);
			$stmt->bindParam(":lightinsidecar", $lightinsidecar);
			$stmt->bindParam(":trashcanSW", $trashcanSW);
			$stmt->bindParam(":trashcan", $trashcan);
			$stmt->bindParam(":plateSW", $plateSW);
			$stmt->bindParam(":plate", $plate);
			$stmt->bindParam(":drivlisSW", $drivlisSW);
			$stmt->bindParam(":drivlis", $drivlis);
			$stmt->bindParam(":stencil1", $stencil1);
			$stmt->bindParam(":stencil2", $stencil2);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":inspectedby", $_SESSION['fullname']);
			$stmt->bindParam(":approvedby", $_SESSION['fullname']);
			$stmt->bindParam(":remarks", $remarks);
			$stmt->execute();

			$stmt = "";
			switch ($appl_status) {
				case "NEW":
				case "RENEW":
					if ($status == "PASSED") {
						$stmt = $this->connect()->prepare("UPDATE tbl_application SET Tags = 'FOR ASSESSMENT', tagscode = 3 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					} else {
						$stmt = $this->connect()->prepare("UPDATE tbl_application SET Tags = 'DENIED', tagscode = 7 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					}
					break;
				case "CHANGE MOTOR":
					if ($status == "PASSED") {
						$stmt = $this->connect()->prepare("UPDATE tbl_changemotor SET Tags = 'FOR ASSESSMENT', tagscode = 3 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					} else {
						$stmt = $this->connect()->prepare("UPDATE tbl_changemotor SET Tags = 'DENIED', tagscode = 7 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					}
					break;
				case "CHANGE OWNERSHIP":
					if ($status == "PASSED") {
						$stmt = $this->connect()->prepare("UPDATE tbl_changeownership SET Tags = 'FOR ASSESSMENT', tagscode = 3 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					} else {
						$stmt = $this->connect()->prepare("UPDATE tbl_changeownership SET Tags = 'DENIED', tagscode = 7 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					}
					break;
						case "CHANGE DRIVER":
					if ($status == "PASSED") {
						$stmt = $this->connect()->prepare("UPDATE tbl_changedriver SET Tags = 'FOR ASSESSMENT', tagscode = 3 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					} else {
						$stmt = $this->connect()->prepare("UPDATE tbl_changedriver SET Tags = 'DENIED', tagscode = 7 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					}
					break;

				case "DROPPING":
					if ($status == "PASSED") {
						$stmt = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'FOR ASSESSMENT', tagscode = 3 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					} else {
						$stmt = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'DENIED', tagscode = 7 WHERE trcode = ?");
						$stmt->bindValue(1, $trcode);
					}
					break;
				default:
			}


			if ($stmt->execute()) {
			    $this->saveAudit("Motor Inspection", $trcode . " / " . $opercode . " / " . $motorcode . " has been inspected.");
				return json_encode(array("result" => true, "msg" => "Saved successfully."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
			}
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => $e->getMessage()));
		}
	}

	public function uploadRequirements($trcode, $reqid, $reqdesc, $targetpath, $newname)
	{
		$stmt1 = $this->connect()->prepare("SELECT * FROM tbl_reqapplication WHERE reqid = ? AND trcode = ?");
		$stmt1->bindValue(1, $reqid);
		$stmt1->bindValue(2, $trcode);
		$stmt1->execute();

		$stmt = "";
		if ($stmt1->rowCount() == 0) {
			$stmt = $this->connect()->prepare("INSERT INTO tbl_reqapplication (reqid, reqdesc, trcode, target_path, imgname) VALUES (:reqid, :reqdesc, :trcode, :target_path, :imgname)");
			$stmt->bindParam(":reqid", $reqid);
			$stmt->bindParam(":reqdesc", $reqdesc);
			$stmt->bindParam(":trcode", $trcode);
			$stmt->bindParam(":target_path", $targetpath);
			$stmt->bindParam(":imgname", $newname);
		} else {
			$stmt = $this->connect()->prepare("UPDATE tbl_reqapplication SET target_path = :target_path, imgname = :imgname WHERE reqid = :reqid AND trcode = :trcode");
			$stmt->bindParam(":reqid", $reqid);
			$stmt->bindParam(":trcode", $trcode);
			$stmt->bindParam(":target_path", $targetpath);
			$stmt->bindParam(":imgname", $newname);
		}



		if ($stmt->execute()) {
			return json_encode(array("result" => true, "msg" => $reqdesc." has been uploaded."));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
		}
	}

	public function getChangeMotor($yr, $trstats, $start, $length, $column, $order, $search)
	{

		$sql = "SELECT trcode, humanpin, a.motorcode, a.newmotorcode, a.opercode, first_name, middle_name, last_name, ext_name, address_house_no, address_street_name, address_subdivision, address_brgy, address_municipality, address_province, appl_status, Tags, dttm, target_path FROM tbl_changemotor AS a LEFT JOIN tbl_humans AS b ON a.newopercode = b.humanpin LEFT JOIN tbl_motor AS c ON a.motorcode = c.motorpin JOIN tbl_motor AS d ON a.newmotorcode = d.motorpin WHERE iscancel = 0 AND yr = " . $yr;

		$search_arr = array(0 => "trcode", 1 => "CONCAT(first_name, ' ', last_name)", 2 => "humanpin", 3 => "CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_subdivision, ' ', address_municipality, ' ', address_province, ' ', address_region)", 4 => "dttm", 5 => "a.motorcode",  6 => "a.newmotorcode");

		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}


		if (!empty($trstats)) {
			$sql .= " AND Tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}

        $stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		$rc = $stmt->rowCount();
		
		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;

		$data = array();
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"newopcode" => $key["humanpin"],
				"opcode" => $key["opercode"],
				"motorid" => $key["motorcode"],
				"newmotorid" => $key["newmotorcode"],
				"target_path" => $key["target_path"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				"appl_status" => $key["appl_status"],
				"Tags" => $key["Tags"],
				"dttm" => $key["dttm"],
				"buttons" => $this->statusButton($key["Tags"], "changemotor")
			));
		}

		return json_encode(array("data" => $data, "recordsTotal" => $stmt->rowCount(), "recordsFiltered" => $rc));
	}

	public function getChangeOwnership($yr, $trstats, $start, $length, $column, $order, $search)
	{

		$sql = "SELECT trcode, a.opercode, a.motorcode, a.newopercode, b.first_name, b.middle_name, b.last_name, b.ext_name, b.address_house_no, b.address_street_name, b.address_subdivision, b.address_brgy, b.address_municipality, b.address_province, appl_status, Tags, dttm, b.target_path FROM tbl_changeownership AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_motor AS c ON a.motorcode = c.motorpin LEFT JOIN tbl_humans AS d ON a.newopercode = d.humanpin WHERE iscancel = 0 AND yr = " . $yr;

		$search_arr = array(0 => "trcode", 1 => "CONCAT(first_name, ' ', last_name)", 2 => "a.humanpin", 3 => "CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_subdivision, ' ', address_municipality, ' ', address_province, ' ', address_region)", 4 => "dttm", 5 => "a.motorcode",  6 => "a.newmotorcode");

		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}

		if (!empty($trstats)) {
			$sql .= " AND Tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}

		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;

		$data = array();
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"opcode" => $key["opercode"],
				"motorid" => $key["motorcode"],
				"newopcode" => $key["newopercode"],
				"target_path" => $key["target_path"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				"appl_status" => $key["appl_status"],
				"Tags" => $key["Tags"],
				"dttm" => $key["dttm"],
				"buttons" => $this->statusButton($key["Tags"], "changeownership")
			));
		}

		return json_encode(array("data" => $data, "recordsTotal" => $stmt->rowCount(), "recordsFiltered" => $stmt->rowCount()));
	}
//carlo
	public function getChangeDriver($yr, $trstats, $start, $length, $column, $order, $search)
	{

		$sql = "SELECT trcode, a.opercode, a.motorcode, a.newopercode, b.first_name, b.middle_name, b.last_name, b.ext_name, b.address_house_no, b.address_street_name, b.address_subdivision, b.address_brgy, b.address_municipality, b.address_province, appl_status, Tags, dttm, b.target_path FROM tbl_changedriver AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin LEFT JOIN tbl_motor AS c ON a.motorcode = c.motorpin LEFT JOIN tbl_humans AS d ON a.newopercode = d.humanpin WHERE iscancel = 0 AND yr = " . $yr;

		$search_arr = array(0 => "trcode", 1 => "CONCAT(first_name, ' ', last_name)", 2 => "a.humanpin", 3 => "CONCAT(address_house_no, ' ', address_street_name, ' ', address_subdivision, ' ', address_subdivision, ' ', address_municipality, ' ', address_province, ' ', address_region)", 4 => "dttm", 5 => "a.motorcode",  6 => "a.newmotorcode");

		if (!empty($search)) {
			$x = 0;
			foreach ($search_arr as $key) {
				if ($x > 0) {
					$sql .= " OR " . $key . " like '%" . $search . "%'";
				} else {
					$sql .= " AND (" . $key . " like '%" . $search . "%'";
				}
				$x++;
			}
			$sql .= ")";
		}

		if (!empty($trstats)) {
			$sql .= " AND Tags = '" . $trstats . "'";
		}

		if ($column == "function") {
			$column = "trcode";
		}

		$sql .= " ORDER BY " . $column . " " . $order . " LIMIT " . $start . ", " . $length;

		$data = array();
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
			array_push($data, array(
				"trcode" => $key["trcode"],
				"opcode" => $key["opercode"],
				"motorid" => $key["motorcode"],
				"newopcode" => $key["newopercode"],
				"target_path" => $key["target_path"],
				"fullname" => $this->concatfullname($key),
				"addr" => $this->concataddress($key),
				// "appl_status" => $key["appl_status"],
				"appl_status" => "CHANGE DRIVER",
				"Tags" => $key["Tags"],
				"dttm" => $key["dttm"],
				"buttons" => $this->statusButton($key["Tags"], "changedriver")
			));
		}

		return json_encode(array("data" => $data, "recordsTotal" => $stmt->rowCount(), "recordsFiltered" => $stmt->rowCount()));
	}
//calo
	public function motorMakeOption () {
	    $stmt = $this->connect()->query("SELECT * FROM tbl_make ORDER BY decription");
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function ltoOption() {
	    $stmt = $this->connect()->query("SELECT * FROM tbl_lto");
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function platekulayOption() {
	    $stmt = $this->connect()->query("SELECT * FROM tbl_platekulay");
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function verifyCTC($ctcno) {
	    $stmt = $this->conn()->prepare("SELECT ctcno, CONCAT(firstname, ' ', surname) AS fullname, dateissued FROM ctcind WHERE ctcno = ?");
	    $stmt->bindValue(1, $ctcno);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0) {
	       return json_encode(array("result" => true, "msg" => "found.", "data" => $stmt->fetch(PDO::FETCH_ASSOC)));
		} else {
			return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
		}
	}
	
	public function insertList() {
	    $toda = $this->connect()->query("SELECT * FROM tbl_toda WHERE todacode <> 'ETRIKE'");
	    $toda->execute();
	    $dtoda = $toda->fetchAll(PDO::FETCH_ASSOC);

	    foreach($dtoda as $value){
	        for ($x = $value['rangelow']; $x <= $value['rangehigh']; $x++) {
    	        $stmt = $this->connect()->prepare("INSERT INTO tbl_franlist (franchiseno, todacode) VALUES (?, ?)");
    	        $stmt->bindValue(1, $x);
	            $stmt->bindValue(2, $value['todacode']);
	            $stmt->execute();
	            echo $value['todacode'] . " #" . $x . "<br>";
	        } 
	    }
	}
	
	public function getAvailToda ($toda) {
	    try {
	        $stmt = $this->connect()->prepare("SELECT franchiseno FROM tbl_franlist WHERE status <> 'NOT AVAILABLE' AND todacode = ?");
    	    $stmt->bindValue(1, $toda);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "found.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
	    }
	}
	
	public function getTODAperFran() {
	    try {
	        $stmt = $this->connect()->query("SELECT * FROM tbl_franlist");
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "found.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
	    }
	}
	
	public function getExpFran () {
	    try {
	        $stmt = $this->connect()->query("SELECT * FROM tbl_franlist WHERE dtexprd <= DATE(NOW()) AND status = 'NOT AVAILABLE'");
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "found.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
	    }
	}
	
	public function getDashFranDet($trcode) {
	    try {
	        $stmt = $this->connect()->prepare("SELECT * FROM tbl_motorlinking WHERE trcode = ?");
    	    $stmt->bindValue(1, $trcode);
    	    $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            switch ($data['appl_status']) {
    			case "NEW":
    			case "RENEW":
    				return $this->getdetFranchise($trcode);
    				break;
    			case "CHANGE MOTOR":
    				return $this->getdetChangeMotor($trcode);
    				break;
    			case "CHANGE OWNERSHIP":
    				return $this->getdetChangeOwnership($trcode);
    				break;
    			case "CHANGE DRIVER":
    				return $this->getdetChangeDriver($trcode);
    				break;
    			case "DROPPING":
    				return $this->getdetDrop($trcode);
    				break;

    			default:
    				return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
    		}
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong can't load the data."));
	    }
	}
	
	public function saveMake($desc) {
	    try {
	        $stmt = $this->connect()->prepare("INSERT INTO tbl_make (decription) VALUES(?)");
    	    $stmt->bindValue(1, $desc);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => $desc." has been added to the records."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function updateMake($desc, $id) {
	    try {
	        $stmt = $this->connect()->prepare("UPDATE tbl_make SET decription = ? WHERE makeid = ?");
    	    $stmt->bindValue(1, $desc);
    	    $stmt->bindValue(2, $id);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Make has been update."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function saveLTO($desc) {
	    try {
	        $stmt = $this->connect()->prepare("INSERT INTO tbl_lto (nm) VALUES(?)");
    	    $stmt->bindValue(1, $desc);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => $desc." has been added to the records."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function updateLTO($desc, $id) {
	    try {
	        $stmt = $this->connect()->prepare("UPDATE tbl_lto SET nm = ? WHERE ID = ?");
    	    $stmt->bindValue(1, $desc);
    	    $stmt->bindValue(2, $id);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "LTO has been update."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}


	
	public function updateStatus($stags, $strcode) {
		try {
			//$stmt = $this->connect()->prepare("UPDATE tbl_application SET tags = ?, tagscode = ? WHERE trcode = ?");
			$stmt = $this->connect()->prepare("UPDATE tbl_application SET tags = ? WHERE trcode = ?");
			$stmt->bindValue(1, $stags);
			//$stmt->bindValue(2, $sstagscode);
			$stmt->bindValue(2, $strcode);
	
			
			if ($stmt->execute()) {
			   return json_encode(array("result" => true, "msg" => "Status has been update."));
			} else {
				return json_encode(array("result" => false, "msg" => "Something went wrong."));
			} 
		} catch (PDOException $e) {
			return json_encode(array("result" => false, "msg" => "Something went wrong."));
		}
	}
	


	public function getResidencySummaryReport () {
	    try {
	        $stmt1 = $this->connect()->query("SELECT todacode FROM tbl_toda WHERE todacode <> 'ETRIKE'");
	        $stmt1->execute();
	        $data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	        
	        $stmt = $this->connect()->query("SELECT todacode, IFNULL(COUNT(franid), '0') AS res FROM tbl_franlist AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin WHERE psgc_municipality = '042104' GROUP BY todacode");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            $stmt = $this->connect()->query("SELECT todacode, IFNULL(COUNT(franid), '0') AS nres FROM tbl_franlist AS a LEFT JOIN tbl_humans AS b ON a.opercode = b.humanpin WHERE psgc_municipality <> '045809' GROUP BY todacode");
    	    if ($stmt->execute()) {
    	    	if ($stmt->rowCount() == 0) {
    	    		return json_encode(array("data" => [], "result" => false, "msg" => "Something went wrong."));
    	    	}
    	       $nres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	        $zdata = array();
        	    for($x = 0; $x < $stmt1->rowCount() - 1; $x++) {
        	        $xres = ($res[$x]["res"] === null ? 0 : $res[$x]["res"]);
        	        $xnres = ($nres[$x]["nres"] === null ? 0 : $nres[$x]["nres"]);
        	        array_push($zdata, array("toda" => $data[$x]["todacode"], "res" => $xres, "nres" => $xnres, "total" => $xres + $xnres));
        	    }   
	    	       
	    	       return json_encode(array("result" => true, "msg" => "Report has been loaded.", "data" => $zdata));
	    		} else {
	    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => $e));
	    }
	}
	
	public function getActivityLogs ($username, $datefrom, $dateto) {
	    try {
	        $stmt = $this->connect()->prepare("SELECT * FROM audit_trail WHERE username = ? AND (dttransact BETWEEN ? AND ?)");
    	    $stmt->bindValue(1, $username);
            $stmt->bindValue(2, $datefrom);
            $stmt->bindValue(3, $dateto);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Logs has been loaded.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	    
	}
	
	public function getAllUsernames () {
	    $stmt = $this->connect()->query("SELECT username FROM users");
	    $stmt->execute();
	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function insertWaitlist ($fullname, $contactno, $toda) {
	    try {
	        $stmt = $this->connect()->prepare("INSERT INTO tbl_waitinglist (fullname, contactno, toda) VALUES (:fullname, :contactno, :toda)");
    	    $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":contactno", $contactno);
            $stmt->bindParam(":toda", $toda);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Record has been added to waiting list."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function getWaitingList () {
	    try {
	        $stmt = $this->connect()->query("SELECT id, fullname, contactno, toda, status, datereg FROM tbl_waitinglist");
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Waiting List has been loaded.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	    
	}
	
	public function markWaitlist ($id) {
	    try {
	        $stmt = $this->connect()->prepare("UPDATE tbl_waitinglist SET status = 'SATISFIED' WHERE id = :id");
    	    $stmt->bindParam(":id", $id);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Waiting List Record has been updated."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function cancelWaitlist ($id) {
	    try {
	        $stmt = $this->connect()->prepare("UPDATE tbl_waitinglist SET status = 'CANCELLED' WHERE id = :id");
    	    $stmt->bindParam(":id", $id);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Waiting List Record has been updated."));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function savePayencode($trcode, $orno, $type, $data, $ordate, $nname) {
	    try {
	        $stmt = "";
    		$stmt1 = "";
    		switch ($type) {
    			case "NEW":
    			case "RENEW":
    				$stmt = $this->connect()->prepare("SELECT * FROM tbl_application WHERE trcode = ?");
    				$stmt1 = $this->connect()->prepare("UPDATE tbl_application SET tags = 'FOR RELEASING', tagscode = '5', f4  = :orno WHERE trcode = :trcode");
    				break;
    			case "CHANGE MOTOR":
    				$stmt = $this->connect()->prepare("SELECT yr, opercode, newmotorcode AS motorcode FROM tbl_changemotor WHERE trcode = ?");
    				$stmt1 = $this->connect()->prepare("UPDATE tbl_changemotor SET tags = 'FOR RELEASING', tagscode = '5', orno  = :orno, ordate = :ordate WHERE trcode = :trcode");
    				$zxc = date('Y-m-d');
    				$stmt1->bindParam(":ordate", $zxc);
    				break;
    			case "CHANGE OWNERSHIP":
    				$stmt = $this->connect()->prepare("SELECT yr, newopercode AS opercode, motorcode FROM tbl_changeownership WHERE trcode = ?");
    				$stmt1 = $this->connect()->prepare("UPDATE tbl_changeownership SET tags = 'FOR RELEASING', tagscode = '5', orno  = :orno, ordate = :ordate WHERE trcode = :trcode");
    				$zxc = date('Y-m-d');
    				$stmt1->bindParam(":ordate", $zxc);
    				break;
    				case "CHANGE DRIVER":
    				$stmt = $this->connect()->prepare("SELECT yr, newopercode AS opercode, motorcode FROM tbl_changedriver WHERE trcode = ?");
    				$stmt1 = $this->connect()->prepare("UPDATE tbl_changedriver SET tags = 'FOR RELEASING', tagscode = '5', orno  = :orno, ordate = :ordate WHERE trcode = :trcode");
    				$zxc = date('Y-m-d');
    				$stmt1->bindParam(":ordate", $zxc);
    				break;
    			case "DROPPING":
    				$stmt = $this->connect()->prepare("SELECT year AS yr, opercode, motorcode FROM tbl_drop WHERE trcode = ?");
    				$stmt1 = $this->connect()->prepare("UPDATE tbl_drop SET tags = 'FOR RELEASING', tagscode = '5', orno  = :orno, ordate = :ordate WHERE trcode = :trcode");
    				$zxc = date('Y-m-d');
    				$stmt1->bindParam(":ordate", $zxc);
    				break;
    			default:
    				return json_encode(array("result" => false, "msg" => 'Transaction type is invalid.'));
    		}
    		$stmt->bindValue(1, $trcode);
    		$stmt->execute();
    		$data = $stmt->fetch(PDO::FETCH_ASSOC);
    		
    		if ($data['Tags'] == "FOR ASSESSMENT") {
    		    return json_encode(array("result" => false, "msg" => 'Please assess first.'));
    		}
    
    		$stmt1->bindParam(":orno", $orno);
    		$stmt1->bindParam(":trcode", $trcode);
    		$stmt1->execute();
    
    		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
    		$stmt->bindValue(1, $trcode);
    		$stmt->execute();
    		$ass = $stmt->fetchAll();
    
    		foreach ($ass as $key => $value) {
    			if ($value['status'] == "PAID") {
    				return json_encode(array("result" => false, "msg" => "This is PAID already."));
    			}
    		}
    
    		$stmt = $this->connect()->prepare("UPDATE tbl_assessment SET status  = 'PAID', or_number = ?, or_date =  ? WHERE trcode = ?");
    		$stmt->bindValue(1, $orno);
    		$stmt->bindValue(2, $ordate);
    		$stmt->bindValue(3, $trcode);
    		$stmt->execute();
    
    		$stmt = $this->connect()->prepare("SELECT * FROM tbl_assessment WHERE trcode = ?");
    		$stmt->bindValue(1, $trcode);
    		$stmt->execute();
    		$ff = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    		$total = 0;
    
    		foreach ($ff as $key => $value) {
    			$stmt = $this->connect()->prepare("INSERT INTO tbl_payment (trcode,opcode,motorcode,yr, feesid,fessgrpid, dueamt, or_number,or_date,user) VALUES (:trcode,:opcode,:motorcode,:yr, :feesid,:fessgrpid, :dueamt, :or_number,:or_date,:user)");
    			$stmt->bindParam(":trcode", $trcode);
    			$stmt->bindParam(":opcode", $data['opercode']);
    			$stmt->bindParam(":motorcode", $data['motorcode']);
    			$stmt->bindParam(":yr", $data['yr']);
    			$stmt->bindParam(":feesid", $value['feesid']);
    			$stmt->bindParam(":fessgrpid", $value['collnature']);
    			$stmt->bindParam(":dueamt", $value['AmtDue']);
    			$stmt->bindParam(":or_number", $orno);
    			$stmt->bindParam(":or_date", $value["or_date"]);
    			$stmt->bindParam(":user", $_SESSION["username"]);
    			$stmt->execute();
    		}
    		return json_encode(array("result" => true, "msg" => "MTOP payment encoded successfully."));
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
	
	public function searchPayencode($orno) {
	    try {
	        $ordet = $this->conn()->prepare("SELECT payor, orno, ordate FROM acfno51 WHERE orno = :orno AND cancelled = 0");
	        $ordet->bindParam(":orno", $orno);
	        $ordet->execute();
	        
	        $stmt = $this->conn()->prepare("SELECT * FROM acf51det WHERE orno = :orno AND iscancel = 0");
    	    $stmt->bindParam(":orno", $orno);
    	    if ($stmt->execute()) {
    	       return json_encode(array("result" => true, "msg" => "Record has been selected.", "data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "info" => $ordet->fetch(PDO::FETCH_ASSOC)));
    		} else {
    			return json_encode(array("result" => false, "msg" => "Something went wrong!."));
    		} 
	    } catch (PDOException $e) {
	        return json_encode(array("result" => false, "msg" => "Something went wrong."));
	    }
	}
}
?>