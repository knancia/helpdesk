<template>
    <form @submit.prevent="store()">
        <AppLayout title="Home">           
            <div class="flex justify-center items-center horizontal_center fd_column">
                <div v-if="message" class="alert_pos_form" :class="message.icon == 'check' ? 'bg_green' : 'bg_red' ">
                    <div class="alert_message">
                        <pre class="font-sans text_wrap">{{ message.text }}</pre>
                    </div>
                    <div v-if="message.icon == 'check'" class="alert_icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div v-else class="alert_icon">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <div class="flex_wrap cont_btn_card">
                    <a :href="route('abrirChamado')" class="btn_card">
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900">
                            <i class="fa-solid fa-square-plus"></i>
                            &nbsp;
                            ABRIR NOVO CHAMADO
                        </h5>
                    </a>
                    
                    <a :href="route('acompanharChamado')" class="btn_card">
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            &nbsp;
                            ACOMPANHAR CHAMADO
                        </h5>
                    </a>
                </div>
            </div>
        </AppLayout>
    </form>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia';
    import AppLayout from '@/Layouts/AppLayout.vue';

    export default {
        components: {AppLayout},
        props: { },
        data() {
            return {
                form: Object.assign({}),
                message: this.$page.props.message
            }
        },
        watch: {
            
        },
        mounted() {
            
        },
        methods: {

        }
    }
</script>
