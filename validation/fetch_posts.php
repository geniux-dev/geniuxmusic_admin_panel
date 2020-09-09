<?php
require("../connect/db_connect.php");
$category = mysqli_real_escape_string($conn, $_POST['category']);

if(isset($_POST['page']))
{
    $page = $_POST['page'];
}else
{
    $page = 1;
}

$num_per_page = 10;
$start_from = ($page-1)*10;


if($category=='topliked'){
    $fetchSongs = mysqli_query($conn,"SELECT * FROM (SELECT * FROM songs_details ORDER BY id DESC LIMIT 5) sub ORDER BY likes DESC");
    ?>
        <script>
            $('#toplikedTab').addClass('active');
        </script>
    <?php
}else if($category=='topdisliked'){
    $fetchSongs = mysqli_query($conn,"SELECT * FROM (SELECT * FROM songs_details ORDER BY id DESC LIMIT 5) sub ORDER BY dislikes DESC");
    ?>
        <script>
            $('#topdislikedTab').addClass('active');
        </script>
    <?php
}
while($fetchSongs_r = mysqli_fetch_assoc($fetchSongs)){
    $postId = $fetchSongs_r['songId'];
    $title = $fetchSongs_r['title'];
    $genre = $fetchSongs_r['genre'];
    $likes = $fetchSongs_r['likes'];
    $dislikes = $fetchSongs_r['dislikes'];
    $date_added = substr($fetchSongs_r['date'], 0, 21);
    $fetchart = mysqli_query($conn,"SELECT * FROM songs_arts WHERE songId='{$postId}'");
    $fetchart_r = mysqli_fetch_assoc($fetchart);
    $artcover = $fetchart_r['file'];

    ?>
        <div class="post-card">
              <?php
                if(mysqli_num_rows($fetchart)>0 && !empty($artcover) ){
                    ?>
                        <div class="post-img noborder" style="background-image: url('../data/media/arts/<?php echo $artcover;?>');"></div>
                    <?php
                }else{
                    ?>
                      <div class="post-img noborder defaultart" style="background-image: url('assets/img/defaultdisk.jpg');"></div>
                    <?php
                }

                if($category=='topliked'){
                    ?>
                        <div class="post-card-badge bg-primary"><span><?php echo $likes?></span></div>
                    <?php
                }else if($category=='topdisliked'){
                    ?>
                        <div class="post-card-badge"><span><?php echo $dislikes?></span></div>
                    <?php

                }
            ?>
            
            
            <div class="post-data"  data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $title;?>"><span><?php echo $title;?><br></span><span>Posted: <?php echo $date_added;?></span></div>
            <div class="post-menu"><button class="btn btn-primary" type="button">Go To Post</button></div>
        </div>
    <?php
}
?>
<script>
        $(document).ready(function(){
            $("[data-bs-tooltip]").tooltip();
        });
</script>
