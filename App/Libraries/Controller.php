<?php

namespace App\Libraries;

/**
 * Classe Controller Base
 */
abstract class Controller 
{
    /**
     * Instância do Model
     * @param string $model
     * @return object
     */
    public function model(string $model): object
    {
        
        $class = "\\App\\Models\\".$model;
        return (new $class);
    }
    
    /**
     * Carrega a View
     * @param string $view
     * @param array $data
     * @return void
     */
    public function view(string $view, array $data = [])
    {
      
        $file = __DIR__.'/../Views/'.$view.'.php';

        if(file_exists($file)){
            require_once($file);
        }else{
            die('O arquivo de view não existe!');
        }
        
    }
}