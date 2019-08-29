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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sql = "SELECT * FROM movie";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $id=0;
            while($row = $result->fetch_assoc()) {
                $id=$id+1;
                echo "<div id='parent'>
                        <br>
                        <img src=\"" .$row["img"]. "\" width=\"50px\"/>
                        <br> 
                        <h2 id='mname'>" . $row["moviename"]. "</h2>
                        <div id='".$id."'>
                            <br>". " 
                            <h3>Actor:-".$row["actor"]."</h3>
                            <br>  
                            <h4>Rating:- ".$row['rating']."  Genre:-"." $row[Genre]</h4>
                            <button value='".$id."' onclick=\"edit(this)\">Edit Movie</button>
                            <button onclick=\"del(this)\">Delete Movie</button>
                        </div>
                    </div>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // echo $_POST['name'];
        $req= $_REQUEST["req"];
        if($req=='edit') {
            $name=$_POST["name"];
            $genre=$_POST["genre"];
            $rating=$_POST["rating"];
            $actor=$_POST["actor"];

            $sql = "UPDATE movie SET Genre='$genre',rating='$rating',actor='$actor' WHERE moviename='$name'";
            if ($conn->query($sql) === TRUE) {
                echo "successfull";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        else {
            $name=$_POST["name"];
            // echo $name;
            $img=$_POST["img"];
            $genre=$_POST["genre"];
            $rating=$_POST["rating"];
            $actor=$_POST["actor"];
            $sql = "INSERT INTO movie (moviename, actor, img, rating, Genre)
            VALUES ('$name', '$actor', '$img', $rating, '$genre')";
            // $conn->query($sql);
            $conn->query($sql);
            $conn->close();
            header('Location: /projects/movie.html');
        }

    }

    else if ($_SERVER["REQUEST_METHOD"]== "DELETE") {
        $data =file_get_contents('php://input');
        parse_str($data, $name);
        $del_id=$name['name'];
        $sql = "DELETE FROM movie WHERE moviename='$del_id'";
        if ($conn->query($sql) === TRUE) {
            echo "successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

?>