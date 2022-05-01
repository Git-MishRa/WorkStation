
<?php
	include('./includes/dbCon.php') ;
	$files = $conn->query("SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 order by date(f.date_updated) desc");
?>
<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
			<div class="card col-md-12 p-0">
				<div class="card-body p-0">
					<table width="100%" class="table table-stripped">
						<thead class="thead-dark">
						<tr>
							<th width="20%" class="">Uploader</th>
							<th width="30%" class="">Filename</th>
							<th width="20%" class="">Date</th>
							<th width="30%" class="">Description</th>
						</tr>
						</thead>
						<?php 
						while($row=$files->fetch_assoc()):
						$name = explode(' ||',$row['name']);
						$name = isset($name[1]) ? $name[0] ." (".$name[1].").".$row['file_type'] : $name[0] .".".$row['file_type'];
						$img_arr = array('png','jpg','jpeg','gif','psd','tif');
						$doc_arr =array('doc','docx');
						$pdf_arr =array('pdf','ps','eps','prn');
						$icon ='fa-file';
						if(in_array(strtolower($row['file_type']),$img_arr))
							$icon ='fa-image';
						if(in_array(strtolower($row['file_type']),$doc_arr))
							$icon ='fa-file-word';
						if(in_array(strtolower($row['file_type']),$pdf_arr))
							$icon ='fa-file-pdf';
						if(in_array(strtolower($row['file_type']),['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr']))
							$icon ='fa-file-excel';
						if(in_array(strtolower($row['file_type']),['zip','rar','tar']))
							$icon ='fa-file-archive';

					?>
						<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>">
							<td><i><?php echo ucwords($row['uname']) ?></i></td>
							<td><large><span><i class="fa <?php echo $icon ?>"></i></span><b> <?php echo $name ?></b></large>
							<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">

							</td>
							<td><i><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></i></td>
							<td><i><?php echo $row['description'] ?></i></td>
						</tr>
							
					<?php endwhile; ?>
					</table>
					
				</div>
			</div>
			
		</div>
	</div>

</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Download</a>
</div>
<script>
	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

    $('.file-item').removeClass('active')
    $(this).addClass('active')
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
        custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	
	$("div.file.custom-menu .download").click(function(e){
		e.preventDefault()
		window.open('./includes/open.php?id='+$(this).attr('data-id'))
	})

	

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
})
</script>