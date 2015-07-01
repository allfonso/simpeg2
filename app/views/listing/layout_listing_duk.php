<table width="100%" id="listing-duk" class="easyui-treegrid" data-options="
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

<div title="Data DUK" class="easyui-dialog" id="dialog-listing-duk" style="width:1000px;height:600px;" closed="true">
	<table class="easyui-datagrid" id="grid-listing-duk" data-options="toolbar:'#toolbar-grid-listing-duk'" width="100%">
		<thead>
			<tr>
				<th field="NIP_LAMA" width="10%">NIP LAMA</th>
				<th field="NIP" width="20%">NIP BARU</th>
				<th field="NAMA" width="20%">NAMA</th>
<!-- 			</tr>
		</thead>
		<thead>
			<tr> -->				
				<th field="TTL" width="20%">TEMPAT, TANGGAL LAHIR</th>
				<th field="PANGKAT" width="20%">PANGKAT</th>
				<th field="GOLONGAN" width="8%">GOLONGAN</th>
				<th field="TMT_GOLONGAN" width="10%">TMT GOLONGAN</th>
				<th field="JABATAN" width="20%">JABATAN</th>
				<th field="PENDIDIKAN" width="20%">PENDIDIKAN</th>
				<th field="MASA_KERJA" width="20%">MASA KERJA</th>
				<th field="UNIT" width="20%">UNIT</th>
				<th field="SUB_UNIT" width="20%">SUB UNIT</th>
			</tr>
		</thead>
	</table>
</div>

<div id="toolbar-grid-listing-duk">
<a class="easyui-linkbutton" href="#" onclick="exportDukToExcel()" iconCls="icon-man">Export ke Excel</a>
</div>

<script type="text/javascript">
	var param_url = '';
	$(document).ready(function(){
		var url = '<?=site_url('listing/load_data_duk')?>';
		$('#listing-duk').treegrid({
			onSelect:function(row){
				$('#grid-listing-duk').datagrid({
					url: url+'/'+row.url
				});
				$('#dialog-listing-duk').dialog('open');
				param_url = row.url;
			}
		});
	});

	function exportDukToExcel()
	{	    
		var url_download = '<?=site_url('listing/export_duk')?>';
		var params = 'params='+param_url
		download_excel(url_download,params);
	}

</script>