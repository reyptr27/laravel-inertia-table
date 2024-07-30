<template>
  <div
    v-for="(searchInput, key) in searchInputs"
    v-show="searchInput.value !== null || isForcedVisible(searchInput.key)"
    :key="key"
    class="px-4 sm:px-0"
  >
    <div class="flex rounded-md shadow-sm relative mt-3">
      <label
        :for="searchInput.key"
        class="inline-flex items-center px-4 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2 text-gray-400"

          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
            clip-rule="evenodd"
          />
        </svg>
        <span>{{ searchInput.label }}</span></label>
      <input
        :id="searchInput.key"
        :ref="skipUnwrap.el"
        :key="searchInput.key"
        :name="searchInput.key"
        :value="searchInput.value"
        type="text"
        :class="getTheme('input')"
        @input="onChange(searchInput.key, $event.target.value)"
      >
      <div
        class="absolute inset-y-0 right-0 pr-3 flex items-center"
      >
        <button
          :class="getTheme('remove_button')"
          :dusk="`remove-search-row-${searchInput.key}`"
          @click.prevent="onRemove(searchInput.key)"
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
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch, nextTick, inject } from "vue";
import find from "lodash-es/find";
import { twMerge } from "tailwind-merge";
import { get_theme_part } from "../helpers.js";

const skipUnwrap = { el: ref([]) };
let el = computed(() => skipUnwrap.el.value);

const props = defineProps({
    searchInputs: {
        type: Object,
        required: true,
    },

    forcedVisibleSearchInputs: {
        type: Array,
        required: true,
    },

    onChange: {
        type: Function,
        required: true,
    },

    onRemove: {
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

function isForcedVisible(key) {
    return props.forcedVisibleSearchInputs.includes(key);
}

watch(props.forcedVisibleSearchInputs, (inputs) => {
    const latestInput = inputs.length > 0 ? inputs[inputs.length -1] : null;

    if(!latestInput) {
        return;
    }

    nextTick().then(() => {
        const inputElement = find(el.value, (el) => {
            return el.name ===  latestInput;
        });

        if(inputElement) {
            inputElement.focus();
        }
    });
}, { immediate: true });

// Theme
const fallbackTheme = {
    input: {
        base: "flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md text-sm",
        color: {
            primary: "border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
        },
    },
    remove_button: {
        base: "rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2",
        color: {
            primary: "text-gray-400 hover:text-gray-500 focus:ring-indigo-500"
        },
    },
};
const themeVariables = inject("themeVariables");
const getTheme = (item) => {
    return twMerge(
        get_theme_part([item, "base"], fallbackTheme, themeVariables?.inertia_table?.table_search_rows, props.ui),
        get_theme_part([item, "color", props.color], fallbackTheme, themeVariables?.inertia_table?.table_search_rows, props.ui),
    );
};
</script>