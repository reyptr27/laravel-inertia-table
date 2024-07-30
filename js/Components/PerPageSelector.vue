<template>
  <select
    name="per_page"
    :dusk="dusk"
    :value="value"
    :class="getTheme('select')"
    @change="onChange($event.target.value)"
  >
    <option
      v-for="option in perPageOptions"
      :key="option"
      :value="option"
    >
      {{ option }} {{ translations.per_page }}
    </option>
  </select>
</template>

<script setup>
import { computed, inject } from "vue";
import uniq from "lodash-es/uniq";
import { getTranslations } from "../translations.js";
import { twMerge } from "tailwind-merge";
import { get_theme_part } from "../helpers.js";

const translations = getTranslations();

const props = defineProps({
    dusk: {
        type: String,
        default: null,
        required: false,
    },

    value: {
        type: Number,
        default: 15,
        required: false,
    },

    options: {
        type: Array,
        default() {
            return [15, 30, 50, 100];
        },
        required: false,
    },

    onChange: {
        type: Function,
        required: true,
    },

    color: {
        type: String,
        default: "primary",
        required: false,
    },

    ui: {
        required: false,
        type: Object,
    },
});

const perPageOptions = computed(() => {
    let options = [...props.options];

    options.push(parseInt(props.value));

    return uniq(options).sort((a, b) => a - b);
});

// Theme
const fallbackTheme = {
    select: {
        base: "block min-w-max shadow-sm text-sm rounded-md",
        color: {
            primary: "border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
        },
    },
};
const themeVariables = inject("themeVariables");
const getTheme = (item) => {
    return twMerge(
        get_theme_part([item, "base"], fallbackTheme, themeVariables?.inertia_table?.per_page_selector, props.ui),
        get_theme_part([item, "color", props.color], fallbackTheme, themeVariables?.inertia_table?.per_page_selector, props.ui),
    );
};
</script>