<?php

/**
 * Classe genérica para teste de conectividade via socket
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016-2018, Fábio J L Ferreira
 */

namespace Crphp\Check;

use \RuntimeException;

class Socket
{
    /**
     * Dispara o teste de conexão.
     * 
     * @param   string  $host
     * @param   int     $port
     * @param   int     $timeout    Tempo em segundos.
     *
     * @return  true|string         Para sucesso retorna true, já para erro retorna uma string.
     */
    public static function run($host, $port, $timeout = 10)
    {
        try {
            /**
             * @see https://msdn.microsoft.com/en-us/library/windows/desktop/ms740668(v=vs.85).aspx
             */
            $dic = [
                110   => "Time Out ao tentar se conectar ao destino: <strong>{$host}</strong>",
                113   => "Não existem rotas para o destino: <strong>{$host}</storng>",
                10056 => "Já existe uma conexão socket aberta para o host <strong>{$host}</storng>",
                10057 => "Não foi possível conectar ao socket na chamada do host <strong>{$host}</storng>",
                10060 => "Time Out ao tentar se conectar ao destino: <strong>{$host}</storng>",
                10061 => "Conexão recusada pelo destino: <strong>{$host}<storng>>"
            ];

            if (! $socket = @fsockopen($host, $port, $errno, $errstr, $timeout)) {
                $msg = (array_key_exists($errno, $dic)) ? strtr($errno, $dic) : $errstr;
                throw new RuntimeException("Erro ({$errno}): {$msg}");
            }

            /** @internal Fecha o socket para liberar o recurso */
            fclose($socket);
            return true;
        } catch (RuntimeException $e) {
            return $e->getMessage();
        }
    }
}