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
<div id="dialogDetailPegawai" class="easyui-window" style="width:1300px;height:550px" closed="true" modal="true" data-options="iconCls:'icon-user'" buttons="#dialogDetailPegawai-buttons">
	<div class="easyui-layout" data-options="fit:true,height:'200px'">
	<div data-options="region:'west',split:false" style="width:160px">
	<div id="pegawaiImage"></div>
	</div>
	<div data-options="region:'center'">
	<input type="hidden" name="current_nip" id="current_nip" value="" />
	<table id="gridDataPokok" style="width:100%">
	<thead>
	<th field="nip" width="20%">&nbsp;</th>
	<th field="nama" width="60%">&nbsp;</th>
	</thead>
	<tbody>	
	<tr>
	<td>Nama pegawai</td>
	<td><span id="namaPegawai"></span></td>
	</tr>
	<tr>
	<td>NIP Lama / NIP Baru</td>
	<td><span id="nip"></span></td>
	</tr>
	<tr>
	<td>Golongan</td>
	<td><span id="golongan"></span></td>
	</tr>	
	<tr>
	<td>Instansi induk</td>
	<td><span id="instansiInduk"></span></td>
	</tr>
	<tr>
	<td>Unit</td>
	<td><span id="unit"></span></td>
	</tr>
	<tr>
	<td>Sub Unit</td>
	<td><span id="subunit"></span></td>
	</tr>
	</tbody>
	</table>
	</div>
	<div data-options="region:'south'" style="min-height:330px;">
	<?php $this->load->view('pegawai/layout_data_penunjang'); ?>
	</div>
	</div>
</div>

<script>
var url_detail = '<?=site_url('pegawai/get_detail_pegawai')?>';
var photo_url = '<?=_URL?>files/pegawai/';
var nip = $('#current_nip').val();

$('#tabsriwayat').tabs({
	onSelect: function(title,index){
	switch( parseInt(index) ){
	case 0:

	break;

	case 1:
	var nip = $('#current_nip').val();
	loadRiwayatGolongan(nip);
	break;

	case 2:
	var nip = $('#current_nip').val();
	loadRiwayatDiklat(nip);
	break;

	case 3:
	var nip = $('#current_nip').val();
	loadRiwayatPendidikan(nip);
	break;

	case 4:
	
	break;

	case 5:
	var nip = $('#current_nip').val();
	loadRiwayatKursus(nip);
	break;

	case 6:
	var nip = $('#current_nip').val();
	loadRiwayatPenghargaan(nip);
	break;

	case 7:
	var nip = $('#current_nip').val();
	loadRiwayatDP3(nip);
	break;

	case 8:
	var nip = $('#current_nip').val();
	loadRiwayatAngkaKredit(nip);
	break

	case 9:
	var nip = $('#current_nip').val();
	loadRiwayatHukuman(nip);
	break;

	default:
	alert(index+'nya');
	break;
	}
	}
});	


