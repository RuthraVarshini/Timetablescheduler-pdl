<?php
if (isset($_GET['generated']) && $_GET['generated'] == "false") {
    unset($_GET['generated']);
    echo '<script>alert("Timetable not generated yet!!");</script>';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>TimeTable Management System</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="CSS/bootstrap.css" rel="stylesheet"/>
    <!-- FONT AWESOME CSS -->
    <link href="CSS/font-awesome.min.css" rel="stylesheet"/>
    <!-- FLEXSLIDER CSS -->
    <link href="CSS/flexslider.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE CSS -->
    <link href="CSS/style.css" rel="stylesheet"/>
    <link href="CSS/Card.css" rel="stylesheet"/>
    <!-- Google	Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'/>
     

</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top " id="menu">
    <div class="container">
        <div align="center">
            <h2>National Engineering College</h2>
            <h3 align="center">TIME TABLE MANAGEMENT SYSTEM,  DEPARTMENT OF INFORMATION TECHNOLOGY</h3>
        </div>
    </div>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators" style="margin-bottom: 160px">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="img/NEC.jpg" alt="Chania">
        </div>

        <div class="item">
            <img src="img/NEC2.jpg" alt="Chania">
        </div>

        <div class="item">
            <img src="img/Lab1.jpg" alt="Flower">
        </div>

        <div class="item">
            <img src="img/NEC4.jpg" alt="Flower">
        </div>
    </div>
</div>
<script type="text/javascript">
    function genpdf() {
        var doc = new jsPDF();

        doc.addHTML(document.getElementById('TT'), function () {
            doc.save('demo timetable.pdf');
        });
        window.alert("Downloaded!");
    }
</script>
<div align="center" STYLE="margin-top: 30px">
    
    <button data-scroll-reveal="enter from the bottom after 0.2s"
            id="adminLoginBtn" class="btn btn-success btn-lg">ADMIN LOGIN
    </button>
</div>
<br>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times</span>
            <h2 id="popupHead">Modal Header</h2>
        </div>
        <div class="modal-body" id="LoginType">
            <!--Admin Login Form-->
            <div style="display:none" id="adminForm">
                <form action="Course.php" method="POST">
                    <div class="form-group">
                        <label for="adminname">Username</label>
                        <input type="text" class="form-control" id="adminname" name="UN" placeholder="Username ...">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="PASS"
                               placeholder="Password ...">
                    </div>
                    <div align="right">
                        <input type="submit" class="btn btn-default" name="LOGIN" value="LOGIN">
                    </div>
                </form>
            </div>
        </div>
        <!--Faculty Login Form-->
        <div style="display:none" id="facultyForm">
            <form action="facultyformvalidation.php" method="POST" style="overflow: hidden">
                <div class="form-group">
                    <label for="facultyno">Faculty No.</label>
                    <input type="text" class="form-control" id="facultyno" name="FN" placeholder="Faculty No. ...">
                </div>
                <div align="right">
                    <button type="submit" class="btn btn-default" name="LOGIN">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var teacherLoginBtn = document.getElementById("teacherLoginBtn");
    var adminLoginBtn = document.getElementById("adminLoginBtn");
    var heading = document.getElementById("popupHead");
    var facultyForm = document.getElementById("facultyForm");
    var adminForm = document.getElementById("adminForm");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    adminLoginBtn.onclick = function () {
        modal.style.display = "block";
        heading.innerHTML = "Admin Login";
        adminForm.style.display = "block";
        facultyForm.style.display = "none";

    }
    teacherLoginBtn.onclick = function () {
        modal.style.display = "block";
        heading.innerHTML = "Faculty Login";
        facultyForm.style.display = "block";
        adminForm.style.display = "none";


    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
        adminForm.style.display = "none";
        facultyForm.style.display = "none";

    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<!--HOME SECTION END-->
<!--HOME SECTION TAG LINE END-->
 
                    

<div class="box-container">
	<div class="box-item">
    <div class="flip-box">
      <div class="flip-box-front text-center" style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
        <div class="inner color-white">
          <h3 class="flip-box-header">About Us</h3>
          
          <img src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
        </div>
      </div>
      <div class="flip-box-back text-center" style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
      <div class="inner color-white">
    <h3 class="flip-box-header">About Us</h3>
    <p>You can  Know about Us.</p>
    <a href="About.php" class="flip-box-button">Learn More</a>
</div>
      </div>
    </div>
	</div>
	<div class="box-item">
    <div class="flip-box">
      <div class="flip-box-front text-center" style="background-image: url('https://s25.postimg.cc/hj4c4qnov/cta-3.png');">
        <div class="inner color-white">
          <h3 class="flip-box-header">Contact Us</h3>
         
          <img src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
        </div>
      </div>
      <div class="flip-box-back text-center" style="background-image: url('https://s25.postimg.cc/hj4c4qnov/cta-3.png');">
      <div class="inner color-white">
    <h3 class="flip-box-header">Contact Us</h3>
    <a href="page1.html">
    <img src="img/gm.png" alt="Icon 1" style="width: 50px; height: 50px;">
    </a>
    <a href="page2.html">
        <img src="img/ln.png" alt="Icon 2"  style="width: 50px; height: 50px;">
    </a>
     
</div>

      </div>
    </div>
	</div>
	<div class="box-item">
    <div class="flip-box">
      <div class="flip-box-front text-center filter-" style="background-image: url('https://s25.postimg.cc/l2q9ujy4f/cta-4.png');">
        <div class="inner color-white">
          <h3 class="flip-box-header">Dedicated</h3>
          <p>A short sentence describing this callout is.</p>
          <img src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
        </div>
      </div>
      <div class="flip-box-back text-center" style="background-image: url('https://s25.postimg.cc/l2q9ujy4f/cta-4.png');">
        <div class="inner color-white">
          <h3 class="flip-box-header">Dedicated</h3>
          <p>A short sentence describing this callout is.</p>
          <button class="flip-box-button">Learn More</button>
        </div>
      </div>
    </div>
	</div>
</div>


<!-- CONTACT SECTION END-->
<div id="footer">
    <!--  &copy 2014 yourdomain.com | All Rights Reserved |  <a href="http://binarytheme.com" style="color: #fff" target="_blank">Design by : binarytheme.com</a>
--></div>
<!-- FOOTER SECTION END-->

<!--  Jquery Core Script -->
<script src="js/jquery-1.10.2.js"></script>
<!--  Core Bootstrap Script -->
<script src="js/bootstrap.js"></script>
<!--  Flexslider Scripts -->
<script src="js/jquery.flexslider.js"></script>
<!--  Scrolling Reveal Script -->
<script src="js/scrollReveal.js"></script>
<!--  Scroll Scripts -->
<script src="js/jquery.easing.min.js"></script>
<!--  Custom Scripts -->
<script src="js/custom.js"></script>
</div>
</body>
</html>