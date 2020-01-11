<?php
require_once("model/db/db.class.php");

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