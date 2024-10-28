<script setup>
import {
IconAlignCenter,
IconAlignLeft,
IconAlignRight,
IconBold,
IconH1,
IconH2,
IconH3,
IconIndentDecrease,
IconIndentIncrease,
IconItalic,
IconLetterP,
IconList,
IconListNumbers,
IconListTree,
IconStrikethrough,
} from '@tabler/icons-vue'
import { mergeAttributes } from '@tiptap/core'
import Bold from '@tiptap/extension-bold'
import BulletList from '@tiptap/extension-bullet-list'
import Document from '@tiptap/extension-document'
import Heading from '@tiptap/extension-heading'
import Italic from '@tiptap/extension-italic'
import ListItem from '@tiptap/extension-list-item'
import OrderedList from '@tiptap/extension-ordered-list'
import Paragraph from '@tiptap/extension-paragraph'
import Placeholder from '@tiptap/extension-placeholder'
import Text from '@tiptap/extension-text'
import TextAlign from '@tiptap/extension-text-align'
import TextStyle from '@tiptap/extension-text-style'
import Typography from '@tiptap/extension-typography'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import { Editor, EditorContent } from '@tiptap/vue-3'
import { watch } from 'vue'

import { BubbleMenu, FloatingMenu } from '@tiptap/vue-3'
import { onBeforeUnmount, onMounted, ref } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },

  placeholder: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['update:modelValue'])

const editor = ref()

watch(() => props.modelValue, (value) => {
  const isSame = editor.value.getHTML() === value

  if (isSame) {
    return
  }

  editor.value.commands.setContent(value, false)
})

onMounted(() => {
  editor.value = new Editor({

    content: props.modelValue,

    onUpdate: () => {
      emits('update:modelValue', editor.value.getHTML())
    },

    editorProps: {
      attributes: {
        class: 'prose w-full dark:prose-invert prose-sm sm:prose lg:prose-md mx-auto focus:outline-none p-2 scrollbar-none scroll-smooth shadow-sm rounded-b-md h-64 overflow-y-auto',
      },
    },

    extensions: [
      Document,
      Italic,
      Text,
      TextStyle,
      Bold,
      Typography,
      Underline,
      BulletList,
      OrderedList,
      ListItem,
      Strike,
      Placeholder.configure({
        // placeholder: 'Write some notes …',
        // Use different placeholders depending on the node type:
        placeholder: ({ node }) => {
          if (node.type.name === 'heading') {
            return 'Enter a title for the note'
          }

          return props.placeholder ?? 'Write some notes'
        },
      }),
      TextAlign.configure({
        types: ['heading', 'paragraph'],
      }),
      Paragraph.configure({
        HTMLAttributes: {
          class: `text-lg ${props.modelValue.length ? 'dark:text-neutral-100 text-gray-800' : 'text-gray-500'}`,
        },
      }),
      Heading.configure({ levels: [2, 3, 4] }).extend({
        levels: [2, 3, 4],
        renderHTML({ node, HTMLAttributes }) {
          const level = this.options.levels.includes(node.attrs.level)
            ? node.attrs.level
            : this.options.levels[0]
          const classes = {
            2: 'text-2xl text-gray-800 dark:text-gray-100 mb-2 font-semibold',
            3: 'text-xl text-gray-800 dark:text-gray-100 mb-2 font-semibold',
            4: 'text-lg text-gray-800 dark:text-gray-100 mb-2 font-semibold',
          }
          return [
            `h${level}`,
            mergeAttributes(this.options.HTMLAttributes, HTMLAttributes, {
              class: `${classes[level]}`,
            }),
            0,
          ]
        },
      })
    ]
  })
}),

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>

<template>
  <div v-if="editor">
    <section class="flex items-center justify-start gap-6 overflow-hidden overflow-x-auto scrollbar-none scroll-smooth">
      <!-- <input
        type="color"
        @input="editor.chain().focus().setColor($event.target.value).run()"
        :value="editor.getAttributes('textStyle').color ?? '#548898'" /> -->

      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'is-active': editor.isActive('bulletList') }"
        class="p-2 sm:p-0.5 bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-50 hover:opacity-75 transition duration-300 rounded-md">
        <IconList />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ 'is-active': editor.isActive('orderedList') }"
        class="p-2 sm:p-0.5 bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-50 hover:opacity-75 transition duration-300 rounded-md">
        <IconListNumbers />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().splitListItem('listItem').run()"
        :disabled="!editor.can().splitListItem('listItem')"
        class="p-2 sm:p-0.5 bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-50 hover:opacity-75 transition duration-300 rounded-md">
        <IconListTree />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().sinkListItem('listItem').run()"
        :disabled="!editor.can().sinkListItem('listItem')"
        class="p-2 sm:p-0.5 bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-50 hover:opacity-75 transition duration-300 rounded-md">
        <IconIndentIncrease />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().liftListItem('listItem').run()"
        :disabled="!editor.can().liftListItem('listItem')"
        class="p-2 sm:p-0.5 bg-gray-300 text-gray-500 dark:bg-gray-600 dark:text-gray-50 hover:opacity-75 transition duration-300 rounded-md">
        <IconIndentDecrease />
      </button>
    </section>

    <bubble-menu
      class="bubble-menu"
      :tippy-options="{ duration: 100 }"
      :editor="editor">
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :class="{ 'is-active': editor.isActive('bold') }">
        <IconBold />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :class="{ 'is-active': editor.isActive('italic') }">
        <IconItalic />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleStrike().run()"
        :class="{ 'is-active': editor.isActive('strike') }">
        <IconStrikethrough />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().setParagraph().run()"
        :class="{ 'is-active': editor.isActive('paragraph') }">
        <IconLetterP />
      </button>

      <button
        @click="editor.chain().focus().setTextAlign('left').run()"
        :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }"
        type="button">
        <IconAlignLeft />
      </button>

      <button
        @click="editor.chain().focus().setTextAlign('center').run()"
        :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }"
        type="button">
        <IconAlignCenter />
      </button>

      <button
        @click="editor.chain().focus().setTextAlign('right').run()"
        :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }"
        type="button">
        <IconAlignRight/>
      </button>

<!--      <button-->
<!--        type="button"-->
<!--        @click="editor.chain().focus().unsetColor().run()">-->
<!--        <IconColorSwatchOff />-->
<!--      </button>-->
    </bubble-menu>

    <floating-menu
      class="floating-menu"
      :tippy-options="{ duration: 100 }"
      :editor="editor">
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
        <IconH1 />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
        <IconH2 />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
        :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
        <IconH3 />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().setParagraph().run()"
        :class="{ 'is-active': editor.isActive('paragraph') }">
        <IconLetterP />
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'is-active': editor.isActive('bulletList') }">
        <IconList />
      </button>
    </floating-menu>
  </div>

  <editor-content :editor="editor" />
</template>


<style lang="scss">
.tiptap {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }

  blockquote {
    padding-left: 1rem;
    border-left: 2px solid rgba(#0D0D0D, 0.1);
  }
}

.bubble-menu {
  display: flex;
  background-color: #0D0D0D;
  padding: 0.2rem;
  border-radius: 0.5rem;

  button {
    border: none;
    background: none;
    color: #FFF;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0 0.2rem;
    opacity: 0.6;

    &:hover,
    &.is-active {
      opacity: 1;
    }
  }
}

.floating-menu {
  display: flex;
  padding: 0.2rem;
  border-radius: 0.5rem;

  button {
    border: none;
    background: none;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0 0.2rem;
    opacity: 0.6;

    &:hover,
    &.is-active {
      opacity: 1;
    }
  }
}
</style>
