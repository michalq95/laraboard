<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-3x1 font-bold">
                    {{ model.id ? model.title : "Create new offer" }}
                </h1>
            </div>
        </template>

        <form @submit.prevent="saveOffer">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Image</label
                        >
                        <div class="mt1 flex items-center">
                            <img
                                v-if="model.image"
                                :src="model.image"
                                :alt="model.title"
                                class="w-64 object-cover"
                            />
                            <span
                                v-else
                                class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[80%] w-[80%] text-gray-300"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                            <button
                                type="button"
                                class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <input
                                    type="file"
                                    @change="onImageChoose"
                                    class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                />
                                Change
                            </button>
                        </div>
                    </div>
                    <!--/ Image -->

                    <!-- Title -->
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Title</label
                        >
                        <input
                            type="text"
                            name="title"
                            id="title"
                            v-model="model.title"
                            autocomplete="offer_title"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700"
                            >Status</label
                        >
                        <input
                            type="text"
                            name="status"
                            id="status"
                            v-model="model.status"
                            autocomplete="offer_status"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >description</label
                        >
                        <input
                            type="text"
                            name="description"
                            id="description"
                            v-model="model.description"
                            autocomplete="offer_description"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <div>
                        <label
                            for="bracket_low"
                            class="block text-sm font-medium text-gray-700"
                            >bracket_low</label
                        >
                        <input
                            type="number"
                            name="bracket_low"
                            id="bracket_low"
                            v-model="model.bracket_low"
                            autocomplete="offer_bracket_low"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>

                    <div>
                        <label
                            for="bracket_high"
                            class="block text-sm font-medium text-gray-700"
                            >bracket_high</label
                        >
                        <input
                            type="number"
                            name="bracket_high"
                            id="bracket_high"
                            v-model="model.bracket_high"
                            autocomplete="offer_bracket_high"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="status"
                                name="status"
                                type="checkbox"
                                v-model="model.status"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label
                                for="status"
                                class="font-medium text-gray-700"
                                >Active</label
                            >
                        </div>
                    </div>
                    <div>
                        <label
                            for="bracket_high"
                            class="block text-sm font-medium text-gray-700"
                            >bracket_high</label
                        >
                        <input
                            type="number"
                            name="bracket_high"
                            id="bracket_high"
                            v-model="model.bracket_high"
                            autocomplete="offer_bracket_high"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <h3
                            class="text-2xl font-semibold flex items-center justify-between"
                        >
                            Tags

                            <select
                                id="available_tags"
                                name="available_tags"
                                v-model="selected"
                                @change="addTag()"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 ring-indigo-400 border-indigo-00 block w-60 shadow-sm sm:text-sm rounded-md"
                            >
                                <option value="tags" disabled hidden selected>
                                    tags
                                </option>
                                <option
                                    v-for="tag in availableTags"
                                    :key="tag"
                                    :value="tag"
                                >
                                    {{ tag }}
                                </option>
                            </select>
                            <input
                                v-model="filterText"
                                type="text"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 ring-indigo-400 border-indigo-00 block w-60 shadow-sm sm:text-sm rounded-md"
                            />
                            <button
                                type="button"
                                @click="addCustomTag()"
                                class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Add Tag
                            </button>
                        </h3>
                        <div class="flex flex-wrap">
                            <span
                                v-for="tag in model.tags"
                                class="text-center text-gray-600 p-5"
                            >
                                {{ tag
                                }}<span
                                    @click="removeTag(tag)"
                                    class="bg-red-500 border-red-600 rounded-full px-2 cursor-pointer"
                                    >X</span
                                >
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </PageComponent>
</template>
<script setup>
import { ref, computed } from "vue";
import store from "../store";
import { useRoute } from "vue-router";
import PageComponent from "../components/PageComponent.vue";

const route = useRoute();
let model = ref({
    title: "",
    status: "",
    description: null,
    bracket_low: null,
    bracket_high: null,
    tags: [],
});
let filterText = ref("");
let selected = null;

function addTag() {
    model.value.tags.push(selected);
}

function addCustomTag() {
    model.value.tags.push(filterText.value);
    filterText.value = "";
}

function removeTag(tag) {
    model.value.tags = model.value.tags.filter((el) => el !== tag);
}

let availableTags = computed(() => {
    return store.state.tags
        .filter((el) => !model.value.tags.includes(el))
        .filter((el) => el.includes(filterText.value));
});

if (route.params.id) {
    model.value = store.state.offers.find(
        (s) => s.id === parseInt(route.params.id)
    );
}
</script>
<style lang=""></style>
