<?php
    $servername = "localhost:3306";
    $username = "root";
    $password = "password";
    $dbname = "moviedb";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $req= $_REQUEST["req"];
        if($req=='a'){
            $name=$_POST["aname"];
            $sql = "INSERT INTO actor (actor)
            VALUES ('$name')";
            // $conn->query($sql);
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
        else if($req== 'g') {
            $name=$_POST["aname"];
            // echo $name;
            $sql = "INSERT INTO genre (genrename)
            VALUES ('$name')";
            // $conn->query($sql);
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $req= $_REQUEST["req"];
        if($req=='a') {
            $sql = "SELECT * FROM actor";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['actor']."'>".$row['actor']."</option>";
                }
            } else {
                echo "0 results";
            }
        }
        else if($req=='g'){
            $sql = "SELECT * FROM genre";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['genrename']."'>".$row['genrename']."</option>";
                }
            } else {
                echo "0 results";
            }
        }
    }
?>