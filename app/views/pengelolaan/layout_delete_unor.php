<div id="dialogDeleteUnor" class="easyui-dialog" style="width:700px;height:500px" closed="true" buttons="#dialogDeleteUnor-buttons" data-options="iconCls:'icon-user'">
	<table id="gridDeletePengelolaanUnor">
    	
	</table>
</div>

<script type="text/javascript">
	function deleteUnor()
	{
		var row = $('#gridPengelolaanUnor').datagrid('getSelected');		
	    if( !row ){
	        error('Error!','Silahkan pilih unor');
	    }else{
	    	var idunor = row.ID;
			var namaunor = row.UNOR_NAMA;
			$.messager.confirm('Konfirmasi','Apakah Andaa yakin ingin hapus data ini?',function(r){
				if (r){
					$.post('<?=site_url('pengelolaan/delete_unor')?>',{idunor:idunor},function(result){
						if (result.status == 1){
							success('Success',result.msg);	
							load_data_unor();						
						} else {							
							loadDataUnor(idunor,namaunor);
							error('Error',result.msg);
						}
					},'json');
				}
			});
			
		}
	}

	function loadDataUnor(idunor,namaunor)
	{
		var url_data = '<?=site_url('pengelolaan/get_data_delete_unor')?>';

		$('#dialogDeleteUnor').dialog('open').dialog('setTitle','Data Pegawai Jabatan '+namaunor);
	    $('#gridDeletePengelolaanUnor').datagrid({
	        url: url_data, 
	        queryParams:{
	                idunor:idunor,               
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