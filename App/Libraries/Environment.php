<?php

namespace App\Libraries;

/**
 * Carrega variáveis de ambiente, para configurar o projeto em si
 */
class Environment 
{
    
   /**
    * Carrega varíaveis de ambiente para configurar o projeto
    * @param $dir string
    * @return void
    */
   public static function loadVariables(string $dir): void
   {
       if(file_exists($dir.'/.env')){
           
            $lines = file($dir.'/.env');

            foreach($lines as $line){
                putenv(trim($line));
            }
        }
   }
    
}