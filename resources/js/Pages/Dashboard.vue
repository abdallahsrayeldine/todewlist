<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import Add from '@/Components/Add.vue';
import { onMounted, reactive, ref, watch } from 'vue';
import UpdateProfileInformationForm from './Profile/Partials/UpdateProfileInformationForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Tree from '@/Components/Tree.vue';
import Plant from '@/Components/Plant.vue';
import Sun from '@/Components/Sun.vue';
import Droplet from '@/Components/Droplet.vue';
import Prof from '@/Components/Prof.vue';
import Cursor from '@/Components/Cursor.vue';
import Edit_plant from '@/Components/Edit_plant.vue';
import PlantImage from '@/Components/PlantImage.vue';

const showEdit = ref(false);
const showAdd = ref(false);
const showEditPlant = ref(false);
const showImg = ref(false);

// function showPopupSun(active) {

// }
// const hidePopup = () => {

// }
// function showPopupWater(active) {

// }

const openImg = () => {
    showImg.value = true;
};
const closeImg = () => {
    showImg.value = false;
};
const openEdit = () => {
    showEdit.value = true
};
const openAdd = () => {
    showAdd.value = true;
};
const closeAdd = () => {
    showAdd.value = false;
};
const closeEdit = () => {
    showEdit.value = false;
};
const closeEditPlant = () => {
    showEditPlant.value = false;
};
function openEditPlant(plant) {
    Edited_plant.value = plant;
    showEditPlant.value = true;
}

const isHovered = ref(false);
function handleMouseOver() {
    isHovered.value = true;
}
function handleMouseLeave() {
    isHovered.value = false;
}

const headers = ref([
    "Child Name",
    "Species/ Varieties",
    "Watering",
    "Date Planted",
    "Soil Type",
    "Drainage",
    "Fertilizer",
    "Sunlight",
    "Humidity",
    "Notes",
]);

const state = reactive(headers.value.reduce((acc, header) => {
    acc[header] = '';
    return acc;
}, {}));

const searchParams = new URLSearchParams(window.location.search);
const active = ref(null);
const orderType = ref(searchParams.get('OrderType') || '');
const fieldType = ref(searchParams.get('FieldType') || '');

if (fieldType.value) {
    state[fieldType.value] = orderType.value;
    active.value = state[fieldType.value] ? fieldType.value : null;
    rotate(fieldType.value)
}

function rotate(header) {
    if (active.value && active.value !== header) {
        state[active.value] = '';
    }
    state[header] = state[header] === 'asc' ? 'desc' : 'asc';
    active.value = state[header] === 'asc' ? header : null;
}
function sort(header) {
    if (state[header] === '') state[header] = 'asc';
    router.get(route('plants.index', { OrderType: state[header], FieldType: header, key: key.value }));
    rotate(header);
}

const Input = ref(null);
const key = ref(searchParams.get('key') || '');
const search = () => {
    router.get(route('plants.index', { key: key.value, OrderType: orderType.value, FieldType: fieldType.value }));
}
onMounted(() => {
    if (true) {
        Input.value.focus();
    }
});

const props = defineProps({
    plants: Object,
});

const Edited_plant = ref();
watch(Edited_plant, (newVal, oldVal) => {
    const plantIndex = props.plants.data.findIndex(plant => plant.id === newVal.id);
    if (plantIndex !== -1) {
        props.plants.data[plantIndex] = newVal;
    }
});

function activePage(index) {
    props.plants.links.forEach(link => {
        link.active = false;
    });
    props.plants.links[index].active = true;
    window.location.href = props.plants.links[index].url;
}

const imgLink = ref(null);
function showFullImage(link) {
    openImg();
    imgLink.value = link;
}
</script>

