<?php
session_start();
	  
   include('dblib.php');
   //////////////////POSTING THE BLOGS
   $blogs ='';
   $comments = '';
   $realpage='';
   $edited='';
   $con = db_connection();
   $count = db_query("select count(bid) from blogs",$con);
   $blogrow = $count->fetch_assoc();
   $blogcount = $blogrow['count(bid)'];
   //Pagination
   if(!isset($_POST['page'])){
	   $_SESSION['realpage'] = $blogcount-3;
	   $realpage = $_SESSION['realpage'];
	   }
   if(isset($_POST['page'])){
	   if($_POST['page'] == 0){
			   $_SESSION['realpage'] -=3;
		  $realpage = $_SESSION['realpage']; 
		  if($realpage < 0){
			  $_SESSION['realpage'] = 0;
			  $realpage = 0;
			  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">There is no older Blog!</div>';
			  }
		   }
		   if($_POST['page'] == 1){
			   $_SESSION['realpage'] +=3;
		  $realpage = $_SESSION['realpage'];
		  if($realpage >= $blogcount){
			    $_SESSION['realpage'] -=3;
		  $realpage = $_SESSION['realpage'];
		    $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">There is no newer blog!</div>';
			  
			}
		   }
	   }
	   ////
   $result = db_query("
Select blogs.*,username,content from blogs,users,image where id = blogger and image = ikey order by time limit 3 offset $realpage ",$con);
   while($row = $result->fetch_assoc()){
	  		
	 if((!isset($_POST['login'])) && (!isset($_COOKIE['login']))){
		$comments = '<form method="post">Your Comment as Guest:<textarea class="form-control" cols="200" row="8" name="commentbody" > </textarea><br><button type="submit" class="btn btn-primary" name="guestcomment" value="'.$row['Bid'].'">Submit</button></form>';
		
		 }else    $comments = '<form method="get">Your Comment as User:<textarea class="form-control" cols="200" row="8" name="commentbody" ></textarea><br><button type="submit" class="btn btn-primary" name="comment" value="'.$row['Bid'].'">Submit</button></form>';
	   if($row['Edittag']==1){ $edited='Edited';
	  }else $edited = 'Posted';
	  $Bid = $row['Bid'];
	  ////Post comments
	  $resultcomment = db_query("select * from comments where blog='$Bid' ",$con);
	  $countresult0 = db_query("select count(id) from comments where blog='$Bid' and atag=1 order by time desc",$con);
	  $rowcount0 = $countresult0->fetch_assoc();
	  while($commentrow=$resultcomment->fetch_assoc()){
		  $commentbody  = $commentrow['body'];
		  $commentsender = $commentrow['poster'];
		  
		  $timecomment2 = $commentrow['time'];
		  if($commentsender){
		  $resultuser = db_query("select username from users where id='$commentsender'",$con);
		  $row2 = $resultuser->fetch_assoc();
		  $commentusername=$row2['username'];}
		  else $commentusername = 'Guest';
		  if($commentrow['atag']==1)
		  $comments = "<div class='col-ms-8'><h6 class='text-primary'>".$commentusername."</h6><p class='text-warning'><span class='glyphicon glyphicon-time'></span>Posted On ".$timecomment2."</p><p class='text'>".$commentbody."</p> </div><hr>".$comments;
		  }
		  
		  //blogs string 
	  $body = $row['body'];
	  $trimmed = substr($body,0,200);
	  	$commentcount = $rowcount0['count(id)'];
   $blogs = '<div id="'.$row['Bid'].'"><h4>
                    <a href="#">'. $row['title']. '</a>
                </h4>
                <p class="lead">
                    by <a href="index.php">'.$row['username'].'</a>
                </p>
				<p class="text-warning"><span class="glyphicon glyphicon-time"></span>'.$edited.' on '.$row['time'].'</p>
                <hr>
                <img class="img-responsive" height="200" width="900" src="data:image/jpeg;base64,'.base64_encode( $row['content'] ).'">
                <hr>
                <p>'.$trimmed.'...</p>
                <button  type="button" class="btn btn-primary" onClick="'."popup('".$row['Bid']."')".'">Read More <span class="glyphicon glyphicon-chevron-right"></span></button><div class="pull-right"><p class="text-primary"> <span class="glyphicon glyphicon-comment"></span> '.$commentcount.'</p></div>
				
				<div style="display:none;overflow:auto;background-color:black;max-height:600px;" class="col-md-8" id="popdiv'.$row['Bid'].'"><button class="btn btn-danger btn-xs btn-rounded" onClick="closepop1(this)"><span class="glyphicon glyphicon-remove"></span></button><h4>
                   
					<a href="#">'. $row['title']. '</a>
                </h4>
                <p class="lead">
                    by <a href="index.php">'.$row['username'].'</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$row['time'].'</p>
                
                <img class="img-rounded" height="200" width="700" src="data:image/jpeg;base64,'.base64_encode( $row['content'] ).'">
                <p>'.$body.'</p>'.
				//////////////////Comments
				
				'<hr><div class="col-md-8">'.$comments.'
				</div>
                </div></div>
                <hr>
' . $blogs;
   
   }
   //////////////////////////////////////////////////////////////
  //warningmsg set
   if(!isset($_POST['warning'])){
	   $_POST['warning'] = '';
	   }
	      
//initial data
$posterror = '';
$loginmsg='';
$adminpanel = '';
$bloggerpanel  = '';
$blogstring = '';
$signupform  =  "<form id='signup' method='post'><div class='input-group'><h2><a href='#'>Sign Up</a>
                </h2>Username<br><input type='text' name='username' class='form-control'>
<label for='password'>Password</label><br><input type='password' class='form-control' name='password'><label for='password_again'>Confirm password</label><br><input type='password' name='password_again' class='form-control' name='password'><p id='warning' class='text-warning'></p>Full Name<br><input type='text' name='name' class='form-control'><button class='btn btn-primary' type='submit' name='signup' value='Validate!' id='signupsubmit'>Submit</button></div></form>";


//Log In
if((isset($_POST['login']))||(isset($_COOKIE['login']))){
	if(!isset($_COOKIE['login'])){
   $con = db_connection();
   $username1 = $_POST['username'];
   $username = mysql_real_escape_string($username1);
   $usernametopost = $username;
   $password1 = $_POST['password'];
   
   $password = mysql_real_escape_string($password1);
   $rs = db_query("select * from users,role where users.username = '$username' and users.pass = '$password' and users.role = role.id ",$con);
   $row = db_fetch_row($rs);
   $loggedinrole  = $row['role'];
   if($row['id']!= null){
	   $logininfo =  "<h5><a href='#'>Username: </a></h5><p class='text-warning'>" . $row['fullname'] . "</p><br><p>". $row['name']. "</p><form method='post'><button class='btn btn-primary' type='submit' name='logout' value='1'>Log Out</button>" ;
	   setcookie("login", $username, time()+3600);
	   } 
	  else $logininfo = "<form method='post'><div class='input-group'><h2><a href='#'>Log In</a>
                </h2><p class='text-warning'>Invalid Username Or Password!</p>Username<br><input type='text' name='username' value='' class='form-control'>Password<br><input type='password' class='form-control' name='password' value=''><br><br><span class='btn-group-btn'><button class='btn btn-default' type='submit' name='login' value='login'>Login</button></form><button class='btn btn-default' id='sign' onclick='return false;'>Sign Up</button></span></div>";
	}
	else {
		$username = $_COOKIE['login'];
		$resultforuser = db_query("select * from users,role where users.username = '$username' and users.role = role.id",$con);
		$row = $resultforuser->fetch_assoc();
		$loggedinrole  = $row['role'];
		 $usernametopost = $username;
   
		 $logininfo =  "<h5><a href='#'>Username: </a></h5><p class='text-warning'>" . $row['fullname'] . "</p><br><p>". $row['name']. "</p><form method='post'><button class='btn btn-primary' type='submit' name='logout' value='1'>Log Out</button>" ;
	   }
	//Admin Panel
	if($row['role'] == 1){
		$createuserform = "<form id='createuser' method='post' style='margin-left:10%'><div class='input-group'><h6><a href='#'>Create user</a>
                </h2>Username<br><input type='text' name='ausername' class='form-control'>
<label for='password'>Password</label><br><input type='password' class='form-control' name='apassword'></p>Full Name<br><input type='text' name='aname' class='form-control'><p id='warning'></p><button class='btn btn-primary' type='button' name='createduser' value='1' id='createbutton'>Submit</button></div></form>";

	    $createuser = '<a href="#" class="dropdown-toggle" data-toggle="dropdown" >Create User</span></a><ul class="dropdown-menu" role="menu">
            <li class="createuser">'. $createuserform .'
			</li>
			</ul>';
			
		$con  = db_connection();
		$result = db_query("select * from users",$con);
		$count = count($row);
		$usertable = '';
		while($row = $result->fetch_assoc())
		{
			$username = $row['username'];
			$password  = $row['pass'];
			$fullname = $row['fullname'];
			$role = $row['role'];
			if($role == 1){
				$usertable .= "<tr><td>" . $username . "</td><td>" . $password . "</td><td>" . $fullname . "</td><td><p class='text-success'>Admin</p></td><td><form method='post'></td><td></td><td></td><td></td><td></td></tr>"; 
				
				}
			if($role == 2){
				$usertable .= "<tr><td>" . $username . "</td><td>" . $password . "</td><td>" . $fullname . "</td><td><p class='text-warning'>Moderator</p></td><td><form method='post'><button type='button' class='btn' id='remove' onclick='deleteuser(this);' value='$username'><span class='glyphicon glyphicon-remove'></span></button></form></td><td><button id='Makeadmin' type='button' value='$username' onClick='makeadmin(this);' class='btn btn-success btn-sm'>Make Admin</button></td><td></td><td></td></tr>"; 
				
				}
			if($role==3){
				$usertable .= "<tr><td>" . $username . "</td><td>" . $password . "</td><td>" . $fullname . "</td><td><p class='text-info'>Author</p></td><td><form method='post'><button type='button' class='btn' id='remove' onclick='deleteuser(this);' value='$username'><span class='glyphicon glyphicon-remove'></span></button></td><td><button id='Makemod' type='button' value='$username' onClick='makemod(this);' class='btn btn-warning btn-sm'>Make Moderator</button></form></td><td><button id='Makeadmin' type='button' value='$username' onClick='makeadmin(this);' class='btn btn-info btn-sm'>Make Admin</button></td><td></td></tr>"; 
				}
			if($role == 4){
				
				$usertable .= "<tr><td>" . $username . "</td><td>" . $password . "</td><td>" . $fullname . "</td><td><p class='text-primary'>User</p></td><td><form method='post'><button type='button' class='btn' id='remove' onclick='deleteuser(this);' value='$username'><span class='glyphicon glyphicon-remove'></span></button></form></td><td><button id='Makemod' type='button' value='$username' onClick='makemod(this);' class='btn btn-warning btn-sm'>Make Moderator</button></td><td><button id='Makemod' type='button' value='$username' onClick='makeauthor(this);' class='btn btn-info btn-sm'>Make Author</button></td><td><button id='Makeadmin' type='button' value='$username' onClick='makeadmin(this);' class='btn btn-success btn-sm'>Make Admin</button></td></tr>"; 
				
				}		
			
		$showusers = '<a href="#" class="dropdown-toggle" data-toggle="dropdown" >Show Users</span></a><ul class="dropdown-menu" role="menu">
            <li class="showuser" style="max-height: 10;overflow-y: scroll;">'. "<p class='text-warning' id='warning2'></p><table class='table table-striped'>".'<tr><td><b> Username </b></td><td><b> Password </b></td><td><b> Full Name </b></td><td style="margin-left:5%"><b> Role</b></td><td></td><td></td><td></td><td></td>'. $usertable ."</table>" .'
			</li>
			</ul>';	
			
		$adminpanel ='<a href="#" class="dropdown-toggle text-primary" data-toggle="dropdown" role="button" >Admin Panel <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="dropdown dropdown-submenu">'. $createuser.'
			</li>
			<li class="dropdown dropdown-submenu">'.$showusers . '</li>
			</ul>';
		
		}}
	//bloggerpanel	
	if(isset($_COOKIE['login'])){
	$loggedinuser = $_COOKIE['login'];
	$res1 = db_query("select role from users where username='$loggedinuser'",$con);
	$rolerow = $res1->fetch_assoc();
	$loggedinrole = $rolerow['role'];}
	
	else{
		$loggedinuser = $_POST['username'];
	$res1 = db_query("select role from users where username='$loggedinuser'",$con);
	$rolerow = $res1->fetch_assoc();
	$loggedinrole = $rolerow['role'];
	}
	if(($loggedinrole ==1) ||($loggedinrole ==2)||($loggedinrole ==3)){
		$result = db_query("
Select blogs.*,username,content from blogs,users,image where id = blogger and image = ikey order by time limit 3 offset $realpage ",$con);
 $blogs = '';
   while($row = $result->fetch_assoc()){
	   if($row['Edittag']==1){ $edited='Edited';
	  }else $edited = 'Posted';
	  /////Comments
	  $Bid2 = $row['Bid'];
	  $comments = '<form method="post">Your Comment:<textarea class="form-control" cols="200" row="8" name="commentbody" ></textarea><br><button type="submit" class="btn btn-primary" name="bloggercomment" value="'.$row['Bid'].'">Submit</button></form>';
	  $resultcomment = db_query("select * from comments where blog='$Bid2' order by time desc",$con);
	  $countresult = db_query("select count(id) from comments where blog='$Bid2' and atag=1 order by time desc",$con);
	  $rowcount = $countresult->fetch_assoc();
	  while($commentrow=$resultcomment->fetch_assoc()){
		  $commentbody  = $commentrow['body'];
		  $commentsender = $commentrow['poster'];
		  $timecomment2 = $commentrow['time'];
		  $commentid = $commentrow['id'];
		  $commenttag = $commentrow['atag'];
		  if($commentsender){
		  $resultuser = db_query("select username from users where id='$commentsender'",$con);
		  $row2 = $resultuser->fetch_assoc();
		  $commentusername=$row2['username'];}
		  else $commentusername = 'Guest';
		  if($commenttag==0){
		  $comments = "<div class='col-ms-8'><form method='post'><button type='submit' name='acceptcomment' class='btn btn-success btn-xs' value='".$commentid."'>Accept</button> <button class='btn btn-xs btn-danger' type='submit' name='declinecomment' value='".$commentid."'>Decline</button></form><br><h6 class='text-primary'>".$commentusername."</h6><p class='text-warning'><span class='glyphicon glyphicon-time'></span>Posted On ".$timecomment2."</p><p class='text'>".$commentbody."</p> </div><hr>".$comments;
		  } else {
			  $comments = "<div class='col-ms-8'><form method='post'><button type='submit' name='deletecomment' value='".$commentid."' class='btn btn-xs btn-warning' ><span class='glyphicon glyphicon-remove'></span>Delete</button></form><br><h6 class='text-primary'>".$commentusername."</h6><p class='text-warning '><span class='glyphicon glyphicon-time '></span>Posted On ".$timecomment2."</p><p class='text'>".$commentbody."</p> </div><hr>".$comments;}
	  }
		  
		  //blogstring
		  
	  $body = $row['body'];
	  $commentcount2 = $rowcount['count(id)'];
	  $trimmed = substr($body,0,200); 	
   $blogs = '<div id="blogdiv'.$row['Bid'].'">
   		   <button class="btn sm btn-primary" type="button" onClick="'."edit('".$row['Bid']."')".'">Edit</button>
               <button class="btn sm btn-warning"  type="button" id="deletebutton'.$row['Bid'].'" onClick="'."deleteblog('".$row['Bid']."')".'">Delete</button>
			   <div style="display:none";background-color:black" class="col-md-8" id="editdiv'.$row['Bid'].'">
			   
			   <form method="post"><div class="input-group"><h4><p href="#" class="text-primary">Edit Blog</p></h4><br>Title <input class="form-control" name="title" value="' . $row['title'] .'" > <br> Body <br><textarea class="form-control" name="body" cols="100" rows="10" >'.$body .'</textarea></div><br><br><div> <button type="submit" class="btn btn-primary" name="editblog" value="'. $row['Bid'] . '" >Submit</button></form><button type="button" onClick="closepop2(this)" class="btn btn-warning">Cancel</button><br><br></div>
			   </div>
			   <div style="display:none";background-color:black" class="col-md-8" id="deletediv'.$row['Bid'].'">
			   <h4><p class="text-warning">Delete Blog</h4>
			   <h6><p class="text-primary">Are you sure you want to delete this blog?</h6><br><br>
			   <form method="post"><button type="submit" class="btn btn-primary" name="deleteblog" value="'.$row['Bid'].'">Yes</button><button type="button" class="btn btn-warning" onClick="closepop(this)">No</button></form>
			   </div>
			  <h4>
                    <a href="#">'. $row['title']. '</a>
                </h4>
                <p class="lead">
                    by <a href="index.php">'.$row['username'].'</a>
                </p>
				
                <p class="text-warning"><span class="glyphicon glyphicon-time" ></span>'.$edited.' on '.$row['time'].'</p>
                <hr>
                <img class="img-responsive" height="200" width="900" src="data:image/jpeg;base64,'.base64_encode( $row['content'] ).'">
                <hr>
                <p>'.$trimmed.'...</p>
                <button  type="button" class="btn btn-primary" onClick="'."popup('".$row['Bid']."')".'">Read More <span class="glyphicon glyphicon-chevron-right"></span></button><div class="pull-right"><p class="text-primary"> <span class="glyphicon glyphicon-comment"></span> '.$commentcount2.'</p></div>
				
				<div style="display:none;overflow:auto;background-color:black;max-height:600px;" class="col-md-8" id="popdiv'.$row['Bid'].'"><button class="btn btn-danger btn-xs" onClick="closepop1(this)"><span class="glyphicon glyphicon-remove"></span></button><h4>
                   
					<a href="#">'. $row['title']. '</a>
                </h4>
                <p class="lead">
                    by <a href="index.php">'.$row['username'].'</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$row['time'].'</p>
                
                <img class="img-rounded" height="200" width="700" src="data:image/jpeg;base64,'.base64_encode( $row['content'] ).'">
                <p>'.$body.'</p>'
				////////////Comments
				.'<hr><div class="col-md-8">'.$comments.'
				</div>
				
                </div></div>
                <hr>
' . $blogs;
}

		     if($loggedinrole !=3)
		    $bloggerpanel = '<div class="well" id="bloggerpanel"><h6 class="text-primary">Blogger Panel</h6>
                <button type="button" id="addblogbutton" onClick="addblog();" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Blog</button><br><br><button type="button" onClick="addpage()" id="addpage" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Page</button></div>';
		else $bloggerpanel = '<div class="well" id="bloggerpanel"><h6 class="text-primary">Blogger Panel</h6>
                <button type="button" id="addblog" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Blog</button></div>';
		
		} 
}
	else{
		
$usernametopost = '';
		$logininfo = "<form method='post'><div class='input-group'><h2><a href='#'>Log In</a>
                </h2><?php echo $loginmsg ?>Username<br><input type='text' name='username' value='' class='form-control'>Password<br><input type='password' class='form-control' name='password' value=''><br><br><span class='btn-group-btn'><button class='btn btn-default' type='submit' name='login' value='login'>Login</button></form><button class='btn btn-default' id='sign' onclick='return false;'>Sign Up</button></span></div>";

		}
		
		
		      
            //deletecomment
			if(isset($_POST['deletecomment'])){
				$commentid1 = $_POST['deletecomment'];
				 $resultaccept = db_query("delete from comments where id='$commentid1'",$con);
				 if($resultaccept)
				 	   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Comment Was deleted!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
				
				}
		     //declinecomment
			 if(isset($_POST['declinecomment'])){
				 $commentid2 = $_POST['declinecomment'];
				 $resultaccept = db_query("delete from comments where id='$commentid2'",$con);
				 if($resultaccept)
				 	   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Comment Was deleted!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
				 }
			 //acceptcomment
			 if(isset($_POST['acceptcomment'])){
				 $commentid1 = $_POST['acceptcomment'];
				 $resultaccept = db_query("update comments set atag=1 where id='$commentid1'",$con);
				 if($resultaccept)
				 	   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Comment Was accepted!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
				 }
			//Blogger Comment
			if(isset($_POST['bloggercomment'])){
				 $user = $_COOKIE['login'];
				 $resultuser = db_query("select id from users where username='$user'",$con);
				 $rw = $resultuser->fetch_assoc();
				 $id = $rw['id'];
				 $commentbody2 = $_POST['commentbody'];
				 $commentbody = mysql_real_escape_string($commentbody2);
			   
				 $blogid = $_POST['bloggercomment'];
				$timecomment =  date("Y/m/d H:i:s");
				 $cmrs = db_query("insert into comments(poster,body,blog,time,atag) values('$id','$commentbody','$blogid','$timecomment',1)",$con);
				 if($cmrs)
					   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Your Comment Was Posted!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
			 }	 
	//Post Comment
			 if(isset($_GET['comment'])){
				 $user = $_COOKIE['login'];
				 $resultuser = db_query("select id from users where username='$user'",$con);
				 $rw = $resultuser->fetch_assoc();
				 $id = $rw['id'];
				 $commentbody2 = $_GET['commentbody'];
				 $commentbody = mysql_real_escape_string($commentbody2);
			   
				 $blogid = $_GET['comment'];
				$timecomment =  date("Y/m/d H:i:s");
				 $cmrs = db_query("insert into comments(poster,body,blog,time,atag) values('$id','$commentbody','$blogid','$timecomment',0)",$con);
				 if($cmrs)
					   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Your comment was posted And it is waiting for confirmation!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
			}
	////guest comment
	if(isset($_POST['guestcomment'])){
		
				 $commentbody2 = $_POST['commentbody'];
				 $commentbody = mysql_real_escape_string($commentbody2);
			   
				 $blogid = $_POST['guestcomment'];
				$timecomment =  date("Y/m/d H:i:s");
				 $cmrs = db_query("insert into comments(body,blog,time,atag) values('$commentbody','$blogid','$timecomment',0)",$con);
				 if($cmrs)
					   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Your comment was posted And it is waiting for confirmation!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Something Went Wrong Try Again!</div>';
			 }		 
	//Delete blog
		      if(isset($_POST['deleteblog'])){
			$bid = $_POST['deleteblog'];
			$resultdeletecomment = db_query("
Delete from comments where blog = '$bid';",db_connection());
			$resultdelete = db_query("Delete from blogs where Bid = '$bid'",$con);
			if($resultdelete)
			   $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Blog was deleted!</div>';
			 	else  $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Blog was not deleted!</div>';
			
			}
	//Edit BLog
			 if(isset($_POST['editblog'])){
				 $editedbody = $_POST['body'];
				 $editedtitle = $_POST['title'];
				 $editedid = $_POST['editblog'];
				 $mybody = mysql_real_escape_string($editedbody);
			   $mytitle = mysql_real_escape_string($editedtitle);   
			   date_default_timezone_set("Asia/Tehran");
               $time =  date("Y/m/d H:i:s");
			   
				 $result = db_query("update blogs
				      set body = '$mybody', title='$mytitle' , time = '$time', edittag = '1'
                       where  Bid = '$editedid'",db_connection());
					   if($result)
					    $_POST['warning'] = '<div class="alert alert-success" style="width:200px">Blog is edited!</div>';
			 	      else $_POST['warning'] = '<div class="alert alert-danger" style="width:200px">Nothing happened!!</div>';
			 	       
				 }  
			
     //make Author
	   		if(isset($_POST['makeauthor'])){
		   $username = $_POST['makeauthor'];
		   $con = db_connection();
		  	   $result = $con->query("update  users 
				set role = 3
				where username = '$username';
				 ");
      if($result)
		   echo $username . ' is now an Author';
		   else echo "Something Went Wrong!";
		   exit();
		   
		   }   
	//make moderator
	     if(isset($_POST['makemod'])){
		   $username = $_POST['makemod'];
		   $con = db_connection();
		  
		   $result = $con->query("update  users 
set role = 2
where username = '$username';
");
		   if($result){
			  echo $username . " Is now a Moderator!"; 
			   }
			  else echo "Something went Wrong!";
			  exit();
			    
		   
		   }
	//Make Admin
		if(isset($_POST['makeadmin'])){
			$username = $_POST['makeadmin'];
		   $con = db_connection();
		  
		   $result = $con->query("update  users 
set role = 1
where username = '$username';
");
		   if($result){
			  echo $username . " Is now an Admin!"; 
			   }
			  else echo "Something went Wrong!";
			  exit();
			 
			}   
	 //Delete User
	  if(isset($_POST['remove'])){
		 $username = $_POST['remove'];
		 $result = db_query("Delete from users where username = '$username'",db_connection());
		 if($result)
		 	echo $username . ' Was Deleted!';
			else{ echo "Failed";}
      exit();
		 }
	//CreateUser
	if(isset($_POST['createuser'])){
		
	   $con = db_connection();
	   $username = $_POST['ausername'];
	   $password = $_POST['apassword'];
	   $fullname = $_POST['aname'];
	   $result = db_query("select * from users where username = '$username' ",$con);
		 if(mysqli_num_rows($result) != 0)
		 {
			echo '<a href="#" class="text-danger">Username Already Exists Try Again!</a>';
			exit();
			 }  
	else{		 
	    echo '<a href="#" class="text-warning">User Was Created Successfully</a>';
	   $rs = db_query("call saveuser('$username','$fullname','$password')",$con);
	   exit();}
	   }
    //Sign up
   if(isset($_POST['signup'])){
	   $con = db_connection();
	   $username = $_POST['username'];
	   $password = $_POST['password'];
	   $fullname = $_POST['name'];
	   $result = db_query("select * from users where username = '$username' ",$con);
		 if(mysqli_num_rows($result) != 0)
		 {
			 $_POST['warning'] = '<div class="alert alert-danger col-md-5" role="alert">
  <a href="#" class="alert-link">Username Already Exists Please Try Again!</a>
</div>';
			 }  
	else{		 
	    $_POST['warning'] = '<div class="alert alert-success col-md-5" role="alert">
  <a href="#" class="alert-link">You have Registered in my weblog! Thank you!</a></div>';
	   $rs = db_query("call saveuser('$username','$fullname','$password')",$con);}
	   }
   //Log Out
   if(isset($_POST['logout'])){
setcookie ("login", "", time() - 3600);
	   header('location:main.php');
	   
	   die();
	   
	   }
	//include('debug.php');
  include('mainview.php');
    mysql_close($con);
?>