<?php

$action = $_POST['action'];

if ($action == 'create'){
    $attractie = $_POST['attractie'];
    $type = $_POST['type'];
    $capaciteit = $_POST['capaciteit'];
    if(isset($_POST['prioriteit']))
    {$prioriteit = 1;}
    else
    {$prioriteit = 0;}
    $melder = $_POST['melder'];
    $overig = $_POST['overig'];


    require_once '../../../config/conn.php';
    $query = "INSERT INTO meldingen (attractie, type, capaciteit, prioriteit, melder, overige_info)
    VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :overige_info)";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":attractie" => $attractie,
        ":type" => $type,
        ":capaciteit" => $capaciteit,
        ":prioriteit" => $prioriteit,
        ":melder" => $melder,
        ":overige_info" => $overig
    ]);

    if(empty($attractie))
    {
        $errors[] = "Vul de attractie-naam in.";
    }
    if(empty($type))
    {
        $errors[] = "Kies de type.";
    }
    if(!is_numeric($capaciteit)) 
    {
        $errors[] = "Vul voor capaciteit een geldig getal in.";
    }
    if(empty($melder))
    {
        $errors[] = "Vul de melder's naam in.";
    }
    if(isset($errors))
    {
    var_dump($errors);
    die();
    }

    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding opgeslagen");
}

if ($action == 'update'){
    $id = $_POST['id'];
    $capaciteit = $_POST['capaciteit'];
    if(isset($_POST['prioriteit']))
    {$prioriteit = 1;}
    else
    {$prioriteit = 0;}
    $melder = $_POST['melder'];
    $overig = $_POST['overig'];
    $action = $_POST['action'];

    require_once '../../../config/conn.php';
    $query = "UPDATE meldingen 
    SET capaciteit = :capaciteit, prioriteit = :prioriteit, melder = :melder, overige_info = :overige_info WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":capaciteit" => $capaciteit,
        ":prioriteit" => $prioriteit,
        ":melder" => $melder,
        ":overige_info" => $overig,
        ":id" => $id
        ]);

    if(!is_numeric($capaciteit)) 
    {
        $errors[] = "Vul voor capaciteit een geldig getal in.";
    }
    if(empty($melder))
    {
        $errors[] = "Vul de melder's naam in.";
    }
    if(isset($errors))
    {
    var_dump($errors);
    die();
    }

    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding aangepast");
}
