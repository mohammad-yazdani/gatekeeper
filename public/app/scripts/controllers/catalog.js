/**
 * Created by myazdani on 6/21/2017.
 */

'use strict';

angular
  .module('analyticsApp').controller('CatalogCtrl', function ($scope, $location, $localStorage) {

  var params = $location.search();

  console.log("Token: " + params['token']);
  console.log("User: " + params['user']);

  $localStorage.token = params['token'];
  $localStorage.user = params['user'];

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

    console.log("Opening " + address);

    $location.path("analytics");
  };

});
