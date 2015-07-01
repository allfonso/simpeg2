<table id="grid_rekap_per_golongan" class="easyui-datagrid" data-options="rownumbers:true,toolbar:'#grid_toolbar_per_golongan',url:'<?=site_url('rekap/load_rekap_per_golongan')?>',showFooter: true" width="120%">
	<thead>
		<tr>
			<th colspan="11"><b>REKAPITULASI JUMLAH PNS PER GOLONGAN DAN JENIS KELAMIN PEMERINTAH PROVINSI DIY KEADAAN BULAN : <?=$bulan?></b></th>
		</tr>
		<tr>
			<th field="UNOR" rowspan="2">UNOR</th>
			<th colspan="4">LAKI LAKI</th>
			<th rowspan="2" field="L_TOTAL">TOTAL</th>
			<th colspan="4">PEREMPUAN</th>
			<th rowspan="2" field="P_TOTAL">TOTAL</th>
		</tr>
		<tr>
			<th field="L_GOLONGAN_I" align="center">GOLONGAN I</th>
			<th field="L_GOLONGAN_II" align="center">GOLONGAN II</th>
			<th field="L_GOLONGAN_III" align="center">GOLONGAN III</th>
			<th field="L_GOLONGAN_IV" align="center">GOLONGAN IV</th>
			<th field="P_GOLONGAN_I" align="center">GOLONGAN I</th>
			<th field="P_GOLONGAN_II" align="center">GOLONGAN II</th>
			<th field="P_GOLONGAN_III" align="center">GOLONGAN III</th>
			<th field="P_GOLONGAN_IV" align="center">GOLONGAN IV</th>
		</tr>
	</thead>
</table>

<div id="grid_toolbar_per_golongan">
<a href="#" class="easyui-linkbutton" onclick="exportPerGolongan()" iconCls="icon-export-excel" class="toolbar">Export ke Excel</a>
</div>

<script type="text/javascript">
function exportPerGolongan()
{
	var url_download = '<?=site_url('rekap/export_per_golongan')?>';
	download_excel(url_download);
}
</script>