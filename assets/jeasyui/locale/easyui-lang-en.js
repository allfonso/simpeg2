if ($.fn.pagination){
	$.fn.pagination.defaults.beforePageText = 'Halaman';
	$.fn.pagination.defaults.afterPageText = 'dari {pages}';
	$.fn.pagination.defaults.displayMsg = 'Menampilkan {from} ke {to} dari {total} data';
}
if ($.fn.datagrid){
	$.fn.datagrid.defaults.loadMsg = 'Sedang memproses. Silahkan tunggu ...';
}
if ($.fn.treegrid && $.fn.datagrid){
	$.fn.treegrid.defaults.loadMsg = $.fn.datagrid.defaults.loadMsg;
}
if ($.messager){
	$.messager.defaults.ok = 'Ok';
	$.messager.defaults.cancel = 'Batal';
}
if ($.fn.validatebox){
	$.fn.validatebox.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
	$.fn.validatebox.defaults.rules.email.message = 'Masukkan alamat email yang valid.';
	$.fn.validatebox.defaults.rules.url.message = 'Please enter a valid URL.';
	$.fn.validatebox.defaults.rules.length.message = 'Please enter a value between {0} and {1}.';
	$.fn.validatebox.defaults.rules.remote.message = 'Form ini tidak boleh kosong.';
}
if ($.fn.numberbox){
	$.fn.numberbox.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
}
if ($.fn.combobox){
	$.fn.combobox.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
}
if ($.fn.combotree){
	$.fn.combotree.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
}
if ($.fn.combogrid){
	$.fn.combogrid.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
}
if ($.fn.calendar){
	$.fn.calendar.defaults.weeks = ['M','S','S','R','K','J','S'];
	$.fn.calendar.defaults.months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'];
}
if ($.fn.datebox){
	$.fn.datebox.defaults.currentText = 'Hari ini';
	$.fn.datebox.defaults.closeText = 'Tutup';
	$.fn.datebox.defaults.okText = 'Ok';
	$.fn.datebox.defaults.missingMessage = 'Kolom ini tidak boleh kosong.';
}
if ($.fn.datetimebox && $.fn.datebox){
	$.extend($.fn.datetimebox.defaults,{
		currentText: $.fn.datebox.defaults.currentText,
		closeText: $.fn.datebox.defaults.closeText,
		okText: $.fn.datebox.defaults.okText,
		missingMessage: $.fn.datebox.defaults.missingMessage
	});
}
