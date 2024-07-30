<script setup>
import { ref, watch } from "vue";
import { router, useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Droplet from "@/Components/Droplet.vue";
import Sun from "@/Components/Sun.vue";

const emits = defineEmits(['close']);
const props = defineProps({
    tempPlant: {
        type: Object,
    }
})

const Plant = ref();
const filepath = ref("pic.png");
const file_upld = ref(false);

function initializeForm() {
    if (props.tempPlant) {
        if (props.tempPlant.plant_path !== 'pic.png') {
            filepath.value = props.tempPlant.plant_path;
            // file_upld.value = true;
        }
        return useForm({
            plant_pic: props.tempPlant.plant_pic,
            plant_path: props.tempPlant.plant_path,
            name: props.tempPlant.name,
            species: props.tempPlant.species,
            water: props.tempPlant.water,
            date: props.tempPlant.date,
            soil: props.tempPlant.soil,
            drainage: props.tempPlant.drainage,
            fertilizer: props.tempPlant.fertilizer,
            sunlight: props.tempPlant.sunlight,
            humidity: props.tempPlant.humidity,
            notes: props.tempPlant.notes,
        });
    }
}

// const activeIndexw = ref(-1);

function colorw(index) {
    // activeIndexw.value = index;
    Plant.value.water = index;
}

// const activeIndexs = ref(-1);
function colors(index) {
    // activeIndexs.value = index;
    Plant.value.sunlight = index;
}

function handleFileChange(event) {
    const input = event.target;
    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        Plant.value.plant_pic = file;

        // Read the file and save the path
        const reader = new FileReader();
        reader.onload = function (e) {
            Plant.value.plant_path = file.name;
        };
        reader.readAsDataURL(file);
        filepath.value = URL.createObjectURL(file);
        file_upld.value = true;
    }
}

watch(() => props.tempPlant, (newVal) => {
    Plant.value = initializeForm();
    file_upld.value = false;
});

function reset() {
    Plant.value = initializeForm();
    file_upld.value = false;
    filepath.value = "pic.png";
}

function Update() {
    const formData = new FormData();
    formData.append("name", Plant.value.name);
    formData.append("species", Plant.value.species);
    formData.append("water", Plant.value.water);
    formData.append("date", Plant.value.date);
    formData.append("soil", Plant.value.soil);
    formData.append("drainage", Plant.value.drainage);
    formData.append("fertilizer", Plant.value.fertilizer);
    formData.append("sunlight", Plant.value.sunlight);
    formData.append("humidity", Plant.value.humidity);
    formData.append("notes", Plant.value.notes);
    formData.append("_method", "PATCH");
    if (Plant.value.plant_pic) {
        formData.append("plant_path", Plant.value.plant_path);
        formData.append("plant_pic", Plant.value.plant_pic);
    }
    router.post(route('plants.update', props.tempPlant.id), formData, {
        onSuccess: () => {
            emits('close');
            reset();
        },
        onError: (errors) => {
            console.error(errors); // Add error logging for debugging
        }
    });
}

