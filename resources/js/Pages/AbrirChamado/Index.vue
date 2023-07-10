<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <form @submit.prevent="store()">
        <AppLayout title="AbrirChamado">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div>
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h1 class="text-2xl font-medium text-gray-900">
                                    Abrir Chamado
                                </h1>
                            </div>
    
                            <div class="bg-gray-200 bg-opacity-25 p-6">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">
                                        Identificação:
                                    </h2>
                                </div>
    
                                <input
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                    type="text"
                                    id="email"
                                    placeholder="Informe o email"
                                    v-model="form.email"
                                />
                            </div>
    
                            <hr>
                            
                            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6">
                                <div>
                                    <div class="flex items-center">
                                        <h2 class="text-xl font-semibold text-gray-900">
                                            Selecione o sistema:
                                        </h2>
                                    </div>
    
                                    <select 
                                        v-model="form.form_system_id"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                        focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                        id="sistema" name="sistema">
                                        <option v-for="system in systems" :key="system.id" :value="system.id">
                                            {{ system.name }}
                                        </option>
                                    </select>
                                </div>
    
                                <div>
                                    <div class="flex items-center">
                                        <h2 class="text-xl font-semibold text-gray-900">
                                            Selecione o serviço:
                                        </h2>
                                    </div>
    
                                    <select 
                                        v-model="form.form_service_id"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                        focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                        id="sistema" name="sistema">
                                        <option v-for="service in services" :key="service.id" :value="service.id">
                                            {{ service.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="bg-gray-200 bg-opacity-25 p-6">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">
                                        Titulo:
                                    </h2>
                                </div>
    
                                <input
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                    type="text"
                                    id="titulo"
                                    placeholder="Informe o titulo"
                                    v-model="form.titulo"
                                />
                            </div>
    
                            <div class="bg-gray-200 bg-opacity-25 p-6">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">
                                        Descrição:
                                    </h2>
                                </div>
    
                                <textarea 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                    rows="4"
                                    placeholder="Digite seus comentários aqui..."
                                    id="descricao"
                                    v-model="form.descricao"
                                ></textarea>
                            </div>

                            <div class="bg-gray-200 bg-opacity-25 p-6">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">
                                        Imagens:
                                    </h2>
                                </div>

                                <input
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                    type="file"
                                    id="imagens"
                                    accept="image/*"
                                    multiple
                                    ref="imagensInput"
                                    @change="imagesUpload($event)"
                                />
                            </div>

                            <div v-if="images.length > 0">
                                <hr>
                                <GalleryInput :selectedImages="selectedImages" @remove-image="removeImage" />
                            </div>
    
                            <div class="bg-gray-200 bg-opacity-25 p-6 flex justify-end">
                                <button
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                    type="submit"
                                >
                                    <i class="fa-solid fa-check"></i>
                                    Enviar
                                </button>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    </form>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia';
    import GalleryInput from '../../Components/GlobalComponents/GalleryInput.vue';

    export default {
        props: { 
            services: Array,
            systems: Array
        },
        components: {
            GalleryInput
        },
        data() {
            return {
                form: Object.assign({}),
                images: []
            }
        },
        watch: {
            
        },
        mounted() {
            
        },
        methods: {
            store() {
                const formData = new FormData();
                formData.append('email', this.form.email);
                formData.append('form_system_id', this.form.form_system_id);
                formData.append('form_service_id', this.form.form_service_id);
                formData.append('titulo', this.form.titulo);
                formData.append('descricao', this.form.descricao);

                for (let i = 0; i < this.images.length; i++) {
                    formData.append('images[]', this.images[i]);
                    URL.revokeObjectURL(this.images[i]);
                }

                Inertia.post(route('abrirChamado.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
            },
            imagesUpload($event) {
                const files = $event.target.files;
                for (let i = 0; i < files.length; i++) {
                    this.images.push(files[i]);
                }
            },
            removeImage(index) {
                this.images.splice(index, 1);
            }
        },
        computed: {
            selectedImages() {
                return this.images.map((image) => ({
                    name: image.name,
                    size: image.size,
                    url: URL.createObjectURL(image),
                }));
            },
        },
    }
</script>

<style scoped>
    .thumbnail {
        max-width: 150px;
        max-height: 150px;
        margin-top: 10px;
    }

    .lt200 {
        max-width: 200px;
    }

    .container_mini_image {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-flow: wrap;
        margin-top: 10px;
    }

    .cont_desc_img {
        display: flex;
        flex-direction: column;
    }

    .mini_image {
        width: 220px;
        height: 275px;
        background-color: #f8f9fa;
        margin: 10px;
        border: 1px solid #d1d5db;
        padding: 10px;
        border-radius: 7px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;

    }

    .delete_image_btn {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #e51515;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>