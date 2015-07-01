<table id="gridPegawaiTidakAktif" data-options="toolbar:'#search_pegawai_tidak_aktif'">
    
</table>

<div id="search_pegawai_tidak_aktif">
	<table width="100%" border="0">
		<tr>
			<td width="15%">Alasan pemberhentian</td>
			<td width="85%">
				 <select class="easyui-combobox" data-options="panelHeight:'200px'">
			    	<option value="">...</option>
			    	<?php
			    	$jenis_pemberhentian = get_kedudukan_pegawai();
			    	foreach((array)$jenis_pemberhentian as $k=>$v)
			    	{
			    		if( $k != '01' ){
			    	?>
			    		<option value="<?=$k?>"><?=$v?></option>
			    	<?php
			    		}
			    	}
			    	?>
			    </select>
			</td>
		</tr>
		<tr>
			<td>NIP</td>
			<td><input type="text" class="easyui-textbox" name="nama" id="nama" style="width:280px;"></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td><input type="text" class="easyui-textbox" name="nama" id="nama" style="width:280px;"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><button type="button" class="easyui-linkbutton" name="submit" id="submit" iconCls="icon-search">Cari</button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/load_pegawai_tidak_aktif')?>';
    $('#gridPegawaiTidakAktif').datagrid({
        url: url_data,
        method: 'post',
        title: 'Data Pegawai Tidak Aktif',
        iconCls: 'icon-people',
        rownumbers: false,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'NIP',title:'NIP',width:35},
            {field:'NAMA',title:'NAMA PEGAWAI',width:50},
            {field:'GOLONGAN',title:'GOLONGAN',width:50},
            {field:'JABATAN',title:'JABATAN',width:50},
            {field:'KEDUDUKAN_NAMA',title:'JENIS PEMBERHENTIAN',width:50},
            {field:'LINK',title:'AKTIVASI',width:30},
        ]]
    });

    
});

function searchDataPegawaiTidakAktif(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{
        $.ajax({
            url:'<?=site_url('pegawai/get_data_pegawai')?>',
            type:'post',
            dataType:'json',
            data:{type:name,key:value},
            beforeSend:function(xhr,status){

            },
            success:function(response){
                if(response.total > 0){
                    $('#gridPegawaiTidakAktif').datagrid('loadData',response);
                }else{
                    info('Info','Data tidak ditemukan');
                    $('#gridPegawaiTidakAktif').datagrid('loadData',[]);
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
            }
        });
    }

}

function aktivasiPegawai(id)
{
	if(id)
	{
		$.ajax({
            url:'<?=site_url('pegawai/aktivasi_pegawai')?>',
            type:'post',
            dataType:'json',
            data:{id:id},
            beforeSend:function(xhr,status){

            },
            success:function(response){
               if( response.status == 1 ){
               		success('Sukses',response.msg);
               		$('#gridPegawaiTidakAktif').datagrid('reload');
               }else{
               		error('Error',response.msg);
               }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat aktivasi pegawai. Silahkan ulangi');
            }
        });
	}
}

</script>