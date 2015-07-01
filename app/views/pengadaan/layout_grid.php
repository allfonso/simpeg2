<table id="gridPegawai">
    
</table>

<div id="mm">
    <div data-options="name:'nip'">NIP</div>
    <div data-options="name:'nama'">Nama</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/get_data_pegawai')?>';
    $('#gridPegawai').datagrid({
        url: url_data,
        method: 'post',
        title: 'Data Pegawai',
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
        ]],
        toolbar:[{
                text:'Input Data Pegawai',
                iconCls:'icon-add',
                handler:function(){
                   addPegawai();
                }
            },'-',{
                text:'Edit Data Pegawai',
                iconCls:'icon-edit',
                handler:function(){
                   editPegawai();
                }
            },'-',{
                text:'Detail Pegawai',
                iconCls:'icon-user',
                handler:function(){
                    detailPegawai();
                }
            },'-',{
                text:'Data riwayat',
                iconCls:'icon-user',
                handler:function(){
                    riwayatPegawai();
                }
            },'-',{
                text:'Hapus Pegawai',
                iconCls:'icon-remove',
                handler:function(){
                    deletePegawai();
                }
            }]
    });
    
    $('.datagrid-toolbar > table').css('float','left');
    $('.datagrid-toolbar').append('<div style="float:right;padding:2px;"><input class="easyui-searchbox" menu="#mm" searcher="searchData" style="width:300px"></div><div style="clear:both;"></div>');
    
});

function searchData(value,name)
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
                    $('#gridPegawai').datagrid('loadData',response);
                }else{
                    info('Info','Data tidak ditemukan');
                    $('#gridPegawai').datagrid('loadData',[]);
                }
            },
            error:function(xhr,status){
                info('Info','Terjadi kesalahan saat load data pegawai. Silahkan ulangi');
            }
        });
    }

}

</script>
<?php
$this->load->view('pegawai/layout_add');
$this->load->view('pegawai/layout_detail');
$this->load->view('pegawai/layout_riwayat');
$this->load->view('pegawai/layout_form_riwayat');
?>