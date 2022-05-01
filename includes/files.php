<?php 
include './includes/dbCon.php';
$folder_parent = isset($_GET['fid'])? $_GET['fid'] : 0;
$folders = $conn->query("SELECT * FROM folders where parent_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");


$files = $conn->query("SELECT * FROM files where folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");
$f=$files;
?>
<style>
	.folder-item{
		cursor: pointer;
	}
	.folder-item:hover{

	    color: white;
	}
	.folder-item:hover > img{
		transform:translate(5px,-5px);
	}
.hidden{
	display:none;
}
.file-item:hover{
	cursor: pointer;
	color:white;
}
.file-item:hover  .hidden{
	display:block;
}
.file-item:hover > img{
		transform:translate(5px,-5px);
	}
a.custom-menu-list:hover {
    background: linear-gradient(#5c96f2,#7fadf5);
	color:black;
	text-decoration:none;
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}
a:hover{
	text-decoration:none;
}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row sticky-top">
			<div class="card col-lg-8">
				<div class="card-body" style="padding-top:5px;padding-bottom:0" id="paths">
				<!-- <a href="index.php?page=files" class="">..</a> -->
				<?php 
				$id=$folder_parent;
				while($id > 0){

					$path = $conn->query("SELECT * FROM folders where id = $id  order by name asc")->fetch_array();
					echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files&fid='.$path['id'].'\">'.$path['name'].'</a> / ")
					</script>';
					$id = $path['parent_id'];

				}
				echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files\">My Repo</a> / ")
					</script>';
				?>
					
				</div>
			</div>
			<div class="col-lg-4">
			<div class="input-group">
				
  				<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
  				<div class="input-group-append">
   					 <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
  				</div>
			</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-8"><h4><b>Folders</b></h4></div>
			<div class="col-md-4">
			<div class="row justify-content-space">
			<button class="btn col-md-5 btn-trans btn-sm" id="new_folder"><i class="fa fa-plus"></i> New Folder</button>
			<button class="btn col-md-5 btn-trans offset-1 btn-sm" id="new_file"><i class="fa fa-upload"></i> Upload File</button>
			</div>
			
			</div>
			
		</div>
		<hr>
		<div class="row">
			<?php 
			while($row=$folders->fetch_assoc()):
			?>
				<div class="card col-md-3 mt-2 mb-5 folder-item" style="background-color:transparent;border:none" data-id="<?php echo $row['id'] ?>">
				<img class="card-img-top m-auto" style="width:50%;" src="./resources/img/folder.svg" alt="Card image cap">
					<div class="card-body p-0 text-center">
							<large><b class="to_folder"> <?php echo $row['name'] ?></b></large>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<hr>
		<div>
			<div class="row">
			<div class="col-md-12"><h4><b>Files</b></h4>
			</div>
			</div>
			<hr>
			<div class="row">
					<?php 
					while($row=$files->fetch_assoc()):
						$name = explode(' ||',$row['name']);
						$name = isset($name[1]) ? $name[0] ." (".$name[1].").".$row['file_type'] : $name[0] .".".$row['file_type'];
						$img_arr = array('png','jpg','jpeg','gif','psd','tif');
						$doc_arr =array('doc','docx');
						$music=array('mp3','m4a');
						$pdf_arr =array('pdf','ps','eps','prn');
						$icon ='./resources/img/file.svg';
						if(in_array(strtolower($row['file_type']),$img_arr))
							$icon ='./resources/img/photo.svg';
						if(in_array(strtolower($row['file_type']),$music))
							$icon ='./resources/img/music.svg';
						if(in_array(strtolower($row['file_type']),$doc_arr))
							$icon ='./resources/img/file.svg';
						if(in_array(strtolower($row['file_type']),$pdf_arr))
							$icon ='./resources/img/pdf.svg';
						if(in_array(strtolower($row['file_type']),['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr']))
							$icon ='./resources/img/file.svg';
						if(in_array(strtolower($row['file_type']),['zip','rar','tar']))
							$icon ='./resources/img/file.svg';
						if(in_array(strtolower($row['file_type']),['','','mp4']))
							$icon ='./resources/img/video.svg';
					?>
					<div class="col-md-3">
						<div class="card file-item" style="background-color:transparent;border:none" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>">
  						<img class="card-img-top m-auto" style="width:50%;" src="<?php echo $icon ?>" alt="Card image cap">
  						<div class="card-body text-center" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
						  <large><b> <?php echo $name?></b></large>
						  <input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">
    						<div class="card-text hidden"><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></div>
  						</div>
						</div>
					</div>
					<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>
