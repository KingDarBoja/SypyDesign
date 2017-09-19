<?php require_once(dirname(__FILE__).'/functions.php'); ?>
<!DOCTYPE html>
<html lang="en" class="no-js" dir="ltr">

<head>
    <!-- Agrega el icono al titulo de la pagina en el navegador-->
    <link rel="shortcut icon" href="../img/Trailer_Icon.png" />
    <title><?php the_title();?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="SyPy Design is a project development by Electronic Engineering student on Electronic Design Course at Universidad Del Norte" />
    <meta name="keywords" content="SyPy Design, Uninorte" />
    <meta name="author" content="Manuel Bojato, Gerardo Ojeda, Danilo Galindo, Augusto Amador" />
    <!--Font Scripts  -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
    <!-- Insert this within your head tag and after foundation.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/motion-ui/1.1.1/motion-ui.min.css" />
    <!-- CSS files -->
    <link rel="stylesheet" type="text/css" href="../plugin/foundation_6.4.2/css/foundation_flex.css">
    <link rel="stylesheet" type="text/css" href="../plugin/foundation_datepicker/css/foundation-datepicker.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/estilos.css" media="screen" />
    <!-- JavaScript Jquery-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="https://use.fontawesome.com/f0839d1153.js"></script>
    <script type="text/javascript">
      $(window).on('load', function() {
      // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
      });
    </script>
</head>
<body>
    <!-- Gif de carga  -->
    <div class="se-pre-con"></div>
    <header>
      <div data-sticky-container>
        <div class="sticky" data-sticky data-margin-top="0" data-sticky-on="small">
          <!-- Mobile only -->
          <div class="title-bar flex-container align-spaced align-middle" data-responsive-toggle="main-menu" data-hide-for="large">
            <div class="title-bar-title"><a href="#" class="title-bar-title__link"><img src="../img/sypy_main_logo_light.png" alt="SyPy Design Logo"></a>
            </div>
            <div class="menu-icon-container text-right">
              <button class="menu-icon" type="button" data-toggle></button>
            </div>
          </div>

          <div class="my-menu">
            <div class="main-title">
              <div class="row">
                <div class="columns large-centered text-center">
                  <a href="#" class="show-for-large large-centered-logo"><img src="../img/sypy_main_logo_light.png" alt="SyPy Design Logo"></a>
                </div>
              </div>
            </div>
            <div class="sub-title">
              <div class="row">
                <div class="columns">
                  <div class="top-bar" id="main-menu">
                    <ul class="menu align-justify vertical large-horizontal">
                      <li><a href="../index.php">Home</a></li>
                      <li><a href="../historical.php">Historical</a></li>
                      <li><a href="#">Contact us</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </header>
