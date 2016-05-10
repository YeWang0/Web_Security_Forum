<?php
    session_start();
    $role=$_SESSION['role'];
    $object=$_POST['object'];
    $operation=$_POST['operation'];
    if ($object=='author' and $operation=='revoke'){
        if($role=='moderator'){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    else{
    // echo $role.'-'.$object.'-'.$operation.'<br>';
    $dbhandle = new PDO("sqlite:../database/rbac.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query='
            select RL.role,OB.object,OP.operation from role_permissions RP 
            left outer join roles RL on RL.id=RP.role_id 
            left outer join objects OB on OB.id=RP.object_id 
            left outer join operations OP on OP.id=RP.operation_id 
            where RL.role=:role and OB.object=:object and OP.operation=:operation
           ';
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(":role", $role);
    $statement->bindParam(":object", $object);
    $statement->bindParam(":operation", $operation);
    $statement->execute();
    $results = $statement->fetch(PDO::FETCH_ASSOC);
    // echo json_encode($results);
    if (count($results)!=0 and $results!=false){
        echo 'true';
    }
    else{
        echo 'false';
    }
    }
?>