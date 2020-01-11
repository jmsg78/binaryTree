<?php
require_once 'controllers/trees.php';
//require_once 'controllers/trees.class.php';
    // Asignar variable a la clase
    $tree = new TreeController();

    $allowResourceTypes = [
        'trees',
    ];

    $resourceType = $_GET['resource_type'];

    if ( !in_array($resourceType, $allowResourceTypes)) {
        //echo "Resource ".$_GET['resource_type']." is not available".PHP_EOL;
        die();
    }
    else
    {
        //echo "Service is available! Enjoy hacking";
        
    }
    $resourceIdTree=$_GET['resource_id'];


    switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
        case 'GET':
            if (empty($resourceIdTree)) 
            {
                echo $tree->showTrees();
            }
            else
            {
                echo $tree->showNodesTree($resourceIdTree);
            }
        break;
        case 'POST':
            $json = file_get_contents('php://input');
            $newNode = json_decode($json);
            if ((!empty($resourceIdTree)) && (!array_key_exists("node1",$newNode))) 
            {
                echo $tree->addNode($resourceIdTree,$newNode);
            }   
            elseif ( !empty($resourceIdTree)  && (array_key_exists("node1",$newNode)) && (array_key_exists("node2",$newNode)))
            {
                $nodesTree = $tree->showNodesTree($resourceIdTree, true);
                $treeSearch = new Tree();
                for($i=0,$n=count($nodesTree);$i<$n;$i++) {
                   $treeSearch->addNode($nodesTree[$i]);
                }
                $node2=$newNode->node1;
                $node1=$newNode->node2;
                $treeSearch->execute('lca',$newNode->node1,$newNode->node2);

            }
            else
            {
                echo $tree->addNodes($json);
            }
        break;
        case 'PUT':
            //Could be implement in the future
        break;
        case 'DELETE':
            //Could be implement in the future
        break;
    }
    