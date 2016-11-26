<?php

/**
 * Essa classe fornece uma interface de consulta ou consumo de páginas web
 * 
 * @package     crphp
 * @subpackage  check
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (consulte o arquivo license disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */

namespace Crphp\Check;

class HealthCheck
{
    /**
     * Armazena uma instância de Curl
     * 
     * @var object
     */
    private $curl;
    
    /**
     * Conteúdo da URL consultada
     *
     * @var string 
     */
    private $html;
    
    /**
     * Define algumas configurações padrões para o Curl
     * 
     * @return null
     */
    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
    }
    
    /**
     * Define a URL alvo e o tempo máximo do pedido, contando desde o tempo de 
     * conexão até o retorno da requisição
     * 
     * @param   string  $url
     * @param   int     $timeout
     * @return  null
     */    
    public function setURL($url, $timeout = 30)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
    }
    
    /**
     * Define o agente a ser utilizado
     * 
     * @param   string $agente
     * @return  null
     */  
    public function setAgent($agente = "PHP Health Check")
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, $agente);
    }
    
    /**
     * Define regras de redirecionamento de URL, tais como se deve serguir 
     * redirecionamentos, total de redirecionamentos aceitos e se deve ser 
     * aplicado refresh caso um redirect seja seguido
     * 
     * @param   bool  $redirect
     * @param   int   $numRedirect
     * @param   bool  $refresh
     * @return  null
     */  
    public function setRedirect($redirect = true, $numRedirect = 5, $refresh = true)
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $redirect);
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, $numRedirect);
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, $refresh);
    }

    /**
     * Executa a consulta a URL alvo
     * 
     * @return int
     */  
    public function run()
    {
        $this->html = curl_exec($this->curl);
        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);
        return $code;
    }
        
    /**
     * Verifica se determinada string existe no contexto da página consultada
     * 
     * @param   string $buscar
     * @return  bool
     */
    public function buscarString($buscar)
    {
        // se a string pesquisada for encontrada retorna true
        return (strpos(strtolower($this->html), strtolower($buscar)) === false) ? false : true;
    }
    
    /**
     * Retorna o html da URL alvo
     * 
     * @return string
     */
    public function html()
    {
        return htmlentities($this->html);
    }
}