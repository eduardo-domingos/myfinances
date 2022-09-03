<?php

/**
 * Função para criar o diretório de logs, caso não exista
 * @param string $pathDir
 */
function createDirLogs(string $pathDir): void
{
    if(!file_exists($pathDir)){
        mkdir($pathDir);
    }
}

/**
 * Função para registrar erros e avisos no log
 * @param int $error
 * @param string $message
 * @param string $file
 * @param int $line
 * @return void
 */
function phpError(int $error, string $message, string $file, int $line): void
{
    if(DEBUG){

        createDirLogs(__DIR__.'/../logs');

        $logs = "[".date('d/m/Y H:i:s')."] Erro: {$message} no arquivo {$file} na linha {$line}\n\n";

        error_log($logs, 3, __DIR__.'/../logs/phpErro.log');

        if($error == 1 || $error == 256){
            die();
        }
    }
}

set_error_handler('phpError');