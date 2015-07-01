<div id="dialogAddPegawai" class="easyui-dialog" style="width:800px;height:550px" closed="true" buttons="#dialogAddPegawai-buttons" data-options="iconCls:'icon-user'">
	<form id="formTambahPegawai" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="new" />
		<div class="easyui-tabs" style="width:100%">
			<div title="Data utama" style="padding:10px">
				<table cellpadding="0" cellspacing="2" border="0">
	                <tr>
	                    <td width="30%">NIP : </td>
	                    <td width="70%"><input name="inputNip" id="inputNip" class="easyui-textbox" style="width:100%" required></td>
	                </tr>
	                <tr>
	                    <td>NIP Lama : </td>
	                    <td><input name="inputNipLama" id="inputNipLama" class="easyui-textbox" style="width:100%"></td>
	                </tr>
	                <tr>
	                    <td>Nama : </td>
	                    <td><input name="inputNama" id="inputNama" class="easyui-textbox" style="width:100%" required></td>
	                </tr>
	                <tr>
	                    <td>Gelar depan : </td>
	                    <td><input name="inputGelarDepan" id="inputGelarDepan" class="easyui-textbox" style="width:100%"></td>
	                </tr>
	                <tr>
	                    <td>Gelar belakang : </td>
	                    <td><input name="inputGelarBelakang" id="inputGelarBelakang" class="easyui-textbox" style="width:100%"></td>
	                </tr>
	                <tr>
	                    <td>Gelar lain : </td>
	                    <td><input name="inputGelarLain" id="inputGelarLain" class="easyui-textbox" style="width:100%"></td>
	                </tr>
	                <tr>
	                    <td>Tempat, Tanggal lahir : </td>
	                    <td>
	                        <input name="inputTempatLahir" id="inputTempatLahir" class="easyui-textbox" style="width:60%" required>&nbsp;
	                        <input name="inputTanggaLahir" id="inputTanggaLahir" class="easyui-datebox" data-options="formatter:date_format" size="15" required>
	                    </td>
	                </tr>
	                <tr>
	                    <td>No Akta Lahir : </td>
	                    <td><input name="inputNoAktaLahir" id="inputNoAktaLahir" class="easyui-textbox"  style="width:100%"></td>
	                </tr>
	                <tr>
	                    <td>Jenis Kelamin : </td>
	                    <td>
	                        <input name="inputJenisKelamin" id="inputJenisKelamin1" type="radio" value="1" id="gender1" checked=""><label for="gender1">Laki-laki</label>&nbsp;
	                        <input name="inputJenisKelamin" id="inputJenisKelamin2" type="radio" value="2" id="gender2"><label for="gender2">Perempuan</label>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Agama : </td>
	                    <td>
	                        <select name="inputAgama" id="inputAgama" class="easyui-combobox" data-options="panelHeight:'auto'" required>
	                            <?php
	                            	foreach((array)$agama as $id=>$nama)
	                            	{
	                            ?>
	                            		<option value="<?=$id?>"><?=$nama?></option>
	                            <?php
	                            	}
	                            ?>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Alamat : </td>
	                    <td>
	                        <input name="inputAlamat" id="inputAlamat" class="easyui-textbox"  style="width:100%" required>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Kodepos : </td>
	                    <td>
	                        <input name="inputKodepos" id="inputKodepos" class="easyui-textbox"  style="width:100%" required>
	                    </td>
	                </tr>
	                <tr>
	                    <td>No Handphone</td>
	                    <td>
	                        <input name="inputHandphone" id="inputHandphone" class="easyui-textbox" size="25"> 
	                        Telephone : <input name="inputTelephone" class="easyui-textbox" size="25">
	                    </td>
	                </tr>

	                <tr>
	                    <td>No Identitas : </td>
	                    <td><input name="inputNoIdentitas" id="inputNoIdentitas" class="easyui-textbox" style="width:100%" required></td>
	                </tr>
	                <tr>
	                    <td>Golongan darah : </td>
	                    <td>
	                        <select name="inputGolonganDarah" id="inputGolonganDarah" class="easyui-combobox" data-options="panelHeight:'auto'">
	                            <option value="">-pilih-</option>
	                            <option value="A">A</option>
	                            <option value="AB">AB</option>
	                            <option value="B">B</option>
	                            <option value="O">O</option>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Berat badan, Tinggi badan : </td>
	                    <td>
	                    	<input name="inputBeratBadan" id="inputBeratBadan" class="easyui-textbox" size="10"> kg
	                    	<input name="inputTinggiBadan" id="inputTinggiBadan" class="easyui-textbox" size="10"> cm
	                    </td>
	                </tr>
	                <!-- <tr>
	                    <td>Tinggi badan : </td>
	                    <td><input name="inputTinggiBadan" class="easyui-textbox" size="10"> cm</td>
	                </tr> -->
	                <tr>
	                    <td>Warna kulit : </td>
	                    <td><input name="inputWarnaKulit" id="inputWarnaKulit" class="easyui-textbox" style="width:100%"></td>
	                </tr>	                
	            </table>
			</div>
			<div title="Data pendukung" style="padding:10px">
				<table cellpadding="0" cellspacing="2" border="0">
					<tr>
	                    <td>Status Pegawai : </td>
	                    <td>
	                    	<select name="inputStatusPegawai" id="inputStatusPegawai" class="easyui-combobox" data-options="panelHeight:'auto'" style="width:100px;">
	                    	<?php
	                    		foreach($status_pegawai as $id=>$nama)
	                    		{
	                    			$selected = ($id==1)?' selected="selected"':'';
	                    	?>
	                    			<option value="<?=$id?>"<?=$selected?>><?=$nama?></option>
	                    	<?php
	                    		}
	                    	?>
	                    	</select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Kedudukan Pegawai : </td>
	                    <td>
	                    	<select name="inputKedudukanPegawai" id="inputKedudukanPegawai" class="easyui-combobox" data-options="panelHeight:'auto'">
	                    	<?php
	                    		foreach($kedudukan_pegawai as $id=>$nama)
	                    		{
	                    			$selected = ($id=='01')?' selected="selected"':'';
	                    	?>
	                    			<option value="<?=$id?>"<?=$selected?>><?=$nama?></option>
	                    	<?php
	                    		}
	                    	?>
	                    	</select>
	                    </td>
	                </tr> 
	                <tr>
	                    <td>Jenis Pegawai : </td>
	                    <td>
	                    	<select name="inputJenisPegawai" id="inputJenisPegawai" class="easyui-combobox" data-options="panelHeight:'auto'" required>
	                    	<?php
	                    		foreach($jenis_pegawai as $id=>$nama)
	                    		{	  
	                    	?>
	                    			<option value="<?=$id?>"><?=$nama?></option>
	                    	<?php
	                    		}
	                    	?>
	                    	</select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Golongan : </td>
	                    <td>
	                    	<select name="inputGolongan" id="inputGolongan" class="easyui-combobox" data-options="panelHeight:'auto'" style="width:100px;" required>
	                    	<?php
	                    		foreach($golongan as $id=>$nama)
	                    		{	  
	                    	?>
	                    			<option value="<?=$id?>"><?=$nama?></option>
	                    	<?php
	                    		}
	                    	?>
	                    	</select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Instansi : </td>
	                    <td>
	                    	<select name="inputUnor" id="inputUnor" class="easyui-combobox" data-options="panelHeight:'150px'" required>
	                    	<?php
	                    		foreach($unor as $id=>$nama)
	                    		{	  
	                    	?>
	                    			<option value="<?=$id?>"><?=$nama?></option>
	                    	<?php
	                    		}
	                    	?>
	                    	</select>
	                    </td>
	                </tr>  
					<tr>
	                    <td width="40%">No SK CPNS / Tanggal SK CPNS : </td>
	                    <td width="60%">
	                    	<input name="inputNoSKCPns" id="inputNoSKCPns" class="easyui-textbox"  style="width:50%"required>&nbsp;
	                    	<input name="inputTanggalSKCpns" id="inputTanggalSKCpns" class="easyui-datebox" data-options="formatter:date_format" required>
	                    </td>
	                </tr>	                                   
	                <tr>
	                    <td>TMT SK CPNS : </td>
	                    <td><input name="inputTMTSKCpns" id="inputTMTSKCpns" class="easyui-datebox" data-options="formatter:date_format" style="width:40%" required></td>
	                </tr>
	                <tr>
	                    <td>TMT SP CPNS : </td>
	                    <td><input name="inputTMTSPCpns" id="inputTMTSPCpns" class="easyui-datebox" data-options="formatter:date_format" style="width:40%" required></td>
	                </tr>
	                <tr>
	                    <td>No NPWP / Tanggal NPWP: </td>
	                    <td>
	                    	<input name="inputNoNpwp" id="inputNoNpwp" class="easyui-textbox" style="width:70%">&nbsp;
	                    	<input name="inputTanggalNpwp" id="inputTanggalNpwp" class="easyui-datebox" data-options="formatter:date_format">
	                    </td>
	                </tr>
	                
	                <tr>
	                    <td>No BPJS : </td>
	                    <td><input name="inputNoBpjs" id="inputNoBpjs" class="easyui-textbox" style="width:100%"></td>
	                </tr>
	                
	                <tr>
	                    <td>Kepemilikan rumah : </td>
	                    <td>
	                        <select name="inputStatusKepemilikanRumah" id="inputStatusKepemilikanRumah" class="easyui-combobox" data-options="panelHeight:'auto'">
	                            <?php
	                    		foreach($status_rumah as $id=>$nama)
	                    		{	  
		                    	?>
		                    			<option value="<?=$id?>"><?=$nama?></option>
		                    	<?php
		                    	}
		                    	?>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <td>Foto: </td>
	                    <td><input name="inputFoto" id="inputFoto" class="easyui-filebox" size="30"></td>
	                </tr>
	            </table>
			</div>
		</div>
	</form>
</div>
<div id="dialogAddPegawai-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanPegawai" onclick="simpanPegawai()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddPegawai').dialog('close')" style="width:90px">Cancel</a>
</div>

<script type="text/javascript">
var url_save = "<?=site_url('pegawai/save')?>";
var action = null;

function addPegawai()
{
    $('#dialogAddPegawai').dialog('open').dialog('setTitle','Tambah data pegawai');
    $('#formTambahPegawai').form('clear');
    $('#inputStatusPegawai').combobox('setValue','CPNS');
    $('#inputKedudukanPegawai').combobox('disable');
    $('#inputKedudukanPegawai').combobox('setValue','Aktif');
}

function simpanPegawai()
{
	$('#formTambahPegawai').form('submit',{
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
				$('#dialogAddPegawai').dialog('close');
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