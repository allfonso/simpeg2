<table id="gridAgama" title="Data Referensi Agama" class="easyui-datagrid" style="width:100%;height:auto"
        url="<?=site_url('agama/load_data')?>"
        toolbar="#toolbar" pagination="true"
        iconCls="icon-people"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="agama_id" width="5">ID</th>
            <th field="agama_nama" width="50">NAMA AGAMA</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addAgama()">Tambah</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAgama()">Edit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteAgama()">Hapus</a>
</div>

<?php include "form.php"; ?>