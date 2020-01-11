<?php
require_once("auth.php");
require_once("../model/db/db.class.php");

if(isset($_POST['register_tree'])){

    // filter data
    $name = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    $db = DB::singleton();

    $sql = "INSERT INTO trees (description, user_id, created) 
            VALUES (:description, :userid, :created)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":description" => $name,
        ":userid" => $_SESSION["id"],
        ":created" => date("Y-m-d H:i:s")
    );

    // execute query
    $saved = $stmt->execute($params);

    if($saved) header("Location: dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register BinaryTree</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <p>&larr; <a href="../index.php">Home</a>

        <h4>New Binary Tree ...</h4>
        <p>Already have the nodes?  <a href="create_node.php">Create Nodes here</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="name">Description</label>
                <input class="form-control" type="text" name="description" placeholder="Description" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="register_tree" value="Save Tree" />

        </form>
            
        </div>

        <div class="col-md-6">
            <img class="img img-responsive" src="../img/binary.png" />
        </div>

    </div>
</div>

</body>
</html>