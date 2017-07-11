/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl',
  ['$scope', 'fileUpload', 'fileService', '$rootScope', '$location', '$window', '$localStorage',
    function ($scope, fileUpload, fileService, $rootScope, $location, $window, $localStorage) {
    $scope.garbage = "garbage";
    $scope.files = [];
    $scope.selected = {
      'option' : ""
    };
    $scope.error = "";

    $scope.test_option = function () {
      console.log($scope.selected.option);
    };

    console.log("Profile Controller instantiated.");

    /*console.log($scope.$on('profile_init', function (event, args) {
      console.log("Broadcast received");
      $scope.files = args.files;
    }));*/

    console.log("In profile: " + $localStorage.profile);
    console.log("In profile files: " + $localStorage.profile_files);
    $scope.files = $localStorage.profile_files;
    $scope.inputs = $localStorage.profile_input;

    console.log($scope.inputs);

    $scope.files_tb = $localStorage.profile_files_tb;
    $scope.option_dd = $localStorage.profile_options_dd;
    $scope.selected_option = "Options";

    console.log($scope.files);

    $scope.holders = [];

    for (var c = 0; c < $scope.files.length; c++) {
      $scope.holders[$scope.files[c]] = "file" + c.toString();
    }

    console.log($scope.holders);

    var uploadUrl = 'http://' + $rootScope.host_address + '/gatekeeper/index.php/ClientFiles/'
      + $localStorage.token + '/' + $localStorage.user + '/';

    console.log("Token: " + $localStorage.token);

    $scope.publish_ready = "Upload Files Please!";
    $scope.publish_button = $('#publish_btn');
    $scope.publish_button.attr('disabled','disabled');

    $scope.submit_ready = "Add files to upload!";
    $scope.submit_button = $('#submit_btn');
    $scope.submit_button.attr('disabled','disabled');

    var files_count = 0;

    //$scope.$on('file_added', function (event, args) {
      console.log("File add broadcast.");
      $scope.submit_ready = "Submit";
      $scope.submit_button.removeAttr('disabled');
    //});

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

    $scope.parse_options = function () {
      var dict_whole = {};
      var dict = {};
      var dict_string = "dict_start";

      for (var option in $scope.inputs) {
        option = $scope.inputs[option];
        var option_value = document.getElementById(option).value;
        dict[option] = option_value;
        dict_string += "/" + option.replace(" ", "_") + "/" + option_value.toString();
      }

      if ($scope.selected_option === 'Options') {
        $scope.error = "Please select an option";
        return;
      } else {
        $scope.error = "";
      }

      dict["subject"] = $scope.selected_option.replace(/ /g, "_");
      dict_string += "/subject/" + $scope.selected_option.replace(/ /g, "_");

      dict_string += "/dict_end";
      // console.log(dict);
      // console.log(dict_string);
      dict_whole['json'] = dict;
      dict_whole['string'] = dict_string;

      console.log(dict_whole);

      return dict_whole;
    };

    $scope.toggle_option = function (data) {
      console.log(data);
      $scope.selected_option = data;
    };

    $scope.publish_report = function () {

      var options = $scope.parse_options();
      $scope.option = options['string'];
      /*console.log("Options: " + $scope.option);

      console.log($rootScope.profile.replace(/ /g, "_"));*/

      var downloadUrl = 'http://' + $rootScope.host_address + '/gatekeeper/index.php/AnalyticsController/'
        + $localStorage.token + '/' + $localStorage.profile.replace(/ /g, "_") + '/' + $scope.option;

      console.log(downloadUrl);
      if (fileUpload.downloadFromUrl(downloadUrl)) {
      }
    };
  }]);
