<div id="dialogAddJabatan" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogAddJabatan-buttons" data-options="iconCls:'icon-user'">
	<form id="formAddJabatan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>Jenis Jabatan</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputJenisJabatan" id="inputJenisJabatan" data-options="url:'<?=site_url('pengelolaan/load_jabatan')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    </td>
                </tr>                             
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputJabatan" required id="inputJabatan" class="easyui-textbox" size="30"></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddJabatan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanJabatan" onclick="simpanJabatan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddJabatan').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save   = "<?= site_url('pengelolaan/savejabatan')?>";

function addJabatan()
{
    $('#dialogAddJabatan').dialog('open').dialog('setTitle','Tambah Jabatan');
    $('#formAddJabatan').form('clear');
}

function simpanJabatan(){
   
    $('#formAddJabatan').form('submit',{
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
                // $('#dialogPengangkatanPegawai').dialog('close');
                load_data_jabatan();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>