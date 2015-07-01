<div id="dialogAddIjinBelajarDetailLn" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogAddIjinBelajarDetailLn-buttons" data-options="iconCls:'icon-user'">
    <form id="formDetailAddIjinLuarNegeri" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
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
                    <td>Tanggal Keberangkatan</td>
                    <td>: <input name="inputTglkeberangkatan" required id="inputTglkeberangkatan" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Pulang</td>
                    <td>: <input name="inputTglPulang" required id="inputTglPulang" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tujuan Negara</td>
                    <td>: <input name="inputTujuanNegara" required id="inputTujuanNegara" class="easyui-textbox" size="30">
                    <input type="hidden" name="current_ln_nip" id="current_detail_ln_nip" value="" /></td>
                </tr>
            </table>
        </div>      
    </form>
</div>
<div id="dialogAddIjinBelajarDetailLn-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanIjinBelajarDetailLn" onclick="simpanIjinBelajarDetailLn()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogAddIjinBelajarDetailLn').dialog('close')" style="width:90px">Cancel</a>
</div>

<!-- edit ijin belajar -->
<div id="dialogEditIjinBelajarDetailLn" class="easyui-dialog" style="width:600px;height:400px" closed="true" buttons="#dialogEditIjinBelajarDetailLn-buttons" data-options="iconCls:'icon-user'">
    <form id="formDetailEditIjinBelajarLn" method="post"  class="easyui-form" data-options="novalidate:true" enctype="multipart/form-data">
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
                    <td>Tanggal Keberangkatan</td>
                    <td>: <input name="inputTglkeberangkatan" required id="inputTglkeberangkatanEdit" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Tanggal Pulang</td>
                    <td>: <input name="inputTglPulang" required id="inputTglPulangEdit" class="easyui-datebox" data-options="formatter:date_format,parser:date_parser" size="15"></td>
                </tr>
                <tr>
                    <td>Universitas</td>
                    <td>: <input name="inputTujuanNegara" required id="inputTujuanNegaraEdit" class="easyui-textbox" size="30">
                        <input type="hidden" name="current_ijin_id_ln" id="current_ijin_id_ln" value="" />
                    </td>
                </tr>
            </table>
        </div>      
    </form>
</div>
<div id="dialogEditIjinBelajarDetailLn-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-save" id="simpanEditIjinBelajarDetailLn" onclick="simpanEditIjinBelajarDetailLn()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialogEditIjinBelajarDetailLn').dialog('close')" style="width:90px">Cancel</a>
</div>