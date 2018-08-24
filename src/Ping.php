<?php

/**
 * Está classe utiliza o exec para disparar uma requisição ICMP por meio do 
 * sistema operacional no qual o código se encontra 
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016-2018, Fábio J L Ferreira
 */

namespace Crphp\Check;

class Ping
{
    /**
     * Realiza o disparo do ping via SO
     * 
     * @param   string      $destino
     * @param   int         $totalPings
     * @return  array|null
     */
    public static function run($destino, $totalPings = 5)
    {
        // Verifica se o servidor é Windows
        $opcao = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '-n' : '-c';

        exec("ping {$opcao} {$totalPings} {$destino}", $output, $status);

        // se obtiver sucesso retorna um array com os dados do teste
        return ($status == 0) ? $output : null;
    }

    /**
     * Converte o retorno do método run para string
     * 
     * @param   array   $pings
     * @return  string
     */
    public static function toString(Array $pings)
    {
        $var = "";
        foreach ($pings as $linha) {
            $var .= utf8_encode($linha) . "\n";
        }

        $dicionario = [
            "¡" => "í",
            "£" => "ú",
            "M ximo" => "Máximo",
            "Mdia " => "Média"
        ];

        return "<pre>" . strtr($var, $dicionario) . "</pre>";
    }
}