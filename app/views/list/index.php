<h1>Добавить новый список</h1>
<form role="form" class="col-lg-6" style="padding: 0;" id="main_input_box">
    <div class="input-group">
        <input type="text" class="form-control" id="custom_textbox" name="Item" style="height: auto"
               placeholder="Название списка">
        <span class="input-group-btn">
            <input class="btn btn-default" type="submit" value="Создать">
        </span>
    </div>
</form>
<div class="clearfix"></div>
<table class="table table-hover" id="sorting">
    <thead>
    <tr id="filter">
        <th>
            <span>Название списка</span>
            <input class="string" />
            <span class="glyphicon glyphicon-sort sort"></span>
        </th>
    </tr>
    </thead>
    <tbody id="target">
    </tbody>
</table>
<?php $data['js'] = '<script src="/app/bundles/list.js"></script>'; ?>