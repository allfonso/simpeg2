<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Sistem Informasi Kepegawaian | Badan Kepegawaian Daerah Propinsi Yogyakarta</title>
	<link rel="stylesheet" type="text/css" href="<?=easyui('themes/default/easyui.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=easyui('themes/icon.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=asset_url('css/style.css')?>">
	<!--<script type="text/javascript" src="<?=easyui('jquery.min.js')?>"></script>-->
	<script src="<?=asset_url('js/jquery-1.7.min.js')?>"></script>
	<script type="text/javascript" src="<?=easyui('jquery.easyui.min.js')?>"></script>
	<script type="text/javascript" src="<?=asset_url('js/application.js')?>"></script>
	<script type="text/javascript" src="<?=asset_url('js/jquery.form.js')?>"></script>
	<script type="text/javascript" src="<?=asset_url('js/jquery.validate.js')?>"></script>
	<script type="text/javascript" src="<?=asset_url('js/jquery.file_download.js')?>"></script>

	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=asset_url('css/style_custom.css')?>">

	<link rel="stylesheet" href="<?=asset_url('css/kategori.css')?>">
	<script src="<?=asset_url('js/jquery-ui-1.8.16.custom.min.js')?>"></script>
	<script src="<?=asset_url('js/jquery.mjs.nestedSortable.js')?>"></script>
	<script>
   		var _BASE_URL_JS = '<?=site_url()?>';
    </script>
</head>
<body class="easyui-layout">
	<div data-options="region:'north',border:false" style="height:50px;background:none;padding:0px">
		<img src="<?=asset_url('img/logo-simpeg.png')?>" height="47">
		<span class="right">
			<span class="logout">
				<a class="easyui-linkbutton logoutbutton" iconCls="icon-logout" href="<?=site_url('main/logout')?>">LOGOUT</a>
			</span>			
		</span>
	</div>

	<div id="paneltools">
		<span id="timer"></span>
	</div>

	<div data-options="region:'west',split:true,title:'Menu'" style="width:250px;padding:2px;">
	<div class="easyui-accordion">
			<div title="Main menu" data-options="iconCls:'icon-help'" style="padding:10px;">
				<ul class="easyui-tree" data-options="url:'<?php echo site_url('main/menu') ?>',method:'get',animate:true,lines:true" id="mainenutree"></ul>
			</div>
			<div title="Help" data-options="iconCls:'icon-help'" style="padding:10px;">
				<ul class="easyui-tree" data-options="url:'<?php echo site_url('main/access') ?>',method:'get',animate:true,lines:true" id="accesstree"></ul>
			</div>
		</div>
	</div>
	<div data-options="region:'center',title:'Center',tools:'#paneltools'">
		<div class="easyui-tabs" id="tabs" fit="true" border="false" class="tabcontent">
			<div title="Selamat Datang">
				<div>
                	Welcomesds
                </div>
			</div>
		</div>
	</div>

	<div data-options="region:'south'" style="height:30px;">
		<div class="footertext">Badan Kepegawaian Daerah Daerah Istimewa Yogyakarta</div>
	</div>

</body>
</html>

<script type="text/javascript">
	function tanggalSekarang()
	{
		tday  =new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		tmonth=new Array("January","February","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
		d = new Date();
		nday   = d.getDay();
		nmonth = d.getMonth();
		ndate  = d.getDate();
		nyear  = d.getFullYear();
		nhour  = d.getHours();
		nmin   = d.getMinutes();
		nsec   = d.getSeconds();

		if(nhour <= 9){
			nhour = "0" +nhour;
		}

		if(nmin <= 9){
			nmin = "0" +nmin;
		}

		if(nsec <= 9){
			nsec = "0" +nsec;
		}
		$('span#timer').html(tday[nday]+", "+ndate+" "+tmonth[nmonth]+" "+nyear+" "+nhour+":"+nmin+":"+nsec);
		setTimeout("tanggalSekarang()", 1000);

	}
	window.onload=tanggalSekarang;
	$('#mainenutree, #accesstree').tree({
		onClick: function (e) {					
			if ($('#mainmenutree,#accesstree').tree('isLeaf', e.target)) {
				if ($('#tabs').tabs('exists', e.text)) {
					$('#tabs').tabs('select', e.text);
					var name = e.text.toLowerCase();
					var url = e.url;					
					var tab = $('#tabs').tabs('getSelected');
					$('#tabs').tabs('update', {
						tab:tab,
						options:{
								title: e.text,
								closable:true,
								href:url						
							}
						
					});	
					
				} else {					
					var name = e.text.toLowerCase();
					var url = e.url;
					$('#tabs').tabs('add', {
						title: e.text,
						closable:true,
						href:url						
					});						
				}
			};
		}
	});
</script>