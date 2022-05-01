<?php 
include('./dbCon.php');
if(isset($_GET['id'])){
$qry = $conn->query("SELECT `files`.*,users.name FROM `files` join users on `files`.`user_id`=`users`.`id` where `files`.id=".$_GET['id']);
	if($qry->num_rows > 0){
		foreach($qry->fetch_array() as $k => $v){
			$meta[$k] = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-files">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] :'' ?>">
		<input type="hidden" name="folder_id" value="<?php echo isset($_GET['fid']) ? $_GET['fid'] :'' ?>">
		<!-- <div class="form-group">
			<label for="name" class="control-label">File Name</label>
			<input type="text" name="name" id="name" value="<?php echo isset($meta['name']) ? $meta['name'] :'' ?>" class="form-control">
		</div> -->
		<?php if(!isset($_GET['id']) || empty($_GET['id'])): ?>
		<div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text">Upload</span>
		  </div>
		  <div class="custom-file">
		    <input type="file" class="custom-file-input" name="upload" id="upload" onchange="displayname(this,$(this))">
		    <label class="custom-file-label" for="upload">Choose file</label>
		  </div>
		</div>
	<?php endif; ?>
		<div class="form-group">
			<label for="" class="control-label">Description</label>
			<textarea name="description" id="modal-textarea" cols="30" rows="10" class="form-control"><?php echo isset($meta['description']) ? $meta['description']." Uploaded By ".$meta['name'] :'' ?></textarea>
		</div>
		<div class="form-group">
			<label for="is_public" class="control-label"><input type="checkbox" name="is_public" id="is_public"><i> Share to All Users</i></label>
		</div>
		<div class="form-group" id="msg"></div>

	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-files').submit(function(e){
			e.preventDefault()
			start_load();
		$('#msg').html('')
		$.ajax({
			url:'/workstation/includes/actionDispatcher.php?action=save_files',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				console.log("done upload")
				console.log(resp)
				if(typeof resp != undefined){
					resp = JSON.parse(resp);
					if(resp.status == 1){
						alert_toast("New File successfully added.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
						end_load()
					}
				}
			}
		})
		})
	})
	function displayname(input,_this) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function (e) {
            			_this.siblings('label').html(input.files[0]['name'])
			            
			        }

			        reader.readAsDataURL(input.files[0]);
			    }
			}
</script>