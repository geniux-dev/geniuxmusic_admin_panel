<?php
//Counting Registered Users
$count_users = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));

//Counting Total Posts
$count_posts= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM songs_details"));

//Counting Total Tickets
$count_tickets = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets"));

//Counting Total Tickets
$count_forums = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM forums"));
?>
<div class="row">
    <div class="col-md-3 col-md-3">
        <div class="kpi-contain">
            <div class="kpi_0"><span><?php echo $count_users;?></span></div>
            <div class="kpi-details">
                <span class="title">Registered Identities
                    <i class="fas fa-user-friends"></i>
                </span>
            <button class="btn btn-outline-primary text-white" onclick="viewmodal('registered_identities')" type="button">VIEW</button></div>
        </div>
    </div>
    <div class="col-md-3 col-md-3">
        <div class="kpi-contain">
            <div class="kpi_0"><span><?php echo $count_posts;?></span></div>
            <div class="kpi-details"><span class="title">Total Posts<i class="fa fa-list-alt"></i></span><button onclick="viewmodal('posts')" class="btn btn-outline-primary text-white" type="button">VIEW</button></div>
        </div>
    </div>
    <div class="col-md-3 col-md-3">
        <div class="kpi-contain">
            <div class="kpi_0"><span><?php echo $count_tickets;?></span></div>
            <div class="kpi-details"><span class="title">Total Tickets<i class="fa fa-tags"></i></span><button onclick="viewmodal('tickets')" class="btn btn-outline-primary text-white" type="button">VIEW</button></div>
        </div>
    </div>
    <div class="col-md-3 col-md-3">
        <div class="kpi-contain">
            <div class="kpi_0"><span><?php echo $count_forums;?></span></div>
            <div class="kpi-details"><span class="title">Total Forums<i class="fab fa-slack-hash"></i></span><button onclick="viewmodal('tickets')" class="btn btn-outline-primary text-white" type="button">VIEW</button></div>
        </div>
    </div>
</div>