<!-- Form riwayat jabatan -->
<div id="dialogAddRiwayatJabatan" class="easyui-dialog" style="width:500px;height:400px;padding:10px" closed="true" buttons="#dialogAddRiwayatJabatan-buttons">
    <form id="formTambahRiwayatJabatan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_jabatan_id" id="riwayat_jabatan_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
	    	<tr>
	    		<td width="30%">Instansi</td>
	    		<td width="70%">
	    			<input class="easyui-combobox" required name="unor_id" id="unor_id" data-options=" url:'<?=site_url('referensi/load_unor_induk')?>', valueField:'id', textField:'text',	panelHeight:'auto',onSelect:function(rec){ getUnit(rec.id); }" style="width:250px">
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Unit</td>
	    		<td><input class="easyui-combobox" required name="unit_id" id="unit_id" data-options="panelHeight:'auto',valueField:'id', textField:'text',onSelect:function(rec){ getSubUnit(rec.id); }" style="width:250px"></td>
	    	</tr>
	    	<tr>
	    		<td>Subunit</td>
	    		<td><input class="easyui-combobox" required name="subunit_id" id="subunit_id" data-options="panelHeight:'auto',valueField:'id', textField:'text'" style="width:250px"></td>
	    	</tr>
	    	<tr>
	    		<td>Jenis jabatan</td>
	    		<td>
	    			<select class="easyui-combobox" name="jabatan_id" id="jabatan_id" data-options="panelHeight:'auto'" style="width:250px" required >
	    				<?php
	    				$jenis_jabatan = $this->riwayat_jabatan_model->getJenisJabatan();
	    				foreach((array)$jenis_jabatan as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Jabatan</td>
	    		<td><input class="easyui-combobox" required name="jenjang_jabatan_id" id="jenjang_jabatan_id" data-options="url:'<?=site_url('referensi/load_jenjang_jabatan')?>', valueField:'id', textField:'text',panelHeight:'auto'" style="width:250px"></td>
	    	</tr>
	    	<tr>
	    		<td>Eselon</td>
	    		<td>
	    			<select class="easyui-combobox" name="eselon_id" id="eselon_id" data-options="panelHeight:'auto'" style="width:250px" required >
	    				<?php
	    				$jenis_jabatan = $this->riwayat_golongan_model->getPangkatGolongan();
	    				foreach((array)$jenis_jabatan as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>TMT Jabatan</td>
	    		<td><input class="easyui-datebox" name="tmt_jabatan" id="tmt_jabatan" data-options="formatter:date_format,parser:date_parser" required ></td>
	    	</tr>
	    	<tr>
	    		<td>Nomor SK</td>
	    		<td><input class="easyui-textbox" name="no_sk" id="no_sk" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal SK</td>
	    		<td><input class="easyui-datebox" name="tgl_sk" id="tgl_sk" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>TMT Pelantikan</td>
	    		<td><input class="easyui-datebox" name="tmt_pelantikan" id="tmt_pelantikan" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Pejabat penetap</td>
	    		<td>
	    			<select class="easyui-combobox" name="penetap_id" id="penetap_id" data-options="panelHeight:'auto'" style="width:250px" required>
	    				<?php
	    				$penetap = $this->application_model->getPejabatPenetap();
	    				foreach((array)$penetap as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatJabatan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanPegawai" onclick="saveRiwayatJabatan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatJabatan').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form riwayat jabatan -->

<!-- Form riwayat golongan -->
<div id="dialogAddRiwayatGolongan" class="easyui-dialog" style="width:500px;height:400px;padding:10px" closed="true" buttons="#dialogAddRiwayatGolongan-buttons">
    <form id="formTambahRiwayatGolongan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_golongan_id" id="riwayat_golongan_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
    		<tr>
	    		<td>Kode Jenis KP</td>
	    		<td><input class="easyui-textbox" name="kode_jenis_kp" id="kode_jenis_kp" value="211" required></td>
	    	</tr>
	    	<tr>
	    		<td width="30%">Golongan</td>
	    		<td width="70%">
	    			<select class="easyui-combobox" name="golongan_id" id="golongan_id" data-options="panelHeight:'auto'" style="width:100px" required>
	    				<?php
	    				$golongan = $this->golongan_model->get_golongan();
	    				foreach((array)$golongan as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>">Golongan <?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Nomor SK</td>
	    		<td><input class="easyui-textbox" name="no_sk_gol" id="no_sk_gol" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal SK</td>
	    		<td><input class="easyui-datebox" name="tgl_sk_gol" id="tgl_sk_gol" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Nomor BKN</td>
	    		<td><input class="easyui-textbox" name="no_bkn" id="no_bkn" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal BKN</td>
	    		<td><input class="easyui-datebox" name="tgl_bkn" id="tgl_bkn" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>TMT Golongan</td>
	    		<td><input class="easyui-datebox" name="tmt_golongan" id="tmt_golongan" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Masa Kerja Tahun</td>
	    		<td><input class="easyui-textbox" name="masa_kerja_tahun" id="masa_kerja_tahun" required></td>
	    	</tr>
	    	<tr>
	    		<td>Masa Kerja Bulan</td>
	    		<td><input class="easyui-textbox" name="masa_kerja_bulan" id="masa_kerja_bulan" required></td>
	    	</tr>
	    	<tr>
	    		<td>Angka Kredit Utama</td>
	    		<td><input class="easyui-textbox" name="angka_kredit_utama" id="angka_kredit_utama" required></td>
	    	</tr>
	    	<tr>
	    		<td>Angka Kredit Tambahan</td>
	    		<td><input class="easyui-textbox" name="angka_kredit_tambahan" id="angka_kredit_tambahan" required></td>
	    	</tr>
	    	<tr>
	    		<td>Pejabat penetap</td>
	    		<td>
	    			<select class="easyui-combobox" name="penetap_id" id="penetap_id" data-options="panelHeight:'auto'" style="width:250px" required>
	    				<?php
	    				$penetap = $this->application_model->getPejabatPenetap();
	    				foreach((array)$penetap as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatGolongan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanPegawai" onclick="saveRiwayatGolongan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatGolongan').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form riwayat golongan -->

<!-- Form riwayat diklat -->
<div id="dialogAddRiwayatDiklat" class="easyui-dialog" style="width:500px;height:auto;padding:10px" closed="true" buttons="#dialogAddRiwayatDiklat-buttons">
	<form id="formTambahRiwayatDiklat" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_diklat_id" id="riwayat_diklat_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
	    	<tr>
	    		<td width="30%">Jenis Diklat</td>
	    		<td width="70%">
	    			<select class="easyui-combobox" name="jenis_diklat" id="jenis_diklat" data-options="panelHeight:'auto'" style="width:150px" required>
	    				<?php
	    				$jenis_diklat = $this->diklat_model->getDataJenisDiklat();
	    				foreach((array)$jenis_diklat as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Diklat Struktural</td>
	    		<td>
	    			<select class="easyui-combobox" name="diklat_struktural" id="diklat_struktural" data-options="panelHeight:'auto'" style="width:300px" required>
	    				<?php
	    				$diklat_struktural = $this->diklat_model->getDataDiklatStruktural();
	    				foreach((array)$diklat_struktural as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Nama Diklat</td>
	    		<td><input class="easyui-textbox" name="nama_diklat" id="nama_diklat" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal mulai</td>
	    		<td><input class="easyui-datebox" name="tanggal_mulai" id="tanggal_mulai" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal selesai</td>
	    		<td><input class="easyui-datebox" name="tanggal_selesai" id="tanggal_selesai" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Nomor Sertifikat</td>
	    		<td><input class="easyui-textbox" name="no_sertifikat" id="no_sertifikat" required></td>
	    	</tr>
	    	<tr>
	    		<td>Jumlah PJL</td>
	    		<td><input class="easyui-textbox" name="jumlah_pjl" id="jumlah_pjl" required></td>
	    	</tr>
	    	<tr>
	    		<td>Penyelenggara</td>
	    		<td><input class="easyui-textbox" name="penyelenggara" id="penyelenggara" required></td>
	    	</tr>
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatDiklat-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="saveRiwayatDiklat()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatDiklat').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form riwayat diklat

<!-- Form riwayat pendidikan -->
<div id="dialogAddRiwayatPendidikan" class="easyui-dialog" style="width:500px;height:auto;padding:10px" closed="true" buttons="#dialogAddRiwayatPendidikan-buttons">
	<form id="formTambahRiwayatPendidikan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_pendidikan_id" id="riwayat_pendidikan_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
	    	<tr>
	    		<td width="30%">Jenjang pendidikan</td>
	    		<td width="70%">
	    			<select class="easyui-combobox" name="tingkat_pendidikan" id="tingkat_pendidikan" data-options="valueField:'id', textField:'text',panelHeight:'auto',onSelect:function(rec){ getNamaPendidikan(rec.id); }"  style="width:150px" required>
	    				<?php
	    				$tingkat_pendidikan = $this->pendidikan_model->getDataTingkatPendidikan();
	    				foreach((array)$tingkat_pendidikan as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Pendidikan</td>
	    		<td>
	    			<input class="easyui-combobox" required name="nama_pendidikan" id="nama_pendidikan" data-options="panelHeight:'200px',valueField:'id', textField:'text'" style="width:250px">
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal lulus</td>
	    		<td><input class="easyui-datebox" name="tanggal_lulus" id="tanggal_lulus" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tahun lulus</td>
	    		<td><input class="easyui-textbox" name="tahun_lulus" id="tahun_lulus" required></td>
	    	</tr>
	    	<tr>
	    		<td>Nomor ijazah</td>
	    		<td><input class="easyui-textbox" name="nomor_ijazah" id="nomor_ijazah" required></td>
	    	</tr>
	    	<tr>
	    		<td>Nama sekolah</td>
	    		<td><input class="easyui-textbox" name="nama_sekolah" id="nama_sekolah" required></td>
	    	</tr>
	    	<tr>
	    		<td>Gelar depan</td>
	    		<td><input class="easyui-textbox" name="gelar_depan" id="gelar_depan"></td>
	    	</tr>
	    	<tr>
	    		<td>Gelar belakang</td>
	    		<td><input class="easyui-textbox" name="gelar_belakang" id="gelar_belakang"></td>
	    	</tr>
	    	<tr>
	    		<td>Status Pendidikan</td>
	    		<td>
	    			<select class="easyui-combobox" name="status_pendidikan" id="status_pendidikan" data-options="valueField:'id', textField:'text',panelHeight:'auto'"  style="width:150px" required>
	    				<?php
	    				$status_pendidikan = $this->pendidikan_model->getStatusPendidikan();
	    				foreach((array)$status_pendidikan as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatPendidikan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="saveRiwayatPendidikan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatPendidikan').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form riwayat pendidikan -->

<!-- Riwayat kursus -->
<div id="dialogAddRiwayatKursus" class="easyui-dialog" style="width:500px;height:auto;padding:10px" closed="true" buttons="#dialogAddRiwayatKursus-buttons">
	<form id="formTambahRiwayatKursus" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_kursus_id" id="riwayat_kursus_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
	    	<tr>
	    		<td width="30%">Instansi</td>
	    		<td width="70%">
	    			<select class="easyui-combobox" name="instansi" id="instansi" data-options="valueField:'id', textField:'text',panelHeight:'200px',onSelect:function(rec){ getNamaPendidikan(rec.id); }"  style="width:300px" required>
	    				<?php
	    				$instansi = get_instansi();
	    				foreach((array)$instansi as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Nama kursus</td>
	    		<td><input class="easyui-textbox" name="nama_kursus" id="nama_kursus" required style="width:300px;"></td>
	    	</tr>
	    	<tr>
	    		<td>Jumlah jam</td>
	    		<td><input class="easyui-textbox" name="jumlah_jam" id="jumlah_jam" required style="width:300px;"></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal kursus</td>
	    		<td><input class="easyui-datebox" name="tanggal_kursus" id="tanggal_kursus" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>	    	
	    	<tr>
	    		<td>Tahun kursus</td>
	    		<td><input class="easyui-textbox" name="tahun_kursus" id="tahun_kursus" required style="width:300px;"></td>
	    	</tr>
	    	<tr>
	    		<td>Institusi penyelenggara</td>
	    		<td><input class="easyui-textbox" name="institusi_penyelenggara" id="institusi_penyelenggara" required style="width:300px;"></td>
	    	</tr>
	    	<tr>
	    		<td>Nomor Sertifikat</td>
	    		<td><input class="easyui-textbox" name="nomor_sertifikat" id="nomor_sertifikat" required style="width:300px;"></td>
	    	</tr>
	    	<tr>
	    		<td>Tipe Kursus</td>
	    		<td>
	    			<select class="easyui-combobox" name="tipe_kursus" id="tipe_kursus" data-options="valueField:'id', textField:'text',panelHeight:'auto'"  style="width:150px" required>
	    				<option value="K">Kursus</option>
	    				<option value="S">Sertifikat</option>
	    			</select>
	    		</td>
	    	</tr>	   
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatKursus-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="saveRiwayatKursus()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatKursus').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End form riwayat kursus -->

<!-- Riwayat Penghargaan -->
<div id="dialogAddRiwayatPenghargaan" class="easyui-dialog" style="width:500px;height:auto;padding:10px" closed="true" buttons="#dialogAddRiwayatPenghargaan-buttons">
	<form id="formTambahRiwayatPenghargaan" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
    	<input type="hidden" name="nip" id="nip" class="nip" value="">
    	<input type="hidden" name="riwayat_penghargaan_id" id="riwayat_penghargaan_id" value="">
    	<table cellpadding="0" cellspacing="2" border="0" width="100%">
	    	<tr>
	    		<td width="30%">Jenis Penghargaan</td>
	    		<td width="70%">
	    			<select class="easyui-combobox" name="instansi" id="instansi" data-options="valueField:'id', textField:'text',panelHeight:'200px',onSelect:function(rec){ getNamaPendidikan(rec.id); }"  style="width:300px" required>
	    				<?php
	    				$instansi = get_instansi();
	    				foreach((array)$instansi as $kode=>$nama):
	    				?>
	    				<option value="<?=$kode?>"><?=$nama?></option>
	    				<?php
	    				endforeach;
	    				?>
	    			</select>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>Nomor SK</td>
	    		<td><input class="easyui-textbox" name="no_sk" id="no_sk" required></td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal SK</td>
	    		<td><input class="easyui-datebox" name="tgl_sk" id="tgl_sk" data-options="formatter:date_format,parser:date_parser" required></td>
	    	</tr>	    	 
    	</table>
    </form>
</div>
<div id="dialogAddRiwayatPenghargaan-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" onclick="saveRiwayatPenghargaan()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddRiwayatPenghargaan').dialog('close')" style="width:90px">Cancel</a>
</div>
<!-- End Riwayat Penghargaan -->