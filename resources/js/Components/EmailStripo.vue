<script setup>
import { IconCode } from '@tabler/icons-vue';
import { random } from 'lodash';
import { onMounted } from 'vue';

const emailBody = defineModel('email');

const emailTitle = defineModel('subject', { default: 'Welcome to Ultrashots' })

function request(method, url, data, callback) {

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {

      callback(req.responseText);

    } else if (req.readyState === 4 && req.status !== 200) {

      console.error('Can not complete request. Please check you entered a valid PLUGIN_ID and SECRET_KEY values');

    }

  };

  req.open(method, url, true);

  if (method !== 'GET') {
    req.setRequestHeader('content-type', 'application/json');
  }

  req.send(data);
}

function loadDemoTemplate(callback) {
  request('GET', 'https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Empty-Template/Empty-Template.html', null, function (html) {
    request('GET', 'https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Empty-Template/Empty-Template.css', null, function (css) {
      callback({ html: html, css: css });
    });
  });
}

function initPlugin(template) {
  const apiRequestData = {
    emailId: random(100, 900)
  };

  const script = document.createElement('script');

  script.id = random(9000, 25000);

  script.type = 'text/javascript';

  script.src = 'https://plugins.stripo.email/static/latest/stripo.js';

  script.onload = function () {

    window.Stripo.init({
      settingsId: 'stripoSettingsContainer',
      previewId: 'stripoPreviewContainer',
      codeEditorButtonId: 'codeEditor',
      undoButtonId: 'undoButton',
      redoButtonId: 'redoButton',
      onDataChanged: async () => {

        await window.StripoApi.compileEmail((error, html, ampHtml, ampErrors) => {
          
          window.StripoApi.setTitle(emailTitle.value)

          emailBody.value = html

        })

      },
      /*mergeTags: [
        {
          "category": "Gmail",
          "entries": [
            { "label": "mergeTag.label.firstName", "value": "*|FNAME|*" }
          ]
        }
      ],*/
      locale: 'en',
      html: template.html,
      css: template.css,
      supportOutlookButtonsByDefault: true,
      // externalImagesLibrary: window.ExternalImagesLibrary,
      // ignoreClickOutsideSelectors: '#externalImagesLibrary',
      apiRequestData: apiRequestData,
      getAuthToken: function (callback) {
        request('POST', 'https://plugins.stripo.email/api/v1/auth',
          JSON.stringify({
            pluginId: '3035546043c74ad08201df9822582c1c',
            secretKey: '6f8a42af885649ce96a6e013e4ccb3c1'
          }),
          function (data) {
            callback(JSON.parse(data).token);
          });
      }
    });
  };

  document.body.appendChild(script);
}

onMounted(() => {
  loadDemoTemplate(initPlugin);
})
</script>

<template>
  <div id="externalSystemContainer" class="bg-white rounded-t-lg dark:bg-gray-700 dark:text-gray-100">
    <!--This is external system container where you can place plugin buttons -->
    <button id="undoButton" type="button" class="control-button">Undo</button>
    <button id="redoButton" type="button" class="control-button">Redo</button>
    <button id="codeEditor" type="button" class="control-button">
      <IconCode />
    </button>
    <span id="changeHistoryContainer" style="display: none;">Last change: <a id="changeHistoryLink"></a></span>
  </div>

  <!-- <div class="notification-zone"></div> -->

  <div>
    <!--Plugin containers -->
    <div id="stripoSettingsContainer" class="dark:text-white">
      Loading...
    </div>
    <div id="stripoPreviewContainer"></div>
  </div>
</template>


<style>
#externalSystemContainer {
  /* background-color: darkgrey; */
  padding: 5px 0 5px 20px;
}

#undoButton,
#redoButton {
  display: none;
}

#stripoSettingsContainer {
  width: 400px;
  float: left;
  height: 70svh;
  overflow-y: auto;
  @apply scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-800 scrollbar-track-gray-100
}

#stripoPreviewContainer {
  width: calc(100% - 400px);
  float: left;
  @apply scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-800 scrollbar-track-gray-100
}

.stripo-preview-frame {
  height: 70svh !important;
}

.panel-body .esdev-panel-content-wrapper {
  max-height: 70svh !important;
}

div[mb-panel-max-height] {
  height: 70svh;
  max-height: 70svh !important;
  @apply scrollbar-none
}

/* .notification-zone {
  position: fixed;
  width: 400px;
  z-index: 99999;
  right: 20px;
  bottom: 80px;
} */

.control-button {
  border-radius: 17px;
  padding: 5px 10px;
  border-color: grey;
}

#changeHistoryLink {
  cursor: pointer;
}

a.sripo-watermark {
  display: none !important;
}
</style>
