<div id="pegawai_grid_ijin_belajar_tugas_toolbar">
<a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addIjinBelajarTugasTes()">Input Data Tugas BelajarTes</a>
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addIjinBelajarTugas()">Input Data Tugas Belajar</a>
    <a class="easyui-linkbutton" iconCls="icon-user" href="#" onclick="detailIjinBelajarPegawaiTugas()">Detail Tugas Belajar Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-export-excel" href="#" onclick="exportPegawaiTugas()">Export Data Pegawai</a>

    <hr>

    <form method="post" action="">
        <table width="100%" border="0">
        <tr>
            <td width="5%">NIP</td>
            <td width="95%"> : <input type="text" class="easyui-textbox" id="search_nip" name="search_nip" style="width:400px"></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td> : <input type="text" class="easyui-textbox" id="search_nama" name="search_nama" style="width:400px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariPegawai()">Cari pegawai</a></td>
        </tr>
        </table>
    </form>

</div>


<table id="gridPegawaiTugasBelajar">
    
</table>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/get_data_pegawai')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawaiTugasBelajar').datagrid({
        url: url_data,
        queryParams:{
            nip: search_nip,
            nama: search_nama
        },
        method: 'post',
        title: 'Data Pegawai',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'NIP',title:'NIP',width:25},
            {field:'NAMA',title:'NAMA PEGAWAI',width:40},
            {field:'GOLONGAN',title:'GOLONGAN',width:20},
            {field:'ALAMAT',title:'ALAMAT',width:40},
            {field:'INSTANSI',title:'INSTANSI',width:50},
            {field:'JABATAN',title:'JABATAN',width:50}
        ]],
        toolbar:'#pegawai_grid_ijin_belajar_toolbar'

    });
    
});

function cariPegawai(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_nip = $('#search_nip').textbox('getValue');
        var search_nama = $('#search_nama').textbox('getValue');

       var url_data = '<?=site_url('pegawai/get_data_pegawai')?>';
        $('#gridPegawaiTugasBelajar').datagrid({
            url: url_data,
            queryParams:{
                nip:search_nip,
                nama:search_nama
            },
            method: 'post',
            title: 'Data Pegawai',
            iconCls: 'icon-people',
            pagination:true,
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
            toolbar:'#pegawai_grid_ijin_belajar_toolbar'

        });
    }

}

</script>
<?php
$this->load->view('kembangkarir/layout_add_ijin_belajar_tugas_tes');

$this->load->view('kembangkarir/layout_add_ijin_belajar_tugas');
$this->load->view('kembangkarir/layout_add_ijin_belajar_detail_tugas');
$this->load->view('kembangkarir/layout_detail_ijin_belajar_tugas');

?>