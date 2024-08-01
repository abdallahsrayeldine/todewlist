<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';


const emits = defineEmits(['close']);

const user = usePage().props.auth.user;
const userForm = useForm({
    name: user.name,
    email: user.email,
    profile_pic: null,
    pic_path: user.picpath
});

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const fileName = ref("Upload Image");
const filepath = ref(userForm.pic_path);
const file_upld = ref(false);

function handleFileChange(event) {
    const input = event.target;
    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        fileName.value = file.name;
        userForm.profile_pic = file;

        const reader = new FileReader();
        reader.onload = function (e) {
            userForm.pic_path = file.name;
        };
        reader.readAsDataURL(file);
        filepath.value = URL.createObjectURL(file);
        file_upld.value = true;
    }
}

function reset() {
    user.value = usePage().props.auth.user;
    userForm.name = user.value.name;
    userForm.email = user.value.email;
    userForm.profile_pic = null;
    userForm.pic_path = user.value.picpath;
    filepath.value = user.value.picpath;
    fileName.value = "Upload Image";
    passwordForm.current_password = '';
    passwordForm.password = '';
    passwordForm.password_confirmation = '';
    file_upld.value = false;
}

const updateProfile = () => {
    const formData = new FormData();
    formData.append("name", userForm.name);
    formData.append("email", userForm.email);
    formData.append("current_password", passwordForm.current_password);
    formData.append("password", passwordForm.password);
    formData.append("password_confirmation", passwordForm.password_confirmation);
    formData.append("_method", "PATCH");
    if (userForm.profile_pic) {
        formData.append("pic_path", userForm.pic_path);
        formData.append("profile_pic", userForm.profile_pic);
    }
    router.post(route("profile.update"), formData, {
        onSuccess: () => {
            reset();
            emits('close');
        },
        onError: () => {
            if (passwordForm.errors.password) {
                passwordForm.reset('password', 'password_confirmation');
            }
            if (passwordForm.errors.current_password) {
                passwordForm.reset('current_password');
            }
        },
    });
};

</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-biege-light p-5 rounded-3xl w-[500px] h-fit relative mx-auto my-4">
            <header class="flex flex-row items-baseline justify-start">
                <p class="text-black text-3xl  mr-4" @click="$emit('close'),reset()">
                    X
                </p>
                <p class="relative text-2xl font-medium text-grn">
                    Edit Farmer Profile
                </p>
                <div class="ml-32">
                    <p class="text-md">
                        <Link :href="route('logout')" as="button" method="post" class="text-[#F27114] cursor-none">Log
                        Out</Link>
                    </p>
                </div>
            </header>

            <form @submit.prevent="updateProfile" class="mx-5 space-y-3">
                <div class="flex flex-col items-start mt-1 skew-x-6">
                    <input id="file_upload" type="file" accept="image/*" class="hidden" @change="handleFileChange" />
                    <label for="file_upload"
                        class="skew-x-0 w-full h-20 bg-biege rounded-2xl  flex items-center justify-center relative cursor-none">
                        <span class=" mt-1 text-[#9D904C]" v-if="fileName">{{ fileName }}</span>
                        <div class="absolute top-[10%] left-5 w-[15%] bg-upld h-[80%] rounded-2xl">
                            <img :src="file_upld ? filepath : `/storage/${filepath}`"
                                class="w-full h-full object-cover rounded-2xl " />
                        </div>
                    </label>
                </div>
                <div>
                    <TextInput type="text" placeholder="Name" class=" skew-x-12 w-full" v-model="userForm.name" required
                        autofocus autocomplete="name" />

                    <InputError class="mt-1" :message="userForm.errors.name" />
                </div>

                <div>
                    <TextInput type="email" placeholder="Email" class="skew-x-12 w-full" v-model="userForm.email"
                        required autocomplete="username" />

                    <InputError class=" mt-1" :message="userForm.errors.email" />
                </div>
                <div>
                    <TextInput type="password" placeholder="Current Password" v-model="passwordForm.current_password"
                        class="skew-x-12 w-full" autocomplete="current-password" />

                    <InputError :message="passwordForm.errors.current_password" class="mt-1" />
                </div>

                <div>
                    <TextInput type="password" placeholder="New Password" v-model=" passwordForm.password"
                        class="skew-x-12 w-full" autocomplete="new-password" />

                    <InputError :message="passwordForm.errors.password" class=" mt-1" />
                </div>

                <div>
                    <TextInput type="password" placeholder="Confirm New Password"
                        v-model="passwordForm.password_confirmation" class="skew-x-12 w-full"
                        autocomplete="new-password" />

                    <InputError :message="passwordForm.errors.password_confirmation" class=" mt-1" />
                </div>

                <div>
                    <PrimaryButton class="mx-auto" :disabled="userForm.processing || passwordForm.processing">Save
                        Changes
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </div>
</template>
