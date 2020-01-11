<?php 
require_once("auth.php"); 
require_once("../model/db/db.class.php");

Class TreeController
{
    public function showTrees(){
        /**
         * Show Trees
         */
        $db = DB::singleton();
        $sql = "SELECT id,user_id,description,created FROM trees WHERE id>:id ORDER BY id asc";
        $stmt = $db->prepare($sql);
        // bind parameter ke query
        $params = array(
        ":id" => 0
        );
        $saved = $stmt->execute($params);
        $results = $stmt->fetchAll();
        $data='';
        if (empty($results)){
                $data = 'Anything for here';
        }else{
            $data='';
            foreach ($results as $key){
                $data .= '{"id":'.$key['id'].' ,"description":"'.$key['description'].'" ,"user_id":"'.$key['user_id'].'" ,"created":"'.$key['created'].'"},';
           }
           return "[".$data."]";
        }
    }

    public function showNodesTree($idTree, $lca = false ){
        /**
         * Show Trees
         */
        $db = DB::singleton();
        $sql = "SELECT id,user_id,value,created FROM tree_details WHERE tree_id=:id ORDER BY id asc";
        $stmt = $db->prepare($sql);
        // bind parameter ke query
        $params = array(
        ":id" => $idTree
        );
        $saved = $stmt->execute($params);
        $results = $stmt->fetchAll();
        $data='';
        if (empty($results)){
                $data = 'Anything for here';
        }else{
            $data='';
            $dataLCA= array();
            foreach ($results as $key){
                if ($lca) 
                {
                $dataLCA[]= $key['value'];
                }
                else
                {
                $data .= '{"id":'.$key['id'].' ,"user_id":"'.$key['user_id'].'" ,"value":"'.$key['value'].'" ,"created":"'.$key['created'].'"},';
                }
           }
        if ($lca) { return $dataLCA; } else { return "[".$data."]"; }
        // return $data;
        }

    }
    
    public function addNode($tree,$node){
        /**
         * Show Trees
         */
        $db = DB::singleton();
        // menyiapkan query
        $sql = "INSERT INTO tree_details (user_id,tree_id, value, created) 
        VALUES (:userid,:treeid,:valuenode,:created)";
        $stmt = $db->prepare($sql);

        // bind parameter ke query
        $params = array(
        ":userid" => $node->userid,
        ":treeid" => $tree,
        ":valuenode" => $node->valuenode,
        ":created" => date("Y-m-d H:i:s")
        );
        $saved = $stmt->execute($params);
        
            if($saved) {
                echo 'Node '.$node->valuenode.' added!';
            } 
            else {
                return 'Error trying to add a new Node';
            }
    }

    public function addNodes($nodes){
        /**
         * Show Trees
         */
        $db = DB::singleton();
        //Decode JSON
        echo $nodes;
        $data = array();
        $data = json_encode($nodes, true);

        if (is_array($data) || is_object($data))
        {
            foreach ($values as $value)
            {
                echo $values['userid']."<br/>";
            }
        }
        
        $sql = "INSERT INTO tree_details (user_id,tree_id, value, created) 
        VALUES (:userid,:treeid,:valuenode,:created)";
        $stmt = $db->prepare($sql);

        // bind parameter ke query
        $params = array(
        ":userid" => $node->userid,
        ":treeid" => $node->treeid,
        ":valuenode" => $node->valuenode,
        ":created" => date("Y-m-d H:i:s")
        );

        $saved = $stmt->execute($params);
        
            if($saved) {
                echo 'Node '.$node->valuenode.' added!';
            } 
            else {
                return 'Error trying to add a new Node';
            }
    }

}

class Node {
    public $value;
    public $leftNode;
    public $rightNode;
    public $levelNode;
    public function __construct($value) {
           $this->value = $value;
           $this->leftNode = NULL;
           $this->rightNode = NULL;
           $this->levelNode = NULL;
    }
    public function __toString() {
           return "$this->value";
    }
} 

class Tree {
    public $rootNode;
    public function  __construct() {
           $this->rootNode = NULL;
    }

