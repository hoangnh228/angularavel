app = angular.module 'myApp', [], ($interpolateProvider) ->
    $interpolateProvider.startSymbol '<%'
    $interpolateProvider.endSymbol '%>'
.constant 'apiConfig',
    'TODO': '/api/todos'
    'EMPLOYEE' : '/api/employees'

# app controller for todo app
app.controller 'todoController', ($scope, $http, apiConfig) ->
    $scope.todo = []
    $scope.loading = off

    # initial
    $scope.init = ->
        $scope.loading = on
        $http.get apiConfig.TODO
        .success (data, status, headers, config) ->
            $scope.todos = data
            $scope.loading = off

    # add new record
    $scope.addTodo = ->
        $scope.loading = on
        $http.post apiConfig.TODO,
            title: $scope.todo.title
        .success (data, status, headers, config) ->
            $scope.todos.push(data)
            $scope.loading = off

    # update record
    $scope.updateTodo = (todo) ->
        $scope.loading = on
        $http.put apiConfig.TODO + "/#{todo.id}",
            done: todo.done
        .success (data, status, headers, config) ->
            todo = data
            $scope.loading = off

    # delete record
    $scope.deleteTodo = (index) ->
        $scope.loading = on
        todo = $scope.todos[index]
        $http.delete apiConfig.TODO + "/#{todo.id}"
        .success ->
            $scope.todos.splice index, 1
            $scope.loading = off
    $scope.init()

# app controller for employee management app
app.controller 'employeeController', ($scope, $http, apiConfig) ->
    # initial
    $scope.init = ->
        $http.get apiConfig.EMPLOYEE
        .success (data) ->
            $scope.employees = data

    # show modal form
    $scope.toggle = (modalstate, employee) ->
        $scope.modalstate = modalstate
        switch modalstate
            when 'add'
                $scope.form_title = 'Add new employee'
                $scope.employee = null
            when 'edit'
                $scope.form_title = 'Employee detail'
                $http.get apiConfig.EMPLOYEE + "/#{employee.id}"
                .success (response) ->
                    $scope.employee = response
            else
                break
        $('#myModal').modal 'show'
        true

    # save new record / update exist record
    $scope.save = (modalstate, employee) ->
        url = apiConfig.EMPLOYEE
        # append employee id to the URL if the form is in edit mode
        url += "/#{employee.id}" if modalstate is 'edit'
        $http
            method: 'POST',
            url: url,
            data: $.param($scope.employee),
            headers: 'Content-Type': 'application/x-www-form-urlencoded'
        .success (data) ->
            if modalstate is 'edit'
                employee = data
                $scope.init()
            else
                $scope.employees.push(data)
            $('#myModal').modal 'hide'
        .error (err) ->
            alert 'Have some fail, please check log to details!'

    # delete record
    $scope.confirmDelete = (index) ->
        isConfirmDelete = confirm 'Are you sure to delete this record?'
        if isConfirmDelete
            employee = $scope.employees[index]
            $http.delete apiConfig.EMPLOYEE + "/#{employee.id}"
            .success (data) ->
                $scope.employees.splice index, 1
            .error (err) ->
                alert 'Unable to delete'
        else
            false
    $scope.init()
















