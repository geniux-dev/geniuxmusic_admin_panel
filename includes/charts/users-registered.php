<?php
require("../../connect/db_connect.php");
if(isset($_POST['year'])){
    $year = mysqli_real_escape_string($conn, $_POST['year']);
}else{
    $year = date('Y', time());
}

$fetch_users_years = mysqli_query($conn,"SELECT * FROM users");
$_SESSION['year']='';

?>
<p class="graph-title"><span id="graphTitle">... </span> <span class="filter-btn"><i class="fas fa-ellipsis-v"></i>
<div class="menuu" id="selectYears" style="display: none;">
    <ul>
    <li class="bordB"><a href="javascript:void(0);">Choose Year</a></li>
    <li onclick="filter_registered_identities('<?php echo date('Y', time());?>')" class="bordB"><a href="javascript:void(0);"><?php echo date('Y', time());?></a></li>    
        <?php
            while($fetch_users_years_r = mysqli_fetch_assoc($fetch_users_years)){
                $years = substr($fetch_users_years_r['date'], 0, 4);
        
                if($_SESSION['year']!= $years){
                    
                    $_SESSION['year'] = $years;
                    if(date('Y', time()) !=  $_SESSION['year']){
                        ?>
                            <li onclick="filter_registered_identities('<?php echo $_SESSION['year'];?>')" class="bordB"><a href="javascript:void(0);"><?php echo  $_SESSION['year'];?></a></li>
                        <?php
                    }

                    
                }
                
            }
        ?>
    </ul>
</div>
</span>
</p>
<div id="bar-example" class="morris-chart"></div>

<script>
        Morris.Bar({
        element: 'bar-example',
        data: [
            <?php
                for($i=1;$i<=12;$i++){
                    $yearmonth = $year."-".sprintf("%02d",$i);
                    if($yearmonth<=date('Y-m', time())){
                        if(sprintf("%02d",$i)=="01"){
                            $months = "JAN";
                        }else if(sprintf("%02d",$i)=="02"){
                            $months = "FEB";
                        }else if(sprintf("%02d",$i)=="03"){
                            $months = "MAR";
                        }else if(sprintf("%02d",$i)=="04"){
                            $months = "APR";
                        }else if(sprintf("%02d",$i)=="05"){
                            $months = "MAY";
                        }else if(sprintf("%02d",$i)=="06"){
                            $months = "JUN";
                        }else if(sprintf("%02d",$i)=="07"){
                            $months = "JUL";
                        }else if(sprintf("%02d",$i)=="08"){
                            $months = "AUG";
                        }else if(sprintf("%02d",$i)=="09"){
                            $months = "SEP";
                        }else if(sprintf("%02d",$i)=="10"){
                            $months = "OCT";
                        }else if(sprintf("%02d",$i)=="11"){
                            $months = "NOV";
                        }else if(sprintf("%02d",$i)=="12"){
                            $months = "DEC";
                        }
                        
                        $accounts_created = mysqli_query($conn,"SELECT * FROM users WHERE date LIKE '%$yearmonth%'");
                        $accounts_removed = mysqli_query($conn,"SELECT * FROM account_deletion WHERE status='deleted' AND deleted_date LIKE '%$yearmonth%'");
    
                        ?>
                            { y: '<?php echo $months;?>', a: <?php echo mysqli_num_rows($accounts_created); ?>, b: <?php echo mysqli_num_rows($accounts_removed); ?> },
                        <?php
                    }
                  
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        grid : true,
        axes : true,
        barColors: ['#2196F3','#ef5350'],
        labels: ['Accounts Created', 'Accounts Deleted']
        });

        document.getElementById('usersTab').classList.add('active');
        $('#graphTitle').html('Registered Identities (<?php echo $year;?>)');
</script>       
<script>
    function filter_registered_identities(year){
        $('#graphContain').html('<div class="loading-data" style="height:220px"> <div> <div class="ld ld-ring ld-spin"></div><br> <p>Just a moment</p> </div></div>');
        setTimeout(function() {
            $('#graphContain').load('includes/charts/users-registered.php',{
                year: year
            });
        }, 1000);
    }
    $('.filter-btn').click(function(){
        $('#selectYears').fadeIn(100);
    });
 
</script>
