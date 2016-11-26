<?php

/**
 * Está classe permite rastrear o caminho "até o alvo"
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */

namespace Crphp\Check;

class Traceroute
{
    /**
     * Realiza o disparo do tracert via SO
     * 
     * @param   string      $destino
     * @param   int         $totalSaltos
     * @return  array|null  em caso de sucesso retorna uma string
     */
    public function run($destino, $totalSaltos = 15)
    {        
        // Se o servidor for Windows executa este comando
        exec("tracert -h {$totalSaltos} {$destino}", $output, $status);
        
        if(!$output)
        {
            // Se o servidor for "Linux" executa este comando
            exec("traceroute -t {$totalSaltos} {$destino}", $output, $status);
        }
         
        return ($status == 0) ? $output : null;
    }
    
    /**
     * Converte o retorno do método run para string
     * 
     * @param array $tracert
     * @return string
     */
    public function toString(Array $tracert)
    {
        $var = "";
        foreach ($tracert as $linha)
        {
            $var .= utf8_encode($linha) . "\n";
        }
        
        $dic = [
            "¡" => "í",
            "m ximo" => "máximo",            
        ];
        
        return "<pre>" . strtr($var, $dic) . "</pre>";
    }
}