$(document).ready(function(){
	$('#gridDataPokok, #gridDataGolongan, #gridDataDiklat, #gridDataPendidikan, #gridDataKursus, #gridDataPenghargaan, #gridDataHukuman, #gridDataDP3, #gridDataAngkaKredit ').datagrid({
	singleSelect: true
	});


	$('#gridDataJabatan').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Jabatan',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatJabatan();
                }
            },'-',{
                text:'Edit Data Jabatan',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatJabatan();
                }
            },'-',{
                text:'Hapus Data Jabatan',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatJabatan();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatJabatan(nip);
                }
            }]
	});

	$('#gridDataGolongan').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Golongan',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatGolongan();
                }
            },'-',{
                text:'Edit Data Golongan',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatGolongan();
                }
            },'-',{
                text:'Hapus Data Golongan',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatGolongan();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatGolongan(nip);
                }
            }]
	});

	$('#gridDataDiklat').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Diklat',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatDiklat();
                }
            },'-',{
                text:'Edit Data Diklat',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatDiklat();
                }
            },'-',{
                text:'Hapus Data Diklat',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatDiklat();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatDiklat(nip);
                }
            }]
	});

	$('#gridDataPendidikan').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Pendidikan',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatPendidikan();
                }
            },'-',{
                text:'Edit Data Pendidikan',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatPendidikan();
                }
            },'-',{
                text:'Hapus Data Pendidikan',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatPendidikan();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatPendidikan(nip);
                }
            }]
	});

	$('#gridDataKursus').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Kursus',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatKursus();
                }
            },'-',{
                text:'Edit Data Kursus',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatKursus();
                }
            },'-',{
                text:'Hapus Data Kursus',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatKursus();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatKursus(nip);
                }
            }]
	});

	$('#gridDataPenghargaan').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Penghargaan',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatPenghargaan();
                }
            },'-',{
                text:'Edit Data Penghargaan',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatPenghargaan();
                }
            },'-',{
                text:'Hapus Data Penghargaan',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatPenghargaan();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    $('#gridDataPenghargaan').datagrid('reload');
                }
            }]
	});

	$('#gridDataHukuman').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Hukuman',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatHukuman();
                }
            },'-',{
                text:'Edit Data Hukuman',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatHukuman();
                }
            },'-',{
                text:'Hapus Data Hukuman',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatHukuman();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatHukuman(nip);
                }
            }]
	});

	$('#gridDataDP3').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data DP3',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatDP3();
                }
            },'-',{
                text:'Edit Data DP3',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatDP3();
                }
            },'-',{
                text:'Hapus Data DP3',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatDP3();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatDP3(nip);
                }
            }]
	});

	$('#gridDataAngkaKredit').datagrid({
	singleSelect: true,
	toolbar:[
	{
                text:'Input Data Angka Kredit',
                iconCls:'icon-add',
                handler:function(){
                   addRiwayatAngkaKredit();
                }
            },'-',{
                text:'Edit Data Angka Kredit',
                iconCls:'icon-edit',
                handler:function(){
                   editRiwayatAngkaKredit();
                }
            },'-',{
                text:'Hapus Data Angka Kredit',
                iconCls:'icon-remove',
                handler:function(){
                    deleteRiwayatAngkaKredit();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadRiwayatAngkaKredit(nip);
                }
            }]
	});
});

function detailPegawai()
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
	var nip = response['data']['profil']['NIP'];
	$('#current_nip').val(response['data']['profil']['NIP']);
	$('.nip').val(response['data']['profil']['NIP']);
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
	$('#pegawaiImage').html('<img src="'+photo_url+response['data']['profil']['PHOTO']+'" style="padding:10px;width:135px;" />');

	// Load data jabatan
	loadRiwayatJabatan(nip);


	}else{
	error('Error!','Gagal ambil data detail pegawai. Silahkan ulangi');
	}
	$.messager.progress('close');
	},
	error: function(){
	error('Error!','Terjadi kesalahan saat memuat data. Silahkan hubungi administrator');
	}

	});
	$('#dialogDetailPegawai').dialog('open').dialog('setTitle','Detail pegawai');
	}
}

function getUnit(rec){
	$('#unit_id').combobox('reload', '<?=site_url('referensi/load_unor_unit')?>/'+rec);
}
function getSubUnit(rec){
	$('#subunit_id').combobox('reload', '<?=site_url('referensi/load_unor_unit')?>/'+rec);
}


