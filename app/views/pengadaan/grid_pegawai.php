<table id="gridpegawai" title="Data Pegawai" class="easyui-datagrid" style="width:100%;height:auto"
        url="<?=site_url('pegawai/get_data_pegawai')?>"
        toolbar="#toolbar" pagination="true"
        iconCls="icon-people"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="NIP" width="50">NIP</th>
            <th field="NAMA" width="50">NAMA PEGAWAI</th>
            <th field="INSTANSI" width="50">INSTANSI</th>
            <th field="JABATAN" width="50">JABATAN</th>
            <th field="GOLONGAN" width="50">GOLONGAN</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addPegawai()">Tambah pegawai</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPegawai()">Edit pegawai</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deletePegawai()">Hapus pegawai</a>
</div>



<!-- Form tambah pegawai -->
<div id="dialogAddPegawai" class="easyui-dialog" style="width:800px;height:auto;padding:10px 20px" closed="true" buttons="#dialogAddPegawai-buttons">
    <form id="formTambahPegawai" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
       <div id="left">
            <table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td width="35%">NIP : </td>
                    <td width="65%"><input name="nip" class="easyui-textbox" size="25" required="true"></td>
                </tr>
                <tr>
                    <td>Nama : </td>
                    <td><input name="nama" class="easyui-textbox" size="30" required="true"></td>
                </tr>
                <tr>
                    <td>Gelar depan : </td>
                    <td><input name="gelardepan" class="easyui-textbox" size="10"></td>
                </tr>
                <tr>
                    <td>Gelar belakang : </td>
                    <td><input name="gelarbelakang" class="easyui-textbox" size="10"></td>
                </tr>
                <tr>
                    <td>Gelar lain : </td>
                    <td><input name="gelarlain" class="easyui-textbox" size="10"></td>
                </tr>
                <tr>
                    <td>Tempat, Tgl lahir : </td>
                    <td>
                        <input name="tempatlahir" class="easyui-textbox" size="20">&nbsp;
                        <input name="tanggalahir" class="easyui-datebox" size="15">
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin : </td>
                    <td>
                        <input name="gender" type="radio" value="1" id="gender1"><label for="gender1">Laki-laki</label>&nbsp;
                        <input name="gender" type="radio" value="2" id="gender2"><label for="gender2">Perempuan</label>
                    </td>
                </tr>
                <tr>
                    <td>Agama : </td>
                    <td>
                        <select name="agama" class="easyui-combobox">
                            <?php
                            foreach((array)$agama as $agama_id=>$agama_nama)
                            {
                            ?>
                                <option value="<?=$agama_id?>"><?=$agama_nama?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Alamat : </td>
                    <td>
                        <input name="alamat1" class="easyui-textbox" size="40">
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input name="alamat2" class="easyui-textbox" size="40">
                    </td>
                </tr>
                <tr>
                    <td>Kodepos</td>
                    <td>
                        <input name="kodepos" class="easyui-textbox" size="15">
                    </td>
                </tr>
                <tr>
                    <td>No Handphone</td>
                    <td>
                        <input name="handphone" class="easyui-textbox" size="25">
                    </td>
                </tr>
                <tr>
                    <td>Telephone</td>
                    <td>
                        <input name="telephone" class="easyui-textbox" size="25">
                    </td>
                </tr>
                <tr>
                    <td>No SK CPNS : </td>
                    <td><input name="noskcpns" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tgl SK CPNS : </td>
                    <td><input name="tglskcpns" class="easyui-datebox"></td>
                </tr>
            </table>
       </div>
       <div id="right">
           <table cellpadding="0" cellspacing="2" border="0">                    
                <tr>
                    <td>TMT SK CPNS : </td>
                    <td><input name="tmtskcpns" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>TMT SP CPNS : </td>
                    <td><input name="tmtspcpns" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>No NPWP : </td>
                    <td><input name="nonpwp" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal NPWP : </td>
                    <td><input name="tanggalnpwp" class="easyui-datebox"></td>
                </tr>
                <tr>
                    <td>No Akta Lahir : </td>
                    <td><input name="noaktalahir" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>No BPJS : </td>
                    <td><input name="nobpjs" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>No Identitas : </td>
                    <td><input name="noidentitas" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Golongan darah : </td>
                    <td>
                        <select name="golongandarah" class="easyui-combobox">
                            <option value="">-pilih-</option>
                            <option value="A">A</option>
                            <option value="AB">AB</option>
                            <option value="B">B</option>
                            <option value="O">O</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Berat badan : </td>
                    <td><input name="beratbadan" class="easyui-textbox" size="10"> kg</td>
                </tr>
                <tr>
                    <td>Tinggi badan : </td>
                    <td><input name="tinggibadan" class="easyui-textbox" size="10"> cm</td>
                </tr>
                <tr>
                    <td>Warna kulit : </td>
                    <td><input name="warnakulit" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Kepemilikan rumah : </td>
                    <td>
                        <select name="statuskepemilikanrumah" class="easyui-combobox">
                            <option value="">-pilih-</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Foto: </td>
                    <td><input name="foto" class="easyui-filebox" size="30"></td>
                </tr>
            </table>
       </div>
       <div class="clear"></div>
    </form>
</div>
<div id="dialogAddPegawai-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="simpanPegawai()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddPegawai').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form tambah pegawai -->




<script>
var url;
function addPegawai(){
    $('#dialogAddPegawai').dialog('open').dialog('setTitle','Tambah data pegawai');
    $('#formTambahPegawai').form('clear');
    url = '<?=site_url('pegawai/save')?>';
}

function simpanPegawai(){
    $('#formTambahPegawai').form('submit',{
        url: '<?=site_url('pegawai/save')?>',
        type:'POST',
        data:$('#formTambahPegawai').serialize(),
        onSubmit: function(){
            return $(this).form('validate');
        },
        error: function(xhr,status){
            error('Gagal',status);
        },
        success: function(result){
            var response = eval('('+result+')');
            if( response.status == 1 )
            {
                success('Sukses',response.msg);
                $('#dialogAddPegawai').dialog('close');        // close the dialog
                $('#gridpegawai').datagrid('reload');
            }else{
                error('Gagal',response.msg);
            }
        }
    });
    return false;
}

function editPegawai()
{
    var row = $('#gridpegawai').datagrid('getSelected');
    console.log(row);
    if (row){
        $('#dialogAddPegawai').dialog('open').dialog('setTitle','Ubah data pegawai');
        $('#formTambahPegawai').form('load',row);
        url = 'update_user.php?id='+row.NIP;
    }
}

</script>