<div id="pengelolaan_grid_pendidikan_toolbar">
    <a class="easyui-linkbutton" iconCls="icon-add" href="#" onclick="addPendidikan()">Tambah Jabatan</a>
    <a class="easyui-linkbutton" iconCls="icon-edit" href="#" onclick="editPendidikan()">Edit Jabatan</a>
    <a class="easyui-linkbutton" iconCls="icon-remove" href="#" onclick="deletePendidikan()">Hapus</a>
    <a class="easyui-linkbutton" iconCls="icon-reload" href="#" onclick="load_data_pendidikan()">Refresh</a>

    <hr>
    <form method="post" action="" id="formSearchPendidikan">
        <table width="100%" border="0">
        <tr>
            <td width="20%">Nama Pendidikan</td>
            <td width="80%"> : <input type="text" class="easyui-textbox" id="search_pendidikan" name="search_pendidikan" style="width:400px"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" iconCls="icon-search" href="#" onclick="cariPendidikan()">Cari</a></td>
        </tr>
        </table>
    </form>
</div>


<table id="gridPengelolaanPendidikan">
    <thead>
        <th field="PENDIDIKAN_ID" width="">ID</th>
        <th field="TINGKAT_PENDIDIKAN_NAMA" width="">Tingkat Pendidikan</th>
        <th field="PENDIDIKAN_NAMA" width="">Nama Pendidikan</th>       
    </thead>
    <tbody>

    </tbody>
</table>

<script type="text/javascript">
var url_data = '<?=site_url('pengelolaan/get_data_pendidikan')?>';
$(document).ready(function(){   
    
    $('#gridPengelolaanPendidikan').datagrid({
        url: url_data,        
        method: 'post',
        title: 'Data Pendidikan',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: false,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'PENDIDIKAN_ID',title:'ID',width:20},
            {field:'TINGKAT_PENDIDIKAN_NAMA',title:'TINGKAT PENDIDIKAN',width:60},
            {field:'PENDIDIKAN_NAMA',title:'NAMA PENDIDIKAN',width:60},           
        ]],
        toolbar:'#pengelolaan_grid_pendidikan_toolbar'

    });
    
});

function cariPendidikan(value,name)
{
    if( value == '' ){
        info('Info','Silahkan masukkan kata kunci pencarian.');
        return false;
    }else{

        var search_pendidikan = $('#search_pendidikan').textbox('getValue');
      
        $('#gridPengelolaanPendidikan').datagrid({
            url: url_data,
            queryParams:{
                pendidikan:search_pendidikan,               
            },
            method: 'post',
            title: 'Data Pendidikan',
            iconCls: 'icon-people',
            pagination:true,
            rownumbers: false,
            width: '100%',
            height: 'auto',
            fitColumns: true,
            singleSelect: true,
            columns:[[
                {field:'PENDIDIKAN_ID',title:'ID',width:20},
                {field:'TINGKAT_PENDIDIKAN_NAMA',title:'TINGKAT PENDIDIKAN',width:60},
                {field:'PENDIDIKAN_NAMA',title:'NAMA PENDIDIKAN',width:60},
            ]],
            toolbar:'#pengelolaan_grid_pendidikan_toolbar'

        });
    }

}

function load_data_pendidikan()
{
    $('#formSearchPendidikan').form('clear');
    var url_data = url_data;

     $('#gridPengelolaanPendidikan').datagrid({
        url: url_data, 
        queryParams:{
                pendidikan:'',               
            },       
        method: 'post',
        title: 'Data Pendidikan',
        iconCls: 'icon-people',
        pagination:true,
        rownumbers: false,
        width: '100%',
        height: 'auto',
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'PENDIDIKAN_ID',title:'ID',width:20},
            {field:'TINGKAT_PENDIDIKAN_NAMA',title:'TINGKAT PENDIDIKAN',width:60},
            {field:'PENDIDIKAN_NAMA',title:'NAMA PENDIDIKAN',width:60},           
        ]],
        toolbar:'#pengelolaan_grid_pendidikan_toolbar'

    });
}

function exportTugasBelajar()
{
    console.log($("#formSearchPendidikan").serialize());
}

</script>

<?php
$this->load->view('pengelolaan/layout_add_pendidikan');
$this->load->view('pengelolaan/layout_edit_pendidikan');
$this->load->view('pengelolaan/layout_delete_pendidikan');
?>