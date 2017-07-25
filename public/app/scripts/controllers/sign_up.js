/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

// TODO : CLEAN-CODE

'use strict';

AnalyticsApp.controller('SignUpCtrl',
  ['$scope', 'fileService', '$rootScope', '$location', 'Server', '$window', '$timeout', '$localStorage',
  function ($scope, fileService, $rootScope, $location, Server, $window, $timeout, $localStorage) {
    $scope.email = null;
    $scope.email_confirm = null;
    $scope.username = null;
    $scope.password = null;
    $scope.password_confirm = null;
    $scope.special = "None";
    $scope.error = null;

    $scope.register = function () {
      var error_stop = true;
      $scope.error = null;

      if (!$scope.email || $scope.email.length <= 0) {
        $scope.error = "Email field empty!";
        if (error_stop) return;
      }

      if ($scope.email_confirm !== $scope.email) {
        $scope.error = "Emails do not match!";
        if (error_stop) return;
      }
      if (!$scope.username || $scope.username.length <= 0) {
        $scope.error = "Username field empty!";
        if (error_stop) return;
      }
      if (!$scope.password || $scope.password.length <= 0) {
        $scope.error = "Password field empty!";
        if (error_stop) return;
      }
      if ($scope.password_confirm !== $scope.password) {
        $scope.error = "Passwords do not match!";
        if (error_stop) return;
      }

      Server.register($scope.username, $scope.password, $scope.email, $scope.special)
        .then(function (data) {
          if (data.headers('token').length > 1) {
            $localStorage.token = data;
            $localStorage.user = $scope.username;
            $location.path("/catalog");
          } else {
            $scope.error = data.data.replace(/_/g, ' ');
          }
        });
    };

    $scope.goToLogin = function () {
      $location.path("/");
    };
  }]);
