<?php
require '../CoursesTableDataGateway/Courses.php';
include_once '../CoursesTableDataGateway/CoursesValidation.php';

$columns = Courses::ReturnColumnsKeyPair();

//Check for get and post methods. Prepare to process either one.
if ( !empty($_POST)) {
    if(!empty($_POST["id"])){
        $id = $_POST["id"];
        $data = Courses::Find($_POST["id"]);
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
        $data = Courses::Find($id);
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

            echo "<div class='control-group '>
					<label class='control-label'>". trim($columnValue) ."</label>
                    <div class='controls'>
                      <label class='checkbox'>" . trim($dataItem) . "</label>
                    </div></div>";
        ?>
    <?php
}
?>




