/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window', function ($scope, fileUpload, fileService, $rootScope, $location, $window) {
    $scope.garbage = "garbage";
    $scope.files = [];

    console.log("Profile Controller instantiated.");

    /*console.log($scope.$on('profile_init', function (event, args) {
      console.log("Broadcast received");
      $scope.files = args.files;
    }));*/

    console.log("In profile: " + $rootScope.profile);
    console.log("In profile files: " + $rootScope.profile_files);
    $scope.files = $rootScope.profile_files;
    $scope.files_tb = $rootScope.profile_files_tb;

    console.log($scope.files);

    $scope.holders = [];

    for (var c = 0; c < $scope.files.length; c++) {
      $scope.holders[$scope.files[c]] = "file" + c.toString();
    }

    console.log($scope.holders);

    var token = window.localStorage.getItem('token');
    var user = window.localStorage.getItem('user');

    var uploadUrl = 'http://192.168.68.145/gatekeeper/index.php/ClientFiles/' + token + '/' + user + '/';
    var downloadUrl = 'http://192.168.68.145/gatekeeper/index.php/AnalyticsController/' + token + '/' + $rootScope.profile + '/';

    console.log("Token: " + token);

    $scope.publish_ready = "Upload Files Please!";
    $scope.publish_button = $('#publish_btn');
    $scope.publish_button.attr('disabled','disabled');

    $scope.submit_ready = "Add files to upload!";
    $scope.submit_button = $('#submit_btn');
    $scope.submit_button.attr('disabled','disabled');

    var files_count = 0;

    $scope.$on('file_added', function (event, args) {
      console.log("File add broadcast.");
      $scope.submit_ready = "Submit";
      $scope.submit_button.removeAttr('disabled');
    });

    $scope.uploadFile = function () {

      console.log("Stack length: " + files_count);
      console.log("Uploaded Files: " + fileService);

      files_count = fileService.length;

      for (var i = 0; i < files_count; i++) {
        var file = fileService[i];
        console.log("The FILE IS:" + file[1]);
        fileUpload.uploadFileToUrl(file[0], uploadUrl + file[1]);
      }

      $scope.clearFiles();

      $scope.$on('profile_upload_failed', function (event, args) {
        $scope.publish_ready = "File upload not successful!";
        $scope.publish_button.css("background-color", "red");
        $scope.publish_button.css("color", "white");
        $scope.publish_button.attr('disabled','disabled');
        return null;
      });

      $scope.publish_ready = "Publish Report";
      // TODO : Colorful
      $scope.publish_button.css("background-color", "#27c400");
      $scope.publish_button.css("color", "white");
      $scope.publish_button.removeAttr('disabled');

      console.log("Post Push Files: " + fileService);

      //window.location.reload();
    };

    $scope.clearFiles = function () {
      for (var j = 0; j < files_count; j++) {
        console.log("Popping file ..." + j);
        fileService.pop();
      }
    };

    $scope.start_engine = function () {

    };

    $scope.publish_report = function () {
      console.log(downloadUrl);
      if (fileUpload.downloadFromUrl(downloadUrl)) {
      }
    };

  }]);
