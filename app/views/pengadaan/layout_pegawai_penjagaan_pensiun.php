<table id="gridPegawaiPenjagaanPensiun">
    
</table>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/load_pegawai_penjagaan_pensiun')?>';
    $('#gridPegawaiPenjagaanPensiun').datagrid({
        url: url_data,
        method: 'post',
        title: 'Data Pegawai Tidak Aktif',
        iconCls: 'icon-people',
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'NIP',title:'NIP',width:30},
            {field:'NAMA',title:'NAMA PEGAWAI',width:50},
            {field:'GOLONGAN',title:'GOLONGAN',width:20},
            {field:'INSTANSI',title:'INSTANSI',width:50},
            {field:'JABATAN',title:'JABATAN',width:50}
        ]]
    });
});

function searchDataPenjagaanPensiun(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{
        $.ajax({
            url:'<?=site_url('pegawai/load_pegawai_penjagaan_pensiun')?>',
            type:'post',
            dataType:'json',
            data:{type:name,key:value},
            beforeSend:function(xhr,status){

            },
            success:function(response){
                if(response.total > 0){
                    $('#gridPegawaiPenjagaanPensiun').datagrid('loadData',response);
                }else{
                    info('Info','Data tidak ditemukan');
                    $('#gridPegawaiPenjagaanPensiun').datagrid('loadData',[]);
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
            }
        });
    }

}

</script>