<script setup>
import grapesjs from 'grapesjs';
import grapesMjml from 'grapesjs-mjml';
// import grapesRte from 'grapesjs-rte-extensions';
import grapesFonts from '@silexlabs/grapesjs-fonts';
import grapesCkeditor from 'grapesjs-plugin-ckeditor';
import grapesStyleBg from 'grapesjs-style-bg';
// import grapesTable from 'grapesjs-table';
import grapesTouch from 'grapesjs-touch';
// import grapesImageEditor from 'grapesjs-tui-image-editor';
import 'grapesjs/dist/css/grapes.min.css';
import 'grapick/dist/grapick.min.css';
import { onMounted, ref } from 'vue';

const email = defineModel('email');

const editor = ref(null)

onMounted(() => {
  editor.value = grapesjs.init({
    clearOnRender: true,

    avoidInlineStyle: false,

    container: '#gjs',

    fromElement: true,

    // Size of the editor
    height: '600',

    width: 'auto',

    // storageManager: false,

    plugins: [grapesMjml, grapesStyleBg, grapesFonts, grapesCkeditor, grapesTouch, /*grapesTable*/],

    pluginsOpts: {
      [grapesCkeditor]: {
        onToolbar: el => {
          el.style.minWidth = '250px';
        },
        options: {
          startupFocus: true,
          extraAllowedContent: '*(*);*{*}', // Allows any class and any inline style
          allowedContent: true, // Disable auto-formatting, class removing, etc.
          enterMode: 2, // CKEDITOR.ENTER_BR,
          extraPlugins: 'sharedspace,justify,colorbutton,panelbutton,font',
          toolbar: [
            { name: 'styles', items: ['Font', 'FontSize'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'], },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Hr', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
          ],
        }
      },

      /*[grapesRte]: {
        base: {
          bold: true,
          italic: true,
          underline: true,
          strikethrough: true,
          link: false,
        },
        fonts: {
          fontColor: false,
          hilite: false,
        },
        format: {
          heading1: true,
          heading2: true,
          heading3: false,
          heading4: false,
          paragraph: true,
        },
        subscriptSuperscript: true,
        indentOutdent: false,
        list: false,
        align: true,
        actions: false,
        undoredo: false,
        extra: true,
        darkColorPicker: true,
        maxWidth: '480px'
      },*/

      /*[grapesImageEditor]: {
        toolbarIcon: `
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 stroke-current"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M15 8h.01" fill="none" />
            <path d="M11 21h-5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5" fill="none" />
            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l2 2" fill="none" />
            <path d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" fill="none" />
          </svg>
        `,
        config: {
          includeUI: {
            initMenu: 'crop',
          },
        },
        cssMaxWidth: 700,
        cssMaxHeight: 500,
        selectionStyle: {
          cornerSize: 20,
          rotatingPointOffset: 70,
        },
      },*/

      [grapesFonts]: {
        api_key: 'AIzaSyAyVW9dXasn4d2CKARx8iEjI44kpVLhKJk'
      },

      [grapesMjml]: {
        fonts: {
          Inter: 'https://fonts.googleapis.com/css?family=inter',
        },
        blocks: [
          'mj-1-column',
          'mj-2-columns',
          'mj-3-columns',
          'mj-divider',
          'mj-image',
          'mj-spacer',
          'mj-hero',
          'mj-text',
          'mj-button',
          'mj-wrapper',
          // 'mj-raw',
          'mj-social-element'
        ],
      },

      /*[grapesTable]: {
        tableProps: {
          rows: 3,
          columns: 3,
          header: true,
          footer: false,
        },

        // Table Footer content attribute identifier
        attrTableFooter: false,

      },*/
    }
  });

  // add custom fonts options on editor's font list
  editor.value.on('load', () => {
    let styleManager = editor.value.StyleManager;
    let fontProperty = styleManager.getProperty('typography', 'font-family');

    let list = [];

    // empty list
    fontProperty.set('list', list);

    // custom list
    list.unshift(fontProperty.addOption({ value: 'Inter, sans-serif', name: 'Inter' }));
    fontProperty.set('list', list);

    styleManager.render();
  });

  // const bm = editor.Blocks;
  // const imageBlock = bm.get("mj-image");
  // imageBlock.set({ content: '<mj-image src="DEFAULT_SRC" width="300px"/>' })

  editor.value.DomComponents.addType('image', {
    model: {
      defaults: {
        resizable: {
          tl: 0, // Top left
          tr: 0, // Top right
          br: 0, // Bottom right
          bl: 0, // Bottom left
        }
      }
    }
  })

  //prevent janky rendering
  editor.value.on('load', function () {
    document.getElementById("gjs").style.display = "block";
  })

  const cmd = editor.value.Commands;
  const pn = editor.value.Panels;

  // Update canvas-clear command
  cmd.add('canvas-clear', function () {
    if (confirm('Are you sure to clean the canvas?')) {
      editor.runCommand('core:canvas-clear')
      setTimeout(function () { localStorage.clear() }, 0)
    }
  });

  // console.log(pn.getPanel('options'));

  pn.removeButton('options', 'mjml-import')
  pn.removeButton('options', 'fullscreen')
  // pn.removeButton('options', 'export-template')
  // pn.removeButton('options', 'export-template')
  pn.removeButton('options', 'redo')

  pn.getButton('options', 'sw-visibility').set('className', '')

  pn.getButton('options', 'sw-visibility').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" fill="none" />
      <path d="M4 12l16 0" />
      <path d="M12 4l0 16" />
    </svg>
  `)

  pn.getButton('options', 'preview').set('className', '')

  pn.getButton('options', 'preview').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
      <path d="M4 16v2a2 2 0 0 0 2 2h2" />
      <path d="M16 4h2a2 2 0 0 1 2 2v2" />
      <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
      <path d="M8 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" fill="none" />
      <path d="M16 16l-2.5 -2.5" />
    </svg>
  `)

  // pn.getButton('options', 'undo').set('className', '')

  // pn.getButton('options', 'undo').set('label', `
  //   <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
  //     viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  //     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  //     <path d="M8 14l-4 -4l4 -4" />
  //     <path d="M18 21c0 -6.075 -4.925 -11 -11 -11h-3" fill="none" />
  //   </svg>
  // `)

  // pn.getButton('options', 'redo').set('className', '')

  // pn.getButton('options', 'redo').set('label', `
  //   <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
  //     viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  //     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  //     <path d="M16 14l4 -4l-4 -4" />
  //     <path d="M6 21c0 -6.075 4.925 -11 11 -11h3" fill="none" />
  //   </svg>
  // `)

  pn.getButton('devices-c', 'set-device-desktop').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M3 4a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-12z" fill="none" />
      <path d="M3 13h18" />
      <path d="M8 21h8" />
      <path d="M10 17l-.5 4" />
      <path d="M14 17l.5 4" />
    </svg>
  `)

  pn.getButton('devices-c', 'set-device-tablet').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M18 2a3 3 0 0 1 2.995 2.824l.005 .176v14a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005h12zm-3 15h-6l-.117 .007a1 1 0 0 0 0 1.986l.117 .007h6l.117 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" fill="none" />
    </svg>
  `)

  pn.getButton('devices-c', 'set-device-mobile').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" fill="none" />
      <path d="M11 4h2" />
      <path d="M12 17v.01" />
    </svg>
  `)

  pn.addButton('options', {
    id: 'open-fonts',
    label: `
    <svg
      xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M17.5 15.5m-3.5 0a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0 -7 0" fill="none" />
      <path d="M3 19v-10.5a3.5 3.5 0 0 1 7 0v10.5" fill="none" />
      <path d="M3 13h7" />
      <path d="M21 12v7" />
    </svg>
    `,
    command: function () {
      editor.value.runCommand('open-fonts')
    },
    attributes: {
      'title': 'Add fonts',
      'data-tooltip-pos': 'bottom',
    },
  });

  pn.getButton('views', 'open-blocks').set('className', '');

  pn.getButton('views', 'open-blocks').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" fill="none" />
      <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" fill="none" />
      <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" fill="none" />
      <path d="M14 7l6 0" />
      <path d="M17 4l0 6" />
    </svg>
  `)

  pn.getButton('views', 'open-layers').set('className', '');

  pn.getButton('views', 'open-layers').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M12 4l-8 4l8 4l8 -4l-8 -4" fill="none" />
      <path d="M4 12l8 4l8 -4" fill="none" />
      <path d="M4 16l8 4l8 -4" fill="none" />
    </svg>
  `)

  pn.getButton('views', 'open-tm').set('className', '');

  pn.getButton('views', 'open-tm').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" fill="none" />
      <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
      <path d="M15 8l2 0" fill="none" />
      <path d="M15 12l2 0" fill="none" />
      <path d="M7 16l10 0" fill="none" />
    </svg>
  `)

  pn.getButton('views', 'open-sm').set('className', '');

  pn.getButton('views', 'open-sm').set('label', `
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" fill="none" />
      <path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
      <path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
      <path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
    </svg>
  `)

  editor.value.on('change:changesCount', () => {

    setTimeout(() => {
      email.value = editor.value.runCommand('mjml-code-to-html')?.html;
    }, 1000);

  })

})
</script>

