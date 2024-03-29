Api Forms
--------

Esta é uma API de formulários desenvolvida utilizando php 8.1 e o framework laravel 10. 
Através deste sistema é possível gerenciar formularios e respostas. 
Está integrado disparo de e-mails para quando o cliente preenche todo o formulário e além disso possui um limitador de no máximo 100 respostas 
de clientes por mês. (Ao responder uma pergunta apenas do formulário já conta como consumo).

Foi abordada diferentes recursos para solucionar os desafios:
------------
- Helpers;
- Repositories;
- Listeners;
- DB Index. (Melhoria na performance por conta do alto volume de dados)

Documentação:
-
https://documenter.getpostman.com/view/22555988/2sA35Ea32w

---------
Instruções iniciais
---
Existem alguns seeders a serem rodados, realize nesta ordem para que possa ser gerado da maneira correta:

- FormSeeder;
- QuestionSeeder;
- AnswersSeeder.

Os outro seeders não possuem uma ordem especifica, rode como preferir.

----------

Como a API funciona:
-

Users:
Você pode criar um user através do store. Ele irá retornar um token que você irá utilizar para se autenticar e acessar a API por completo.

--------

Forms:
Aqui fica o core da aplicação. Através deste endPoint você pode cadastrar e consultar formulários. Podendo verificar até mesmo quantia de formulários
respondidos, filtrar por envios completos  e as respostas dadas as perguntas de forma amigável.

-------

Questions:
Existe um endPoint para poder lidar com as perguntas. Como um formulário pode ter um número ilimitado de perguntas tudo é gerenciado por um 
ponto especifico do sistema.

------

Answers:
Aqui é o endPoint onde o cliente irá enviar suas respostas. A cada formulário respondido por completo é disparado um email para o criador do form.

Nesta parte existe um campo chamado "idClient", nele é necessário que seja enviado um id para identificar de quem está realizando o envio. Poderiamos ter tratado
isso do lado da api, por exemplo, capturando o ip do usuário e utilizando como seu ID. Neste caso apenas para simplificar os teste deixei como um número aleatório para ser enviado 
pela requisição.

------

Styles:
Este é não é um ponto fundamental, porém ele da liberdade para que o usuário adicione e gerencie novas cores e tipografia ao sistema.

------


multiple_choices:
É um endPoint que gerencia as respostas possíveis para perguntas com multiplas alternativas.

------


Se houver alguma dúvida, feedback ou sugestão não exite em entrar em contato.


