<div class="panel datagrid easyui-fluid">
    <div class="panel-header" ><div class="panel-title panel-with-icon">Perbandingan Acuan Anjab dan Keadaan saat ini</div>
    <div class="panel-icon icon-people"></div>
</div>
<div class="easyui-tabs">
    <div title="Acuan Anjab" style="padding:10px">        
        <ul class="easyui-tree" data-options="url:'<?=site_url('anjab/load_data_anjab/1')?>',method:'get',animate:true,lines:true" id="mainacuantree"></ul>
    </div>
    <div title="Keadaan Saat Ini" style="padding:10px">
        <ul class="easyui-tree" data-options="url:'<?=site_url('anjab/load_data_anjab/0')?>',method:'get',animate:true,lines:true" id="mainacuanrealtree"></ul>
    </div>   
</div>
