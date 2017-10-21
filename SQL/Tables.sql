
create table role (
id int not null primary key,
name nvarchar(20)
);

create table users(
id int not null primary key auto_increment,
username nvarchar(20),
fullname nvarchar(20),
pass nvarchar(20),
role int not null,
foreign key (role) references role(id)
);

create table image(
ikey int not null primary key auto_increment,
name nvarchar(20),
content longblob
);

create table blogs(
Bid int not null primary key auto_increment,
title nvarchar(50),
time nvarchar(60),
blogger int not null,
foreign key (blogger) references users(id),
body VARCHAR(2000) CHARACTER SET utf8,
image int not null,
foreign key (image) references image(ikey),
category nvarchar(50)
); 

create table pages(
id int not null primary key auto_increment,
title nvarchar(50),
body varchar(2000) character set utf8,
time varchar(50)
);

create table comments(
id int not null primary key auto_increment,
poster int not null,
foreign key (poster) references users(id),
blog int not null,
foreign key (blog) references blogs(bid),
body varchar(2000) character set utf8
);

create table tag(
id int not null primary key auto_increment,
name nvarchar(40),
blog int not null,
foreign key (blog) references blogs(bid)
);

