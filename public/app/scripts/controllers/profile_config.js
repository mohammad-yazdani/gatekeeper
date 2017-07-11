/**
 * Created by myazdani on 7/11/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileConfig',
    ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window', '$localStorage',
  function ($scope, fileUpload, fileService, $rootScope, $location, $window, $localStorage) {

    // Error display
    $scope.error = "";

    // Profile name
    $scope.profile_name = "Black Forest Monthly";

    // Columns configuration
    $scope.columns = [
    ];
    $scope.column_count = 0;
    $scope.column_types = [
      "Spreadsheet",
      "Number"
    ];
    $scope.addColumn = function () {
      var default_name = "Column " + $scope.column_count;
      $scope.column_count += 1;
      $scope.columns.push(default_name)
    };
    $scope.removeColumn = function (name) {
      $scope.columns.splice($scope.columns.indexOf(name), 1);
    };

    // Is it update?
    $scope.update = false;

    // Set options
    $scope.options = [
      "Abu Dhabi"
    ];

}]);