// ========== Riwayat Jabatan
function loadRiwayatJabatan(nip)
{
	var url = "<?=site_url('riwayat_jabatan/load_data_riwayat_jabatan')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataJabatan').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataJabatan').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function addRiwayatJabatan()
{
	$('#formTambahRiwayatJabatan').form('clear');
	$('#dialogAddRiwayatJabatan').dialog('open').dialog('setTitle','Tambah data riwayat jabatan');
}

function saveRiwayatJabatan()
{
	$('#formTambahRiwayatJabatan').form('submit',{
	url: '<?php echo site_url('riwayat_jabatan/save_riwayat_jabatan'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatJabatan').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
	loadRiwayatJabatan(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function deleteRiwayatJabatan()
{
	var row = $('#gridDataJabatan').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_jabatan/delete_riwayat_jabatan')?>',{id:row.ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	loadRiwayatJabatan(nip);
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatJabatan()
{
	var row = $('#gridDataJabatan').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	var url = "<?=site_url('riwayat_jabatan/load_detail_riwayat_jabatan')?>";
	$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{id:row.ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){
	           	$('#riwayat_jabatan_id').val( response['data']['RIWAYAT_JABATAN_ID'] );
	           	$('#dialogAddRiwayatJabatan').dialog('open').dialog('setTitle','Ubah data riwayat jabatan');
	           	getUnit(response['data']['UNOR_ID']);
	           	getSubUnit(response['data']['UNIT_ID']);
	           	$('#unor_id').combobox('setValue',response['data']['UNOR_ID']);
	           	$('#unit_id').combobox('setValue',response['data']['UNIT_ID']);
	           	$('#subunit_id').combobox('setValue',response['data']['SUBUNIT_ID']);
	           	$('#jabatan_id').combobox('setValue',response['data']['JENIS_JABATAN_ID']);
	           	$('#jenjang_jabatan_id').combobox('setValue',response['data']['JENJANG_JABATAN_ID']);
	           	$('#eselon_id').combobox('setValue',response['data']['ESELON_ID']);
	           	$('#tmt_jabatan').datebox('setValue',response['data']['TMT_JABATAN']);
	           	$('#no_sk').textbox('setValue',response['data']['NOMOR_SK']);
	           	$('#tgl_sk').textbox('setValue',response['data']['TANGGAL_SK']);
	           	$('#tmt_pelantikan').datebox('setValue',response['data']['TMT_PELANTIKAN']);
	           	$('#penetap_id').combobox('setValue',response['data']['PENETAP_ID']);
	           }
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}
// ========== End Riwayat JAbatan

// ========== Riwayat Golongan
function loadRiwayatGolongan(nip)
{
	var url = "<?=site_url('riwayat_golongan/load_data_riwayat_golongan')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataGolongan').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataGolongan').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function addRiwayatGolongan()
{
	$('#formTambahRiwayatGolongan').form('clear');
	$('#dialogAddRiwayatGolongan').dialog('open').dialog('setTitle','Tambah data riwayat golongan');
}

function saveRiwayatGolongan()
{
	$('#formTambahRiwayatGolongan').form('submit',{
	url: '<?php echo site_url('riwayat_golongan/save_riwayat_golongan'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatGolongan').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
	loadRiwayatGolongan(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function editRiwayatGolongan()
{
	var row = $('#gridDataGolongan').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	var url = "<?=site_url('riwayat_golongan/load_detail_riwayat_golongan')?>";
	$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{id:row.ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){
	           	$('#riwayat_golongan_id').val( response['data']['RIWAYAT_GOLONGAN_ID'] );
	           	$('#kode_jenis_kp').textbox('setValue',response['data']['KODE_JENIS_KP']);
	           	$('#golongan_id').combobox('setValue',response['data']['GOLONGAN_ID']);
	           	$('#no_sk_gol').textbox('setValue',response['data']['NOMOR_SK']);
	           	$('#tgl_sk_gol').datebox('setValue',response['data']['TANGGAL_SK']);
	           	$('#no_bkn').textbox('setValue',response['data']['NOMOR_BKN']);
	           	$('#tgl_bkn').datebox('setValue',response['data']['TANGGAL_BKN']);
	           	$('#tmt_golongan').datebox('setValue',response['data']['TMT_GOLONGAN']);
	           	$('#masa_kerja_tahun').textbox('setValue',response['data']['MASA_KERJA_TAHUN']);
	           	$('#masa_kerja_bulan').textbox('setValue',response['data']['MASA_KERJA_BULAN']);
	           	$('#angka_kredit_utama').textbox('setValue',response['data']['ANGKA_KREDIT_UTAMA']);
	           	$('#angka_kredit_tambahan').textbox('setValue',response['data']['ANGKA_KREDIT_TAMBAHAN']);
	           	$('#penetap_id').combobox('setValue',response['data']['PENETAP_ID']);
	           	$('#dialogAddRiwayatGolongan').dialog('open').dialog('setTitle','Ubah data riwayat golongan');
	           }
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

function deleteRiwayatGolongan()
{
	var row = $('#gridDataGolongan').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_golongan/delete_riwayat_golongan')?>',{id:row.ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	loadRiwayatGolongan(nip);
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}
//========== End riwayat golongan

//========== Riwayat diklat
function addRiwayatDiklat()
{
	$('#formTambahRiwayatDiklat').form('clear');
	$('#dialogAddRiwayatDiklat').dialog('open').dialog('setTitle','Tambah data riwayat diklat');
}

function loadRiwayatDiklat(nip)
{
	var url = "<?=site_url('riwayat_diklat/load_data_riwayat_diklat')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataDiklat').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataDiklat').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function editRiwayatDiklat()
{
	var row = $('#gridDataDiklat').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	var url = "<?=site_url('riwayat_diklat/load_detail_riwayat_diklat')?>";
	$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{id:row.ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){
	           	$('#riwayat_diklat_id').val( response['data']['RIWAYAT_DIKLAT_ID'] );
	           	$('#jenis_diklat').combobox('setValue',response['data']['JENIS_DIKLAT']);
	           	$('#diklat_struktural').combobox('setValue',response['data']['DIKLAT_STRUKTURAL']);
	           	$('#nama_diklat').textbox('setValue',response['data']['NAMA_DIKLAT']);
	           	$('#tanggal_mulai').datebox('setValue',response['data']['TANGGAL_MULAI']);
	           	$('#tanggal_selesai').datebox('setValue',response['data']['TANGGAL_SELESAI']);
	           	$('#nomor_sertifikat').textbox('setValue',response['data']['NOMOR_SERTIFIKAT']);
	           	$('#jumlah_pjl').textbox('setValue',response['data']['JUMLAH_PJL']);
	           	$('#penyelengara').textbox('setValue',response['data']['PENYELENGGARA']);
	           	
	           	$('#dialogAddRiwayatDiklat').dialog('open').dialog('setTitle','Ubah data riwayat diklat');
	           	}
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

function saveRiwayatDiklat()
{
	$('#formTambahRiwayatDiklat').form('submit',{
	url: '<?php echo site_url('riwayat_diklat/save_riwayat_diklat'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatDiklat').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
	loadRiwayatDiklat(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function deleteRiwayatDiklat()
{
	var row = $('#gridDataDiklat').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_diklat/delete_riwayat_diklat')?>',{id:row.ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	loadRiwayatDiklat(nip);
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

//========== End riwayat diklat


//========= Riwayat Pendidikan
function getNamaPendidikan(rec){
	$('#nama_pendidikan').combobox('reload', '<?=site_url('referensi/load_data_pendidikan')?>/'+rec);
}

function loadRiwayatPendidikan(nip)
{
	var url = "<?=site_url('riwayat_pendidikan/load_data_riwayat_pendidikan')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataPendidikan').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataPendidikan').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function addRiwayatPendidikan()
{
	   $('#formTambahRiwayatPendidikan').form('clear');
    $('#dialogAddRiwayatPendidikan').dialog('open').dialog('setTitle','Tambah data riwayat pendidikan');
}

function saveRiwayatPendidikan()
{
	$('#formTambahRiwayatPendidikan').form('submit',{
	url: '<?php echo site_url('riwayat_pendidikan/save_riwayat_pendidikan'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatPendidikan').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
	loadRiwayatPendidikan(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function deleteRiwayatPendidikan()
{
	var row = $('#gridDataPendidikan').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_pendidikan/delete_riwayat_pendidikan')?>',{id:row.ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	loadRiwayatPendidikan(nip);
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatPendidikan()
{
	var row = $('#gridDataPendidikan').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	var url = "<?=site_url('riwayat_pendidikan/load_detail_riwayat_pendidikan')?>";
	$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{id:row.ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){
	           	getNamaPendidikan( response['data']['TINGKAT_PENDIDIKAN_ID'] );
	           	$('#riwayat_pendidikan_id').val( response['data']['RIWAYAT_PENDIDIKAN_ID'] );
	           	$('#tingkat_pendidikan').combobox('setValue',response['data']['TINGKAT_PENDIDIKAN_ID']);
	$('#nama_pendidikan').combobox('setValue',response['data']['PENDIDIKAN_ID']);
	$('#tanggal_lulus').datebox('setValue',response['data']['TANGGAL_LULUS']);
	$('#tahun_lulus').textbox('setValue',response['data']['TAHUN_LULUS']);
	$('#nomor_ijazah').textbox('setValue',response['data']['NOMOR_IJAZAH']);
	$('#nama_sekolah').textbox('setValue',response['data']['NAMA_SEKOLAH']);
	$('#gelar_depan').textbox('setValue',response['data']['GELAR_DEPAN']);
	$('#gelar_belakang').textbox('setValue',response['data']['GELAR_BELAKANG']);
	$('#status_pendidikan').combobox('setValue',response['data']['STATUS_PENDIDIKAN']);	           	
	           	$('#dialogAddRiwayatPendidikan').dialog('open').dialog('setTitle','Ubah data riwayat diklat');
	           	}
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

//========= End Riwayat Pendidikan


//========= Riwayat Kursus
function addRiwayatKursus(){
    $('#formTambahRiwayatKursus').form('clear');
	$('#dialogAddRiwayatKursus').dialog('open').dialog('setTitle','Tambah data riwayat kursus');
}

function saveRiwayatKursus()
{
	$('#formTambahRiwayatKursus').form('submit',{
	url: '<?php echo site_url('riwayat_kursus/save_riwayat_kursus'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatKursus').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
	loadRiwayatKursus(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function loadRiwayatKursus(nip)
{
	var url = "<?=site_url('riwayat_kursus/load_data_riwayat_kursus')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataKursus').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataKursus').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function deleteRiwayatKursus()
{
	var row = $('#gridDataKursus').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_kursus/delete_riwayat_kursus')?>',{id:row.ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	loadRiwayatKursus(nip);
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatKursus()
{
	var row = $('#gridDataKursus').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	var url = "<?=site_url('riwayat_kursus/load_detail_riwayat_kursus')?>";
	$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{id:row.ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){	           	         	
	           	$('#dialogAddRiwayatKursus').dialog('open').dialog('setTitle','Ubah data riwayat diklat');

	           	$('#riwayat_kursus_id').val( response['data']['RIWAYAT_KURSUS_ID'] );
	           	$('#instansi').combobox('setValue',response['data']['INSTANSI_ID']);
	$('#nama_kursus').textbox('setValue',response['data']['NAMA_KURSUS']);
	$('#jumlah_jam').textbox('setValue',response['data']['JUMLAH_JAM']);
	$('#tanggal_kursus').datebox('setValue',response['data']['TGL_KURSUS']);
	$('#tahun_kursus').textbox('setValue',response['data']['TAHUN_KURSUS']);
	$('#institusi_penyelenggara').textbox('setValue',response['data']['INSTITUSI_PENYELENGGARA']);
	$('#nomor_sertifikat').textbox('setValue',response['data']['NOMOR_SERTIFIKAT']);
	$('#tipe_kursus').combobox('setValue',response['data']['TIPE_KURSUS']);
	           	}
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

//========= End Riwayat Kursus


//========= Riwayat Hukuman
function addRiwayatHukuman(){
    $('#formTambahRiwayatHukuman').form('clear');
	$('#dialogAddRiwayatHukuman').dialog('open').dialog('setTitle','Tambah data riwayat hukuman');
}

function saveRiwayatHukuman()
{
	$('#formTambahRiwayatHukuman').form('submit',{
	url: '<?php echo site_url('riwayat_hukuman/save_riwayat_hukuman'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatHukuman').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
                loadRiwayatHukuman(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function loadRiwayatHukuman(nip)
{
	var url = "<?=site_url('riwayat_hukuman/load_data_riwayat_hukuman')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataHukuman').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataHukuman').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function deleteRiwayatHukuman()
{
	var row = $('#gridDataHukuman').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_hukuman/delete_riwayat_hukuman')?>',{id:row.RIWAYAT_HUKUMAN_ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	$('#gridDataHukuman').datagrid('reload');
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatHukuman()
{
	var row = $('#gridDataHukuman').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	$('#riwayat_hukuman_id').val(row.RIWAYAT_HUKUMAN_ID);
	$('#jenis_hukuman_id').combobox('setValue',row.JENIS_HUKUMAN_ID);
	$('#no_sk').textbox('setValue',row.NOMOR_SK);
	$('#tgl_sk').datebox('setValue',row.TANGGAL_SK_EDIT);
	$('#tanggal_mulai_hukuman').datebox('setValue',row.TANGGAL_MULAI_HUKUM_EDIT);
	$('#tanggal_akhir_hukuman').datebox('setValue',row.TANGGAL_AKHIR_HUKUM_EDIT);
	$('#masa_tahun').textbox('setValue',row.MASA_TAHUN);
	$('#masa_bulan').textbox('setValue',row.MASA_BULAN);
	$('#nomor_pp').textbox('setValue',row.NOMOR_PP);
	$('#golongan_id').combobox('setValue',row.GOLONGAN_ID);
	$('#no_sk_batal').textbox('setValue',row.NOMOR_SK_BATAL);
	$('#tgl_sk_batal').datebox('setValue',row.TANGGAL_SK_BATAL_EDIT);	
	$('#dialogAddRiwayatHukuman').dialog('open').dialog('setTitle','Ubah data riwayat diklat');
	}
}

//========= End Riwayat Hukuman

//========= Riwayat Penghargaan
function addRiwayatPenghargaan(){
    $('#formTambahRiwayatPenghargaan').form('clear');
	$('#dialogAddRiwayatPenghargaan').dialog('open').dialog('setTitle','Tambah data riwayat penghargaan');
}

function saveRiwayatPenghargaan()
{
	$('#formTambahRiwayatPenghargaan').form('submit',{
	url: '<?php echo site_url('riwayat_penghargaan/save_riwayat_penghargaan'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatPenghargaan').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
                loadRiwayatPenghargaan(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function loadRiwayatPenghargaan(nip)
{
	var url = "<?=site_url('riwayat_penghargaan/load_data_riwayat_penghargaan')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataPenghargaan').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataPenghargaan').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function deleteRiwayatPenghargaan()
{
	var row = $('#gridDataPenghargaan').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_penghargaan/delete_riwayat_penghargaan')?>',{id:row.RIWAYAT_PENGHARGAAN_ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	$('#gridDataPenghargaan').datagrid('reload');
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatPenghargaan()
{
	var row = $('#gridDataPenghargaan').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	$('#dialogAddRiwayatPenghargaan').dialog('open').dialog('setTitle','Ubah data riwayat penghargaan');
	$('#riwayat_penghargaan_id').val(row.RIWAYAT_PENGHARGAAN_ID);
	$('#jenis_penghargaan_id').combobox('setValue',row.PENGHARGAAN_ID);
	$('#penghargaan_no_sk').textbox('setValue',row.NOMOR_SK);
	$('#penghargaan_tgl_sk').datebox('setValue',row.TANGGAL_SK);
	$('#gridDataPenghargaan').datagrid('reload');	
	}
}

//========= End Riwayat Penghargaan

//========= Riwayat DP3
function addRiwayatDP3(){
    $('#formTambahRiwayatDP3').form('clear');
	$('#dialogAddRiwayatDP3').dialog('open').dialog('setTitle','Tambah data riwayat DP3');
}

function saveRiwayatDP3()
{
	$('#formTambahRiwayatDP3').form('submit',{
	url: '<?php echo site_url('riwayat_dp3/save_riwayat_dp3'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatDP3').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
                loadRiwayatDP3(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function loadRiwayatDP3(nip)
{
	var url = "<?=site_url('riwayat_DP3/load_data_riwayat_dp3')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataDP3').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataDP3').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function deleteRiwayatDP3()
{
	var row = $('#gridDataDP3').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_DP3/delete_riwayat_dp3')?>',{id:row.RIWAYAT_DP3_ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	$('#gridDataDP3').datagrid('reload');
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatDP3()
{
	var row = $('#gridDataDP3').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	$('#riwayat_dp3_id').val(row.RIWAYAT_DP3_ID);
	$('#dialogAddRiwayatDP3').dialog('open').dialog('setTitle','Ubah data riwayat DP3');
	$('#JENIS_JABATAN_ID').combobox('setValue',row.JENIS_JABATAN_ID);
	$('#TAHUN').textbox('setValue',row.TAHUN);
	$('#KESETIAAN').textbox('setValue',row.KESETIAAN);
	$('#PRESTASI_KERJA').textbox('setValue',row.PRESTASI_KERJA);
	$('#TANGGUNG_JAWAB').textbox('setValue',row.TANGGUNG_JAWAB);
	$('#KETAATAN').textbox('setValue',row.KETAATAN);
	$('#KEJUJURAN').textbox('setValue',row.KEJUJURAN);
	$('#KERJASAMA').textbox('setValue',row.KERJASAMA);
	$('#PRAKARSA').textbox('setValue',row.PRAKARSA);
	$('#KEPEMIMPINAN').textbox('setValue',row.KEPEMIMPINAN);
	$('#JUMLAH').textbox('setValue',row.JUMLAH);
	$('#NILAI_RATA_RATA').textbox('setValue',row.NILAI_RATA_RATA);
	}
}

//========= End Riwayat Penghargaan



//========= Riwayat Angka Kredit
function addRiwayatAngkaKredit(){
    $('#formTambahRiwayatAngkaKredit').form('clear');
	$('#dialogAddRiwayatAngkaKredit').dialog('open').dialog('setTitle','Tambah data riwayat Angka Kredit');
}

function saveRiwayatAngkaKredit()
{
	$('#formTambahRiwayatAngkaKredit').form('submit',{
	url: '<?php echo site_url('riwayat_angka_kredit/save_riwayat_angka_kredit'); ?>/'+$('#current_nip').val(),
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
	$('#dialogAddRiwayatAngkaKredit').dialog('close');
	success('Berhasil',response.msg);
	var thisNip = $('#current_nip').val();
                loadRiwayatAngkaKredit(thisNip);
	}else{
	error('Gagal',response.msg);
	}
	}
	});
}

function loadRiwayatAngkaKredit(nip)
{
	var url = "<?=site_url('riwayat_angka_kredit/load_data_riwayat_angka_kredit')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataAngkaKredit').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataAngkaKredit').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

function deleteRiwayatAngkaKredit()
{
	var row = $('#gridDataAngkaKredit').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
	info('Info','Silahkan pilih data yang akan dihapus');
	}else{
	$.messager.confirm('Konfirmasi','Apakah Anda yakin ingin hapus data ini?',function(r){
	if (r){
	$.post('<?=site_url('riwayat_angka_kredit/delete_riwayat_angka_kredit')?>',{id:row.RIWAYAT_ANGKA_KREDIT_ID},function(result){
	if (result.status == 1){
	success('Success',result.msg);
	$('#gridDataAngkaKredit').datagrid('reload');
	} else {
	error('Error',result.msg);
	}
	},'json');
	}
	});
	}
}

function editRiwayatAngkaKredit()
{
	var row = $('#gridDataAngkaKredit').datagrid('getSelected');
	if( !row ){
	info('Info','Silahkan pilih data riwayat');
	}else{
	$('#riwayat_angka_kredit_id').val(row.RIWAYAT_ANGKA_KREDIT_ID);
	$('#AK_ANGKA_KREDIT_PERTAMA').textbox('setValue',row.ANGKA_KREDIT_PERTAMA);
	$('#AK_JABATAN_ID').combobox('setValue',row.JABATAN_ID);
	$('#AK_NOMOR_SK').textbox('setValue',row.NOMOR_SK);
	$('#AK_TANGGAL_SK').datebox('setValue',row.TANGGAL_SK);
	$('#AK_BULAN_MULAI_PENILAIAN').textbox('setValue',row.BULAN_MULAI_PENILAIAN);
	$('#AK_TAHUN_MULAI_PENILAIAN').textbox('setValue',row.TAHUN_MULAI_PENILAIAN);
	$('#AK_BULAN_SELESAI_PENILAIAN').textbox('setValue',row.BULAN_SELESAI_PENILAIAN);
	$('#AK_TAHUN_SELESAI_PENILAIAN').textbox('setValue',row.TAHUN_SELESAI_PENILAIAN);
	$('#AK_KREDIT_UTAMA_BARU').textbox('setValue',row.KREDIT_UTAMA_BARU);
	$('#AK_KREDIT_PENUNJANG_BARU').textbox('setValue',row.KREDIT_PENUNJANG_BARU);
	$('#AK_KREDIT_BARU_TOTAL').textbox('setValue',row.KREDIT_BARU_TOTAL);
	$('#dialogAddRiwayatAngkaKredit').dialog('open').dialog('setTitle','Ubah data riwayat Angka Kredit');
	}
}

//========= End Riwayat Angka Kredit


</script>