<table id="grid_rekap_per_agama" class="easyui-datagrid" data-options="rownumbers:true,toolbar:'#grid_toolbar_per_agama',url:'<?=site_url('rekap/load_rekap_per_agama')?>',showFooter: true" width="110%">
	<thead>
		<tr>
			<th colspan="15"><b>REKAPITULASI JUMLAH PNS PER AGAMA DAN JENIS KELAMIN PEMERINTAH PROVINSI DIY KEADAAN BULAN : <?=$bulan?></b></th>
		</tr>
		<tr>
			<th field="UNOR" rowspan="2">UNOR</th>
			<th colspan="6">LAKI LAKI</th>
			<th rowspan="2" field="L_TOTAL">TOTAL</th>
			<th colspan="6">PEREMPUAN</th>
			<th rowspan="2" field="P_TOTAL">TOTAL</th>
		</tr>
		<tr>
			<th field="L_ISLAM" align="center">ISLAM</th>
			<th field="L_KRISTEN" align="center">KRISTEN</th>
			<th field="L_KATHOLIK" align="center">KATHOLIK</th>
			<th field="L_HINDU" align="center">HINDU</th>
			<th field="L_BUDHA" align="center">BUDHA</th>
			<th field="L_LAINYA" align="center">LAINYA</th>
			<th field="P_ISLAM" align="center">ISLAM</th>
			<th field="P_KRISTEN" align="center">KRISTEN</th>
			<th field="P_KATHOLIK" align="center">KATHOLIK</th>
			<th field="P_HINDU" align="center">HINDU</th>
			<th field="P_BUDHA" align="center">BUDHA</th>
			<th field="P_LAINYA" align="center">LAINYA</th>
		</tr>
	</thead>
</table>

<div id="grid_toolbar_per_agama">
<a href="#" class="easyui-linkbutton" onclick="exportPerInstansi()" iconCls="icon-export-excel" class="toolbar">Export ke Excel</a>
</div>

<script type="text/javascript">
function exportPerInstansi()
{
	var url_download = '<?=site_url('rekap/export_per_agama')?>';
	download_excel(url_download);
}
</script>