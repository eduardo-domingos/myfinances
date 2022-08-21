<?php

namespace App\Libraries;

/**
 * Gerencia as rotas do projeto
 */
class Router 
{
    
    /**
     * Instância do controller
     * @var object|string
     */
    private object|string $controller = 'Pages';
    
    /**
     * Método referente ao controller
     * @var string
     */
    private string $method = 'index';
    
    /**
     * Paramêtros da URL
     * @var array
     */
    private array $params = [];
    
    public function __construct() 
    {
        $url = $this->parseUrl() ?? [0];
        
        if(isset($url[0]) && $url[0] === 'api' && count($url) >= 2){
        
        }
        
        $this->setControllerUrl($url);
        $this->setMethodUrl($url);
        $this->setParamsUrl($url);
        $this->run();
       
    }
    
    /**
     * Trata a URL
     * @return array
     */
    private function parseUrl(): array
    {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) ?? '';
        return explode('/', trim(rtrim($url, '/')));
    }
    
    /**
     * Define o controller com base na URL
     * @param array $url
     * @return void
     */
    private function setControllerUrl(array $url): void
    {
      
        if(file_exists(__DIR__.'/../Controllers/'.ucwords($url[0]).'.php')){
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }
        
        $class = "\\App\\Controllers\\".$this->controller;
        
        $this->controller = new $class;
    }
    
    /**
     * Define o método do controller
     * @param array $url
     * @return void
     */
    private function setMethodUrl(array $url): void
    {
        if(isset($url[1])){
            if(method_exists($this->controller , $url[1])){
                $this->method = $url[1]; 
                unset($url[0]);
            }
        }
    }
    
    
    /**
     * Define os valores dos parâmetros
     * @param array $url
     * @return void
     */
    private function setParamsUrl(array $url): void
    {
        $this->params = $url ? array_values($url) : [];
    }
    
    /**
     * Executa a classe, chamando o métodos e passando os argumentos
     * @return void
     */
    private function run(): void
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
}