    public function addNode($value) {
        
           if($this->rootNode == NULL) {
              $this->rootNode = new Node($value);
           } else {

              $current = $this->rootNode;
              while(true) {
                    if($value < $current->value) {
                   
                          if($current->leftNode) {
                             $current = $current->leftNode;
                          } else {
                             $current->leftNode = new Node($value);
                             break; 
                          }
                    } else if($value > $current->value){
                          if($current->rightNode) {
                             $current = $current->rightNode;
                          } else {
                             $current->rightNode = new Node($value);
                             break; 
                          }
                    } else {
                      break;
                    }
              } 
           }
    }
      public function execute($method,$node1=NULL,$node2=NULL) {
            switch($method) {
                case 'lca':
                $this->_lca($this->rootNode,$node1,$node2);
                break;
                case 'preorder':
                    //Could be implement in the future
                    break;
                default:
                break;
            } 
      } 

    
      private function _lca($node, $n1, $n2) 
      { 
          if ($node == null) 
          { 
              return null; 
          } 
  
          // If both n1 and n2 are smaller than rootNode, then LCA lies in leftNode  
          if ($node->value > $n1 && $node->value > $n2) 
          { 
              return $this->_lca($node->leftNode, $n1, $n2); 
          } 
  
          // If both n1 and n2 are greater than rootNode, then LCA lies in rightNode  
          if ($node->value < $n1 && $node->value < $n2) 
          { 
              return $this->_lca($node->rightNode, $n1, $n2); 
          } 
  
          echo $node. " ";
      }
}
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

$dataSelect='';
if (empty($results)){
         $dataSelect = 'You haven´t created any Tree';
}else{
    //return $results;
    foreach ($results as $key){
        if ((!empty($_GET['idtree'])) && ($key["id"] == $_GET['idtree'])) { $selected_tree='selected'; $nameTree=$key["description"];} else { $selected_tree='';}
         $dataSelect.='<option value="'.$key['id'].'"'.$selected_tree.'>';
         $dataSelect.=$key['description'];
         $dataSelect.='</option>';                    
    }
}

if(isset($_POST['search_lca'])){

    // filter data yang diinputkan
    $tree_id = filter_input(INPUT_POST, 'idtree', FILTER_SANITIZE_NUMBER_INT);
    $value_node = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_NUMBER_INT);

    $tree = new TreeController();
    $nodesTree = $tree->showNodesTree($tree_id, true);
    
    $treeSearch = new Tree();
    for($i=0,$n=count($nodesTree);$i<$n;$i++) {
       $treeSearch->addNode($nodesTree[$i]);
    }
    $node2=$_POST["node1"];
    $node1=$_POST["node2"];
    
}


if ((!empty($_GET["idtree"])) || (!empty($_POST["idtree"])))
{
    if (empty($_GET["idtree"])) { $idtree=$_POST["idtree"]; } else { $idtree=$_GET["idtree"];}  
        $sql = "SELECT id,value FROM tree_details WHERE tree_id=:treeid ORDER BY id asc";
        $stmt_nodes = $db->prepare($sql);
        // bind parameter ke query
        $params = array(
        ":treeid" => $idtree,
        );
        $stmt_nodes->execute($params);
        $results_nodes = $stmt_nodes->fetchAll();
        $count_nodes = count($results_nodes);
        $nodes_tree='';
        $data='';
        foreach ($results_nodes as $keynode){
        $nodes_tree.='<button type="button" class="btn btn-default btn-sm">
        '.$keynode['value'].' <a href="dashboard.php?idnode='.$keynode["id"].'" class="badge badge-danger" title="delete Node"> - </a>
        </button>';
        }
         $data.='<div class="card mb-3">';
         $data.='<div class="card-body">';
         $data.='<div class="row">';
         $data.='<div class="col-10">';
         $data.='<h4><small>Id:'.$idtree.'</small></h4>';
         $data.='</div>';
         $data.='<div class="col-2">';
         $data.='<button type="button" class="btn btn-primary btn-sm">
                Nodes <span class="badge badge-light">'.$count_nodes.'</span>
                </button>';
         $data.='</div>';
         $data.='</div>';
         $data.='<div class="row" style="padding:5px;">';
         $data.=$nodes_tree;
         $data.='</div>';

         $data.='</div>';                    
         $data.='</div>';
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

            <h4>Search LCA at Tree <?php echo $nameTree;?>...</h4>
            <h5>
            <?php 
            if (isset($_POST['search_lca']))
            {
            echo "Node 1: ".$_POST["node1"]. " Node 2: ".$_POST["node2"]."<strong> LCA:".$result_lca."</strong><span style='color:red;font-size:22px;font-weight:bold'>";
            $treeSearch->execute('lca',$node1,$node2);
            echo "</span>";
            }
            ?>
            
            </h5>
            
            <div class="row">
            <?php echo $data; ?>
            </div>

            <form action="" method="POST">
            <div class="form-group">
                <label for="name">Node 1</label>
                <input class="form-control" type="number" name="node1" placeholder="value Node" />
            </div>
            <div class="form-group">
                <label for="name">Node 2</label>
                <input class="form-control" type="number" name="node2" placeholder="value Node" />
                <input type="hidden" class="form-control" name="idtree" value="<?php echo $_GET['idtree']; ?>" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="search_lca" value="Search LCA" />

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