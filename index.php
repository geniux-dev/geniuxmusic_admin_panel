<?php
require("connect/db_connect.php");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GeniuXMusic | Administrator</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <link href="assets/css/morris.css" rel="stylesheet">
</head>

<body>
<?php include('includes/modal-box.php');?>
    <nav class="navbar navbar-dark navbar-expand-md bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <div class="brand-logo-img"></div>GeniuXMusic</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end"
                id="navcol-1">
                <ul class="nav navbar-nav justify-content-between align-items-center align-content-center align-self-center m-auto">
                    <li class="nav-item" style="margin-left: -94px;" role="presentation"><a class="nav-link active" href="#">Management</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Promotion</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item profile-menu" role="presentation"><a class="nav-link" href="#">Geniux<i class="far fa-user"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="padding-top: 50px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><span>GeniuXMusic</span></a></li>
            <li class="breadcrumb-item active"><span>Administrator</span></li>
        </ol>
    </div>
    <div>
        <div class="container">
        <?php include('includes/kpis/management.php');?>
            <div class="row mt-2">
                <div class="col col-sm-8 " style="border: 1px solid #1e252f;margin-left: 15px;    padding-top: 8px;">
                    <div class="filters-contain">
                        <div class="filter-cont">
                            <span class="filters active" id="usersTab" onclick="fetch_charts('usersregistered');">Registered Identities <i class='fas fa-user-friends'></i>
                        </span>
                            <span class="filters" id="postsTab" onclick="fetch_charts('posts');">Posts Created <i class='fa fa-list-alt'></i>
                        </span>
                        </span>
                            <span class="filters" id="ticketsTab" onclick="fetch_charts('tickets');">Tickets Created <i class='fa fa-tags'></i>
                        </span>
                        </span>
                            <span class="filters" id="forumTabs" onclick="fetch_charts('forums');">Forums Created <i class='fab fa-slack-hash'></i>
                        </span>
                    </div>
                    </div>

                    <div class="graph-container" style="height: 300px;">
                        <div id="graphContain"></div>
                    </div>
                </div>
                <div class="col card-2">
                    <div class="filters-contain">
                        <div class="filter-cont"><span class="filters active" id="toplikedTab" onclick="fetch_posts('topliked');">Top LikEd POSTS <i class='fas fa-heart blueC'></i></span><span class="filters" id="topdislikedTab"  onclick="fetch_posts('topdisliked');">TOP DISLIKED POSTS <i class='fas fa-thumbs-down redC'></i></span></div>
                    </div>
                    <div class="card-2-container" id="posts">
                 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/morris_charts/raphael-min.js"></script>
    <script src="assets/plugins/morris_charts/morris.min.js"></script>
    
    <script src="assets/js/script.min.js"></script>
    <div id="myscripts"></div>
    <script>
    function closeModal(){
        $('.modal-box').fadeOut(300);
        setTimeout(function() {
            $('#modal-container').html('');
        }, 600);
    }
    function viewmodal(d){
        $('#modal-container').html('<div class="loading-data"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
        if(d=="registered_identities"){
            $('#modaltitle').html('Registered Identities');
            $('.modal-box').fadeIn(300);
            setTimeout(function() {
                $('#modal-container').load('includes/containers/registered-identities.php',{
                });
            }, 1000);
        }
        if(d=="posts"){
            $('#modaltitle').html('Uploaded Posts');
            $('.modal-box').fadeIn(300);
            setTimeout(function() {
                $('#modal-container').load('includes/containers/posts.php',{
                });
            }, 1000);
        }
        if(d=="tickets"){
            $('#modaltitle').html('Tickets');
            $('.modal-box').fadeIn(300);
            setTimeout(function() {
                $('#modal-container').load('includes/containers/tickets.php',{
                });
            }, 1000);
        }
        if(d=="tickets"){
            $('#modaltitle').html('Forums');
            $('.modal-box').fadeIn(300);
            setTimeout(function() {
                $('#modal-container').load('includes/containers/forums.php',{
                });
            }, 1000);
        }
    }

    
    function fetch_posts(category){

            $('#toplikedTab').removeClass('active');
            $('#topdislikedTab').removeClass('active');

            $('#posts').load('validation/fetch_posts.php',{
                category : category
            });
    }
    function fetch_charts(d){
        $('#usersTab').removeClass('active');
        $('#postsTab').removeClass('active');
        $('#ticketsTab').removeClass('active');
        $('#forumTabs').removeClass('active');

        if(d=="usersregistered"){
            $('#graphContain').html('<div class="loading-data" style="height:220px"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
            setTimeout(function() {
                $('#graphContain').load('includes/charts/users-registered.php',{
                    
                });
            }, 1000);
        }
        if(d=="posts"){
            $('#graphContain').html('<div class="loading-data" style="height:220px"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
            setTimeout(function() {
                $('#graphContain').load('includes/charts/posts.php',{
                    
                });
            }, 1000);
        }
        if(d=="tickets"){
            $('#graphContain').html('<div class="loading-data" style="height:220px"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
            setTimeout(function() {
                $('#graphContain').load('includes/charts/tickets.php',{
                    
                });
            }, 1000);
        }
        if(d=="forums"){
            $('#graphContain').html('<div class="loading-data" style="height:220px"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
            setTimeout(function() {
                $('#graphContain').load('includes/charts/forums.php',{
                    
                });
            }, 1000);
        }
    }
    $(document).ready(function(){
        fetch_posts('topliked');
        fetch_charts('usersregistered');
    });
    </script>
</body>

</html>