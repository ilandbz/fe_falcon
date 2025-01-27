<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
    <div class="py-12">
        <div class="w-fluid">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Tabla para mostrar pacientes -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">PERIODO</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">CCODIJE.</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicamento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PREADJ</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PREOPE</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CODIGO_SIGA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="medicamento in $page.props.medicamentos" :key="medicamento.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.CPERIODO }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.CCODUE }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.med_Nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.PREADJ }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.PREOPE }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ medicamento.CODIGO_SIGA }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>

</template>