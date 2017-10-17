
create table `acl_aro`(
    `id` bigint(20) not null,
    `created` datetime default null,
    primary key (`id`)
);

create table `acl_aro_link`(
    `acl_aro_id` bigint(20) not null,
    `acl_sub_aro_id` bigint(20) not null,
    `item` smallint not null default 1,
    `created` datetime default null,
    primary key (`acl_aro_id`,`acl_sub_aro_id`),
    foreign key (`acl_aro_id`) references `acl_aro`(`id`) on delete cascade on update cascade,
    foreign key (`acl_sub_aro_id`) references `acl_aro`(`id`) on delete cascade on update cascade
);

create table `acl_aro_name`(
    `id` bigint(20) not null,
    `name` varchar(64) not null,
    `created` datetime default null,
    `modified` datetime default null,
    primary key (`id`),
    foreign key (`id`) references `acl_aro`(`id`) on delete cascade on update cascade,
    unique (`name`)
);


create table `acl_aco`(
    `id` bigint(20) not null,
    `created` datetime default null,
    primary key (`id`)
);

create table `acl_aco_link`(
    `acl_aco_id` bigint(20) not null,
    `acl_sub_aco_id` bigint(20) not null,
    `item` smallint not null default 1,
    `created` datetime default null,
    primary key (`acl_aco_id`,`acl_sub_aco_id`),
    foreign key (`acl_aco_id`) references `acl_aco`(`id`) on delete cascade on update cascade,
    foreign key (`acl_sub_aco_id`) references `acl_aco`(`id`) on delete cascade on update cascade
);

create table `acl_aco_name`(
    `id` bigint(20) not null,
    `name` varchar(64) not null,
    `created` datetime default null,
    `modified` datetime default null,
    primary key (`id`),
    foreign key (`id`) references `acl_aco`(`id`) on delete cascade on update cascade,
    unique (`name`)
);

create table `acl_alo`(
    `id` bigint(20) not null,
    `created` datetime default null,
    primary key (`id`)
);

create table `acl_alo_link`(
    `acl_alo_id` bigint(20) not null,
    `acl_sub_alo_id` bigint(20) not null,
    `item` smallint not null default 1,
    `created` datetime default null,
    primary key (`acl_alo_id`,`acl_sub_alo_id`),
    foreign key (`acl_alo_id`) references `acl_alo`(`id`) on delete cascade on update cascade,
    foreign key (`acl_sub_alo_id`) references `acl_alo`(`id`) on delete cascade on update cascade
);

create table `acl_alo_name`(
    `id` bigint(20) not null,
    `name` varchar(64) not null,
    `created` datetime default null,
    `modified` datetime default null,
    primary key (`id`),
    foreign key (`id`) references `acl_alo`(`id`) on delete cascade on update cascade,
    unique (`name`)
);

create table `acl_item`(
    `id` bigint(20) not null AUTO_INCREMENT,
    `acl_aro_id` bigint(20) not null,
    `acl_aco_id` bigint(20) not null,
    `acl_alo_id` bigint(20) not null,
    `start` datetime default null,
    `stop` datetime default null,
    `created` datetime default null,
    `modified` datetime default null,
    primary key (`id`),
    foreign key (`acl_aro_id`) references `acl_aro`(`id`) on delete cascade on update cascade,
    foreign key (`acl_aco_id`) references `acl_aco`(`id`) on delete cascade on update cascade,
    foreign key (`acl_alo_id`) references `acl_alo`(`id`) on delete cascade on update cascade
);

create view `acl_access`(`acl_aro_id`,`acl_aco_id`,`acl_alo_id`,`start`,`stop`) AS
SELECT `R`.`acl_sub_aro_id`, `C`.`acl_sub_aco_id`, `L`.`acl_sub_alo_id`, max(`A`.`start`), min(`A`.`stop`)
from `acl_item` A, `acl_aro_link` R, `acl_aco_link` C, `acl_alo_link` L
where `A`.`acl_aro_id`=`R`.`acl_aro_id` and `A`.`acl_aco_id`=`C`.`acl_aco_id` and `A`.`acl_alo_id`=`L`.`acl_alo_id`
group by `R`.`acl_sub_aro_id`, `C`.`acl_sub_aco_id`, `L`.`acl_sub_alo_id`;

