<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'publicar'){

    $query = $pdo->prepare("INSERT INTO lion SET publicacao = :publicacao");
  
       $query->bindValue(":publicacao", $postjson['publicacao']);
      
       $query->execute();
  
       $id = $pdo->lastInsertId();
       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;





    
}

else if($postjson['requisicao'] == 'feed'){

    if($postjson['publicacao'] == ''){
        $query = $pdo->query("SELECT * from lion order by id desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['publicacao'] . '%';
      $query = $pdo->query("SELECT * from lion where publicacao LIKE '$busca' or email LIKE '$busca' order by id desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
      $dados[] = array(
        'id' => $res[$i]['id'],
        'publicacao' => $res[$i]['publicacao'],
        'email' => $res[$i]['email'],
        

            
        
 		);

 }

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;

}
elseif($postjson['requisicao'] == 'delete'){
    
            
  $query = $pdo->query("DELETE FROM lion where id = '$postjson[id]'");

           

    if($query){
      $result = json_encode(array('success'=>true));

      }else{
      $result = json_encode(array('success'=>false));
  
      }
   echo $result;

  }
  elseif($postjson['requisicao'] == 'editar'){
    

    $query = $pdo->prepare("UPDATE lion SET publicacao = :publicacao where id = :id");
  
       $query->bindValue(":nome", $postjson['nome']);
       $query->bindValue(":email", $postjson['email']);
       $query->bindValue(":telefone", $postjson['telefone']);
       $query->bindValue(":senha", $postjson['senha']);
       $query->bindValue(":endereco", $postjson['endereco']);
       $query->bindValue(":id", $postjson['id']);
       $query->execute();
  
       $id = $pdo->lastInsertId();
       
  
      if($query){
        $result = json_encode(array('success'=>true, 'id'=>$id));
  
        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;

    }  

?>