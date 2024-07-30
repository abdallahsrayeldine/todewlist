<script setup>
import { ref, reactive } from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Droplet from "./Droplet.vue";
import Sun from "./Sun.vue";

const emits = defineEmits(['close']);

const addPlant = useForm({
    plant_pic: null,
    plant_path: "pic.png",
    name: "",
    species: "",
    water: 0,
    date: null,
    soil: "",
    drainage: "",
    fertilizer: "",
    sunlight: 0,
    humidity: "",
    notes: "",
});

const activeIndexw = ref(-1);

function colorw(index) {
    activeIndexw.value = index;
    addPlant.water = index;
}

const activeIndexs = ref(-1);
function colors(index) {
    activeIndexs.value = index;
    addPlant.sunlight = index;
}

const fileName = ref("Upload Image");
const filepath = ref("pic.png");
const file_upld = ref(false);

function handleFileChange(event) {
    const input = event.target;
    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        fileName.value = file.name;
        addPlant.plant_pic = file;

        // Read the file and save the path
        const reader = new FileReader();
        reader.onload = function (e) {
            addPlant.plant_path = file.name;
        };
        reader.readAsDataURL(file);
        filepath.value = URL.createObjectURL(file);
        file_upld.value = true;
    }
}

function reset() {
    addPlant.plant_pic = null;
    addPlant.plant_path = "pic.png";
    addPlant.name = "";
    addPlant.species = "";
    addPlant.water = 0;
    addPlant.date = null;
    addPlant.soil = "";
    addPlant.drainage = "";
    addPlant.fertilizer = "";
    addPlant.sunlight = 0;
    addPlant.humidity = "";
    addPlant.notes = "";
    activeIndexs.value = -1;
    activeIndexw.value = -1;
    fileName.value = "Upload Image";
    file_upld.value = false;
    filepath.value = "pic.png";
}

function Add() {
    addPlant.post(route('plants.store'), {
        onSuccess: () => {
            emits('close');
            reset();
        }
    });
}
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-biege-light p-5 rounded-3xl w-[800px] h-fit relative mx-auto my-4">
            <header class="flex flex-row items-baseline justify-start">
                <p class="text-black text-3xl mr-4" @click="$emit('close'), reset()">
                    X
                </p>
                <p class="relative text-2xl font-medium text-grn">
                    Add Your Plant Child
                </p>
            </header>

            <form @submit.prevent="Add" ref="updateForm" enctype="multipart/form-data">
                <div class="mt-2 flex flex-wrap items-center justify-between w-full text-biege-dark">
                    <div class="flex flex-col items-start w-[49%] space-y-3">
                        <div class="w-full skew-x-6">
                            <input id="plant_upload" type="file" accept="image/*" class="hidden "
                                @change="handleFileChange" />
                            <label for="plant_upload"
                                class="skew-x-0 w-full h-20 bg-biege rounded-2xl flex items-center justify-center relative cursor-none">
                                <span class="mt-1 text-biege-dark" v-if="fileName">{{ fileName }}</span>
                                <div class="absolute top-[10%] left-5 w-[15%] bg-upld h-[80%] rounded-2xl">
                                    <img :src="file_upld ? filepath : `/storage/${filepath}`"
                                        class="w-full h-full object-cover rounded-2xl" @error="this.onerror=null" />
                                </div>
                            </label>
                        </div>

                        <div class="w-full">
                            <TextInput type="text" placeholder="Plant Child Name" class="skew-x-12 w-full"
                                v-model="addPlant.name" required autofocus />
                            <InputError class="mt-1" :message="addPlant.errors.name" />
                        </div>

                        <select required v-model="addPlant.species"
                            class="bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent skew-x-12 font-IrishGrover w-full h-12 py-2 px-4 cursor-none">
                            <option value="" disabled selected hidden>Species/Variety</option>
                            <option value="Moses in the Cradle">Moses in the Cradle</option>
                            <option value="Lettuce">Lettuce</option>
                            <option value="Honey Suckle">Honey Suckle</option>
                            <option value="Sunflower">Sunflower</option>
                            <option value="Basil">Basil</option>
                            <option value="Trifoliate Orange">Trifoliate Orange</option>
                            <option value="Petunia">Petunia</option>
                        </select>

                        <div
                            class="bg-biege rounded-xl font-IrishGrover w-full h-12 py-2 px-4 flex items-center justify-between skew-x-12">
                            <span class="mr-4">Water Requirement</span>
                            <div class="flex space-x-2">
                                <Droplet v-for="(item, index) in 5" :key="index + 1" @click="colorw(index + 1)"
                                    :index="index + 1" :activeIndex="activeIndexw" :value="index + 1" />
                            </div>
                        </div>

                        <label
                            class="block relative bg-biege rounded-xl border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12 cursor-none">
                            <input type="date" required
                                class="absolute bg-transparent outline-none border-transparent focus:ring-0 focus:border-transparent h-12 w-[42%] top-[0.5%] right-0 cursor-none"
                                v-model="addPlant.date" onfocus="this.max=(new Date()).toISOString().split('T')[0]" />
                            <span class="relative top-[15%]">Date Planted</span>
                        </label>

                        <select required v-model="addPlant.soil"
                            class="bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12 cursor-none">
                            <option value="" disabled selected hidden>Soil Type</option>
                            <option value="Acidic">Acidic</option>
                            <option value="Sandy">Sandy</option>
                            <option value="Loamy">Loamy</option>
                            <option value="Peat-based">Peat-based</option>
                            <option value="Well-drained">Well-drained</option>
                        </select>
                    </div>

                    <div class="flex flex-col items-start w-[49%] space-y-3">
                        <select required v-model="addPlant.drainage"
                            class="bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12 cursor-none">
                            <option value="" disabled selected hidden>Drainage</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>

                        <select required v-model="addPlant.fertilizer"
                            class="bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12 cursor-none">
                            <option value="" disabled selected hidden>Fertilizer</option>
                            <option value="10-10-10 Fertilizer">10-10-10 Fertilizer</option>
                            <option value="50$">50$</option>
                            <option value="Liquid Fertilizer">Liquid Fertilizer</option>
                            <option value="Acidic Fertilizer">Acidic Fertilizer</option>
                            <option value="Organic Fertilizer">Organic Fertilizer</option>
                        </select>

                        <div
                            class="bg-biege rounded-xl font-IrishGrover w-full h-12 py-2 px-4 flex items-center justify-between skew-x-12">
                            <span class="mr-4">Sunlight</span>
                            <div class="flex space-x-2">
                                <Sun v-for="(item, index) in 5" :key="index + 1" @click="colors(index + 1)"
                                    :index="index + 1" :activeIndex="activeIndexs" :value="index + 1" />
                            </div>
                        </div>

                        <select required v-model="addPlant.humidity"
                            class="bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12 cursor-none">
                            <option value="" disabled selected hidden>Humidity</option>
                            <option value="Alright">Alright</option>
                            <option value="Coastal">Coastal</option>
                            <option value="We Humid">We Humid</option>
                        </select>

                        <textarea placeholder="Notes" v-model="addPlant.notes"
                            class="bg-biege rounded-xl border-transparent outline-none focus:ring-0 focus:border-transparent font-IrishGrover w-full h-36 py-2 px-4 placeholder-biege-dark skew-x-6 resize-none cursor-none"></textarea>
                    </div>
                </div>

                <PrimaryButton class="mx-auto" :disabled="addPlant.processing">
                    Add Item
                </PrimaryButton>
            </form>
        </div>
    </div>
</template>
