<?php
require("../connect/db_connect.php");
$interest = mysqli_real_escape_string($conn, $_POST['interest']);
if($interest=="All"){
    $fetch_users = mysqli_query($conn,"SELECT * FROM users ORDER BY id ASC");
    ?>
        <script>
              $('#All').addClass('active');
        </script>
    <?php
}else{
    $fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE interest='$interest' ORDER BY id ASC");
    ?>
        <script>
            $('#<?php echo str_replace(' ','',$interest)?>').addClass('active');
        </script>
    <?php
}

?>
<div class="header-modal">
    <h1>Registered Identities <?php if($interest!="All"){echo "(".$interest."s)";}?></h1>
    <div class="search-box"><input type="text" id="search-input" placeholder="Search users by name or date added" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="nameth">Full Names</th>
                <th>Email</th>
                <th class="interetstd">Interest</th>
                <th class="poststh">Posts</th>
                <th class="dateth">Date Registered</th>
                <th class="actionsth">Acion</th>
            </tr>
        </thead>
        <tbody id="users-row">
        <?php
            while($fetch_users_r = mysqli_fetch_assoc($fetch_users)){
                $userId = $fetch_users_r['userId'];
                $fullnames = $fetch_users_r['firstname'];
                $email = $fetch_users_r['email'];
                $date_created = $fetch_users_r['date'];
                if(!empty($fetch_users_r['nickname'])){
                    $nickname = " (".$fetch_users_r['nickname'].")";
                }else{
                    $nickname = "";
                }
                if(!empty($fetch_users_r['interest'])){
                    $interest = $fetch_users_r['interest'];
                }else{
                    $interest = "N/A";
                }
                
                $count_posts = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM songs_details WHERE userId='$userId'"));

                $fetchupic = mysqli_query($conn,"SELECT * FROM user_pics WHERE userId='$userId'");
                $fetchupic_r = mysqli_fetch_assoc($fetchupic);

                
                ?>
                    <tr>
                        <td class="limitTd">
                            <div class="limitTxt" data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $fullnames. $nickname;?>">
                                <?php
                                    if(mysqli_num_rows($fetchupic)>0 && !empty($fetchupic_r['upic'])){
                                        ?>
                                            <img src="../images/users/<?php echo $fetchupic_r['upic'];?>" class="u-pic"/>
                                        <?php
                                    }else{
                                        ?>
                                            <span class="u-pic"><i class="far fa-user"></i></span>
                                        <?php
                                    }
                                ?>
                                &nbsp;<?php echo $fullnames. $nickname;?>
                            </div>
                        
                        </td>
                        <td><a data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $email;?>" href="mailto:<?php echo $email;?>"><?php echo $email;?></a></td>
                        <td><?php echo $interest;?></td>
                        <td><?php echo $count_posts;?></td>
                        <td><?php echo $date_created;?></td>
                        <td><button onclick="view_user('<?php echo $userId;?>','');" class="btn btn-outline-primary text-white" type="button">More Info</button></td>
                    </tr>
                <?php
            }
            if(mysqli_num_rows($fetch_users)<1){
                ?>
                    <tr><td colspan="6">No Users </td></tr>
                <?php
            }
        ?>
        </tbody>
    </table>
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