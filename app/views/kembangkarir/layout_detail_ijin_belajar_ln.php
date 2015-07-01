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
<div id="dialogDetailPegawaiIjinLn" class="easyui-window" style="width:1300px;height:550px" closed="true" data-options="iconCls:'icon-user'" buttons="#dialogDetailPegawaiIjinLn-buttons">
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
			<?php $this->load->view('kembangkarir/layout_data_ijin_belajar_ln'); ?>
		</div>
	</div>
</div>

<script>
var url_detail = '<?=site_url('pegawai/get_detail_pegawai')?>';
var photo_url = '<?=_URL?>files/pegawai/';
var nip = $('#current_nip').val();

function detailIjinBelajarPegawaiLn()
{
	var row = $('#gridPegawaiIjinLuarNegeri').datagrid('getSelected');
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
					loadIjinLuarNegeri(nip);


				}else{
					error('Error!','Gagal ambil data detail ijin belajar pegawai. Silahkan ulangi');
				}
				$.messager.progress('close');
			},
			error: function(){
				error('Error!','Terjadi kesalahan saat memuat data. Silahkan hubungi administrator');
			}

		});
		$('#dialogDetailPegawaiIjinLn').dialog('open').dialog('setTitle','Detail ijin Luar Negeri pegawai');
	}
}

$(document).ready(function(){
	$('#gridDataIjinBelajarLn').datagrid({
		singleSelect: true
	});

	$('#gridDataIjinBelajarLn').datagrid({
		singleSelect: true,
		toolbar:[
			{
                text:'Input Data Ijin Luar Negeri',
                iconCls:'icon-add',
                handler:function(){
                	addIjinBelajarDetailLn();
                }
            },'-',{
                text:'Edit Data Ijin Luar Negeri',
                iconCls:'icon-edit',
                handler:function(){
                   editIjinBelajarDetailLn();
                }
            },'-',{
                text:'Hapus Data Ijin Luar Negeri',
                iconCls:'icon-remove',
                handler:function(){
                    deleteIjinBelajarDetailLn();
                }
            },'-',{
                text:'Refresh',
                iconCls:'icon-reload',
                handler:function(){
                	var nip = $('#current_nip').val();
                    loadIjinLuarNegeri(nip);
                }
            }]
	});
});

// ========== Ijin Belajar
function loadIjinLuarNegeri(nip)
{
	var url = "<?=site_url('kembangkarir/load_data_ijin_luar_negeri')?>";
	$.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:{nip:nip},
        beforeSend:function(xhr,status){

        },
        success:function(response){
        	console.log(response);
            if(response.total > 0){
                $('#gridDataIjinBelajarLn').datagrid('loadData',response);
            }else{
                info('Info','Data tidak ditemukan');
                $('#gridDataIjinBelajarLn').datagrid('loadData',[]);
            }
        },
        error:function(xhr,status){
            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
        }
    });
}

var url_save   = "<?= site_url('kembangkarir/saveijinluarnegri')?>";
var url_detail = "<?= site_url('pegawai/get_detail_pegawai')?>";

function addIjinBelajarDetailLn()
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
                $('#dialogAddIjinBelajarDetailLn').dialog('open').dialog('setTitle','Tambah Ijin Luar Negeri pegawai');
                // $('#current_ijin_nip').val( response['data']['profil']['NIP'] );
                $('#current_detail_ln_nip').val( response['data']['profil']['NIP'] );
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

function simpanIjinBelajarDetailLn()
{
	var nip = $('#current_nip').val();
    $('#formDetailAddIjinLuarNegeri').form('submit',{
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
                $('#dialogAddIjinBelajarDetailLn').dialog('close');
                loadIjinLuarNegeri(nip);
                success('Berhasil',response.msg);
            }else{
                error('Gagal',response.msg);
            }
        }
    });
}

function editIjinBelajarDetailLn()
{
	var row = $('#gridDataIjinBelajarLn').datagrid('getSelected');
	if( !row ){
		error('Error!','Silahkan pilih data ijin luar negeri');
	}else{
		var ijin_id_ln = row.IJIN_ID_LN;
		console.log(ijin_id_ln);
		var url = "<?=site_url('kembangkarir/load_detail_ijin_belajar_ln')?>";
		$.ajax({
	        url:url,
	        type:'post',
	        dataType:'json',
	        data:{ijin_id_ln:row.IJIN_ID_LN},
	        beforeSend:function(xhr,status){

	        },
	        success:function(response){
	           if(response.status==1){	           		
	           		$('#dialogEditIjinBelajarDetailLn').dialog('open').dialog('setTitle','Ubah data Ijin Luar Negeri');
	           		$('#current_ijin_id_ln').val( response['data']['IJIN_ID_LN'] );
	           		$('span#inputNipEdit').html( response['data']['NIP'] );
	           		$('span#inputNipLamaEdit').html( response['data']['NIP_LAMA'] );
	           		$('span#inputNamaEdit').html( response['data']['NAMA_PEGAWAI'] );
	           		$('#inputTglkeberangkatanEdit').datebox('setValue',response['data']['TGL_KEBERANGKATAN']);
					$('#inputTglPulangEdit').datebox('setValue',response['data']['TGL_PULANG']);	           		
					$('#inputTujuanNegaraEdit').textbox('setValue',response['data']['NEGARA_TUJUAN']);
	           }
	        },
	        error:function(xhr,status){
	            info('Info','Terjadi kesalahan saat load data. Silahkan hubungi administrator');
	        }
	    });
	}
}

function simpanEditIjinBelajarDetailLn()
{
	$('#formDetailEditIjinBelajarLn').form('submit',{
			url: '<?php echo site_url('kembangkarir/edit_ijin_luarnegeri'); ?>',
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
					$('#dialogEditIjinBelajarDetailLn').dialog('close');
					success('Berhasil',response.msg);
					var thisNip = $('#current_nip').val();
					loadIjinLuarNegeri(thisNip);
				}else{
					error('Gagal',response.msg);
				}
			}
		});
}

function deleteIjinBelajarDetailLn()
{
	var row = $('#gridDataIjinBelajarLn').datagrid('getSelected');
	var nip = $('#current_nip').val();

	if( !row ){
		info('Info','Silahkan pilih data yang akan dihapus');
	}else{
		$.messager.confirm('Konfirmasi','Apakah Andaa yakin ingin hapus data ini?',function(r){
			if (r){
				$.post('<?=site_url('kembangkarir/delete_ijin_luarnegri')?>',{ijin_id_ln:row.IJIN_ID_LN},function(result){
					if (result.status == 1){
						success('Success',result.msg);
						loadIjinLuarNegeri(nip);
					} else {
						error('Error',result.msg);
					}
				},'json');
			}
		});
	}
}
</script>