<div id="menu-folder-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit">Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete">Delete</a>
</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit"><span><i class="fa fa-edit"></i> </span>Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Download</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete"><span><i class="fa fa-trash"></i> </span>Delete</a>
</div>

<script>
	
	$('#new_folder').click(function(){
		uni_modal('','./includes/manage_folder.php?fid=<?php echo $folder_parent ?>')
	})
	$('#new_file').click(function(){
		uni_modal('','./includes/manage_files.php?fid=<?php echo $folder_parent ?>')
	})
	$('.folder-item').dblclick(function(){
		location.href = './index.php?page=files&fid='+$(this).attr('data-id')
	})
	$('.folder-item').bind("contextmenu", function(event) { 
    event.preventDefault();
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu'></div>")
        custom.append($('#menu-folder-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.custom-menu .edit").click(function(e){
		e.preventDefault()
		uni_modal('Rename Folder','./includes/manage_folder.php?fid=<?php echo $folder_parent ?>&id='+$(this).attr('data-id') )
	})
	$("div.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this Folder?",'delete_folder',[$(this).attr('data-id')])
	})
})

	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

    $('.file-item').removeClass('active')
    $(this).addClass('active')
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
        custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.file.custom-menu .edit").click(function(e){
		e.preventDefault()
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').siblings('large').hide();
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').show();
	})
	$("div.file.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this file?",'delete_file',[$(this).attr('data-id')])
	})
	$("div.file.custom-menu .download").click(function(e){
		e.preventDefault()
		window.open('./includes/open.php?id='+$(this).attr('data-id'))
	})

	$('.rename_file').keypress(function(e){
		var _this = $(this)
		if(e.which == 13){
			start_load()
			$.ajax({
				url:'/workstation/includes/actionDispatcher.php?action=file_rename',
				method:'POST',
				data:{id:$(this).attr('data-id'),name:$(this).val(),type:$(this).attr('data-type'),folder_id:'<?php echo $folder_parent ?>'},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp);
						if(resp.status== 1){
								_this.siblings('large').find('b').html(resp.new_name);
								end_load();
								_this.hide()
								_this.siblings('large').show()
						}
					}
				}
			})
		}
	})

})
//FILE


	$('.file-item').click(function(){
		if($(this).find('input.rename_file').is(':visible') == true)
    	return false;
		uni_modal($(this).attr('data-name'),'./includes/manage_files.php?<?php echo $folder_parent ?>&id='+$(this).attr('data-id'))
	})
	$(document).bind("click", function(event) {
    $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

});
	$(document).keyup(function(e){

    if(e.keyCode === 27){
        $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

    }

});
	$(document).ready(function(){
		$('#search').keyup(function(){
			var _f = $(this).val().toLowerCase()
			$('.to_folder').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('.card').toggle(true);
					else
					$(this).closest('.card').toggle(false);

				
			})
			$('.to_file').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('tr').toggle(true);
					else
					$(this).closest('tr').toggle(false);

				
			})
		})
	})
	function delete_folder($id){
		start_load();
		$.ajax({
			url:'/workstation/includes/actionDispatcher.php?action=delete_folder',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}
	function delete_file($id){
		start_load();
		$.ajax({
			url:'/workstation/includes/actionDispatcher.php?action=delete_file',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}

</script>