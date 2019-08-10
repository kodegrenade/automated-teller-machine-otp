# PHP BANK SQL
create table users(
id int(11) auto_increment key,
name varchar (255) not null,
email varchar (255) not null,
account_type varchar (255) not null,
account_no varchar (255) not null,
account_bal varchar (255) not null,
code varchar (255) not null,
pin_code varchar (255) not null,
atm_digit varchar (5) not null,
created_at timestamp not null
);

create table deposit(
id int(11) auto_increment key,
name varchar (255) not null,
amount varchar (255) not null,
account_no varchar (255) not null,
);

create table valid_account(
id int(11) auto_increment key,
bvn_no varchar (255) not null,
name varchar (255) not null,
email varchar (255) not null,
account_type varchar (255) not null,
account_no varchar (255) not null,
code varchar (255) not null,
pin_code varchar(255) not null,
atm_digit varchar (5) not null,
validated_at timestamp not null
);