# crphp/check

<a href="https://packagist.org/packages/crphp/check"><img src="https://poser.pugx.org/crphp/check/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/crphp/check"><img src="https://poser.pugx.org/crphp/check/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/crphp/check"><img src="https://poser.pugx.org/crphp/check/license.svg" alt="License"></a>

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

## 1 - <a name="referencias"></a>Referências

- [PSR-1](http://www.php-fig.org/psr/psr-1/)
- [PSR-2](http://www.php-fig.org/psr/psr-2/)
- [RFC 2119](http://tools.ietf.org/html/rfc2119) (tradução livre [RFC 2119 pt-br](http://rfc.pt.webiwg.org/rfc2119))

## 2 - <a name="funcionalidades"></a>Funcionalidades

- [x] Health Check
- [x] Ping
- [x] Socket
- [x] Tracert / Traceroute

## 3 - <a name="requisitos">Requisitos (módulos)

Os módulos abaixos já estão definidos no arquivo composer.json, isso significa que serão validados automaticamente.

- REQUER ext-curl
- REQUER ext-sockets

## 4 - <a name="download"></a>Baixando o pacote crphp/check

Para a etapa abaixo estou pressupondo que você tenha o composer instalado e saiba utilizá-lo:
```
composer require crphp/check
```

Ou se preferir criar um projeto:
```
composer create-project --prefer-dist crphp/check nome_projeto
```

Caso ainda não tenha o composer instalado, obtenha este em: https://getcomposer.org/download/

## 5 - <a name="exemplos"></a>Exemplos de uso

**Obs:** este é um exemplo simples, funcionalidades adicionais estão disponíveis em cada pacote.

**Health Check**:
```
use Crphp\Check\HealthCheck;

$obj = new HealthCheck;

$obj->setRequest("http://www.terra.com.br")
    ->setAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50")
    ->setRedirect()
    ->doRequest();

echo ($obj->searchString('esportes')) ? 'String encontrada!' : 'String não encontrada!' ;

// Retorna um array contendo o cabeçalho da resposta
// $obj->getHeader();

// Ao manter htmlentities o código html será mostrado. Ao omitir htmlentities o conteúdo será renderizado no navegador.
// echo htmlentities($obj->getResponse());
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
```
use Crphp\Check\Socket;

$result = Socket::run( 'www.google.com.br', 80);
echo ($result === true) ? 'Tudo ok ;)' : $result;
```

**Traceroute/Tracert**
```
use Crphp\Check\Traceroute;

$output = Traceroute::run("google.com.br", 2);

if (is_array($output)) {
    echo '<pre>' . Traceroute::toString($output) . '</pre>';
} else {
    echo 'Não foi possível executar o tracer';
}
```

## 6 - <a name="licenca"></a>Licença (MIT)
Todo o conteúdo presente neste diretório segue o que determina a licença [MIT](https://github.com/crphp/check/blob/master/LICENSE).