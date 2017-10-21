delimiter $$
create procedure VerifyUser
  (in myusername nvarchar(20))
BEGIN 
select users.id from users where users.username = myusername;
END $$

delimiter $$
create procedure SaveUser
  (in myusername nvarchar(20),in myfullname nvarchar(40),in mypass nvarchar(20))
BEGIN 
insert into users(username,fullname,pass,role) 
values (myusername,myfullname,mypass,4);
END $$

delimiter $$
create procedure Deleteblog
  (in mykey int)
BEGIN 
delete from blogs where bid = mykey;
END $$

	delimiter $$
	create procedure deleteuser
	  (in myuid int)
	BEGIN 
	Delete from users where id = myuid;
	END $$

delimiter $$
create procedure Deletepage
  (in mykey int)
BEGIN 
delete from pages where id = mykey;
END $$


delimiter $$
create procedure Editblog
  (in mykey int,in mytitle nvarchar(50),in mytime nvarchar(50),in mybody varchar(2000) character set utf8,in myimage int)
BEGIN
update blogs
set title = mytitle , time = mytime , body = mybody, image = myimage
where bid = mykey;
END $$

delimiter $$
create procedure Editpages
(in mykey int, in mytitle nvarchar(50),in mybody varchar(2000),in mytime varchar(50))
Begin
update pages
set title = mytitle , body = mybody, time = mytime
where id = mykey;
end $$


delimiter $$
create procedure addpage
  (in mytitle nvarchar(50),in mytime nvarchar(50),in mybody varchar(2000) character set utf8)
BEGIN 
insert into pages(title,body,time)
values(mytitle,mybody,mytime);
END $$


delimiter $$
create procedure addcomment
  (in myposter int,in myblog int,in mybody varchar(2000) character set utf8)
BEGIN 
insert into comments(blog,poster,body,time)
values(myblog,myposter,mybody,mytime);
END $$

delimiter $$
create procedure promote
  (in myid nvarchar(20),in myrole int)
BEGIN 
update users
set role = myrole
where id = myid;
END $$

delimiter $$
create procedure pagination
(in mypage int)
Begin
select * from blogs Limit 3 Offset mypage;
end $$


