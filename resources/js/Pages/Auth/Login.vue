<script setup>
import Cursor from '@/Components/Cursor.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
});

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />
    <Cursor />

    <div class="relative bg-[url('/pictures/bg.png')] h-screen w-screen bg-cover bg-center">
        <div class="absolute inset-0 flex">
            <div
                class="bg-[url('/pictures/subtract.svg')] w-[40%] bg-no-repeat bg-contain bg-left h-full sm:w-1/2 md:w-1/2">
                <div class="relative flex-col justify-start items-start px-[15%] -space-y-12 h-[50%] top-[20%]">
                    <p class="text-[500%] text-ylw ml-[15%] rotate-[-5deg]">
                        to-
                    </p>
                    <p class="text-[500%] text-ylw ml-[6%] rotate-[-5deg]">
                        Dew
                    </p>
                    <p class="text-[500%] text-ylw ml-[15%] rotate-[-5deg]">
                        List
                    </p>
                </div>
            </div>
            <div class="flex-grow mx-auto my-auto">
                <div class="bg-[url('/pictures/popup.svg')] bg-full p-14 max-w-lg bg-no-repeat mx-auto h-full">
                    <h1 class="text-grn text-2xl mb-4 text-center">Howdy there!</h1>
                    <p class="text-biege-dark mb-4 text-center">Welcome to To-Dew-List Plant Tracker. We hope you keep
                        all your dandy plants alive!</p>
                    <form @submit.prevent="submit" class="relative bg-transparent">
                        <div class="mb-4 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput type="email" placeholder="Email" v-model="form.email" autocomplete="username"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mb-4 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput type="password" placeholder="Password" v-model="form.password"
                                autocomplete="current-password"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="flex justify-center items-center w-full">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                type="submit">Hop Back In</PrimaryButton>
                        </div>
                    </form>
                    <p class="mt-4 text-center text-biege-dark">
                        Don't have an account?
                        <Link :href="route('register')" class="text-grn cursor-none">Register here</Link>
                    </p>
                </div>
            </div>
        </div>
    </div>


</template>
