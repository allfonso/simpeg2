<div id="dialogAddUnor" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogAddUnor-buttons" data-options="iconCls:'icon-user'">
	<form id="formAddUnor" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                
                <tr>
                    <td>Nama Unor</td>
                    <td>: <input name="inputNamaUnor" required id="inputNamaUnor" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputNamaJabatan" required id="inputNamaJabatan" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputInstansi" id="inputInstansi" data-options="url:'<?=site_url('pengelolaan/load_instansi')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    </td>
                </tr>                
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddUnor-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanUnor" onclick="simpanUnor()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddUnor').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save_unor   = "<?= site_url('pengelolaan/saveunor')?>";

function addUnor()
{
    $('#dialogAddUnor').dialog('open').dialog('setTitle','Tambah Unor');
    $('#formAddUnor').form('clear');
}

function simpanUnor(){
    $('#formAddUnor').form('submit',{
        url: url_save_unor,
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
                load_data_unor();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>