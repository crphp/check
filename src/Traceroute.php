<?php

/**
 * Está classe permite rastrear o caminho "até o alvo".
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016-2018, Fábio J L Ferreira
 */

namespace Crphp\Check;

class Traceroute
{
    /**
     * Realiza o disparo do traceroute via SO, ou seja, o tracer é realizado pelo próprio sistema operacional,
     * e não pelo PHP. É importante que seu sistema disponha deste comando para que esse método atinja seu objetivo.
     * 
     * @param   string      $target
     * @param   int         $jumps
     *
     * @return  array|null  Em caso de sucesso retorna uma string.
     */
    public static function run($target, $jumps = 15)
    {
        /** @internal Utiliza PHP_OS para determinar se o sistema é Windows ou outro. */
        $command_option = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'tracert -h' : 'traceroute -m';

        exec("{$command_option} {$jumps} {$target}", $output, $status);

        /** @internal Em caso de sucesso ($status = 0) será retornado um array contendo o resultado dos testes. */
        return ($status === 0) ? $output : null;
    }
    
    /**
     * Converte o retorno do método run para string.
     * 
     * @param   array   $traceroute
     *
     * @return  string
     */
    public static function toString(Array $traceroute)
    {
        $var = '';
        foreach ($traceroute as $row)
        {
            $var .= utf8_encode($row) . "\n";
        }
        
        $dic = [
            '¡' => 'í',
            'm ximo' => 'máximo',
        ];
        
        return strtr($var, $dic);
    }
}