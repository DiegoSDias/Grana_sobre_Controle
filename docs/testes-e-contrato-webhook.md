# Testes e contrato do webhook

## Ambiente de testes

Execute `php artisan test` ou `php vendor/bin/phpunit` com as dependências de desenvolvimento e a extensão `pdo_sqlite` instaladas. O PHPUnit define o ambiente de teste e o SQLite em memória, mas variáveis herdadas do sistema ou configuração em cache podem prevalecer. A classe base verifica a configuração efetiva antes da preparação do banco e interrompe a execução se ela não for segura; conexões de banco alternativas não ficam disponíveis nos testes. Se o bloqueio ocorrer, confira as variáveis de ambiente e o cache de configuração antes de alterá-los; o cache pode ser usado pela aplicação em execução.

O cliente HTTP do Laravel rejeita requisições externas que não tenham resposta simulada. Testes que precisem de HTTP devem usar `Http::fake()` ou simular o serviço. A proteção não intercepta outros clientes de rede ou código que altere explicitamente a configuração em tempo de execução. Não executar testes reais contra a Pluggy sem autorização específica. Fila, e-mail, sessão e cache usam configurações de teste; testes que verificam enfileiramento devem usar `Queue::fake()`.

## Página inicial

`GET /` exige autenticação: visitantes são redirecionados à tela de login; usuários autenticados recebem o dashboard com HTTP 200.

## `POST /webhooks/pluggy`

- O endpoint aceita JSON e exige o segredo configurado na aplicação, enviado no parâmetro `token` da URL.
- Para evento válido e autenticado, o contrato atual é **HTTP 200 sem corpo**, inclusive para uma entrega repetida. O evento é persistido e o job é despachado. Com uma fila assíncrona, o 200 não significa que o processamento terminou ou teve sucesso; com o driver `sync`, o job executa durante a requisição e pode atrasar a resposta.
- Eventos são identificados por `eventId`; uma repetição não deve criar outro registro de evento nem agendar outro job de processamento.
- Conteúdo que não seja JSON recebe 415; segredo ausente, incorreto ou não configurado recebe 401; campos obrigatórios inválidos recebem 400. Conflito de proprietário também recebe 401.
- A documentação da Pluggy aceita respostas 2xx dentro do prazo estabelecido para confirmar o recebimento: https://docs.pluggy.ai/en/docs/developer-tools/webhooks-ref. Assim, 200 é uma escolha do contrato deste projeto, e não uma exigência específica de 200 pela Pluggy.

O teste do retorno e do agendamento usa banco em memória e fila simulada; ele não comprova entrega real, tempo de resposta em produção nem conclusão da sincronização. A análise operacional e a estabilização de webhooks pertencem aos módulos posteriores.