<template>

    <Head title="Dashboard" />
    <Cursor />
    <div class="absolute inset-0 overflow-hidden bg-biege-light">
        <div class="flex h-full w-full">
            <div class="m-2 bg-grn rounded-3xl p-2 flex flex-col justify-between w-[180px]">
                <div class="text-center">
                    <p class="text-biege text-5xl rotate-[-5deg]">to-</p>
                    <p class="text-biege text-5xl rotate-[-5deg]">Dew</p>
                    <p class="text-biege text-5xl rotate-[-5deg]">List</p>
                </div>
                <div class="flex items-center mb-1">
                    <Prof :imageurl="`storage/${usePage().props.auth.user.picpath}`" />
                    <div class="flex flex-col items-start ml-2">
                        <p class="mt-2 text-biege-light " @click="openEdit">{{ usePage().props.auth.user.name }}</p>
                        <p class="mt-2 text-ylw " @click="openEdit">Edit profile</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-between w-full h-full mr-2 overflow-hidden">
                <div class="flex flex-col h-full">
                    <div class="flex justify-between items-center mt-[1.7rem] mb-1">
                        <p class="text-3xl text-grn">Hi there, {{ usePage().props.auth.user.name }}!</p>
                        <div class="bg-biege rounded-2xl px-4 flex items-center">
                            <img src="pictures/search.svg" class="h-6 w-6" />
                            <input
                                class="bg-biege text-biege-dark placeholder:text-biege-dark border-transparent outline-none focus:ring-0 focus:border-transparent w-full cursor-none"
                                placeholder="Search" @input="search" v-model="key" ref="Input" />
                        </div>
                    </div>
                    <div class="flex-1 overflow-auto">
                        <table class="min-w-[1250px] w-full rounded-2xl border-separate border-spacing-y-2">
                            <thead class="bg-[url('pictures/header.svg')] bg-no-repeat bg-cover">
                                <tr class="h-[75px]">
                                    <th></th>
                                    <th v-for="header in headers" :key="header"
                                        class="text-biege-light text-center text-md" @click="sort(header)">
                                        {{ header }}
                                        <span :class="[
                                            state[header]==='desc'
                                            ? 'rotate-90 text-ylw'
                                            : 'rotate-0 text-biege-light',
                                            'inline-block duration-200 transition-all text-2xl  ',
                                            ]">
                                            &gt;
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="h-[75px] rounded-2xl space-y-2 bg-[url('pictures/tbody.svg')] bg-no-repeat bg-cover"
                                    v-for="(plant, index) in plants.data" :key="plant.id">
                                    <td>
                                        <div class="flex justify-end items-end">
                                            <div class="w-[45px] h-[45px] ml-2 rounded-sm">
                                                <img :src="plant.plant_path ? `storage/${plant.plant_path}` : 'storage/pic.png'"
                                                    class="w-full h-full object-cover rounded-lg"
                                                    @click="showFullImage(plant.plant_path ? `storage/${plant.plant_path}` : 'storage/pic.png')" />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-grn text-center text-md">{{ plant.name }}</td>
                                    <td class="text-brwn text-center text-md">{{ plant.species }}</td>
                                    <td class=" object-center">
                                        <!-- <div>
                                            <p
                                                class=" bg-[url('pictures/bubble1.svg')] text-center h-fit p-2 pt-0 pb-0 text-[#E8FF5B] bg-no-repeat bg-contain">
                                                hahahah</p>
                                            <img src="pictures/bubble2.svg" class="mx-auto mb-1" />
                                        </div> -->
                                        <div class="flex space-x-2 justify-center "
                                            @mouseover="showPopupWater(plant.water)" @mouseleave="hidePopup">
                                            <Droplet v-for="(item, index) in 5" :index="index + 1"
                                                :activeIndex="plant.water" />
                                        </div>
                                    </td>
                                    <td class="text-brwn text-center text-md">{{ new
                                        Date(plant.date).toLocaleDateString('en-GB') }}</td>
                                    <td class="text-brwn text-center text-md">{{ plant.soil }}</td>
                                    <td class="text-brwn text-center text-md">{{ plant.drainage }}</td>
                                    <td class="text-brwn text-center text-md">{{ plant.fertilizer }}</td>
                                    <td class="object-center">
                                        <!-- <div>
                                            <p
                                                class=" bg-[url('pictures/bubble1.svg')] text-center h-fit p-2 pt-0 pb-0 text-[#E8FF5B] bg-no-repeat bg-contain">
                                                hahahah</p>
                                            <img src="pictures/bubble2.svg" class="mx-auto mb-1" />
                                        </div> -->
                                        <div class="flex space-x-1 justify-center" @mouseover="showPopupSun(plant.sun)"
                                            @mouseleave="hidePopup">
                                            <Sun v-for="(item, index) in 5" :index="index + 1"
                                                :activeIndex="plant.sunlight" />
                                        </div>
                                    </td>
                                    <td class="text-brwn text-center text-md">{{ plant.humidity }}</td>
                                    <td class="text-brwn text-center text-md">{{ plant.notes }}</td>
                                    <td @click="openEditPlant(plant)" class="">
                                        <img src="pictures/edit_plant.svg" class="w-90% h-full mr-2" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div v-show="plants.data.length === 0" class="w-[35%] h-[50%] ml-auto mr-auto">
                            <br>
                            <br>
                            <Tree class="bg-[url('pictures/oval.svg')] relative ml-auto mr-auto bg-no-repeat" />
                            <p class="font-IrishGrover text-center text-2xl text-[#40341D]">
                                You don't have any Plants in
                            </p>
                            <p class="font-IrishGrover text-center text-2xl text-[#40341D]">
                                your Garden.
                            </p>
                            <PrimaryButton class="ml-auto mr-auto text-biege-light" @click="openAdd">Add a Plant Child
                            </PrimaryButton>
                        </div>
                    </div>
                    <div>
                        <div class="flex space-x-2 justify-center h-[2.12rem]">
                            <div v-for="link in plants.links" :key="link.label">
                                <div class="text-biege-dark text-2xl px-3 bg-cover bg-no-repeat"
                                    v-if="Number.isInteger(parseInt(link.label))"
                                    :class=" {'text-biege-light bg-[url(pictures/hover2.svg)]': link.active,'hover:bg-[url(pictures/hover.svg)] hover:text-biege-dark': !link.active}"
                                    @click="activePage(parseInt(link.label))">
                                    {{ link.label }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fixed bottom-1 right-1">
                    <Add :glow="isHovered" @mouseover="handleMouseOver" @mouseleave="handleMouseLeave"
                        @click="openAdd" />
                </div>
            </div>
        </div>
    </div>
    <div>
        <UpdateProfileInformationForm v-show="showEdit" @close="closeEdit" />
    </div>
    <div>
        <Plant v-show="showAdd" @close="closeAdd" />
    </div>
    <div v-if="plants.data.length !== 0">
        <Edit_plant :tempPlant="Edited_plant" v-show="showEditPlant" @close="closeEditPlant" />
    </div>
    <div>
        <PlantImage :imgLink="imgLink" v-show="showImg" @close="closeImg" />
    </div>
</template>
