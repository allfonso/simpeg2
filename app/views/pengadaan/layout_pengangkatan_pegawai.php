<div id="dialogPengangkatanPegawai" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogPengangkatanPegawai-buttons" data-options="iconCls:'icon-user'">
	<form id="formPengangkatanPegawai" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
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
                    <td>No. Surat Kesehatan</td>
                    <td>: <input name="inputNoSuratSehat"  id="inputNoSuratSehat" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal Surat Kesehatan</td>
                    <td>: <input name="inputTglSuratSehat"  id="inputTglSuratSehat" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>No. Surat Prajabatan</td>
                    <td>: <input name="inputNoSuratPrajab"  id="inputNoSuratPrajab" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal Surat Prajabatan </td>
                    <td>: <input name="inputTglSuratPrajab"  id="inputTglSuratPrajab" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal SK Pengangkatan </td>
                    <td>: <input name="inputTglSKPengangkatan"  id="inputTglSKPengangkatan" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>No. SK Pengangkatan </td>
                    <td>: <input name="inputSKPengangkatan"  id="inputSKPengangkatan" class="easyui-textbox" ></td>
                </tr>
                <tr>
                    <td>TMT. Pengangkatan PNS</td>
                    <td>: <input name="inputTMTPengangkatan"  id="inputTMTPengangkatan" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Jabatan </td>
                    <td>
                        : <input class="easyui-combobox"  name="jenjang_jabatan_id" id="jenjang_jabatan_id" data-options="url:'<?=site_url('referensi/load_jenjang_jabatan/1')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"> 

                        <input type="hidden" name="current_nip" id="current_nip" value="" />
                    </td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogPengangkatanPegawai-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanPengangkatan" onclick="simpanPengangkatan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogPengangkatanPegawai').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">

var url_save_pengadaan   = "<?= site_url('pengadaan/save')?>";
// var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";
var url_detail = "<?= site_url('pengadaan/get_detail_pengadaan')?>";
var action     = null;


function pengangkatanPegawai()
{    
    var row = $('#gridPegawaiCPNS').datagrid('getSelected');
    if( !row ){
        error('Error!','Silahkan pilih pegawai');
    } else {        
        // $('#formTambahPegawai').form('clear');
        // $('#inputStatusPegawai').combobox('setValue','CPNS');
        // $('#inputKedudukanPegawai').combobox('disable');
        // $('#inputKedudukanPegawai').combobox('setValue','Aktif');
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
                    $('#dialogPengangkatanPegawai').dialog('open').dialog('setTitle','Pengangkatan pegawai');
                    $('#current_nip').val( response['data']['profil']['NIP'] );
                    $('span#inputNip').html( response['data']['profil']['NIP'] );
                    $('span#inputNipLama').html( response['data']['profil']['NIP_LAMA'] );
                    $('span#inputNama').html( response['data']['profil']['NAMA_PEGAWAI'] );
                    $('#inputNoSuratSehat').textbox('setValue',response['data']['profil']['NO_SURAT_SEHAT']);
                    $('#inputTglSuratSehat').textbox('setValue',response['data']['profil']['TGL_SURAT_SEHAT']);
                    $('#inputNoSuratPrajab').textbox('setValue',response['data']['profil']['NOMOR_SERTIFIKAT']);
                    $('#inputTglSuratPrajab').textbox('setValue',response['data']['profil']['TANGGAL_SELESAI']);
                    $('#inputSKPengangkatan').textbox('setValue',response['data']['profil']['NOMOR_SK']);
                    $('#inputTglSKPengangkatan').textbox('setValue',response['data']['profil']['TANGGAL_SK']);
                    $('#inputTMTPengangkatan').textbox('setValue',response['data']['profil']['TMT_GOLONGAN']);
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
            }
        });
    }
}

function simpanPengangkatan()
{
    var row = $('#gridPegawaiCPNS').datagrid('getSelected');
	$('#formPengangkatanPegawai').form('submit',{
		url: url_save_pengadaan,
		type:'post',
		onSubmit: function(){
            console.log(row.NIP);
            var inputNoSuratSehat = $('#inputNoSuratSehat').textbox('getValue');
            var inputTglSuratSehat = $('#inputTglSuratSehat').datebox('getValue');

            var inputNoSuratPrajab = $('#inputNoSuratPrajab').textbox('getValue');
            var inputTglSuratPrajab = $('#inputTglSuratPrajab').datebox('getValue');

            var inputSKPengangkatan = $('#inputSKPengangkatan').textbox('getValue');
            var inputTglSKPengangkatan = $('#inputTglSKPengangkatan').datebox('getValue');
            var inputTMTPengangkatan = $('#inputTMTPengangkatan').datebox('getValue');
            var jenjang_jabatan_id = $('#jenjang_jabatan_id').combobox('getValue');

            if (inputNoSuratSehat == '' && inputTglSuratSehat == '' && inputNoSuratPrajab == '' && inputTglSuratPrajab == '' &&  inputSKPengangkatan == '' && inputTMTPengangkatan == '' && jenjang_jabatan_id == '' && inputTglSKPengangkatan == '') {
                error('Gagal',"Isian form harus diisi");
                return false;
            }

            if ((inputNoSuratSehat == '' && inputTglSuratSehat != '') || (inputNoSuratSehat != '' && inputTglSuratSehat == '') ) {
                error('Gagal',"Nomor surat sehat dan tanggal surat sehat harus diisi");
                return false;
            }

            if ((inputNoSuratPrajab == '' && inputTglSuratPrajab != '') || (inputNoSuratPrajab != '' && inputTglSuratPrajab == '') ) {
                error('Gagal',"Nomor surat prajab dan tanggal surat prajab harus diisi");
                return false;
            }

            // if (inputSKPengangkatan != '' || inputTMTPengangkatan != '' || jenjang_jabatan_id != '' || inputTglSKPengangkatan != '') {

            //     error('Gagal',inputTglSKPengangkatan+inputSKPengangkatan+inputTMTPengangkatan+jenjang_jabatan_id+"Tanggal SK pengangkatan,SK pengangkatan, TMT pengangkatan dan jabatan harus diisi");
            //     return false;
            // }
            var a,b,c,d,total;
            if (inputSKPengangkatan != '') {
                a = 1;
            } else {
                a = 0;
            }

            if (inputTMTPengangkatan != '') {
                b = 1;
            } else {
                b = 0;
            }

            // if (jenjang_jabatan_id != '') {
            //     c = 1;
            // } else {
            //     c = 0;
            // }
            c = 0;

            if (inputTglSKPengangkatan != '') {
                d = 1;
            } else {
                d = 0;
            }
			console.log(a);console.log(b);console.log(c);console.log(d);
            total = a+b+c+d;

            // if (total > 0 && total < 3) {
            //     error('Gagal',total+" Tanggal SK pengangkatan,SK pengangkatan, TMT pengangkatan dan jabatan harus diisi");
            //     return false;
            // }

            return true;
            
		},
		error:function(xhr,status){
            error('Gagal',status);
		},
		success: function(result){
			console.log(result);
			var response = eval('('+result+')');
			if(response.status == 1){
				$('#dialogPengangkatanPegawai').dialog('close');
                load_pegawai_cpns();
				success('Berhasil',response.msg);
			}else{
				error('Gagal',response.msg);
			}
		}
	});
}
$(document).ready(function(){

});



</script>