<?php
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
          public function traverse($method,$node1=NULL,$node2=NULL) {
                 switch($method) {
                     case 'preorder':
                     $this->_preorder($this->rootNode);
                     break;
                     case 'lca':
                     $this->_lca($this->rootNode,$node1,$node2);
                     break;
                     default:
                     break;
                 } 
          } 

          private function _preorder($node) {
            echo $node. " ";
            if($node->leftNode) {
               $this->_preorder($node->leftNode); 
            } 
            if($node->rightNode) {
               $this->_preorder($node->rightNode); 
            } 
          }
          public function diagramTree() {
                 $node = $this->rootNode;
                 
                 $node->levelNode = 1; 
                 $queue = array($node);
                 $out = array("<br/>");
                 $current_levelNode = $node->levelNode;
  
                 while(count($queue) > 0) {
                       $current_node = array_shift($queue);
                       if($current_node->levelNode > $current_levelNode) {
                            $current_levelNode++;
                            array_push($out,"<br/>");  
                       } 
                       array_push($out,$current_node->value. " --");
                       if($current_node->leftNode) {
                          $current_node->leftNode->levelNode = $current_levelNode + 1;
                          array_push($queue,$current_node->leftNode); 
                       }    
                       if($current_node->rightNode) {
                          $current_node->rightNode->levelNode = $current_levelNode + 1;
                          array_push($queue,$current_node->rightNode); 
                       }    
                 }
                return join($out,""); 
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
    
/*
               $arr = array(67,39,76,28,44,74,85,29,83,87);
               $tree = new Tree();
               for($i=0,$n=count($arr);$i<$n;$i++) {
                   $tree->addNode($arr[$i]);
               }

    echo "<h2>Input vector: ", join($arr," "), "</h2>";
    echo"<h1>Breadh-First Traversal Tree</h1>"; 
    echo $tree->diagramTree();
    echo"<h1>Preorder</h1>"; 
    $tree->traverse('preorder');
    echo"<h1>LCA 29, 44</h1>"; 
    $tree->traverse('lca',29,40);
    $tree->traverse('lca',44,85);
    $tree->traverse('lca',83,87);*/
  
