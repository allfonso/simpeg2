<table id="grid_rekap_per_pendidikan" class="easyui-datagrid" data-options="rownumbers:true,toolbar:'#grid_toolbar_per_pendidikan',url:'<?=site_url('rekap/load_rekap_per_pendidikan')?>',showFooter: true" width="150%">
	<thead>
		<tr>
			<th colspan="23"><b>REKAPITULASI JUMLAH PNS PER PENDIDIKAN DAN JENIS KELAMIN PEMERINTAH PROVINSI DIY KEADAAN BULAN : <?=$bulan?></b></th>
		</tr>
		<tr>
			<th field="UNOR" rowspan="2">UNOR</th>
			<th colspan="10">LAKI LAKI</th>
			<th rowspan="2" field="L_TOTAL">TOTAL</th>
			<th colspan="10">PEREMPUAN</th>
			<th rowspan="2" field="P_TOTAL">TOTAL</th>
		</tr>
		<tr>
			<th field="L_SD">SD</th>
			<th field="L_SMP">SMP</th>
			<!-- <th field="L_SMPK">SMPK</th> -->
			<th field="L_SMA">SMA</th>
			<!-- <th field="L_SMAKJ">SMAKJ</th>
			<th field="L_SMAKG">SMAKG</th> -->
			<th field="L_D1">D1</th>
			<th field="L_D2">D2</th>
			<th field="L_D3">D3</th>
			<th field="L_D4">D4</th>
			<th field="L_S1">S1</th>
			<th field="L_S2">S2</th>
			<th field="L_S3">S3</th>
			<th field="P_SD">SD</th>
			<th field="P_SMP">SMP</th>
			<!-- <th field="P_SMPK">SMPK</th> -->
			<th field="P_SMA">SMA</th>
			<!-- <th field="P_SMAKJ">SMAKJ</th>
			<th field="P_SMAKG">SMAKG</th> -->
			<th field="P_D1">D1</th>
			<th field="P_D2">D2</th>
			<th field="P_D3">D3</th>
			<th field="P_D4">D4</th>
			<th field="P_S1">S1</th>
			<th field="P_S2">S2</th>
			<th field="P_S3">S3</th>

		</tr>
	</thead>
</table>

<div id="grid_toolbar_per_pendidikan">
<a href="#" class="easyui-linkbutton" onclick="exportPerPendidikan()" iconCls="icon-export-excel" class="toolbar">Export ke Excel</a>
</div>

<script type="text/javascript">
function exportPerPendidikan()
{
	var url_download = '<?=site_url('rekap/export_per_pendidikan')?>';
	download_excel(url_download);
}
</script>