<template>
  <div id="gjs">
    <!-- <mjml>
      <mj-body>
        <mj-section>
          <mj-column>
            <mj-text>
              Build your email
            </mj-text>
          </mj-column>
        </mj-section>
      </mj-body>
    </mjml> -->

    <mjml>

      <mj-body>

        <mj-section background-color="#f0f0f0">
          <mj-column>
            <mj-text font-style="italic" font-size="20px" color="#626262">
              My Company
            </mj-text>
          </mj-column>
        </mj-section>

        <mj-section background-url="//1.bp.blogspot.com/-TPrfhxbYpDY/Uh3Refzk02I/AAAAAAAALw8/5sUJ0UUGYuw/s1600/New+York+in+The+1960's+-+70's+(2).jpg" background-size="cover" background-repeat="no-repeat">
          <mj-column>
            <mj-text align="center" color="#fff" font-size="40px" font-family="Helvetica Neue">Slogan here</mj-text>
            <mj-button background-color="#F63A4D" href="#">
              Promotion
            </mj-button>
          </mj-column>
        </mj-section>

        <mj-section background-color="white">
          <mj-column>
            <mj-image width="350px; padding: none" src="https://picsum.photos/id/237/536/354" />
          </mj-column>
          <mj-column>
            <mj-text font-style="italic" font-size="20px" font-family="Helvetica Neue" color="#626262">
              Find amazing places
            </mj-text>
            <mj-text color="#525252">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin rutrum enim eget magna efficitur, eu semper augue semper. Aliquam erat volutpat. Cras id dui lectus. Vestibulum sed finibus lectus.</mj-text>
          </mj-column>
        </mj-section>

        <mj-section background-color="white">
          <mj-column>
            <mj-text font-style="italic" font-size="20px" font-family="Helvetica Neue" color="#626262">
              Find amazing places
            </mj-text>
            <mj-text color="#525252">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin rutrum enim eget magna efficitur, eu semper augue semper. Aliquam erat volutpat. Cras id dui lectus. Vestibulum sed finibus lectus.</mj-text>
          </mj-column>

          <mj-column>
            <mj-image width="350px; padding: none" src="https://picsum.photos/id/1060/536/354?blur=2" />
          </mj-column>
        </mj-section>

        <mj-section background-color="#e7e7e7">
          <mj-column>
            <mj-social font-size="15px" icon-size="30px" mode="horizontal">
              <mj-social-element name="facebook" href="https://mjml.io/">
                Facebook
              </mj-social-element>
              <mj-social-element name="google" href="https://mjml.io/">
                Google
              </mj-social-element>
              <mj-social-element name="twitter" href="https://mjml.io/">
                Twitter
              </mj-social-element>
            </mj-social>
          </mj-column>
        </mj-section>

        <mj-image width="1; height: 1; display:none;" src="https://ultrashots.test/track-open?email_id=123" />

      </mj-body>

    </mjml>
  </div>
