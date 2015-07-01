<div id="dialogDeleteJabatan" class="easyui-dialog" style="width:700px;height:500px" closed="true" buttons="#dialogDeleteJabatan-buttons" data-options="iconCls:'icon-user'">
	<table id="gridDeletePengelolaanJabatan">
    	
	</table>
</div>

<script type="text/javascript">
	function deleteJabatan()
	{
		var row = $('#gridPengelolaanJabatan').datagrid('getSelected');
		
	    if( !row ){
	        error('Error!','Silahkan pilih jabatan');
	    }else{
	    	var idjab = row.ID;
			var namajabatan = row.NAMA_JENJANG_JABATAN;
			$.messager.confirm('Konfirmasi','Apakah Andaa yakin ingin hapus data ini?',function(r){
				if (r){
					$.post('<?=site_url('pengelolaan/delete_jabatan')?>',{idjab:idjab},function(result){
						if (result.status == 1){
							success('Success',result.msg);	
							load_data_jabatan();						
						} else {							
							loadDataJabatan(idjab,namajabatan);
							error('Error',result.msg);
						}
					},'json');
				}
			});
			
		}
	}

	function loadDataJabatan(idjab,namajabatan)
	{
		var url_data = '<?=site_url('pengelolaan/get_data_delete_jabatan')?>';

		$('#dialogDeleteJabatan').dialog('open').dialog('setTitle','Data Pegawai Jabatan '+namajabatan);
	    $('#gridDeletePengelolaanJabatan').datagrid({
	        url: url_data, 
	        queryParams:{
	                idjab:idjab,               
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