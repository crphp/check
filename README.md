# crphp/check
Está é uma biblioteca genérica voltada a efetuar testes/verificação de conectividade.

Está biblioteca segue os padrões descritos na [PSR-2](http://www.php-fig.org/psr/psr-2/), logo, 
isso implica que a mesma está em conformidade com a [PSR-1](http://www.php-fig.org/psr/psr-1/).

As palavras-chave "DEVE", "NÃO DEVE", "REQUER", "DEVERIA", "NÃO DEVERIA", "PODERIA", "NÃO PODERIA", 
"RECOMENDÁVEL", "PODE", e "OPCIONAL" neste documento devem ser interpretadas como descritas no 
[RFC 2119](http://tools.ietf.org/html/rfc2119). Tradução livre [RFC 2119 pt-br](http://rfc.pt.webiwg.org/rfc2119).

1. [Referências](#referencia)
1. [Funcionalidades](#funcionalidades)
1. [Requisitos (módulos)](#requisitos)
1. [Baixando o pacote crphp/check](#download)
1. [Exemplos de uso](#exemplos)
1. [Licença (MIT)](#licenca)

## 1 - <a id="referencias"></a>Referências
 - [PSR-1](http://www.php-fig.org/psr/psr-1/)
 - [PSR-2](http://www.php-fig.org/psr/psr-2/)
 - [RFC 2119](http://tools.ietf.org/html/rfc2119). Tradução livre [RFC 2119 pt-br](http://rfc.pt.webiwg.org/rfc2119)

## 2 - <a id="funcionalidades"></a>Funcionalidades
- [x] Health Check
- [x] Ping
- [x] Socket
- [x] Tracert / Traceroute

## 3 - <a id="requisitos">Requisitos (módulos)
Os módulos abaixo se fazem necessário para que está biblioteca possa ser utilizada:
- REQUER Curl
- REQUER Socket

**Obs:** Provavelmente você já tem instalado e ativo os módulos acima, porém, se algo der errado 
você já sabe o que deve olhar primeiro ;)

## 4 - <a id="download"></a>Baixando o pacote crphp/check

Para a etapa abaixo estou pressupondo que você tenha o composer instalado e saiba utilizá-lo:
```
composer require crphp/check
```

Ou se preferir criar um projeto:
```
composer create-project --prefer-dist crphp/check nome_projeto
```

Caso ainda não tenha o composer instalado, obtenha este em: https://getcomposer.org/download/

## 5 - <a id="exemplos"></a>Exemplos de uso

**Obs:** este é um exemplo simples, funcionalidades adicionais estão disponíveis em cada pacote.

**Health Check**:
```php
use Crphp\Check\HealthCheck;

$obj = new HealthCheck;

$obj->setURL("http://www.terra.com.br");
$obj->setAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50"); //opcional
$obj->setRedirect();
$statusHttp = $obj->run();
var_dump($statusHttp, $obj->buscarString('esportes'));

\\ ou fluent interface
use Crphp\Check\HealthCheck;

$obj = new HealthCheck;

$statusHttp = $obj->setURL("http://www.terra.com.br")
                    ->setAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50")
                    ->setRedirect()
                    ->run();

var_dump($statusHttp, $obj->buscarString('esportes'));
```

**Ping**
```
use Crphp\Check\Ping;

$output = Ping::run('www.google.com.br');

if (is_array($output)) {
    echo '<pre>' . Ping::toString($output) . '</pre>';
} else {
    echo 'Não foi possível executar o ping';
}
```

**Socket**
```php
use Crphp\Check\Socket;

$obj = new Socket;
echo $obj->run('www.google.com.br', 22) ? 'Tudo ok ;)' : $obj->getMensagem();
```

**Traceroute/Tracert**
```php
use Crphp\Check\Traceroute;

$output = Traceroute::run("www.google.com.br", 3); // endereço e total de saltos
echo ($output) ? Traceroute::toString($output) : 'Destino não encontrado';
```

## 6 - <a id="licenca">Licença (MIT)
Para maiores informações, leia o arquivo de licença disponibilizado junto desta biblioteca.