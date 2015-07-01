<div id="pengelolaan_grid_unor_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addUnor()">Tambah Unor</a>
    <a class="easyui-linkbutton" iconCls="icon-edit" href="#" onclick="editUnor()">Edit Unor</a>
    <a class="easyui-linkbutton" iconCls="icon-remove" href="#" onclick="deleteUnor()">Hapus</a>
    <a class="easyui-linkbutton" iconCls="icon-reload" href="#" onclick="load_data_unor()">Refresh</a>

    <hr>
    <form method="post" action="" id="formSearchUnor">
        <table width="100%" border="0">
        <tr>
            <td width="20%">Nama Unor</td>
            <td width="80%"> : <input type="text" class="easyui-textbox" id="search_unor" name="search_unor" style="width:400px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariJabatan()">Cari</a></td>
        </tr>
        </table>
    </form>
</div>


<table id="gridPengelolaanUnor">
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
var url_data = '<?=site_url('pengelolaan/get_data_unor')?>';
$(document).ready(function(){   
    
    $('#gridPengelolaanUnor').datagrid({
        url: url_data,        
        method: 'post',
        title: 'Data Unor',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'ID',title:'ID',width:5},
            {field:'UNOR_NAMA',title:'NAMA UNOR',width:60},
            {field:'UNOR_NAMA_JABATAN',title:'NAMA JABATAN',width:60}, 
            {field:'INSTANSI_NAMA',title:'NAMA INSTANSI',width:60},          
        ]],
        toolbar:'#pengelolaan_grid_unor_toolbar'

    });
    
});

function cariJabatan(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_unor = $('#search_unor').textbox('getValue');
      
        $('#gridPengelolaanUnor').datagrid({
            url: url_data,
            queryParams:{
                unor:'',               
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
                {field:'UNOR_NAMA',title:'NAMA UNOR',width:60},
                {field:'UNOR_NAMA_JABATAN',title:'NAMA JABATAN',width:60}, 
                {field:'INSTANSI_NAMA',title:'NAMA INSTANSI',width:60},
            ]],
            toolbar:'#pengelolaan_grid_unor_toolbar'

        });
    }

}

function load_data_unor()
{
    $('#formSearchUnor').form('clear');
    var url_data = url_data;

    $('#gridPengelolaanUnor').datagrid({
        url: url_data,        
        method: 'post',
        title: 'Data Unor',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: true,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'ID',title:'ID',width:5},
            {field:'UNOR_NAMA',title:'NAMA UNOR',width:60},
            {field:'UNOR_NAMA_JABATAN',title:'NAMA JABATAN',width:60}, 
            {field:'INSTANSI_NAMA',title:'NAMA INSTANSI',width:60},          
        ]],
        toolbar:'#pengelolaan_grid_unor_toolbar'

    });
}

function exportTugasBelajar()
{
    console.log($("#formSearchUnor").serialize());
}

</script>

<?php
$this->load->view('pengelolaan/layout_add_unor');
$this->load->view('pengelolaan/layout_edit_unor');
$this->load->view('pengelolaan/layout_delete_unor');
?>