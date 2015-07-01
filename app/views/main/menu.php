<form method="post" action="/main/save_menu">
<?php
if( $this->session->flashdata('msg') ){
	echo $this->session->flashdata('msg');
}
?>
<br>
<table width="60%" cellpadding="5" border="0">
<tr>
	<td width="20%">Parent ID</td>
	<td width="40">: 
		<select name="parent_id" id="parent_id">
			<option value="0"> No Parent </option>
			<?php foreach($menu as $row){ ?>
				<option value="<?=$row['id']?>"><?=$row['name']?></option>
			<?php } ?>
		</select>
	</td>
</tr>
<tr>
	<td>Nama menu</td>
	<td>: <input type="text" name="nama" id="nama"></td>
</tr>
<tr>
	<td>URL</td>
	<td>: <input type="text" name="url" id="url"></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" name="submit" id="submit" value="Simpan"></td>
</tr>
</table>
</form>