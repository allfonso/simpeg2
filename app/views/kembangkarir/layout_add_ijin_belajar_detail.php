<div id="dialogAddIjinBelajarDetail" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinBelajarDetail-buttons" data-options="iconCls:'icon-user'">
    <form id="formDetailAddIjinBelajar" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
        <div title="Data utama" style="padding:10px">
            <table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td width="40%">NIP</td>
                    <td width="60%">: <span id="inputNip"></span></td>
                </tr>
                <tr>
                    <td>NIP Lama</td>
                    <td>: <span id="inputNipLama"></span></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: <span id="inputNama"></span></td>
                </tr>
                <tr>
                    <td>No. Surat Ijin Belajar</td>
                    <td>: <input name="inputNoSuratIjinBelajar" required id="dialogAddIjinBelajarDetail" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal Mulai Ijin Belajar</td>
                    <td>: <input name="inputTglMulaiIjinBelajar" required id="inputTglMulaiIjinBelajar" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai Ijin Belajar</td>
                    <td>: <input name="inputTglSelesaiIjinBelajar" required id="inputTglSelesaiIjinBelajar" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Jenjang Pendidikan</td>
                    <td>: <input class="easyui-combobox" required name="jenjang_didik_id" id="jenjang_didik_id" data-options="url:'<?=site_url('referensi/load_jenjang_didik')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>: <input name="inputJurusan" required id="inputJurusan" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Universitas</td>
                    <td>: <input class="easyui-combobox" required name="inputUniversitas" id="inputUniversitas" data-options="url:'<?=site_url('kembangkarir/load_universitas')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
                    <input type="hidden" name="current_ijin_nip" id="current_detail_nip" value="" />
                    </td>
                </tr>
            </table>
        </div>      
    </form>
</div>
<div id="dialogAddIjinBelajarDetail-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanIjinBelajarDetail" onclick="simpanIjinBelajarDetail()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddIjinBelajarDetail').dialog('close')" style="width:90px">Cancel</a>
</div>

<!-- edit ijin belajar -->
<div id="dialogEditIjinBelajarDetail" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogEditIjinBelajarDetail-buttons" data-options="iconCls:'icon-user'">
    <form id="formDetailEditIjinBelajar" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
        <div title="Data utama" style="padding:10px">
            <table cellpadding="0" cellspacing="2" border="0">
                <tr>
                    <td width="40%">NIP</td>
                    <td width="60%">: <span id="inputNipEdit"></span></td>
                </tr>
                <tr>
                    <td>NIP Lama</td>
                    <td>: <span id="inputNipLamaEdit"></span></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: <span id="inputNamaEdit"></span></td>
                </tr>
                <tr>
                    <td>No. Surat Ijin Belajar</td>
                    <td>: <input name="inputNoSuratIjinBelajar" required id="inputNoSuratIjinBelajarEdit" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Tanggal Mulai Ijin Belajar</td>
                    <td>: <input name="inputTglMulaiIjinBelajar" required id="inputTglMulaiIjinBelajarEdit" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai Ijin Belajar</td>
                    <td>: <input name="inputTglSelesaiIjinBelajar" required id="inputTglSelesaiIjinBelajarEdit" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Jenjang Pendidikan</td>
                    <td>: <input class="easyui-combobox" required name="jenjang_didik_id" id="jenjang_didik_idEdit" data-options="url:'<?=site_url('referensi/load_jenjang_didik')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px"></td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>: <input name="inputJurusan" required id="inputJurusanEdit" class="easyui-textbox" size="30"></td>
                </tr>
                <tr>
                    <td>Universitas</td>
                    <td>:
                        <input class="easyui-combobox" required name="inputUniversitas" id="inputUniversitasEdit" data-options="url:'<?=site_url('kembangkarir/load_universitas')?>', valueField:'id', textField:'text',panelHeight:'150px'" style="width:250px">
                        <input type="hidden" name="current_ijin_id" id="current_ijin_id" value="" />
                    </td>
                </tr>
            </table>
        </div>      
    </form>
</div>
<div id="dialogEditIjinBelajarDetail-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanEditIjinBelajarDetail" onclick="simpanEditIjinBelajarDetail()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditIjinBelajarDetail').dialog('close')" style="width:90px">Cancel</a>
</div>