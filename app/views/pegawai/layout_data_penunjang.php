<div class="easyui-tabs" style="width:100%;height:auto;" data-options="tabWidth:100,tabHeight:80" id="tabsriwayat">

	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-jabatan.png'/><br>Jabatan</span>" style="padding-top:1px">
		<table id="gridDataJabatan" style="width:100%">
			<thead>
			<tr>
				<th field="ID" width="">ID</th>
				<th field="INSTANSI" width="">Instansi</th>
				<th field="UNIT" width="">Unit</th>
				<th field="SUBUNIT" width="">Sub Unit</th>
				<th field="JENIS_JABATAN" width="">Jenis Jabatan</th>
				<th field="JABATAN" width="">Jabatan</th>
				<th field="ESELON" width="">Eselon</th>
				<th field="TMT_JABATAN" width="">TMT Jabatan</th>
				<th field="NOMOR_SK" width="">Nomor SK</th>
				<th field="TANGGAL_SK" width="">Tanggal SK</th>
				<th field="TMT_PELANTIKAN" width="">TMT Pelantikan</th>
				<th field="PENETAP" width="">Pejabat Penetap</th>
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-golongan.png'/><br>Golongan</span>" style="padding-top:1px">
		<table id="gridDataGolongan" style="width:100%">
			<thead>
				<tr>
				<th field="ID" width="">ID</th>
				<th field="JENIS_KP" width="">Jenis KP</th>
				<th field="GOLONGAN" width="">Golongan</th>
				<th field="NOMOR_SK" width="">Nomor SK</th>
				<th field="TANGGAL_SK" width="">Tanggal SK</th>
				<th field="NOMOR_BKN" width="">Nomor BKN</th>
				<th field="TANGGAL_BKN" width="">Tanggal BKN</th>
				<th field="TMT_GOLONGAN" width="">TMT Golongan</th>
				<th field="MASA_KERJA_TAHUN" width="">Masa Kerja Tahun</th>
				<th field="MASA_KERJA_BULAN" width="">Masa Kerja Bulan</th>
				<th field="ANGKA_KREDIT_UTAMA" width="">Angka Kredit Utama</th>
				<th field="ANGKA_KREDIT_TAMBAHAN" width="">Angka Kredit Tambahan</th>
				<th field="PENETAP" width="">Pejabat Penetap</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>		
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-diklat.png'/><br>Diklat</span>" style="padding-top:1px">
		<table id="gridDataDiklat" style="width:100%">
			<thead>
				<tr>
				<th field="ID" width="">ID</th>
				<th field="JENIS_DIKLAT" width="">Jenis Diklat</th>
				<th field="DIKLAT_STRUKTURAL" width="">Jenis Diklat Struktural</th>
				<th field="NAMA_DIKLAT" width="">Nama Diklat</th>
				<th field="TANGGAL_MULAI" width="">Tanggal Mulai</th>
				<th field="TANGGAL_SELESAI" width="">Tanggal Selesai</th>
				<th field="NOMOR_SERTIFIKAT" width="">No. Sertifikat</th>
				<th field="JUMLAH_PJL" width="">Jumlah PJL</th>
				<th field="PENYELENGGARA" width="">Penyelenggara</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-pendidikan.png'/><br>Pendidikan</span>" style="padding-top:1px">
		<table id="gridDataPendidikan" style="width:100%">
			<thead>
				<tr>
				<th field="ID" width="">ID</th>
				<th field="JENJANG" width="">Jenjang</th>
				<th field="PENDIDIKAN" width="">Nama Pendidikan</th>
				<th field="TANGGAL_LULUS" width="">Tanggal Lulus</th>
				<th field="TAHUN_LULUS" width="">Tahun Lulus</th>
				<th field="NOMOR_IJAZAH" width="">Nomor Ijazah</th>
				<th field="NAMA_SEKOLAH" width="">Nama Sekolah</th>
				<th field="GELAR_DEPAN" width="">Gelar Depan</th>
				<th field="GELAR_BELAKANG" width="">Gelar Belakang</th>
				<th field="STATUS_PENDIDIKAN" width="">Status Pendidikan</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-keluarga.png'/><br>Keluarga</span>" style="padding:10px">
		Keluarga
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-kursus.png'/><br>Kursus</span>" style="padding:1px">
		<table id="gridDataKursus" style="width:100%">
			<thead>
				<tr>
				<th field="ID" width="">ID</th>
				<th field="NAMA_KURSUS" width="">Nama Kursus</th>
				<th field="INSTANSI_NAMA" width="">Instansi</th>
				<th field="TANGGAL_KURSUS" width="">Tanggal Kursus</th>
				<th field="TAHUN_KURSUS" width="">Tahun Kursus</th>
				<th field="JUMLAH_JAM" width="">Jumlah Jam</th>
				<th field="INSTITUSI_PENYELENGGARA" width="">Penyelenggara</th>
				<th field="TIPE_KURSUS" width="">Tipe Kursus</th>
				<th field="NOMOR_SERTIFIKAT" width="">Nomor Sertifikat</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-penghargaan.png'/><br>Penghargaan</span>" style="padding:1px">
		<table id="gridDataPenghargaan" style="width:100%">
			<thead>
				<tr>
				<th field="RIWAYAT_PENGHARGAAN_ID" width="">ID</th>
				<th field="NAMA_PENGHARGAAN" width="">NAMA PENGHARGAAN</th>
				<th field="NOMOR_SK" width="">NOMOR SK</th>
				<th field="TANGGAL_SK" width="">TANGGAL SK</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-dp3.png'/><br>DP3</span>" style="padding:1px">
		<table id="gridDataDP3" style="width:100%">
			<thead>
			<tr>
				<th field="JABATAN_NAMA" width="">NAMA JABATAN</th>
				<th field="TAHUN" width="">TAHUN</th>
				<th field="KESETIAAN" width="">KESETIAAN</th>
				<th field="PRESTASI_KERJA" width="">PRESTASI KERJA</th>
				<th field="TANGGUNG_JAWAB" width="">TANGGUNG JAWAB</th>
				<th field="KETAATAN" width="">KETAATAN</th>
				<th field="KEJUJURAN" width="">KEJUJURAN</th>
				<th field="KERJASAMA" width="">KERJASAMA</th>
				<th field="PRAKARSA" width="">PRAKARSA</th>
				<th field="KEPEMIMPINAN" width="">KEPEMIMPINAN</th>
				<th field="JUMLAH" width="">JUMLAH</th>
				<th field="NILAI_RATA_RATA" width="">NILAI RATA RATA</th>
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-angka-kredit.png'/><br>Angka Kredit</span>" style="padding:1px">
		<table id="gridDataAngkaKredit" style="width:100%">
			<thead>
			<tr>
				<th field="ANGKA_KREDIT_PERTAMA" width="">ANGKA KREDIT PERTAMA</th>
				<th field="NAMA_JENJANG_JABATAN" width="">JENJANG JABATAN</th>
				<th field="NOMOR_SK" width="">NOMOR SK</th>
				<th field="TANGGAL_SK" width="">TANGGAL SK</th>
				<th field="BULAN_MULAI_PENILAIAN" width="">BULAN MULAI PENILAIAN</th>
				<th field="TAHUN_MULAI_PENILAIAN" width="">TAHUN MULAI PENILAIAN</th>
				<th field="BULAN_SELESAI_PENILAIAN" width="">BULAN SELESAI PENILAIAN</th>
				<th field="TAHUN_SELESAI_PENILAIAN" width="">TAHUN SELESAI PENILAIAN</th>
				<th field="KREDIT_UTAMA_BARU" width="">KREDIT UTAMABARU</th>
				<th field="KREDIT_PENUNJANG_BARU" width="">KREDIT PENUNJANG BARU</th>
				<th field="KREDIT_BARU_TOTAL" width="">KREDIT BARU TOTAL</th>
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

	</div>
	<div title="<span class='tt-inner'><img src='<?=ASSET_URL?>icons/icon-hukuman.png'/><br>Hukuman</span>" style="padding:1px">
		<table id="gridDataHukuman" style="width:100%">
			<thead>
				<tr>
				<th field="RIWAYAT_HUKUMAN_ID" width="">ID</th>
				<th field="NOMOR_SK" width="">NOMOR SK</th>
				<th field="TANGGAL_SK" width="">TANGGAL SK</th>
				<th field="TANGGAL_MULAI_HUKUM" width="">TANGGAL MULAI HUKUMAN</th>
				<th field="TANGGAL_AKHIR_HUKUM" width="">TANGGAL AKHIR HUKUMAN</th>
				<th field="MASA_TAHUN" width="">MASA TAHUN</th>
				<th field="MASA_BULAN" width="">MASA BULAN</th>
				<th field="NOMOR_PP" width="">NOMOR PP</th>
				<th field="GOLONGAN" width="">GOLONGAN</th>
				<th field="NOMOR_SK_BATAL" width="">NOMOR SK BATAL</th>
				<th field="TANGGAL_SK_BATAL" width="">TANGGAL SK BATAL</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>

