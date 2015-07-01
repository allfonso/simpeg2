<table id="grid_resources" title="Data Resources" class="easyui-datagrid" style="width:100%;height:auto"
        url="<?=site_url('sys_resources/load_data')?>"
        toolbar="#toolbar" pagination="true"
        iconCls="icon-people"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="id" width="50">ID</th>
            <th field="name" width="200">KODE AKSES</th>
            <th field="title" width="300">NAMA AKSES</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addResources()">Tambah Resources</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editResources()">Edit Resources</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteResources()">Hapus Resources</a>
</div>

<div id="popup_form_resources" class="easyui-dialog" style="width:auto;height:auto;padding:10px 20px" closed="true" buttons="#form_resources_button">
 <form id="form_resources" method="post" action="" class="easyui-form" novalidate>
 	 <table cellpadding="0" cellspacing="2" border="0">
        <tr>
            <td width="35%">Kode Akses : </td>
            <td width="65%"><input name="name" id="name" class="easyui-textbox" size="25" required="false"></td>
        </tr>
        <tr>
            <td>Nama Akses : </td>
            <td><input name="title" id="title" class="easyui-textbox" size="30" required="false"></td>
        </tr>
        <tr>
            <td>Parent : </td>
            <td>
            	<input class="easyui-combobox" name="parent_id" id="parent_id" data-options="url:'<?php echo site_url('sys_resources/get_resources'); ?>',
							method:'get',
							valueField:'id',
							textField:'title',
							panelHeight:'auto'
					">
            </td>
        </tr>
    </table>
 </form>
</div>

<div id="form_resources_button">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="simpanResources()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#popup_form_resources').dialog('close')" style="width:90px">Cancel</a>
</div>

<script>
var url;
function addResources(){    
    $('#popup_form_resources').dialog('open').dialog('setTitle','Tambah resources');
    $('form#form_resources').form('clear');
    $('#parent_id').combobox('reload', '<?php echo site_url('sys_resources/get_resources'); ?>');
}

function simpanResources(){
   $('#form_resources').form('submit',{
		onSubmit:function(){
			var validation = $(this).form('enableValidation').form('validate');
			if( validation == true )
			{
				$.ajax({
					url:"<?php echo site_url('sys_resources/save'); ?>",
					type:'post',
					dataType:'json',
					data:$('form#form_resources').serialize(),
					success : function(response){
						if( response.status == 0 ){
							error('Error',response.msg);
						}else{
							success('Sukses',response.msg);
							$('#popup_form_resources').dialog('close');		// close the dialog
							$('#grid_resources').datagrid('reload');
						}
					}
				});
			}
		}
	});
}

function editResources()
{
    var row = $('#grid_resources').datagrid('getSelected');
    console.log(row);
    if (row){
        $('#popup_form_resources').dialog('open').dialog('setTitle','Ubah resources');
        $('#form_resources').form('load',row);
        url = 'update_user.php?id='+row.id;
    }
}

function deleteResources(){
	var row = $('#grid_resources').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Menghapus data ini mungkin akan sekaligus menghapus subdata dengan parent id ini. Yakin?',function(r){
			if (r){
				$.post("<?php echo site_url('sys_resources/delete'); ?>",{id:row.id},function(result){
					if (result.status = 1){
						$('#grid_resources').datagrid('reload');	// reload the user data
					} else {
						error('Error',response.msg);
					}
				},'json');
			}
		});
	}
}

</script>