</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-5 rounded-3xl w-[800px] h-fit relative mx-auto my-4">
            <header class="flex flex-row items-baseline justify-start">
                <p class="text-black text-3xl  mr-4" @click="$emit('close'), reset()">
                    X
                </p>
                <p class="relative text-2xl font-medium text-grn">
                    Update Your Plant Child
                </p>
            </header>

            <form @submit.prevent="Update" ref="updateForm" enctype="multipart/form-data" v-if="tempPlant">
                <div class="mt-2 flex flex-wrap items-center justify-between w-full text-biege-dark">
                    <div class="flex flex-col items-start w-[49%] space-y-3">
                        <div class="w-full skew-x-6">
                            <input id="edit_upload" type="file" accept="image/*" class="hidden"
                                @change="handleFileChange" />
                            <label for="edit_upload"
                                class="cursor-none skew-x-0 w-full h-20 bg-biege rounded-2xl  flex items-center justify-center relative">
                                <span class="mt-1 text-biege-dark">Upload Image</span>
                                <div class="absolute top-[10%] left-5 w-[15%] bg-upld h-[80%] rounded-2xl">
                                    <img :src="file_upld ? filepath : `/storage/${filepath}`"
                                        class="w-full h-full object-cover rounded-2xl" @error="this.onerror=null" />
                                </div>
                            </label>
                        </div>

                        <div class="w-full">
                            <TextInput type="text" placeholder="Name" class="skew-x-12 w-full" v-model="Plant.name"
                                required autofocus autocomplete="name" />
                            <InputError class="mt-1" :message="Plant.errors.name" />
                        </div>

                        <select required v-model="Plant.species"
                            class="cursor-none bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent skew-x-12 font-IrishGrover w-full h-12 py-2 px-4">
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
                            class="bg-biege rounded-xl  font-IrishGrover w-full h-12 py-2 px-4 flex items-center justify-between skew-x-12">
                            <span class="mr-4">Water Requirement</span>
                            <div class="flex space-x-2">
                                <Droplet v-for="(item, index) in 5" :key="index + 1" @click="colorw(index + 1)"
                                    :index="index + 1" :activeIndex="Plant.water" :value="index + 1" />
                            </div>
                        </div>

                        <label
                            class="cursor-none block relative bg-biege rounded-xl border-transparent  font-IrishGrover w-full h-12 py-2 px-4 skew-x-12">
                            <input type="date" required
                                class="cursor-none absolute bg-transparent outline-none border-transparent focus:ring-0 focus:border-transparent h-12 w-[42%] top-[0.5%]  right-0"
                                v-model="Plant.date" onfocus="this.max=(new Date()).toISOString().split('T')[0]" />
                            <span class="relative top-[15%]">Date Planted</span>
                        </label>

                        <select required v-model="Plant.soil"
                            class="cursor-none bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12">
                            <option value="" disabled selected hidden>Soil Type</option>
                            <option value="Acidic">Acidic</option>
                            <option value="Sandy">Sandy</option>
                            <option value="Loamy">Loamy</option>
                            <option value="Peat-based">Peat-based</option>
                            <option value="Well-drained">Well-drained</option>
                        </select>
                    </div>

                    <div class="flex flex-col items-start w-[49%] space-y-3">
                        <select required v-model="Plant.drainage"
                            class="cursor-none bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12">
                            <option value="" disabled selected hidden>Drainage</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>

                        <select required v-model="Plant.fertilizer"
                            class="cursor-none bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12">
                            <option value="" disabled selected hidden>Fertilizer</option>
                            <option value="10-10-10 Fertilizer">10-10-10 Fertilizer</option>
                            <option value="50$">50$</option>
                            <option value="Liquid Fertilizer">Liquid Fertilizer</option>
                            <option value="Acidic Fertilizer">Acidic Fertilizer</option>
                            <option value="Organic Fertilizer">Organic Fertilizer</option>
                        </select>

                        <div
                            class="bg-biege rounded-xl  font-IrishGrover w-full h-12 py-2 px-4 flex items-center justify-between skew-x-12">
                            <span class="mr-4">Sunlight</span>
                            <div class="flex space-x-2">
                                <Sun v-for="(item, index) in 5" :key="index + 1" @click="colors(index + 1)"
                                    :index="index + 1" :activeIndex="Plant.sunlight" :value="index + 1" />
                            </div>
                        </div>

                        <select required v-model="Plant.humidity"
                            class="cursor-none bg-biege rounded-xl border-transparent outline-none focus:outline-0 focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 skew-x-12">
                            <option value="" disabled selected hidden>Humidity</option>
                            <option value="Alright">Alright</option>
                            <option value="Coastal">Coastal</option>
                            <option value="We Humid">We Humid</option>
                        </select>

                        <textarea placeholder="Notes" v-model="Plant.notes"
                            class="bg-biege rounded-xl border-transparent outline-none focus:ring-0 focus:border-transparent font-IrishGrover w-full h-36 py-2 px-4 placeholder-biege-dark skew-x-6 resize-none cursor-none"></textarea>
                    </div>
                </div>

                <PrimaryButton class="mx-auto" :disabled="Plant.processing">
                    Save Changes
                </PrimaryButton>
            </form>
        </div>
    </div>
</template>