</template>

<style>
.image-rounded {
  border-radius: 10px;
}

/* Primary color for the background */
.gjs-one-bg {
  @apply border-gray-300 bg-white rounded-md dark:border-gray-700 dark:bg-gray-900;
}

/* Secondary color for the text color */
.gjs-two-color {
  @apply dark:text-gray-300 text-gray-800
}

.gjs-cv-canvas {
  @apply w-[75%] max-w-[780px]
}

.gjs-pn-views-container {
  min-width: 25%;
  z-index: 1;
}

.gjs-block-label {
  font-size: 12px;
}

.gjs-toolbar {
  @apply dark:bg-gray-800 bg-gray-500
}

.gjs-block__media {
  @apply flex items-center justify-center
}

.gjs-block__media>svg {
  @apply stroke-current stroke-1 h-10 w-10
}

/* fonts loader */
.gjs-mdl-dialog {
  @apply max-w-2xl
}

.silex-form>hr {
  display: none !important;
}

.silex-form>footer {
  @apply flex justify-end items-center gap-6
}

.silex-form>footer>input {
  counter-reset: unset;
  @apply inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
}

.grapesjs-fonts select {
  /* background-color: #352d2f;
  color: #b9a5a6;
  padding: 5px;
  border: 3px solid red; */
  @apply border-gray-300 w-full rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600
}

.grapesjs-fonts input,
.grapesjs-fonts button {
  /* background-color: #352d2f;
  color: #b9a5a6;
  padding: 5px;
  border: none; */
  @apply w-full rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600
}

.grapesjs-fonts .silex-bar {
  display: flex;
}

.grapesjs-fonts .silex-bar>* {
  margin: 5px;
}

/* .grapesjs-fonts input {
  border: 2px solid red;
} */

.grapesjs-fonts button {
  /* padding: 5px;
  margin: 5px;
  padding-top: 8px; */
  @apply max-w-52 px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
}

.grapesjs-fonts .silex-list__item__footer {
  display: flex;
  justify-content: flex-end;
}
</style>
