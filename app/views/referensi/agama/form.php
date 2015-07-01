<div id="dialogFormAgama" class="easyui-dialog" style="width:400px;padding:10px 20px" closed="true" buttons="#buttonFormAgama-buttons">
    <form id="formAgama" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<table cellpadding="0" cellspacing="2" border="0"> 
    		<tr>
                <td>Nama Agama : </td>
                <td>
                    <input name="agama_nama" class="easyui-textbox" size="25">
                </td>
            </tr>
    	</table>
    </form>
</div>
<div id="buttonFormAgama-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="simpanAgama()" style="width:90px">SIMPAN</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogFormAgama').dialog('close')" style="width:90px">BATAL</a>
</div>

<script>
var url;
function addAgama()
{
    $('#dialogFormAgama').dialog('open').dialog('setTitle','Tambah data agama');
    $('#formAgama').form('clear');
}

function simpanAgama()
{
	$('#formAgama').form('submit',{
        url: '<?=site_url('agama/save')?>',
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            // var response = eval('('+result+')');
            // if( response.status == 1 )
            // {
            //     success('Sukses',response.msg);
            //     $('#dialogFormAgama').dialog('close');        // close the dialog
            //     $('#gridAgama').datagrid('reload');
            // }else{
            //     error('Gagal',response.msg);
            // }
            alert('ccc');
        }
    });
    return false;
}
</script>