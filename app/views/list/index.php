<h1>Добавить новый список</h1>
<form role="form" class="col-lg-6" style="padding: 0;" id="main_input_box">
    <div class="input-group">
        <input type="text" class="form-control" id="custom_textbox" name="Item" style="height: auto" placeholder="Название списка">
        <span class="input-group-btn">
            <input class="btn btn-default" type="submit" value="Создать">
        </span>
    </div>
</form>
<div class="clearfix"></div>
<ol class="list-group list_of_items"></ol>
<?php $data['js']='<script src="/app/bundles/list.js"></script>';?>