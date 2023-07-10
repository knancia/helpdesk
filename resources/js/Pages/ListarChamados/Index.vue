<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="ListarChamados">
        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-medium text-gray-900">
                                Listar Chamados
                            </h1>
                        </div>

                        <div class="bg-gray-200 bg-opacity-25 p-6">
                            <Table :columns="['O.S.', 'Email', 'Sistema', 'Serviço', 'Titulo', 'Status', 'Data de Criação']" :pagination_data="helpdesk">
                                <tr
                                    v-for="(item, indice) in helpdesk.data"
                                    :key="item.id"
                                    @click="getPhotos(item)"
                                    :class="indice % 2 === 0 ? 'bg-gray-100' : 'bg-white'">
                                    <td class="border px-4 py-2 text-center">{{  item.id }}</td>
                                    <td class="border px-4 py-2 text-center">{{  item.email }}</td>
                                    <td class="border px-4 py-2 text-center">{{  item.sistema }}</td>
                                    <td class="border px-4 py-2 text-center">{{  item.servico }}</td>
                                    <td class="border px-4 py-2 text-center">{{  item.titulo }}</td>
                                    <td class="border px-4 py-2 text-center">{{  item.status }}</td>
                                    <td class="border px-4 py-2 text-center">{{  formatData(item.created_at) }}</td>
                                </tr>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="modal-container">
            <div class="modal-card">
                <div class="modal-card-head">
                    <div>
                        # {{ modalForm.id }} - {{ formatData(modalForm.created_at) }}
                        <br>
                        <i
                            class="fa-solid fa-circle"
                            :class="modalForm.status == 'Aberto'
                            ? 'circle_red' : modalForm.status == 'Em Andamento'
                            ? 'circle_yellow' : modalForm.status == 'Resolvido'
                            ? 'circle_green' : modalForm.status == 'Finalizado'
                            ? 'circle_blue' : 'circle_black'"
                        ></i>
                        {{ modalForm.status }}
                    </div>
                    <div>
                        <button class="modal-close-btn" @click="closeModal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-card-body">
                    <div class="identification bg-ansewer">
                        <div>
                            <strong>E-mail:</strong> <br> {{ modalForm.email }}
                        </div>
                        <div>
                            <strong>Sistema:</strong> <br> {{ modalForm.sistema }}
                        </div>
                        <div>
                            <strong>Serviço:</strong> <br> {{ modalForm.servico }}
                        </div>
                    </div>
                    <div class="titulo bg-ansewer">
                        {{ modalForm.titulo }}
                    </div>
                    <div class="descricao bg-ansewer">
                        <pre class="font-sans">{{ modalForm.descricao }}</pre>
                    </div>

                    <div v-if="photoList.length > 0">
                        <hr>
                        <GalleryPhotos :images="photoList" />
                    </div>

                    <div>
                        <hr>
                        <div class="bg-gray-300 bg-opacity-25 p-6">
                            <div class="flex items-center">
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Resposta para o chamado {{ modalForm.id }}:
                                </h2>
                            </div>

                            <textarea
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                rows="4"
                                placeholder="Digite sua resposta aqui..."
                                id="descricao"
                                v-model="form.descricao"
                            ></textarea>
                        </div>

                        <div class="bg-gray-300 bg-opacity-25 p-6">
                            <div class="flex items-center">
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Alterar Status:
                                </h2>
                            </div>

                            <select
                                v-model="form.status"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm
                                focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                id="status" name="status">
                                <option value="1" selected> Aberto </option>
                                <option value="2"> Em Andamento </option>
                                <option value="3"> Resolvido </option>
                            </select>
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

                        <div class="bg-gray-300 bg-opacity-25 p-6 flex justify-end">
                            <button
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                type="button"
                                @click="store"
                            >
                                <i class="fa-solid fa-check"></i>
                                Enviar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia';
    import { ref } from 'vue';
    import axios from 'axios';
    import moment from 'moment';
    import Table from '../../Components/GlobalComponents/Table.vue';
    import GalleryInput from '../../Components/GlobalComponents/GalleryInput.vue';
    import GalleryPhotos from '../../Components/GlobalComponents/GalleryPhotos.vue';

    export default {
        props: {
            helpdesk: Object,
            photos: Object
        },
        components: {
            Table,
            GalleryPhotos,
            GalleryInput
        },
        data() {
            return {
                form: {},
                showModal: false,
                modalForm: {},
                photoList: Object.assign({}, this.photos ),
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
                formData.append('helpdesk_id', this.modalForm.id);
                formData.append('descricao', this.form.descricao);
                formData.append('status', this.form.status);

                for (let i = 0; i < this.images.length; i++) {
                    formData.append('images[]', this.images[i]);
                    URL.revokeObjectURL(this.images[i]);
                }

                Inertia.post(route('listarChamados.store'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
            },  
            getPhotos(item) {
                this.modalForm = item;
                axios.get(route('listarChamados.chamado', item.id))
                .then(response => {
                    this.photoList = response.data;
                    document.documentElement.style.overflow = 'hidden';
                    document.body.style.overflow = 'hidden';
                    this.showModal = true;
                })
                .catch(error => {
                    console.error(error);
                });
            },
            formatData(date) {
                return moment(date).format('DD/MM/YYYY HH:mm');
            },
            closeModal() {
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
                this.showModal = false;
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
    .circle_red {
        color: #dc3545;
    }

    .circle_yellow {
        color: #ffc107;
    }

    .circle_green {
        color: #198754;
    }

    .circle_blue {
        color: #0d6efd;
    }

    .circle_black {
        color: #000000;
    }
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

        /* ... */

    .modal-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px 15px;
    }

    .modal-card {
        background-color: white;
        height: calc(100vh - 40px);
        border-radius: 7px;
    }

    .modal-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        border-bottom: 1px solid #dfdfdf;
        font-weight: bold;
        font-size: 20px;
    }

    .modal-close-btn {

    }

    .modal-card-body {
        font-size: 18px;
        padding-top: 15px;
        background-color: #f3f4f6;
        height: calc(100vh - 133px);
        overflow-y: auto;
    }

    .identification {
        display: flex;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #dfdfdf;
        margin-bottom: 15px;
        justify-content: space-evenly;
        text-align: center;
    }

    .identification div {
        margin-right: 15px;
        margin-left: 15px;
    }

    .titulo {
        text-align: center;
        font-weight: bold;
        font-size: 22px;
        padding: 0 15px;
        margin-bottom: 15px;
    }

    .descricao {
        padding: 0 15px;
        margin-bottom: 15px;
    }

    .descricao pre {
        text-wrap: wrap;
    }
</style>
