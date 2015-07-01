$(function() {

	function update_kategori_select() {
		$.ajax({
			url: _BASE_URL_JS+"anjab/updateOption",
			type : 'post',
			success: function(data) {
				$('#optionjabatan').html(data);
			}
		});
	}

	$('.sortable').nestedSortable({
		/* forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 3,

		isTree: true,
		expandOnHover: 700,
		startCollapsed: true, */

		listType: 'ul',
		handle: 'div',
		items: 'li',
		opacity: .6,
		toleranceElement: '> div',
		forcePlaceholderSize: true,
		tabSize: 15,
		placeholder: 'ns-helper',
		maxLevels: 5,
		update: function() {
			var sorted = $('.sortable').nestedSortable('serialize');
			//var sorted = $('.sortable').nestedSortable('toArray');
			//var sorted = $('.sortable').nestedSortable('toHierarchy');
			//console.log(sorted);
			//$('#serialize').text(sorted);
			$.ajax({
				type: 'POST',
				url: $('#kategori').attr('action'),
				data: sorted,
				error: function() {
					//$.colorbox({html:'<h2>Error</h2>Simpan kategori gagal'});
				},
				success: function(data) {
					//$.colorbox({html: data + ' kategori berhasil disimpan'});
					update_kategori_select();
				}
			});

		}
	});

	$('#toggle-add').click(function() {
		$('#add-category')
			.slideToggle(500 )
			.find('input')
			.first()
			.focus();
		return false;
	});

	$('#add-category input').keydown(function(e) {
		if (e.which == 13) {
			//enter
			$('#add-category').submit();
			return false;
		}
	});

	$('#add-category').submit(function() {
		var nama = $(this).find('input').first();
		if ($.trim(nama.val()) == '') {
			nama.focus();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			datatype: 'json',
			timeout: 20000,
			error: function() {
				$.colorbox({html:'<h2>Error</h2>Tambah kategori gagal'});
			},
			success: function(data) {
				if (data.success) {
					var li =
						'<li id="kategori_' + data.category_id + '" data-category_id="' + data.category_id + '">' +
							'<div class="ns-item">' +
								'<div class="ns-title"><i class="fa fa-arrows"></i>' + data.name + '</div>' +
								'<div class="ns-actions">' +
									'<a href="#" class="edit-kategori" title="Edit">' +
										'<i class="fa fa-pencil"></i>' +
									'</a>' +
									'<a href="#" class="delete-kategori" title="Delete">' +
										'<i class="fa fa-trash-o"></i>' +
									'</a>' +
								'</div>' +
							'</div>' +
						'</li>';
					if (data.parent_id == 0) {
						$('#kategori > ul').append(li);
					} else {
						var parent_li = $('#kategori_' + data.parent_id);
						var ul = parent_li.children('ul');
						//console.log(parent_li);
						//console.log(ul);
						if (ul.length) {
							ul.append(li);
						} else {
							parent_li.append('<ul>' + li + '<ul>');
						}
					}
					$('#add-category')[0].reset();
					update_kategori_select();
					$.colorbox({
						html:'<div class="col-sm-12"><div class="alert alert-success alert-dismissible">Berhasil tambah data</div></div>',
						onClosed: function () {					        
					        location.reload();
					    }
					});										
				} else {
					$.colorbox({html: data.msg});
				}
			}
		});
		return false;
	});

	$('a.delete-kategori').on('click', function(e) {
		e.preventDefault();
		if (!confirm('Apakah anda yakin akan menghapus kategori ini (termasuk semua sub kategorinya)?')) {
			return false;
		}

		var anjab_id = $(this).data('iddel');
		console.log(anjab_id);
		$.ajax({
			url : _BASE_URL_JS+"anjab/delete",
			type : 'post',
			dataType : 'json',
			data : {anjab_id:anjab_id},
			success : function(response){							
				if (response.status == 1) {
					success('Berhasil',response.msg);
					$("#kategori").html(response.updkat);

				} else {
					error('Gagal',response.msg);
				}
			}

		});
		// var category_id = $(this).closest('li').data('category_id');
		//console.log(category_id);
		// $.ajax({
		// 	type: 'POST',
		// 	url: _BASE_URL + 'index.php?action=product_admin.kategori_delete',
		// 	data: 'category_id=' + category_id,
		// 	//datatype: 'json',
		// 	timeout: 20000,
		// 	error: function() {
		// 		$.colorbox({html:'Hapus kategori gagal'});
		// 	},
		// 	success: function(data) {
		// 		if (data.success) {
		// 			$('#kategori_' + data.category_id).remove();
		// 			update_kategori_select();
		// 		}
		// 	}
		// });
		return false;
	});

	$('a.edit-kategori').on('click', function(e) {
		e.preventDefault();
		var category_id = $(this).closest('li').data('category_id');
		$.colorbox({
			iframe: true,
			width:'700px',
			height:'540px',
			href: _BASE_URL + 'index.php?action=product_admin.kategori_edit&id=' + category_id,
			onClosed: function() {
				update_kategori_select();
			}
		});
	});

	/* $('#btn-edit-kategori').live('click', function(e) {
		e.preventDefault();
		alert('asd');
	}); */

	/* $('a.edit-kategori').colorbox({href:_BASE_URL+'index.php?action=product_admin.kategori_edit&id='+109, iframe:true, width:'80%', height:'80%'}); */

});