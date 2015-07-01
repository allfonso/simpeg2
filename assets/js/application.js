function error( title, msg )
{
	$.messager.alert(title,msg,'error');
}

function success( title, msg )
{
	$.messager.alert(title,msg);
}

function info( title, msg )
{
	$.messager.alert(title,msg,'info');
}

function warning( title, msg )
{
	$.messager.alert(title,msg,'warning');
}

function date_format(date)
{
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
}

function date_parser(s)
{
	if (!s) return new Date();
	var ss = (s.split('-'));
	var y = parseInt(ss[0],10);
	var m = parseInt(ss[1],10);
	var d = parseInt(ss[2],10);
	if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
		return new Date(d,m-1,y);
	} else {
		return new Date();
	}
}

function resetForm( selector )
{
	var form = $(selector);
	form.find('input:text, input:password, input:file, select, textarea').val('');
	form.find('input:radio, input:checkbox').removeAttr('selected').removeAttr('checked');
}

function download_excel(url,param)
{
	var urldownload = url + "?" + param;
    $.fileDownload(urldownload, {
        preparingMessageHtml: '<div style="padding:10px">Sistem sedang memproses download datal. Silahkan tunggu sejenak</div>',
        failMessageHtml: '<div style="padding:10px">Terjadi kesalahan saat download data, silakan ulangi lagi.</div>',
        successCallback: function (url) {
           console.log("Sukses download file : "+url);
        },failCallback: function (html, url) {
           console.log(url);
        }
    });
}

$.fn.combobox.defaults.filter = function(q,row){
      var opts = $(this).combobox('options');
      return row[opts.textField].toUpperCase().indexOf(q.toUpperCase()) >= 0;
};