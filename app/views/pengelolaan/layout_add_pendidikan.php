<div id="dialogAddPendidikan" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogAddPendidikan-buttons" data-options="iconCls:'icon-user'">
	<form id="formAddPendidikan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>Tingkat Pendidikan</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputTingkatPendidikan" id="inputTingkatPendidikan" data-options="url:'<?=site_url('pengelolaan/load_tingkat_pendidikan')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    </td>
                </tr>                             
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputNamaPendidikan" required id="inputNamaPendidikan" class="easyui-textbox" size="30"></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddPendidikan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanPendidikan" onclick="simpanPendidikan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddPendidikan').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save_didik   = "<?= site_url('pengelolaan/savependidikan')?>";

function addPendidikan()
{
    $('#dialogAddPendidikan').dialog('open').dialog('setTitle','Tambah Jabatan');
    $('#formAddPendidikan').form('clear');
}

function simpanPendidikan(){
   
    $('#formAddPendidikan').form('submit',{
        url: url_save_didik,
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
                load_data_pendidikan();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>