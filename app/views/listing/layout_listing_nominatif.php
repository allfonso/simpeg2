<table width="100%" id="listing-nominatif" class="easyui-treegrid" data-options="
				url: '<?=site_url('listing/load_data_listing')?>',
				idField: 'id',
				treeField: 'name',
				lines: true,
				collapsible: true,
				animate: true,
				fitColumns: true
			">
	<thead>
		<tr>
			<th data-options="field:'name'">NAMA UNOR</th>
		</tr>
	</thead>
</table>

<div title="Data DUK" class="easyui-dialog" id="dialog-listing-nominatif" style="width:90%;height:600px;" closed="true">
	<table class="easyui-datagrid" id="grid-listing-nominatif" data-options="toolbar:'#toolbar-grid-listing-nominatif'" width="100%">
		<thead>
			<tr>
				<th field="NIP_LAMA" >NIP LAMA</th>
				<th field="NIP" >NIP BARU</th>
				<th field="NAMA" >NAMA</th>				
				<th field="TTL" >TEMPAT, TANGGAL LAHIR</th>
				<th field="PANGKAT" >PANGKAT</th>
				<th field="GOLONGAN" >GOLONGAN</th>
				<th field="TMT_GOLONGAN" >TMT GOLONGAN</th>
				<th field="JABATAN" >JABATAN</th>
				<th field="UNIT" >UNIT</th>
				<th field="SUB_UNIT" >SUB UNIT</th>
			</tr>
		</thead>
	</table>
</div>

<div id="toolbar-grid-listing-nominatif">
<a class="easyui-linkbutton" href="#" onclick="exportDukToExcel()" iconCls="icon-man">Export ke Excel</a>
</div>

<script type="text/javascript">
	var param_url = '';
	$(document).ready(function(){
		var url = '<?=site_url('listing/load_data_nominatif')?>';
		$('#listing-nominatif').treegrid({
			onSelect:function(row){
				$('#grid-listing-nominatif').datagrid({
					url: url+'/'+row.url
				});
				$('#dialog-listing-nominatif').dialog('open');
				param_url = row.url;
			}
		});
	});

	function exportDukToExcel()
	{	    
		var url_download = '<?=site_url('listing/export_nominatif')?>';
		var params = 'params='+param_url
		download_excel(url_download,params);
	}

</script>