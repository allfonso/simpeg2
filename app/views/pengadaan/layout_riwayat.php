<style>
    .tt-inner{
        display:inline-block !important;
        line-height:12px !important;
        padding-top:15px !important;
    }
    .tt-inner img{
        border:0 !important;
    }
</style>
<div id="dialogRiwayatPegawai" class="easyui-window" style="width:1300px;height:550px" closed="true" data-options="iconCls:'icon-user'" buttons="#dialogRiwayatPegawai-buttons">
	<div class="easyui-tabs" style="width:100%;height:auto;" data-options="tabPosition:'left'">
		<div title="Data Pegawai" style="height:200px;padding:10px;">
			<?php $this->load->view('pegawai/layout_detail_pegawai'); ?>
		</div>
		<div title="Riwayat Golongan" style="padding:10px">
			<table id="gridDataGolongan" style="width:100%">
				<thead>
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
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div title="Riwayat Jabatan" style="padding:10px">
			<table id="gridDataJabatan" style="width:100%">
				<thead>
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
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div title="Riwayat Diklat" style="padding:10px">
			<table id="gridDataDiklat" style="width:100%">
				<thead>
					<th field="JENIS_DIKLAT" width="">Jenis Diklat</th>
					<th field="DIKLAT_STRUKTURAL" width="">Jenis Diklat Struktural</th>
					<th field="NAMA_DIKLAT" width="">Nama Diklat</th>
					<th field="TANGGAL_MULAI" width="">Tanggal Mulai</th>
					<th field="TANGGAL_SELESAI" width="">Tanggal Selesai</th>
					<th field="NOMOR_SERTIFIKAT" width="">No. Sertifikat</th>
					<th field="JUMLAH_PJL" width="">Jumlah PJL</th>
					<th field="PENYELENGGARA" width="">Penyelenggara</th>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div title="Riwayat Pendidikan" style="padding:10px">
			<table id="gridDataPendidikan" style="width:100%">
				<thead>
					<th field="JENJANG" width="">Jenjang</th>
					<th field="PENDIDIKAN" width="">Nama Pendidikan</th>
					<th field="TANGGAL_LULUS" width="">Tanggal Lulus</th>
					<th field="TAHUN_LULUS" width="">Tahun Lulus</th>
					<th field="NOMOR_IJAZAH" width="">Nomor Ijazah</th>
					<th field="NAMA_SEKOLAH" width="">Nama Sekolah</th>
					<th field="GELAR_DEPAN" width="">Gelar Depan</th>
					<th field="GELAR_BELAKANG" width="">Gelar Belakang</th>
					<th field="STATUS_PENDIDIKAN" width="">Status Pendidikan</th>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div title="Riwayat Keluarga" style="padding:10px">
			Keluarga
		</div>
		<div title="Riwayat Kursus" style="padding:10px">
			Kursus
		</div>
		<div title="Riwayat Penghargaan" style="padding:10px">
			Penghargaan
		</div>
		<div title="Riwayat DP3" style="padding:10px">
			DP3
		</div>
		<div title="Riwayat Angka Kredit" style="padding:10px">
			Angka Kredit
		</div>
		<div title="Riwayat Hukuman" style="padding:10px">
			Hukuman
		</div>
	</div>
</div>

<script>
var url_detail = '<?=site_url('pegawai/get_detail_pegawai')?>';
function riwayatPegawai()
{
	var row = $('#gridPegawai').datagrid('getSelected');
	if( !row ){
		error('Error!','Silahkan pilih pegawai');
	}else{
		var nip = row.NIP;
		$.ajax({
			url:url_detail,
			type:'post',
			data:{nip:nip},
			dataType:'json',
			success: function(response){
				if( response['status'] == 1 )
				{
					$('span#nip').html(response['data']['profil']['NIP_LAMA']+' / '+response['data']['profil']['NIP']);
					$('span#namaPegawai').html(response['data']['profil']['NAMA']);
					$('span#jabatanTerakhir').html(response['data']['profil']['JABATAN']);
					$('span#jabatanStruktural').html(response['data']['profil']['JABATAN_STRUKTURAL']+' / '+response['data']['profil']['TMT_JABATAN_STRUKTURAL']);
					$('span#jabatanFungsional').html(response['data']['profil']['JABATAN_FUNGSIONAL']+' / '+response['data']['profil']['TMT_JABATAN_FUNGSIONAL']);
					$('span#tmtCpnsPns').html(response['data']['profil']['TMT_CPNS']+' / '+response['data']['profil']['TMT_PNS']);
					$('span#tempatTanggalLahir').html(response['data']['profil']['TEMPAT_TANGGAL_LAHIR']);
					$('span#jenisKelamin').html(response['data']['profil']['JENIS_KELAMIN']);
					$('span#agama').html(response['data']['profil']['AGAMA']);
					$('span#statusPerkawinan').html(response['data']['profil']['NAMA']);
					$('span#unitKerja').html('');
					$('span#instansiInduk').html(response['data']['profil']['INSTANSI']);
					$('span#alamatRumah').html(response['data']['profil']['ALAMAT']);
					$('span#golongan').html(response['data']['profil']['GOLONGAN']);

					// Load data riwayat golongan
					$('#gridDataGolongan').datagrid('loadData',response['data']['riwayat_golongan']);
					$('#gridDataJabatan').datagrid('loadData',response['data']['riwayat_jabatan']);
					$('#gridDataDiklat').datagrid('loadData',response['data']['riwayat_diklat']);
					$('#gridDataPendidikan').datagrid('loadData',response['data']['riwayat_pendidikan']);

				}else{
					error('Error!','Gagal ambil data detail pegawai. Silahkan ulangi');
				}
			},
			error: function(){
				error('Error!','Terjadi kesalahan saat memuat data. Silahkan hubungi administrator');
			}

		});
		$('#dialogRiwayatPegawai').dialog('open').dialog('setTitle','Riwayat pegawai');
	}
}

$(document).ready(function(){
	$('#gridDataPokok, #gridDataGolongan, #gridDataJabatan, #gridDataDiklat, #gridDataPendidikan').datagrid({
		singleSelect: true
	});
});

</script>