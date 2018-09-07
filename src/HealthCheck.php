<?php

/**
 * Essa classe fornece uma interface de consulta ou consumo de páginas web.
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016-2018, Fábio J L Ferreira
 */

namespace Crphp\Check;

class HealthCheck
{
    /**
     * Armazena uma instância de Curl.
     *
     * @var resource
     */
    private $curl;

    /**
     * Cabeçalho a ser enviado.
     *
     * @var array
     */
    private $header;

    /**
     * Armazena as informações referentes a requisição.
     *
     * @var array
     */
    private $info;

    /**
     * Armazena o conteúdo retornado pela consulta.
     *
     * @var string
     */
    private $content;

    /**
     * Atribui alguns valores considerados padrão.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
    }

    /**
     * Define o tempo máximo do pedido.
     *
     * @param   int     $timeout    Em segundos.
     *
     * @return  \Crphp\Check\HealthCheck
     */
    public function setTimeOut($timeout = 180)
    {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);

        return $this;
    }
    
    /**
     * Define o agente a ser utilizado.
     * 
     * @param   string  $agent
     *
     * @return  \Crphp\Check\HealthCheck
     */  
    public function setAgent($agent = "PHP Health Check")
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, $agent);

        return $this;
    }

    /**
     * Adiciona o conteúdo e atribui um cabeçalho a requisição.
     *
     * @param   string  $target
     * @param   array   $header
     * @param   array   $increment
     *
     * @return  \Crphp\Check\HealthCheck
     */
    public function setRequest($target, array $header = null, array $increment = null)
    {
        if (! $header) {
            $this->header = [
                'Content-type: */*;charset=UTF-8',
                'Accept:  */*',
                'Cache-Control: no-cache',
            ];

            if ($increment) {
                $this->header = array_merge($this->header, $increment);
            }
        }

        curl_setopt($this->curl, CURLOPT_URL, $target);

        return $this;
    }

    /**
     * * Dispara a consulta contra o serviço informado.
     *
     * @return void
     */
    public function doRequest()
    {
        $this->content = curl_exec($this->curl);
        $this->info = curl_getinfo($this->curl);

        curl_close($this->curl);
    }

    /**
     * Define regras de redirecionamento de URL, tais como se deve serguir redirecionamentos, total
     * de redirecionamentos aceitos e se deve ser aplicado refresh caso um redirect seja seguido.
     *
     * @param   bool  $redirect
     * @param   int   $redirectNum
     * @param   bool  $refresh
     *
     * @return  \Crphp\Check\HealthCheck
     */
    public function setRedirect($redirect = true, $redirectNum = 5, $refresh = true)
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $redirect);
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, $redirectNum);
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, $refresh);

        return $this;
    }

    /**
     * Informações da requisição obtidos do método curl_getinfo.
     *
     * @see http://php.net/manual/pt_BR/function.curl-getinfo.php
     *
     * @return  array
     */
    public function getHeader()
    {
        return [
            'raw_info'      => $this->info,
            'http_code'     => $this->info['http_code'],
            'total_time'    => round($this->info['total_time'] * 1000) . ' ms',
            'size_upload'   => round($this->info['size_upload'] / 1024, 2) . ' KB',
        ];
    }

    /**
     * Retorna o output devolvido pelo servidor alvo.
     *
     * @return  null|string     Em caso de sucesso retorna vazio, para erro retorna string.
     */
    public function getResponse()
    {
        $status = $this->getHeader()['raw_info']['http_code'];

        if ($status === 500 || $status === 404 || $status === 403 || !$this->content) {
            return null;
        }

        return $this->content;
    }
        
    /**
     * Verifica se determinada string existe no contexto da página consultada.
     * 
     * @param   string  $search
     *
     * @return  bool
     */
    public function searchString($search)
    {
        /** @internal Se a string pesquisada for encontrada retorna true. */
        return (strpos(strtolower($this->content), strtolower($search)) === false) ? false : true;
    }
}