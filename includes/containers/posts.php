<?php 
require("../../connect/db_connect.php");
$fetch_genre = mysqli_query($conn,"SELECT * FROM genres ORDER BY genres ASC");
$count_posts= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM songs_details"));

?>
<div class="row">
    <div class="col col-sm-3">
        <div class="modal-nav">
            <div class="search-box pl-2 pr-1"><input type="text"  data-search="" placeholder="Search genres" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
            <div class="menu-nav interest-contain">
                <div class="link-lists active" data-filter-item data-filter-name="all" id="All" onclick="filter_posts('All');"><a href="#">All <span <?php if($count_posts>0){ echo "class='bg-primary'";}?>><?php echo $count_posts;?></span></a></div>
                <?php
                    while($fetch_genre_r = mysqli_fetch_assoc($fetch_genre)){
                        $genre = $fetch_genre_r['genres'];
                        $count_genres = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM songs_details WHERE genre='{$genre}'"));
                        ?>
                            <div data-filter-item data-filter-name="<?php echo strtolower($genre);?>" class="link-lists" id="<?php echo str_replace(' ','',$genre);?>" onclick="filter_posts('<?php echo $genre;?>');">
                                <a href="#"><?php echo $fetch_genre_r['genres'];?><span <?php if($count_genres>0){ echo "class='bg-primary'";}?>><?php echo $count_genres;?></span></a>
                            </div>
                        <?php
                    }
                ?>

            </div>
            <div class="line-divider"></div>
            <div class="menu-nav">
                <div class="link-lists" id="toplikedposts-nav" onclick="filter_posts('Top Liked');" data-filter-item data-filter-name="top liked posts"><a href="#">Top Liked Posts <span><i class="fas fa-heart"></i></span></a></div>
                <div class="link-lists" id="topdislikedposts-nav" onclick="filter_posts('Top Disliked');" data-filter-item data-filter-name="top disliked posts"><a href="#">Top Dislked Posts <span><i class="fas fa-thumbs-down"></i></span></a></div>
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
        filter_posts('All');
    });

    function filter_posts(category){
        remove_all_active_tabs();
        $('#modal-printout').html('<div class="loading-contain"><div><div class="ld ld-ring ld-spin"></div><p>Just a moment </p></div></div>');
        $('#modal-printout').load('includes/posts_filters.php',{
            category: category
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

    function remove_all_active_tabs(){
        $('#All').removeClass('active');    
        $('#AlternativeRock').removeClass('active');                           
        $('#Ambient').removeClass('active');      
        $('#Classical').removeClass('active');
        $('#Country').removeClass('active');
        $('#DanceAndEDM').removeClass('active');
        $('#Dancehall').removeClass('active');
        $('#DarkMusic').removeClass('active');
        $('#DarkTrap').removeClass('active');
        $('#DeepHouse').removeClass('active');
        $('#Disco').removeClass('active');
        $('#Drill').removeClass('active');
        $('#DrumAndBass').removeClass('active');
        $('#Dubstep').removeClass('active');
        $('#Electronic').removeClass('active');
        $('#FolkAndSinger-Songwriter').removeClass('active');
        $('#Hip-hopAndRap').removeClass('active');
        $('#House').removeClass('active');
        $('#Indie').removeClass('active');
        $('#Instrumentals').removeClass('active');
        $('#JazzAndBlues').removeClass('active');
        $('#Latin').removeClass('active');
        $('#Metal').removeClass('active');
        $('#Other').removeClass('active');
        $('#Piano').removeClass('active');
        $('#Pop').removeClass('active');
        $('#RNBAndSoul').removeClass('active');
        $('#Reggae').removeClass('active');
        $('#Reggaeton').removeClass('active');
        $('#Rock').removeClass('active');
        $('#Soundtrack').removeClass('active');
        $('#Techno').removeClass('active');
        $('#Traditional').removeClass('active');
        $('#Trance').removeClass('active');
        $('#Trap').removeClass('active');
        $('#Triphop').removeClass('active');
        $('#Weddings').removeClass('active');
        $('#World').removeClass('active');
        $('#toplikedposts-nav').removeClass('active');    
        $('#topdislikedposts-nav').removeClass('active');   
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