<div id="dialogAddIjinTugasTes" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinTugasTes-buttons" data-options="iconCls:'icon-user'">
	<form id="formAddTugasBelajar" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>NIP</td>
                    <td>:
                    <input class="easyui-combobox" required name="current_tugas_nip" id="tugas_nip" data-options="
                    url:'<?=site_url('kembangkarir/load_nip')?>',
                    valueField:'id', 
                    textField:'text',
                    panelHeight:'300px',
                    onSelect: function(rec){
                        console.log(rec);
                        var url_get_name = '<?=site_url('kembangkarir/load_nama_pegawai')?>';
                        var rec_nip = rec.text;
                        $.post(url_get_name, {niprec: rec_nip}, function(data){
                            $('span#inputNama').html(data);
                        });
                        
                        }" style="width:250px">
                    </td>
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
                    <td>: <input class="easyui-combobox" required name="inputUniversitas" id="inputUniversitas" data-options="url:'<?=site_url('kembangkarir/load_universitas')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
                </tr>
                <tr>
                    <td>Tanggal Mulai Tugas</td>
                    <td>: <input name="inputTglMulaiTugas" required id="inputTglMulaiTugas" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai Tugas</td>
                    <td>: <input name="inputTglSelesaiTugas" required id="inputTglSelesaiTugas" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15">
                    </td>
                </tr>
            </table>
		</div>		
	</form>
</div>
<div id="dialogAddIjinTugasTes-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanIjinTugasBelajarTes" onclick="simpanIjinTugasBelajarTes()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddIjinTugasTes').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type = "text/javascript">
var url_save   = "<?= site_url('kembangkarir/savetugasbelajar')?>";
// var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";
// var url_detail = "<?= site_url('kembangkarir/get_nip_all')?>";

function addIjinBelajarTugasTes()
{
    $('#dialogAddIjinTugasTes').dialog('open').dialog('setTitle','Tambah Tugas Belajar pegawai');
    $('#formTambahPegawai').form('clear');
}

function simpanIjinTugasBelajarTes(){
    var url_save   = "<?= site_url('kembangkarir/savetugasbelajar')?>";
   
    $('#formAddTugasBelajar').form('submit',{
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
                load_data_tugas_belajar();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>