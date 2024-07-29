<template>
  <div class="w-full flex gap-2 justify-between items-center">
    <label class="relative inline-flex items-center cursor-pointer">
      <input
        type="checkbox"
        :checked="filter.value"
        class="sr-only peer"
        @change="onFilterChange(filter.key, $event.target.checked ? '1' : '0')"
      >
      <div
        class="peer-focus:outline-none peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:transition-all"
        :class="getTheme('toggle')"
      />
    </label>
    <button
      :class="getTheme('reset_button')"
      @click.prevent="onFilterChange(filter.key, null)"
    >
      <span class="sr-only">Remove search</span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { inject } from "vue";
import { twMerge } from "tailwind-merge";
import { get_theme_part } from "../../helpers.js";

const props = defineProps({
    filter: {
        type: Object,
        required: true,
    },

    onFilterChange: {
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

// Theme
const fallbackTheme = {
    toggle: {
        base: "w-11 h-6 rounded-full after:border after:rounded-full after:h-5 after:w-5",
        color: {
            primary: "after:bg-white after:border-white peer-checked:bg-indigo-500 bg-red-500",
            disabled: "after:bg-white after:border-white bg-gray-200",
        },
    },
    reset_button: {
        base: "rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2",
        color: {
            primary: "text-gray-400 hover:text-gray-500 focus:ring-indigo-500",
        },
    },
};
const themeVariables = inject("themeVariables");
const getTheme = (item) => {
    let color = props.color;
    if (item === "toggle" && props.filter.value === null) {
        color = "disabled";
    }
    return twMerge(
        get_theme_part([item, "base"], fallbackTheme, themeVariables?.inertia_table?.table_filter?.toggle_filter, props.ui),
        get_theme_part([item, "color", color], fallbackTheme, themeVariables?.inertia_table?.table_filter?.toggle_filter, props.ui),
    );
};
</script>