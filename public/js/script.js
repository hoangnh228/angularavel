(function() {
  var app;

  app = angular.module('myApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    return $interpolateProvider.endSymbol('%>');
  }).constant('apiConfig', {
    'TODO': '/api/todos',
    'EMPLOYEE': '/api/employees'
  });

  app.controller('todoController', function($scope, $http, apiConfig) {
    $scope.todo = [];
    $scope.loading = false;
    $scope.init = function() {
      $scope.loading = true;
      return $http.get(apiConfig.TODO).success(function(data, status, headers, config) {
        $scope.todos = data;
        return $scope.loading = false;
      });
    };
    $scope.addTodo = function() {
      $scope.loading = true;
      return $http.post(apiConfig.TODO, {
        title: $scope.todo.title
      }).success(function(data, status, headers, config) {
        $scope.todos.push(data);
        return $scope.loading = false;
      });
    };
    $scope.updateTodo = function(todo) {
      $scope.loading = true;
      return $http.put(apiConfig.TODO + ("/" + todo.id), {
        done: todo.done
      }).success(function(data, status, headers, config) {
        todo = data;
        return $scope.loading = false;
      });
    };
    $scope.deleteTodo = function(index) {
      var todo;
      $scope.loading = true;
      todo = $scope.todos[index];
      return $http["delete"](apiConfig.TODO + ("/" + todo.id)).success(function() {
        $scope.todos.splice(index, 1);
        return $scope.loading = false;
      });
    };
    return $scope.init();
  });

  app.controller('employeeController', function($scope, $http, apiConfig) {
    $scope.init = function() {
      return $http.get(apiConfig.EMPLOYEE).success(function(data) {
        return $scope.employees = data;
      });
    };
    $scope.toggle = function(modalstate, employee) {
      $scope.modalstate = modalstate;
      switch (modalstate) {
        case 'add':
          $scope.form_title = 'Add new employee';
          $scope.employee = null;
          break;
        case 'edit':
          $scope.form_title = 'Employee detail';
          $http.get(apiConfig.EMPLOYEE + ("/" + employee.id)).success(function(response) {
            return $scope.employee = response;
          });
          break;
        default:
          break;
      }
      $('#myModal').modal('show');
      return true;
    };
    $scope.save = function(modalstate, employee) {
      var url;
      url = apiConfig.EMPLOYEE;
      if (modalstate === 'edit') {
        url += "/" + employee.id;
      }
      return $http({
        method: 'POST',
        url: url,
        data: $.param($scope.employee),
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      }).success(function(data) {
        if (modalstate === 'edit') {
          employee = data;
          $scope.init();
        } else {
          $scope.employees.push(data);
        }
        return $('#myModal').modal('hide');
      }).error(function(err) {
        return alert('Have some fail, please check log to details!');
      });
    };
    $scope.confirmDelete = function(index) {
      var employee, isConfirmDelete;
      isConfirmDelete = confirm('Are you sure to delete this record?');
      if (isConfirmDelete) {
        employee = $scope.employees[index];
        return $http["delete"](apiConfig.EMPLOYEE + ("/" + employee.id)).success(function(data) {
          return $scope.employees.splice(index, 1);
        }).error(function(err) {
          return alert('Unable to delete');
        });
      } else {
        return false;
      }
    };
    return $scope.init();
  });

}).call(this);
