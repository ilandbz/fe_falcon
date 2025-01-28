<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>FINANCIERA TU AMIGO EMPRENDEDOR</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="logo.png">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="falcon316/simplebar/simplebar.min.css" rel="stylesheet">

    <link href="falcon316/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="falcon316/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <style type="text/css">
    .loader {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: inline-block;
      position: relative;
      border: 10px solid;
      box-sizing: border-box;
      animation: animloader 1s linear infinite alternate;
    }
    @keyframes animloader {
      0% {
        border-color: white rgba(255, 255, 255, 0) rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
      }
      33% {
        border-color: white white rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
      }
      66% {
        border-color: white white white rgba(255, 255, 255, 0);
      }
      100% {
        border-color: white white white white;
      }
    } 
  </style>
    <script src="falcon316/assets/js/config.js"></script>
    <script src="falcon316/simplebar/simplebar.min.js"></script>
    <script src="falcon316/popper/popper.min.js"></script>
    <script src="falcon316/bootstrap/bootstrap.min.js"></script>
    <script src="falcon316/anchorjs/anchor.min.js"></script>
    <script src="falcon316/is/is.min.js"></script>
    <script src="falcon316/echarts/echarts.min.js"></script>
    <script src="fontawesome672/js/all.min.js"></script>
    {{-- <script src="falcon316/fontawesome/all.min.js"></script> --}}
    <script src="falcon316/lodash/lodash.min.js"></script>
    <script src="falcon316/list.js/list.min.js"></script>
    <script src="falcon316/assets/js/theme.js"></script>
    @vite(['resources/js/app.js'])
  </head>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <App></App>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    

  </body>

</html>