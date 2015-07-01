<div id="dialogEditPendidikan" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogEditPendidikan-buttons" data-options="iconCls:'icon-user'">
	<form id="formEditPendidikan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>Tingkat Pendidikan</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputTingkatPendidikan" id="inputEditTingkatPendidikan" data-options="url:'<?=site_url('pengelolaan/load_tingkat_pendidikan')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    </td>
                </tr>                             
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputNamaPendidikan" required id="inputEditNamaPendidikan" class="easyui-textbox" size="30">
                    <input type="hidden" name="current_pendidikan_id" id="current_pendidikan_id" value=""></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogEditPendidikan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanEditJabatan" onclick="simpanEditJabatan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditPendidikan').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save_edit_didik   = "<?= site_url('pengelolaan/saveeditpendidikan')?>";

function editPendidikan()
{
    var row = $('#gridPengelolaanPendidikan').datagrid('getSelected');
    if( !row ){
        error('Error!','Silahkan pilih pendidikan');
    }else{
        var iddidik = row.PENDIDIKAN_ID;
        var url = "<?=site_url('pengelolaan/load_detail_pendidikan')?>";
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{iddidik:iddidik},
            beforeSend:function(xhr,status){

            },
            success:function(response){
               if(response.status==1){                  
                    $('#dialogEditPendidikan').dialog('open').dialog('setTitle','Ubah data Pendidikan');
                    $('#current_pendidikan_id').val( response['data']['PENDIDIKAN_ID'] );                    
                    $('#inputEditTingkatPendidikan').combobox('setValue',response['data']['TINGKAT_PENDIDIKAN_ID']);
                    $('#inputEditNamaPendidikan').textbox('setValue',response['data']['PENDIDIKAN_NAMA']);
               }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
            }
        });
    }
}

function simpanEditJabatan(){
   
    $('#formEditPendidikan').form('submit',{
        url: url_save_edit_didik,
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
                $('#dialogEditPendidikan').dialog('close');
                load_data_pendidikan();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>