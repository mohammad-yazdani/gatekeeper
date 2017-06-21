'use strict';

/**
 * @ngdoc function
 * @name analyticsApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the analyticsApp
 */
AnalyticsApp.controller('ProfileManagerCtrl', ['$scope', '$location',  function($scope, $location) {

    $scope.apps = [
      "Black Forest Monthly"
      //"Sample1",
      //"Sample2"
    ];

    // $scope.new_profile_name = [];

    // TODO : 1. Load app menu

    // TODO : Check if app menu exists
    // $scope.appMenu = $("#app_menu");
    // $scope.appMenu = document.getElementById("app_menu");
    $scope.appMenu = angular.element("#app_menu");

    console.log($scope.appMenu);

    console.log("Adding: " + $scope.apps[0]);

    $scope.open_app = function (name) {
      console.log(name);
      $location.path("/single_profile");
    };

    $scope.delete_app = function (name) {
      alert("Delete " + name)
    };

    $scope.edit_app = function (name) {
      alert("Edit " + name)
    };

    $scope.add_app = function () {
      // alert("Adding " + $scope.new_profile_name);
      var name = $scope.new_profile_name;
      if ($scope.apps.indexOf(name) >= 0) {
        alert("Profile " + name + " already exists!")
      }
      else $scope.apps.push(name);
    };
  }]);
