<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/managementHome.css" rel="stylesheet" media="screen">
    <link href="css/welcome1.css" rel="stylesheet" media="screen">
    <link href="css/welcome2.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="img/siueFavicon.png" type="image/x-icon">
    
</head>       

<body>
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
     <a class="navbar-brand" href="http://www.siue.edu/">
      <img class="siuelogo" alt="Southern Illinois University Edwardsville Logo" src="img/logo-siue.png" >
     </a>
    </div>
  </div>
</nav>
<!-- End navigation bar -->

<!-- Start of image header, only shows on desktop -->
<div class="TopGraBG hidden-xs hidden-sm" style="background-image:img/library_bckgd.jpg">
	<img class= "libimg" alt="Institutional Header" height="135" src="img/Library-Masthead.jpg" >
</div>

<div class="top-content"> 
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="col-sm-offset-2" >
                            <h3 id="signText">Please sign in to make a reservation</h3>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="facultyhome/" method="post" class="login-form">
                            <button type="submit" class="btn">Sign in!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
