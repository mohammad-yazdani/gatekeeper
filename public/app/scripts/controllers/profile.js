/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', ['$scope', 'fileUpload', 'fileService', function ($scope, fileUpload, fileService) {

    $scope.garbage = "garbage";

    $scope.files = [
      "BFSL_NAV"
      , "Drawn_Capital"
      , "Template"
    ];

    $scope.holders = {
      "BFSL NAV" : "file1",
      "Drawn Capital" : "file2",
      "Template" : "file3"
    };

    var token = window.localStorage.getItem('token');
    var user = window.localStorage.getItem('user');

    var uploadUrl = 'http://localhost/gatekeeper/index.php/ClientFiles/' + token + '/' + user + '/';

    console.log("Token: " + token);

    $scope.publish_ready = "Upload Files Please!";

    $scope.publish_button = $('#publish_btn');

    $scope.publish_button.attr('disabled','disabled');

    var files_count = 0;

    $scope.uploadFile = function () {

      console.log("Stack length: " + files_count);
      console.log("Uploaded Files: " + fileService);

      files_count = fileService.length;

      for (var i = 0; i < files_count; i++) {
        var file = fileService[i];
        console.log("The FILE IS:" + file);
        fileUpload.uploadFileToUrl(file, uploadUrl + $scope.files[i]);
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
      alert("Now publish");
    };

  }]);
