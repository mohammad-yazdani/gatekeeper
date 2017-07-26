/**
 * Created by myazdani on 7/11/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileConfig',
    ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window', '$localStorage', 'Server',
  function ($scope, fileUpload, fileService, $rootScope, $location, $window, $localStorage, Server) {

    Server.checkSession();

    // Error display
    $scope.error = "";

    // Profile name
    $scope.profile_name = "Black Forest Monthly";

    $scope.columns = {
      "New": {},
      "Update": {}
    };
    $scope.column_types = [
      "Spreadsheet",
      "Number",
      "Macro"
      //, "Math"
    ];

    $scope.column_count = 1;
    $scope.addColumn = function (section) {
      var index = $scope.column_count;
      $scope.columns[section][index] = {};
      $scope.columns[section][index]['name'] = "";
      $scope.columns[section][index]['type'] = "Select Type";
      $scope.column_count += 1;
    };
    $scope.modifyColumn = function (section, name, field, data) {
      $scope.columns[section][name][field] = data;
    };
    $scope.removeColumn = function (name, section) {
      delete $scope.columns[section][name];
    };

    // Is it update?
    $scope.update = false;

    // Set options
    $scope.options = [
      "Abu Dhabi"
    ];

    $scope.test = function () {
      console.dir($scope.columns);
    };

}]);
