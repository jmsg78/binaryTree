<?php 
require_once("auth.php"); 
require_once("../model/db/db.class.php");
$db = DB::singleton();

        if (!empty($_GET["idnode"]))
        {
            $sql = "DELETE FROM tree_details WHERE id=:nodeid";
            $stmt = $db->prepare($sql);
                // bind parameter ke query
            $params = array(
            ":nodeid" => $_GET["idnode"],
            );

            $deleted = $stmt->execute($params);
            //if ($deleted) { echo "Node deleted!";}
        }
        $sql = "SELECT id,user_id,description FROM trees WHERE user_id=:userid ORDER BY id asc";
        $stmt = $db->prepare($sql);
            // bind parameter ke query
        $params = array(
        ":userid" => $_SESSION["user_id"],
        );

        $saved = $stmt->execute($params);
        $results = $stmt->fetchAll();

        $data='';
        if (empty($results)){
        	     $data = 'You haven`t registered your first BinaryTree';
        }else{

        	foreach ($results as $key){

                $sql = "SELECT id,value FROM tree_details WHERE tree_id=:treeid ORDER BY id asc";
                $stmt_nodes = $db->prepare($sql);
                // bind parameter ke query
                $params = array(
                ":treeid" => $key['id'],
                );
                $stmt_nodes->execute($params);
                $results_nodes = $stmt_nodes->fetchAll();
                $count_nodes = count($results_nodes);
                $nodes_tree='';
                foreach ($results_nodes as $keynode){
                //$nodes_tree.='<span class="badge badge-pill badge-success">'.$keynode['value'].'</span>';
                $nodes_tree.='<button type="button" class="btn btn-default btn-sm">
                '.$keynode['value'].' <a href="dashboard.php?idnode='.$keynode["id"].'" class="badge badge-danger" title="delete Node"> - </a>
                </button>';
                }
                 $data.='<div class="card mb-3">';
                 $data.='<div class="card-body">';
                 $data.='<div class="row">';
                 $data.='<div class="col-10">';
                 $data.='<h4><small>Id:'.$key["id"].'</small> >>'.$key['description'].'</h4>';
                 $data.='</div>';
                 $data.='<div class="col-2">';
                 $data.='<button type="button" class="btn btn-primary btn-sm">
                        Nodes <span class="badge badge-light">'.$count_nodes.'</span>
                        </button>';
                 $data.='</div>';
                 $data.='</div>';
                 $data.='<div class="row" style="padding:5px;">';
                 $data.=$nodes_tree;
                 $data.='<a href="create_node.php?idtree='.$key["id"].'" class="badge badge-dark" title="Add a New Node"> + </a>';
                 $data.='<a href="search_lca.php?idtree='.$key["id"].'" class="badge badge-warning" title="Search Lowest Common Ancestor at this Tree"> Search LCA </a>';
                 $data.='</div>';

                 $data.='</div>';                    
                 $data.='</div>';
                 
                 $nodes_tree='';

            }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Binary dashboard</title>

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
            <div class="card mb-3">
                <div class="card-body">
               <H1>My Trees</H1>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                <?php echo $data; ?>
                </div>
            </div>
            
        </div>
    
    </div>
</div>


</body>
</html>