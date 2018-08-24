<?php

/**
 * Está classe utiliza o exec para disparar uma requisição ICMP por meio do 
 * sistema operacional no qual o código se encontra.
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
     * Realiza o disparo do ping via SO, ou seja, o ping (protocolo ICMP) é realizado pelo próprio sistema operacional,
     * e não pelo PHP. É importante que seu sistema disponha deste comando para que esse método atinja seu objetivo.
     * 
     * @param   string      $target
     * @param   int         $testLimit
     *
     * @return  array|null
     */
    public static function run($target, $testLimit = 5)
    {
        /** @internal Utiliza PHP_OS para determinar se o sistema é Windows ou outro. */
        $option = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '-n' : '-c';

        exec("ping {$option} {$testLimit} {$target}", $output, $status);

        /** @internal Em caso de sucesso ($status = 0) será retornado um array contendo o resultado dos testes. */
        return ($status === 0) ? $output : null;
    }

    /**
     * Converte o retorno do método run para string.
     * 
     * @param   array   $pings
     *
     * @return  string
     */
    public static function toString(Array $pings)
    {
        $var = '';
        foreach ($pings as $row) {
            $var .= utf8_encode($row) . "\n";
        }

        $dic = [
            '¡' => 'í',
            '£' => 'ú',
            'M ximo' => 'Máximo',
            'Mdia ' => 'Média'
        ];

        return strtr($var, $dic);
    }
}