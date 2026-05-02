<script setup lang="ts">
import type { JSONContent } from '@tiptap/core';
import { Extension } from '@tiptap/core';
import CharacterCount from '@tiptap/extension-character-count';
import Color from '@tiptap/extension-color';
import FontFamily from '@tiptap/extension-font-family';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import { Table } from '@tiptap/extension-table';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';
import TableRow from '@tiptap/extension-table-row';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import Typography from '@tiptap/extension-typography';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import { Editor, EditorContent } from '@tiptap/vue-3';
import {
    AlignCenter,
    AlignLeft,
    AlignRight,
    Bold,
    Code,
    Heading2,
    Heading3,
    Highlighter,
    Italic,
    Link2,
    List,
    ListOrdered,
    Pilcrow,
    Quote,
    Redo2,
    Rows3,
    Strikethrough,
    Table2,
    Trash2,
    Underline as UnderlineIcon,
    Undo2,
} from 'lucide-vue-next';
import { computed, onBeforeUnmount, ref, watch } from 'vue';

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        fontSize: {
            setFontSize: (fontSize: string) => ReturnType;
            unsetFontSize: () => ReturnType;
        };
    }
}

const FontSize = Extension.create<{ types: string[] }>({
    name: 'fontSize',

    addOptions() {
        return {
            types: ['textStyle'],
        };
    },

    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    fontSize: {
                        default: null,
                        parseHTML: (element) =>
                            element.style.fontSize.replace(/['"]+/g, ''),
                        renderHTML: (attributes) => {
                            if (!attributes.fontSize) {
                                return {};
                            }

                            return {
                                style: `font-size: ${attributes.fontSize}`,
                            };
                        },
                    },
                },
            },
        ];
    },

    addCommands() {
        return {
            setFontSize:
                (fontSize: string) =>
                ({ chain }) => {
                    return chain()
                        .setMark('textStyle', { fontSize })
                        .run();
                },
            unsetFontSize:
                () =>
                ({ chain }) => {
                    return chain()
                        .setMark('textStyle', { fontSize: null })
                        .removeEmptyTextStyle()
                        .run();
                },
        };
    },
});

const props = withDefaults(
    defineProps<{
        modelValue: string;
        jsonValue?: JSONContent | null;
        placeholder?: string;
    }>(),
    {
        modelValue: '',
        jsonValue: null,
        placeholder: 'Write your signal...',
    },
);

const emit = defineEmits<{
    'update:modelValue': [value: string];
    'update:jsonValue': [value: JSONContent];
}>();

const toolbarTick = ref(0);

const refreshToolbar = () => {
    toolbarTick.value++;
};

const dependOnToolbarTick = () => {
    return toolbarTick.value;
};

const fontFamilies = [
    {
        label: 'Inter',
        value: 'Inter, ui-sans-serif, system-ui, sans-serif',
    },
    {
        label: 'Serif',
        value: 'Georgia, Cambria, Times New Roman, Times, serif',
    },
    {
        label: 'Mono',
        value: 'ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace',
    },
    {
        label: 'Fantasy',
        value: 'Cinzel, Georgia, serif',
    },
];

const fontSizes = [
    '12px',
    '14px',
    '16px',
    '18px',
    '20px',
    '24px',
    '30px',
    '36px',
    '48px',
];

const editor = new Editor({
    content: props.modelValue || '<p></p>',
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3],
            },
        }),
        Underline,
        TextStyle,
        Color,
        FontSize,
        FontFamily,
        Highlight.configure({
            multicolor: true,
        }),
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Link.configure({
            openOnClick: false,
            autolink: true,
            linkOnPaste: true,
            HTMLAttributes: {
                rel: 'noopener noreferrer nofollow',
                target: '_blank',
            },
        }),
        Table.configure({
            resizable: true,
        }),
        TableRow,
        TableHeader,
        TableCell,
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
        Typography,
        CharacterCount,
    ],
    editorProps: {
        attributes: {
            class: 'dv-editor-content',
        },
    },
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
        emit('update:jsonValue', editor.getJSON());
        refreshToolbar();
    },
    onSelectionUpdate: () => {
        refreshToolbar();
    },
    onTransaction: () => {
        refreshToolbar();
    },
    onFocus: () => {
        refreshToolbar();
    },
    onBlur: () => {
        refreshToolbar();
    },
});

const characterCount = computed(() => {
    dependOnToolbarTick();

    return editor.storage.characterCount.characters();
});

const wordCount = computed(() => {
    dependOnToolbarTick();

    return editor.storage.characterCount.words();
});

const isEditorActive = (
    nameOrAttributes: string | Record<string, unknown>,
    attributes?: Record<string, unknown>,
) => {
    dependOnToolbarTick();

    if (typeof nameOrAttributes === 'string') {
        return editor.isActive(nameOrAttributes, attributes);
    }

    return editor.isActive(nameOrAttributes);
};

