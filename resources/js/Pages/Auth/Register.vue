<script setup>
import Cursor from '@/Components/Cursor.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Register" />
    <Cursor />

    <div class="relative bg-[url('/pictures/bg.png')] h-screen w-screen bg-cover bg-center">
        <div class="absolute inset-0 flex">
            <div
                class="bg-[url('/pictures/subtract.svg')] w-[40%] bg-no-repeat bg-contain bg-left h-full sm:w-1/2 md:w-1/2">
                <div class="relative flex-col justify-start items-start px-[15%] -space-y-12 h-[50%] top-[20%]">
                    <p class="text-[500%] text-[#E8FF5B] ml-[15%] rotate-[-5deg]">
                        to-
                    </p>
                    <p class="text-[500%] text-[#E8FF5B] ml-[6%] rotate-[-5deg]">
                        Dew
                    </p>
                    <p class="text-[500%] text-[#E8FF5B] ml-[15%] rotate-[-5deg]">
                        List
                    </p>
                </div>
            </div>
            <div class="flex-grow mx-auto my-auto">
                <div class="bg-[url('/pictures/popup.svg')] p-14 max-w-lg bg-no-repeat bg-full mx-auto h-full">
                    <h1 class="text-grn text-2xl mb-2 mt-6 text-center">Howdy there!</h1>
                    <p class="text-biege-dark mb-2 text-center">Welcome to To-Dew-List Plant Tracker. We hope you keep
                        all your dandy plants alive!</p>
                    <form @submit.prevent="submit" class="relative bg-transparent">
                        <div class="mb-2 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput id="name" type="text" placeholder="Name" v-model="form.name" required autofocus
                                autocomplete="name"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mb-2 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput id="email" type="email" placeholder="Email" v-model="form.email" required
                                autofocus autocomplete="username"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mb-2 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput id="password" type="password" placeholder="Create Password"
                                v-model="form.password" required autofocus autocomplete="new-password"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="mb-2 bg-[url('/pictures/input.svg')] bg-contain bg-no-repeat">
                            <TextInput id="password_confirmation" type="password" placeholder="Confirm Password"
                                v-model="form.password_confirmation" required autofocus autocomplete="new-password"
                                class="w-full p-3 bg-transparent border-transparent outline-none focus:ring-0 focus:border-transparent placeholder:text-biege-dark" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        <div class="flex justify-center items-center w-full">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                type="submit">Get Gardenin'</PrimaryButton>
                        </div>
                    </form>
                    <p class="mb-6 mt-2 text-center text-biege-dark">
                        Already have an account?
                        <Link :href="route('login')" class="text-grn cursor-none">Login here</Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
