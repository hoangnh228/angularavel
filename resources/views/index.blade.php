<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Todo app - Laravel 5.2 & angularJS</title>
    {{ Html::style('css/style.css') }}
    {{ Html::style('css/font-awesome.min.css') }}
</head>
<body ng-app="myApp">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#todo" aria-controls="todo" role="tab" data-toggle="tab">Todo task</a></li>
                    <li role="presentation"><a href="#employee" aria-controls="employee" role="tab" data-toggle="tab">Employee management</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="container tab-pane active" id="todo" role="tabpanel" ng-controller="todoController">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-center">Todo App</h2>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" placeholder="Enter the title" id="title" type="text" ng-model="todo.title">
                    </div>
                    <button class="btn btn-primary btn-md" ng-click="addTodo()">Add</button>
                    <i ng-show="loading" class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="row task-list">
                <div class="col-md-6 col-md-offset-3">
                    <table class="table table-striped">
                        <tr ng-repeat="todo in todos">
                            <td>
                                <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="todo.done" ng-change="updateTodo(todo)">
                            </td>
                            <td>
                                <% todo.title %>
                            </td>
                            <td width="50">
                                <button type="button" class="btn btn-danger btn-sx" ng-click="deleteTodo($index)"><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container tab-pane" id="employee" role="tabpanel" ng-controller="employeeController">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2>Employees Management</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Position</th>
                                <th width="70">
                                    <button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Employee</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="employee in employees">
                                <td><% employee.id %></td>
                                <td><% employee.name %></td>
                                <td><% employee.email %></td>
                                <td><% employee.contact_number %></td>
                                <td><% employee.position %></td>
                                <td class="text-center">
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', employee)">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete($index)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><% form_title %></h4>
                                </div>
                                <div class="modal-body">
                                    <form name="frmEmployees" class="form-horizontal" novalidate="">

                                        <div class="form-group error">
                                            <label for="name" class="col-sm-3 control-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control has-error" id="name" name="name" placeholder="Fullname" ng-model="employee.name" ng-required="true">
                                                <span class="help-inline" ng-show="frmEmployees.name.$invalid && frmEmployees.name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" ng-model="employee.email" ng-required="true">
                                                <span class="help-inline" ng-show="frmEmployees.email.$invalid && frmEmployees.email.$touched">Valid Email field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact_number" class="col-sm-3 control-label">Contact Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" ng-model="employee.contact_number" ng-required="true">
                                            <span class="help-inline"
                                                ng-show="frmEmployees.contact_number.$invalid && frmEmployees.contact_number.$touched">Contact number field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="position" class="col-sm-3 control-label">Position</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="position" name="position" placeholder="Position" ng-model="employee.position" ng-required="true">
                                            <span class="help-inline" ng-show="frmEmployees.position.$invalid && frmEmployees.position.$touched">Position field is required</span>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, employee)" ng-disabled="frmEmployees.$invalid">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script('js/jquery-1.12.0.min.js') }}
    {{ Html::script('js/bootstrap.min.js') }}
    {{ Html::script('js/angular.min.js') }}
    {{ Html::script('js/script.js') }}
</body>
</html>