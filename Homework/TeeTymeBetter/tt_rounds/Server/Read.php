<?php
include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../RoundsTableDataGateway/Rounds.php';
	include_once '../RoundsTableDataGateway/RoundsValidation.php';
	session_start();
	
	$RoundsTable = new Rounds;
	$columns = $RoundsTable->ReturnColumnsKeyPair();

//Check for get and post methods. Prepare to process either one.
if ( !empty($_POST)) {
    if(!empty($_POST["id"])){
        $id = $_POST["id"];
        $data = $RoundsTable->Find($_POST["id"]);
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
        $data = $RoundsTable->Find($id);
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
		$date = $data["teedate"];
				$date = DateTime::createFromFormat('Y-m-d', $date);
				$date = $date->format('m-d-y');
				$data["teedate"] = $date;
    ?>
        <?php
        foreach($columns as $columnkey => $columnValue){

            $dataItem = $data[$columnkey];

            echo "<div class='control-group '>
					<label class='control-label'>". trim($columnValue) ."</label>
                    <div class='controls'>
                      <label class='checkbox'>" . trim($dataItem) . "</label>
                    </div></div>";
        ?>
    <?php
}
?>




