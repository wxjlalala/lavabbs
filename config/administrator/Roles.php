<?php
/**
 * Created by PhpStorm.
 * User: wxj
 * Date: 2018/10/25
 * Time: 10:13
 */

return [
    'title' => '角色',
    'single' => '角色',
    'model' => \Spatie\Permission\Models\Role::class,
    'permission' => function () {
        return Auth::user()->can('manage_users');
    },
    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识',
        ],
        'permissions' => [
            'title' => '权限',
            'output' => function ($value, $model) {
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission) {
                    $result[] = $permission->name;
                }
                return empty($result) ? 'N/A' : implode($result, '|');
            },
        ],
        'operations' => [
            'title' => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],

    ],

    'edit_fields' => [
        'name' => [
            'title' => '标识',
        ],
        'permissions' => [
            'title' => '权限',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识',
        ],
    ],

    // 新建和编辑表单时的表单验证规则
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    // 表单验证错误时定制错误信息
    'messages' => [
        'name.required' => '标识不能为空',
        'name.unique' => '标识已存在',
    ],

];