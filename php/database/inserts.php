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
    $teams->Arsenal = 'multimedia/arsenal.png';
    $teams->Astonvilla = 'multimedia/astonvilla.png';
    $teams->AtlMadrid = 'multimedia/atlmadrid.png';
    $teams->Barcelona = 'multimedia/barcelona.png';
    $teams->Boca = 'multimedia/boca.png';
    $teams->Brighton = 'multimedia/brighton.png';
    $teams->Chelsea = 'multimedia/chelsea.png';
    $teams->Huracan = 'multimedia/huracan.png';
    $teams->Independiente = 'multimedia/independiente.png';
    $teams->Liverpool = 'multimedia/liverpool.png';
    $teams->ManchesterCity = 'multimedia/manchestercity.png';
    $teams->ManchesterUnited = 'multimedia/manchesterunited.png';
    $teams->Newells = 'multimedia/newells.png';
    $teams->Racing = 'multimedia/racing.png';
    $teams->RealMadrid = 'multimedia/realmadrid.png';
    $teams->RealSociedad = 'multimedia/realsociedad.png';
    $teams->River = 'multimedia/river.png';
    $teams->RosarioCentral = 'multimedia/rosariocentral.png';
    $teams->SanLorenzo = 'multimedia/sanlorenzo.png';
    $teams->Sevilla = 'multimedia/sevilla.png';
    $teams->Valencia = 'multimedia/valencia.png';
    $teams->Villarreal = 'multimedia/villarreal.png';

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