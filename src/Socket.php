<?php

/**
 * Classe genérica para teste de conectividade via socket
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016 - 2017, Fábio J L Ferreira
 */

namespace Crphp\Check;

use \RuntimeException;

class Socket
{
    /**
     * Armazena a(s) mensagens de erro
     * 
     * @var string 
     */
    private $mensagem;
    
    /**
     * Dispara o teste de conexão
     * 
     * @param   string  $host
     * @param   int     $porta
     * @param   int     $timeout
     * @return  bool
     */
    public function run($host, $porta, $timeout = 10)
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

            if(!$socket = @fsockopen($host, $porta, $errno, $errstr, $timeout)) {
                $mensagem = (array_key_exists($errno, $dic)) ? strtr($errno, $dic) : $errstr;
                throw new RuntimeException("Erro ({$errno}): {$mensagem}");
            }

            fclose($socket); // Fecha o socket aberto anteriormente
            return true;
        } catch (RuntimeException $e) {
            $this->mensagem = $e->getMessage();
            return false;
        }
    }
    
    /**
     * Retorna a mensagem de erro de conexão caso exista
     * 
     * @return string|null
     */
    public function getMensagem()
    {
        if($this->mensagem) {
            return $this->mensagem;
        }
    }
}