'use strict';

/**
 * @ngdoc function
 * @name analyticsApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the analyticsApp
 */
AnalyticsApp.controller('ProfileManagerCtrl', ['$scope', '$location', '$rootScope', '$timeout', '$localStorage',
  function(
  $scope,
  $location,
  $rootScope,
  $timeout,
  $localStorage
) {

    $localStorage.profile_files = "";
    $localStorage.profile_files_tb = "";
    $localStorage.profile_options_dd = "";
    $localStorage.profile = "";

    $scope.apps = [
      "Black Forest Monthly",
      "Test"
      //"Sample1",
      //"Sample2"
    ];

    var apps_files_info = {
      "Black Forest Monthly" : [
        "BFSL_NAV",
        "Drawn_Capital",
        "Charts",
        "Assets and Ownership",
        "BF_Monthly"
      ],
      "Test" : [
        "Book1",
        "Book2",
        "Book3"
      ]
    };

    var apps_input_info = {
      "Black Forest Monthly" : [
        "T-Bill Rate",
        "Date"
      ]
    };

    var apps_info_textbox = {
      "Black Forest Monthly" : {
        "BFSL_NAV": true,
        "Drawn_Capital": false,
        "Charts": false,
        "Assets and Ownership": true,
        "BF_Monthly": true
      },
      "Test" : {
        "Book1": true,
        "Book2": true,
        "Book3": true
      }
    };

    var apps_info_options = {
      "Black Forest Monthly" : [
        "Abu Dhabi National Insurance Company",
        "Municipal Employees Retirement System of Michigan"
      ]
    };

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
      console.log("In profile manager: " + apps_files_info[name]);

      $location.path("/single_profile");

      //console.log($rootScope.$broadcast('profile_init', { files : apps_info[name]}));
      //console.log($rootScope.$broadcast('test'));
      //console.log($rootScope.$broadcast("test"));
      console.log(apps_files_info);
      console.log(apps_info_options);
      console.log(apps_info_textbox);
      $localStorage.profile_files = apps_files_info[name];
      $localStorage.profile_input = apps_input_info[name];
      $localStorage.profile_files_tb = apps_info_textbox[name];
      $localStorage.profile_options_dd = apps_info_options[name];
      $localStorage.profile = name;
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
      $location.path("/config_profile");
    };
  }]);
