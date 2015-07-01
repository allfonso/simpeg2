<div id="dialogAddIjinLuarNegeri" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinLuarNegeri-buttons" data-options="iconCls:'icon-user'">
	<form id="formgAddIjinLuarNegeri" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td width="40%">NIP</td>
                    <td width="60%">: <span id="inputNip"></span></td>
                </tr>
                <tr>
                    <td>NIP Lama</td>
                    <td>: <span id="inputNipLama"></span></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: <span id="inputNama"></span></td>
                </tr>
                <tr>
                    <td>Tanggal Keberangkatan</td>
                    <td>: <input name="inputTglkeberangkatan" required id="inputTglkeberangkatan" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Pulang</td>
                    <td>: <input name="inputTglPulang" required id="inputTglPulang" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tujuan Negara</td>
                    <td>: <input name="inputTujuanNegara" required id="inputTujuanNegara" class="easyui-textbox" size="30">
                    <input type="hidden" name="current_ln_nip" id="current_ln_nip" value="" /></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddIjinLuarNegeri-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanIjinLuarNegeri" onclick="simpanIjinLuarNegeri()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddIjinLuarNegeri').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">

var url_save   = "<?= site_url('kembangkarir/saveijinluarnegri')?>";
var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";

function addIjinBelajarLn()
{
    var row = $('#gridPegawaiIjinLuarNegeri').datagrid('getSelected');
    if ( !row ) {
        error('Error!','Silahkan pilih pegawai');
    } else {       
        var nip = row.NIP;
        console.log(nip);
        var url = url_detail;
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{nip:nip},
            beforeSend:function(xhr,status){

            },
            success:function(response){
                console.log(response);  
               if(response.status==1){  
                    console.log(response['data']);
                    console.log(response['data']['profil']['NIP'] );                       
                    $('#dialogAddIjinLuarNegeri').dialog('open').dialog('setTitle','Tambah Ijin Luar Negeri pegawai');
                    $('#current_ln_nip').val( response['data']['profil']['NIP'] );
                    $('span#inputNip').html( response['data']['profil']['NIP'] );
                    $('span#inputNipLama').html( response['data']['profil']['NIP_LAMA'] );
                    $('span#inputNama').html( response['data']['profil']['NAMA'] );
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
            }
        });
    }
}

function simpanIjinLuarNegeri(){
    var row = $('#gridPegawaiIjinLuarNegeri').datagrid('getSelected');
    $('#formgAddIjinLuarNegeri').form('submit',{
        url: url_save,
        type:'post',
        onSubmit: function(){
            console.log(row.NIP);
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
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>