<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fee Payment system</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" type="image/x-icon" href="assets/uploads/favicon.png">


    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="assets/DataTables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/jquery.datetimepicker.min.css" rel="stylesheet">
    <link href="assets/css/select2.min.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="assets/css/jquery-te-1.4.0.css">



</head>
<style>
    body {
        width: 100%;
        height: calc(100%);
        position: fixed;
        top: 0;
        left: 0
            /*background: #007bff;*/
    }

    main#main {
        width: 100%;
        height: calc(100%);
        display: flex;
        align-items: center;
        background-image: url(assets/uploads/background.jpg);
        background-size: cover;
    }
</style>

<body class="bg-dark">


    <main id="main">

        <div class="align-self-center w-100">

            <div id="login-center" align="center">
                <div class="card col-md-3 ">
                    <div class="card-body">
                        <h1 class="text-center mb-5"><img src="assets/uploads/logo.png" width="249px"></h1>

                        <form id="login-form" method="POST" action="{{__('/')}}">
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <br>
                            <center><button class="btn btn-primary">Authority Login</button></center>
                            <br>
                            <br>
                            <br>
                            <!-- <label class="control-label"><a href="https://mayurik.com" target="a_blank">Developed By :
                                    Mayuri K.</a> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<!--  Author Name: Mayuri K.
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com
 Visit website : www.mayurik.com -->
<script>
    $('#login-form').submit(function(e) {
        e.preventDefault()
        $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)
                $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

            },
            success: function(resp) {
                if (resp == 1) {
                    location.href = 'index.php?page=home';
                } else {
                    $('#login-form').prepend(
                        '<div class="alert alert-danger">Username or password is incorrect.</div>'
                        )
                    $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                }
            }
        })
    })
</script>
<!--  Author Name: Mayuri K.
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com
 Visit website : www.mayurik.com -->

</html>
