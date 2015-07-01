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
<div id="dlg" class="easyui-dialog" title="Sistem Informasi Kepegawaian" data-options="iconCls:'icon-lock',closable:false,draggable:false" style="width:550px;">
	<form id="loginapp" method="post" action="<?=site_url('login/auth')?>" class="easyui-form" data-options="novalidate:true">
		<div id="ctnt" class="easyui-layout" style="width:100%;height:250px;">
		    <div data-options="region:'south',split:false" style="height:60px;">
		    	<div id="footer-login">SISTEM INFORMASI KEPEGAWAIAN<br>Badan Kepegawaian Daerah Daerah Istimewa Yogyakarta</div>
		    </div>
		    <div data-options="region:'west',split:false" style="width:180px;">
		    	<div id="logo-login">
		    	<img src="<?=asset_url('img/logo.png')?>" style="height:130px;" />
		    	</div>
		    </div>
		    <div data-options="region:'center',split:false">
		    	<div id="title-tab" class="easyui-tabs" style="width:100%;height:189px;">
				    <div title="Login" style="padding:20px">
				        <table width="100%" border="0">
				        	<tr>
					        	<td width="25%">User ID</td>
					        	<td width="75%">
					        		: <input class="easyui-textbox" type="text" name="username" id="username" data-options="required:true" />
					        	</td>
				        	</tr>
				        	<tr>
					        	<td>Password</td>
					        	<td>
					        		: <input class="easyui-textbox" type="password" name="password" id="password" data-options="required:true" />
					        	</td>
				        	</tr>
				        	<tr>
					        	<td>&nbsp;</td>
					        	<td><br>
					        		<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-lock'">Login</a>
					        	</td>
				        	</tr>
				        </table>
				    </div>				    
				</div>
		    </div>
		</div>
	</form>
</div>
	<script>
		$(document).ready(function(){
			$('#ctnt').layout();
			$('#title-tab').tabs();

			$('.textbox-text').on('keyup',function(e){
				if(e.keyCode == 13){
					submitForm();
					return false;
				}
				e.preventDefault();				
			});

		});


		function submitForm()
		{
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