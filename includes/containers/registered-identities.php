<?php 
require("../../connect/db_connect.php");
$fetchinterest = mysqli_query($conn,"SELECT * FROM interests ORDER BY interests ASC");
$count_users = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));

?>
<div class="row">
    <div class="col col-sm-3">
        <div class="modal-nav">
            <div class="search-box pl-2 pr-1"><input type="text"  data-search="" placeholder="Search interests" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
            <div class="menu-nav interest-contain">
                <div class="link-lists active" data-filter-item data-filter-name="all" id="All" onclick="filter_users('All');"><a href="#">All <span <?php if($count_users>0){ echo "class='bg-primary'";}?>><?php echo $count_users;?></span></a></div>
                <?php
                    while($fetchinterest_r = mysqli_fetch_assoc($fetchinterest)){
                        $users_interests = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE interest='{$fetchinterest_r['interests']}'"));

                        ?>
                            <div data-filter-item data-filter-name="<?php echo strtolower($fetchinterest_r['interests']);?>" class="link-lists" id="<?php echo str_replace(' ','',$fetchinterest_r['interests']);?>" onclick="filter_users('<?php echo $fetchinterest_r['interests'];?>');">
                                <a href="#"><?php echo $fetchinterest_r['interests'];?><span <?php if($users_interests>0){ echo "class='bg-primary'";}?>><?php echo $users_interests;?></span></a>
                            </div>
                        <?php
                    }
                ?>

            </div>
            <div class="line-divider"></div>
            <div class="menu-nav">
                <div class="link-lists" data-filter-item data-filter-name="top followed identities"><a href="#">Top Followed Identities</a></div>
                <div class="link-lists" data-filter-item data-filter-name="top following identities"><a href="#">Top Following Identities<br></a></div>
            </div>
            <div class="line-divider"></div>
            <div class="menu-nav">
                <div class="link-lists" data-filter-item data-filter-name="dark theme identities"><a href="#">Dark Theme Identitties</a></div>
                <div class="link-lists" data-filter-item data-filter-name="light theme identities"><a href="#">Light Theme Identities<br></a></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="modal-container" id="modal-printout">
        
           
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("[data-bs-tooltip]").tooltip();
        filter_users('All');
    });

    function filter_users(interest){
        $('#All').removeClass('active');
        $('#Amateur').removeClass('active');
        $('#Artist').removeClass('active');
        $('#BeatMaker').removeClass('active');
        $('#Composer').removeClass('active');
        $('#Dancer').removeClass('active');
        $('#Director').removeClass('active');
        $('#GhostWriter').removeClass('active');
        $('#Instrumentalist').removeClass('active');
        $('#Lyricist').removeClass('active');
        $('#Manager').removeClass('active');
        $('#Musician').removeClass('active');
        $('#Producer').removeClass('active');
        $('#Rapper').removeClass('active');
        $('#RecordLabel').removeClass('active');
        $('#RegularUser').removeClass('active');
        $('#Singer').removeClass('active');
        $('#SongWriter').removeClass('active');
        $('#SoundEngineer').removeClass('active');
        $('#Trapper').removeClass('active');
        $('#Writer').removeClass('active');
        $('#modal-printout').html('<div class="loading-contain"><div><div class="ld ld-ring ld-spin"></div><p>Just a moment </p></div></div>');
        $('#modal-printout').load('includes/user_filters.php',{
            interest: interest
        });
    }
    function view_user(userId,goback){
        if(goback=="goback"){
            $('#myscripts').load('includes/modals/view_user.php',{
                userId: userId,
                goback: goback
            });
        }else{
            $('#myscripts').load('includes/modals/view_user.php',{
                userId: userId
            });
        }
        
    }
    $('[data-search]').on('keyup', function() {
      var searchVal = $(this).val();
      var filterItems = $('[data-filter-item]');

      if (searchVal != '') {
        filterItems.addClass('hidden');
        $('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
      } else {
        filterItems.removeClass('hidden');
      }
    });

</script>