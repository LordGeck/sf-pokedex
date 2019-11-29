# sf-pokedex

Pokedex example using Symfony 4.2, Bootstrap 4, PHP 7.3.
Frontend uses twig templates and Webpack Encore.
Object relational mapping with Doctrine and MySQL.

Pagination with KnpPaginatorBundle.
Image management and upload with VichUploaderBundle.

Makes use of Symfony components : ApachePack, Console, Expresion-Language, Flex, Form, Monolog, Security, Stopwatch, SwiftMailer, Translation, Validator.


# Site map

/
Home page

/pokemon
List of all pokemon

/pokemon/{pokedexNb}
Details of a pokemon

/attack
List of all attacks

/attack/{id}
Details of an attack

/contact
Contact page

/login /logout /account
User login system

/admin/attack (GET POST DELETE) *
Attack management CRUD

/admin/pokemon (GET POST DELETE) *
Pokemon management CRUD

*Logged in required


