<div id="dialogDeletePendidikan" class="easyui-dialog" style="width:700px;height:500px" closed="true" buttons="#dialogDeletePendidikan-buttons" data-options="iconCls:'icon-user'">
	<table id="gridDeletePengelolaanPendidikan">
    	
	</table>
</div>

<script type="text/javascript">
	function deletePendidikan()
	{
		var row = $('#gridPengelolaanPendidikan').datagrid('getSelected');		
	    if( !row ){
	        error('Error!','Silahkan pilih unor');
	    }else{
	    	var iddidik = row.PENDIDIKAN_ID;
			var namadidik = row.PENDIDIKAN_NAMA;
			$.messager.confirm('Konfirmasi','Apakah Andaa yakin ingin hapus data ini?',function(r){
				if (r){
					$.post('<?=site_url('pengelolaan/delete_pendidikan')?>',{iddidik:iddidik},function(result){
						if (result.status == 1){
							success('Success',result.msg);	
							load_data_pendidikan();						
						} else {							
							loadDataPendidikan(iddidik,namadidik);
							error('Error',result.msg);
						}
					},'json');
				}
			});
			
		}
	}

	function loadDataPendidikan(iddidik,namadidik)
	{
		var url_data = '<?=site_url('pengelolaan/get_data_delete_pendidikan')?>';

		$('#dialogDeletePendidikan').dialog('open').dialog('setTitle','Data Pegawai Pendidikan '+namadidik);
	    $('#gridDeletePengelolaanPendidikan').datagrid({
	        url: url_data, 
	        queryParams:{
	                iddidik:iddidik,               
	            },       
	        method: 'post',	        
	        iconCls: 'icon-people',
	        pagination:true,
	        rownumbers: false,
	        width: '100%',
	        height: 'auto',
	        fitColumns: true,
	        singleSelect: true,
	        columns:[[	           
	            {field:'NIP',title:'NIP',width:60},
	            {field:'NAMA_PEGAWAI',title:'NAMA PEGAWAI',width:60},
	            {field:'ALAMAT',title:'ALAMAT',width:60}, 
	        ]],	        

	    });
	}
</script>
</script>