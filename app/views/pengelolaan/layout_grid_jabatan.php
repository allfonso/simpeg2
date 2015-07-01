<div id="pengelolaan_grid_jabatan_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addJabatan()">Tambah Jabatan</a>
    <a class="easyui-linkbutton" iconCls="icon-edit" href="#" onclick="editJabatan()">Edit Jabatan</a>
    <a class="easyui-linkbutton" iconCls="icon-remove" href="#" onclick="deleteJabatan()">Hapus</a>
    <a class="easyui-linkbutton" iconCls="icon-reload" href="#" onclick="load_data_jabatan()">Refresh</a>

    <hr>
    <form method="post" action="" id="formSearchTugasBelajar">
        <table width="100%" border="0">
        <tr>
            <td width="20%">Jabatan</td>
            <td width="80%"> : <input type="text" class="easyui-textbox" id="search_jabatan" name="search_jabatan" style="width:400px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariJabatan()">Cari</a></td>
        </tr>
        </table>
    </form>
</div>


<table id="gridPengelolaanJabatan">
    <thead>
        <th field="ID" width="">ID</th>
        <th field="NAMA_JENJANG_JABATAN" width="">Jenjang Pendidikan</th>
        <th field="JURUSAN" width="">Jurusan</th>
        <th field="JENIS_JABATAN" width="">Universitas</th>        
    </thead>
    <tbody>

    </tbody>
</table>

<script type="text/javascript">
var url_data = '<?=site_url('pengelolaan/get_data_jenjang_jabatan')?>';
$(document).ready(function(){   
    
    $('#gridPengelolaanJabatan').datagrid({
        url: url_data,        
        method: 'post',
        title: 'Data Jabatan',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: false,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'ID',title:'ID',width:5},
            {field:'NAMA_JENJANG_JABATAN',title:'NAMA JABATAN',width:60},
            {field:'JENIS_JABATAN',title:'JENIS JABATAN',width:60},           
        ]],
        toolbar:'#pengelolaan_grid_jabatan_toolbar'

    });
    
});

function cariJabatan(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_jabatan = $('#search_jabatan').textbox('getValue');
      
        $('#gridPengelolaanJabatan').datagrid({
            url: url_data,
            queryParams:{
                jabatan:search_jabatan,               
            },
            method: 'post',
            title: 'Data Jabatan',
            iconCls: 'icon-people',
            pagination:true,
            rownumbers: false,
            width: '100%',
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            columns:[[
                {field:'ID',title:'ID',width:5},
            {field:'NAMA_JENJANG_JABATAN',title:'NAMA JABATAN',width:60},
            {field:'JENIS_JABATAN',title:'JENIS JABATAN',width:60},
            ]],
            toolbar:'#pengelolaan_grid_jabatan_toolbar'

        });
    }

}

function load_data_jabatan()
{
    $('#formSearchTugasBelajar').form('clear');
    var url_data = url_data;

     $('#gridPengelolaanJabatan').datagrid({
        url: url_data, 
        queryParams:{
                jabatan:'',               
            },       
        method: 'post',
        title: 'Data Jabatan',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: false,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'ID',title:'ID',width:5},
            {field:'NAMA_JENJANG_JABATAN',title:'NAMA JABATAN',width:60},
            {field:'JENIS_JABATAN',title:'JENIS JABATAN',width:60},           
        ]],
        toolbar:'#pengelolaan_grid_jabatan_toolbar'

    });
}

function exportTugasBelajar()
{
    console.log($("#formSearchTugasBelajar").serialize());
}

</script>

<?php
$this->load->view('pengelolaan/layout_add_jabatan');
$this->load->view('pengelolaan/layout_edit_jabatan');
$this->load->view('pengelolaan/layout_delete_jabatan');
?>