<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true"/>
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="block h-8 w-auto lg:hidden" src="/logo/logo.png" alt="tdd"/>
                        <img class="hidden h-8 w-auto lg:block" src="/logo/logo.png" alt="tdd"/>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <div v-for="item in navigation">
                                <Menu as="div" class="relative" v-if="item.has_children">
                                    <div>
                                        <MenuButton
                                            class="flex text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                                            {{ item.name }}
                                            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                 fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </MenuButton>
                                    </div>
                                    <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems
                                            class="absolute z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            <MenuItem v-slot="{ active }" v-for="childrenItem in item.children">
                                                <a :href="childrenItem.href"
                                                   :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{
                                                        childrenItem.name
                                                    }}</a>
                                            </MenuItem>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                                <a v-else :key="item.name" :href="item.href"
                                   :class="[item.current ? 'flex bg-gray-900 text-white' : 'flex text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                   :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                                    <svg v-if="item.has_children" class="-mr-1 h-5 w-5 text-gray-400"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <Menu v-if="signIn" as="div" class="relative ml-3">
                        <div>
                            <MenuButton
                                class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">打开用户菜单</span>
                                <img class="h-8 w-8 rounded-full"
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt=""/>
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                    <a :href="'/profiles/'+user.name"
                                       :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">个人中心</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a  @click="logout" href="#"
                                       :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">退出</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <div v-else class="flex">
                        <a href="/login" class="flex text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                            登录
                        </a>

                        <a href="/register" class="flex text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                            注册
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                                  :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                  :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                </DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, BellIcon, XMarkIcon} from '@heroicons/vue/24/outline'


</script>

<script>
export default {
    props: ["channels"],
    data() {
        let navigation = [
            {name: '浏览', href: '/threads', current: true, has_children: true, children: getAllViewChildren()},
            {
                name: '频道',
                href: '/threads',
                current: false,
                has_children: true,
                children: getChannelChildren(this.channels)
            },
            {name: '发帖', href: '/threads/create', current: false, has_children: false, children: []},
        ];
        return {
            navigation: navigation,
        }
    },
    computed: {
        signIn() {
            return window.App.signIn;
        },
        user() {
            return window.App.user;
        }
    },
    methods: {
        logout() {
            axios.post('/logout');

            // $(this.$el).fadeOut(300, () => {
            //     // flash('Your reply has been deleted!');
            // });
        }
    }
}

function getAllViewChildren() {
    let all_view_children = [];
    all_view_children.push({name: '全部帖子', href: '/threads', current: false, has_children: false, children: []});
    all_view_children.push({
        name: '热门帖子',
        href: '/threads?popularity=1',
        current: false,
        has_children: false,
        children: []
    });
    all_view_children.push({
        name: '无回复帖子',
        href: '/threads?unanswered=1',
        current: false,
        has_children: false,
        children: []
    });
    if (window.App.signIn) {
        all_view_children.push({
            name: '我的帖子',
            href: '/threads?by=' + window.App.user.name,
            current: false,
            has_children: false,
            children: []
        });
    }
    return all_view_children;
}

function getChannelChildren(channels) {
    let channelChildren = [];
    channels.forEach(function (channel) {
        let children = {};
        children.name = channel.name;
        children.href = "/threads/" + channel.slug;
        children.current = false;
        children.has_children = false;
        children.children = [];
        channelChildren.push(children);
    });
    return channelChildren;
}

</script>

<style scoped>

</style>
