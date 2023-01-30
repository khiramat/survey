<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    vision: String,
    mission: String,
    values: String,
    tests: Array,
})

</script>

<template>
    <Head title="landing"/>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170 45" fill="none"
                     class="h-16 w-auto text-gray-700 sm:h-10">
                    <path
                        d="M145.151 9c5 2.7 8.015 6.187 8.015 9.99 0 8.6-15.412 15.578-34.427 15.578a68.192 68.192 0 0 1-17.838-2.251c6.316 3.415 15.8 5.591 26.415 5.591 19.014 0 34.43-6.976 34.43-15.578-.002-5.651-6.648-10.599-16.595-13.33z"
                        fill="#75787b"/>
                    <path
                        d="M104.668 15.646h7.161a2.3 2.3 0 0 0 1.844-.922l3.073-4.1h-12.078V5.41h8.6a2.474 2.474 0 0 0 1.98-.991L118.27.384H99.091v25.679h14.269a2.48 2.48 0 0 0 1.98-.994l3.02-4.032h-13.692zM30.82.362L20.445 24.744l-5.3-7.761a8.784 8.784 0 0 0 3.96-2.868 8.02 8.02 0 0 0 1.511-5.063v-.069a7.828 7.828 0 0 0-2.539-6.21 10.419 10.419 0 0 0-7.1-2.228H0v25.57h5.626v-8.177h3.7L13.6 24.32a4.059 4.059 0 0 0 3.378 1.8h6.442a3.242 3.242 0 0 0 3-2.017l1.514-3.717h10.817l1.514 3.719a3.239 3.239 0 0 0 3 2.016h3.7L36.007.362zm-15.903 8.99a3.339 3.339 0 0 1-1.113 2.63 4.672 4.672 0 0 1-3.2.987H5.626V5.627H10.5a5.164 5.164 0 0 1 3.246.909 3.261 3.261 0 0 1 1.165 2.739zm15.025 6.06l3.4-8.292 3.4 8.292zm34.403.771L53.081.439h-5.187v25.57h5.552V9.755l10.446 14.651a4.068 4.068 0 0 0 3.237 1.6h2.77V.439h-5.554zm70.827.694a8.784 8.784 0 0 0 3.96-2.868 8.02 8.02 0 0 0 1.514-5.06v-.072a7.828 7.828 0 0 0-2.539-6.209 10.419 10.419 0 0 0-7.1-2.228H120.03v25.568h5.626v-8.187h3.7l4.273 6.382a4.059 4.059 0 0 0 3.378 1.8h4.407zm-.219-7.635a3.339 3.339 0 0 1-1.113 2.63 4.672 4.672 0 0 1-3.2.987h-4.982V5.52h4.872a5.164 5.164 0 0 1 3.251.913 3.261 3.261 0 0 1 1.165 2.739zM87.682 12.75l-2.527 3.378v.021h5.662v3.676a8.852 8.852 0 0 1-5.3 1.546 7.82 7.82 0 0 1-3.123-.6 7.305 7.305 0 0 1-2.446-1.7 7.687 7.687 0 0 1-1.607-2.581 9 9 0 0 1-.566-3.24v-.072a8.4 8.4 0 0 1 .566-3.094 7.885 7.885 0 0 1 1.569-2.526 7.729 7.729 0 0 1 2.338-1.725 6.539 6.539 0 0 1 2.868-.641 10.272 10.272 0 0 1 2 .186 8.947 8.947 0 0 1 1.7.511 9.6 9.6 0 0 1 1.514.8 1.924 1.924 0 0 0 2.59-.459l2.177-2.912a16.817 16.817 0 0 0-1.807-1.3 12.162 12.162 0 0 0-2.26-1.1 14.948 14.948 0 0 0-2.613-.68 18.861 18.861 0 0 0-3.116-.237 13.575 13.575 0 0 0-5.369 1.041 13.1 13.1 0 0 0-8.037 12.182v.077a13.763 13.763 0 0 0 .987 5.26 12.373 12.373 0 0 0 2.758 4.164 12.586 12.586 0 0 0 4.237 2.739 14.579 14.579 0 0 0 5.46.987 15.448 15.448 0 0 0 6.232-1.19 18.732 18.732 0 0 0 4.694-2.868V11.287h-5.659a3.65 3.65 0 0 0-2.922 1.463z"
                        fill="#e40046"/>
                </svg>
                <div v-if="canLogin" class="top-180 px-6 py-4 sm:block">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                          class="text-sm text-gray-700 dark:text-gray-500 underline" style="font-size: 20px">Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline" style="font-size: 20px">Log in</Link>
                    </template>
                </div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                <path
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>

                            <div class="ml-4 text-lg leading-7 font-semibold">このサーベイについて
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                このサーベイは各メンバーがレンジャーシステムズのMVVを理解し各自において、日々実践できているか、体現できているかを定期調査するものです。<br><br>
                                <div class="text-sm leading-7 font-semibold">VISION（将来のあるべき姿）</div>
                                <ul>
                                    <ol>{{ vision }}</ol>
                                </ul>
                                <div class="text-sm leading-7 font-semibold">MISSION（使命と目的）</div>
                                <ul>
                                    <li>{{ mission }}</li>
                                </ul>
                                <div class="text-sm leading-7 font-semibold">VALUE（行動指針と価値基準）</div>
                                <ul>
                                    <li v-for="value in values">
                                        第 {{ value.chapter_no }}条、 {{ value.chapter_name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>
