/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

'use strict';

AnalyticsApp.controller('SignUpCtrl', ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window',
  'Server', function ($scope, fileUpload, fileService, $rootScope, $location, $window, Server) {

    $scope.email = null;
    $scope.email_confirm = null;
    $scope.username = null;
    $scope.password = null;
    $scope.password_confirm = null;
    $scope.error = null;

    $scope.signUp = function () {
      // TODO : Get username from input
      // TODO : Get password from input
      console.log("Sign up begin...");

      if (!$scope.email || $scope.email.length <= 0) {
        $scope.error = "Email field empty!";
        return;
      }

      if ($scope.email_confirm !== $scope.email) {
        $scope.error = "Emails do not match!";
        return;
      }

      if (!$scope.username || $scope.username.length <= 0) {
        $scope.error = "Username field empty!";
        return;
      }

      if (!$scope.password || $scope.password.length <= 0) {
        $scope.error = "Password field empty!";
        return;
      }

      if ($scope.password_confirm !== $scope.password) {
        $scope.error = "Passwords do not match!";
        return;
      }



      $scope.error = null;
      return;

      // TODO : Call cred login
      var result = Server.signUp($scope.username, $scope.password, $scope.email)
        .then(function (data) {
          if (data.length > 1) {
            $localStorage.token = data;
            console.log("Transfer");
            $localStorage.user = $scope.username;
            $location.path("/catalog");
          }
        });
    };

    $scope.goToLogin = function () {
      $location.path("/");
    };

  }]);
