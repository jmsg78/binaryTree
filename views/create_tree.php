<?php 
require_once("auth.php"); 
require_once("../model/db/db.class.php");
$db = DB::singleton();
if(isset($_POST['create_tree'])){

    // filter data 
    $name = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    

    // Query
    $sql = "INSERT INTO trees (description, user_id, created) 
            VALUES (:description, :userid, :created)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":description" => $name,
        ":userid" => $_SESSION["user_id"],
        ":created" => date("Y-m-d H:i:s")
    );

    // Execute Query
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
    <title>Create New Tree</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body text-center">

                    <img class="img img-responsive rounded-circle mb-3" width="160" src="../img/<?php echo $_SESSION['user']['photo'] ?>" />
                    
                    <h3><?php echo  $_SESSION["user"]["name"] ?></h3>
                    <p><?php echo $_SESSION["user"]["email"] ?></p>
                    </br>
                    <hr>
                    <p><a href="create_tree.php">Create new Tree</a></p>
                    </br>
                    </br>
                    <hr>
                    <p><a href="logout.php">Logout</a></p>
                </div>
            </div>

            
        </div>


        <div class="col-md-8">

        <div class="container mt-5">
        <div class="row">
            <div class="col-md-9">

            <p>&larr; <a href="dashboard.php">Home</a>

            <h4>New Binary Tree ...</h4>
            <p>Already have the nodes?  <a href="create_node.php">Create Nodes here</a></p>

            <form action="" method="POST">

            <div class="form-group">
                <label for="name">Description</label>
                <input class="form-control" type="text" name="description" placeholder="Description" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="create_tree" value="Save Tree" />

            </form>
            
            </div>
            <div class="col-md-3">
            <img class="img img-responsive" src="../img/binary.png" />
            </div>

        </div>
        </div>
        </div>
    
    </div>
</div>
            


</body>
</html>