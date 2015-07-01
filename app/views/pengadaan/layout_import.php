<div class="panel datagrid easyui-fluid">
	<div class="panel-header" ><div class="panel-title panel-with-icon">Import Data CPNS</div>
	<div class="panel-icon icon-people"></div>
</div>

<div style="padding:10px;">
	<form id="formImportDataPegawai" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="2" border="0">					
	        <tr>
	            <td width="40%">Data csv: </td>
	            <td width="60%"><input name="inputFile" id="inputFile" class="easyui-filebox" size="30" required></td>
	        </tr>
	        <tr>
	        	<td></td>
	        	<td><br /><a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanImport" onclick="simpanImport()" style="width:90px">Save</a></td>
	        </tr>
	    </table>			
	</form>
</div>

<script type="text/javascript">
var url_save = "<?=site_url('pengadaan/saveimport')?>";
var action = null;

function simpanImport()
{
	$('#formImportDataPegawai').form('submit',{
		url: url_save,
		type:'post',
		onSubmit: function(){
			return $(this).form('validate');
		},
		error:function(xhr,status){
            error('Gagal',status);
		},
		success: function(result){
			console.log(result);
			var response = eval('('+result+')');
			if(response.status == 1){
				$('#dialogAddPegawai').dialog('close');
				success('Berhasil',response.msg);
			}else{
				error('Gagal',response.msg);
			}
		}
	});
}
$(document).ready(function(){

});