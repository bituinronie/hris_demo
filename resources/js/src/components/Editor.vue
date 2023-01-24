<template>
    <div class="md-layout" style="width: 100%">
        <div v-if="editor" class="md-layout-item md-size-100 text-right">
            <md-button
                @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'is-active': editor.isActive('bold') }"
                class="md-simple format-button"
            >
                <md-icon
                    :style="
                        editor.isActive('bold') && 'color: black !important'
                    "
                    >format_bold</md-icon
                >
            </md-button>
            <md-button
                @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'is-active': editor.isActive('italic') }"
                class="md-simple format-button"
            >
                <md-icon
                    :style="
                        editor.isActive('italic') && 'color: black !important'
                    "
                    >format_italic</md-icon
                >
            </md-button>
            <md-button
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'is-active': editor.isActive('underline') }"
                class="md-simple format-button"
            >
                <md-icon
                    :style="
                        editor.isActive('underline') &&
                        'color: black !important'
                    "
                    >format_underlined</md-icon
                >
            </md-button>
            <md-button
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'is-active': editor.isActive('orderedList') }"
                class="md-simple format-button"
            >
                <md-icon
                    :style="
                        editor.isActive('orderedList') &&
                        'color: black !important'
                    "
                    >format_list_numbered</md-icon
                >
            </md-button>
            <md-button
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active': editor.isActive('bulletList') }"
                class="md-simple format-button"
            >
                <md-icon
                    :style="
                        editor.isActive('bulletList') &&
                        'color: black !important'
                    "
                    >format_list_bulleted</md-icon
                >
            </md-button>
        </div>
        <div class="md-layout-item md-size-100" style="padding: 0px">
            <editor-content :editor="editor" />
        </div>
    </div>
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-2";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import BulletList from "@tiptap/extension-bullet-list";
import OrderedList from "@tiptap/extension-ordered-list";
import ListItem from "@tiptap/extension-list-item";
import Paragraph from "@tiptap/extension-paragraph";
import Text from "@tiptap/extension-text";

export default {
    components: {
        EditorContent,
    },

    props: {
        modelValue: {
            type: String,
        },
    },

    data() {
        return {
            editor: null,
            emitAfterOnUpdate: false,
        };
    },

    watch: {
        modelValue(val) {
            if (this.emitAfterOnUpdate) {
                this.emitAfterOnUpdate = false;
                return;
            }
            if (this.editor) this.editor.setContent(val);
        },
    },

    created() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Underline,
                Paragraph,
                Text,
                ListItem,
                OrderedList,
                BulletList,
            ],
            content: this.modelValue,
            onUpdate: () => {
                this.emitAfterOnUpdate = true;

                // HTML
                this.$emit("input", this.editor.getHTML());

                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        });
        this.editor.commands.setContent(this.modelValue);
    },

    beforeUnmount() {
        this.editor.destroy();
    },
};
</script>

<style lang="scss">
.text-black {
    color: black !important;
}

.format-button .md-ripple {
    padding: 0px !important;
}

.format-button.md-button {
    min-width: 30px;
    // border: 1px solid black;
    margin: 0px !important;
}

/* Basic editor styles */
.ProseMirror {
    margin-top: 1rem;
    border: 1px solid gray;
    padding: 20px;

    > * + * {
        margin-top: 0.75em;
    }

    ul,
    ol {
        padding: 0 1rem;
    }
}
</style>
