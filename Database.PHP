
<?php
    require "";


    $sql = "CREATE DATABASE ` //enter DB name `";

    if($conn->query($sql) === TRUE) {
        echo "database created sucessfully";
    }else{
        echo "Error creating database:" .$conn->error;
    }

    $conn->close();