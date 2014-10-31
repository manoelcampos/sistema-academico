<?
/*
exit(0);

create table segur_sistema (
    id      integer not null auto_increment ,
    sistema  varchar(50) not null,
    sigla    varchar(20) not null ,
    constraint pk_segur_sistema primary key (id)
);

create table segur_pagina (
    id         integer not null auto_increment,
    id_sistema  integer not null,
    titulo      varchar(50) not null,
    pagina  varchar(50) not null,
    alias varchar(50) null comment 'Alias (route) utilizada para uma página, que dá acesso a ela por meio de um nome mais amigável', 
    constraint pk_segur_pagina primary key (id)
) comment 'Cadastro das páginas do sistema.';


create table segur_pagina_acao (
  id integer not null auto_increment,
  id_pagina int not null,
  acao varchar(50) not null,
  constraint pk_segur_pagina_acao primary key (id),
  constraint fk_segur_pagina_acao_pagina foreign key (id_pagina) references segur_pagina(id)
) comment 'Cadastro das ações associadas às páginas (views). Estas incluem todas as ações de cada view do modelo MVC. Por exemplo, pode-se cadastrar index, adicionar, editar, excluir';

create table segur_grupo (
    id         integer not null auto_increment,
    grupo       varchar(50) not null,
    id_sistema  integer not null,
    tipo        char(1) not null comment 'A - Administrador (acesso sem vínculo a um curso. Podem existir vários grupos administradores com diferentes acessos), C - Coordenador (acesso apenas aos cursos que coordena), P - Professor (acesso apenas aos cursos que leciona)',
    constraint pk_segur_grupo primary key (id)
);

create table segur_permissao_grupo (
    id integer not null auto_increment,
    id_grupo   integer not null,
    id_pagina_acao  integer not null,
    constraint pk_segur_permissao_grupo primary key (id)
);

create table segur_grupo_usuario (
    id integer not null auto_increment,
    id_usuario  integer not null,
    id_grupo    integer not null,
    constraint pk_segur_grupo_usuario primary key (id)
);


alter table segur_pagina add constraint fk_pagina_sistema foreign key (id_sistema) references segur_sistema (id);
alter table segur_grupo_usuario add constraint fk_grupo_usuario_grupo foreign key (id_grupo) references segur_grupo (id);
alter table segur_grupo_usuario add constraint fk_grupo_usuario_usuario foreign key (id_usuario) references usuario (id);
alter table segur_permissao_grupo add constraint fk_permissao_grupo_pagina_acao foreign key (id_pagina_acao) references segur_pagina_acao (id);
alter table segur_permissao_grupo add constraint fk_permissao_grupo_grupo foreign key (id_grupo) references segur_grupo (id);


create unique index ix_segur_pagina on segur_pagina (id_sistema, pagina);
create unique index ix_segur_pagina_titulo on segur_pagina (id_sistema, titulo);
create unique index ix_segur_grupo on segur_grupo (grupo);
create unique index ix_segur_sistema on segur_sistema (sistema);
create unique index ix_segur_sistema_sigla on segur_sistema (sigla);
create unique index ix_grupo_usuario on segur_grupo_usuario(id_usuario, id_grupo);
create unique index ix_segur_permissao_grupo on segur_permissao_grupo(id_grupo, id_pagina_acao);
create unique index ix_segur_pagina_acao on segur_pagina_acao (id_pagina, acao);

create view vwsegur_permissao_grupo
as
select s.sigla as sigla_sistema, s.sistema, g.tipo as tipo_grupo, 
pag.titulo as titulo_pagina, pag.pagina,
permg.id_grupo, pag.id as id_pagina,
acao.acao
from segur_sistema  s
inner join segur_pagina pag on s.id = pag.id_sistema
inner join segur_pagina_acao acao on acao.id_pagina = pag.id
inner join segur_permissao_grupo permg on acao.id = permg.id_pagina_acao
inner join segur_grupo g on g.id = permg.id_grupo
;

create view vwsegur_paginas_grupo
as
select s.sigla as sigla_sistema, s.sistema, g.tipo as tipo_grupo, 
pag.titulo as titulo_pagina, pag.pagina,
permg.id_grupo, pag.id as id_pagina
from segur_sistema  s
inner join segur_pagina pag on s.id = pag.id_sistema
inner join segur_pagina_acao acao on acao.id_pagina = pag.id
inner join segur_permissao_grupo permg on acao.id = permg.id_pagina_acao
inner join segur_grupo g on g.id = permg.id_grupo
group by s.sigla, s.sistema, g.tipo, pag.titulo, pag.pagina, permg.id_grupo, pag.id
;


create view vwsegur_permissao_usuario
as
select s.sigla as sigla_sistema,
g.grupo, g.tipo as tipo_grupo,
gu.id_usuario, pag.titulo as titulo_pagina, pag.pagina, acao.acao
from usuario u
inner join segur_grupo_usuario gu on u.id = gu.id_usuario
inner join segur_permissao_grupo permg on gu.id_grupo = permg.id_grupo 
inner join segur_grupo g on permg.id_grupo = g.id 
inner join segur_sistema s on g.id_sistema = s.id 
inner join segur_pagina_acao acao on acao.id = permg.id_pagina_acao
inner join segur_pagina pag on acao.id_pagina = pag.id 
group by s.sigla, g.grupo, g.tipo, gu.id_usuario, pag.titulo, pag.pagina, acao.acao
;

insert into segur_sistema (sistema, sigla) values ('Sistema Acadêmico EaD', 'academico');

insert into `segur_pagina` 
(id_sistema, titulo, pagina, alias) values 
(1, 'Pólos', 'polo', null),
(1, 'Cursos', 'curso', null),
(1, 'Turmas', 'turma', null),
(1, 'Notas', 'aluno-turma-disciplina', 'notas'),
(1, 'Áreas Profissionais', 'area-profissional', null),
(1, 'Módulos', 'modulo', null),
(1, 'Disciplinas', 'disciplina', null),
(1, 'Usuários', 'usuario', null);

insert into `segur_pagina` 
(id_sistema, titulo, pagina, alias) values 
(1, 'Professores', 'professor', null);

*/
?>
