<?php

    function hash_m1($pwd,$salt,$r){
        $x='0';
        $x=hash('sha256', $x.$pwd.$salt);

        for(;$r>1;$r-=1){
            
            $x=hash('sha256', strtoupper($x).$pwd.$salt);
            // echo $x.'<br>';
        }
        return ($x);
    }
    
    function hash_m2($pwd,$salt,$r){
        $x='0';
        $x=hash('sha256', $x.$pwd.$salt);

        for(;$r>1;$r-=1){
            
            $x=hash('sha256', $x.$pwd.$salt);
            // echo $x.'<br>';
        }
        return ($x);
    }
    
    function hash_m3($pwd,$salt,$r){
        $x='0';
        $x=hash('sha256', $x.$pwd.$salt);
        // echo $x.'<br>';
        for(;$r>1;$r-=1){
            
            $x=hash('sha256', hex2bin($x).$pwd.$salt);
            // echo $x.'<br>';
        }
        return ($x);
    }
   ?>