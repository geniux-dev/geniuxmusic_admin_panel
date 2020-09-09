<?php
require("../../connect/db_connect.php");
$userId = $_POST['userId'];
if(!isset($_POST['goback'])){

    if($_SESSION['user_session']!=$userId){
        $_SESSION['user_session'] = $userId;
    }
}

$fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userId'");
$fetch_users_r = mysqli_fetch_assoc($fetch_users);
$fullnames = $fetch_users_r['firstname'];
$email = $fetch_users_r['email'];
$phonenumber = $fetch_users_r['phone'];
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

$fetch_followings = mysqli_query($conn,"SELECT * FROM followers WHERE from_user_id='$userId'");


$fetch_followers = mysqli_query($conn,"SELECT * FROM followers WHERE following='$userId'");
$fetchSongs = mysqli_query($conn,"SELECT * FROM songs_details WHERE userId='$userId'");

$check_chatbox = mysqli_query($conn,"SELECT * FROM chat_box WHERE from_user_id ='{$userId}' AND to_user_id !='{$userId}'");
  
                                                          

?>
<style>
.noborder {
border-radius: 0px;
}
</style>
<div class="modal fade" id="user_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="user_modalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><?php if(isset($_POST['goback'])){echo '<i onclick=\'view_user("'.$_SESSION['user_session'].'","");\' class="icon-arrow-left-circle close-btn"></i>';}?><?php echo $fullnames. $nickname;?></h5>
				<button type="button" class="close" data-dismiss="modal" onclick="close_modal();" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row ml-0 mr-0">
					<div class="col-sm-12 col-md-12 col-lg-12 p-3 pt-4 p-details">
			
						<div class="row">
							<div class="margin-center col-sm-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="row ml-0 mr-0 ">
										<div class="col-sm-12 col-md-3 col-lg-3 p-details greyBG text-center" style="min-height: 520px;">
											<div class="p-body pb-4">
                                            
                                                <?php
                                                    if($fetchupic_r['banner']!="" && !empty($fetchupic_r['banner'])){
                                                        ?>
                                                            <div class="banner-wallpaper" style="background-image: url('../images/users/banners/<?php echo $fetchupic_r['banner'];?>');background-image: linear-gradient(180deg, #0c0e1b7d 30%, #0c0e1b40 100%), url('../images/users/banners/<?php echo $fetchupic_r['banner'];?>');">
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="banner-wallpaper">
                                                            </div>
                                                        <?php
                                                    }
                                                ?>
                                                <?php
                                                    if(mysqli_num_rows($fetchupic)>0 && !empty($fetchupic_r['upic'])){
                                                        ?>
                                                            <img src="../images/users/<?php echo $fetchupic_r['upic'];?>" class="img-user"/>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <i class="far fa-user img-user"></i>
                                                        <?php
                                                    }
                                                ?>

										
												<h6 id="FullNames"><?php echo $fullnames. $nickname;?></h6>
                                                <hr>
                                                <?php
                                                    if(!empty($phonenumber))
                                                    {
                                                        ?>
                                                            <p class="mb-0"><i class="fas fa-phone-alt"></i> <?php echo $phonenumber;?></p>
                                                        <?php
                                                    }
                                                ?>
												
												<p class="mb-2"><a href="mailto:<?php echo $email;?>"><i class="fas fa-envelope"></i> <?php echo $email;?></a></p>
												<!-- <p>ID Number <br>3243434</p> -->
												<p>Account Created <br><?php echo $date_created;?></p>
											
												<a href="" class="btn btn-outline-danger" target="_blank" style="min-width: 122px">Remove User</a>
													
											</div>
										</div>
										<div class="col-sm-12 col-md-9 col-lg-9 pl-4 pr-4 pt-4 pb-0" style="border-right: 1px solid #2a303e;border-top: 1px solid #2a303e;border-bottom: 1px solid #2a303e;">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-uploads-tab" data-toggle="tab" href="#nav-uploads" role="tab" aria-controls="nav-uploads" aria-selected="true">Uploads (<?php echo mysqli_num_rows($fetchSongs);?>)</a>
                                                    <a class="nav-item nav-link" id="nav-followers-tab" data-toggle="tab" href="#nav-followers" role="tab" aria-controls="nav-followers" aria-selected="false">Followers (<?php echo mysqli_num_rows($fetch_followers);?>)</a>
                                                    <a class="nav-item nav-link" id="nav-following-tab" data-toggle="tab" href="#nav-following" role="tab" aria-controls="nav-following" aria-selected="false">Following (<?php echo mysqli_num_rows($fetch_followings);?>)</a>
                                                    <a class="nav-item nav-link" id="nav-chats-tab" data-toggle="tab" href="#nav-chats" role="tab" aria-controls="nav-chats" aria-selected="false">Chats (<?php echo mysqli_num_rows($check_chatbox);?>)</a>
                                                    <div class="search-box"><input type="text" placeholder="Search upload by title or date" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
                                                </div>
                                            </nav>
                                            <div class="tab-content p-0 mb-3" id="nav-tabContent">
                                         
                                                <div class="tab-pane fade active show" id="nav-uploads" role="tabpanel" aria-labelledby="nav-uploads-tab">
                                                 
                                                        <div class="row ml-0 mr-0">
                                                            <div class="col-sm-12 col-md-12 col-lg-12 p-2 pb-0">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="nameth">Song Title</th>
                                                                            <th class="">Genre</th>
                                                                            <th class="">Likes/Dislikes</th>
                                                                            <th class="">Date Added</th>
                                                                            <th class="actionsth">Acion</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php

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
                                                                            $count_comments = mysqli_query($conn,"SELECT * FROM comments WHERE postId='{$postId}'");

                                                                            $fetchsong = mysqli_query($conn,"SELECT * FROM songs_files WHERE songId='{$postId}'");
                                                                            $fetchsong_r = mysqli_fetch_assoc($fetchsong);

                                                                            ?>
                                                                                <tr>
                                                                                    <td class="limitTd">
                                                                                        <div class="limitTxt" data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $title;?>">
                                                                                            <?php
                                                                                                if(mysqli_num_rows($fetchart)>0 && !empty($artcover) ){
                                                                                                    ?>
                                                                                                        <img src="../data/media/arts/<?php echo $artcover;?>" class="u-pic noborder"/>
                                                                                                    <?php
                                                                                                }else{
                                                                                                    ?>
                                                                                                        <span class="u-pic defaultart noborder"></span>
                                                                                                    <?php
                                                                                                }
                                                                                            ?>
                                                                                            &nbsp;<?php echo $title;?>                                       
                                                                                        </div>

                                                                                    </td>
                                                                                    <td><?php echo $genre;?></td>
                                                                                    <td><?php echo "<i class='fas fa-heart blueC'></i>: ".$likes. "<br><i class='fas fa-thumbs-down redC'></i>: ".$dislikes;?></td>
                                                                                    <td><?php echo $date_added;?></td>
                                                                                    <td><button onclick="view_song('251111995');" class="btn btn-outline-primary text-white" type="button">More Info</button></td>
                                                                                </tr>
                                                                            <?php

                                                                        }
                                                                        if(mysqli_num_rows($fetchSongs)<1){
                                                                            ?>
                                                                                <tr>
                                                                                    <td colspan="5">No Uploads</td>
                                                                                </tr>
                                                                            <?php

                                                                        }
                                                                    ?>

                                                              

                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                             
                                                </div>

                                                <div class="tab-pane fade" id="nav-followers" role="tabpanel" aria-labelledby="nav-followers-tab">              
                                                 
                                                    <div class="row ml-0 mr-0">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 p-2 pb-0">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="nameth">Full Names</th>
                                                                            <th>Email</th>
                                                                            <th class="interetstd">Interest</th>
                                                                            <th class="poststh">Followers</th>
                                                                            <th class="actionsth">Acion</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            while($fetch_followers_r = mysqli_fetch_assoc($fetch_followers)){
                                                                                $follower_userId = $fetch_followers_r['from_user_id'];
                                                                                $fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE userId='$follower_userId'");
                                                                                $fetch_users_r = mysqli_fetch_assoc($fetch_users);

                                                                                $fullnames = $fetch_users_r['firstname'];
                                                                                $email = $fetch_users_r['email'];
                                                                                $date_created = $fetch_followers_r['date'];
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
                                                                                
                                                                                $count_followers = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM followers WHERE following='$follower_userId'"));

                                                                                $fetchupic = mysqli_query($conn,"SELECT * FROM user_pics WHERE userId='$follower_userId'");
                                                                                $fetchupic_r = mysqli_fetch_assoc($fetchupic);
                                                        
                                                                                
                                                                                ?>
                                                                                    <tr>
                                                                                        <td class="limitTd">
                                                                                            <div class="limitTxt">
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
                                                                                        <td><?php echo $email;?></td>
                                                                                        <td><?php echo $interest;?></td>
                                                                                        <td><?php echo $count_followers;?></td>
                                                                                        <td><button onclick="view_user('<?php echo $follower_userId;?>','goback');" class="btn btn-outline-primary text-white" type="button">More Info</button></td>
                                                                                    </tr>
                                                                                <?php
                                                                            }
                                                                            if(mysqli_num_rows($fetch_followers)<1){
                                                                                ?>
                                                                                    <tr>
                                                                                        <td colspan="5">No Followers</td>
                                                                                    </tr>
                                                                                <?php
    
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                </div>
                                                <div class="tab-pane fade" id="nav-following" role="tabpanel" aria-labelledby="nav-following-tab">              
                                                 
                                                        <div class="row ml-0 mr-0">
                                                            <div class="col-sm-12 col-md-12 col-lg-12 p-2 pb-0">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="nameth">Full Names</th>
                                                                            <th>Email</th>
                                                                            <th class="interetstd">Interest</th>
                                                                            <th class="poststh">Following</th>
                                                                            <th class="actionsth">Acion</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        
                                                                            while($fetch_followings_r = mysqli_fetch_assoc($fetch_followings)){
                                                                                $following_userId = $fetch_followings_r['following'];
                                                                                $fetch_users = mysqli_query($conn,"SELECT * FROM users WHERE userId='$following_userId'");
                                                                                $fetch_users_r = mysqli_fetch_assoc($fetch_users);

                                                                                $fullnames = $fetch_users_r['firstname'];
                                                                                $email = $fetch_users_r['email'];
                                                                                $date_created = $fetch_followings_r['date'];
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
                                                                                
                                                                                $count_followers = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM followers WHERE following='$following_userId'"));

                                                                                $fetchupic = mysqli_query($conn,"SELECT * FROM user_pics WHERE userId='$following_userId'");
                                                                                $fetchupic_r = mysqli_fetch_assoc($fetchupic);
                                                        
                                                                                
                                                                                ?>
                                                                                    <tr>
                                                                                        <td class="limitTd">
                                                                                            <div class="limitTxt">
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
                                                                                        <td><?php echo $email;?></td>
                                                                                        <td><?php echo $interest;?></td>
                                                                                        <td><?php echo $count_followers;?></td>
                                                                                        <td><button onclick="view_user('<?php echo $following_userId;?>','goback');" class="btn btn-outline-primary text-white" type="button">More Info</button></td>
                                                                                    </tr>
                                                                                <?php
                                                                            }
                                                                            if(mysqli_num_rows($fetch_followings)<1){
                                                                                ?>
                                                                                    <tr>
                                                                                        <td colspan="5">No Followings</td>
                                                                                    </tr>
                                                                                <?php
    
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            </div>
                                                        </div>
                                               
                                                </div>
                                                <div class="tab-pane fade" id="nav-chats" role="tabpanel" aria-labelledby="nav-chats-tab">              
                                                        
                                                    <div class="row ml-0 mr-0">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 p-2 pb-0">
                                                        <?php
                                                        while($check_chatbox_r = mysqli_fetch_assoc($check_chatbox)){
                                                                $chat_userId = $check_chatbox_r['to_user_id'];
                                                                $date_added = $check_chatbox_r['date'];
                                                                $fetch_user = mysqli_query($conn,"SELECT * FROM users WHERE userId='$userId'");
                                                                $fetch_user_r = mysqli_fetch_assoc($fetch_user);

                                                                
                                                                if($fetch_user_r['displayname']=="nickname"){
                                                                    $user_prefer_name =  $fetch_user_r['nickname'];
                                                                }else{
                                                                    $user_prefer_name = $fetch_user_r['firstname'];
                                                                }

                                                                $fetchupic = mysqli_query($conn,"SELECT * FROM user_pics WHERE userId='$chat_userId'");
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

                                                                        ?>
                                                                        <div class="post-data"  data-toggle="tooltip" data-bs-tooltip="" type="button" title="<?php echo $user_prefer_name;?>"><span><?php echo $user_prefer_name;?></span><span>Date Added: <?php echo substr($date_added, 0, 21);?></span></div>
                                                                        <div class="post-menu"><button class="btn btn-primary" type="button">VIEW USER</button></div>
                                                                    </div>
                                                                <?php
                                                            }
                                                            if(mysqli_num_rows($check_chatbox)<1){
                                                                ?>
                                                                    <div class="feedback-cont">
                                                                        <i class="fas fa-user-slash"></i>
                                                                        <span>No Users</span>
                                                                    </div>
                                                                <?php
                                                            }
                                                        ?>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
										</div>
									</div>
										
								</div>

							</div>
						</div>
						
						
					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
	<script>
            
        $(document).ready(function(){
            $("[data-bs-tooltip]").tooltip();
            $('#user_modal').modal('toggle');
            $('#nav-uploads-tab').click(function(){
                $('.modal nav .search-box').html('<input type="text" placeholder="Search upload by title or date" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span>');
            });
            $('#nav-followers-tab').click(function(){
                $('.modal nav .search-box').html('<input type="text" placeholder="Search followers by name" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span>');
            });
            $('#nav-following-tab').click(function(){
                $('.modal nav .search-box').html('<input type="text" placeholder="Search following by name" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span>');
            });
            $('#nav-chats-tab').click(function(){
                $('.modal nav .search-box').html('<input type="text" placeholder="Search chats by name"  class="search-input"><span class="src-icon"><i class="material-icons">search</i></span>');
            });
        });
		function close_modal(){
			$('#user_modal').modal('hide');
			setTimeout(function() {
				$('#user_modal').remove();
			}, 500);
		}
	</script>
</div>
