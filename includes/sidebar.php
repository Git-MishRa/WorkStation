<div class="col sidebar-bg d-none d-md-block col-md-3 px-0 py-2">
    <div class="card col col-md-10 mx-auto">
        <img class="card-img-top dp" src="./resources/img/dp_sidebar.jpg" alt="Card image cap">
        <div class="card-body text-white text-center">
            <h4><b>SHITENDU MISHRA</b></h4>
            <hr>
            <span class="card-icon"><i class="fa fa-users"></i></span>       
        </div>
    </div>
    <div>
        <div id="fetchedUsers" class="text-center">
		</div>
    </div>
</div>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
	setInterval(fetchUser,1000);
    function fetchUser(){
        $.ajax({
			url:'/workstation/includes/actionDispatcher.php?action=fetch_user',
			method:'get',
            data:({}),
			success:function(data){
				if(data){
                    $("#fetchedUsers").html(data);
				}
			}
		}) 
    }
</script>