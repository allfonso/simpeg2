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
<div id="dialogDetailPegawaiIjin" class="easyui-window" style="width:1300px;height:550px" closed="true" data-options="iconCls:'icon-user'" buttons="#dialogDetailPegawaiIjin-buttons">
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
			<?php $this->load->view('kembangkarir/layout_data_ijin_belajar'); ?>
		</div>
	</div>
</div>

<script>
var url_detail = '<?=site_url('pegawai/get_detail_pegawai')?>';
var photo_url = '<?=_URL?>files/pegawai/';
var nip = $('#current_nip').val();

function detailIjinBelajarPegawai()
{
	var row = $('#gridPegawaiIjinBelajar').datagrid('getSelected');
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
					loadIjinBelajar(nip);


				}else{
					error('Error!','Gagal ambil data detail ijin belajar pegawai. Silahkan ulangi');
				}
				$.messager.progress('close');
			},
			error: function(){
				error('Error!','Terjadi kesalahan saat memuat data. Silahkan hubungi administrator');
			}

		});
		$('#dialogDetailPegawaiIjin').dialog('open').dialog('setTitle','Detail ijin belajar pegawai');
	}
}

$(document).ready(function(){
	$('#gridDataIjinBelajar').datagrid({
		singleSelect: true
	});

	$('#gridDataIjinBelajar').datagrid({
		singleSelect: true,
		toolbar:[
			{
                text:'Input Data Ijin Belajar',
                iconCls:'icon-add',
                handler:function(){
                	addIjinBelajarDetail();
                }
            },'-',{
                text:'Edit Data Ijin Belajar',
                iconCls:'icon-edit',
                handler:function(){
                   editIjinBelajarDetail();
                }
            },'-',{
                text:'Hapus Data Ijin Belajar',
                iconCls:'icon-remove',
                handler:function(){
                    deleteIjinBelajarDetail();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadIjinBelajar(nip);
                }
            }]
	});
});

// ========== Ijin Belajar
function loadIjinBelajar(nip)
{
	var url = "<?=site_url('kembangkarir/load_data_ijin_belajar')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
            if(response.total > 0){
                $('#gridDataIjinBelajar').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataIjinBelajar').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

var url_save   = "<?= site_url('kembangkarir/saveijinbelajar')?>";
var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";

function addIjinBelajarDetail()
{
	var nip = $('#current_nip').val();
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
                $('#dialogAddIjinBelajarDetail').dialog('open').dialog('setTitle','Tambah Ijin Belajar pegawai');
                // $('#current_ijin_nip').val( response['data']['profil']['NIP'] );
                $('#current_detail_nip').val( response['data']['profil']['NIP'] );
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

function simpanIjinBelajarDetail()
{
	var nip = $('#current_nip').val();
    $('#formDetailAddIjinBelajar').form('submit',{
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
                $('#dialogAddIjinBelajarDetail').dialog('close');
                loadIjinBelajar(nip);
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}

function editIjinBelajarDetail()
{
	var row = $('#gridDataIjinBelajar').datagrid('getSelected');
	if( !row ){
		error('Error!','Silahkan pilih data ijin belajar');
	}else{
		var ijin_id = row.IJIN_ID;
		console.log(ijin_id);
		var url = "<?=site_url('kembangkarir/load_detail_ijin_belajar')?>";
		$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{ijin_id:row.IJIN_ID},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){	           		
	           		$('#dialogEditIjinBelajarDetail').dialog('open').dialog('setTitle','Ubah data Ijin Belajar');
	           		$('#current_ijin_id').val( response['data']['IJIN_ID'] );
	           		$('span#inputNipEdit').html( response['data']['NIP'] );
	           		$('span#inputNipLamaEdit').html( response['data']['NIP_LAMA'] );
	           		$('span#inputNamaEdit').html( response['data']['NAMA_PEGAWAI'] );
	           		$('#inputNoSuratIjinBelajarEdit').textbox('setValue',response['data']['NO_SURAT_IJIN_BELAJAR']);
	           		$('#inputTglMulaiIjinBelajarEdit').datebox('setValue',response['data']['IJIN_TGL_MULAI']);
					$('#inputTglSelesaiIjinBelajarEdit').datebox('setValue',response['data']['IJIN_TGL_SELESAI']);
	           		$('#jenjang_didik_idEdit').combobox('setValue',response['data']['JENJANG_DIDIK']);
	           		$('#inputJurusanEdit').textbox('setValue',response['data']['JURUSAN']);
					$('#inputUniversitasEdit').textbox('setValue',response['data']['UNIVERSITAS']);
	           }
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

function simpanEditIjinBelajarDetail()
{
	$('#formDetailEditIjinBelajar').form('submit',{
			url: '<?php echo site_url('kembangkarir/edit_ijin_belajar'); ?>',
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
					$('#dialogEditIjinBelajarDetail').dialog('close');
					success('Berhasil',response.msg);
					var thisNip = $('#current_nip').val();
					loadIjinBelajar(thisNip);
				}else{
					error('Gagal',response.msg);
				}
			}
		});
}

function deleteIjinBelajarDetail()
{
	var row = $('#gridDataIjinBelajar').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
		info('Info','Silahkan pilih data yang akan dihapus');
	}else{
		$.messager.confirm('Konfirmasi','Apakah Andaa yakin ingin hapus data ini?',function(r){
			if (r){
				$.post('<?=site_url('kembangkarir/delete_ijin_belajar')?>',{ijin_id:row.IJIN_ID},function(result){
					if (result.status == 1){
						success('Success',result.msg);
						loadIjinBelajar(nip);
					} else {
						error('Error',result.msg);
					}
				},'json');
			}
		});
	}
}
</script>