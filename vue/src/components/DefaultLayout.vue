<template>
  <div class="h-full w-full">
    <Disclosure as="nav" class="bg-gray-600" v-slot="{ open }">
      <div class="m-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img
                class="h-8 w-8"
                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                alt="Your Company"
              />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <router-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.to"
                  active-class="bg-gray-900 text-white"
                  :class="[
                    this.$route.name === item.to.name
                      ? ''
                      : 'text-white hover:bg-gray-700 hover:text-white',
                    'rounded-md px-3 py-2 text-sm font-medium',
                  ]"
                  >{{ item.name }}</router-link
                >
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <!-- Profile dropdown -->
              <Menu as="div" class="relative ml-3">
                <div>
                  <MenuButton
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 w-11 h-11"
                  >
                    <span class="sr-only">Open user menu</span>
                    <img src="../assets/lines.svg" class="w-full self-center" />
                  </MenuButton>
                </div>
                <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
                >
                  <MenuItems
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  >
                    <MenuItem v-if="Object.keys(user).length != 0">
                      <a
                        @click="logout"
                        :class="[
                          'block px-4 py-2 text-sm text-gray-500 cursor-pointer',
                        ]"
                        >Logout</a
                      >
                    </MenuItem>
                    <span v-else>
                      <MenuItem>
                        <router-link
                          :to="{ name: 'Login' }"
                          :class="[
                            'block px-4 py-2 text-sm text-gray-500 cursor-pointer',
                          ]"
                          >Log In</router-link
                        >
                      </MenuItem>
                      <MenuItem>
                        <router-link
                          :to="{ name: 'Register' }"
                          :class="[
                            'block px-4 py-2 text-sm text-gray-500 cursor-pointer',
                          ]"
                          >Register</router-link
                        >
                      </MenuItem>
                    </span>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton
              class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
            >
              <span class="sr-only">Open main menu</span>
              <img
                v-if="!open"
                src="../assets/lines.svg"
                class="block h-6 w-6 self-center"
                alt="Your Company"
              />
              <img
                v-else
                src="../assets/lines.svg"
                class="block h-6 w-6 self-center"
                alt="Your Company"
              />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <router-link
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            active-class="bg-gray-900 text-white"
            :class="[
              this.$route.name === item.to.name
                ? ''
                : 'text-white hover:bg-gray-400',
              'block rounded-md px-3 py-2 text-base font-medium',
            ]"
            >{{ item.name }}</router-link
          >
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">
                {{ user.name }}
              </div>
              <div class="text-sm font-medium leading-none text-gray-400">
                {{ user.email }}
              </div>
            </div>
          </div>
          <div class="mt-3 space-y-1 px-2">
            <div v-if="Object.keys(user).length != 0">
              <DisclosureButton
                as="a"
                @click="logout"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white cursor-pointer"
                >Logout</DisclosureButton
              >
            </div>
            <div v-else></div>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <router-view></router-view>
  </div>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { Bars3Icon, BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRouter } from "vue-router";
const navigation = [
  { name: "Dashboard", to: { name: "Dashboard" }, current: true },
  { name: "Offers", to: { name: "Offers" }, current: false },
  { name: "Companies", to: { name: "Companies" }, current: false },
];

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    function logout() {
      store.dispatch("logout").then(() => {
        router.push({
          name: "Login",
        });
      });
    }

    return {
      user: computed(() => store.state.user.data),
      navigation,
      logout,
    };
  },
};
</script>

<style scoped lang="scss"></style>
