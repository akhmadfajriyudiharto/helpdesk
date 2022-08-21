<template>
    <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Tickets') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md mr-4"
                        to="/dashboard/tickets/new"
                    >
                        {{ $t('Create ticket') }}
                    </router-link>
                    <div class="rounded-md shadow-sm mr-4">
                        <button
                            id="filter-button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-400 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                            type="button"
                            @click="openFiltersSidebar"
                        >
                            <svg-vue class="self-center mr-3 h-4 w-4" icon="font-awesome.filter-regular"></svg-vue>
                            {{ $t('Filters') }}
                            <svg-vue class="self-center ml-2.5 -mr-1.5 h-3 w-3" icon="font-awesome.chevron-right-solid"></svg-vue>
                        </button>
                        <div v-show="filtersSidebar" class="fixed inset-0 overflow-hidden z-30">
                            <div class="absolute inset-0 overflow-hidden">
                                <section v-on-clickaway="closeFiltersSidebar" :style="{top: '65px'}" class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                                    <transition
                                        duration="500"
                                        enter-active-class="transform transition ease-in-out duration-500"
                                        enter-class="translate-x-full"
                                        enter-to-class="translate-x-0"
                                        leave-active-class="transform transition ease-in-out duration-500"
                                        leave-class="translate-x-0"
                                        leave-to-class="translate-x-full"
                                    >
                                        <div v-show="filtersSidebar" class="w-screen max-w-xs">
                                            <div class="h-full flex flex-col space-y-4 bg-white shadow-xl">
                                                <header class="px-4 pt-4 sm:px-6">
                                                    <div class="flex items-start justify-between space-x-3">
                                                        <h2 class="text-lg leading-7 font-medium text-gray-900">
                                                            {{ $t('Filters') }}
                                                        </h2>
                                                        <div class="h-7 flex items-center">
                                                            <button aria-label="Close panel" class="text-gray-400 hover:text-gray-500 transition ease-in-out duration-150" type="button" @click="closeFiltersSidebar">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="relative flex-1 px-4 sm:px-6 h-full border-t overflow-y-scroll">
                                                    <div class="absolute inset-0 px-4 sm:px-6">
                                                        <div class="grid grid-cols-3 py-3">
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Search') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-4 w-4 text-gray-400" icon="font-awesome.search-regular"></svg-vue>
                                                                    </div>
                                                                    <input
                                                                        id="search"
                                                                        v-model.lazy="filters.search"
                                                                        :placeholder="$t('Search')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getTickets"
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Customer') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.users-regular"></svg-vue>
                                                                    </div>
                                                                    <input
                                                                        id="user"
                                                                        v-model.lazy="filters.user"
                                                                        :placeholder="$t('User')"
                                                                        aria-label="User"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getTickets"
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Agents') }}
                                                                </label>
                                                                <input-select
                                                                    id="agent"
                                                                    v-model="filters.agents"
                                                                    :options="agentList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getTickets"
                                                                >
                                                                    <template v-slot:selectOption="props">
                                                                        <div class="flex items-center space-x-3">
                                                                            <div class="flex-shrink-0 inline-block">
                                                                                <img :src="props.option.avatar !== 'gravatar' ? props.option.avatar : props.option.gravatar" alt="Icon" class="w-5 h-auto rounded-full">
                                                                            </div>
                                                                            <div :class="Object.values(filters.agents).indexOf(props.option.id) > -1 ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                                                                {{ props.option.name }}
                                                                            </div>
                                                                        </div>
                                                                    </template>
                                                                </input-select>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Departments') }}
                                                                </label>
                                                                <input-select
                                                                    id="department"
                                                                    v-model="filters.departments"
                                                                    :options="departmentList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getTickets"
                                                                />
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Labels') }}
                                                                </label>
                                                                <input-select
                                                                    id="label"
                                                                    v-model="filters.labels"
                                                                    :options="labelList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getTickets"
                                                                >
                                                                    <template v-slot:selectedOption="props">
                                                                        <template v-if="props && !props.anySelected">
                                                                            <span class="block truncate">{{ $t('Select an option') }}</span>
                                                                        </template>
                                                                        <template v-else>
                                                                            <span class="block truncate">{{ $t('Selected') }} {{ Object.keys(filters.labels).length }} {{ $t('options') }}</span>
                                                                        </template>
                                                                    </template>
                                                                    <template v-slot:selectOption="props">
                                                                        <div class="flex items-center space-x-3">
                                                                            <div class="flex-shrink-0 inline-block">
                                                                                <svg-vue :style="{color: props.option.color}" class="h-5 w-5" icon="font-awesome.circle-solid"></svg-vue>
                                                                            </div>
                                                                            <div :class="Object.values(filters.labels).indexOf(props.option.id) > -1 ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                                                                {{ props.option.name }}
                                                                            </div>
                                                                        </div>
                                                                    </template>
                                                                </input-select>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Statuses') }}
                                                                </label>
                                                                <input-select
                                                                    id="status"
                                                                    v-model="filters.statuses"
                                                                    :options="statusList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getTickets"
                                                                />
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Priorities') }}
                                                                </label>
                                                                <input-select
                                                                    id="priority"
                                                                    v-model="filters.priorities"
                                                                    :options="priorityList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getTickets"
                                                                />
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Sort') }}
                                                                </label>
                                                                <div class="relative inline-flex w-full">
                                                                    <button
                                                                        class="relative -ml-px inline-flex items-center px-4 py-2 rounded-l-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700"
                                                                        type="button"
                                                                        @click="changeSort"
                                                                    >
                                                                        <svg-vue
                                                                            v-show="sort.order === 'asc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-down-alt-regular"
                                                                        />
                                                                        <svg-vue
                                                                            v-show="sort.order === 'desc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-up-alt-regular"
                                                                        />
                                                                        <span class="ml-2">{{ $t('Sort') }}</span>
                                                                    </button>
                                                                    <select
                                                                        id="sort.column"
                                                                        v-model="sort.column"
                                                                        aria-label="Sort by"
                                                                        class="-ml-px block form-select w-full pl-3 pr-9 py-2 rounded-l-none rounded-r-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                                        @change="changeSort"
                                                                    >
                                                                        <option value="subject">{{ $t('Subject') }}</option>
                                                                        <option value="status_id">{{ $t('Status') }}</option>
                                                                        <option value="priority_id">{{ $t('Priority') }}</option>
                                                                        <option value="department_id">{{ $t('Department') }}</option>
                                                                        <option value="user_id">{{ $t('User') }}</option>
                                                                        <option value="agent_id">{{ $t('Agent') }}</option>
                                                                        <option value="created_at">{{ $t('Created at') }}</option>
                                                                        <option value="updated_at">{{ $t('Updated at') }}</option>
                                                                        <option value="closed_at">{{ $t('Closed at') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Items per page') }}
                                                                </label>
                                                                <input-select
                                                                    id="per_page"
                                                                    v-model="perPage"
                                                                    :options="[{id: 5, name: 5}, {id: 10, name: 10}, {id: 25, name: 25}, {id: 50, name: 50}]"
                                                                    option-label="name"
                                                                    required
                                                                    @change="getTickets"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </section>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="rounded-md border border-gray-400 px-3 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                        @click="getTickets"
                    >
                        <svg-vue class="w-4 h-4" icon="font-awesome.sync-regular"></svg-vue>
                    </button>
                </div>
            </div>
        </div>
        <loading :status="loading"/>
        <div class="tickets-list">
            <div class="hidden sm:block">
                <div v-show="selectedRows.length > 0" v-on-clickaway="closeQuickActionDropdown" class="tickets-list-toolbar">
                    <div class="relative inline-block text-left">
                        <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('agent')">
                            <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.user-tag-regular"></svg-vue>
                        </button>
                        <div v-show="quickActions.agent" class="origin-top-right absolute left-0 mt-1 w-56 rounded-md shadow-lg">
                            <div class="rounded-md bg-white shadow-xs">
                                <div class="py-1">
                                    <template v-for="agent in agentList">
                                        <a
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            href="#"
                                            role="menuitem"
                                            @click.prevent="quickAction('agent', agent.id)"
                                        >
                                            {{ agent.name }}
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative inline-block text-left">
                        <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('department')">
                            <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.users-class-regular"></svg-vue>
                        </button>
                        <div v-show="quickActions.department" class="origin-top-right absolute left-0 mt-1 w-56 rounded-md shadow-lg">
                            <div class="rounded-md bg-white shadow-xs">
                                <div class="py-1">
                                    <template v-for="department in departmentList">
                                        <a
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            href="#"
                                            role="menuitem"
                                            @click.prevent="quickAction('department', department.id)"
                                        >
                                            {{ department.name }}
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative inline-block text-left">
                        <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('label')">
                            <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.tags-regular"></svg-vue>
                        </button>
                        <div v-show="quickActions.label" class="origin-top-right absolute left-0 mt-1 w-56 rounded-md shadow-lg">
                            <div class="rounded-md bg-white shadow-xs">
                                <div class="py-1">
                                    <template v-for="label in labelList">
                                        <a
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            href="#"
                                            role="menuitem"
                                            @click.prevent="quickAction('label', label.id)"
                                        >
                                            {{ label.name }}
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative inline-block text-left">
                        <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('priority')">
                            <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.pennant-regular"></svg-vue>
                        </button>
                        <div v-show="quickActions.priority" class="origin-top-right absolute left-0 mt-1 w-56 rounded-md shadow-lg">
                            <div class="rounded-md bg-white shadow-xs">
                                <div class="py-1">
                                    <template v-for="priority in priorityList">
                                        <a
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            href="#"
                                            role="menuitem"
                                            @click.prevent="quickAction('priority', priority.id)"
                                        >
                                            {{ priority.name }}
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('delete')">
                        <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                    </button>
                </div>
            </div>
            <template v-if="ticketList.length > 0">
                <div class="sm:hidden">
                    <ul class="border-b border-gray-200 divide-y divide-gray-200">
                        <template v-for="ticket in ticketList">
                            <li>
                                <router-link
                                    :to="'/dashboard/tickets/' + ticket.uuid + '/manage'"
                                    class="flex items-center justify-between px-4 py-4 hover:bg-gray-100 sm:px-6"
                                >
                                    <div class="flex items-center truncate space-x-3">
                                        <img
                                            :alt="$t('Avatar')"
                                            :src="ticket.user.avatar !== 'gravatar' ? ticket.user.avatar : ticket.user.gravatar"
                                            class="h-8 w-8 mr-4 rounded-full"
                                        >
                                        <div class="whitespace-no-wrap">
                                            <div class="text-sm leading-5 text-gray-900">
                                                <template v-for="label in ticket.labels">
                                                    <div
                                                        :style="{backgroundColor: label.color}"
                                                        class="inline-flex items-center px-2 py-0.5 mr-1 rounded text-xs font-medium leading-4 text-gray-100"
                                                    >
                                                        {{ label.name }}
                                                    </div>
                                                </template>
                                                {{ ticket.subject }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500 w-full truncate">
                                                {{ ticket.lastReply ? ticket.lastReply.body : null }}
                                            </div>
                                        </div>
                                    </div>
                                    <svg-vue class="ml-4 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150" icon="font-awesome.angle-right-regular"></svg-vue>
                                </router-link>
                            </li>
                        </template>
                    </ul>
                </div>
                <div class="hidden sm:block">
                    <div class="align-middle inline-block min-w-full border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-3 pt-2 pb-3">
                                    <input
                                        id="select-all-tickets"
                                        v-model="selectAll"
                                        aria-label="Checkbox"
                                        class="form-checkbox cursor-pointer h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                        type="checkbox"
                                        @change="selectAllTickets"
                                    >
                                </th>
                                <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('Customer') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto" colspan="2">
                                    {{ $t('Ticket summary') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                    {{ $t('Agent') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                    {{ $t('Updated at') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                            <template v-for="ticket in ticketList">
                                <router-link
                                    :to="'/dashboard/tickets/' + ticket.uuid + '/manage'"
                                    class="cursor-pointer hover:bg-gray-100"
                                    tag="tr"
                                >
                                    <td class="px-3 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                        <input
                                            :id="'ticket-' + ticket.id"
                                            v-model="selectedRows"
                                            :value="ticket.id"
                                            aria-label="Checkbox"
                                            class="form-checkbox cursor-pointer h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                            type="checkbox"
                                            @change="selectTicket"
                                            @click.stop
                                        >
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img
                                                    :alt="$t('Avatar')"
                                                    :src="ticket.user.avatar !== 'gravatar' ? ticket.user.avatar : ticket.user.gravatar"
                                                    class="h-10 w-10 rounded-full"
                                                >
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ ticket.user.name }}
                                                </div>
                                                <div class="text-sm leading-5 text-gray-500">
                                                    {{ ticket.user.email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 max-w-0 w-full whitespace-no-wrap">
                                        <div class="flex text-sm leading-5 text-gray-900">
                                            <template v-for="label in ticket.labels">
                                                <div
                                                    :style="{backgroundColor: label.color}"
                                                    class="hidden lg:inline-flex items-center px-2 py-0.5 mr-1 rounded text-xs font-medium leading-4 text-gray-100"
                                                >
                                                    {{ label.name }}
                                                </div>
                                            </template>
                                            <div class="w-full truncate">
                                                {{ ticket.subject }}
                                            </div>
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500 w-full truncate">
                                            {{ ticket.lastReply ? ticket.lastReply.body : null }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                            {{ ticket.status ? ticket.status.name : $t('Unassigned') }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ ticket.priority ? ticket.priority.name : $t('Unassigned') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="text-sm leading-5 text-gray-900">
                                            {{ ticket.agent ? ticket.agent.name : $t('Unassigned') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="text-sm text-gray-500">
                                            {{ ticket.updated_at | momentFormatDateTimeAgo }}
                                        </div>
                                    </td>
                                </router-link>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
            <template v-else-if="!loading">
                <div class="h-full flex">
                    <div class="m-auto">
                        <div class="grid grid-cols-1 justify-items-center h-full w-full p-4">
                            <div class="flex justify-center items-center">
                                <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                            </div>
                            <div class="flex justify-center items-center">
                                <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                            </div>
                            <template v-if="anyFilter">
                                <div class="flex justify-center items-center">
                                    <div>{{ $t('Try changing the filters, or rephrasing your search') }}.</div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <nav class="bg-white absolute bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-gray-700">
                    {{ $t('Showing') }}
                    <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                    {{ $t('to') }}
                    <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                    {{ $t('of') }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ $t('results') }}
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <button
                    :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage <= 1"
                    class="pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage - 1)"
                >
                    {{ $t('Previous') }}
                </button>
                <button
                    :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage >= pagination.totalPages"
                    class="ml-3 pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage + 1)"
                >
                    {{ $t('Next') }}
                </button>
            </div>
        </nav>
        <div v-show="quickActions.delete" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="quickActions.delete" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="quickActions.delete"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Delete tickets') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Are you sure you want to delete the selected tickets?') }}
                                            {{ $t('All data will be permanently removed') }}.
                                            {{ $t('All related data will be deleted') }}.
                                            {{ $t('This action cannot be undone') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="quickAction('delete')"
                            >
                                {{ $t('Delete tickets') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="quickActions.delete = false"
                            >
                                {{ $t('Cancel') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Tickets')
        }
    },
    mixins: [clickaway],
    data() {
        return {
            loading: true,
            filtersSidebar: false,
            filters: {
                search: '',
                user: '',
                agents: [],
                departments: [],
                labels: [],
                statuses: [1, 2],
                priorities: [],
            },
            quickActions: {
                agent: false,
                department: false,
                label: false,
                priority: false,
                delete: false,
            },
            sort: {
                order: 'desc',
                column: 'updated_at',
            },
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            agentList: [],
            departmentList: [],
            labelList: [],
            statusList: [],
            priorityList: [],
            ticketList: [],
            selectAll: false,
            selectedRows: [],
        }
    },
    computed: {
        anyFilter() {
            return this.filters.search !== ''
                || this.filters.user !== ''
                || this.filters.agents !== 0
                || this.filters.departments.length !== 0
                || this.filters.labels.length !== 0
                || this.filters.statuses.length !== 0
                || this.filters.priorities.length !== 0;
        }
    },
    filters: {
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    mounted() {
        this.getTickets();
        this.getFilters();
    },
    methods: {
        openFiltersSidebar() {
            const self = this;
            self.selectedRows = [];
            self.selectTicket();
            setTimeout(function () {
                self.filtersSidebar = true;
            }, 100);
        },
        closeFiltersSidebar() {
            this.filtersSidebar = false;
        },
        closeQuickActionDropdown() {
            this.quickActions.agent = false;
            this.quickActions.department = false;
            this.quickActions.label = false;
            this.quickActions.priority = false;
            this.quickActions.delete = false;
        },
        toggleQuickActionDropdown(quickAction) {
            if (quickAction === 'agent') {
                this.quickActions.agent = !this.quickActions.agent;
                this.quickActions.department = false;
                this.quickActions.label = false;
                this.quickActions.priority = false;
                this.quickActions.delete = false;
            }
            if (quickAction === 'department') {
                this.quickActions.department = !this.quickActions.department;
                this.quickActions.agent = false;
                this.quickActions.label = false;
                this.quickActions.priority = false;
                this.quickActions.delete = false;
            }
            if (quickAction === 'label') {
                this.quickActions.label = !this.quickActions.label;
                this.quickActions.agent = false;
                this.quickActions.department = false;
                this.quickActions.priority = false;
                this.quickActions.delete = false;
            }
            if (quickAction === 'priority') {
                this.quickActions.priority = !this.quickActions.priority;
                this.quickActions.agent = false;
                this.quickActions.department = false;
                this.quickActions.label = false;
                this.quickActions.delete = false;
            }
            if (quickAction === 'delete') {
                this.quickActions.delete = !this.quickActions.delete;
                this.quickActions.agent = false;
                this.quickActions.department = false;
                this.quickActions.label = false;
                this.quickActions.priority = false;
            }
        },
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getTickets();
            }
        },
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getTickets();
        },
        selectTicket() {
            this.closeQuickActionDropdown();
            this.selectAll = Object.keys(this.selectedRows).length === Object.keys(this.ticketList).length;
        },
        selectAllTickets() {
            this.selectedRows = [];
            this.closeQuickActionDropdown();
            if (this.selectAll) {
                for (let ticket in this.ticketList) {
                    this.selectedRows.push(this.ticketList[ticket].id);
                }
            }
        },
        getTickets() {
            const self = this;
            self.selectAll = false;
            self.selectedRows = [];
            self.loading = true;
            axios.get('api/dashboard/tickets', {
                params: {
                    page: self.page,
                    sort: self.sort,
                    perPage: self.perPage,
                    search: self.filters.search,
                    user: self.filters.user,
                    agents: self.filters.agents,
                    departments: self.filters.departments,
                    labels: self.filters.labels,
                    statuses: self.filters.statuses,
                    priorities: self.filters.priorities,
                }
            }).then(function (response) {
                self.ticketList = response.data.items;
                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getTickets();
                } else {
                    if (self.ticketList.length === 0) {
                        self.selectAll = false;
                        self.selectedRows = [];
                    }
                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;
            });
        },
        getFilters() {
            const self = this;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.agentList = response.data.agents;
                self.departmentList = response.data.departments;
                self.labelList = response.data.labels;
                self.statusList = response.data.statuses;
                self.priorityList = response.data.priorities;
            });
        },
        quickAction(param, value) {
            const self = this;
            axios.post('api/dashboard/tickets/quick-actions', {
                action: param,
                value: value,
                tickets: self.selectedRows,
            }).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: response.data.message,
                    type: 'success'
                });
                self.getTickets();
            }).catch(function () {
                self.closeQuickActionDropdown();
            });
        },
    }
}
</script>

<style lang="scss">
.tickets-list {
    @apply bg-white w-full z-0 overflow-y-auto;
    height: calc(100vh - 270px);
}

@media (min-width: theme('screens.md')) {
    .tickets-list {
        height: calc(100vh - 216px);
    }
}

.filters-options {
    @apply rounded-md bg-white shadow-xs p-3 overflow-y-auto;
    height: calc(100vh - 270px);
    max-height: 360px;
}

@media (min-width: theme('screens.md')) {
    .filters-options {
        height: calc(100vh - 140px)
    }
}

.tickets-list-toolbar {
    @apply bg-white fixed flex rounded-md shadow-lg;
    left: 50px;
}

@media (min-width: theme('screens.md')) {
    .tickets-list-toolbar {
        left: 50%;
    }
}
</style>
