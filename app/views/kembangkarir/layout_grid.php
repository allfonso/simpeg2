<div id="pegawai_grid_ijin_belajar_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addIjinBelajar()">Input Data Ijin Belajar</a>
    <a class="easyui-linkbutton" iconCls="icon-user" href="#" onclick="detailIjinBelajarPegawai()">Detail Ijin Belajar Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-reload" href="#" onclick="load_data_ijin_belajar()">Refresh</a>
    <a class="easyui-linkbutton" iconCls="icon-export-excel" href="#" onclick="exportIjinBelajar()">Export Data Pegawai</a>

    <hr>

    <form method="post" action="" id="formSearchIjinBelajar">
        <table width="100%" border="0">
        <tr>
            <td width="20%">NIP</td>
            <td width="80%"> : <input type="text" class="easyui-textbox" id="search_nip" name="search_nip" style="width:400px"></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td> : <input type="text" class="easyui-textbox" id="search_nama" name="search_nama" style="width:400px"></td>
        </tr>
        <tr>
            <td>Universitas</td>
            <td>: <input class="easyui-combobox" name="search_universitas" id="search_universitas" data-options="url:'<?=site_url('kembangkarir/load_universitas')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
        </tr>
        <tr>
            <td>BULAN & TAHUN MULAI</td>
            <td> : 
                <select name="search_bulanmulai" id="search_bulanmulai" class="easyui-combobox">
                    <option value="">pilih Tanggal</option>
                <?php
                foreach ((array)$bulan as $key => $value) {
                    ?>
                    <option value="<?=$key?>"><?=$value?></option>
                    <?php
                }
                ?>
                </select>

                <select name="search_tahunmulai" id="search_tahunmulai" class="easyui-combobox">
                    <option value="">pilih Tahun</option>
                <?php
                $yearnow = date("Y",time());
                for ($i=1990; $i < $yearnow+5; $i++) { 
                ?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?php
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>BULAN & TAHUN SELESAI</td>
            <td> : 
                <select name="search_bulanselesai" id="search_bulanselesai" class="easyui-combobox">
                    <option value="">pilih Tanggal</option>
                <?php
                foreach ((array)$bulan as $key => $value) {
                    ?>
                    <option value="<?=$key?>"><?=$value?></option>
                    <?php
                }
                ?>
                </select>

                <select name="search_tahunselesai" id="search_tahunselesai" class="easyui-combobox">
                    <option value="">pilih Tahun</option>
                <?php
                $yearnow = date("Y",time());
                for ($i=1990; $i < $yearnow+10; $i++) { 
                ?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?php
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariijinbelajar()">Cari</a></td>
        </tr>
        </table>
    </form>

</div>


<table id="gridPegawaiIjinBelajar">
    
</table>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawaiIjinBelajar').datagrid({
        url: url_data,
        queryParams:{
            nip: search_nip,
            nama: search_nama
        },
        method: 'post',
        title: 'Data Ijin Belajar',
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
            {field:'NO_SURAT_IJIN_BELAJAR',title:'NO SURAT IJIN BELAJAR',width:60},
            {field:'IJIN_TGL_MULAI',title:'TGL MULAI IJIN',width:40},
            {field:'IJIN_TGL_SELESAI',title:'TGL SELESAI IJIN',width:40},
            {field:'JENJANG_DIDIK',title:'JENJANG PENDIDIKAN',width:20},
            {field:'JURUSAN',title:'JURUSAN',width:50},
            {field:'UNIVERSITAS',title:'UNIVERSITAS',width:50}
        ]],
        toolbar:'#pegawai_grid_ijin_belajar_toolbar'

    });
    
});

function cariijinbelajar(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_nip = $('#search_nip').textbox('getValue');
        var search_nama = $('#search_nama').textbox('getValue');
        var search_universitas = $('#search_universitas').combobox('getValue');
        var search_bulanmulai = $('#search_bulanmulai').val();
        var search_tahunmulai = $('#search_tahunmulai').val();
        var search_bulanselesai = $('#search_bulanselesai').val();
        var search_tahunselesai = $('#search_tahunselesai').val();

       var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar')?>';
        $('#gridPegawaiIjinBelajar').datagrid({
            url: url_data,
            queryParams:{
                nip:search_nip,
                nama:search_nama,
                universitas:search_universitas,
                bulanmulai:search_bulanmulai,
                tahunmulai:search_tahunmulai,
                bulanselesai:search_bulanselesai,
                tahunselesai:search_tahunselesai
            },
            method: 'post',
            title: 'Data Ijin Belajar',
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
                {field:'NO_SURAT_IJIN_BELAJAR',title:'NO SURAT IJIN BELAJAR',width:60},
                {field:'IJIN_TGL_MULAI',title:'TGL MULAI IJIN',width:40},
                {field:'IJIN_TGL_SELESAI',title:'TGL SELESAI IJIN',width:40},
                {field:'JENJANG_DIDIK',title:'JENJANG PENDIDIKAN',width:20},
                {field:'JURUSAN',title:'JURUSAN',width:50},
                {field:'UNIVERSITAS',title:'UNIVERSITAS',width:50}
            ]],
            toolbar:'#pegawai_grid_ijin_belajar_toolbar'

        });
    }

}

function load_data_ijin_belajar()
{
    $('#formSearchIjinBelajar').form('clear');
    var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawaiIjinBelajar').datagrid({
        url: url_data,
        queryParams:{
            nip: search_nip,
            nama: search_nama
        },
        method: 'post',
        title: 'Data Ijin Belajar',
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
            {field:'NO_SURAT_IJIN_BELAJAR',title:'NO SURAT IJIN BELAJAR',width:60},
            {field:'IJIN_TGL_MULAI',title:'TGL MULAI IJIN',width:40},
            {field:'IJIN_TGL_SELESAI',title:'TGL SELESAI IJIN',width:40},
            {field:'JENJANG_DIDIK',title:'JENJANG PENDIDIKAN',width:20},
            {field:'JURUSAN',title:'JURUSAN',width:50},
            {field:'UNIVERSITAS',title:'UNIVERSITAS',width:50}
        ]],
        toolbar:'#pegawai_grid_ijin_belajar_toolbar'

    });
}

</script>
<?php
$this->load->view('kembangkarir/layout_add_ijin_belajar');
$this->load->view('kembangkarir/layout_add_ijin_belajar_detail');
$this->load->view('kembangkarir/layout_detail_ijin_belajar');
// $this->load->view('pegawai/layout_riwayat');
// $this->load->view('pegawai/layout_form_riwayat');
?>