Api Forms
--------

Esta é uma API de formulários desenvolvida utilizando php 8.1 e o framework laravel 10. 
Através deste sistema é possível gerenciar formularios e respostas. 
Está integrado disparo de email para quando o cliente preenche todo o formulário e além disso possui um limitador de no máximo 100 respostas 
de clientes por mês. (Ao responder uma pergunta apenas do formulário já conta como consumo).

Foi abordada diferentes recursos para solucionar os desafios:
----
- Helpers;
- Repositories;
- Listeners;
- DB Index. (Melhoria na performance por conta do alto volume de dados)

Documentação:
-------
https://documenter.getpostman.com/view/22555988/2sA35Ea32w

---------
Instruções iniciais

Existem alguns seeders a serem rodados, realize neste ordem para que possa se gerado da maneira correta:

- FormSeeder;
- QuestionSeeder;
- AnswersSeeder.

Os outro seeders não possuem uma ordem necessária, rode como preferir.

----------

Como a API funciona:

Users:
Você pode criar um user através do store. Ele irá retornar um token que você irá utilizar para se autenticar e acessar a API por completo.

--------

Forms:
Aqui fica core da aplicação. Através deste endPoint você pode cadastrar e consultar formulários. Podendo verificar até mesmo quantia de formulários
respondidos, filtrar por envios completos  e as respostas dadas as perguntas de forma amigável.

-------

Questions:
Existe um endPoint especifico para poder lidar com as perguntas, como 1 formulário pode ter um número ilimitado de perguntas tudo é gerenciado por um 
ponto especifico.

------

Answers:
Aqui é o endPoint onde o cliente irá enviar suas respostas. A cada formulário respondido por completo é disparado um email para o criador do form.

------

Styles:
Este é um ponto não fundamental porém que da liberdade para o usuário adicionar e gerenciar novas cores com uma tipografia ao sistema.

------


multiple_choices:
É um endPoint que gerencia as respostas possível para perguntas com multiplas alternativas.

------


Se houver alguma dúvida, feedback ou sugestão não exite em entrar em contato.


