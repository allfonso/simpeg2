<script>
			$(document).ready(function(){
				$( "#formEditAnjab" ).submit(function() {
					$.ajax({
						url : "<?=site_url('anjab/update')?>",
						type : 'post',
						dataType : 'json',
						data : $('#formEditAnjab').serialize(),
						success : function(response){							
							if (response.status == 1) {
								

								success('Berhasil',response.msg);
								$("#kategori").html(response.updkat);

							} else {
								error('Gagal',response.msg);
							}
						}

					});
					return false;
				});

				$('#formaddanjab').submit(function(){
					var validation = $(this).form('enableValidation').form('validate');
					if( validation == true )
					{
						//set ajax
						$.ajax({
							url : "<?=site_url('anjab/save')?>",
							type : 'post',
							dataType : 'json',
							data : $('#formaddanjab').serialize(),
							success : function(response){
								if (response.status == 1) {
									// update select option
									$.ajax({
										url : "<?=site_url('anjab/updateOption')?>",
										type : 'post',										
										success : function(data){
											$("#optionjabatan").html(data);											
										}
									});
									var li =
									'<li id="kategori_' + response.id + '" data-category_id="' + response.id + '">' +
										'<div class="ns-item">' +
											'<div class="ns-title"><i class="fa fa-arrows"></i>' + response.name + '</div>' +
											'<div class="ns-actions">' +
												'<a href="#" class="edit-kategori" title="Edit">' +
													'<i class="fa fa-pencil"></i>' +
												'</a>' +
												'<a href="#" class="delete-kategori" title="Delete">' +
													'<i class="fa fa-trash-o"></i>' +
												'</a>' +
											'</div>' +
										'</div>' +
									'</li>';
									if (response.parent_id == 0) {
										$('#kategori > ul').append(li);
									} else {
										var parent_li = $('#kategori_' + response.parent_id);
										var ul = parent_li.children('ul');
										//console.log(parent_li);
										//console.log(ul);
										if (ul.length) {
											ul.append(li);
										} else {
											parent_li.append('<ul>' + li + '<ul>');
										}
									}
									// success('Berhasil',response.msg);
								} else {
									// error('Gagal',response.msg);
								}
							}

						});
					}
					return false;
				});	
	
			});
			function submitForm(){
				$('#loginapp').form('submit',{
					onSubmit:function(){
						var validation = $(this).form('enableValidation').form('validate');
						if( validation == true )
						{
							var username = $('input[name="username"]').val();
							var password = $('input[name="password"]').val();
							$.ajax({
								url:"<?php echo site_url('login/auth'); ?>",
								type:'post',
								dataType:'json',
								data:{username:username,password:password},
								success : function(response){
									if( response.status == 0 ){
										error('Login gagal',response.msg);
									}else{
										success('Login berhasil',response.msg);
										if(response.redirect){
											document.location.href=response.redirect;
										}
									}
								}
							});
						}
					}
				});
			}

		function editAnjab(id)
		{
		   		console.log(id);
		        $('#dialogEditAnjab').dialog('open').dialog('setTitle','Ubah data anjab');
		        //get data anjab
		        $.ajax({
					url : "<?=site_url('anjab/getDataAnjab')?>",
					data : {id : id},
					dataType:'json',
					type : 'post',										
					success : function(response){						
						if (response.status == 1) {
							console.log(response.nama);
							console.log(response.nominal_acuan);
							$("#editnamajabatan").val(response.nama);
							$("#editnominalacuan").val(response.nominal_acuan);
							$("#editnominalreal").val(response.nominal_real);
							$("#anjab_id").val(response.id);
						}
					}
				});
		}

		function saveEditAnjab()
		{			
			$( "#formEditAnjab" ).submit(function() {
				console.log("asd23e233");
				return false;
			});
		}

		</script>

<div class="panel datagrid easyui-fluid">
	<div class="panel-header" ><div class="panel-title panel-with-icon">Kelola Analisa Jabatan</div>
	<div class="panel-icon icon-people"></div>
