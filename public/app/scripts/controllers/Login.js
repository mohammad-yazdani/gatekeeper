/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

'use strict';

AnalyticsApp.controller('LoginCtrl', ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window',
  function ($scope, fileUpload, fileService, $rootScope, $location, $window) {

    if ($localStorage.token.length > 1) {
      // TODO : Automatically login if token available
    }

    $scope.login = function () {
      // TODO : Get username from input
      // TODO : Get password from input
      // TODO : Call service login
      // TODO : Set new token


      this.address = "ClientAuth";

      this.username = document.getElementById("username").value;
      window.localStorage.setItem('user', this.username);

      this.password = document.getElementById("password").value;
      this.error = document.getElementById("error");

      this.login = function () {
        console.log("Login begin..");

        let request;
        request = ["null", this.username, this.password];

        let result = this.server.get(request);
        this.error = result;

        if (httpStatus === 202) {
          // TODO : FOR TEST
          console.log("Login successful.");
          console.log(result);
          document.cookie = "token=" + result;
          this.moveToPortal();
        }
        return result;
      };

      this.upDateToken = function (token) {
        return this.server.get([token, null, null]);
      };

      this.moveToPortal = function () {
        window.location.href = "<?php echo site_url('HomeController/ClientPortal'); ?>";
      };

      this.login();


    };
}]);
