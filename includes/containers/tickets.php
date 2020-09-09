<?php 
require("../../connect/db_connect.php");
$fetch_genre = mysqli_query($conn,"SELECT * FROM genres ORDER BY genres ASC");
$count_tickets = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets"));

$count_uploads = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='uploads'"));
$count_chats= mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='chats'"));
$count_comments = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='comments'"));
$count_forums = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='forums'"));
$count_notifications = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE category='notifications'"));

$count_resolved = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE status='resolved'"));
$count_pending = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM reports_tickets WHERE status='pending'"));

?>
<div class="row">
    <div class="col col-sm-3">
        <div class="modal-nav">
            <div class="search-box pl-2 pr-1"><input type="text"  data-search="" placeholder="Search genres" class="search-input"><span class="src-icon"><i class="material-icons">search</i></span></div>
            <div class="menu-nav interest-contain">
                <div class="link-lists active" data-filter-item data-filter-name="all tickets" id="All" onclick="filter_tickets('All');"><a href="#">All Tickets<span <?php if($count_tickets>0){ echo "class='bg-primary'";}?>><?php echo $count_tickets;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="regarding uploads" id="uploads" onclick="filter_tickets('uploads');"><a href="#">Regarding uploads <span <?php if($count_uploads>0){ echo "class='bg-primary'";}?>><?php echo $count_uploads;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="regarding chats" id="chats" onclick="filter_tickets('chats');"><a href="#">Regarding chats <span <?php if($count_chats>0){ echo "class='bg-primary'";}?>><?php echo $count_chats;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="regarding comments" id="comments" onclick="filter_tickets('comments');"><a href="#">Regarding comments <span <?php if($count_comments>0){ echo "class='bg-primary'";}?>><?php echo $count_comments;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="regarding forums" id="forums" onclick="filter_tickets('forums');"><a href="#">Regarding forums <span <?php if($count_forums>0){ echo "class='bg-primary'";}?>><?php echo $count_forums;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="regarding notifications" id="notifications" onclick="filter_tickets('notifications');"><a href="#">Regarding notifications <span <?php if($count_notifications>0){ echo "class='bg-primary'";}?>><?php echo $count_notifications;?></span></a></div>
            </div>
            <div class="line-divider"></div>
            <div class="menu-nav">
                <div class="link-lists" data-filter-item data-filter-name="all" id="resolvedtickets-nav" onclick="filter_tickets('resolved');"><a href="#">Resolved Tickets <span class='bg-primary'><?php echo $count_resolved;?></span></a></div>
                <div class="link-lists" data-filter-item data-filter-name="all" id="pendingtickets-nav" onclick="filter_tickets('pending');"><a href="#">Pending Tickets <span class='bg-danger'><?php echo $count_pending;?></span></a></div>
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
        filter_tickets('All');
    });

    function filter_tickets(category){
        remove_all_active_tabs();
        $('#modal-printout').html('<div class="loading-contain"><div><div class="ld ld-ring ld-spin"></div><p>Just a moment </p></div></div>');
        $('#modal-printout').load('includes/tickets_filters.php',{
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
        $('#uploads').removeClass('active'); 
        $('#chats').removeClass('active'); 
        $('#comments').removeClass('active'); 
        $('#forums').removeClass('active'); 
        $('#notifications').removeClass('active'); 
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