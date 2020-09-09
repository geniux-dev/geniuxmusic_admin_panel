<?php
require("../connect/db_connect.php");
$category = mysqli_real_escape_string($conn, $_POST['category']);
if($category=="All"){
    $fetch_posts = mysqli_query($conn,"SELECT * FROM songs_details ORDER BY id ASC");
    ?>
        <script>
              $('#All').addClass('active');
        </script>
    <?php
}else{

    if($category=="Top Liked"){
        $fetch_posts = mysqli_query($conn,"SELECT * FROM (SELECT * FROM songs_details ORDER BY id DESC) sub ORDER BY likes DESC");
        ?>
            <script>
                $('#toplikedposts-nav').addClass('active');
            </script>
        <?php
    }else if($category=="Top Disliked"){
        $fetch_posts = mysqli_query($conn,"SELECT * FROM (SELECT * FROM songs_details ORDER BY id DESC) sub ORDER BY dislikes DESC");
        ?>
            <script>
                $('#topdislikedposts-nav').addClass('active');
            </script>
        <?php 
    }else{
    $fetch_posts = mysqli_query($conn,"SELECT * FROM songs_details WHERE genre='$category' ORDER BY id ASC");
    ?>
        <script>
            $('#<?php echo str_replace(' ','',$category)?>').addClass('active');
        </script>
    <?php  
    }
   
}

?>
<div class="header-modal">
    <h1>Posts <?php if($category!="All"){echo "(".$category.")";}?></h1>
    <div class="search-box"><input type="text" id="search-input" placeholder="Search users by name or date added" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="min-width: 50px;">Art</th>
                <th style="min-width: 160px;">Song Title</th>
                <th>Genre</th>
                <th>Likes/Dislikes</th>
                <th style="min-width: 160px;">Uploaded By</th>
                <th style="min-width: 160px;">Date Posted</th>
                <th class="actionsth">Acion</th>
            </tr>
        </thead>
        <tbody id="users-row">
        <?php
            while($fetch_posts_r = mysqli_fetch_assoc($fetch_posts)){
                $userId = $fetch_posts_r['userId'];
                $songId = $fetch_posts_r['songId'];
                $songTitle = $fetch_posts_r['title'];
                $genre = $fetch_posts_r['genre'];
                $likes = $fetch_posts_r['likes'];
                $dislikes = $fetch_posts_r['dislikes'];
                $date_created = $fetch_posts_r['date'];

                $fetch_user = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userId'");
                $fetch_user_r = mysqli_fetch_assoc($fetch_user);

                
                if($fetch_user_r['displayname']=="nickname"){
                    $user_prefer_name =  $fetch_user_r['nickname'];
                }else{
                    $user_prefer_name = $fetch_user_r['firstname'];
                }

                $fetchupic = mysqli_query($conn,"SELECT * FROM songs_arts WHERE songId='$songId'");
                $fetchupic_r = mysqli_fetch_assoc($fetchupic);

                
                ?>
                    <tr>
                        <td>
                                <?php
                                    if(mysqli_num_rows($fetchupic)>0 && !empty($fetchupic_r['file'])){
                                        ?>
                                            <img src="../data/media/arts/<?php echo $fetchupic_r['file'];?>" style="margin-right: 0px;" class="u-pic noborder"/>
                                        <?php
                                    }else{
                                        ?>
                                            <span class="u-pic defaultart noborder" style="margin-right: 0px;" ></span>
                                        <?php
                                    }
                                ?>
                        </td>
                        <td>
                            
                            <div data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $songTitle;?>">
                                
                                &nbsp;<?php echo $songTitle;?>
                            </div>
                        </td>
                       
                        <td><?php echo $genre;?></td>
                        <td><i class="fas fa-heart blueC"></i>: <?php echo $likes;?><br><i class="fas fa-thumbs-down redC"></i>: <?php echo $dislikes;?></td>
                        <td><a href="#" onclick="view_user('<?php echo $userId;?>','')"><?php echo $user_prefer_name;?></a></td>
                        <td><?php echo substr($date_created, 0, 21);?></td>
                        <td><button onclick="view_post('<?php echo $songTitle;?>');" class="btn btn-outline-primary text-white" type="button">Go To Post</button></td>
                    </tr>
                <?php
            }
            if(mysqli_num_rows($fetch_posts)<1){
                ?>
                    <tr><td colspan="6">No Posts Found </td></tr>
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