<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Game Freaks</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
  
    <link href="css/blog-home.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
  <style>
  body{  background: url(background.jpg) no-repeat center center fixed; background-size:cover}
  .col-md-8{background-color:black;
  }
  .createuser { width: 300px; }
  .showuser {width:800px;height:auto;}
  #contact { width:300px;}
  .contact {margin-left:10%}
  .glyphicon-remove {background-color:inherit;}
  #remove {background-color:inherit;border:none}
  #blogpost {height:500px;}
  </style>
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top nav" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <li class="dropdown">
                <?php echo $adminpanel ?>
                </li>
                    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">About</a>
          <ul class="dropdown-menu" role="menu">
          
          <li><a href="#">Game Freaks is a weblog that i designed for my final project.<br> i have spent much of my time on this, and i hope you like it. if you have any suggestions please contact me! <br> Regards, <br> -Admin</a></li>
          
          </ul>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Contact</a>
          <ul class="dropdown-menu" role="menu" id="contact">
          <li class="contact"><h4><a href="#" class="text-primary">Admin's Info:</a></h4></li>
          <li class="contact"><p class='text-primary'>Hooman Malekzadeh</p></li>
            <li class="contact"><img class="img-responsive" src="images/outlook.png" height="30" width="30"><p class="text-warning">Hooman.malekzadeh@outlook.com </p></li>
            <li class="contact"><img class="img-responsive" src="images/facebook.png" height="30" width="30"><p class="text-warning">Hooman Malekzawdeh</p></li>
            <li class="contact"><img class="img-responsive" src="images/skype.png" height="30" width="30"><p class="text-warning">H2oMaN</p></li>
            
            
          </ul>
          </li>
          </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
             <?php echo $_POST['warning'] ?>
            <!-- Blog Entries Column -->
            <div class="col-md-8" id="blogcontainer">

                <h1 class="page-header">
                    Game Freaks
                    <small>Weblog for gamers</small>
                </h1>

                <!-- First Blog Post -->
                <?php echo $blogs ?>
                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                       <form method='post'><button type="submit" name="page" class="btn btn-primary pull-left" value="0">&larr; Older</button></form>
                    </li>
                    <li class="next">
                        <form method='post'><button type="submit" name="page" class="btn btn-primary pull-right" value="1">Newer &rarr;</button></form>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class="well">
                <?php echo $logininfo ?>
                </div>
                
                <div class="well" id="signform">
                <?php echo $signupform ?>
                 </div>
                <?php echo $bloggerpanel ?> 
                <div class='well' id="blogpost">
                </div>
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-danger" ><b>Copyright &copy; Game Freaks Website 2014</b></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bpopup.js"></script>
  <script>
  $("#sign").click(function(){
	  $("#signform").fadeToggle(500);
	  
	  });
	  
	
    //Slide Down Animation	
	(function() {
		// ADD SLIDEDOWN ANIMATION TO DROPDOWN //
  $('.dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // ADD SLIDEUP ANIMATION TO DROPDOWN //
  $('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });
})()	  


$(document).ready(function(e) {
		    $("#signform").hide();
	       $("#blogpost").hide();
   $("#createbutton").click(function(){
	var form = $("#createuser")[0];
	var username = form[0].value;
	var password = form[1].value;
	var fullname = form[2].value;
	$.post("main.php", {
createuser: 1,
ausername: username,
apassword: password,
aname: fullname
}, function(data) {
	if(data == 'User Was Created Successfully'){
$("#warning").html(data);
					setTimeout("location.href = 'main.php'",1000);

}

else
{
	$("#warning").html(data);


}
});
	});}); 
	
	
function deleteuser(e){
	var usernamefordelete = e.value;
		$.post("main.php",{remove :usernamefordelete},function(data){
			$("#warning2").html(data);
			
			
					setTimeout("location.href = 'main.php'",1000);});
			}
function makemod(e){
	var usernameformod = e.value;
	console.log(e.value);
		$.post("main.php",{makemod :usernameformod},function(data){
			$("#warning2").html(data);
			
					setTimeout("location.href = 'main.php'",1000);
			});
			
	
	}		
function makeauthor(e){
	var usernameforauthor = e.value;
	console.log(e.value);
		$.post("main.php",{makeauthor :usernameforauthor},function(data){
			$("#warning2").html(data);
			
			
					setTimeout("location.href = 'main.php'",1000);});
			
	
	}		
function makeadmin(e){
	var usernameforadmin = e.value;
  	$.post("main.php",{makeadmin :usernameforadmin},function(data){
			$("#warning2").html(data);
			
					setTimeout("location.href = 'main.php'",1000);
			});
	
	
	}	

function addblog(){	
		$("#blogpost").fadeToggle(500);
		var blogpostform = "<form id='blogpostform' enctype='multipart/form-data' method='post'><div class='input-group'><h2><a href='#'>Post a blog</a></h2><p id='warning4' class='text-warning'></p><br>Title<br><input type='text' name='title' class='form-control'><br>Body<textarea class='form-control' name='body'></textarea><br><br><span class='btn btn-primary btn-file'>Browse&hellip; <input type='file' name='image'></span><br>Category<br><input type='text' name='category' class='form-control'>Tags<br><input type='text' name= 'tags'  class='form-control'><br><br><button class='btn btn-primary'type='Button' onClick='postblog();' value='Submit' name='blogsubmit'>Submit</button></div></form>";
		$("#blogpost").html(blogpostform);
}

function addpage(){	
		 $("#blogpost").fadeToggle(500);
		var pagepostform = "<form id='blogpostform' method='post'><div class='input-group'><h2><a href='#'>Post a Page</a></h2><p class='text-warning' id='warning3'></p> Title<br><input type='text' class='form-control'>Body<textarea class='form-control'></textarea><br><br><br><button class='btn btn-primary' type='button' name='blogpost' value='1' id='signupsubmit'>Submit</button></div></form>";
		$("#blogpost").html(pagepostform);
}

function postblog(){ 
   var form = $("#blogpostform")[0];
   data = new FormData(form);
   var username = "<?php echo $usernametopost ?>"; 
    console.log(username);	
	data.append("username",username);
       $.ajax({
            type: 'post',
            url: 'ajaxPost.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false}).done(function(result){
				var error = '<?php echo $posterror ?>';
				console.log(error);
				if(result === 'Blog was posted!'){
				$("#warning4").html(result);
			form.reset();
		 $("#blogpost").fadeToggle(1000);
					setTimeout("location.href = 'main.php'",1000);
		 
		 }
		       else {
					$("#warning4").html(result);
			   }
			   });

}

function popup(bid){
	
	 event.preventDefault();
			 console.log(bid);
			 	 $('#popdiv' + bid).bPopup({
					 follow:[false,false],
            modalClose: false,
            opacity: 0.6,
            positionStyle: 'fixed', //'fixed' or 'absolute'
			modalColor: 'black',
			closeClass : 'b-close',
			modalClose: false,
			position: [200, 20]
        });
 
	
	}
	
function edit(element){
	var blog = $("#popdiv" + element);
	var blogchildren = $(blog).children();
	var title = blogchildren.children()[0].innerHTML; 
	var blogbody = blogchildren[4].innerHTML;
	
	  		 	 $('#editdiv' + element).bPopup({
					 follow:[false,false],
            modalClose: false,
            opacity: 0.6,
            positionStyle: 'fixed', //'fixed' or 'absolute'
			modalColor: 'black',
			closeClass : 'b-close',
			modalClose: false,
			position: [200, 20]
        });
 	
	}

function deleteblog(bid){
	$('#deletediv' + bid).bPopup({
					 follow:[false,false],
            modalClose: false,
            opacity: 0.6,
            positionStyle: 'fixed', //'fixed' or 'absolute'
			modalColor: 'black',
			closeClass : 'b-close',
			modalClose: false,
			position: [500, 200]
        });
	
	
	}	
	function closepop(element){
		var parent = $(element).parent().parent();
		$(parent).bPopup().close(); 
		}
		
	function closepop1(element){
		var parent = $(element).parent();
		$(parent).bPopup().close(); 
		}
		
	function closepop2(element){
		var parent = $(element).parent().parent().parent();
		$(parent).bPopup().close(); 
		
		
		}
	
  </script>
</body>

</html>
