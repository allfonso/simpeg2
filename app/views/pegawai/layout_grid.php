<div id="pegawai_grid_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addPegawai()">Input Data Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-edit" href="#" onclick="editPegawai()">Edit Data Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-user" href="#" onclick="detailPegawai()">Detail Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-user" href="#" onclick="riwayatPegawai()">Data riwayat Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-remove" href="#" onclick="deletePegawai()">Hapus Data Pegawai</a>
    <a class="easyui-linkbutton" iconCls="icon-export-excel" href="#" onclick="exportPegawai()">Export Data Pegawai</a>

    <hr>

    <?php
    $this->load->view('pegawai/layout_search_pegawai');
    ?>

</div>


<table id="gridPegawai">
    
</table>

<script type="text/javascript">
$(document).ready(function(){
    var url_data = '<?=site_url('pegawai/get_data_pegawai')?>';
    var search_nip = $('#search_nip').val();
    var search_nama = $('#search_nama').val();

    $('#gridPegawai').datagrid({
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
        toolbar:'#pegawai_grid_toolbar'
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
        $('#gridPegawai').datagrid({
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
            toolbar:'#pegawai_grid_toolbar'

        });
    }
}

function editPegawai()
{
    $('#mode').val('edit');
    var row = $('#gridPegawai').datagrid('getSelected');
    if( !row ){
        info('Info','Silahkan pilih data yang akan diubah');
    }else{

        if( row.JENIS_KELAMIN != '' ){
            $('#inputJenisKelamin'+row.JENIS_KELAMIN).prop('checked',true);
        }

        $('#inputNip').textbox('setValue',row.NIP);
        $('#inputNipLama').textbox('setValue',row.NIP_LAMA);
        $('#inputNip').textbox('readonly');
        $('#inputNama').textbox('setValue',row.NAMA_PEGAWAI);
        $('#inputGelarDepan').textbox('setValue',row.GELAR_DEPAN);
        $('#inputGelarBelakang').textbox('setValue',row.GELAR_BELAKANG);
        $('#inputGelarLain').textbox('setValue',row.GELAR_LAIN);
        $('#inputTempatLahir').textbox('setValue',row.TEMPAT_LAHIR);
        $('#inputTanggaLahir').datebox('setValue',row.TANGGAL_LAHIR_EDIT);
        $('#inputNoAktaLahir').textbox('setValue',row.NO_AKTA_LAHIR);
        $('#inputJenisKelamin').textbox('setValue',row.JENIS_KELAMIN);
        $('#inputAgama').combobox('setValue',row.AGAMA_ID);
        $('#inputAlamat').textbox('setValue',row.ALAMAT);
        $('#inputKodepos').textbox('setValue',row.KODEPOS);
        $('#inputHandphone').textbox('setValue',row.NO_HANDPHONE);
        $('#inputTelephone').textbox('setValue',row.NO_TELEPHONE);
        $('#inputNoIdentitas').textbox('setValue',row.NO_IDENTITAS);
        $('#inputGolonganDarah').combobox('setValue',row.GOLONGAN_DARAH);
        $('#inputBeratBadan').textbox('setValue',row.BERAT_BADAN);
        $('#inputTinggiBadan').textbox('setValue',row.TINGGI_BADAN);
        $('#inputWarnaKulit').textbox('setValue',row.WARNA_KULIT);
        $('#inputStatusPegawai').combobox('setValue',row.STATUS_PEGAWAI);
        $('#inputStatusPegawai').combobox('disable');
        $('#inputKedudukanPegawai').combobox('setValue',row.KEDUDUKAN_ID);
        $('#inputKedudukanPegawai').combobox('disable');
        $('#inputJenisPegawai').combobox('setValue',row.JENIS_PEGAWAI_ID);
        $('#inputGolongan').combobox('setValue',row.GOLONGAN_ID);
        $('#inputGolongan').combobox('disable');
        $('#inputUnor').combobox('setValue',row.UNOR_ID);
        $('#inputUnor').combobox('disable');
        $('#inputNoSKCPns').textbox('setValue',row.NO_SK_CPNS);
        $('#inputTanggalSKCpns').datebox('setValue',row.TANGGAL_SK_CPNS_EDIT);
        $('#inputTMTSKCpns').datebox('setValue',row.TMT_SK_CPNS_EDIT);
        $('#inputTMTSPCpns').datebox('setValue',row.TMT_SPMT_CPNS_EDIT);
        $('#inputNoNpwp').textbox('setValue',row.NO_NPWP);
        $('#inputTanggalNpwp').datebox('setValue',row.TANGGAL_NPWP_EDIT);
        $('#inputNoBpjs').textbox('setValue',row.NO_BPJS);
        $('#inputStatusKepemilikanRumah').combobox('setValue',row.STATUS_KEPEMILIKAN_RUMAH);
        //$('#inputFoto').textbox('setValue',row.);
        $('#inputFoto').filebox('clear');
        if( row.PHOTO ){
            var photoPlacement = '<img src="'+_BASE_URL_JS+row.PHOTO_URL+'" width="50" />';
            $('.photo-placement').html(photoPlacement);
            $('#photoEdited').val(row.PHOTO);
        }
        $('#dialogAddPegawai').dialog('open').dialog('setTitle','Ubah data pegawai');
    }
}

</script>
<?php
$this->load->view('pegawai/layout_add');
$this->load->view('pegawai/layout_detail');
$this->load->view('pegawai/layout_riwayat');
$this->load->view('pegawai/layout_form_riwayat');
?>