<div id="dialogAddIjinLuarNegeri" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinLuarNegeri-buttons" data-options="iconCls:'icon-user'">
	<form id="formgAddIjinLuarNegeri" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<div title="Data utama" style="padding:10px">
			<table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td>NIP</td>
                    <td>:
                    <input class="easyui-combobox" required name="current_ln_nip" id="current_ln_nip" data-options="
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
                    </td>
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
    $('#dialogAddIjinLuarNegeri').dialog('open').dialog('setTitle','Tambah Ijin Luar Negeri pegawai');
    $('#formgAddIjinLuarNegeri').form('clear');    
}

function simpanIjinLuarNegeri(){
    var row = $('#gridPegawaiIjinLuarNegeri').datagrid('getSelected');
    $('#formgAddIjinLuarNegeri').form('submit',{
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
                load_data_ijin_belajar_ln();
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}
</script>