watch(
    () => props.modelValue,
    (value) => {
        if (editor.isDestroyed) {
            return;
        }

        const currentHtml = editor.getHTML();

        if (value !== currentHtml) {
            editor.commands.setContent(value || '<p></p>', {
                emitUpdate: false,
            });

            refreshToolbar();
        }
    },
);

onBeforeUnmount(() => {
    editor.destroy();
});

const buttonClass = (active = false) => {
    return [
        'inline-flex h-9 min-w-9 items-center justify-center rounded-lg border px-2.5 text-sm font-bold transition-all duration-200',
        active
            ? 'border-dv-cyan/45 bg-dv-cyan/15 text-dv-cyan shadow-[0_0_18px_rgba(103,185,254,0.18)]'
            : 'border-dv-cyan/15 bg-dv-void/45 text-dv-sky/75 hover:border-dv-magenta/45 hover:bg-dv-magenta/10 hover:text-dv-magenta',
    ];
};

const runCommand = (callback: () => void) => {
    callback();
    refreshToolbar();
};

const toggleBulletList = () => {
    runCommand(() => {
        editor.chain().focus().toggleBulletList().run();
    });
};

const toggleOrderedList = () => {
    runCommand(() => {
        editor.chain().focus().toggleOrderedList().run();
    });
};

const toggleBlockquote = () => {
    runCommand(() => {
        editor.chain().focus().toggleBlockquote().run();
    });
};

const setLink = () => {
    const previousUrl = editor.getAttributes('link').href as string | undefined;

    const url = window.prompt('Enter link URL', previousUrl ?? 'https://');

    if (url === null) {
        return;
    }

    if (url === '') {
        editor.chain().focus().extendMarkRange('link').unsetLink().run();
        refreshToolbar();

        return;
    }

    editor
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run();

    refreshToolbar();
};

const setFontFamily = (event: Event) => {
    const value = (event.target as HTMLSelectElement).value;

    if (!value) {
        editor.chain().focus().unsetFontFamily().run();
        refreshToolbar();

        return;
    }

    editor.chain().focus().setFontFamily(value).run();
    refreshToolbar();
};

const setFontSize = (event: Event) => {
    const value = (event.target as HTMLSelectElement).value;

    if (!value) {
        editor.chain().focus().unsetFontSize().run();
        refreshToolbar();

        return;
    }

    editor.chain().focus().setFontSize(value).run();
    refreshToolbar();
};

const setTextColor = (event: Event) => {
    const value = (event.target as HTMLInputElement).value;

    editor.chain().focus().setColor(value).run();
    refreshToolbar();
};

const setHighlightColor = (event: Event) => {
    const value = (event.target as HTMLInputElement).value;

    editor.chain().focus().toggleHighlight({ color: value }).run();
    refreshToolbar();
};
</script>

