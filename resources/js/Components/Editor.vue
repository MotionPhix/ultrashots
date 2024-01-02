<script>
import Heading from '@tiptap/extension-heading'
import Placeholder from '@tiptap/extension-placeholder'
import Underline from '@tiptap/extension-underline'
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent, mergeAttributes } from '@tiptap/vue-3'
import Icon from './Icon.vue'
import MenuButton from './MenuButton.vue'

export default {
  name: 'Editor',
  components: {
    EditorContent,
    MenuButton,
    Icon,
  },
  props: {
    modelValue: {
      type: String,
      default: '',
    },

    placeholder: {
      type: String,
      default: 'Write a thing or two ...',
    },

    activeButtons: {
      type: Array,
      validator(list) {
        for (const el of list) {
          // The value must match one of these strings
          if (
            ![
              'bold',
              'italic',
              'strike',
              'underline',
              'code',
              'h2',
              'h3',
              'h4',
              'bulletList',
              'orderedList',
              'blockquote',
              'codeBlock',
              'horizontalRule',
              'undo',
              'redo',
            ].includes(el)
          )
            return -1
        }
        return 1
      },
      default: () => ['bold', 'italic'],
    },
  },
  emits: ['update', 'update:modelValue'],
  data() {
    return {
      html: '',
      json: '',
      editor: null,
    }
  },
  created() {
    this.editor = new Editor({
      content: this.modelValue,
      extensions: [
        StarterKit.configure({
          heading: false,
          paragraph: {
            HTMLAttributes: {
              class: 'text-lg',
            },
          },
        }),
        Underline,
        Placeholder.configure({
          placeholder: this.placeholder,
        }),
        Heading.extend({
          levels: [2, 3, 4],
          renderHTML({ node, HTMLAttributes }) {
            const level = this.options.levels.includes(node.attrs.level)
              ? node.attrs.level
              : this.options.levels[0]
            const classes = {
              2: 'text-3xl',
              3: 'text-2xl',
              4: 'text-xl',
            }
            return [
              `h${level}`,
              mergeAttributes(this.options.HTMLAttributes, HTMLAttributes, {
                class: `${classes[level]}`,
              }),
              0,
            ]
          },
        }).configure({ levels: [2, 3, 4] }),
      ],
    })

    this.html = this.editor.getHTML()
    this.json = this.editor.getJSON()

    this.editor.on('update', () => {
      this.html = this.editor.getHTML()
      this.json = this.editor.getJSON()
      // this.$emit('update', this.html);
      this.$emit('update:modelValue', this.html)
    })
  },
  beforeUnmount() {
    this.editor.destroy()
  },
}
</script>

<template>
  <div>
    <div class="flex gap-1 menubar">
      <span v-for="actionName in activeButtons" :key="actionName" class="empty:hidden">
        <MenuButton
          v-if="actionName === 'bold'" type="button" :class="{ 'is-active': editor.isActive('bold') }"
          @click="editor.chain().focus().toggleBold().run()"
        >
          <Icon name="Bold" />
        </MenuButton>

        <MenuButton
          v-if="actionName === 'italic'" type="button" :class="{ 'is-active': editor.isActive('italic') }"
          @click="editor.chain().focus().toggleItalic().run()"
        >
          <Icon name="Italic" />
        </MenuButton>

        <!-- <MenuButton
          type="button"
          v-if="actionName === 'strike'"
          :class="{ 'is-active': editor.isActive('strike') }"
          @click="editor.chain().focus().toggleStrike().run()"
        >
          <icon name="strike" />
        </MenuButton> -->

        <MenuButton
          v-if="actionName === 'underline'" type="button" :class="{ 'is-active': editor.isActive('underline') }"
          @click="editor.chain().focus().toggleUnderline().run()"
        >
          <Icon name="Underline" />
        </MenuButton>

        <!-- <MenuButton
          type="button"
          v-if="actionName === 'code'"
          :class="{ 'is-active': editor.isActive('code') }"
          @click="editor.chain().focus().toggleCode().run()"
        >
          <icon name="code" />
        </MenuButton> -->

        <MenuButton
          v-if="actionName === 'h2'" type="button"
          :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }"
          @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        >
          <Icon name="H2" />
        </MenuButton>

        <MenuButton
          v-if="actionName === 'h3'" type="button"
          :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }"
          @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        >
          <Icon name="H3" />
        </MenuButton>

        <MenuButton
          v-if="actionName === 'h4'" type="button" class="hidden sm:inline-flex"
          :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }"
          @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
        >
          <Icon name="H4" />
        </MenuButton>

        <!-- <MenuButton
          type="button"
          v-if="actionName === 'bulletList'"
          :class="{ 'is-active': editor.isActive('bulletList') }"
          @click="editor.chain().focus().toggleBulletList().run()"
        >
          <icon name="Ul" />
        </MenuButton>

        <MenuButton
          type="button"
          v-if="actionName === 'orderedList'"
          :class="{ 'is-active': editor.isActive('orderedList') }"
          @click="editor.chain().focus().toggleOrderedList().run()"
        >
          <icon name="Ol" />
        </MenuButton> -->

        <!-- <MenuButton
          type="button"
          v-if="actionName === 'blockquote'"
          :class="{ 'is-active': editor.isActive('blockquote') }"
          @click="editor.chain().focus().toggleBlockquote().run()"
        >
          <icon name="quote" />
        </MenuButton> -->

        <!-- <MenuButton
          type="button"
          v-if="actionName === 'codeBlock'"
          :class="{ 'is-active': editor.isActive('codeBlock') }"
          @click="editor.chain().focus().toggleCodeBlock().run()"
        >
          <icon name="code" />
        </MenuButton> -->

        <MenuButton
          v-if="actionName === 'horizontalRule'" type="button" class="hidden sm:inline-flex"
          @click="editor.chain().focus().setHorizontalRule().run()"
        >
          <Icon name="Hr" />
        </MenuButton>

        <MenuButton v-if="actionName === 'undo'" type="button" @click="editor.chain().focus().undo().run()">
          <Icon name="Undo" />
        </MenuButton>

        <MenuButton v-if="actionName === 'redo'" type="button" @click="editor.chain().focus().redo().run()">
          <Icon name="Redo" />
        </MenuButton>
      </span>
    </div>

    <div class="py-2 bg-white rounded-b-lg dark:bg-gray-800">
      <EditorContent :editor="editor" />
    </div>
  </div>
</template>

<style>
.is-active {
  background-color: rgba(black, 0.1);
}
  .tiptap p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    @apply text-gray-600 dark:text-gray-400;
    pointer-events: none;
    height: 0;
  }
</style>

<style lang="scss">
$color-black: #000000;
$color-white: #ffffff;
$color-grey: #dddddd;

.menubar {

margin-bottom: 1rem;
transition: visibility 0.2s 0.4s, opacity 0.2s 0.4s;

&.is-hidden {
  visibility: hidden;
  opacity: 0;
}

&.is-focused {
  visibility: visible;
  opacity: 1;
  transition: visibility 0.2s, opacity 0.2s;
}

&__button {
  vertical-align: middle;
  width: 1.8rem;
  height: 1.2rem;
  font-weight: bold;
  display: inline-flex;
  background: transparent;
  border: 0;
  color: $color-black;
  padding: 0.2rem 0.5rem;
  margin-right: 0.2rem;
  border-radius: 3px;
  cursor: pointer;

  &:hover {
    background-color: rgba($color-black, 0.05);
  }

  &.is-active {
    background-color: rgba($color-black, 0.1);
  }
}

span#{&}__button {
  font-size: 13.3333px;
}
}
</style>
