<div id="dialogEditJabatan" class="easyui-dialog" style="width:600px;height:200px" closed="true" buttons="#dialogEditJabatan-buttons" data-options="iconCls:'icon-user'">
	<form id="formEditJabatan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>Jenis Jabatan</td>
                    <td>:
                    <input class="easyui-combobox" required name="inputJenisJabatan" id="inputEditJenisJabatan" data-options="url:'<?=site_url('pengelolaan/load_jabatan')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                    </td>
                </tr>                             
                <tr>
                    <td>Nama Jabatan</td>
                    <td>: <input name="inputJabatan" required id="inputEditJabatan" class="easyui-textbox" size="30">
                    <input type="hidden" name="current_jabatan_id" id="current_jabatan_id" value=""></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogEditJabatan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanEditJabatan" onclick="simpanEditJabatan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditJabatan').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save   = "<?= site_url('pengelolaan/savejabatan')?>";
var url_save_edit   = "<?= site_url('pengelolaan/saveeditjabatan')?>";

function editJabatan()
{
    var row = $('#gridPengelolaanJabatan').datagrid('getSelected');
    if( !row ){
        error('Error!','Silahkan pilih jabatan');
    }else{
        var idjab = row.ID;
        var url = "<?=site_url('pengelolaan/load_detail_jabatan')?>";
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{idjab:idjab},
            beforeSend:function(xhr,status){

            },
            success:function(response){
               if(response.status==1){                  
                    $('#dialogEditJabatan').dialog('open').dialog('setTitle','Ubah data Jabatan');
                    $('#current_jabatan_id').val( response['data']['ID'] );                    
                    $('#inputEditJenisJabatan').combobox('setValue',response['data']['JENIS_JABATAN_ID']);
                    $('#inputEditJabatan').textbox('setValue',response['data']['NAMA_JENJANG_JABATAN']);
               }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
            }
        });
    }
}

function simpanEditJabatan(){
   
    $('#formEditJabatan').form('submit',{
        url: url_save_edit,
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
                $('#dialogEditJabatan').dialog('close');
                load_data_jabatan();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>