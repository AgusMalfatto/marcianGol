<?php

include ("connection.php");

$database = "marciangol";
mysqli_select_db($conn, $database);

/* ------------------------ INSERTS DEFAULT LEAGUE VALUES ------------------------ */

$result = $conn->query("SELECT COUNT(*) as count FROM league");
echo $conn->error;
$row = $result->fetch_assoc();
$count = $row['count'];

// If there is not register in the database, do the inserts
if ($count == 0) {
    $insertLeagueQuery = $conn->prepare("INSERT INTO league (description) VALUES (?)");

    $leagueValues = ['Primera A', 'Primera B', 'Brasileiro Serie A', 'Premier League', 'Serie A', 'La Liga', 'Bundesliga', 'Ligue 1'];

    // Inserting the Leagues
    foreach ($leagueValues as $value) {
        $insertLeagueQuery->bind_param("s", $value);
        $insertLeagueQuery->execute();
    }

    echo "<br> Table League filled successfully.";
} else {
    echo "<br> Table League was already filled.";
}

/* ------------------------ INSERTS DEFAULT TEAM VALUES ------------------------ */

$result = $conn->query("SELECT COUNT(*) as count FROM team");
$row = $result->fetch_assoc();
$count = $row['count'];

// If there is not register in the database, do the inserts
if ($count == 0) {

    $teams = new stdClass();
    $teams->Arsenal = 'multimedia/Arsenal.png';
    $teams->Astonvilla = 'multimedia/Astonvilla.png';
    $teams->AtlMadrid = 'multimedia/Atlmadrid.png';
    $teams->Barcelona = 'multimedia/Barcelona.png';
    $teams->Boca = 'multimedia/Boca.png';
    $teams->Brighton = 'multimedia/Brighton.png';
    $teams->Chelsea = 'multimedia/Chelsea.png';
    $teams->Huracan = 'multimedia/Huracan.png';
    $teams->Independiente = 'multimedia/Independiente.png';
    $teams->Liverpool = 'multimedia/Liverpool.png';
    $teams->ManchesterCity = 'multimedia/ManchesterCity.png';
    $teams->ManchesterUnited = 'multimedia/ManchesterUnited.png';
    $teams->Newells = 'multimedia/Newells.png';
    $teams->Racing = 'multimedia/Racing.png';
    $teams->RealMadrid = 'multimedia/RealMadrid.png';
    $teams->RealSociedad = 'multimedia/RealSociedad.png';
    $teams->River = 'multimedia/River.png';
    $teams->RosarioCentral = 'multimedia/RosarioCentral.png';
    $teams->SanLorenzo = 'multimedia/SanLorenzo.png';
    $teams->Sevilla = 'multimedia/Sevilla.png';
    $teams->Valencia = 'multimedia/Valencia.png';
    $teams->Villarreal = 'multimedia/Villarreal.png';

    $insertLeagueQuery = $conn->prepare("INSERT INTO team (name, photo) VALUES (?, ?)");


    // Inserting the Leagues
    foreach ($teams as $team => $path) {
        $insertLeagueQuery->bind_param("ss", $team, $path);
        $insertLeagueQuery->execute();
    }

    echo "<br> Table Team filled successfully.";
} else {
    echo "<br> Table Team was already filled.";
}


/* ------------------------ INSERTS DEFAULT ADMIN VALUES ------------------------ */

$result = $conn->query("SELECT COUNT(*) as count FROM user");
$row = $result->fetch_assoc();
$count = $row['count'];

// If there is not register in the database, do the inserts
if ($count == 0) {
    /* 

        ***************************
    
        ACCESS INFORMATION.
        MODIFY BASED ON YOUR NEEDS.

        ***************************
    
    */
    $name = "Agustín";
    $last_name = "Malfatto";
    $email = "agus.malfatto20@gmail.com";
    $plain_password = "Racing.2010";
    $admin = 1;
    $active = 1;
    $id_team = 14;
    
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    $insertUserQuery = $conn->prepare("INSERT INTO user (name, last_name, email, password, admin, active, id_team) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $insertUserQuery->bind_param("ssssiii", $name, $last_name, $email, $hashed_password, $admin, $active, $id_team);

    // Ejecutar la consulta
    $insertUserQuery->execute();

    // Cerrar la consulta
    $insertUserQuery->close();
    echo "<br> Table User filled successfully.";
} else {
    echo "<br> Table User was already filled.";
}


?>