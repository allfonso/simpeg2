<div id="pegawai_grid_ijin_belajar_ln_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addIjinBelajarLn()">Input Data Ijin Luar Negeri</a>
    <a class="easyui-linkbutton" iconCls="icon-user" href="#" onclick="detailIjinBelajarPegawaiLn()">Detail Ijin Luar Negeri Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-reload" href="#" onclick="load_data_ijin_belajar_ln()">Refresh</a>
    <a class="easyui-linkbutton" iconCls="icon-export-excel" href="#" onclick="exportIjinBelajarLn()">Export Data Pegawai</a>

    <hr>

    <form method="post" action="" id="formSearchIjinBelajarLn">
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
            <td>Negara Tujuan</td>
            <td>: <input class="easyui-textbox" name="search_negara" id="search_negara" style="width:400px"></td>
        </tr>
        <tr>
            <td>BULAN & TAHUN BERANGKAT</td>
            <td> : 
                <select name="search_bulanberangkat" id="search_bulanberangkat" class="easyui-combobox">
                    <option value="">pilih Tanggal</option>
                <?php
                foreach ((array)$bulan as $key => $value) {
                    ?>
                    <option value="<?=$key?>"><?=$value?></option>
                    <?php
                }
                ?>
                </select>

                <select name="search_tahunberangkat" id="search_tahunberangkat" class="easyui-combobox">
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
            <td>BULAN & TAHUN PULANG</td>
            <td> : 
                <select name="search_bulanpulang" id="search_bulanpulang" class="easyui-combobox">
                    <option value="">pilih Tanggal</option>
                <?php
                foreach ((array)$bulan as $key => $value) {
                    ?>
                    <option value="<?=$key?>"><?=$value?></option>
                    <?php
                }
                ?>
                </select>

                <select name="search_tahunpulang" id="search_tahunpulang" class="easyui-combobox">
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
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariijinbelajarln()">Cari</a></td>
        </tr>
        </table>
    </form>

</div>


<table id="gridPegawaiIjinLuarNegeri">
    
</table>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar_ln')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawaiIjinLuarNegeri').datagrid({
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
            {field:'TGL_KEBERANGKATAN',title:'TGL KEBERANGKATAN',width:20},
            {field:'TGL_PULANG',title:'TGL PULANG',width:40},
            {field:'NEGARA_TUJUAN',title:'NEGARA TUJUAN',width:50}
        ]],
        toolbar:'#pegawai_grid_ijin_belajar_ln_toolbar'

    });
    
});

function cariijinbelajarln(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_nip = $('#search_nip').textbox('getValue');
        var search_nama = $('#search_nama').textbox('getValue');
        var search_negara = $('#search_negara').textbox('getValue');
        var search_bulanberangkat = $('#search_bulanberangkat').val();
        var search_tahunberangkat = $('#search_tahunberangkat').val();
        var search_bulanpulang = $('#search_bulanpulang').val();
        var search_tahunpulang = $('#search_tahunpulang').val();

       var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar_ln')?>';
        $('#gridPegawaiIjinLuarNegeri').datagrid({
            url: url_data,
            queryParams:{
                nip:search_nip,
                nama:search_nama,
                negara:search_negara,
                bulanberangkat:search_bulanberangkat,
                tahunberangkat:search_tahunberangkat,
                bulanpulang:search_bulanpulang,
                tahunpulang:search_tahunpulang
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
                {field:'TGL_KEBERANGKATAN',title:'TGL KEBERANGKATAN',width:20},
                {field:'TGL_PULANG',title:'TGL PULANG',width:40},
                {field:'NEGARA_TUJUAN',title:'NEGARA TUJUAN',width:50}
            ]],
            toolbar:'#pegawai_grid_ijin_belajar_ln_toolbar'

        });
    }

}

function load_data_ijin_belajar_ln()
{
    $('#formSearchIjinBelajarLn').form('clear');
    var url_data = '<?=site_url('kembangkarir/get_data_ijin_belajar_ln')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawaiIjinLuarNegeri').datagrid({
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
            {field:'TGL_KEBERANGKATAN',title:'TGL KEBERANGKATAN',width:20},
            {field:'TGL_PULANG',title:'TGL PULANG',width:40},
            {field:'NEGARA_TUJUAN',title:'NEGARA TUJUAN',width:50}
        ]],
        toolbar:'#pegawai_grid_ijin_belajar_toolbar'

    });
}

function exportIjinBelajarLn()
{
    console.log($("#formSearchIjinBelajarLn").serialize());
}

</script>
<?php
$this->load->view('kembangkarir/layout_add_ijin_belajar_ln');
$this->load->view('kembangkarir/layout_add_ijin_belajar_detail_ln');
$this->load->view('kembangkarir/layout_detail_ijin_belajar_ln');

?>