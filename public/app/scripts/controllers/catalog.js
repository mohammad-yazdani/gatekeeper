/**
 * Created by myazdani on 6/21/2017.
 */

// TODO : CLEAN-CODE

'use strict';

angular
  .module('analyticsApp').controller('CatalogCtrl', function ($scope, $location, $localStorage, $rootScope) {
  /*
  console.log("Token: " + $localStorage.token);
  console.log("User: " + $localStorage.user);
  */

  $scope.current_user = $rootScope.current_user_name;

  $scope.apps = [
    'Monthly Report'
  ];

  $scope.app_address = {
    'Monthly Report' : 'analytics',
    'Administration' : 'admin'
  };

  $scope.load_template = function () {
    $location.path('/');
  };

  $scope.open_application = function (name) {
    var address = $scope.app_address[name];
    $location.path("analytics");
  };

});
