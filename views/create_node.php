<?php 
require_once("auth.php"); 
require_once("../model/db/db.class.php");
/**
 * Create Select Tree
 */
$db = DB::singleton();

$sql = "SELECT id,user_id,description FROM trees WHERE user_id=:userid ORDER BY id asc";
$stmt = $db->prepare($sql);
    // bind parameter ke query
$params = array(
":userid" => $_SESSION["user_id"]
);

$saved = $stmt->execute($params);
$results = $stmt->fetchAll();

$data='';
if (empty($results)){
         $data = 'You haven´t created any Tree';
}else{
    //return $results;
    foreach ($results as $key){
        if ((!empty($_GET['idtree'])) && ($key["id"] == $_GET['idtree'])) { $selected_tree='selected';} else { $selected_tree='';}
         $data.='<option value="'.$key['id'].'"'.$selected_tree.'>';
         $data.=$key['description'];
         $data.='</option>';                    
    }
}

if(isset($_POST['register_node'])){

    // filter data yang diinputkan
    $tree_id = filter_input(INPUT_POST, 'tree_id', FILTER_SANITIZE_NUMBER_INT);
    $value_node = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_NUMBER_INT);


    // Query
    $sql = "INSERT INTO tree_details (user_id,tree_id, value, created) 
            VALUES (:userid,:treeid,:valuenode,:created)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":userid" => $_SESSION["user_id"],
        ":treeid" => $tree_id,
        ":valuenode" => $value_node,
        ":created" => date("Y-m-d H:i:s")
    );

    $saved = $stmt->execute($params);

    if($saved) header("Location: create_node.php?idtree=".$tree_id);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create New Node</title>

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
                    <p><a href="create_node.php">Create new Node</a></p>
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

            <h4>New Node of Binary Tree ...</h4>
            <p>Already have the nodes?  <a href="nodes.php">Create Nodes here</a></p>

            <form action="" method="POST">
            <div class="form-group">
                <label for="name">Choose Tree</label>
                <select class="form-control" name="tree_id" placeholder="Tree">
                <?php echo $data;?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Value</label>
                <input class="form-control" type="number" name="value" placeholder="value Node" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="register_node" value="Save Node" />

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