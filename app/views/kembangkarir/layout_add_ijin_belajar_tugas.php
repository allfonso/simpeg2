<div id="dialogAddIjinTugas" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinTugas-buttons" data-options="iconCls:'icon-user'">
	<form id="formgAddTugasBelajar" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
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
                    <td>Jenjang Pendidikan</td>
                    <td>: <input class="easyui-combobox" required name="jenjang_didik_id" id="jenjang_didik_id" data-options="url:'<?=site_url('referensi/load_jenjang_didik')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>: <input name="inputJurusan" required id="inputJurusan" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Universitas</td>
                    <td>: <input name="inputUniversitas" required id="inputUniversitas" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal Mulai Tugas</td>
                    <td>: <input name="inputTglMulaiTugas" required id="inputTglMulaiTugas" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai Tugas</td>
                    <td>: <input name="inputTglSelesaiTugas" required id="inputTglSelesaiTugas" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15">
                    <input type="hidden" name="current_tugas_nip" id="current_tugas_nip" value="" /></td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddIjinTugas-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanIjinTugasBelajar" onclick="simpanIjinTugasBelajar()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddIjinTugas').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">

var url_save   = "<?= site_url('kembangkarir/savetugasbelajar')?>";
var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";

function addIjinBelajarTugas()
{
    var row = $('#gridPegawaiTugasBelajar').datagrid('getSelected');
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
                    $('#dialogAddIjinTugas').dialog('open').dialog('setTitle','Tambah Tugas Belajar pegawai');
                    $('#current_tugas_nip').val( response['data']['profil']['NIP'] );
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

function simpanIjinTugasBelajar(){
    var url_save   = "<?= site_url('kembangkarir/savetugasbelajar')?>";
    var row = $('#gridPegawaiTugasBelajar').datagrid('getSelected');
    $('#formgAddTugasBelajar').form('submit',{
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