<template>
    <div
        class="overflow-hidden rounded-2xl border border-dv-cyan/25 bg-dv-void/55 shadow-[inset_0_0_22px_rgba(103,185,254,0.05)]"
    >
        <div
            class="flex flex-wrap items-center gap-2 border-b border-dv-cyan/15 bg-dv-surface/65 p-3"
        >
            <button
                type="button"
                :class="buttonClass(isEditorActive('paragraph'))"
                title="Paragraph"
                @click="
                    runCommand(() =>
                        editor.chain().focus().setParagraph().run(),
                    )
                "
            >
                <Pilcrow class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('heading', { level: 2 }))"
                title="Heading 2"
                @click="
                    runCommand(() =>
                        editor
                            .chain()
                            .focus()
                            .toggleHeading({ level: 2 })
                            .run(),
                    )
                "
            >
                <Heading2 class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('heading', { level: 3 }))"
                title="Heading 3"
                @click="
                    runCommand(() =>
                        editor
                            .chain()
                            .focus()
                            .toggleHeading({ level: 3 })
                            .run(),
                    )
                "
            >
                <Heading3 class="size-4" />
            </button>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <button
                type="button"
                :class="buttonClass(isEditorActive('bold'))"
                title="Bold"
                @click="
                    runCommand(() => editor.chain().focus().toggleBold().run())
                "
            >
                <Bold class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('italic'))"
                title="Italic"
                @click="
                    runCommand(() =>
                        editor.chain().focus().toggleItalic().run(),
                    )
                "
            >
                <Italic class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('underline'))"
                title="Underline"
                @click="
                    runCommand(() =>
                        editor.chain().focus().toggleUnderline().run(),
                    )
                "
            >
                <UnderlineIcon class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('strike'))"
                title="Strike"
                @click="
                    runCommand(() =>
                        editor.chain().focus().toggleStrike().run(),
                    )
                "
            >
                <Strikethrough class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('code'))"
                title="Inline code"
                @click="
                    runCommand(() => editor.chain().focus().toggleCode().run())
                "
            >
                <Code class="size-4" />
            </button>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <select
                class="h-9 rounded-lg border border-dv-cyan/15 bg-dv-void/60 px-2 text-sm font-semibold text-dv-sky outline-none transition focus:border-dv-cyan"
                @change="setFontFamily"
            >
                <option value="">Font</option>
                <option
                    v-for="family in fontFamilies"
                    :key="family.value"
                    :value="family.value"
                >
                    {{ family.label }}
                </option>
            </select>

            <select
                class="h-9 rounded-lg border border-dv-cyan/15 bg-dv-void/60 px-2 text-sm font-semibold text-dv-sky outline-none transition focus:border-dv-cyan"
                @change="setFontSize"
            >
                <option value="">Size</option>
                <option
                    v-for="size in fontSizes"
                    :key="size"
                    :value="size"
                >
                    {{ size }}
                </option>
            </select>

            <label
                class="inline-flex h-9 items-center gap-2 rounded-lg border border-dv-cyan/15 bg-dv-void/45 px-2.5 text-sm font-bold text-dv-sky/75 transition hover:border-dv-magenta/45 hover:text-dv-magenta"
                title="Text color"
            >
                <span>A</span>
                <input
                    type="color"
                    value="#67b9fe"
                    class="size-5 cursor-pointer rounded border-0 bg-transparent p-0"
                    @input="setTextColor"
                />
            </label>

            <label
                class="inline-flex h-9 items-center gap-2 rounded-lg border border-dv-cyan/15 bg-dv-void/45 px-2.5 text-sm font-bold text-dv-sky/75 transition hover:border-dv-magenta/45 hover:text-dv-magenta"
                title="Highlight color"
            >
                <Highlighter class="size-4" />
                <input
                    type="color"
                    value="#ea46e5"
                    class="size-5 cursor-pointer rounded border-0 bg-transparent p-0"
                    @input="setHighlightColor"
                />
            </label>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <button
                type="button"
                :class="buttonClass(isEditorActive({ textAlign: 'left' }))"
                title="Align left"
                @click="
                    runCommand(() =>
                        editor.chain().focus().setTextAlign('left').run(),
                    )
                "
            >
                <AlignLeft class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive({ textAlign: 'center' }))"
                title="Align center"
                @click="
                    runCommand(() =>
                        editor.chain().focus().setTextAlign('center').run(),
                    )
                "
            >
                <AlignCenter class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive({ textAlign: 'right' }))"
                title="Align right"
                @click="
                    runCommand(() =>
                        editor.chain().focus().setTextAlign('right').run(),
                    )
                "
            >
                <AlignRight class="size-4" />
            </button>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <button
                type="button"
                :class="buttonClass(isEditorActive('bulletList'))"
                title="Bullet list"
                @click="toggleBulletList"
            >
                <List class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('orderedList'))"
                title="Ordered list"
                @click="toggleOrderedList"
            >
                <ListOrdered class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('blockquote'))"
                title="Blockquote"
                @click="toggleBlockquote"
            >
                <Quote class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass(isEditorActive('link'))"
                title="Link"
                @click="setLink"
            >
                <Link2 class="size-4" />
            </button>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <button
                type="button"
                :class="buttonClass(isEditorActive('table'))"
                title="Insert table"
                @click="
                    runCommand(() =>
                        editor
                            .chain()
                            .focus()
                            .insertTable({
                                rows: 3,
                                cols: 3,
                                withHeaderRow: true,
                            })
                            .run(),
                    )
                "
            >
                <Table2 class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass()"
                title="Add row after"
                @click="
                    runCommand(() =>
                        editor.chain().focus().addRowAfter().run(),
                    )
                "
            >
                <Rows3 class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass()"
                title="Delete table"
                @click="
                    runCommand(() =>
                        editor.chain().focus().deleteTable().run(),
                    )
                "
            >
                <Trash2 class="size-4" />
            </button>

            <div class="mx-1 h-7 w-px bg-dv-cyan/15"></div>

            <button
                type="button"
                :class="buttonClass()"
                title="Undo"
                @click="
                    runCommand(() => editor.chain().focus().undo().run())
                "
            >
                <Undo2 class="size-4" />
            </button>

            <button
                type="button"
                :class="buttonClass()"
                title="Redo"
                @click="
                    runCommand(() => editor.chain().focus().redo().run())
                "
            >
                <Redo2 class="size-4" />
            </button>
        </div>

        <EditorContent :editor="editor" />

        <div
            class="flex flex-wrap justify-between gap-3 border-t border-dv-cyan/15 bg-dv-surface/45 px-4 py-2 text-xs font-semibold text-muted-foreground"
        >
            <span>{{ wordCount }} words</span>
            <span>{{ characterCount }} characters</span>
        </div>
    </div>
</template>