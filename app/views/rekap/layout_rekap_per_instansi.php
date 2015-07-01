<table id="grid_rekap_per_instansi" style="width:100%" class="easyui-datagrid" data-options="rownumbers:true,toolbar:'#grid_toolbar',url:'<?=site_url('rekap/load_rekap_per_instansi')?>',showFooter: true" width="100%">
	<thead>
		<tr>
			<th colspan="3"><b>REKAPITULASI JUMLAH PNS PER INSTANSI PEMERINTAH PROVINSI DIY KEADAAN BULAN : <?=$bulan?></b></th>
		</tr>
		<tr>
			<th field="UNOR" width="50%">UNOR</th>
			<th field="TOTAL_LAKI_LAKI" width="20%">LAKI-LAKI</th>
			<th field="TOTAL_PEREMPUAN" width="20%">PEREMPUAN</th>
		</tr>
	</thead>
</table>

<div id="grid_toolbar">
<a href="#" class="easyui-linkbutton" onclick="exportPerInstansi()" iconCls="icon-export-excel" class="toolbar">Export ke Excel</a>
</div>

<script type="text/javascript">
function exportPerInstansi()
{
	var url_download = '<?=site_url('rekap/export_per_instansi')?>';
	download_excel(url_download);
}
</script>