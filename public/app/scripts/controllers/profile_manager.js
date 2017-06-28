'use strict';

/**
 * @ngdoc function
 * @name analyticsApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the analyticsApp
 */
AnalyticsApp.controller('ProfileManagerCtrl', ['$scope', '$location', '$rootScope', '$timeout',  function(
  $scope,
  $location,
  $rootScope,
  $timeout
) {
    $scope.apps = [
      "Black_Forest_Monthly",
      "Test"
      //"Sample1",
      //"Sample2"
    ];

    var apps_info = {
      "Black_Forest_Monthly" : [
        "BFSL_NAV",
        "Drawn_Capital",
        "BF_Monthly"
      ],
      "Test" : [
        "Book1",
        "Book2",
        "Book3"
      ]
    };

    var apps_info_textbox = {
      "Black_Forest_Monthly" : {
        "BFSL_NAV": true,
        "Drawn_Capital": false,
        "BF_Monthly": true
      },
      "Test" : {
        "Book1": true,
        "Book2": true,
        "Book3": true
      }
    };

    console.log("Token: " + window.localStorage.getItem('token'));
    console.log("User: " + window.localStorage.getItem('user'));

    // $scope.new_profile_name = [];

    // TODO : 1. Load app menu

    // TODO : Check if app menu exists
    // $scope.appMenu = $("#app_menu");
    // $scope.appMenu = document.getElementById("app_menu");
    $scope.appMenu = angular.element("#app_menu");

    console.log($scope.appMenu);

    console.log("Adding: " + $scope.apps[0]);

    $scope.open_app = function (name) {
      console.log("Name: " + name);
      console.log("In profile manager: " + apps_info[name]);

      $location.path("/single_profile");

      //console.log($rootScope.$broadcast('profile_init', { files : apps_info[name]}));
      //console.log($rootScope.$broadcast('test'));
      //console.log($rootScope.$broadcast("test"));
      $rootScope.profile_files = apps_info[name];
      $rootScope.profile_files_tb = apps_info_textbox[name];
      $rootScope.profile = name;
    };

    $scope.delete_app = function (name) {
      alert("Delete " + name);
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
