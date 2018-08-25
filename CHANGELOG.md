# Release Notes

## v2.0.0 (2018-08-24)

### Changed

- Reescrita e reestruturação da classe `HealthCheck` [(58f81c1)](https://github.com/crphp/check/commit/58f81c1181fe975be499c62259971b80257099f1)
- Classe `Traceroute` refatorada [(02f6bb4)](https://github.com/crphp/check/commit/02f6bb4223fabaf60410585fd844ca0bbab9216b)
- Classe `Socket` refatorada [(4551da0)](https://github.com/crphp/check/commit/4551da0e80e111ca494dff8a6c16be3aa17e7768)
- Refatoração da classe `Ping` para adequação de código e documentação [(0d66c3e)](https://github.com/crphp/check/commit/0d66c3e01db7637d821c09113822b8393291b0be)
- Classe `Ping` ajustada para permitir melhor identificação do **SO** e comando a ser executado [(62abd42)](https://github.com/crphp/check/commit/62abd4251dad2ad406b7a8ba0d6e5f4e7f270b01)

## v1.1.0 (2017-10-05)

### Added

- Método getInfo adicionado a classe HealthCheck

### Changed

- HealthCheck: Agora é possível utilizar Fluent Interfaces
- Ping: agora os métodos são estáticos
- Socket: pequena alteração na mensagem do dicionário de máquinas Microsoft
- Traceroute: agora os métodos são estáticos

## v1.0.0 (2016-11-27)

### Added

- HealthCheck: consulta de status HTTP e verificação via consulta de string
- Ping: disparo de ping
- Socket: teste de conectividade a nível de socket
- Traceroute: mapeamento de rota