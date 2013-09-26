<?php
	$contactsFile = "res/js/contacts.json";
	$groupsFile = "res/js/groups.json";
	$string = file_get_contents($contactsFile);
	$json = json_decode($string, true);
		
	foreach ($json as $key => $val) {
		if(is_array($val)) {
			/*����� ���� ID*/
			$lastID = 0;
			foreach ($val as $z => $y) {
				if(!is_array($y) && $z=="userID" && $lastID < $y) $lastID= $y+1;
			}
		}
	}
	
	if($_GET['type'] == 'editContact'){
		if($_GET['userID']=='new'){
			/*��������� ������*/
			$json['user'.$lastID]=[
				'userID' => $lastID,
				'name' => $_GET['name'],
				'mail' => $_GET['mail'],
				'phone' => $_GET['phone'],
				'group' => $_GET['group']
			];
			echo json_encode(['status' => 'add','userID' => $lastID]);
		}else{
			/*��������� ������*/
			$json['user'.$_GET['userID']]=[
				'userID' => $_GET['userID'],
				'name' => $_GET['name'],
				'mail' => $_GET['mail'],
				'phone' => $_GET['phone'],
				'group' => $_GET['group']
			];
			echo '';
			echo json_encode(['status' => 'update']);
		}
	}else if($_GET['type'] == 'removeContact'){
		unset($json['user'.$_GET['userID']]);
		echo 'delete';
	}else{
		echo 'error request type';
	};
	/*������*/
	$string = json_encode($json);	
	file_put_contents($contactsFile, $string);
?>