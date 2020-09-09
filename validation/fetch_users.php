<?php
require("../connect/db_connect.php");

if(isset($_POST['searchVal'])){
    $searchVal = mysqli_real_escape_string($conn, $_POST['searchVal']);
    $interest = mysqli_real_escape_string($conn, $_POST['interest']);
    if($interest!="All"){
        $fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE firstname LIKE '%$searchVal%' OR nickname LIKE '%$searchVal%' OR email LIKE '%$searchVal%' OR userId LIKE '%$searchVal%' OR address LIKE '%$searchVal%' OR interest LIKE '%$searchVal%' ORDER BY id ASC");
    }else{
        $fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE firstname LIKE '%$searchVal%' OR nickname LIKE '%$searchVal%' OR email LIKE '%$searchVal%' OR userId LIKE '%$searchVal%' OR address LIKE '%$searchVal%' ORDER BY id ASC");
    }
}
?>
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