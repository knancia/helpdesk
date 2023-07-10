<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <form @submit.prevent="search()">
        <AppLayout title="AcompanharChamado">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div>
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h1 class="text-2xl font-medium text-gray-900">
                                    Acompanhar Chamado
                                </h1>
                            </div>

                            <div class="bg-gray-200 bg-opacity-25 p-6">
                                <div class="flex items-center">
                                    <h2 class="text-xl font-semibold text-gray-900">
                                        Codigo do Chamado:
                                    </h2>
                                </div>

                                <input
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-royalblue-500 focus:border-royalblue-500 sm:text-sm"
                                    type="text"
                                    id="cod_chamado"
                                    placeholder="Informe o codigo do chamado"
                                    v-model="form.id"
                                />
                            </div>

                            <div class="bg-gray-200 bg-opacity-25 p-6 flex justify-end">
                                <button
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                    type="submit"
                                >
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Pesquisar
                                </button>
                            </div>
                            <hr>
                            <div class="w-full bg-gray-100">
                                <div v-for="item in helpdesk" :key="item.id">
                                    <div class="p-6">
                                        <div class="cont_flex">
                                            <div class="container_info">
                                                <hr>
                                                <div class="item">
                                                    <strong>O.S.:</strong> {{ item.id }}
                                                </div>
                                                <hr>
                                                <div class="item">
                                                    <strong>Status do Serviço:</strong> <br> 
                                                    <i class="fa-solid fa-circle"
                                                    :class="item.status_name == 'Aberto' ? 'circle_red' : item.status_name == 'Em Andamento' ? 'circle_yellow' : item.status_name == 'Resolvido' ? 'circle_green' : item.status_name == 'Finalizado' ? 'circle_blue' : 'circle_black'"
                                                    ></i> {{ item.status_name }}
                                                </div>
                                                <hr>
                                                <div class="item">
                                                    <strong>Criado em:</strong> <br> {{ formatData(item.created_at) }}
                                                </div>
                                                <hr>
                                                <div class="item">
                                                    <strong>E-mail:</strong> <br> {{ item.user_email }}
                                                </div>
                                                <hr>
                                                <div class="item">
                                                    <strong>Sistema:</strong> <br> {{ item.system_name }}
                                                </div>
                                                <hr>
                                                <div class="item">
                                                    <strong>Serviço:</strong> <br> {{ item.services_name }}
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="container_desc">
                                                <div class="item_titulo">
                                                    {{ item.titulo }}
                                                </div>
                                                <br>
                                                <div class="item_descricao">
                                                    <pre class="font-sans">{{ item.descricao }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="images">
                                <hr>
                                <GalleryPhotos :images="images" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    </form>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia';
    import moment from 'moment';
    import GalleryPhotos from '../../Components/GlobalComponents/GalleryPhotos.vue';

    export default {
        props: {
            helpdesk: Object,
            images: Object
        },
        components: {
            GalleryPhotos
        },
        data() {
            return {
                form: {}
            }
        },
        methods: {
            search() {
                Inertia.get(route('acompanharChamado', {helpdesk: this.form.id}))
            },
            formatData(date) {
                return moment(date).format('DD/MM/YYYY HH:mm');
            },
        }
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
    .form-container {
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 8px;
        margin-top: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cont_flex {
        display: flex;
        flex-direction: column;
    }
    
    .container_info {
        text-align: center;
        width: 100%;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    @media (min-width: 700px) {
        .cont_flex {
            display: flex;
            flex-direction: row;
        }

        .container_info {
            text-align: left;
            width: 300px;
            border-right: 1px solid #e5e7eb;
            padding-right: 15px;
            margin-right: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    }

    .item {
        margin: 10px 0;
        overflow-wrap: break-word;
    }

    .item_titulo {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
    }

    .container_desc {
        width: 100%;
    }

    .item_descricao pre {
        text-wrap: balance;
        text-align: justify;
    }
</style>