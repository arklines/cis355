<?php
include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../PersonsTableDataGateway/Persons.php';
	include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();	
	$PersonTableGateWay = new Persons;
	$columns = $PersonTableGateWay->ReturnColumnsKeyPair();
//Check for get and post methods. Prepare to process either one.
if ( !empty($_POST)) {
    if(!empty($_POST["id"])){
        $id = $_POST["id"];
        $data = $PersonTableGateWay->Find($_POST["id"]);
        //if id is invalid, echo error
        if(empty($data)){
            echo "error";
            exit;
        }
    }
    else{
        echo "error";
        exit;
    }
}
elseif(!empty($_GET)) {
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        //check that id is valid
        $data = $PersonTableGateWay->Find($id);
	
        if (empty($data)) {
            echo "error";
            exit;
        }
    } else {
        echo "error";
        exit;
    }

}
else {
        echo "error";
        exit;
    }
    ?>
        <?php
        foreach($columns as $columnkey => $columnValue){

            $dataItem = $data[$columnkey];
			if(!(($columnkey ==="password_hash"))){
				InputObjects::EchoInputGroup($columnkey, trim($columnValue), trim($dataItem), $error);
            }
        ?>
    <?php
}
?>




