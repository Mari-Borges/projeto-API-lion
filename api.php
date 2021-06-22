<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);



if($postjson['requisicao'] == 'add'){

    $query = $pdo->prepare("INSERT INTO usuarios SET nome =:nome, email = :email, senha = :senha, telefone = :telefone, endereco = :endereco"); {

        $query->bindValue(":nome", $postjson['nome']);
        $query->bindValue(":email", $postjson['email']);
        $query->bindValue(":senha", $postjson['senha']);
        $query->bindValue(":telefone", $postjson['telefone']);
        $query->bindValue(":endereco", $postjson['endereco']);
        $query->execute();

        $id = $pdo->lastInsertId();

        if($query){
            $result = json_encode(array('success'=>true, 'id'=>$id));
        }else{
            $result = json_encode(array('success'=>false));
        }
        echo $result;
    }
}
else if($postjson['requisicao'] == 'list'){

    if($postjson['nome'] == ''){
        $query = $pdo->query("SELECT * from usuarios order by id desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['nome'] . '%';
      $query = $pdo->query("SELECT * from usuarios where nome LIKE '$busca' or email LIKE '$busca' order by id desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
      $dados[] = array(
        'id' => $res[$i]['id'],
        'nome' => $res[$i]['nome'],
        'email' => $res[$i]['email'],
        'senha' => $res[$i]['senha'],
        'telefone' => $res[$i]['telefone'],
        'endereco' => $res[$i]['endereco'],

            
        
 		);

 }

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;

}

elseif($postjson['requisicao'] == 'editar'){
    
    $senha_cript = md5($postjson['senha']);

    $query = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, endereco = :endereco where id = :id");
  
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
    elseif($postjson['requisicao'] == 'delete'){
    
            
        $query = $pdo->query("DELETE FROM usuarios where id = '$postjson[id]'");
      
                 
      
          if($query){
            $result = json_encode(array('success'=>true));
      
            }else{
            $result = json_encode(array('success'=>false));
        
            }
         echo $result;
    
        }

        else if($postjson['requisicao'] == 'login'){

         
            $query = $pdo->query("SELECT * from usuarios where email = '$postjson[email]' and senha = '$postjson[senha]'");
            
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
        
           for ($i=0; $i < count($res); $i++) { 
              foreach ($res[$i] as $key => $value) {
              }
             $dados = array(
               'id' => $res[$i]['id'],
              'nome' => $res[$i]['nome'],
            'email' => $res[$i]['email'],
               'senha' => $res[$i]['senha'],
               'telefone' => $res[$i]['telefone'],
               'endereco' => $res[$i]['endereco'],

                    
                    
                
             );
        
         }
        
                if(count($res) > 0){
                        $result = json_encode(array('success'=>true, 'result'=>$dados));
        
                    }else{
                        $result = json_encode(array('success'=>false, 'msg'=>'Dados Incorretos!'));
        
                    }
                    echo $result;
        
        }    


?>