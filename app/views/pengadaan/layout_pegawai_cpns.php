<table id="gridPegawaiCPNS">
    
</table>

<div id="cpns_search">
    <div data-options="name:'nip'">NIP</div>
    <div data-options="name:'nama'">Nama</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/load_pegawai_cpns')?>';
    $('#gridPegawaiCPNS').datagrid({
        url: url_data,
        method: 'post',
        title: 'Data Pegawai CPNS',
        iconCls: 'icon-people',
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'NIP',title:'NIP',width:30},
            {field:'NAMA',title:'NAMA PEGAWAI',width:50},
            {field:'JENIS_KELAMIN',title:'JENIS KELAMIN',width:30},
            {field:'TEMPAT_TANGGAL_LAHIR',title:'TEMPAT, TANGGAL LAHIR',width:40},
            {field:'ALAMAT',title:'ALAMAT',width:40},
            {field:'GOLONGAN',title:'GOLONGAN',width:40}
        ]],
        toolbar:[
        	{
                text:'Pengangkatan pegawai',
                iconCls:'icon-people',
                handler:function(){
                   pengangkatanPegawai();
               }
            },{
                text:'Bersihkan pencarian',
                iconCls:'icon-reload',
                handler:function(){
                	$('#search').searchbox('clear');
                   $.ajax({
			            url:'<?=site_url('pegawai/load_pegawai_cpns')?>',
			            type:'post',
			            dataType:'json',
			            beforeSend:function(xhr,status){

			            },
			            success:function(response){
			                if(response.total > 0){
			                    $('#gridPegawaiCPNS').datagrid('loadData',response);
			                }else{
			                    info('Info','Data tidak ditemukan');
			                    $('#gridPegawaiCPNS').datagrid('loadData',[]);
			                }
			            },
			            error:function(xhr,status){
			                info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
			            }
			        });
                }
            }]
    });
    
    $('.datagrid-toolbar > table').css('float','left');
    $('.datagrid-toolbar').append('<div style="float:right;padding:2px;"><input class="easyui-searchbox" menu="#cpns_search" searcher="searchDataCPNS" style="width:300px" id="search"></div><div style="clear:both;"></div>');
    
});

function searchDataCPNS(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{
        $.ajax({
            url:'<?=site_url('pegawai/load_pegawai_cpns')?>',
            type:'post',
            dataType:'json',
            data:{type:name,key:value},
            beforeSend:function(xhr,status){

            },
            success:function(response){
                if(response.total > 0){
                    $('#gridPegawaiCPNS').datagrid('loadData',response);
                }else{
                    info('Info','Data tidak ditemukan');
                    $('#gridPegawaiCPNS').datagrid('loadData',[]);
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
            }
        });
    }

}

function load_pegawai_cpns(){
    var url_data = '<?=site_url('pegawai/load_pegawai_cpns')?>';
    $('#gridPegawaiCPNS').datagrid({
        url: url_data,
        method: 'post',
        title: 'Data Pegawai CPNS',
        iconCls: 'icon-people',
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'NIP',title:'NIP',width:30},
            {field:'NAMA',title:'NAMA PEGAWAI',width:50},
            {field:'JENIS_KELAMIN',title:'JENIS KELAMIN',width:30},
            {field:'TEMPAT_TANGGAL_LAHIR',title:'TEMPAT, TANGGAL LAHIR',width:40},
            {field:'ALAMAT',title:'ALAMAT',width:40},
            {field:'GOLONGAN',title:'GOLONGAN',width:40}
        ]],
        toolbar:[
            {
                text:'Pengangkatan pegawai',
                iconCls:'icon-people',
                handler:function(){
                   pengangkatanPegawai();
               }
            },{
                text:'Bersihkan pencarian',
                iconCls:'icon-reload',
                handler:function(){
                    $('#search').searchbox('clear');
                   $.ajax({
                        url:'<?=site_url('pegawai/load_pegawai_cpns')?>',
                        type:'post',
                        dataType:'json',
                        beforeSend:function(xhr,status){

                        },
                        success:function(response){
                            if(response.total > 0){
                                $('#gridPegawaiCPNS').datagrid('loadData',response);
                            }else{
                                info('Info','Data tidak ditemukan');
                                $('#gridPegawaiCPNS').datagrid('loadData',[]);
                            }
                        },
                        error:function(xhr,status){
                            info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
                        }
                    });
                }
            }]
    });
    
    $('.datagrid-toolbar > table').css('float','left');
    $('.datagrid-toolbar').append('<div style="float:right;padding:2px;"><input class="easyui-searchbox" menu="#cpns_search" searcher="searchDataCPNS" style="width:300px" id="search"></div><div style="clear:both;"></div>');
}

</script>

<?php
$this->load->view('pengadaan/layout_pengangkatan_pegawai');
?>