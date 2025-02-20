<?php

include_once 'connection.php';
include_once 'class.php';
$object = new myclass;

$page = isset($_GET['var']) ? $_GET['var'] : '';

function is_base64($s) {
    //   return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    
    // Check if there are valid base64 characters
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

    // Decode the string in strict mode and check the results
    $decoded = base64_decode($s, true);
    if(false === $decoded) return false;

    // Encode the string again
    if(base64_encode($decoded) != $s) return false;

    return true;
}

// if ($page == "formigration") {
// 	$object->formigration();
// }

if ($page != "login") {
    $object->islogin();
}

// if ($page == "addrangetoda") {
//     $object->addrangetoda();
// }

if ($page == "login") {
	if (!empty($_POST['si-email']) && !empty($_POST['si-password'])) {
		$acc =  $object->getUser($_POST['si-email'], $_POST['si-password']);
		if ($acc != 'error') {
			echo json_encode(array("result" => true, "msg" => "Login Successful.", "location" => "/admin/dashboard.php"));
		} else {
			echo json_encode(array("result" => false, "msg" => "Please check you username and password."));
		}
	}
} else if ($page == "getuserdet") {
    if (!empty($_POST['id'])) {
        echo json_encode($object->getAitai($_POST['id']));
    } else {
		echo json_encode(array("result" => false, "msg" => "Please check you username and password."));
	}
} else if ($page == "signup") {
	if (!empty($_POST['fullname']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['position'])) {
		echo $object->signUser($_POST['fullname'], $_POST['username'], $_POST['password'], $_POST['position'], (isset($_POST['tfran-application-switch']) ? 1 : 0), (isset($_POST['tfran-view-switch']) ? 1 : 0), (isset($_POST['tfran-inspection-switch']) ? 1 : 0), (isset($_POST['tfran-assessment-switch']) ? 1 : 0), (isset($_POST['tfran-release-switch']) ? 1 : 0), (isset($_POST['tfran-cancel-switch']) ? 1 : 0), (isset($_POST['cm-application-switch']) ? 1 : 0), (isset($_POST['cm-view-switch']) ? 1 : 0), (isset($_POST['cm-inspection-switch']) ? 1 : 0), (isset($_POST['cm-assessment-switch']) ? 1 : 0), (isset($_POST['cm-release-switch']) ? 1 : 0), (isset($_POST['cm-cancel-switch']) ? 1 : 0), (isset($_POST['co-application-switch']) ? 1 : 0), (isset($_POST['co-view-switch']) ? 1 : 0), (isset($_POST['co-inspection-switch']) ? 1 : 0), (isset($_POST['co-assessment-switch']) ? 1 : 0), (isset($_POST['co-release-switch']) ? 1 : 0), (isset($_POST['co-cancel-switch']) ? 1 : 0), (isset($_POST['drop-application-switch']) ? 1 : 0), (isset($_POST['drop-view-switch']) ? 1 : 0), (isset($_POST['drop-inspection-switch']) ? 1 : 0), (isset($_POST['drop-assessment-switch']) ? 1 : 0), (isset($_POST['drop-release-switch']) ? 1 : 0), (isset($_POST['drop-cancel-switch']) ? 1 : 0), (isset($_POST['settings-operator-switch']) ? 1 : 0), (isset($_POST['settings-motor-switch']) ? 1 : 0), (isset($_POST['settings-toda-switch']) ? 1 : 0), (isset($_POST['settings-frantoda-switch']) ? 1 : 0), (isset($_POST['references-requirements-switch']) ? 1 : 0), (isset($_POST['references-assfee-switch']) ? 1 : 0), (isset($_POST['references-signa-switch']) ? 1 : 0), (isset($_POST['references-make-switch']) ? 1 : 0), (isset($_POST['references-lto-switch']) ? 1 : 0), (isset($_POST['report-franchise-switch']) ? 1 : 0), (isset($_POST['report-cm-switch']) ? 1 : 0), (isset($_POST['report-co-switch']) ? 1 : 0), (isset($_POST['report-drop-switch']) ? 1 : 0), (isset($_POST['report-exprdfran-switch']) ? 1 : 0), (isset($_POST['report-collection-switch']) ? 1 : 0), (isset($_POST['report-abstract-switch']) ? 1 : 0), (isset($_POST['tfran-orencode-switch']) ? 1 : 0), (isset($_POST['tfran-appform-switch']) ? 1 : 0), (isset($_POST['cm-orencode-switch']) ? 1 : 0), (isset($_POST['cm-appform-switch']) ? 1 : 0), (isset($_POST['co-orencode-switch']) ? 1 : 0), (isset($_POST['co-appform-switch']) ? 1 : 0), (isset($_POST['drop-orencode-switch']) ? 1 : 0), (isset($_POST['drop-appform-switch']) ? 1 : 0));
	} else {
		echo json_encode(array("result" => false, "msg" => "Something went wrong."));
	}
} else if ($page == "updateuser") {
	if (!empty($_POST['fullname']) && !empty($_POST['username']) && !empty($_POST['position']) && !empty($_POST['id'])) {
		echo $object->updateUser($_POST['fullname'], $_POST['username'], $_POST['position'], (isset($_POST['tfran-application-switch']) ? 1 : 0), (isset($_POST['tfran-view-switch']) ? 1 : 0), (isset($_POST['tfran-inspection-switch']) ? 1 : 0), (isset($_POST['tfran-assessment-switch']) ? 1 : 0), (isset($_POST['tfran-release-switch']) ? 1 : 0), (isset($_POST['tfran-cancel-switch']) ? 1 : 0), (isset($_POST['cm-application-switch']) ? 1 : 0), (isset($_POST['cm-view-switch']) ? 1 : 0), (isset($_POST['cm-inspection-switch']) ? 1 : 0), (isset($_POST['cm-assessment-switch']) ? 1 : 0), (isset($_POST['cm-release-switch']) ? 1 : 0), (isset($_POST['cm-cancel-switch']) ? 1 : 0), (isset($_POST['co-application-switch']) ? 1 : 0), (isset($_POST['co-view-switch']) ? 1 : 0), (isset($_POST['co-inspection-switch']) ? 1 : 0), (isset($_POST['co-assessment-switch']) ? 1 : 0), (isset($_POST['co-release-switch']) ? 1 : 0), (isset($_POST['co-cancel-switch']) ? 1 : 0), (isset($_POST['drop-application-switch']) ? 1 : 0), (isset($_POST['drop-view-switch']) ? 1 : 0), (isset($_POST['drop-inspection-switch']) ? 1 : 0), (isset($_POST['drop-assessment-switch']) ? 1 : 0), (isset($_POST['drop-release-switch']) ? 1 : 0), (isset($_POST['drop-cancel-switch']) ? 1 : 0), (isset($_POST['settings-operator-switch']) ? 1 : 0), (isset($_POST['settings-motor-switch']) ? 1 : 0), (isset($_POST['settings-toda-switch']) ? 1 : 0), (isset($_POST['settings-frantoda-switch']) ? 1 : 0), (isset($_POST['references-requirements-switch']) ? 1 : 0), (isset($_POST['references-assfee-switch']) ? 1 : 0), (isset($_POST['references-signa-switch']) ? 1 : 0), (isset($_POST['references-make-switch']) ? 1 : 0), (isset($_POST['references-lto-switch']) ? 1 : 0), (isset($_POST['report-franchise-switch']) ? 1 : 0), (isset($_POST['report-cm-switch']) ? 1 : 0), (isset($_POST['report-co-switch']) ? 1 : 0), (isset($_POST['report-drop-switch']) ? 1 : 0), (isset($_POST['report-exprdfran-switch']) ? 1 : 0), (isset($_POST['report-collection-switch']) ? 1 : 0), (isset($_POST['report-abstract-switch']) ? 1 : 0), (isset($_POST['tfran-orencode-switch']) ? 1 : 0), (isset($_POST['tfran-appform-switch']) ? 1 : 0), (isset($_POST['cm-orencode-switch']) ? 1 : 0), (isset($_POST['cm-appform-switch']) ? 1 : 0), (isset($_POST['co-orencode-switch']) ? 1 : 0), (isset($_POST['co-appform-switch']) ? 1 : 0), (isset($_POST['drop-orencode-switch']) ? 1 : 0), (isset($_POST['drop-appform-switch']) ? 1 : 0), $_POST['id']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Something went wrong."));
	}
} else if ($page == "checkavail") {
	if (!empty($_POST['checkin']) && !empty($_POST['checkout'])) {
		echo $object->checkAvail($_POST['checkin'], $_POST['checkout']);
	}
} else if ($page == "getblocks") {
	echo $object->getBlocks();
} else if ($page == "getdashcount") { 
    echo $object->dashboardcount();
} else if ($page == "getoperators") {
	echo $object->getOperators();
} else if ($page == "getstatus") {
	echo $object->getStatus();
}
else if ($page == "getdetstatus") {
	if (!empty($_POST['code'])) {
		echo $object->getdetStatus($_POST['code']);
	}
} else if ($page == "getdetoperator") {
	if (!empty($_POST['code'])) {
		echo $object->getdetOperator($_POST['code']);
	}
} else if ($page == "insertoperator") {
	if (!empty($_POST['firstname'])) {
		$target_path = "";
		$newname = "";
		
	
	    if (is_base64($_POST['hiddenimage']) == 1) {
	        if (!empty($_FILES) && is_uploaded_file($_FILES['oper-img']['tmp_name'])) {
    			if (!empty($_POST['hiddenimage'])) {
    				if (file_exists("../admin/images/" . $_POST['hiddenimage'])) {
    					unlink("../admin/images/" . $_POST['hiddenimage']);
    				}
    			}
    			$source_path = $_FILES['oper-img']['tmp_name'];
    			$imgname = $_FILES['oper-img']['name'];
    			$target_path = 'images/' . $imgname;
    			move_uploaded_file($source_path, "../admin/" . $target_path);
    			$newname = md5(date("Y-m-d hh:mm:ss") . rand()) . substr($imgname, -4);
    			rename("../admin/" . $target_path, "../admin/images/" . $newname);
    			$target_path = 'images/' . $newname;
    		} else {
    		    if (!empty($_POST['hiddenimage'])) {
    		        $target_path = "images/" . $_POST['hiddenimage'];   
    		    }
    			$newname = $_POST['hiddenimage'];
    		}
	    } else {
	        $imgp = explode(";base64", $_POST['hiddenimage']);
	        $data = base64_decode($imgp[1]);
	        $newname = md5(date("Y-m-d hh:mm:ss") . rand()) . ".png";
	        $target_path = 'images/' . $newname;
	        file_put_contents('../admin/images/'.$newname, $data);
	    }
		
// 		if ($_POST['age'] < 18) {
// 		    echo json_encode(array("result" => false, "msg" => "Underage is not viable to apply tricycle franchise."));
// 		    return;
// 		}

	    if(!preg_match('/^[0]+[9]+[0-9]{2}+-+[0-9]{3}+-+[0-9]{4}/', $_POST['contact'])) {
			echo json_encode(array("result" => false, "msg" => "Invalid Contact # must be (09XX-XXX-XXX)"));
			return;
		}
		
		if ($_POST['contact'] == "" || strlen($_POST['contact']) != 13) {
		    echo json_encode(array("result" => false, "msg" => "Contact # is required."));
		    return;
		}

		echo $object->insertOperator($_POST['firstname'], $_POST['midinit'], $_POST['lastname'], $_POST['ext_name'], $_POST['bday'], $_POST['age'], $_POST['gender'], $_POST['civstats'], $_POST['hse'], $_POST['st'], $_POST['subd'], $_POST['brgy'], $_POST['brgydesc'], $_POST['mun'], $_POST['mundesc'], $_POST['prov'], $_POST['provdesc'], $_POST['region'], $_POST['regiondesc'], $_POST['drivlic'], $_POST['drivissue'], $_POST['drivplace'], $_POST['contact'], $_POST['ctc'], $_POST['ctcissue'], $_POST['ctcplace'], $_POST['emername'], $_POST['emercontact'], $_POST['emeraddr'], $_POST['remarks'], $target_path, $newname, $_POST['cin'], $_POST['occupation']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Empty fields detected. Please fill up the form correctly."));
	}
} else if ($page == "getopmotor") {
	if (!empty($_POST['code'])) {
		echo $object->getopMotor($_POST['code']);
	}
} else if ($page == "getmotor") {
	echo $object->getMotor();
} else if ($page == "getdetmotor") {
	if (!empty($_POST['motorid'])) {
		echo $object->getdetMotor($_POST['motorid']);
	}
} else if ($page == "updateoperator") {
	if (!empty($_POST['firstname']) && !empty($_GET['opercode'])) {
		$target_path = "";
		$newname = "";
		if (is_base64($_POST['hiddenimage']) == 1) {
	        if (!empty($_FILES) && is_uploaded_file($_FILES['oper-img']['tmp_name'])) {
    			if (!empty($_POST['hiddenimage'])) {
    				if (file_exists("../admin/images/" . $_POST['hiddenimage'])) {
    					unlink("../admin/images/" . $_POST['hiddenimage']);
    				}
    			}
    			$source_path = $_FILES['oper-img']['tmp_name'];
    			$imgname = $_FILES['oper-img']['name'];
    			$target_path = 'images/' . $imgname;
    			move_uploaded_file($source_path, "../admin/" . $target_path);
    			$newname = md5(date("Y-m-d hh:mm:ss") . rand()) . substr($imgname, -4);
    			rename("../admin/" . $target_path, "../admin/images/" . $newname);
    			$target_path = 'images/' . $newname;
    		} else {
    		    if (!empty($_POST['hiddenimage'])) {
    		        $target_path = "images/" . $_POST['hiddenimage'];   
    		    }
    			$newname = $_POST['hiddenimage'];
    		}
	    } else {
	        $imgp = explode(";base64", $_POST['hiddenimage']);
	        $data = base64_decode($imgp[1]);
	        $newname = md5(date("Y-m-d hh:mm:ss") . rand()) . ".png";
	        $target_path = 'images/' . $newname;
	        file_put_contents('../admin/images/'.$newname, $data);
	    }
		
// 		if ($_POST['age'] < 18) {
// 		    echo json_encode(array("result" => false, "msg" => "Underage is not viable to apply tricycle franchise."));
// 		    return;
// 		}
		
		if(!preg_match('/^[0]+[9]+[0-9]{2}+-+[0-9]{3}+-+[0-9]{4}/', $_POST['contact'])) {
			echo json_encode(array("result" => false, "msg" => "Invalid Contact # must be (09XX-XXX-XXX)"));
			return;
		}

		if ($_POST['contact'] == "" || strlen($_POST['contact']) != 13) {
		    echo json_encode(array("result" => false, "msg" => "Contact # is required."));
		    return;
		}

		echo $object->updateOperator($_POST['firstname'], $_POST['midinit'], $_POST['lastname'], $_POST['ext_name'], $_POST['bday'], $_POST['age'], $_POST['gender'], $_POST['civstats'], $_POST['hse'], $_POST['st'], $_POST['subd'], $_POST['brgy'], $_POST['brgydesc'], $_POST['mun'], $_POST['mundesc'], $_POST['prov'], $_POST['provdesc'], $_POST['region'], $_POST['regiondesc'], $_POST['drivlic'], $_POST['drivissue'], $_POST['drivplace'], $_POST['contact'], $_POST['ctc'], $_POST['ctcissue'], $_POST['ctcplace'], $_POST['emername'], $_POST['emercontact'], $_POST['emeraddr'], $_POST['remarks'], $target_path, $newname, $_GET['opercode'], $_POST['cin'], $_POST['occupation']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
}   else if ($page == "submitfranchise") {
	if (!empty($_POST['opcode']) && !empty($_POST['motorid']) && !empty($_POST['drivercode']) && !empty($_POST['yr']) && !empty($_POST['applstatus'])) {
		echo $object->submitFranchise($_POST['opcode'], $_POST['motorid'], $_POST['yr'], $_POST['applstatus'], $_POST['drivercode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "submitchangemotor") {
	if (!empty($_POST['opcode']) && !empty($_POST['motorid']) && !empty($_POST['motorid-new']) && !empty($_POST['newopcode']) && !empty($_POST['yr'])) {
		echo $object->submitChangeMotor($_POST['opcode'], $_POST['motorid'], $_POST['motorid-new'], $_POST['yr'], $_POST['drivercode'], $_POST['remarks'], $_POST['newopcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "submitchangeownership") {
	if (!empty($_POST['opcode']) && !empty($_POST['motorid']) && !empty($_POST['newopcode']) && !empty($_POST['yr'])) {
		echo $object->submitChangeOwnership($_POST['opcode'], $_POST['motorid'], $_POST['newopcode'], $_POST['yr'], $_POST['drivercode'], $_POST['remarks']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
}else if ($page == "submitchangedriver") {
	if (!empty($_POST['opcode']) && !empty($_POST['motorid']) && !empty($_POST['newopcode']) && !empty($_POST['yr'])) {
		echo $object->submitChangeDriver($_POST['opcode'], $_POST['motorid'], $_POST['newopcode'], $_POST['yr'], $_POST['drivercode'], $_POST['remarks']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "submitdriverpermit") {
	if (!empty($_POST['opcode']) && !empty($_POST['opmotor']) && !empty($_POST['drivercode']) && !empty($_POST['yr']) && !empty($_POST['tdpexpdt'])) {
		echo $object->submitDriverPermit($_POST['opcode'], $_POST['opmotor'], $_POST['yr'], $_POST['drivercode'], $_POST['tdpexpdt']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "getfranchise") {
	echo $object->getFranchise($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"], $_GET['search']['value']);
} else if ($page == "getdetfranchise") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetFranchise($_POST['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "No Franchise Found."));
	}
} else if ($page == "saveassessment") {
	if (!empty($_POST['spay']) && !empty($_POST['trcode'])) {
		echo $object->saveAssessment($_POST['spay'], $_POST['trcode'], $_POST['spay'][0]['trans']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Opps.. Something went wrong."));
	}
} else if ($page == "getdetassrelease") {
	if (!empty($_POST['trcode']) && !empty($_POST['trans'])) {
		echo $object->getdetAssRelease($_POST['trcode'], $_POST['trans']);
	}
} else if ($page == "saverelease") {
	if (!empty($_POST['mtp']) && !empty($_POST['mtpdt']) && !empty($_POST['dtexp']) && !empty($_POST['trcode']) && !empty($_POST['trans'])) {
		echo $object->saveRelease($_POST['mtp'], $_POST['mtpdt'], $_POST['dtexp'], $_POST['trcode'], $_POST['trans'], $_POST['mmtop']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Something is missing please check required fields. <br>(Payment, Franchise #, Franchise Date, Expiration Date)"));
	}
} else if ($page == "savetdprelease") {
	if (!empty($_POST['tdpno']) && !empty($_POST['tdpexp']) && !empty($_POST['reldt']) && !empty($_POST['trcode'])) {
		echo $object->saveTDPRelease($_POST['tdpno'], $_POST['tdpexp'], $_POST['reldt'], $_POST['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "This is not PAID at all."));
	}
} else if ($page == "getdrop") {
	echo $object->getDrop($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"]);
} else if ($page == "getdroplist") {
	echo $object->getDropList();
} else if ($page == "getdrivers") {
	echo $object->getDrivers();
} else if ($page == "getdetdriver") {
	if (!empty($_POST['code'])) {
		echo $object->getdetDriver($_POST['code']);
	}
} else if ($page == "insertdriver") {
	if (!empty($_POST['dlastname'])) {
		$target_path = "";
		$newname = "";
		
		if (is_base64($_POST['drhiddenimage']) == 1) {
	        if (!empty($_FILES) && is_uploaded_file($_FILES['driver-img']['tmp_name'])) {
    			if (!empty($_POST['drhiddenimage'])) {
    				if (file_exists("../admin/images/" . $_POST['drhiddenimage'])) {
    					unlink("../admin/images/" . $_POST['dhiddenimage']);
    				}
    			}
    			$source_path = $_FILES['driver-img']['tmp_name'];
    			$target_path = 'images/' . $_FILES['driver-img']['name'];
    			$imgname = $_FILES['driver-img']['name'];
    			move_uploaded_file($source_path, "../admin/" . $target_path);
    			$newname = md5(date("Y-m-d hh:mm:ss") . rand()) . substr($imgname, -4);
    			rename("../admin/" . $target_path, "../admin/images/" . $newname);
    			$target_path = 'images/' . $newname;
    		} else {
    			if (!empty($_POST['drhiddenimage'])) {
    			    $target_path = "images/" . $_POST['drhiddenimage'];
    			}
    			$newname = $_POST['drhiddenimage'];
    		}
	    } else {
	        $imgp = explode(";base64", $_POST['drhiddenimage']);
	        $data = base64_decode($_POST['drhiddenimage']);
	        $newname = md5(date("Y-m-d hh:mm:ss") . rand()) . ".png";
	        $target_path = 'images/' . $newname;
	        file_put_contents('../admin/images/'.$newname, $data);
	    }
		
// 		if ($_POST['dage'] < 18) {
// 		    echo json_encode(array("result" => false, "msg" => "Underage is not viable to apply tricycle franchise."));
// 		    return;
// 		}

	    if(!preg_match('/^[0]+[9]+[0-9]{2}+-+[0-9]{3}+-+[0-9]{4}/', $_POST['dcontact'])) {
			echo json_encode(array("result" => false, "msg" => "Invalid Contact # must be (09XX-XXX-XXX)"));
			return;
		}
		
		if ($_POST['dcontact'] == "" || strlen($_POST['dcontact']) != 13) {
		    echo json_encode(array("result" => false, "msg" => "Contact # is required."));
		    return;
		}

		echo $object->insertDriver($_POST['dfirstname'], $_POST['dmidinit'], $_POST['dlastname'], $_POST['dextname'], $_POST['dbday'], $_POST['dage'], $_POST['dgender'], $_POST['dcivstats'], $_POST['dhse'], $_POST['dst'], $_POST['dsubd'], $_POST['dbrgy'], $_POST['dbrgydesc'], $_POST['dmun'], $_POST['dmundesc'], $_POST['dprov'], $_POST['dprovdesc'], $_POST['dregion'], $_POST['dregiondesc'], $_POST['ddrivlic'], $_POST['ddrivissue'], $_POST['ddrivplace'], $_POST['dcontact'], $_POST['dctc'], $_POST['dctcissue'], $_POST['dctcplace'], $_POST['demername'], $_POST['demercontact'], $_POST['demeraddr'], $_POST['dremarks'], $target_path, $newname, $_POST['dcin']);
	}
} else if ($page == "updatedriver") {
	if (!empty($_POST['dfirstname']) && !empty($_GET['drivercode'])) {
		$target_path = "";
		$newname = "";
		if(is_base64($_POST['drhiddenimage']) == 1) {
	        if (!empty($_FILES) && is_uploaded_file($_FILES['driver-img']['tmp_name'])) {
    			if (!empty($_POST['drhiddenimage'])) {
    				if (file_exists("../admin/images/" . $_POST['drhiddenimage'])) {
    					unlink("../admin/images/" . $_POST['dhiddenimage']);
    				}
    			}
    			$source_path = $_FILES['driver-img']['tmp_name'];
    			$target_path = 'images/' . $_FILES['driver-img']['name'];
    			$imgname = $_FILES['driver-img']['name'];
    			move_uploaded_file($source_path, "../admin/" . $target_path);
    			$newname = md5(date("Y-m-d hh:mm:ss") . rand()) . substr($imgname, -4);
    			rename("../admin/" . $target_path, "../admin/images/" . $newname);
    			$target_path = 'images/' . $newname;
    		} else {
    			if (!empty($_POST['drhiddenimage'])) {
    			    $target_path = "images/" . $_POST['drhiddenimage'];
    			}
    			$newname = $_POST['drhiddenimage'];
    		}
	    } else {
	        $imgp = explode(";base64", $_POST['drhiddenimage']);
	        $data = base64_decode($_POST['drhiddenimage']);
	        $newname = md5(date("Y-m-d hh:mm:ss") . rand()) . ".png";
	        $target_path = 'images/' . $newname;
	        file_put_contents('../admin/images/'.$newname, $data);
	    }
		
// 		if ($_POST['dage'] < 18) {
// 		    echo json_encode(array("result" => false, "msg" => "Underage is not viable to apply tricycle franchise."));
// 		    return;
// 		}

	    if(!preg_match('/^[0]+[9]+[0-9]{2}+-+[0-9]{3}+-+[0-9]{4}/', $_POST['dcontact'])) {
			echo json_encode(array("result" => false, "msg" => "Invalid Contact # must be (09XX-XXX-XXX)"));
			return;
		}
		
		if ($_POST['dcontact'] == "" || strlen($_POST['dcontact']) != 13) {
		    echo json_encode(array("result" => false, "msg" => "Contact # is required."));
		    return;
		}

		echo $object->updateDriver($_GET['drivercode'], $_POST['dfirstname'], $_POST['dmidinit'], $_POST['dlastname'], $_POST['dextname'], $_POST['dbday'], $_POST['dage'], $_POST['dgender'], $_POST['dcivstats'], $_POST['dhse'], $_POST['dst'], $_POST['dsubd'], $_POST['dbrgy'], $_POST['dbrgydesc'], $_POST['dmun'], $_POST['dmundesc'], $_POST['dprov'], $_POST['dprovdesc'], $_POST['dregion'], $_POST['dregiondesc'], $_POST['ddrivlic'], $_POST['ddrivissue'], $_POST['ddrivplace'], $_POST['dcontact'], $_POST['dctc'], $_POST['dctcissue'], $_POST['dctcplace'], $_POST['demername'], $_POST['demercontact'], $_POST['demeraddr'], $_POST['dremarks'], $target_path, $newname, $_POST['dcin']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "getdetdrop") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetDrop($_POST['trcode']);
	}
} else if ($page == "submitdrop") {
	if (!empty($_POST['motorid']) && !empty($_POST['opcode']) && !empty($_POST['drivercode']) && !empty($_POST['reason']) && !empty($_POST['yr'])) {
		echo $object->submitDrop($_POST['motorid'], $_POST['opcode'], $_POST['drivercode'], $_POST['reason'], $_POST['yr'], $_POST['franchiseno'], $_POST['remarks']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "getdetdropassrelease") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetDropAssRelease($_POST['trcode']);
	}
} else if ($page == "savedroprelease") {
	if (!empty($_POST['trcode'])) {
		echo $object->saveDropRelease($_POST['trcode']);
	}
} else if ($page == "getcountapptodas") {
	if (!empty($_POST['yr'])) {
		echo $object->getCountAppTodas($_POST['yr']);
	}
} else if ($page == "getassfees") {
	if (!empty($_GET['type']) & !empty($_GET['code'])) {
		echo $object->getAssFees($_GET['type'], $_GET['code']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Something went missing."));
	}
} else if ($page == "getcurassfees") {
	if (!empty($_GET['trcode'])) {
		echo $object->getCurAssFees($_GET['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Something went missing."));
	}
} else if ($page == "saveornorelease") {
	if (!empty($_POST['trcode']) && !empty($_POST['orno']) && !empty($_POST['ordate'])) {
		echo $object->SaveORnoRelease($_POST['trcode'], $_POST['orno'], $_POST['ordate']);
	} else {
		echo json_encode(array("result" => false, "msg" => "This is not PAID at all."));
	}
} else if ($page == "savedropornorelease") {
	if (!empty($_POST['trcode']) && !empty($_POST['orno']) && !empty($_POST['ordate'])) {
		echo $object->SaveDropORnoRelease($_POST['trcode'], $_POST['orno'], $_POST['ordate']);
	} else {
		echo json_encode(array("result" => false, "msg" => "This is not PAID at all."));
	}
} else if ($page == "savemotor") {
// 	if (!empty($_POST['mopcode']) && !empty($_POST['mtoda']) && !empty($_POST['mmake']) && !empty($_POST['mengine']) && !empty($_POST['mchassis']) && !empty($_POST['myrmodel']) && !empty($_POST['mcolor']) && !empty($_POST['mcert']) && !empty($_POST['mdtissue']) && !empty($_POST['mplate']) && !empty($_POST['magency']) && !empty($_POST['mremarks']) && !empty($_POST['mplatecolor']) && !empty($_POST['mmvno']) && !empty($_POST['morcrname'])) {
	if (!empty($_POST['mopcode']) && !empty($_POST['mtoda']) && !empty($_POST['mmake']) && !empty($_POST['mengine']) && !empty($_POST['mchassis']) && !empty($_POST['mcert']) && !empty($_POST['mplate']) && !empty($_POST['mmvno']) && !empty($_POST['morcr']) && !empty($_POST['morcrdate'])) {	
		echo $object->saveMotor($_POST['mopcode'], "", $_POST['mtoda'], $_POST['mmake'], $_POST['mengine'], $_POST['mchassis'], $_POST['myrmodel'], $_POST['mcolor'], $_POST['mcert'], $_POST['mdtissue'], $_POST['mplate'], $_POST['magency'], $_POST['mremarks'], $_POST['mplatecolor'], $_POST['mmvno'], (isset($_POST['inspect-stoplight-switch']) ? 'on' : 'off'), $_POST['morcrname'], $_POST['morcr'], $_POST['morcrdate'], $_POST['mmunplateno']);//, $_POST['mmunplateno'])
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "deleteoperator") {
	if (!empty($_POST['opcode']) && !empty($_POST['reason']) && !empty($_POST['auth'])) {
		echo $object->DeleteOperator($_POST['opcode'], $_POST['reason'], $_POST['auth']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "deletedriver") {
	if (!empty($_POST['opcode']) && !empty($_POST['reason']) && !empty($_POST['auth'])) {
		echo $object->DeleteDriver($_POST['opcode'], $_POST['reason'], $_POST['auth']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "deletemotor") {
	if (!empty($_POST['opcode']) && !empty($_POST['reason']) && !empty($_POST['auth'])) {
		echo $object->DeleteMotor($_POST['opcode'], $_POST['reason'], $_POST['auth']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Please fill up the form correctly."));
	}
} else if ($page == "updatemotor") {
	if (!empty($_POST['mid']) && !empty($_POST['mopcode']) && !empty($_POST['mtoda']) && !empty($_POST['mmake']) && !empty($_POST['mengine']) && !empty($_POST['mchassis']) && !empty($_POST['mcert']) && !empty($_POST['mplate']) && !empty($_POST['mmvno']) && !empty($_POST['morcr']) && !empty($_POST['morcrdate']))  {
		echo $object->updateMotor($_POST['mid'], $_POST['mopcode'], "", $_POST['mtoda'], $_POST['mmake'], $_POST['mengine'], $_POST['mchassis'], $_POST['myrmodel'], $_POST['mcolor'], $_POST['mcert'], $_POST['mdtissue'], $_POST['mplate'], $_POST['magency'], $_POST['mremarks'], $_POST['mplatecolor'], $_POST['mmvno'], (isset($_POST['inspect-stoplight-switch']) ? 'on' : 'off'), $_POST['morcrname'], $_POST['morcr'], $_POST['morcrdate'], $_POST['mmunplateno'], $_POST['mmtop']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Something is missing!'));
	}
} else if ($page == "getalltodadetails") {
	echo $object->getAllTodaDetails();
} else if ($page == "getdettoda") {
	if (!empty($_POST['tcode'])) {
		echo $object->getdetToda($_POST['tcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'No Toda to select.'));
	}
} else if ($page == "savetoda") {
	if (!empty($_POST['tcode']) && !empty($_POST['troute'])) {
		echo $object->saveToda($_POST['tcode'], $_POST['troute'], $_POST['tremarks'], $_POST['tpres'], $_POST['tcontactno'], $_POST['ttest']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected. Please fill out Toda Code and Toda Route.'));
	}
} else if ($page == "updatetoda") {
	if (!empty($_POST['tid']) && !empty($_POST['tcode'])) {
		echo $object->updateToda($_POST['tid'], $_POST['tcode'], $_POST['troute'], $_POST['tremarks'], $_POST['tpres'], $_POST['tcontactno'], $_POST['ttest']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected. Please fill out Toda Code.'));
	}
} else if ($page == "updatestatus") {
    if (!empty($_POST['stags']) && !empty($_POST['status-id'])) {
        echo $object->updateStatus($_POST['stags'], $_POST['status-id']);
    }
}else if ($page == "deletetoda") {
	if (!empty($_POST['todaid'])) {
		echo $object->deleteToda($_POST['todaid']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Select a TODA in order to use the delete button.'));
	}
} else if ($page == "getmasterlistfran") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getMasterListFranchise($_POST['toda'], $_POST['from'], $_POST['to'], $_POST['year']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Select a TODA in order to display the report.', "data" => []));
	}
} else if ($page == "getchangemotorreport") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getChangeMotorReport($_POST['toda'], $_POST['from'], $_POST['to'], $_POST['year']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Select a TODA in order to display the report.', "data" => []));
	}
} else if ($page == "getchangeownershipreport") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getChangeOwnershipReport($_POST['toda'], $_POST['from'], $_POST['to'], $_POST['year']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Select a TODA in order to display the report.', "data" => []));
	}
} else if ($page == "getdriverspermit") {
	echo $object->getDriversPermit($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"], $_GET['search']['value']);
} else if ($page == "getdetdriverspermit") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetDriverPermit($_POST['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => "No Driver's Permit Found."));
	}
} else if ($page == "getsignatories") {
	echo $object->getSignatories();
} else if ($page == "getfees") {
	echo $object->getFees($_GET["category"]);
} else if ($page == "getfeesoption") {
	echo $object->getFeesOption();
} else if ($page == "updatefees") {
	if (!empty($_POST['fees-option']) && !empty($_POST['fees-amount']) && !empty($_POST['fees-category']) && !empty($_POST['fees-id'])) {
		echo $object->updateFees($_POST["fees-option"], $_POST["fees-amount"], $_POST['fees-category'], $_POST['fees-id']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "savesignatories") {
	if (!empty($_POST['signa-fullname']) && !empty($_POST['signa-position'])) {
		echo $object->saveSignatories($_POST['signa-fullname'], $_POST['signa-position']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
	}
} else if ($page == "updatesignatories") {
	if (!empty($_POST['signa-fullname']) && !empty($_POST['signa-position'])) {
		echo $object->updateSignatories($_POST['signa-id'], $_POST['signa-fullname'], $_POST['signa-position']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Don't panic just call the administrator."));
	}
} else if ($page == "getdetsignatories") {
	if (!empty($_POST['id'])) {
		echo $object->getdetSignatories($_POST['id']);
	} else {
		echo json_encode(array("result" => false, "msg" => "Information not found."));
	}
} else if ($page == "getmasterlisttdp") {
	if (!empty($_POST['toda']) && !empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getMasterListTDP($_POST['toda'], $_POST['from'], $_POST['to'], $_POST['year']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Select a TODA in order to display the report.', "data" => []));
	}
} else if ($page == "getexpiringtdp") {
	echo $object->getExpiringTDP();
} else if ($page == "getexpiredfranchise") {
	if (!empty($_POST['toda'])) {
		echo $object->getExpiredFranchise($_POST['toda'], "");
	} else {
		echo json_encode(array("result" => false, "msg" => "Information not found.", "data" => []));
	}
} else if ($page == "getexpiringfranchise") {
	if (!empty($_POST['toda']) && !empty($_POST['from'])) {
		echo $object->getExpiringFranchise($_POST['toda'], $_POST['from'], "");
	} else {
		echo json_encode(array("result" => false, "msg" => "Information not found.", "data" => []));
	}
} else if ($page == "getmasterlistdrop") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getMasterListDrop($_POST['toda'], $_POST['from'], $_POST['to']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.', "data" => []));
	}
} else if ($page == "getreportcollection") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getReportCollection($_POST['from'], $_POST['to']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.', "data" => []));
	}
} else if ($page == "getrecentapplication") {
	echo $object->getRecentApplication();
} else if ($page == "getallusers") {
	echo $object->getAllUsers();
} else if ($page == "getoperatorhistory") {
	if (!empty($_POST['code'])) {
		echo $object->getOperatorHistory($_POST['code']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.'));
	}
} else if ($page == "cancelfranchise") {
	if (!empty($_POST['trcode']) && !empty($_POST['reason']) && !empty($_POST['auth'])) {
		echo $object->cancelFranchise($_POST['trcode'], $_POST['reason'], $_POST['auth']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "canceldropping") {
	if (!empty($_POST['trcode']) && !empty($_POST['reason']) && !empty($_POST['auth'])) {
		echo $object->cancelDrop($_POST['trcode'], $_POST['reason'], $_POST['auth']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "getreportabstract") {
	if (!empty($_POST['from']) && !empty($_POST['to'])) {
		echo $object->getReportAbstract($_POST['from'], $_POST['to']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.', "data" => []));
	}
} else if ($page == "getapprovepersonel") {
	echo $object->getApprovePersonel();
} else if ($page == "getassforprint") {
	if (!empty($_POST['type']) && !empty($_POST['trcode'])) {
		echo $object->getAssforPrint($_POST['type'], $_POST['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.'));
	}
} else if ($page == "getpermitdetails") {
	if (!empty($_POST['trcode']) && !empty($_POST['trans'])) {
		echo $object->getPermitDetails($_POST['trcode'], $_POST['trans']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Information not found.'));
	}
} else if ($page == "getallrequirements") {
	echo $object->getAllRequirements($_GET["category"]);
} else if ($page == "updatereq") {
	if (!empty($_POST['req-desc']) && !empty($_POST['req-cat']) && !empty($_POST['req-id'])) {
		echo $object->updateReq($_POST["req-desc"], $_POST["req-cat"], $_POST['req-id']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "savefees") {
	if (!empty($_POST['fees-option']) && !empty($_POST['fees-amount']) && !empty($_POST['fees-category'])) {
		echo $object->saveFees($_POST["fees-option"], $_POST["fees-amount"], $_POST['fees-category']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "savereq") {
	if (!empty($_POST['req-desc']) && !empty($_POST['req-cat'])) {
		echo $object->saveReq($_POST["req-desc"], $_POST["req-cat"]);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "getfranexpdate") {
	echo $object->getFranExpDate();
} else if ($page == "updatefranexpdate") {
    if ((!empty($_POST['fran-exp']) && $_POST['fran-exp'] != 0) && isset($_POST['exp-mode'])) {
        echo $object->updateFranExpDate($_POST['fran-exp'], $_POST['exp-mode']);
    } else {
        echo json_encode(array("result" => false, "msg" => "Empty field detected."));
    }
} else if ($page == "gettodaoption") {
	echo $object->getTodaOption();
} else if ($page == "getreqapplication") {
	if (!empty($_GET['trcode']) && !empty($_GET['apptype'])) {
		echo $object->getReqApplication($_GET['trcode'], $_GET['apptype']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Cannot load sorry.', "data" => []));
	}
} else if ($page == "getdetinspection") {
	if (!empty($_GET['trcode'])) {
		echo $object->getdetInspection($_GET['trcode']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Cannot load sorry.'));
	}
} else if ($page == "saveinspection") {
	if (!empty($_POST['inspect-trcode']) && !empty($_POST['opcode']) && !empty($_POST['motorid'])) {
		echo $object->submitInspection($_POST['inspect-trcode'], $_POST['opcode'], $_POST['motorid'], $_POST['inspect-toda'], $_POST['inspect-make'], $_POST['inspect-engine'], $_POST['inspect-chassis'], $_POST['inspect-bodyno'], $_POST['inspect-plateno'], $_POST['inspect-fuel'], $_POST['inspect-model'], $_POST['inspect-yearacquired'], (isset($_POST['inspect-headlight-switch']) ? 'on' : 'off'), $_POST['inspect-headlight'], (isset($_POST['inspect-signallight-switch']) ? 'on' : 'off'), $_POST['inspect-signallight'], (isset($_POST['inspect-stoplight-switch']) ? 'on' : 'off'), $_POST['inspect-stoplight'], (isset($_POST['inspect-handfootbrake-switch']) ? 'on' : 'off'), $_POST['inspect-handfootbrake'], (isset($_POST['inspect-lightinsidecar-switch']) ? 'on' : 'off'), $_POST['inspect-lightinsidecar'], (isset($_POST['inspect-trashcan-switch']) ? 'on' : 'off'), $_POST['inspect-trashcan'], (isset($_POST['inspect-plate-switch']) ? 'on' : 'off'), $_POST['inspect-plate'], (isset($_POST['inspect-drivlis-switch']) ? 'on' : 'off'), $_POST['inspect-drivlis'], $_POST['inspect-stencil1'], $_POST['inspect-stencil2'], '', $_POST['appl_status']);
	} else {
		echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
	}
} else if ($page == "uploadrequirements") {
	$target_path = "";
	$newname = "";
	if (!empty($_FILES) && is_uploaded_file($_FILES['req-img']['tmp_name'])) {
		if (!empty($_POST['imgname'])) {
			if (file_exists("../admin/req/" . $_POST['imgname'])) {
				unlink("../admin/req/" . $_POST['imgname']);
			}
		}
		$source_path = $_FILES['req-img']['tmp_name'];
		$target_path = 'req/' . $_FILES['req-img']['name'];
		$imgname = $_FILES['req-img']['name'];
		move_uploaded_file($source_path, "../admin/" . $target_path);
		$newname = md5(date("Y-m-d hh:mm:ss") . rand()) . substr($imgname, -4);
		rename("../admin/" . $target_path, "../admin/req/" . $newname);
		$target_path = 'req/' . $newname;
	} else {
		$target_path = "req/" . $_POST['imgname'];
		$newname = $_POST['imgname'];
	}

	echo $object->uploadRequirements($_POST['trcode'], $_POST['reqid'], $_POST['reqdesc'], $target_path, $newname);
} else if ($page == "getchangemotor") {
	echo $object->getChangeMotor($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"], $_GET['search']['value']);
} else if ($page == "getdetcminitialmotor") {
	if (!empty($_POST['motor'])) {
		echo $object->getdetCMinitialMotor($_POST['motor']);
	}
}else if ($page == "getdetcminitialmotors") {
	if (!empty($_POST['motor'])) {
		echo $object->getdetCMinitialMotors($_POST['motor']);
	}
} else if ($page == "getdetchangemotor") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetChangeMotor($_POST['trcode']);
	}
} else if ($page == "getchangeownership") {
	echo $object->getChangeOwnership($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"], $_GET['search']['value']);
}else if ($page == "getchangedriver") {
	echo $object->getChangeDriver($_GET['yr'], str_replace(array('^', '$'), '', $_GET["columns"]['2']['search']['value']), (int)$_GET['start'], (int)$_GET['length'], $_GET["columns"][$_GET['order'][0]["column"]]["data"], $_GET['order'][0]["dir"], $_GET['search']['value']);
} else if ($page == "getdetchangeownership") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetChangeOwnership($_POST['trcode']);
	}
} else if ($page == "getdetchangedriver") {
	if (!empty($_POST['trcode'])) {
		echo $object->getdetChangeDriver($_POST['trcode']);
	}
}  else if ($page == "verifyctc") {
    if (!empty($_POST['ctc'])) {
        echo $object->verifyCTC($_POST['ctc']);
    } else {
        echo json_encode(array("result" => false, "msg" => 'Empty field detected.'));
    }
} else if ($page == "getmake") {
    echo json_encode(array("data" => $object->motorMakeOption()));
} else if ($page == "getavailtoda") {
    echo $object->getAvailToda($_POST['toda']);
} else if ($page == "getlto") {
    echo json_encode(array("data" => $object->ltoOption()));
} else if ($page == "gettodaperfran") {
    echo $object->getTODAperFran();
} else if ($page == "getexpfran") {
    echo $object->getExpFran();
} else if ($page == "getdashfrandet") {
    echo $object->getDashFranDet($_POST['trcode']);
} else if ($page == "savemake") {
    if (!empty($_POST['make-description'])) {
        echo $object->saveMake($_POST['make-description']);
    }
} else if ($page == "updatemake") {
    if (!empty($_POST['make-description']) && !empty($_POST['make-id'])) {
        echo $object->updateMake($_POST['make-description'], $_POST['make-id']);
    }
} else if ($page == "savelto") {
    if (!empty($_POST['lto-loc'])) {
        echo $object->saveLTO($_POST['lto-loc']);
    }
} else if ($page == "updatelto") {
    if (!empty($_POST['lto-loc']) && !empty($_POST['lto-id'])) {
        echo $object->updateLTO($_POST['lto-loc'], $_POST['lto-id']);
    }
} else if ($page == "getresidencyrummaryreport") {
        echo $object->getResidencySummaryReport();
} else if ($page == "getactivitylogs") {
    if (!empty($_POST['user']) && !empty($_POST['from']) && !empty($_POST['to'])) {
        echo $object->getActivityLogs($_POST['user'], $_POST['from'], $_POST['to']);
    } else {
        echo json_encode(array("result" => false, "msg" => 'Please select user.', "data" => []));
    }
} else if ($page == "getwaitinglist") {
    echo $object->getWaitingList();
} else if ($page == "insertwaitlist") {
    if (!empty($_POST['wait-fullname']) && !empty($_POST['wait-contact']) && !empty($_POST['wait-toda'])) {
        echo $object->insertWaitlist($_POST['wait-fullname'], $_POST['wait-contact'], $_POST['wait-toda']);
    }
} else if ($page == "markwaitlist") {
    if (!empty($_POST['id'])) {
        echo $object->markWaitlist($_POST['id']);
    }
} else if ($page == "cancelwaitlist") {
    if (!empty($_POST['id'])) {
        echo $object->cancelWaitlist($_POST['id']);
    }
} else if ($page == "savepayencode") {
    echo $object->savePayencode($_POST['trcode'], $_POST['or_no'], $_POST['appl_status'], $_POST['payment'], $_POST['or_date'], $_POST['nname']);
} else if ($page == "searchpayencode") {
    echo $object->searchPayencode($_POST['orno']);
} else if ($page == "generatepin") {
    echo $object->generatePIN();
}
?>