</div>
<div style="padding:10px;">
	<!-- <form id="formaddanjab" method="post" action="<?=site_url('anjab/save')?>" class="easyui-form" data-options="novalidate:true"> -->
	<form id="formaddanjab" method="post" action="<?=site_url('anjab/save')?>" >
		<div id="result"></div>
		<table width="100%" border="0">
        	<tr>
	        	<td width="15%">Nama Jabatan</td>
	        	<td width="75%">
	        		<input class="easyui-textbox" type="text" name="namajabatan" required />
	        	</td>
        	</tr>
        	<tr>
	        	<td>Nominal Acuan</td>
	        	<td>
	        		<input class="easyui-textbox" type="text" name="nominalacuan" required />
	        	</td>
        	</tr>
        	<tr>
	        	<td>Nominal Real</td>
	        	<td>
	        		<input class="easyui-textbox" type="text" name="nominalreal" required />
	        	</td>
        	</tr>
        	<tr>
	        	<td>Sub Kategori</td>
	        	<td>	        		 
	        		<select id="optionjabatan" name="parent_id">
	        		<?php
                        echo $jabatan;
                    ?>
                    </select>
	        	</td>
        	</tr>
        	<tr>
	        	<td>&nbsp;</td>
	        	<td><br>
	        		<!-- <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Login</a> -->
	        		<input type="submit" name="submit" value="Simpan">
	        	</td>
        	</tr>
        </table>
	</form>
</div>



<div style="height:20px;"></div>
<div class="panel datagrid easyui-fluid">
	<div class="panel-header"><div class="panel-title panel-with-icon">Data Kelola Analisa Jabatan</div>
	<div class="panel-icon icon-people"></div>
</div>
<?php
include APPPATH."libraries/Tree.php";
$tree = new Tree;

// $query = $this->GetDataFromDB("SELECT * FROM sp_anjab ORDER BY par_id,urutan","all");
// echo "<pre>";print_r($query);echo "</pre>";
// echo "<pre>";print_r($anjab);echo "</pre>";
function get_label($data) {
	global $db;
	$name  = $data['nama'];
	$id    = $data['id'];
	$label =
		'<div class="ns-item">
			<div class="ns-title"><i class="fa fa-arrows"></i>'.$name.'</div>
			<div class="ns-actions">
				<a href="javascript:void(0)" class="easyui-linkbutton"  plain="true" onclick="editAnjab('.$id.')">
					<i class="fa fa-pencil"></i>
				</a>
				<a href="#" class="delete-kategori" title="Delete" data-iddel="'.$id.'">
					<i class="fa fa-trash-o"></i>
				</a>
			</div>
		</div>';
	return $label;
}
foreach ($anjab as $row) {
	$tree->add_item(
		$row['id'],
		$row['parent_id'],
		sprintf(' id="kategori_%s" data-category_id="%s"', $row['id'], $row['id']),
		get_label($row)
	);
}

$kategori = $tree->generate('class="sortable"');

?>
<script src="<?=asset_url('js/kategori.js')?>"></script>
<div class="prod-cat-list">
	<form action="<?=site_url("anjab/saveOrderBy")?>" id="kategori">
		<?=$kategori?>
	</form>
</div>


<div id="dialogEditAnjab" class="easyui-dialog" style="width:400px;height:300px" closed="true" buttons="#dialogEditAnjab-buttons" data-options="iconCls:'icon-user'">
	<form id="formEditAnjab" method="post" action="" enctype="multipart/form-data">
		<div style="padding:30px;">
			
				<table width="100%" border="0">
		        	<tr>
			        	<td width="30%">Nama Jabatan</td>
			        	<td>
			        		: <input id="editnamajabatan"  type="text" name="editnamajabatan" required="required" value="" />
			        	</td>
		        	</tr>
		        	<tr>
			        	<td>Nominal Acuan</td>
			        	<td>
			        		: <input id="editnominalacuan"  type="text" name="editnominalacuan" required="required" value="" />
			        	</td>
		        	</tr>
		        	<tr>
			        	<td>Nominal Acuan</td>
			        	<td>
			        		: <input id="editnominalreal"  type="text" name="editnominalreal" required="required" value="" />
			        	</td>
		        	</tr>        	
		        	<tr>
			        	<td>&nbsp;</td>
			        	<td><br>
			        		<!-- <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Login</a> -->
			        		<input type="hidden" name="anjab_id" id="anjab_id" value="">
			        		<input type="submit" name="submit" value="Simpan">
			        	</td>
		        	</tr>
		        </table>
			
		</div>
		<div id="dialogEditAnjab-buttons">

		    <!-- <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="saveEditAnjab"onclick="saveEditAnjab()" style="width:90px">Save</a> -->
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditAnjab').dialog('close')" style="width:90px">Cancel</a>
		</div>
	</form>
</div>


		

