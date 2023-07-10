<template>
    <!-- Container para tabela responsiva -->
    <div class="table-responsive rounded">
        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="table-component table-auto w-full" ref="table">
                <thead>
                    <tr>
                        <th class="px-4 py-2" v-for="(col, i) in columns" :key="i">{{ col }}</th>
                    </tr>
                </thead>
                <tbody>
                    <slot class="border px-4 py-2" />
                </tbody>
            </table>
        </div>

        <hr>

        <div v-if="emptyTable" class="w-100 text-center my-4">
            <h6>Nenhum registro encontrado</h6>
        </div>

        <div class="p-1 flex w-full items-end justify-end text-right mt-8">
            <!-- Paginação -->
            <div v-if="pagination_data && pagination_data.data.length" style="text-align: right;">
                <strong >
                    Mostrando {{ pagination_data.from ?? 0 }} até {{ pagination_data.to ?? 0 }} de {{ pagination_data.total ?? 0 }}
                    registros.
                </strong>
                <ul class="pagination mb-0 mt-2 flex items-center justify-between">
                    <li v-for="(link, i) in pagination_data.links" :key="i" :class="getLinkCSSClass(link)">
                        <a class="page-link" :class="getLinkCSSClass(link)" :href="link.url" v-html="link.label"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'Table',
        props: { columns: Array, pagination_data: Object, excel_route: String },
        components: { Link },
        data() {
            return {
                emptyTable: true
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.emptyTable = this.$refs.table.rows.length <= 1;
            });
            this.scrollPosition = window.scrollY;
            window.scrollTo(0, this.scrollPosition);
        },
        updated() {
            this.$nextTick(() => {
                this.emptyTable = this.$refs.table.rows.length <= 1;
            });
            window.scrollTo(0, this.scrollPosition);
        },
        methods: {
            getLinkCSSClass(link) {
                let css = '';
                if (link.active) {
                    css = 'active';
                }

                if (isNaN(link.label) && link.url === null) {
                    css += 'disabled';
                }

                return css;
            }
        }
    }
</script>


<style>
    .table-component tbody tr:hover {
        cursor: pointer;
        background: linear-gradient(0deg, #084298 0% 8%, transparent 5% 94%, #084298 90% 100%)
    }
</style>

<style scoped>

    .pagination li a {
        display: block;
        margin: 0px 2px;
        box-sizing: content-box;
        text-align: center;
        width: 38px;
        background-color: #c9c9c9;
        border-radius: 3px;
    }

    .pagination li:first-child a {
        width: 94px;
    }

    .pagination li:last-child a {
        width: 68px;
    }

    .pagination li.disabled a, .pagination li.active a {
        background-color: #084298;
        color: white
    }

    .pagination li:hover a {
        font-weight: bold;
        overflow: hidden;
        cursor: pointer;
    }
</style>