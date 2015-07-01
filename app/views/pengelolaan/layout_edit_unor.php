<div id="dialogEditUnor" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogEditUnor-buttons" data-options="iconCls:'icon-user'">
	<form id="formEditJabatan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>Nama Unor</td>
                    <td>: <input name="inputNamaUnor" required id="inputEditNamaUnor" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputNamaJabatan" required id="inputEditNamaJabatan" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputInstansi" id="inputEditInstansi" data-options="url:'<?=site_url('pengelolaan/load_instansi')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    <input type="hidden" name="current_unor_id" id="current_unor_id" value="">
                    </td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogEditUnor-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanEditUnor" onclick="simpanEditUnor()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditUnor').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save_edit_unor   = "<?= site_url('pengelolaan/saveeditunor')?>";

function editUnor()
{
    var row = $('#gridPengelolaanUnor').datagrid('getSelected');
    if( !row ){
        error('Error!','Silahkan pilih Unor');
    }else{
        var idunor = row.ID;
        var url = "<?=site_url('pengelolaan/load_detail_unor')?>";
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{idunor:idunor},
            beforeSend:function(xhr,status){

            },
            success:function(response){
               if(response.status==1){                  
                    $('#dialogEditUnor').dialog('open').dialog('setTitle','Ubah data Unor');
                    $('#current_unor_id').val( response['data']['ID'] );
                    $('#inputEditNamaUnor').textbox('setValue',response['data']['UNOR_NAMA']);               
                    $('#inputEditNamaJabatan').textbox('setValue',response['data']['UNOR_NAMA_JABATAN']);
                    $('#inputEditInstansi').combobox('setValue',response['data']['INSTANSI_ID']);
               }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
            }
        });
    }
}

function simpanEditUnor(){
   
    $('#formEditJabatan').form('submit',{
        url: url_save_edit_unor,
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
                $('#dialogEditUnor').dialog('close');
                load_data_unor();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>