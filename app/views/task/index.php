<h1 style="display:inline-block;">Список контактов</h1>
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
    Добавить
</button>
<div class="clearfix"></div>
<table class="table table-hover" id="sorting">
    <thead>
    <tr id="filter">
        <th>
            <span>Имя</span>
            <span class="glyphicon glyphicon-sort sort"></span>
            <input class="string form-control form-task" style="display: inline-block;" />
        </th>
        <th>
            <span>Фамилия</span>
            <span class="glyphicon glyphicon-sort sort"></span>
            <input class="string form-control form-task" style="display: inline-block;" />
        </th>
        <th>
            <span>Телефон</span>
            <span class="glyphicon glyphicon-sort sort"></span>
            <input class="string form-control form-task" style="display: inline-block;" />
        </th>
        <th>
            <span>email</span>
            <span class="glyphicon glyphicon-sort sort"></span>
            <input class="string form-control form-task" style="display: inline-block;" />
        </th>
        <th style="width: 125px;">
            <span>Фото</span>
        </th>
    </tr>
    </thead>
    <tbody id="target">
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Создание новой записи</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon">Имя</span>
                    <input type="text" class="string form-control form-task" name="name">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Фамилия</span>
                    <input type="text" class="string form-control form-task" name="surname">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Телефон</span>
                    <input type="text" class="string form-control form-task" name="phone">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">email</span>
                    <input type="text" class="string form-control form-task" name="email">
                </div>
                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary input-group-addon">
                        Загрузить фото&hellip;
                        <input type="file" style="display: none;">
                    </span>
                    </label>
                    <input type="text" class="form-control right-border" name="file" readonly>
                </div>
                <span class="ajax-error" style="display: none"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary save">Создать</button>
            </div>
        </div>
    </div>
</div>
<?php $data['js'] = '<script src="/app/bundles/task.js"></script>'?>
