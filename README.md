# Sistema Acadêmico para Educação à Distância do Instituto Federal de Educação do Tocantins (EaD/IFTO)

Sistema acadêmico para gerenciamento de cursos, turmas, alunos e todo o processo referente a registro de notas, presenças, 
geração de relatórios e históricos escolares.


# Tecnologia

## Linguagem e Framework
O sistema é desenvolvida em PHP 5.3 com o framework MVC [VorticePHP](http://github.com/caferrari/vorticephp)
que também provê algumas funcionalidades básicas de mapeamento objeto-relacional (ORM).

## Banco de Dados

O banco de dados atualmente utilizado é o MySQL 5, mas o framework utilizado permite a fácil alteração para outros bancos.
No entanto, como não é utilizado um framework ORM completo, o sistema utiliza SQL como linguagem de consulta,
podendo ter sido utilizadas instruções que são dependentes do MySQL.

# Instalação e Configuração

Para instalar o sistema, basta ter um servidor Apache 2.4 ou superior com o módulo mod_rewrite habilitado.
As configurações de acesso ao banco de dados são definidas no arquivo [MasterController.php](app/controller/MasterController.php)

# Documentação

O sistema possui alguma documentação na pasta [docs](docs), como: 
- [Diagrama de Entidade e Relacionamentos](docs/academico.mwb) gerado com o MySQL Workbench
- [Script MySQL com estrutura e dados do banco](docs/academicoead.sql)
- [Documentação HTML](docs/phpdoc) gerada com PhpDoc que está incluso como dependência [Composer](http://getcomposer.org) 
no arquivo [composer.json](composer.json). Com o Composer instalado, para gerar a documentação HTML basta
executar `vendor/bin/phpdoc` no terminal


# Autor

Sistema desenvolvidor por [Manoel Campos da Silva Filho](http://manoelcampos.com), professor da Coordenação de Informática 
do campus Palmas do IFTO.