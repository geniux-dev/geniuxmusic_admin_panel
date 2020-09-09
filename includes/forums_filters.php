<?php
require("../connect/db_connect.php");
$category = mysqli_real_escape_string($conn, $_POST['category']);
if($category=="All"){
    $fetch_tickets = mysqli_query($conn,"SELECT * FROM reports_tickets ORDER BY id ASC");
    ?>
        <script>
              $('#All').addClass('active');
        </script>
    <?php
}else{

    if($category=="Resolved"){
        $fetch_tickets = mysqli_query($conn,"SELECT * FROM reports_tickets WHERE status='resolved'");
        ?>
            <script>
                $('#resolvedtickets-nav').addClass('active');
            </script>
        <?php
    }else if($category=="Pending"){
        $fetch_tickets = mysqli_query($conn,"SELECT * FROM reports_tickets WHERE status='pending'");
        ?>
            <script>
                $('#pendingtickets-nav').addClass('active');
            </script>
        <?php 
    }else{
        $fetch_tickets = mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='$category' ORDER BY id ASC");
        ?>
            <script>
                $('#<?php echo $category;?>').addClass('active');
            </script>
        <?php  
    }
   
}

?>
<div class="header-modal">
    <h1>Tickets <?php if($category!="All"){echo "(".$category.")";}?></h1>
    <div class="search-box"><input type="text" id="search-input" placeholder="Search users by name or date added" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
</div>
<div class="table-responsive">

        <?php
            while($fetch_tickets_r = mysqli_fetch_assoc($fetch_tickets)){
                $ticketId = $fetch_tickets_r['ticketId'];
                $userId = $fetch_tickets_r['userId'];
                $message = $fetch_tickets_r['message'];
                $category = $fetch_tickets_r['category'];
                $status = $fetch_tickets_r['status'];
                $date_added = $fetch_tickets_r['date'];
                $fetch_user = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userId'");
                $fetch_user_r = mysqli_fetch_assoc($fetch_user);

                
                if($fetch_user_r['displayname']=="nickname"){
                    $user_prefer_name =  $fetch_user_r['nickname'];
                }else{
                    $user_prefer_name = $fetch_user_r['firstname'];
                }

                $fetchupic = mysqli_query($conn,"SELECT * FROM user_pics WHERE userId='$userId'");
                $fetchupic_r = mysqli_fetch_assoc($fetchupic);
                ?>
                    <div class="post-card">
                        <?php
                            if(mysqli_num_rows($fetchupic)>0 && !empty($fetchupic_r['upic'])){
                                ?>
                                    <div class="post-img" style="background-image: url('../images/users/<?php echo $fetchupic_r['upic'];?>');"></div>
                                <?php
                            }else{
                                ?>
                                    <div class="post-img defaultart"><i class="far fa-user"></i></div>
                                <?php
                            }
                            
                            if($status=='resolved'){
                                ?>
                                    <div class="post-card-badge bg-primary"><span><i class="fas fa-check-circle"></i></span></div>
                                <?php
                            }else{
                                ?>
                                    <div class="post-card-badge"><span><i class="fas fa-question"></i></span></div>
                                <?php

                            }

                        ?>
                        <div class="post-data"  data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $user_prefer_name .": ".$message;?>"><span><?php echo $user_prefer_name;?> (<?php echo $status?>)</span><span>Message: <?php echo $message;?></span><span>Date Created: <?php echo substr($date_added, 0, 21);?></span></div>
                        <div class="post-menu"><button class="btn btn-primary" type="button">VIEW TICKET</button></div>
                    </div>
                <?php
            }
            if(mysqli_num_rows($fetch_tickets)<1){
                ?>
                    <div class="feedback-cont">
                        <i class="fa fa-tags"></i>
                        <span>No Tickets Created</span>
                    </div>
                <?php
            }
        ?>
</div>
<script>
 $(document).ready(function(){
    $("[data-bs-tooltip]").tooltip();
});

$('#search-input').on('keyup', function() {
    var searchVal = $(this).val();
    $('#users-row').load('validation/fetch_users.php',{
        searchVal: searchVal,
        interest: interest
    });

});


</script>