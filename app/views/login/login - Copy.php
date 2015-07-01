<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Sistem Informasi Kepegawaian | Badan Kepegawaian Daerah Propinsi Yogyakarta</title>
	<link rel="stylesheet" type="text/css" href="<?=easyui('themes/default/easyui.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=easyui('themes/icon.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=asset_url('css/style.css')?>">
	<script type="text/javascript" src="<?=easyui('jquery.min.js')?>"></script>
	<script type="text/javascript" src="<?=easyui('jquery.easyui.min.js')?>"></script>
	<script type="text/javascript" src="<?=asset_url('js/application.js')?>"></script>
</head>
<body>
	<div id="dlg" class="easyui-dialog" title="Login Aplikasi" data-options="iconCls:'icon-lock',closable:false,draggable:false" style="width:500px;height:auto;padding:10px">
		<form id="loginapp" method="post" action="<?=site_url('login/auth')?>" class="easyui-form" data-options="novalidate:true">
			<div style="text-align:center">
				
				<img src="<?=asset_url('img/logo.png')?>" style="height:150px;" />
				<div style="font-weight:bold;font-size:15px">SISTEM INFORMASI KEPEGAWAIAN</div>
				<div><h3 style="font-size:12px;">BADAN KEPEGAWAIAN DAERAH PROPINSI YOGYAKARTA</h3></div>
				
			</div>
	    	<table cellpadding="5" width="100%">
	    		<tr>
	    			<td width="40%">User ID:</td>
	    			<td width="60%"><input class="easyui-textbox" type="text" name="username" data-options="required:true"></input></td>
	    		</tr>
	    		<tr>
	    			<td>Password:</td>
	    			<td><input class="easyui-textbox" type="password" name="password" data-options="required:true"></input></td>
	    		</tr>
	    		
	    	</table>
	    </form>
	    <div style="text-align:center;padding:5px">
	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-lock'">Login</a>
	    </div>
	</div>
	<script>
		function submitForm(){
			$('#loginapp').form('submit',{
				onSubmit:function(){
					var validation = $(this).form('enableValidation').form('validate');
					if( validation == true )
					{
						var username = $('input[name="username"]').val();
						var password = $('input[name="password"]').val();
						$.ajax({
							url:"<?php echo site_url('login/auth'); ?>",
							type:'post',
							dataType:'json',
							data:{username:username,password:password},
							success : function(response){
								if( response.status == 0 ){
									error('Login gagal',response.msg);
								}else{
									success('Login berhasil',response.msg);
									if(response.redirect){
										document.location.href=response.redirect;
									}
								}
							}
						});
					}
				}
			});
		}
	</script>
</body>
</html>