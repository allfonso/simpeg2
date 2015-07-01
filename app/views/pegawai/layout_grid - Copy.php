<table id="gridPegawai" title="Data Pegawai" class="easyui-datagrid" style="width:100%;height:auto"
        url="<?=site_url('pegawai/get_data_pegawai')?>"
        toolbar="#toolbar" pagination="true"
        iconCls="icon-people"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="NIP" width="30">NIP</th>
            <th field="NAMA" width="50">NAMA PEGAWAI</th>
            <th field="GOLONGAN" width="20">GOLONGAN</th>
            <th field="INSTANSI" width="50">INSTANSI</th>
            <th field="JABATAN" width="50">JABATAN</th>
            
        </tr>
    </thead>
</table>
<div id="toolbar">
    <div class="easyui-panel padding2px">
        <div class="left">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addPegawai()">Tambah pegawai</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPegawai()">Edit pegawai</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-user" plain="true" onclick="detailPegawai()">Detail pegawai</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deletePegawai()">Hapus pegawai</a>
        </div>
        <div class="right">
            <input type="text" name="inputNip" id="inputNip" class="easyui-textbox"/>
            <select id="inputType" name="inputType" class="easyui-combobox" data-options="panelHeight:'auto'">
                <option value="name">Nama</option>
                <option value="nip">NIP</option>
            </select>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="simpanPegawai()" iconCls="icon-search">Cari</a>
        </div>
        <div class="clear"></div>
    </div>    
    
</div>

<?php
$this->load->view('pegawai/layout_add');
$this->load->view('pegawai/layout_detail');
?>